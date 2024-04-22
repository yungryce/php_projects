<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
    <title>Projects</title>
</head>
<body class="bg-gradient-to-r from-gray-900 from-10% via-purple-900 via-50% to-gray-900 to-90% text-white my-12">

    <?php include ('menu.php'); ?>

	<h1 class="text-5xl text-center p-4 mb-12 font-bold">PROJECTS</h1>

    <section class="container mx-auto flex flex-wrap justify-center items-center space-y-8 md:space-y-0">

            <div class="flex flex-col w-full px-4 space-y-4 md:w-1/2 lg:w-1/4 justify-center items-center">
                <h3 class="text-xl font-semibold underline decoration-dotted">Simple shell</h3>
                <a href="/blog/simple_shell.php" class="group">
                    <img src="assets/images/sh-shell.gif" alt="shell" class="rounded-lg h-64 w-64 transition duration-500 transform group-hover:scale-110 group-hover:shadow-md group-hover:shadow-red-900">
                </a>
                <a href="https://github.com/yungryce/simple_shell" class="text-lg hover:underline hover:text-blue-400 font-bold px-2 shadow shadow-md shadow-blue-400">GitHub</a>
            </div>

            <div class="w-full flex flex-col px-4 space-y-4 md:w-1/2 lg:w-1/4 justify-center items-center">
                <h3 class="text-xl font-semibold mb-2 underline decoration-dotted">PHP Authentication System</h3>
                <a href="/blog/auth.php" class="group">
                    <img src="assets/images/auth.jpg" alt="auth" class="rounded-lg h-64 w-64 transition duration-500 transform group-hover:scale-110 group-hover:shadow-md group-hover:shadow-red-900">
                </a>
                <a href="http://github.com/yungryce/php_auth" class="text-lg hover:underline hover:text-blue-400 font-bold px-2 shadow shadow-md shadow-blue-400">GitHub</a>
            </div>

            <div class="w-full flex flex-col px-4 space-y-4 md:w-1/2 lg:w-1/4 justify-center items-center">
                <h3 class="text-xl font-semibold mb-2 underline decoration-dotted">AirBnB Clone</h3>
                <a href="/blog/airbnb.php" class="group">
                    <img src="assets/images/hbnb_clone.gif" alt="AiBnB Clone" class="rounded-lg h-64 w-64 transition duration-500 transform group-hover:scale-110 group-hover:shadow-md group-hover:shadow-red-900">
                </a>
                <a href="https://github.com/yungryce/AirBnB_clone" class="text-lg hover:underline hover:text-blue-400 font-bold px-2 shadow shadow-md shadow-blue-400">GitHub</a>
            </div>

            <div class="w-full flex flex-col px-4 space-y-4 md:w-1/2 lg:w-1/4 justify-center items-center">
                <h3 class="text-xl font-semibold mb-2 underline decoration-dotted">EasyPay Services</h3>
                <a href="/blog/easyPay.php" class="group">
                    <img src="assets/images/php_app.png" alt="easyPay" class="rounded-lg h-64 w-64 transition duration-500 transform group-hover:scale-110 group-hover:shadow-md group-hover:shadow-red-900">
                </a>
                <a href="http://github.com/yungryce/php_app" class="text-lg hover:underline hover:text-blue-400 font-bold px-2 shadow shadow-md shadow-blue-400">GitHub</a>
            </div>

    </section>

    <script src="assets/js/menu.js"></script>

</body>
</html>
