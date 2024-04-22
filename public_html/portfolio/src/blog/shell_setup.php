<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
    <title>Installation and Usage Guide</title>

</head>

<body class="bg-gradient-to-r from-gray-900 from-10% via-purple-900 via-50% to-gray-900 to-90%">

    <div class="w-11/12 lg:max-w-4xl container mx-auto bg-white my-12 p-4 md:p-8 rounded shadow-xl shadow-yellow-600">

        <h1 class="md:text-2xl lg:text-3xl mx-auto font-bold mb-6 text-center">Installation and Usage Guide</h1>
        <p class="mb-4">Welcome to the installation and usage guide for my <strong><code class="bg-gray-200 p-1">Simple Shell!</code></strong> Follow the steps below to unleash the power of this fantastic command-line companion.</p>

        <h2 class="text-2xl font-bold mb-4">1. Clone the Repository</h2>
        <p class="mb-4">Open your terminal and run the following command to clone the repository:</p>

        <div class="relative max-w-2xl mx-auto bg-cyan-100 p-2 mb-12 italic font-bold">
            <pre class="relative overflow-x-auto"><code id="language-c6">
git clone https://github.com/yungryce/simple_shell.git
            </code></pre>

            <button onclick="copyToClipboard('language-c6')" class="absolute top-0 right-0 mt-2 mr-2 bg-blue-900 text-white px-3 py-1 opacity-50 hover:opacity-100 rounded-md">
                <i class="fas fa-copy"></i>
            </button>
        </div>

        <h2 class="text-2xl font-bold mb-4">2. Compile the Code</h2>
        <p class="mb-4">Navigate to the cloned repository and compile the code using the specified command:</p>

        <div class="relative max-w-2xl mx-auto bg-cyan-100 p-2 mb-12 italic font-bold">
            <pre class="relative overflow-x-auto"><code id="language-c7">
cd simple_shell
gcc -Wall -Werror -Wextra -pedantic -std=gnu89 *.c -o shell
            </code></pre>

            <button onclick="copyToClipboard('language-c7')" class="absolute top-0 right-0 mt-2 mr-2 bg-blue-900 text-white px-3 py-1 opacity-50 hover:opacity-100 rounded-md">
                <i class="fas fa-copy"></i>
            </button>
        </div>


        <h2 class="text-2xl font-bold mb-4">3. Run the Shell</h2>
        <p class="mb-4">Now, you're ready to run the shell. Use the following commands for interactive and non-interactive modes:</p>

        <div class="relative max-w-2xl mx-auto bg-cyan-100 p-2 mb-12 italic font-bold">
            <pre class="relative overflow-x-auto"><code id="language-c8">
Interactive: ./shell
Non-Interactive: echo "command" | ./shell
            </code></pre>

            <button onclick="copyToClipboard('language-c8')" class="absolute top-0 right-0 mt-2 mr-2 bg-blue-900 text-white px-3 py-1 opacity-50 hover:opacity-100 rounded-md">
                <i class="fas fa-copy"></i>
            </button>
        </div>

        <p class="mb-4 text-2xl font-bold underline">Usage:</p>
        <h2 class="text-xl font mb-2">In Interactive Mode</h2>

        <div class="relative max-w-2xl mx-auto bg-cyan-100 p-2 mb-12 italic font-bold">
            <pre class="relative overflow-x-auto"><code id="language-c9">
$ ./shell
    ($) /ls
    shell main.c shell.c
    ($)
    ($) exit
$
            </code></pre>

            <button onclick="copyToClipboard('language-c9')" class="absolute top-0 right-0 mt-2 mr-2 bg-blue-900 text-white px-3 py-1 opacity-50 hover:opacity-100 rounded-md">
                <i class="fas fa-copy"></i>
            </button>
        </div>

        <h2 class="text-xl font mb-2">In Non-Interactive Mode</h2>

        <div class="relative max-w-2xl mx-auto bg-cyan-100 p-2 mb-12 italic font-bold">
            <pre class="relative overflow-x-auto"><code id="language-c10">
$ echo "ls" | ./shell
shell main.c shell.c test_ls_2
$
$ cat test_ls_2
/bin/ls
/bin/ls
$
$ cat test_ls_2 | ./shell
shell main.c shell.c test_ls_2
shell main.c shell.c test_ls_2
$
            </code></pre>

            <button onclick="copyToClipboard('language-c10')" class="absolute top-0 right-0 mt-2 mr-2 bg-blue-900 text-white px-3 py-1 opacity-50 hover:opacity-100 rounded-md">
                <i class="fas fa-copy"></i>
            </button>
        </div>

        <h2 class="text-xl mb-4 font-bold">Explore and Enjoy!</h2>
        <p class="mb-4">Congratulations! You've successfully installed and run <strong><code class="bg-gray-200 p-1">Simple Shell</code></strong>. Feel free to explore its features and unleash the command-line magic. If you encounter any issues, please reach out as it would be greatly appreciated.</p>

    </div>

    <a href="simple_shell.php" class="bg-red-200 text-blue-700 px-4 py-2 rounded-lg fixed bottom-8 left-8 font-bold delay-200 duration-300 transition-transform transform hover:scale-125 shadow-inner shadow-black">
        Back
    </a>

    <a href="https://github.com/yungryce/simple_shell.git" class="bg-red-200 text-blue-700 px-4 py-2 rounded-lg fixed bottom-8 right-8 font-bold delay-200 duration-300 transition-transform transform hover:scale-125 shadow-inner shadow-black">
        GitHub
    </a>

    <script src="../assets/js/button_copy.js"></script>

</body>

</html>
