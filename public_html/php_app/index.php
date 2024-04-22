<?php
session_start();


if (isset($_SESSION['user_id']) && $_SESSION['login_successful'] === true)
    $_SESSION['message'] = "Hello ". htmlspecialchars($_SESSION["username"]);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
    <title>Tailwind CSS Navbar</title>
</head>

<body class="">
    <?php include ('header.php'); ?>

    <p> <?php include('alerts.php'); ?> </p>

    <main>

        <section class="min-h-screen relative flex text-white bg-gray-800 z-0">
            <div class="absolute inset-0 bg-[url('/assets/images/bg4.jpg')] opacity-20 bg-cover bg-center bg-no-repeat bg-fixed z-0"></div>

            <div class="flex m-12 h-full z-10">
                <div class="flex flex-col space-y-12 text-center">
                    <h1 class="text-8xl font-bold">Quick <span class="text-green-600">easyPay</span>ment Platform</h1>

                    <div class="flex space-x-20 justify-center">
                        <a href="#" class="bg-rose-600 text-white rounded-full px-8 py-2 hover:bg-blue-300">Send</a>
                        <a href="#" class="bg-rose-600 text-white rounded-full px-8 py-2 hover:bg-rose-300">Recieve</a>
                        <a href="#" class="bg-rose-600 text-white rounded-full px-8 py-2 hover:bg-rose-300">Pay Bills</a>
                        <a href="#" class="bg-rose-600 text-white rounded-full px-8 py-2 hover:bg-rose-300">Cards</a>
                        <a href="#" class="bg-rose-600 text-white rounded-full px-8 py-2 hover:bg-rose-300">Airtime</a>
                    </div>

                    <p class="text-lg">Experience a user-friendly interface that makes managing your finances quick and easy. Send and receive payments effortlessly with just a few clicks. Payyed is committed to providing a seamless digital payment experience for individuals and businesses alike.</p>

                    <p class="text-lg">Top up phone airtime or internet data. Pay electricity bills; renew TV subscriptions. Buy quality insurance covers, pay education bills, transfer funds and do more ... </p>
                </div>
            </div>
        </section>

        <section class="min-h-screen flex flex-col md:flex-row bg-gradient-to-l from-blue-100 to-gray-900 text-slate-100 mx-auto">
            <div class="w-full md:w-1/2 text-center md:text-left my-10 md:my-auto space-y-8 p-6">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight">Welcome to <span class="text-green-600">easyPay</span></h1>
                <p class="text-base md:text-lg">Your trusted partner for secure and seamless financial transactions. Send and receive money with confidence, anytime, anywhere. Payyed is your one-stop solution for hassle-free digital payments and services.</p>
        
                <p class="text-base md:text-lg">At Payyed, we prioritize the security of your transactions. Whether you're making payments, receiving funds, or requesting payments online, our platform is designed to offer the highest level of security and peace of mind.</p>
        
        
                <div class="mt-8">
                    <a href="#" class="bg-rose-600 text-white rounded-full px-8 py-3 hover:bg-rose-300 transition duration-300 ease-in-out">Get Started</a>
                    <a href="#" class="bg-rose-600 text-white rounded-full px-8 py-3 hover:bg-rose-300 transition duration-300 ease-in-out">Find ot more</a>
                </div>
            </div>
        
            <div class="w-full md:w-1/2 flex justify-center items-center">
                <img src="assets/images/bg13.jpg" alt="Illustration" class="w-full md:w-2/3 max-h-96 mx-auto rounded-lg shadow-md">
            </div>
        </section>

        <section class="relative bg-gray-900 py-16 z-0">
            
            <div class="absolute inset-0 bg-[url('/assets/images/bg3.jpg')] opacity-20 bg-cover bg-center bg-no-repeat bg-fixed z-0"></div>

            <div class="container mx-auto flex flex-wrap z-10">
                <!-- Payment Feature Card 1 -->
                <a href="#" class="w-full md:w-1/2 lg:w-1/4 px-4 mb-8 group">
                    <div class="bg-red-100 p-6 rounded-lg shadow-md h-64 transition duration-300 transform group-hover:scale-105">
                        <i class="fas fa-credit-card text-3xl text-blue-500 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Credit Card Payments</h3>
                        <p class="text-gray-600">Securely pay with your credit card. We accept major credit cards for hassle-free transactions.</p>
                    </div>
                </a>
    
                <!-- Payment Feature Card 2 -->
                <a href="#" class="w-full md:w-1/2 lg:w-1/4 px-4 mb-8 group">
                    <div class="bg-red-100 p-6 rounded-lg shadow-md h-64 transition duration-300 transform group-hover:scale-105">
                        <i class="fas fa-mobile-alt text-3xl text-green-500 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Mobile Payments</h3>
                        <p class="text-gray-600">Conveniently make payments using your mobile device. Fast and secure transactions on the go.</p>
                    </div>
                </a>
    
                <!-- Payment Feature Card 3 -->
                <a href="#" class="w-full md:w-1/2 lg:w-1/4 px-4 mb-8 group">
                    <div class="bg-red-100 p-6 rounded-lg shadow-md h-64 transition duration-300 transform group-hover:scale-105">
                        <i class="fas fa-wallet text-3xl text-purple-500 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Digital Wallets</h3>
                        <p class="text-gray-600">Link your digital wallets for quick and easy payments. Secure and efficient transactions at your fingertips.</p>
                    </div>
                </a>
    
                <!-- Payment Feature Card 4 -->
                <a href="#" class="w-full md:w-1/2 lg:w-1/4 px-4 mb-8 group">
                    <div class="bg-red-100 p-6 rounded-lg shadow-md h-64 transition duration-300 transform group-hover:scale-105">
                        <i class="fas fa-shield-alt text-3xl text-red-500 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Become an Agent</h3>
                        <p class="text-gray-600">Join us as an agent and contribute to secure transactions. Explore exciting opportunities to be part of our team.</p>
                    </div>
                </a>
            </div>
        </section>


        <section class="min-h-screen flex bg-gradient-to-r from-blue-300 to-white text-black pt-24">
            <div class="flex flex-col space-y-24">
                <div class="text-center space-y-4">
                    <h1 class="text-4xl font-bold">Why should you choose <span class="text-green-600">easyPay</span>?</h1>
                    <p class="text-2xl font-light">Here’s Top 4 reasons why using a Payyed account for manage your money.</p>
                </div>

                <div class="flex flex-row mx-6 space-x-4">
                    <div class="flex flex-col space-y-4">
                        <i class="fa-solid fa-handshake text-4xl text-rose-600"></i>
                        <h2 class="text-2xl font-bold">Easy to use</h2>
                        <p class="">Lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure.</p>
                        <a href="#" class="text-slate-600 hover:text-rose-600">Learn more &gt</a>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <i class="fa-solid fa-jet-fighter-up text-4xl text-rose-600"></i>
                        <h2 class="text-2xl font-bold">Faster Payments</h2>
                        <p class="">Persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure.</p>
                        <a href="#" class="text-slate-600 hover:text-rose-600">Learn more &gt</a>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <i class="fa-solid fa-hand-holding-dollar text-4xl text-rose-600"></i>
                        <h2 class="text-2xl font-bold">Lower Fees</h2>
                        <p class="">Essent lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure.</p>
                        <a href="#" class="text-slate-600 hover:text-rose-600">Learn more &gt</a>
                    </div>
                    <div class="flex flex-col space-y-4">
                        <i class="fa-solid fa-user-lock text-4xl text-rose-600"></i>
                        <h2 class="text-2xl font-bold">100% secure</h2>
                        <p class="">Quidam lisque persius interesset his et, in quot quidam persequeris vim, ad mea essent possim iriure.</p>
                        <a href="#" class="text-slate-600 hover:text-rose-600">Learn more &gt</a>
                    </div>
                </div>
            </div>
        </section>

        <footer>

            <div class="flex justify-center space-x-28 p-6">
                <div class="flex flex-col space-y-2">
                    <h2 class="font-bold text-slate-400">INFORMATION</h2>
                    <a href="#" class="hover:text-indigo-600">About Us</a>
                    <a href="#" class="hover:text-indigo-600">Careers</a>
                    <a href="#" class="hover:text-indigo-600">Affiliate</a>
                    <a href="#" class="hover:text-indigo-600">Fees</a>
                </div>
    
                <div class="flex flex-col space-y-4">
                    <h2 class="font-bold text-slate-400">SERVICESS</h2>
                    <a href="#" class="hover:text-indigo-600">Transfer</a>
                    <a href="#" class="hover:text-indigo-600">Cards</a>
                    <a href="#" class="hover:text-indigo-600">Pay Bills</a>
                    <a href="#" class="hover:text-indigo-600">Online shopping</a>
                </div>
    
                <div class="flex flex-col space-y-4">
                    <h2 class="font-bold text-slate-400">HELP CENTER</h2>
                    <a href="#" class="hover:text-indigo-600">Contact Us</a>
                    <a href="#" class="hover:text-indigo-600">Support</a>
                    <a href="#" class="hover:text-indigo-600">FAQ</a>
                </div>
    
                <div class="flex flex-col space-y-4">
                    <h2 class="font-bold text-slate-400">SUBSCRIBE</h2>
                    <div class="flex space-x-8 text-3xl">
                        <i class="fa-brands fa-square-facebook hover:text-indigo-600"></i>
                        <i class="fa-brands fa-square-x-twitter hover:text-indigo-600"></i>
                        <i class="fa-brands fa-linkedin hover:text-indigo-600"></i>
                        <i class="fa-brands fa-square-github hover:text-indigo-600"></i>
                    </div>
                    <p>Subscribe to receive latest news and updates.</p>
                    <div class="flex flex-row">
                        <input type="text" class="border-2 rounded-l-lg px-4 py-2" placeholder="Email Address">
                        <a href="#" class="bg-black rounded-r-lg px-4 py-2 hover:bg-indigo-600"><i class="fas fa-paper-plane text-2xl text-white"></i></a>
                    </div>
                                      
                </div>
            </div>
            <hr class="border-t border-slate-300 w-full">

            <div class="flex justify-around text-center py-4 text-black w-2/3">
                <p class="">&copy; 2023 <span class="text-green-600">easyPay</span>. All Rights Reserved.</p>
            
                <nav class="flex space-x-4">
                    <a href="#" class="">Security</a>
                    <a href="#" class="">Terms</a>
                    <a href="#" class="">Privacy</a>
                </nav>
            </div>

            <button onclick="scrollToTop()" class="fixed bottom-8 right-8 bg-slate-300 text-slate-700 px-4 py-2 rounded-full hover:bg-rose-300">
                Back to Top
            </button>

        </footer>

    </main>


</body>
</html>
