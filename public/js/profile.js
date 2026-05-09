// ── Toggle action (repost / like) ──
function toggleAction(btn, type, postId) {
    const isActive = btn.dataset.active === 'true';
    const countEl  = btn.querySelector('.count-label');
    let count      = parseInt(btn.dataset.count);

    if (isActive) {
        count--;
        btn.dataset.active = 'false';
        btn.classList.remove('active');
        if (type === 'like') {
            btn.querySelector('svg').setAttribute('fill', 'none');
        }
    } else {
        count++;
        btn.dataset.active = 'true';
        btn.classList.add('active');
        if (type === 'like') {
            btn.querySelector('svg').setAttribute('fill', '#ef4444');
            btn.querySelector('svg').setAttribute('stroke', '#ef4444');
            const heartIcon = btn.querySelector('.heart-icon');
            heartIcon.classList.remove('heart-burst');
            void heartIcon.offsetWidth;
            heartIcon.classList.add('heart-burst');
        }
    }

    btn.dataset.count = count;
    countEl.textContent = formatCount(count);
    countEl.classList.remove('num-pop');
    void countEl.offsetWidth;
    countEl.classList.add('num-pop');
}

// ── Delete post modal ──
let pendingDeleteBtn = null;
let pendingDeleteId  = null;

function askDelete(btn, postId) {
    pendingDeleteBtn = btn;
    pendingDeleteId  = postId;
    document.getElementById('deleteModal').classList.add('show');
}
function cancelDelete() {
    document.getElementById('deleteModal').classList.remove('show');
    pendingDeleteBtn = null;
    pendingDeleteId  = null;
}
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('show');
    if (!pendingDeleteBtn) return;
    const postCard = pendingDeleteBtn.closest('.post-card');
    postCard.style.transition = 'opacity 0.3s ease, transform 0.3s ease, max-height 0.4s ease 0.2s, padding 0.4s ease 0.2s, margin 0.4s ease 0.2s';
    postCard.style.opacity = '0';
    postCard.style.transform = 'translateX(30px)';
    setTimeout(() => {
        postCard.style.maxHeight = postCard.offsetHeight + 'px';
        requestAnimationFrame(() => {
            postCard.style.maxHeight = '0';
            postCard.style.padding = '0';
            postCard.style.margin = '0';
            postCard.style.overflow = 'hidden';
            postCard.style.borderWidth = '0';
        });
        setTimeout(() => postCard.remove(), 500);
    }, 280);
    pendingDeleteBtn = null;
    pendingDeleteId  = null;
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) cancelDelete();
});

// ── Format count ──
function formatCount(n) {
    if (n >= 1000000) return (n / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
    if (n >= 1000)    return (n / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    return n;
}

// ── Scroll reveal ──
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); }
    });
}, { threshold: 0.1 });
reveals.forEach(el => observer.observe(el));
document.querySelectorAll('.heart-icon').forEach(el => {
    el.addEventListener('animationend', () => el.classList.remove('heart-burst'));
});
document.querySelectorAll('.count-label').forEach(el => {
    el.addEventListener('animationend', () => el.classList.remove('num-pop'));
});

// ═══════════════════════════════════════════════════
//  COMMENT MODAL — reads & writes to the database
// ═══════════════════════════════════════════════════

const CURRENT_USER_ID = 1; // TODO: swap with session user_id once auth is ready

let activePostId = null;

// ── Open modal: fetch ALL comments for this post from DB ──
async function openCommentModal(postId) {
    activePostId = postId;
    document.getElementById('commentModal').classList.add('show');
    document.body.style.overflow = 'hidden';

    const list = document.getElementById('commentList');
    list.innerHTML = '<p style="text-align:center;color:#9ca3af;font-size:13px;padding:32px 0;">Loading...</p>';

    try {
        const res      = await fetch(`/comments?post_id=${postId}`);
        const json     = await res.json();
        const comments = json.data || [];

        renderComments(comments);

        // Sync the reply button count with the real DB total
        setReplyCount(postId, comments.length);
    } catch {
        list.innerHTML = '<p style="text-align:center;color:#ef4444;font-size:13px;padding:32px 0;">Failed to load. Try again.</p>';
    }

    setTimeout(() => document.getElementById('commentInput').focus(), 300);
}

// ── Close modal ──
function closeCommentModal() {
    document.getElementById('commentModal').classList.remove('show');
    document.body.style.overflow = '';
    document.getElementById('commentInput').value = '';
    document.getElementById('sendBtn').classList.remove('has-text');
}

// ── Render all comment rows ──
function renderComments(comments) {
    const list = document.getElementById('commentList');
    list.innerHTML = comments.length
        ? comments.map(c => buildCommentRow(c)).join('')
        : '<p style="text-align:center;color:#9ca3af;font-size:13px;padding:32px 0;">No comments yet. Be the first!</p>';
}

// ── Build one comment row HTML ──
function buildCommentRow(c) {
    const avatar = c.profile_pic
        ? `<img src="${c.profile_pic}" alt="${c.name}">`
        : `<img src="/assets/img/Foto Basket Profile.png" alt="${c.name}">`;

    return `<div class="comment-row" data-id="${c.id}">
        ${avatar}
        <div class="comment-meta">
            <span class="cm-name">${c.name}</span>
            <span class="cm-handle">@${c.username}</span>
            <p class="cm-text">${c.content}</p>
        </div>
        <button class="cm-delete-btn" onclick="deleteComment(${c.id}, this)" title="Delete comment">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor" width="14" height="14">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
            </svg>
        </button>
    </div>`;
}

// ── Delete a comment → DELETE /comments/{id} → removed from DB ──
async function deleteComment(commentId, btn) {
    const row = btn.closest('.comment-row');

    // Animate out first, then call API
    row.classList.add('removing');

    setTimeout(async () => {
        try {
            const res  = await fetch(`/comments/${commentId}`, {
                method:  'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body:    JSON.stringify({ user_id: CURRENT_USER_ID })
            });
            const json = await res.json();

            if (json.success) {
                row.remove();
                bumpReplyCount(activePostId, -1);

                // Show empty state if no comments left
                const list = document.getElementById('commentList');
                if (!list.querySelector('.comment-row')) {
                    list.innerHTML = '<p style="text-align:center;color:#9ca3af;font-size:13px;padding:32px 0;">No comments yet. Be the first!</p>';
                }
            } else {
                row.classList.remove('removing');
            }
        } catch {
            row.classList.remove('removing');
        }
    }, 220);
}

// ── Submit new comment → POST /comments → saved to DB ──
async function submitComment() {
    const input   = document.getElementById('commentInput');
    const content = input.value.trim();
    if (!content || !activePostId) return;

    const sendBtn = document.getElementById('sendBtn');
    sendBtn.style.opacity       = '0.4';
    sendBtn.style.pointerEvents = 'none';

    try {
        const res  = await fetch('/comments', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({
                post_id: activePostId,
                user_id: CURRENT_USER_ID,
                content
            })
        });
        const json = await res.json();

        if (json.success) {
            const list = document.getElementById('commentList');

            // Remove "no comments" placeholder if present
            const placeholder = list.querySelector('p');
            if (placeholder) placeholder.remove();

            // Append the new comment with animation
            const div = document.createElement('div');
            div.innerHTML = buildCommentRow(json.data);
            const row = div.firstElementChild;
            row.classList.add('new-comment');
            list.appendChild(row);
            list.scrollTop = list.scrollHeight;

            // Clear input
            input.value = '';
            sendBtn.classList.remove('has-text');

            // ✅ +1 on the reply/comment button of this post card
            bumpReplyCount(activePostId, +1);
        } else {
            alert('Could not post comment. Please try again.');
        }
    } catch {
        alert('Network error. Please try again.');
    } finally {
        sendBtn.style.opacity       = '1';
        sendBtn.style.pointerEvents = '';
    }
}

// ── Set reply count to exact number (syncs with DB total on open) ──
function setReplyCount(postId, total) {
    const card = document.querySelector(`[data-post-id="${postId}"]`);
    if (!card) return;
    const replyBtn = card.querySelector('.action-btn.reply');
    if (!replyBtn) return;
    replyBtn.dataset.count = total;
    replyBtn.querySelector('.count-label').textContent = formatCount(total);
}

// ── Bump reply count +1 or -1 with pop animation ──
function bumpReplyCount(postId, delta) {
    const card = document.querySelector(`[data-post-id="${postId}"]`);
    if (!card) return;
    const replyBtn = card.querySelector('.action-btn.reply');
    if (!replyBtn) return;
    const countEl  = replyBtn.querySelector('.count-label');
    const newCount = Math.max(0, parseInt(replyBtn.dataset.count || 0) + delta);
    replyBtn.dataset.count   = newCount;
    countEl.textContent      = formatCount(newCount);
    countEl.classList.remove('num-pop');
    void countEl.offsetWidth;
    countEl.classList.add('num-pop');
}

// ── Input handlers ──
function onCommentInput(input) {
    document.getElementById('sendBtn').classList.toggle('has-text', input.value.trim().length > 0);
}
function onCommentKey(e) {
    if (e.key === 'Enter') submitComment();
}

// ── Backdrop / Escape close ──
document.getElementById('commentModal').addEventListener('click', function(e) {
    if (e.target === this) closeCommentModal();
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeCommentModal();
});