<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
    <title>chxgbx</title>
    <style>
        /* Custom styles for animation */
        @keyframes fadeInOut {
            0%, 100% {
                opacity: 0;
                transform: translateY(-10px);
            }
            50% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes grow {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        #roles p {
            animation: fadeInOut 5s ease-in-out infinite;
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s, transform 0.8s;
        }

        .revealed {
            opacity: 1;
            transform: translateY(0);
            animation: grow 5s ease-in-out infinite;
        }
    </style>
</head>
<body class="z-0 container mx-auto text-white bg-gradient-to-r from-gray-900 from-10% via-purple-900 via-50% to-gray-900 to-90% mb-12">

    <?php include ('menu.php'); ?>

    <section class="min-h-dvh xl:min-h-screen flex flex-col md:flex-row mb-12">
        <div class="w-full md:w-1/2 flex flex-col items-center bg-red-500 mt-12">
            <img src="assets/images/profile1.jpg" alt="coding" class="h-24 w-24 rounded-full mb-10">
            <div class="text-center space-y-4">
                <p class="text-2xl">Hi, I am</p>
                <h2 class="text-5xl md:text-7xl font-bold no-wrap text-cyan-200">
                    Chigbu Joshua
                </h2>
                <div class="text-5xl space-x-4 text-cyan-400">
                    <a href="https://github.com/yungryce" class=""><i class="fa-brands fa-square-git"></i></a>
                    <a href="https://linkedin.com/in/chigbujoshua"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>
            <div id="roles" class="text-4xl py-10 md:py-16">
                <p>Software Engineer</p>
            </div>
        </div>
        <div class="w-2/3 mx-auto md:w-1/2 flex items-center justify-center">
            <img src="assets/images/bg6.gif" alt="" class="rounded-full">
        </div>
    </section>
    
    <section class="min-h-dvh xl:min-h-screen relative container mx-auto text-white flex items-center justify-center bg-gray-900">
        <div class="absolute inset-0 bg-[url('assets/bg9.jpg')] opacity-10 bg-cover bg-center bg-no-repeat bg-fixed z-0"></div>
        <div class="max-w-screen-sm md:max-w-screen-lg mx-auto text-center space-y-8 my-12 md:mx-4">
            <p class="text-xl md:text-2xl leading-7 reveal text-yellow-100 px-8">
                Welcome to my journey—a narrative woven in code, where each keystroke unfolds a story of conquered challenges and unfurled innovations. Embark on a journey with Linux as my canvas, C programming as rhythmic beats echoing through the digital landscape, and Shell scripting as the dance that brings it all to life. 
            </p>

            <p class="text-xl md:text-2xl leading-7 reveal text-red-100 px-8">
                My exploration in technology surpasses rigid language boundaries. From the foundational syntax of C to the dynamic flow of creativity in Python, and navigating databases' intricacies with SQL, each step, a quest for mastery and understanding.
            </p>

            <p class="text-xl md:text-2xl leading-7 reveal text-orange-100 px-8">
                I also dive into the world of server-side scripting with PHP and Python, crafting web applications that seamlessly marry functionality with user experiences. Server-side scripting becoming a gateway to dynamic and interactive digital experiences that are more than just static pages and JavaScript bringing it all to life.
            </p>

            <p class="text-xl md:text-2xl leading-7 reveal text-teal-100 px-8">
                Join me in this technological adventure where the beauty of code meets the fluidity of languages. C, shell scripts, data structures, SQL, and server-side scripting converge as tools in a constantly evolving environment. This portfolio is a celebration of adaptability and the joy of discovering new linguistic possibilities within the ever-expanding universe of technology.
            </p>
    </section>
    
    <section class="min-h-dvh xl:min-h-screen text-white container mx-auto">
        <h1 class="text-3xl md:text-5xl text-center p-12">Tech Stacks</h1>
        <ul class="list-none text-2xl text-center space-y-8 max-w-96 mx-auto w-4/5 md:w-full">
            <li class="bg-slate-400 rounded-full py-3 reveal">C Language</li>
            <li class="bg-slate-500 rounded-full py-3 reveal">Shell Scripting</li>
            <li class="bg-slate-600 rounded-full py-3 reveal">Python / FLASK / Django</li>
            <li class="bg-slate-700 rounded-full py-3 reveal">PHP / Laravel</li>
            <li class="bg-slate-800 rounded-full py-3 reveal">JavaScript</li>
            <li class="bg-slate-900 rounded-full py-3 reveal">HTML / CSS / TailwindCSS</li>
        </ul>
    </section>


    <script src="assets/js/menu.js"></script>
    <script src="assets/js/index.js"></script>

</body>
</html>
