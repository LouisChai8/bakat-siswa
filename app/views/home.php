<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Bakat Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9f9f9;
        }

        .border-gray {
            border-color: #efefef;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }

        /* ── Page load animations ── */
        @keyframes fadeDown {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.94);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .anim-nav {
            animation: fadeDown 0.38s ease both;
        }

        .anim-search {
            animation: fadeUp 0.38s ease both 0.08s;
        }

        .anim-composer {
            animation: fadeUp 0.38s ease both 0.14s;
        }

        /* post stagger */
        .anim-post {
            opacity: 0;
        }

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

        /* ── Post image zoom ── */
        .post-img {
            transition: transform 0.5s ease;
        }

        .post-img:hover {
            transform: scale(1.05);
        }

        /* ── Action buttons ── */
        .action-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 8px;
            border-radius: 9999px;
            cursor: pointer;
            user-select: none;
            -webkit-tap-highlight-color: transparent;
            transition: background 0.15s, color 0.15s, transform 0.12s;
            background: transparent;
            border: none;
            outline: none;
        }

        .action-btn:active {
            transform: scale(0.88);
        }

        .action-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9999px;
            transition: background 0.15s;
            font-size: 15px;
        }

        /* Reply */
        .action-btn.reply {
            color: #6b7280;
        }

        .action-btn.reply:hover {
            color: #1d9bf0;
        }

        .action-btn.reply:hover .action-icon {
            background: rgba(29, 155, 240, 0.1);
        }

        .action-btn.reply.active {
            color: #1d9bf0;
        }

        .action-btn.reply.active .action-icon {
            background: rgba(29, 155, 240, 0.1);
        }

        /* Repost */
        .action-btn.repost {
            color: #6b7280;
        }

        .action-btn.repost:hover {
            color: #16a34a;
        }

        .action-btn.repost:hover .action-icon {
            background: rgba(34, 197, 94, 0.1);
        }

        .action-btn.repost.active {
            color: #16a34a;
        }

        .action-btn.repost.active .action-icon {
            background: rgba(34, 197, 94, 0.1);
        }

        /* Like */
        .action-btn.like {
            color: #6b7280;
        }

        .action-btn.like:hover {
            color: #ef4444;
        }

        .action-btn.like:hover .action-icon {
            background: rgba(239, 68, 68, 0.1);
        }

        .action-btn.like.active {
            color: #ef4444;
        }

        .action-btn.like.active .action-icon {
            background: rgba(239, 68, 68, 0.1);
        }

        /* Delete */
        .action-btn.delete {
            color: #6b7280;
        }

        .action-btn.delete:hover {
            color: #ef4444;
        }

        .action-btn.delete:hover .action-icon {
            background: rgba(239, 68, 68, 0.08);
        }

        /* ── Count animations ── */
        @keyframes numPop {
            0% {
                transform: translateY(0) scale(1);
            }

            40% {
                transform: translateY(-4px) scale(1.2);
            }

            100% {
                transform: translateY(0) scale(1);
            }
        }

        .num-pop {
            animation: numPop 0.22s ease;
        }

        @keyframes heartBurst {
            0% {
                transform: scale(1);
            }

            30% {
                transform: scale(1.6);
            }

            65% {
                transform: scale(0.88);
            }

            100% {
                transform: scale(1);
            }
        }

        .heart-burst {
            animation: heartBurst 0.35s ease;
        }

        /* ── Delete modal ── */
        #deleteModal {
            position: fixed;
            inset: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.42);
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
            border-radius: 18px;
            padding: 28px 24px 20px;
            max-width: 300px;
            width: 90%;
            transform: scale(0.86) translateY(14px);
            transition: transform 0.26s cubic-bezier(.34, 1.56, .64, 1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.16);
        }

        #deleteModal.show .modal-box {
            transform: scale(1) translateY(0);
        }

        /* ── Search input ── */
        .search-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        /* ── Composer avatar ── */
        .composer-avatar {
            transition: transform 0.2s ease;
        }

        .composer-avatar:hover {
            transform: scale(1.08);
        }

        /* ── Add Post button ── */
        .btn-addpost {
            transition: background 0.15s, box-shadow 0.15s, transform 0.12s;
        }

        .btn-addpost:hover {
            background: #f3f4f6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }

        .btn-addpost:active {
            transform: translateY(0);
        }

        /* ── Post card ── */
        .post-card {
            transition: background 0.15s;
        }

        .post-card:hover {
            background: rgba(249, 250, 251, 0.7);
        }

        /* ── Nav link underline slide ── */
        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #000;
            transform: scaleX(0);
            transition: transform 0.2s ease;
        }

        .nav-link.active::after {
            transform: scaleX(1);
        }

        .nav-link:not(.active):hover::after {
            transform: scaleX(1);
            opacity: 0.3;
        }
    </style>
</head>

<body class="bg-white">

    <!-- Delete confirmation modal -->
    <div id="deleteModal">
        <div class="modal-box">
            <h3 class="text-[15px] font-bold mb-1">Hapus postingan?</h3>
            <p class="text-gray-500 text-[13px] mb-5 leading-relaxed">Postingan ini akan dihapus secara permanen dan
                tidak bisa dikembalikan.</p>
            <div class="flex gap-3">
                <button onclick="cancelDelete()"
                    class="flex-1 border border-gray-200 rounded-full py-2 text-[13px] font-semibold hover:bg-gray-50 transition">Batal</button>
                <button onclick="confirmDelete()"
                    class="flex-1 bg-red-500 text-white rounded-full py-2 text-[13px] font-bold hover:bg-red-600 transition">Hapus</button>
            </div>
        </div>
    </div>

    <div class="max-w-xl mx-auto border-x border-gray min-h-screen relative bg-white">

        <!-- Navbar -->
        <nav
            class="anim-nav top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray h-16 flex items-center px-4 relative">
            <div class="absolute left-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
            </div>

            <div class="mx-auto flex h-full items-center gap-8">
                <a href="/home"
                    class="nav-link active font-extrabold text-[11px] uppercase tracking-wider h-full flex items-center">Home</a>
                <a href="/profile"
                    class="nav-link font-extrabold text-[11px] uppercase tracking-wider text-gray-400 hover:text-black transition h-full flex items-center">My
                    Post</a>
            </div>

            <div class="absolute right-4">
                <a href="/login.php"
                    class="bg-black text-white text-[10px] font-bold px-4 py-2 rounded-full uppercase tracking-wider hover:bg-gray-800 transition shadow-sm">
                    Login/Register
                </a>
            </div>
        </nav>

        <!-- Search -->
        <div class="anim-search p-4 border-b border-gray">
            <div class="relative">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" placeholder="What are you looking for, Boss?"
                    class="search-input w-full bg-[#f3f3f3] border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-1 focus:ring-black outline-none font-medium">
            </div>
        </div>

        <!-- Composer -->
        <div class="anim-composer p-4 flex items-center gap-3 border-b border-gray">
            <img src="/assets/img/Foto Basket Profile.png"
                class="composer-avatar w-10 h-10 rounded-full border border-gray object-cover shadow-sm">
            <div class="flex-1 bg-[#f3f3f3] rounded-full px-4 py-2 flex items-center justify-between">
                <span class="text-sm font-bold text-black">What's Happening?</span>
                <button
                    class="btn-addpost bg-white border border-gray rounded-full px-4 py-1 text-[11px] font-bold flex items-center gap-1 shadow-sm">
                    Add Post <span class="text-lg leading-none">+</span>
                </button>
            </div>
        </div>

        <!-- Posts -->
        <div class="divide-y divide-gray" id="postFeed">
            <?php
            $posts = [
                ['id' => 1, 'img' => 'dunk.jpg', 'content' => 'First Time Dunk', 'replies' => 65, 'reposts' => 111, 'likes' => 708],
                ['id' => 2, 'img' => 'anak.jpg', 'content' => 'Main Sama Anak', 'replies' => 65, 'reposts' => 111, 'likes' => 708],
                ['id' => 3, 'img' => 'Makan.png', 'content' => 'Makan Bareng Teman Teman SMA', 'replies' => 65, 'reposts' => 111, 'likes' => 708],
            ];
            foreach ($posts as $i => $post):
                ?>
                <div class="post-card reveal p-4 cursor-pointer" data-post-id="<?php echo $post['id']; ?>">
                    <div class="flex gap-3">
                        <img src="/assets/img/Foto Basket Profile.png"
                            class="w-11 h-11 rounded-full border border-gray object-cover shadow-sm">

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="font-extrabold text-[15px]">Achai</span>
                                    <span class="text-gray-500 text-sm ml-1">@laragooners · 5h</span>
                                    <p class="text-[15px] text-black mt-0.5"><?php echo $post['content']; ?></p>
                                </div>
                                <button
                                    class="text-gray-400 hover:text-black p-1 rounded-full hover:bg-gray-100 transition">•••</button>
                            </div>

                            <div class="mt-3 rounded-2xl overflow-hidden border border-gray bg-gray-100">
                                <img src="/assets/img/<?php echo $post['img']; ?>" class="post-img w-full object-cover">
                            </div>

                            <!-- Action buttons -->
                            <div class="flex justify-between mt-2 max-w-sm">

                                <div class="flex justify-between mt-2 max-w-sm">

                                    <!-- Reply -->
                                    <button class="action-btn reply" onclick="toggleAction(this,'reply')"
                                        data-count="<?php echo $post['replies']; ?>" data-active="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                        </svg>
                                        <span class="text-xs count-label"><?php echo $post['replies']; ?></span>
                                    </button>

                                    <!-- Repost -->
                                    <button class="action-btn repost" onclick="toggleAction(this,'repost')"
                                        data-count="<?php echo $post['reposts']; ?>" data-active="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                                        </svg>
                                        <span class="text-xs count-label"><?php echo $post['reposts']; ?></span>
                                    </button>

                                    <!-- Like -->
                                    <button class="action-btn like" onclick="toggleAction(this,'like')"
                                        data-count="<?php echo $post['likes']; ?>" data-active="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.8" stroke="currentColor" class="w-4 h-4 heart-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                        </svg>
                                        <span class="text-xs count-label"><?php echo $post['likes']; ?></span>
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <script>
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
            if (n >= 1000) return (n / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
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
    </script>

</body>

</html>