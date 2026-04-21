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
    ["content" => "Orang paling ganteng", "time" => "5h", "replies" => 65, "reposts" => 111, "likes" => 708],
    ["content" => "Orang paling ganteng", "time" => "5h", "replies" => 65, "reposts" => 111, "likes" => 708],
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

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }
    </style>
</head>

<body class="font-sans">

    <div class="max-w-xl mx-auto border-x border-gray min-h-screen relative">

        <div class="sticky top-0 z-50 bg-white/80 backdrop-blur-md text-black h-14 w-full border-b border-gray">
            <div class="relative max-w-xl mx-auto flex items-center h-full px-4">

                <div class="absolute left-4">
                    <div class="flex items-center gap-2 cursor-pointer hover:text-blue-600 transition-all text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                        </svg>
                    </div>
                </div>

                <div class="flex-1 flex justify-center text-[10px] uppercase tracking-widest font-bold">
                    <div class="flex gap-8 items-center">
                        
                        <a href="/home" class="flex-1 flex items-center justify-center font-bold text-[11px] uppercase tracking-wider border-r border-gray text-gray-400 hover:text-black transition cursor-pointer">
                    Home
                </a>
                        <div class="cursor-pointer border-b-2 border-black pb-1">Postingan saya</div>
                    </div>
                </div>

                <div class="absolute right-4">

                </div>
            </div>
        </div>

        <div class="relative">
            <div class="h-48 bg-blue-700 overflow-hidden">
                <img src="/assets/img/nba.png" class="w-full h-full">
            </div>

            <div class="absolute -bottom-12 left-4 z-10">
                <div class="p-1 bg-white rounded-full shadow-sm">
                    <img src="/assets/img/Foto Basket Profile.png"
                        class="w-24 h-24 rounded-full border-2 border-black object-cover bg-gray-200">
                </div>
            </div>

            <div class="flex justify-end p-4">
                <button
                    class="border border-black px-4 py-1 rounded-full font-bold text-xs hover:bg-gray-100 transition">Edit
                    Profile</button>
            </div>
        </div>

        <div class="px-4 mt-12">
            <h2 class="text-xl font-bold leading-tight"><?php echo $user['name']; ?></h2>
            <p class="text-gray-500 text-sm"><?php echo $user['username']; ?></p>

            <p class="mt-3 text-sm font-medium"><?php echo $user['bio']; ?></p>

            <div class="flex gap-4 mt-3 text-sm">
                <span><strong class="text-black"><?php echo $user['following']; ?></strong> <span
                        class="text-gray-500">Following</span></span>
                <span><strong class="text-black"><?php echo $user['followers']; ?></strong> <span
                        class="text-gray-500">Followers</span></span>
            </div>
        </div>

        <div class="flex border-b border-gray mt-4">
            <div class="flex-1 text-center   py-3 font-bold border-b-4 border-blue-500 text-sm">Posts</div>
        </div>

        <?php foreach ($posts as $post): ?>
            <div class="p-4 border-b border-gray hover:bg-gray-50 transition cursor-pointer">
                <div class="flex gap-3">
                    <img src="/assets/img/Foto Basket Profile.png" class="w-10 h-10 rounded-full border border-gray">

                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-1">
                                <span class="font-bold text-sm"><?php echo $user['name']; ?></span>
                                <span class="text-gray-500 text-xs"><?php echo $user['username']; ?> ·
                                    <?php echo $post['time']; ?></span>
                            </div>
                            <span class="text-gray-400 text-xs">•••</span>
                        </div>

                        <p class="mt-1 text-sm"><?php echo $post['content']; ?></p>
                    
                        <div
                            class="mt-3 aspect-video bg-gray-100 border border-gray rounded-2xl overflow-hidden flex items-center justify-center">
                            <span class="text-gray-300 text-xs italic">Post image placeholder</span>
                        </div>

                        <div class="flex justify-between mt-4 text-gray-500 text-xs max-w-sm">
                            <div class="flex items-center gap-2 hover:text-blue-500">
                                <span>💬</span> <?php echo $post['replies']; ?>
                            </div>
                            <div class="flex items-center gap-2 hover:text-green-500">
                                <span>🔁</span> <?php echo $post['reposts']; ?>
                            </div>
                            <div class="flex items-center gap-2 hover:text-red-500">
                                <span>❤️</span> <?php echo $post['likes']; ?>
                            </div>
                            <div class="hover:text-black">
                                <span>🗑️</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

</body>

</html>