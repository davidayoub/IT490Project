<?php
require(__DIR__."/../partials/nav.php");
?>

<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h1 class="text-4xl font-bold mb-8">Contact Us</h1>

        <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <h2 class="text-2xl font-semibold mb-5">Get in Touch</h2>
                <form>
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                        <input type="text" id="name" placeholder="Your Name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" id="email" placeholder="Your Email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                        <textarea id="message" rows="4" placeholder="Your Message" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Send Message</button>
                </form>
            </div>

            <div class="w-full md:w-1/2 px-3">
                <h2 class="text-2xl font-semibold mb-5">Our Address</h2>
                <address class="not-italic mb-4">
                    <p>123 Main Street</p>
                    <p>City, State ZIP</p>
                    <p>Country</p>
                </address>
                <h2 class="text-2xl font-semibold mb-5">Find Us</h2>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24130.00225309307!2d-74.5585055!3d40.88832445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c3754c0b110fdd%3A0x7011ac8f0b333916!2sDover%2C%20NJ!5e0!3m2!1sen!2sus!4v1699542594749!5m2!1sen!2sus" width="300" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div id="map" class="h-72"></div>
            </div>
        </div>
    </div>
</body>


<?php
require(__DIR__ . "/../partials/footer.php");
?>

