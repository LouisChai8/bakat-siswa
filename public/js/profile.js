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

// ── Delete modal ──
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

// ── Format count (e.g. 1200 → 1.2K) ──
function formatCount(n) {
    if (n >= 1000000) return (n / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
    if (n >= 1000)    return (n / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    return n;
}

// ── Scroll reveal ──
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            observer.unobserve(e.target);
        }
    });
}, { threshold: 0.1 });
reveals.forEach(el => observer.observe(el));

// ── Remove animation class after heart burst ──
document.querySelectorAll('.heart-icon').forEach(el => {
    el.addEventListener('animationend', () => el.classList.remove('heart-burst'));
});
document.querySelectorAll('.count-label').forEach(el => {
    el.addEventListener('animationend', () => el.classList.remove('num-pop'));
});

// ── Comment modal ──
const commentData = {
    1: [
        { name: 'Abun',     handle: '@laragooners', text: 'Gila bagus banget idenya sangat briliant.', likes: 64 },
        { name: 'Dello',    handle: '@laragooners', text: 'Gila, ini aesthetic banget.',               likes: 43 },
        { name: 'Achai',    handle: '@laragooners', text: 'Ajari aku suhu',                            likes: 26 },
        { name: 'Ryo',      handle: '@laragooners', text: 'Lokasi dimana ini? Keren banget.',          likes: 114 },
        { name: 'Natanael', handle: '@laragooners', text: 'Next main bareng gak',                      likes: 78 },
    ],
    2: [
        { name: 'Rico',     handle: '@laragooners', text: 'Gak Ngajak',  likes: 29 },
        { name: 'Abun',     handle: '@laragooners', text: 'Jago Banget',  likes: 74 },
    ],
};

let activePostId = null;

function openCommentModal(postId) {
    activePostId = postId;
    const list = document.getElementById('commentList');
    const comments = commentData[postId] || [];
    list.innerHTML = comments.length === 0
        ? '<p style="text-align:center;color:#9ca3af;font-size:13px;padding:32px 0;">No comments yet. Be the first!</p>'
        : comments.map((c, i) => buildCommentRow(c, i)).join('');
    document.getElementById('commentModal').classList.add('show');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('commentInput').focus(), 350);
}

function closeCommentModal() {
    document.getElementById('commentModal').classList.remove('show');
    document.body.style.overflow = '';
    document.getElementById('commentInput').value = '';
    document.getElementById('sendBtn').classList.remove('has-text');
}

function buildCommentRow(c, i) {
    return `<div class="comment-row">
        <img src="/assets/img/Foto Basket Profile.png" alt="${c.name}">
        <div class="comment-meta">
            <span class="cm-name">${c.name}</span>
            <span class="cm-handle">${c.handle}</span>
            <p class="cm-text">${c.text}</p>
        </div>
        <div class="comment-like">
            <button onclick="toggleCommentLike(this, ${i})" data-active="false">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.8" stroke="currentColor" width="16" height="16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                </svg>
            </button>
            <span class="like-count">${c.likes}</span>
        </div>
    </div>`;
}

function toggleCommentLike(btn, index) {
    const isActive = btn.dataset.active === 'true';
    const countEl  = btn.closest('.comment-like').querySelector('.like-count');
    let count = parseInt(countEl.textContent);
    if (isActive) {
        count--;
        btn.dataset.active = 'false';
        btn.classList.remove('liked');
        btn.querySelector('svg').setAttribute('fill', 'none');
        btn.querySelector('svg').setAttribute('stroke', 'currentColor');
    } else {
        count++;
        btn.dataset.active = 'true';
        btn.classList.add('liked');
        btn.querySelector('svg').setAttribute('fill', '#ef4444');
        btn.querySelector('svg').setAttribute('stroke', '#ef4444');
    }
    countEl.textContent = count;
    if (activePostId && commentData[activePostId] && commentData[activePostId][index]) {
        commentData[activePostId][index].likes = count;
    }
}

function onCommentInput(input) {
    document.getElementById('sendBtn').classList.toggle('has-text', input.value.trim().length > 0);
}

function onCommentKey(e) {
    if (e.key === 'Enter') submitComment();
}

function submitComment() {
    const input = document.getElementById('commentInput');
    const text  = input.value.trim();
    if (!text || !activePostId) return;

    const newComment = { name: 'Achai Ganteng', handle: '@laragooners', text, likes: 0 };
    if (!commentData[activePostId]) commentData[activePostId] = [];
    commentData[activePostId].push(newComment);

    const list  = document.getElementById('commentList');
    const index = commentData[activePostId].length - 1;
    const div   = document.createElement('div');
    div.innerHTML = buildCommentRow(newComment, index);
    const row = div.firstElementChild;
    row.classList.add('new-comment');
    list.appendChild(row);
    list.scrollTop = list.scrollHeight;

    input.value = '';
    document.getElementById('sendBtn').classList.remove('has-text');

    // update reply counter on the post card
    const postCard = document.querySelector(`[data-post-id="${activePostId}"]`);
    if (postCard) {
        const replyBtn = postCard.querySelector('.action-btn.reply');
        if (replyBtn) {
            const countEl = replyBtn.querySelector('.count-label');
            const c = parseInt(replyBtn.dataset.count || 0) + 1;
            replyBtn.dataset.count = c;
            countEl.textContent = formatCount(c);
            countEl.classList.remove('num-pop');
            void countEl.offsetWidth;
            countEl.classList.add('num-pop');
        }
    }
}

document.getElementById('commentModal').addEventListener('click', function(e) {
    if (e.target === this) closeCommentModal();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeCommentModal();
});