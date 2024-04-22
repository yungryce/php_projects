<?php
// Data structure for project titles and file paths
$projects = [
    'Simple Shell' => 'blog/simple_shell.php',
    'PHP Authentication System' => 'blog/auth.php',
    'AirBnB Clone' => 'blog/airbnb.php',
    'Easy Pay Payment Platform' => 'blog/easyPay.php',
    // Add more projects as needed
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
    <title>My blog</title>
</head>

<body class="bg-custom-gradient my-12">

    <?php include ('menu.php'); ?>

    <div class="container mx-auto my-8 w-5/6">
        <?php
        foreach ($projects as $title => $filePath) {
            $content = file_get_contents($filePath);
            preg_match('/<p[^>]*>(.*?)<\/p>/', $content, $matches);
            $firstParagraph = $matches[1];

            $postDate = date('F j, Y');
        ?>
            <div class="lg:max-w-5xl xl:max-w-3xl bg-white p-4 mb-8 rounded-md shadow-md">
                <h2 class="text-2xl font-bold mb-2"><?= $title ?></h2>
                <p class="text-gray-600">Published on <span class="font-semibold"><?= $postDate ?></span></p>
                <p class="text-gray-700 leading-7 line-clamp-3 md:line-clamp-5"><?= $firstParagraph ?></p>
                <a href="<?= $filePath ?>" class="text-blue-500 hover:underline block mt-2">Read more...</a>
            </div>
        <?php
        }
        ?>
    </div>

    <script src="assets/js/menu.js"></script>

</body>

</html>
