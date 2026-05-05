<?php
$user = [
    "name" => "Achai Ganteng",
    "username" => "@laragooners",
    "bio" => "Orang paling ganteng",
    "following" => 4,
    "followers" => 4,
    "profile_pic" => "",
    "header_img" => "",
];

$posts = [
    ["id" => 1, "content" => "Orang paling ganteng", "time" => "5h", "replies" => 65, "reposts" => 111, "likes" => 708],
    ["id" => 2, "content" => "Orang paling ganteng", "time" => "5h", "replies" => 65, "reposts" => 111, "likes" => 708],
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?php echo $user['name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #ffffff;
            color: #000000;
        }

        .border-gray {
            border-color: #e5e7eb;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

        /* ── Page load animations ── */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.85); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-18px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .anim-navbar  { animation: fadeDown 0.4s ease both; }
        .anim-header  { animation: scaleIn 0.5s ease both 0.05s; }
        .anim-avatar  { animation: scaleIn 0.45s cubic-bezier(.34,1.56,.64,1) both 0.2s; }
        .anim-editbtn { animation: fadeUp 0.4s ease both 0.25s; }
        .anim-info    { animation: fadeUp 0.4s ease both 0.3s; }
        .anim-tabs    { animation: fadeUp 0.35s ease both 0.35s; }
        .anim-post    { animation: fadeUp 0.4s ease both; }
        .anim-post:nth-child(1) { animation-delay: 0.40s; }
        .anim-post:nth-child(2) { animation-delay: 0.52s; }
        .anim-post:nth-child(3) { animation-delay: 0.64s; }
        .anim-post:nth-child(4) { animation-delay: 0.76s; }

        /* ── Header image parallax-ish hover ── */
        .header-img-wrap { overflow: hidden; }
        .header-img-wrap img {
            transition: transform 0.6s ease;
        }
        .header-img-wrap:hover img { transform: scale(1.04); }

        /* ── Avatar pulse ring on hover ── */
        .avatar-ring {
            transition: box-shadow 0.25s ease, transform 0.25s ease;
        }
        .avatar-ring:hover {
            box-shadow: 0 0 0 4px rgba(29,155,240,0.25);
            transform: scale(1.04);
        }

        /* ── Edit Profile button ── */
        .btn-edit {
            transition: background 0.18s, color 0.18s, transform 0.15s, box-shadow 0.18s;
        }
        .btn-edit:hover {
            background: #000;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.12);
        }
        .btn-edit:active { transform: translateY(0); }

        /* ── Stat hover ── */
        .stat-item {
            transition: color 0.15s;
            cursor: pointer;
        }
        .stat-item:hover strong { color: #1d9bf0; }

        /* ── Action buttons ── */
        .action-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 4px 8px;
            border-radius: 9999px;
            cursor: pointer;
            transition: background 0.15s, color 0.15s, transform 0.12s;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
        }
        .action-btn:active { transform: scale(0.9); }

        /* Reply */
        .action-btn.reply { color: #6b7280; }
        .action-btn.reply:hover { background: rgba(29,155,240,0.1); color: #1d9bf0; }
        .action-btn.reply.active { color: #1d9bf0; }

        /* Repost */
        .action-btn.repost { color: #6b7280; }
        .action-btn.repost:hover { background: rgba(34,197,94,0.1); color: #16a34a; }
        .action-btn.repost.active { color: #16a34a; background: rgba(34,197,94,0.1); }

        /* Like */
        .action-btn.like { color: #6b7280; }
        .action-btn.like:hover { background: rgba(239,68,68,0.1); color: #ef4444; }
        .action-btn.like.active { color: #ef4444; background: rgba(239,68,68,0.1); }

        /* Delete */
        .action-btn.delete { color: #6b7280; }
        .action-btn.delete:hover { background: rgba(239,68,68,0.08); color: #ef4444; }
        .action-btn.delete.active { color: #ef4444; }

        /* Number pop animation */
        @keyframes numPop {
            0%   { transform: translateY(0) scale(1); }
            40%  { transform: translateY(-4px) scale(1.15); }
            100% { transform: translateY(0) scale(1); }
        }
        .num-pop { animation: numPop 0.25s ease; }

        /* Heart burst animation */
        @keyframes heartBurst {
            0%   { transform: scale(1); }
            30%  { transform: scale(1.5); }
            60%  { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
        .heart-burst { animation: heartBurst 0.35s ease; }

        /* ── Delete confirm modal ── */
        #deleteModal {
            position: fixed;
            inset: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.45);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.22s ease;
        }
        #deleteModal.show {
            opacity: 1;
            pointer-events: all;
        }
        #deleteModal .modal-box {
            background: #fff;
            border-radius: 16px;
            padding: 28px 24px 20px;
            max-width: 320px;
            width: 90%;
            transform: scale(0.88) translateY(16px);
            transition: transform 0.25s cubic-bezier(.34,1.56,.64,1);
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
        }
        #deleteModal.show .modal-box {
            transform: scale(1) translateY(0);
        }

        /* ── Post card hover ── */
        .post-card {
            transition: background 0.15s;
        }
        .post-card:hover { background: #f9fafb; }

        /* ── Scroll reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="font-sans">

<!-- Delete confirmation modal -->
<div id="deleteModal">
    <div class="modal-box">
        <h3 class="text-[16px] font-bold mb-1">Delete This Post?</h3>
        <p class="text-gray-500 text-sm mb-6">This post will be deleted permanently and cannot be recovered.</p>
        <div class="flex gap-3">
            <button onclick="cancelDelete()" class="flex-1 border border-gray-200 rounded-full py-2 text-sm font-semibold hover:bg-gray-50 transition">Cancel</button>
            <button onclick="confirmDelete()" class="flex-1 bg-red-500 text-white rounded-full py-2 text-sm font-bold hover:bg-red-600 transition">Delete</button>
        </div>
    </div>
</div>

<div class="max-w-xl mx-auto border-x border-gray min-h-screen relative">

    <!-- Navbar -->
    <div class="anim-navbar sticky top-0 z-50 bg-white/80 backdrop-blur-md text-black h-14 w-full border-b border-gray">
        <div class="relative max-w-xl mx-auto flex items-center h-full px-4">
            <div class="absolute left-4">
                <div class="flex items-center gap-2 cursor-pointer hover:text-blue-600 transition-all text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                    </svg>
                </div>
            </div>
            <div class="flex-1 flex justify-center text-[10px] uppercase tracking-widest font-bold">
                <div class="flex gap-8 items-center">
                    <a href="/home" class="flex-1 flex items-center justify-center font-bold text-[11px] uppercase tracking-wider border-r border-gray text-gray-400 hover:text-black transition cursor-pointer">Home</a>
                    <div class="cursor-pointer border-b-2 border-black pb-1">My Post</div>
                </div>
            </div>
            <div class="absolute right-4"></div>
        </div>
    </div>

    <!-- Header image -->
    <div class="anim-header relative">
        <div class="h-48 bg-blue-700 overflow-hidden header-img-wrap">
            <img src="/assets/img/nba.png" class="w-full h-full object-cover">
        </div>

        <!-- Avatar -->
        <div class="anim-avatar absolute -bottom-12 left-4 z-10">
            <div class="p-1 bg-white rounded-full shadow-sm avatar-ring">
                <img src="/assets/img/Foto Basket Profile.png"
                    class="w-24 h-24 rounded-full border-2 border-black object-cover bg-gray-200">
            </div>
        </div>

        <!-- Edit button -->
        <div class="anim-editbtn flex justify-end p-4">
            <a href="/editprofile"
                class="btn-edit border border-black px-4 py-1.5 rounded-full font-bold text-xs inline-block">
                Edit Profile
            </a>
        </div>
    </div>

    <!-- User info -->
    <div class="anim-info px-4 mt-12">
        <h2 class="text-xl font-bold leading-tight"><?php echo $user['name']; ?></h2>
        <p class="text-gray-500 text-sm"><?php echo $user['username']; ?></p>
        <p class="mt-3 text-sm font-medium"><?php echo $user['bio']; ?></p>
        <div class="flex gap-4 mt-3 text-sm">
            <span class="stat-item"><strong class="text-black"><?php echo $user['following']; ?></strong> <span class="text-gray-500">Following</span></span>
            <span class="stat-item"><strong class="text-black"><?php echo $user['followers']; ?></strong> <span class="text-gray-500">Followers</span></span>
        </div>
    </div>

    <!-- Tabs -->
    <div class="anim-tabs flex border-b border-gray mt-4">
        <div class="flex-1 text-center py-3 font-bold border-b-4 border-blue-500 text-sm">Posts</div>
    </div>

    <!-- Posts -->
    <?php foreach ($posts as $i => $post): ?>
    <div class="anim-post post-card p-4 border-b border-gray cursor-pointer reveal"
         data-post-id="<?php echo $post['id']; ?>">
        <div class="flex gap-3">
            <img src="/assets/img/Foto Basket Profile.png" class="w-10 h-10 rounded-full border border-gray object-cover">
            <div class="flex-1">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-sm"><?php echo $user['name']; ?></span>
                        <span class="text-gray-500 text-xs"><?php echo $user['username']; ?> · <?php echo $post['time']; ?></span>
                    </div>
                    <span class="text-gray-400 text-xs select-none">•••</span>
                </div>

                <p class="mt-1 text-sm"><?php echo $post['content']; ?></p>

                <div class="mt-3 aspect-video bg-gray-100 border border-gray rounded-2xl overflow-hidden flex items-center justify-center">
                    <span class="text-gray-300 text-xs italic">Post image placeholder</span>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-between mt-4 max-w-sm">

                    <!-- Reply -->
                    <button class="action-btn reply"
                        onclick="toggleAction(this, 'reply', <?php echo $post['id']; ?>)"
                        data-count="<?php echo $post['replies']; ?>"
                        data-active="false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                        </svg>
                        <span class="text-xs count-label"><?php echo $post['replies']; ?></span>
                    </button>

                    <!-- Repost -->
                    <button class="action-btn repost"
                        onclick="toggleAction(this, 'repost', <?php echo $post['id']; ?>)"
                        data-count="<?php echo $post['reposts']; ?>"
                        data-active="false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3"/>
                        </svg>
                        <span class="text-xs count-label"><?php echo $post['reposts']; ?></span>
                    </button>

                    <!-- Like -->
                    <button class="action-btn like"
                        onclick="toggleAction(this, 'like', <?php echo $post['id']; ?>)"
                        data-count="<?php echo $post['likes']; ?>"
                        data-active="false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 heart-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                        </svg>
                        <span class="text-xs count-label"><?php echo $post['likes']; ?></span>
                    </button>

                    <!-- Delete -->
                    <button class="action-btn delete"
                        onclick="askDelete(this, <?php echo $post['id']; ?>)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

</div>

<script>
// ── Toggle action (reply / repost / like) ──
function toggleAction(btn, type, postId) {
    const isActive = btn.dataset.active === 'true';
    const countEl  = btn.querySelector('.count-label');
    let count      = parseInt(btn.dataset.count);

    if (isActive) {
        // Cancel → -1
        count--;
        btn.dataset.active = 'false';
        btn.classList.remove('active');
        // Unfill heart
        if (type === 'like') {
            const path = btn.querySelector('path');
            btn.querySelector('svg').setAttribute('fill', 'none');
        }
    } else {
        // Activate → +1
        count++;
        btn.dataset.active = 'true';
        btn.classList.add('active');
        // Fill heart
        if (type === 'like') {
            btn.querySelector('svg').setAttribute('fill', '#ef4444');
            btn.querySelector('svg').setAttribute('stroke', '#ef4444');
            const heartIcon = btn.querySelector('.heart-icon');
            heartIcon.classList.remove('heart-burst');
            void heartIcon.offsetWidth; // reflow
            heartIcon.classList.add('heart-burst');
        }
    }

    btn.dataset.count = count;
    countEl.textContent = formatCount(count);

    // Number pop animation
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

    // Animate post out
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

// Close modal on backdrop click
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
</script>

</body>
</html>