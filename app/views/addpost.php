<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post - Bakat Siswa</title>
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

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }

        /* ── Page load animations ── */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .anim-nav     { animation: fadeDown 0.38s ease both; }
        .anim-form    { animation: fadeUp 0.38s ease both 0.1s; }

        /* ── Nav link underline slide ── */
        .nav-link { position: relative; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 2px;
            background: #000;
            transform: scaleX(0);
            transition: transform 0.2s ease;
        }
        .nav-link.active::after { transform: scaleX(1); }
        .nav-link:not(.active):hover::after { transform: scaleX(1); opacity: 0.3; }

        /* ── Textarea ── */
        .post-textarea {
            resize: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .post-textarea:focus {
            outline: none;
            border-color: #000;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.06);
        }
        .post-textarea::placeholder { color: #9ca3af; }

        /* ── Char counter ── */
        .char-counter { transition: color 0.2s ease; }
        .char-counter.warn  { color: #f59e0b; }
        .char-counter.limit { color: #ef4444; }

        /* ── Image preview ── */
        .preview-wrap {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #efefef;
            background: #f3f4f6;
        }
        .preview-wrap img {
            width: 100%;
            max-height: 320px;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }
        .preview-wrap:hover img { transform: scale(1.02); }
        .preview-remove {
            position: absolute;
            top: 8px; right: 8px;
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(0,0,0,0.55);
            color: #fff;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s, transform 0.12s;
        }
        .preview-remove:hover  { background: rgba(0,0,0,0.75); }
        .preview-remove:active { transform: scale(0.88); }

        /* ── Upload zone ── */
        .upload-zone {
            border: 2px dashed #e5e7eb;
            border-radius: 16px;
            transition: border-color 0.2s ease, background 0.2s ease;
            cursor: pointer;
        }
        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #000;
            background: #f9fafb;
        }

        /* ── Tag chips ── */
        .tag-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #f3f4f6;
            border-radius: 99px;
            padding: 3px 10px 3px 10px;
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            transition: background 0.15s;
        }
        .tag-chip button {
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            padding: 0;
            line-height: 1;
            font-size: 14px;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }
        .tag-chip button:hover { color: #ef4444; }

        /* ── Submit button ── */
        .btn-submit {
            transition: background 0.15s, transform 0.12s, box-shadow 0.15s, opacity 0.15s;
        }
        .btn-submit:hover:not(:disabled) {
            background: #1a1a1a;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(0,0,0,0.18);
        }
        .btn-submit:active:not(:disabled) { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.45; cursor: not-allowed; }

        /* ── Back button ── */
        .btn-back {
            transition: background 0.15s, transform 0.12s;
        }
        .btn-back:hover  { background: #f3f4f6; }
        .btn-back:active { transform: scale(0.93); }

        /* ── Success toast ── */
        #toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: #111;
            color: #fff;
            padding: 12px 24px;
            border-radius: 99px;
            font-size: 13px;
            font-weight: 600;
            z-index: 999;
            transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), opacity 0.3s ease;
            opacity: 0;
            white-space: nowrap;
        }
        #toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* ── Toolbar icon buttons ── */
        .toolbar-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            border-radius: 50%;
            border: none;
            background: none;
            color: #6b7280;
            cursor: pointer;
            transition: background 0.15s, color 0.15s, transform 0.12s;
        }
        .toolbar-btn:hover  { background: #f3f4f6; color: #111; }
        .toolbar-btn:active { transform: scale(0.88); }
    </style>
</head>

<body class="bg-white">

    <!-- Success toast -->
    <div id="toast">✓ Post berhasil dibuat!</div>

    <div class="max-w-xl mx-auto border-x border-gray min-h-screen relative bg-white">

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
                    class="nav-link font-extrabold text-[11px] uppercase tracking-wider text-gray-400 hover:text-black transition h-full flex items-center">My Post</a>
            </div>
        </nav>

        <!-- Page header -->
        <div class="anim-form flex items-center gap-3 px-4 py-4 border-b border-gray">
            <button onclick="goBack()" class="btn-back w-8 h-8 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            <h1 class="font-extrabold text-[16px]">New Post</h1>
        </div>

        <!-- Form -->
        <div class="anim-form p-4 flex flex-col gap-5">

            <!-- Author row -->
            <div class="flex items-center gap-3">
                <img src="/assets/img/Foto Basket Profile.png"
                    class="w-11 h-11 rounded-full border border-gray object-cover shadow-sm">
                <div>
                    <p class="font-extrabold text-[14px]">Achai Ganteng</p>
                    <p class="text-gray-400 text-xs">@laragooners</p>
                </div>
            </div>

            <!-- Content textarea -->
            <div>
                <textarea id="postContent" rows="5" maxlength="280"
                    placeholder="What's happening?"
                    oninput="onContentInput(this)"
                    class="post-textarea w-full border border-gray rounded-2xl px-4 py-3 text-[15px] font-medium bg-white"></textarea>
                <div class="flex justify-end mt-1">
                    <span id="charCount" class="char-counter text-xs text-gray-400 font-semibold">0 / 280</span>
                </div>
            </div>

            <!-- Image upload -->
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Photo</p>

                <!-- Preview (hidden until image chosen) -->
                <div id="previewWrap" class="preview-wrap hidden mb-3">
                    <img id="previewImg" src="" alt="preview">
                    <button class="preview-remove" onclick="removeImage()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Upload zone -->
                <div id="uploadZone" class="upload-zone p-6 flex flex-col items-center gap-2 text-center"
                     onclick="document.getElementById('fileInput').click()"
                     ondragover="onDragOver(event)"
                     ondragleave="onDragLeave(event)"
                     ondrop="onDrop(event)">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-7 h-7 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <p class="text-sm font-semibold text-gray-500">Click or drag & drop a photo</p>
                    <p class="text-xs text-gray-400">JPG, PNG, WEBP — max 10 MB</p>
                </div>
                <input type="file" id="fileInput" accept="image/*" class="hidden" onchange="onFileChange(event)">
            </div>

            <!-- Tags -->
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Tags</p>
                <div class="flex flex-wrap gap-2 mb-2" id="tagList"></div>
                <div class="flex gap-2">
                    <input type="text" id="tagInput" placeholder="Add a tag..."
                        maxlength="24"
                        onkeydown="onTagKey(event)"
                        class="flex-1 bg-[#f3f3f3] border-none rounded-full px-4 py-2 text-sm font-medium focus:outline-none focus:ring-1 focus:ring-black">
                    <button onclick="addTag()"
                        class="bg-black text-white text-xs font-bold px-4 py-2 rounded-full hover:bg-gray-800 transition">
                        Add
                    </button>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray"></div>

            <!-- Toolbar -->
            <div class="flex items-center gap-1">
                <button class="toolbar-btn" title="Bold" onclick="insertFormat('**','**')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path fill-rule="evenodd" d="M6 4.75A.75.75 0 0 1 6.75 4h6.5a4.75 4.75 0 0 1 3.256 8.242A4.75 4.75 0 0 1 13.25 20H6.75a.75.75 0 0 1-.75-.75V4.75ZM8.25 9.5V5.5h5a2.25 2.25 0 0 1 0 4.5h-5Zm0 2.5v4h5a2.25 2.25 0 0 0 0-4.5h-5Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button class="toolbar-btn" title="Italic" onclick="insertFormat('_','_')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path d="M15.5 5H13l-4 14h2.5L15.5 5Z" />
                        <path d="M8 5H6.5v1.5H8V5ZM16 17.5h-1.5V19H16v-1.5Z" />
                    </svg>
                </button>
                <button class="toolbar-btn" title="Emoji" onclick="toggleEmojiPicker()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                    </svg>
                </button>

                <!-- Emoji picker -->
                <div id="emojiPicker" class="hidden absolute mt-2 z-10 bg-white border border-gray rounded-2xl shadow-lg p-3 flex flex-wrap gap-1 w-52" style="top:auto">
                    <?php
                    $emojis = ['😀','😂','🥹','😍','🤩','🔥','💪','🏀','⚽','🎉','❤️','👏','🙌','✨','🎯','🚀','💡','😎','🤙','👌'];
                    foreach ($emojis as $e) {
                        echo "<button onclick=\"insertEmoji('$e')\" class=\"text-xl hover:scale-125 transition-transform p-1\">$e</button>";
                    }
                    ?>
                </div>
            </div>

            <!-- Submit -->
            <button id="submitBtn" onclick="submitPost()" disabled
                class="btn-submit w-full bg-black text-white font-extrabold text-sm py-3 rounded-full uppercase tracking-wider">
                Post
            </button>

        </div>
    </div>

    <script src="/js/addpost.js"></script>

</body>
</html>