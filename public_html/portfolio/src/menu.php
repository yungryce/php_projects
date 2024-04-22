<navbar class="text-white">
    <button id="menu-toggle" class="z-10 top-0 left-0 mt-8 ml-8 fixed">
            <i class="fas fa-bars text-4xl text-lime-500"></i>
    </button>

    <div id="menu" class="flex justify-center items-center hidden fixed z-10 top-0 left-0 w-full md:w-1/2 lg:w-1/3 h-screen bg-gray-900 opacity-95">
        <div class="flex flex-col space-y-6 text-3xl font-bold text-orange-300 tracking-wide text-center">

            <a href="/" class="hover:translate-x-3 hover:translate-y-3 duration-700 hover:shadow hover:shadow-md hover:shadow-blue-400">Home</a>
            <?php
            $pages = [
                'Projects' => '/projects.php',
                'Blog' => '/blog.php',
                'Contacts' => '/contacts.php',
            ];

            foreach ($pages as $label => $url) :
                $currentPage = $_SERVER['REQUEST_URI'];
                $isCurrentPage = ($currentPage === $url || ($currentPage === '/' && $url === '/index.php'));
                $hiddenClass = $isCurrentPage ? 'hidden' : '';
            ?>
                <a href="<?php echo $url; ?>" class="hover:translate-x-3 hover:translate-y-3 duration-700 hover:shadow hover:shadow-md hover:shadow-blue-400 <?php echo $hiddenClass; ?>">
                    <?php echo $label; ?>
                </a>
            <?php endforeach; ?>

            <a href="/assets/pdf/Joshua_Resume.pdf" target="_blank" download="Joshua_Resume.pdf" class="hover:translate-x-3 hover:translate-y-3 duration-700 hover:shadow hover:shadow-md hover:shadow-blue-400">Resume</a>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['login_successful'] === true) : ?>
                <a href="auth/logout.php" class="hover:translate-x-3 hover:translate-y-3 duration-700 hover:shadow hover:shadow-md hover:shadow-blue-400">Logout</a>
            <?php else : ?>
                <a href="auth/signup.php" class="hover:translate-x-3 hover:translate-y-3 duration-700 hover:shadow hover:shadow-md hover:shadow-blue-400">Signup</a>
                <a href="auth/login.php" class="hover:translate-x-3 hover:translate-y-3 duration-700 hover:shadow hover:shadow-md hover:shadow-blue-400">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <button id="menu-close" class="hidden z-10 w-full md:w-1/2 lg:w-1/3 top-0 left-0 flex justify-end fixed mt-8 px-8">
        <i class="fas fa-times text-4xl"></i>
    </button>
    
</navbar>