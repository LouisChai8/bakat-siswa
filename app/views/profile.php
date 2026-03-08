<?php
// Data Mockup (bisa diganti dengan data dari Database nantinya)
$user = [
    "name" => "Achai Ganteng",
    "username" => "@laragooners",
    "bio" => "Orang paling ganteng",
    "following" => 4,
    "followers" => 4,
    "profile_pic" => "https://via.placeholder.com/100", // Ganti dengan path foto kamu
    "header_img" => "https://via.placeholder.com/800x200/0047AB/FFFFFF?text=NBA+Logo", // Biru khas NBA
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
        body { background-color: #000; color: white; }
        .border-gray { border-color: #333; }
    </style>
</head>
<body class="font-sans">

    <div class="max-w-xl mx-auto border-x border-gray min-h-screen">
        
        <div class="flex items-center p-4 sticky top-0 bg-black bg-opacity-80 backdrop-blur-md z-10">
            <h1 class="text-xl font-bold">Postingan saya</h1>
        </div>

        <div class="relative">
            <div class="h-48 bg-blue-700 overflow-hidden">
                <img src="<?php echo $user['header_img']; ?>" class="w-full h-full object-cover">
            </div>
            <div class="absolute -bottom-12 left-4">
                <img src="<?php echo $user['profile_pic']; ?>" class="w-24 h-24 rounded-full border-4 border-black object-cover">
            </div>
            <div class="flex justify-end p-4">
                <button class="border border-gray px-4 py-1 rounded-full font-bold text-sm hover:bg-zinc-900">Edit Profile</button>
            </div>
        </div>

        <div class="px-4 mt-8">
            <h2 class="text-xl font-bold leading-tight"><?php echo $user['name']; ?></h2>
            <p class="text-gray-500"><?php echo $user['username']; ?></p>
            <p class="mt-3"><?php echo $user['bio']; ?></p>
            <p class="text-gray-500 mt-1"><?php echo $user['username']; ?></p>
            
            <div class="flex gap-4 mt-3 text-sm">
                <span><strong class="text-white"><?php echo $user['following']; ?></strong> <span class="text-gray-500">Following</span></span>
                <span><strong class="text-white"><?php echo $user['followers']; ?></strong> <span class="text-gray-500">Followers</span></span>
            </div>
        </div>

        <div class="flex border-b border-gray mt-4">
            <div class="flex-1 text-center py-4 font-bold border-b-4 border-blue-500">Posts</div>
        </div>

        <?php foreach ($posts as $post): ?>
        <div class="p-4 border-b border-gray hover:bg-zinc-950 transition cursor-pointer">
            <div class="flex gap-3">
                <img src="<?php echo $user['profile_pic']; ?>" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                    <div class="flex items-center gap-1">
                        <span class="font-bold"><?php echo $user['name']; ?></span>
                        <span class="text-gray-500 text-sm"><?php echo $user['username']; ?> · <?php echo $post['time']; ?></span>
                    </div>
                    <p class="mt-1"><?php echo $post['content']; ?></p>
                    
                    <div class="mt-3 aspect-video bg-black border border-gray rounded-2xl"></div>

                    <div class="flex justify-between mt-4 text-gray-500 text-sm max-w-md">
                        <span>💬 <?php echo $post['replies']; ?></span>
                        <span>🔁 <?php echo $post['reposts']; ?></span>
                        <span>❤️ <?php echo $post['likes']; ?></span>
                        <span>🗑️</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

</body>
</html>