<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Bakat Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9f9f9; }
        .border-gray { border-color: #efefef; }
        /* Custom scrollbar agar tetap minimalis */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
    </style>
</head>
<body class="bg-white">

    <div class="max-w-xl mx-auto border-x border-gray min-h-screen relative bg-white">
        
        <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray h-14 flex items-center">
            <div class="w-16 flex justify-center border-r border-gray h-full items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                </svg>
            </div>
            <div class="flex-1 flex h-full">
                <div class="flex-1 flex items-center justify-center font-bold text-[11px] uppercase tracking-wider border-r border-gray cursor-pointer bg-gray-50/50">Home</div>
                <div class="flex-1 flex items-center justify-center font-bold text-[11px] uppercase tracking-wider border-r border-gray text-gray-400 hover:text-black transition cursor-pointer">Postingan saya</div>
            </div>
            <div class="px-4">
                <a href="login.php" class="bg-black text-white text-[10px] font-bold px-3 py-1.5 rounded uppercase tracking-tight hover:bg-gray-800 transition">
                    Login/Register
                </a>
            </div>
        </nav>

        <div class="p-4 border-b border-gray">
            <div class="relative group">
                <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" placeholder="Cari" class="w-full bg-[#f3f3f3] border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-1 focus:ring-black outline-none font-bold text-right pr-6 placeholder:text-black">
            </div>
        </div>

        <div class="p-4 flex items-center gap-3 border-b border-gray">
            <img src="/assets/img/Foto Basket Profile.png" class="w-10 h-10 rounded-full border border-gray object-cover">
            <div class="flex-1 bg-[#f3f3f3] rounded-full px-4 py-2 flex items-center justify-between">
                <span class="text-sm font-bold text-black">What's Happening?</span>
                <button class="bg-white border border-gray rounded-full px-4 py-1 text-[11px] font-bold flex items-center gap-1 shadow-sm hover:bg-gray-50 transition">
                    Add Post <span class="text-lg">+</span>
                </button>
            </div>
        </div>

        <div class="divide-y divide-gray">
            <?php 
            $posts = [
                ['img' => 'basket-1.jpg', 'content' => 'Orang paling ganteng'],
                ['img' => 'basket-2.jpg', 'content' => 'Orang paling ganteng'],
                ['img' => 'running.jpg', 'content' => 'Orang paling ganteng']
            ];
            foreach($posts as $post): 
            ?>
            <div class="p-4 hover:bg-gray-50/50 transition cursor-pointer group">
                <div class="flex gap-3">
                    <img src="/assets/img/Foto Basket Profile.png" class="w-11 h-11 rounded-full border border-gray object-cover">
                    
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-extrabold text-[15px]">Achai</span>
                                <span class="text-gray-500 text-sm ml-1">@laragooners · 5h</span>
                                <p class="text-[15px] text-black mt-0.5"><?php echo $post['content']; ?></p>
                            </div>
                            <button class="text-gray-400 hover:text-black">•••</button>
                        </div>

                        <div class="mt-3 rounded-2xl overflow-hidden border border-gray">
                            <img src="/bakat-siswa/public/assets/img/nba.png" class="w-full aspect-[16/10] object-cover hover:scale-105 transition duration-500">
                        </div>

                        <div class="flex justify-between mt-4 text-gray-500 max-w-sm pr-4">
                            <div class="flex items-center gap-2 group/icon hover:text-blue-500">
                                <div class="p-2 group-hover/icon:bg-blue-50 rounded-full transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                <span class="text-xs font-medium">65</span>
                            </div>
                            <div class="flex items-center gap-2 group/icon hover:text-green-500">
                                <div class="p-2 group-hover/icon:bg-green-50 rounded-full transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                                </div>
                                <span class="text-xs font-medium">111</span>
                            </div>
                            <div class="flex items-center gap-2 group/icon hover:text-red-500">
                                <div class="p-2 group-hover/icon:bg-red-50 rounded-full transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </div>
                                <span class="text-xs font-medium">708</span>
                            </div>
                            <div class="p-2 hover:bg-gray-100 rounded-full transition hover:text-black">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>

</body>
</html>