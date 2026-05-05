<?php
session_start();

// Default user data (in real app, fetch from DB)
$user = [
    "name" => "Achai Ganteng",
    "username" => "laragooners",
    "bio" => "Orang paling ganteng",
    "profile_pic" => "/assets/img/Foto Basket Profile.png",
    "header_img" => "/assets/img/nba.png",
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In real app: validate, sanitize, save to DB
    $user['name'] = htmlspecialchars($_POST['name'] ?? $user['name']);
    $user['username'] = htmlspecialchars($_POST['username'] ?? $user['username']);
    $user['bio'] = htmlspecialchars($_POST['bio'] ?? $user['bio']);

    // Handle file uploads (profile pic & header)
    // ... your upload logic here

    // Redirect back to profile after save
    header("Location: /profile");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile – <?php echo $user['name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            background: #f5f5f5;
            font-family: 'DM Sans', sans-serif;
            color: #0f0f0f;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

        /* Header image overlay */
        .header-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
            cursor: pointer;
            border-radius: 0;
        }
        .header-wrapper:hover .header-overlay { opacity: 1; }

        /* Avatar overlay */
        .avatar-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
            cursor: pointer;
        }
        .avatar-wrapper:hover .avatar-overlay { opacity: 1; }

        /* Floating label input */
        .field-group { position: relative; margin-bottom: 0; }

        .field-input {
            width: 100%;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            padding: 22px 14px 8px 14px;
            font-size: 15px;
            font-family: 'DM Sans', sans-serif;
            color: #0f0f0f;
            background: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            resize: none;
        }
        .field-input:focus {
            border-color: #1d9bf0;
            box-shadow: 0 0 0 3px rgba(29,155,240,0.12);
        }

        .field-label {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #9ca3af;
            pointer-events: none;
            transition: all 0.18s ease;
            font-family: 'DM Sans', sans-serif;
        }
        textarea + .field-label,
        .field-input:focus ~ .field-label,
        .field-input:not(:placeholder-shown) ~ .field-label {
            top: 10px;
            transform: translateY(0);
            font-size: 11px;
            color: #1d9bf0;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        /* For textarea label always float */
        .field-group.textarea-group .field-label {
            top: 10px;
            transform: translateY(0);
            font-size: 11px;
            color: #9ca3af;
            font-weight: 600;
            letter-spacing: 0.04em;
            transition: color 0.18s;
        }
        .field-group.textarea-group textarea:focus ~ .field-label {
            color: #1d9bf0;
        }

        .char-count {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: #9ca3af;
        }
        .char-count.warn { color: #f59e0b; }
        .char-count.danger { color: #ef4444; }

        /* Save button */
        .btn-save {
            background: #0f0f0f;
            color: #fff;
            border: none;
            border-radius: 9999px;
            padding: 10px 26px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background 0.18s, transform 0.12s;
        }
        .btn-save:hover { background: #1d9bf0; transform: translateY(-1px); }
        .btn-save:active { transform: translateY(0); }

        /* Cancel button */
        .btn-cancel {
            background: transparent;
            color: #0f0f0f;
            border: 1.5px solid #d1d5db;
            border-radius: 9999px;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: border-color 0.18s, background 0.18s;
        }
        .btn-cancel:hover { border-color: #9ca3af; background: #f5f5f5; }

        /* Section divider */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 12px;
        }

        /* Username prefix */
        .username-prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 15px;
            font-family: 'DM Sans', sans-serif;
            pointer-events: none;
            padding-top: 10px;
        }
        .username-input { padding-left: 13px !important; }

        /* Fade in animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up {
            animation: fadeUp 0.4s ease both;
        }
        .fade-up:nth-child(1) { animation-delay: 0.05s; }
        .fade-up:nth-child(2) { animation-delay: 0.10s; }
        .fade-up:nth-child(3) { animation-delay: 0.15s; }
        .fade-up:nth-child(4) { animation-delay: 0.20s; }

        /* Toast */
        #toast {
            position: fixed;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: #0f0f0f;
            color: #fff;
            padding: 12px 24px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            z-index: 9999;
            transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), opacity 0.3s;
            opacity: 0;
            pointer-events: none;
            white-space: nowrap;
        }
        #toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body>

<!-- Toast -->
<div id="toast">✓ Perubahan disimpan</div>

<div class="max-w-xl mx-auto border-x border-gray-200 min-h-screen bg-white">

    <!-- Top Bar -->
    <div class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 h-14 flex items-center px-4 gap-4">
        <a href="/profile" class="p-2 rounded-full hover:bg-gray-100 transition text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
            </svg>
        </a>
        <div class="flex-1">
            <h1 class="text-[15px] font-bold leading-tight">Edit Profile</h1>
            <p class="text-[11px] text-gray-400 font-medium"><?php echo $user['name']; ?></p>
        </div>
        <button class="btn-save" id="saveBtn" onclick="handleSave(event)">Save</button>
    </div>

    <!-- Form -->
    <form method="POST" enctype="multipart/form-data" id="editForm">

        <!-- Header Image -->
        <div class="relative header-wrapper" style="height:160px; background:#1d4ed8; overflow:hidden;">
            <img id="headerPreview" src="<?php echo $user['header_img']; ?>" alt="Header" class="w-full h-full object-cover" onerror="this.style.display='none'">
            <div class="header-overlay" onclick="document.getElementById('headerInput').click()">
                <div class="flex flex-col items-center gap-1 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/>
                    </svg>
                    <span class="text-xs font-semibold">Ganti Header</span>
                </div>
            </div>
            <input type="file" id="headerInput" name="header_img" accept="image/*" class="hidden" onchange="previewImage(this,'headerPreview')">
        </div>

        <!-- Avatar -->
        <div class="px-4 -mt-12 mb-2 relative z-10 flex justify-between items-end">
            <div class="relative avatar-wrapper" style="width:88px;height:88px;" onclick="document.getElementById('avatarInput').click()">
                <div class="p-1 bg-white rounded-full shadow">
                    <img id="avatarPreview" src="<?php echo $user['profile_pic']; ?>" alt="Avatar"
                        class="w-20 h-20 rounded-full border-2 border-gray-200 object-cover bg-gray-200"
                        onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&background=1d4ed8&color=fff&size=80'">
                </div>
                <div class="avatar-overlay" style="inset:4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/>
                    </svg>
                </div>
                <input type="file" id="avatarInput" name="profile_pic" accept="image/*" class="hidden" onchange="previewImage(this,'avatarPreview')">
            </div>
            <span class="text-[11px] text-gray-400 pb-1 font-medium">Click Image to Change</span>
        </div>

        <!-- Form Fields -->
        <div class="px-4 py-2 flex flex-col gap-4 pb-16">

            <!-- Name -->
            <div class="field-group fade-up">
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="field-input"
                    placeholder=" "
                    maxlength="50"
                    value="<?php echo htmlspecialchars($user['name']); ?>"
                    oninput="updateCount(this,'nameCount',50)"
                >
                <label class="field-label" for="name">Name</label>
                <div class="flex justify-end mt-1">
                    <span class="char-count" id="nameCount"><?php echo strlen($user['name']); ?>/50</span>
                </div>
            </div>

            <!-- Username -->
            <div class="field-group fade-up" style="position:relative;">
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="field-input username-input"
                    placeholder=" "
                    maxlength="15"
                    value="<?php echo htmlspecialchars($user['username']); ?>"
                    oninput="updateCount(this,'usernameCount',15); validateUsername(this)"
                    style="padding-left: 28px;"
                >
                <span class="username-prefix" id="atSign"></span>
                <label class="field-label" for="username" style="">Username</label>
                <div class="flex justify-between mt-1">
                    <span class="text-[11px] text-gray-400" id="usernameHint">Only Letters, Numbers, and Underscores</span>
                    <span class="char-count" id="usernameCount"><?php echo strlen($user['username']); ?>/15</span>
                </div>
            </div>

            <!-- Bio -->
            <div class="field-group textarea-group fade-up" style="position:relative;">
                <textarea
                    id="bio"
                    name="bio"
                    class="field-input"
                    rows="3"
                    maxlength="160"
                    placeholder="Ceritakan sedikit tentang dirimu..."
                    oninput="updateCount(this,'bioCount',160)"
                    style="padding-top: 26px;"
                ><?php echo htmlspecialchars($user['bio']); ?></textarea>
                <label class="field-label" for="bio">Bio</label>
                <div class="flex justify-end mt-1">
                    <span class="char-count" id="bioCount"><?php echo strlen($user['bio']); ?>/160</span>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-100 pt-4 mt-1 fade-up">
                <p class="section-title">Account</p>
                <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between border border-gray-100">
                    <div>
                        <p class="text-[13px] font-semibold text-gray-700">Change Password</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">Update your account password</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                    </svg>
                </div>
            </div>

            <!-- Bottom actions -->
            <div class="flex gap-3 mt-2 fade-up">
                <a href="/profile" class="btn-cancel flex-1 text-center">Cancel</a>
                <button type="submit" class="btn-save flex-1" onclick="handleSave(event)">Save Changes</button>
            </div>

        </div>
    </form>
</div>

<script>
    // Live character counter
    function updateCount(input, counterId, max) {
        const len = input.value.length;
        const el = document.getElementById(counterId);
        el.textContent = len + '/' + max;
        el.classList.remove('warn', 'danger');
        if (len >= max) el.classList.add('danger');
        else if (len >= max * 0.85) el.classList.add('warn');
    }

    // Username validation
    function validateUsername(input) {
        const hint = document.getElementById('usernameHint');
        const valid = /^[a-zA-Z0-9_]*$/.test(input.value);
        if (!valid) {
            input.value = input.value.replace(/[^a-zA-Z0-9_]/g, '');
        }
        hint.textContent = valid ? 'Only Letters, Numbers, and Underscores' : '⚠ Invalid characters removed';
        hint.style.color = valid ? '#9ca3af' : '#f59e0b';
    }

    // Image preview
    function previewImage(input, previewId) {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById(previewId);
            img.src = e.target.result;
            img.style.display = '';
        };
        reader.readAsDataURL(file);
    }

    // Save handler with toast
    function handleSave(e) {
        e.preventDefault();
        const name = document.getElementById('name').value.trim();
        if (!name) {
            alert('Name cannot be empty.');
            return;
        }
        // Show toast
        const toast = document.getElementById('toast');
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
            // In real app: submit the form
            document.getElementById('editForm').submit();
        }, 1500);
    }

    // Initialize counts on load
    document.addEventListener('DOMContentLoaded', () => {
        updateCount(document.getElementById('name'), 'nameCount', 50);
        updateCount(document.getElementById('username'), 'usernameCount', 15);
        updateCount(document.getElementById('bio'), 'bioCount', 160);
    });
</script>

</body>
</html>