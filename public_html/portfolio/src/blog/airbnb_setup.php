<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <script src="https://kit.fontawesome.com/9309addca2.js" crossorigin="anonymous"></script>
    <title>Installation and Usage Guide</title>

</head>

<body class="bg-gradient-to-r from-gray-900 from-10% via-purple-900 via-50% to-gray-900 to-90%">

    <div class="w-11/12 lg:max-w-4xl container mx-auto bg-white my-12 p-4 md:p-8 rounded shadow-xl shadow-yellow-600">

        <h1 class="md:text-2xl lg:text-3xl mx-auto font-bold mb-6 text-center">Installation and Usage Guide</h1>
        <p class="mb-8">Welcome to the installation and usage guide for my <strong><code class="bg-gray-200 p-1">CLI management system</code></strong> Follow the steps below to unleash the power of this fantastic command-line Interpreter.</p>

        <h2 class="text-lg lg:text-2xl font-bold mb-2">1. Clone the Repository</h2>
        <p class="mb-4">Open your terminal and run the following command to clone the repository:</p>

        <div class="relative max-w-2xl mx-auto bg-cyan-100 p-2 mb-12 italic font-bold">
            <pre class="relative overflow-x-auto"><code id="python-1">
git clone https://github.com/yungryce/AirBnB_clone.git
            </code></pre>

            <button onclick="copyToClipboard('python-1')" class="absolute top-0 right-0 mt-2 mr-2 bg-blue-900 text-white px-3 py-1 opacity-50 hover:opacity-100 rounded-md">
                <i class="fas fa-copy"></i>
            </button>
        </div>

        <h2 class="text-lg lg:text-2xl font-bold mb-2">2. Navigate to the program</h2>
        <p>Please make sure Python is installed on your system. To install python for your system, please refer to Python's installation guide <a href="https://www.python.org/downloads/" class="text-blue-700 hover:underline font-bold">here...</a></p>
        <p class="my-2">Navigate to the cloned repository and run the Interpreter:</p>

        <div class="relative max-w-2xl mx-auto bg-cyan-100 p-2 mb-12 italic font-bold">
            <pre class="relative overflow-x-auto"><code id="python-2">
cd AirBnB_clone
python3 console.py
            </code></pre>

            <button onclick="copyToClipboard('python-2')" class="absolute top-0 right-0 mt-2 mr-2 bg-blue-900 text-white px-3 py-1 opacity-50 hover:opacity-100 rounded-md">
                <i class="fas fa-copy"></i>
            </button>
        </div>

        <h2 class="mb-4 text-lg lg:text-2xl font-bold">Usage:</h2>

        <div class="relative max-w-2xl mx-auto bg-cyan-100 p-2 mb-12 italic font-bold">
            <pre class="relative overflow-x-auto"><code id="python-3">
python console.py
    (hbnb) &lt;class_name&gt;.&lt;command&gt;([&lt;id&gt;[name_arg value_arg]|[kwargs]])
            </code></pre>

            <button onclick="copyToClipboard('python-3')" class="absolute top-0 right-0 mt-2 mr-2 bg-blue-900 text-white px-3 py-1 opacity-50 hover:opacity-100 rounded-md">
                <i class="fas fa-copy"></i>
            </button>
        </div>

        <img src="/assets/images/hbnb.png" alt="#" class="mx-auto mb-8 p-4">

        <h2 class="text-xl mb-4 font-bold">Explore and Enjoy!</h2>
        <p class="mb-4">Congratulations! You've successfully installed and run my <strong><code class="bg-gray-200 p-1">Airbnb Clone</code></strong> property management Interpreter. Feel free to explore all features. If you encounter any issues or have any inputs or care and love to talk about code, please reach out as it would be greatly appreciated.</p>

    </div>

    <a href="airbnb.php" class="bg-red-200 text-blue-700 px-4 py-2 rounded-lg fixed bottom-8 left-8 font-bold delay-200 duration-300 transition-transform transform hover:scale-125 shadow-inner shadow-black">
        Back
    </a>

    <a href="https://github.com/yungryce/AirBnB_clone.git" class="bg-red-200 text-blue-700 px-4 py-2 rounded-lg fixed bottom-8 right-8 font-bold delay-200 duration-300 transition-transform transform hover:scale-125 shadow-inner shadow-black">
        GitHub
    </a>

    <script src="../assets/js/button_copy.js"></script>

</body>

</html>
