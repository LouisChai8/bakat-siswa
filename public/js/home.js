// ── Toggle reply / repost / like ──
function toggleAction(btn, type) {
    const isActive = btn.dataset.active === 'true';
    const countEl  = btn.querySelector('.count-label');
    let count      = parseInt(btn.dataset.count);

    if (isActive) {
        count--;
        btn.dataset.active = 'false';
        btn.classList.remove('active');

        if (type === 'like') {
            btn.querySelector('svg').setAttribute('fill', 'none');
            btn.querySelector('svg').setAttribute('stroke', 'currentColor');
        }

    } else {
        count++;
        btn.dataset.active = 'true';
        btn.classList.add('active');

        if (type === 'like') {
            btn.querySelector('svg').setAttribute('fill', '#ef4444');
            btn.querySelector('svg').setAttribute('stroke', '#ef4444');

            const heart = btn.querySelector('.heart-icon');
            heart.classList.remove('heart-burst');
            void heart.offsetWidth;
            heart.classList.add('heart-burst');
        }
    }

    btn.dataset.count = count;
    countEl.textContent = formatCount(count);

    countEl.classList.remove('num-pop');
    void countEl.offsetWidth;
    countEl.classList.add('num-pop');
}

// ── Delete ──
let pendingDeleteBtn = null;

function askDelete(btn) {
    pendingDeleteBtn = btn;
    document.getElementById('deleteModal').classList.add('show');
}

function cancelDelete() {
    document.getElementById('deleteModal').classList.remove('show');
    pendingDeleteBtn = null;
}

function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('show');
    if (!pendingDeleteBtn) return;

    const card = pendingDeleteBtn.closest('.post-card');
    card.style.transition = 'opacity 0.28s ease, transform 0.28s ease, max-height 0.38s ease 0.22s, padding 0.38s ease 0.22s';
    card.style.opacity = '0';
    card.style.transform = 'translateX(28px)';
    const h = card.offsetHeight;
    setTimeout(() => {
        card.style.maxHeight = h + 'px';
        requestAnimationFrame(() => {
            card.style.maxHeight = '0';
            card.style.padding = '0';
            card.style.overflow = 'hidden';
            card.style.borderWidth = '0';
        });
        setTimeout(() => card.remove(), 420);
    }, 260);

    pendingDeleteBtn = null;
}

// backdrop click
document.getElementById('deleteModal').addEventListener('click', e => {
    if (e.target === document.getElementById('deleteModal')) cancelDelete();
});

// ── Format large numbers ──
function formatCount(n) {
    if (n >= 1000000) return (n / 1000000).toFixed(1).replace(/\.0$/, '') + 'M';
    if (n >= 1000)    return (n / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    return n;
}

// ── Scroll reveal ──
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('visible');
            observer.unobserve(e.target);
        }
    });
}, { threshold: 0.08 });
reveals.forEach(el => observer.observe(el));

// ── Staggered post entry on load ──
document.querySelectorAll('.post-card').forEach((el, i) => {
    el.style.animationDelay = (0.18 + i * 0.1) + 's';
});

// ── Clean up animation classes ──
document.addEventListener('animationend', e => {
    if (e.target.classList.contains('heart-wrap')) e.target.classList.remove('heart-burst');
    if (e.target.classList.contains('count-label')) e.target.classList.remove('num-pop');
}, true);

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
    3: [
        { name: 'Abun',     handle: '@laragooners', text: 'Pakai camera apa ni', likes: 62 },
        { name: 'Dello',    handle: '@laragooners', text: 'Enak kayaknya!',       likes: 55 },
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

    const newComment = { name: 'Achai', handle: '@laragooners', text, likes: 0 };
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