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
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C8.13 2 5 5.13 5 9C5 11.38 6.19 13.47 8 14.74V17C8 17.55 8.45 18 9 18H15C15.55 18 16 17.55 16 17V14.74C17.81 13.47 19 11.38 19 9C19 5.13 15.87 2 12 2ZM11 21C11 21.55 11.45 22 12 22C12.55 22 13 21.55 13 21H11Z" fill="black"/>
                    <circle cx="12" cy="9" r="2" fill="white"/>
                </svg>
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