<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$error = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #949ca4; }
        .custom-rounded { border-radius: 60px; }
        .input-focus:focus-within { border-color: #000; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl flex flex-col md:flex-row custom-rounded overflow-hidden shadow-2xl">

        <!-- Left: Login form -->
        <div class="flex-1 p-8 md:p-16 flex flex-col justify-center items-center">

            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-black mb-2">Welcome Back</h1>
            <p class="text-gray-400 font-medium mb-6">Please login to your account</p>

            <?php if ($error): ?>
            <div class="w-full max-w-sm bg-red-50 border border-red-200 text-red-600 text-sm font-semibold rounded-2xl px-4 py-3 mb-4 text-center">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form action="/login" method="POST" class="w-full max-w-sm space-y-6">

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-black ml-1">Username</label>
                    <div class="relative flex items-center border-2 border-[#d4c8c4] rounded-2xl p-4 input-focus transition-all">
                        <svg class="w-6 h-6 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" name="username" placeholder="Username"
                            value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                            class="w-full bg-transparent outline-none text-black placeholder-gray-400 font-medium" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-black ml-1">Password</label>
                    <div class="relative flex items-center border-2 border-[#d4c8c4] rounded-2xl p-4 input-focus transition-all">
                        <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <input type="password" name="password" id="loginPassword" placeholder="********"
                            class="w-full bg-transparent outline-none text-black placeholder-gray-400 font-medium" required>
                        <button type="button" onclick="togglePassword('loginPassword', this)" class="text-gray-400 ml-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-black text-white font-bold py-4 rounded-2xl hover:bg-gray-800 transition-all text-lg shadow-lg">
                    Login
                </button>

            </form>
        </div>

        <!-- Right: Sign up prompt -->
        <div class="flex-1 bg-black p-12 md:p-16 flex flex-col justify-center items-center text-center">
            <h2 class="text-white text-3xl md:text-4xl font-bold mb-4">Hello there!</h2>
            <p class="text-gray-300 text-lg mb-12">Don't have an account yet?</p>
            <a href="/register"
                class="w-full max-w-[280px] border-2 border-white text-white font-bold py-4 rounded-2xl hover:bg-white hover:text-black transition-all text-lg text-center block">
                Sign Up
            </a>
        </div>

    </div>

    <script>
    function togglePassword(inputId, btn) {
        const input   = document.getElementById(inputId);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.innerHTML = isHidden
            ? `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
               </svg>`
            : `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
               </svg>`;
    }
    </script>

</body>
</html>