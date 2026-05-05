<?php
$user = [
    "name" => "Achai Ganteng",
    "username" =>"laragooners",
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
        .anim-nav     { animation: fadeDown 0.4s ease both; }
        .anim-header  { animation: scaleIn 0.5s ease both 0.05s; }

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

        /* ── Comment modal (bottom sheet) ── */
        #commentModal {
            position: fixed;
            inset: 0;
            z-index: 998;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            background: rgba(0,0,0,0);
            pointer-events: none;
            transition: background 0.28s ease;
        }
        #commentModal.show {
            background: rgba(0,0,0,0.45);
            pointer-events: all;
        }
        #commentModal .comment-sheet {
            background: #fff;
            width: 100%;
            max-width: 672px;
            border-radius: 20px 20px 0 0;
            display: flex;
            flex-direction: column;
            max-height: 80vh;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(.32,.72,0,1);
            box-shadow: 0 -4px 32px rgba(0,0,0,0.12);
            overflow: hidden;
        }
        #commentModal.show .comment-sheet {
            transform: translateY(0);
        }
        .sheet-handle {
            width: 36px;
            height: 4px;
            background: #e5e7eb;
            border-radius: 99px;
            margin: 12px auto 8px;
            flex-shrink: 0;
        }
        .sheet-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px 12px;
            border-bottom: 1px solid #efefef;
            flex-shrink: 0;
        }
        .sheet-header h4 {
            font-size: 15px;
            font-weight: 700;
            margin: 0;
        }
        .sheet-close-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.15s;
            color: #374151;
        }
        .sheet-close-btn:hover { background: #e5e7eb; }
        .comment-list {
            flex: 1;
            overflow-y: auto;
            padding: 8px 0;
        }
        .comment-list::-webkit-scrollbar { width: 4px; }
        .comment-list::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 99px; }
        .comment-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 16px;
            transition: background 0.12s;
        }
        .comment-row:hover { background: #f9fafb; }
        .comment-row img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid #efefef;
        }
        .comment-meta { flex: 1; min-width: 0; }
        .comment-meta .cm-name { font-size: 13px; font-weight: 700; color: #111; }
        .comment-meta .cm-handle { font-size: 12px; color: #9ca3af; margin-left: 4px; }
        .comment-meta .cm-text { font-size: 14px; color: #1f2937; margin-top: 2px; line-height: 1.4; word-break: break-word; }
        .comment-like {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            flex-shrink: 0;
        }
        .comment-like button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: #d1d5db;
            transition: color 0.15s, transform 0.12s;
            display: flex;
        }
        .comment-like button:active { transform: scale(0.85); }
        .comment-like button.liked { color: #ef4444; }
        .comment-like button.liked svg { fill: #ef4444; stroke: #ef4444; }
        .comment-like .like-count { font-size: 11px; color: #9ca3af; }
        .comment-composer {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-top: 1px solid #efefef;
            flex-shrink: 0;
            background: #fff;
        }
        .comment-composer img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #efefef;
            flex-shrink: 0;
        }
        .comment-input-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            background: #f3f4f6;
            border-radius: 99px;
            padding: 0 12px;
            height: 38px;
        }
        .comment-input-wrap input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            font-size: 14px;
            color: #111;
            font-family: inherit;
        }
        .comment-input-wrap input::placeholder { color: #9ca3af; }
        .btn-send {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            color: #d1d5db;
            padding: 0;
            transition: color 0.15s, transform 0.12s;
        }
        .btn-send:hover { color: #111; }
        .btn-send:active { transform: scale(0.88); }
        .btn-send.has-text { color: #111; }
        @keyframes commentSlideIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .comment-row.new-comment { animation: commentSlideIn 0.22s ease; }
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

<!-- Comment modal (bottom sheet) -->
<div id="commentModal">
    <div class="comment-sheet">
        <div class="sheet-handle"></div>
        <div class="sheet-header">
            <h4>Comments</h4>
            <button class="sheet-close-btn" onclick="closeCommentModal()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
        <div class="comment-list" id="commentList"></div>
        <div class="comment-composer">
            <img src="/assets/img/Foto Basket Profile.png" alt="me">
            <div class="comment-input-wrap">
                <input type="text" id="commentInput" placeholder="Add your comment..." maxlength="280"
                       oninput="onCommentInput(this)" onkeydown="onCommentKey(event)">
                <button class="btn-send" id="sendBtn" onclick="submitComment()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="max-w-xl mx-auto border-x border-gray min-h-screen relative">

    <!-- Navbar -->
    <nav class="anim-nav sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray h-16 flex items-center px-4 relative">
        <div class="absolute left-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>
        </div>

        <div class="mx-auto flex h-full items-center gap-8">
            <a href="/home"
                class="nav-link font-extrabold text-[11px] uppercase tracking-wider text-gray-400 hover:text-black transition h-full flex items-center">Home</a>
            <a href="/profile"
                class="nav-link active font-extrabold text-[11px] uppercase tracking-wider h-full flex items-center">My Post</a>
        </div>

        <div class="absolute right-4">
            <a href="/login"
                class="bg-black text-white text-[10px] font-bold px-4 py-2 rounded-full uppercase tracking-wider hover:bg-gray-800 transition shadow-sm">
                Login/Register
            </a>
        </div>
    </nav>

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
            <a href="/profile/edit"
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
                    <span class="text-gray-300 text-xs italic"></span>
                </div>

                <!-- Action buttons -->
                <div class="flex justify-between mt-4 max-w-sm">

                    <!-- Reply -->
                    <button class="action-btn reply"
                        onclick="openCommentModal(<?php echo $post['id']; ?>)"
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

<script src="/js/profile.js"></script>

</body>
</html>