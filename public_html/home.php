<?php
require(__DIR__."/../partials/nav.php");
require(__DIR__ . "/server_functions/login_registration.php");
?>

<body class="bg-white">
    <!-- Main Section -->
    <div class="p-4"> <!-- Padding to the container -->
        <div class="text-center space-y-4">
            <h1 class="text-3xl font-bold text-var(--theme-color-primary) mt-4">Welcome!</h1>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero bg-gray-100 p-10 text-center">
        <h2 class="text-2xl font-semibold">Discover Our Amazing Features</h2>

        <!--<p class="text-gray-600 mt-4 m-4">Praesent libero.</p>-->
    </section>
    <br>
    <!-- Testimonials -->
    <section class="testimonials mt-10 p-4">
        <h2 class="text-2xl font-semibold text-center mb-6">What Our Users Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="testimonial p-4 border rounded">
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit."</p>
                <h3 class="font-semibold mt-4">- John Doe</h3>
            </div>
            <div class="testimonial p-4 border rounded">
                <p>"Praesent libero. Sed cursus ante dapibus diam."</p>
                <h3 class="font-semibold mt-4">- Jane Smith</h3>
            </div>
            <div class="testimonial p-4 border rounded">
                <p>"Suspendisse fringilla fringilla nisl. Donec sodales sagittis magna."</p>
                <h3 class="font-semibold mt-4">- Alice Brown</h3>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="contact mt-10 p-4">
        <h2 class="text-2xl font-semibold text-center mb-6">Get in Touch</h2>
        <form action="contact_process.php" method="post">
            <div class="mb-4">
                <label for="name" class="block mb-2">Name</label>
                <input type="text" id="name" name="name" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-2">Email</label>
                <input type="email" id="email" name="email" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block mb-2">Message</label>
                <textarea id="message" name="message" rows="5" class="w-full p-2 border rounded" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-var(--theme-color-primary) text-white py-2 px-4 rounded">Send Message</button>
            </div>
        </form>
    </section>

</body>

<?php
require(__DIR__ . "/../partials/footer.php");
?>
