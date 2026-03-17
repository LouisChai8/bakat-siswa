<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #949ca4;
        }
        .custom-rounded {
            border-radius: 60px;
        }
        .input-focus:focus-within {
            border-color: #000;
        }
    </style>
</head>
<body class="h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl flex flex-col md:flex-row custom-rounded overflow-hidden shadow-2xl min-h-[550px]">
        
        <div class="flex-1 p-8 md:p-16 flex flex-col justify-center items-center">
    
    <div class="mb-6">
        <div class="flex items-center gap-2 text-black">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-10 h-10">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>
        </div>
    </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-black mb-2">Welcome Back</h1>
            <p class="text-gray-400 font-medium mb-10">Please login to your account</p>

            <form action="#" class="w-full max-w-sm space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-black ml-1">Username</label>
                    <div class="relative flex items-center border-2 border-[#d4c8c4] rounded-2xl p-4 input-focus transition-all">
                        <svg class="w-6 h-6 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" placeholder="Username" class="w-full bg-transparent outline-none text-black placeholder-gray-400 font-medium">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-black ml-1">Password</label>
                    <div class="relative flex items-center border-2 border-[#d4c8c4] rounded-2xl p-4 input-focus transition-all">
                        <svg class="w-6 h-6 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <input type="password" placeholder="********" class="w-full bg-transparent outline-none text-black placeholder-gray-400 font-medium">
                        <button type="button" class="text-gray-400 ml-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-black text-white font-bold py-4 rounded-2xl mt-4 hover:bg-gray-800 transition-all text-lg shadow-lg">
                    Login
                </button>
            </form>
        </div>

        <div class="flex-1 bg-black p-12 md:p-16 flex flex-col justify-center items-center text-center">
            <h2 class="text-white text-3xl md:text-4xl font-bold mb-4">Hello there!</h2>
            <p class="text-gray-300 text-lg mb-12">If you dont have account</p>
            
            <a href="signup.php" class="w-full max-w-[280px] border-2 border-white text-white font-bold py-4 rounded-2xl hover:bg-white hover:text-black transition-all text-lg">
                Sign Up
            </a>
        </div>
        
    </div>

</body>
</html>