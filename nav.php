<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOS Servis</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        /* Additional styles to handle dropdowns */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .dropdown-menu a {
            white-space: nowrap; /* Prevent line breaks */
        }
    </style>
</head>
<body>
<nav class="bg-gray-900 text-white w-full">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <a class="text-xl font-bold" href="https://mos.si">MOS Servis</a>
            <div class="flex-1 hidden lg:flex lg:items-center lg:justify-center">
                <ul class="flex space-x-4">
                    <li class="relative dropdown">
                        <a class="block py-2 lg:py-0" href="#">Stanovanja</a>
                        <ul class="absolute left-0 mt-2 hidden bg-white text-black dropdown-menu">
                            <li><a class="block px-4 py-2 hover:bg-gray-200" href="index.php">Vnos novih stanovanj</a></li>
                            <li><a class="block px-4 py-2 hover:bg-gray-200" href="display_dn.php">Arhiv stanovanj</a></li>
                        </ul>
                    </li>
                    <li class="relative dropdown">
                        <a class="block py-2 lg:py-0" href="#">Leti v države</a>
                        <ul class="absolute left-0 mt-2 hidden bg-white text-black dropdown-menu">
                            <li><a class="block px-4 py-2 hover:bg-gray-200" href="new_flight.php">Vnos novih letov</a></li>
                            <li><a class="block px-4 py-2 hover:bg-gray-200" href="display_flights.php">Arhiv letov</a></li>
                        </ul>
                    </li>
                    <li class="relative dropdown">
                        <a class="block py-2 lg:py-0" href="#">Povratni leti</a>
                        <ul class="absolute left-0 mt-2 hidden bg-white text-black dropdown-menu">
                            <li><a class="block px-4 py-2 hover:bg-gray-200" href="new_return_flight.php">Vnos povratnih letov</a></li>
                            <li><a class="block px-4 py-2 hover:bg-gray-200" href="display_return_flights.php">Arhiv povratnih letov</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="lg:flex lg:items-center hidden">
                <span class="mr-2">Pozdravljen/a, <?php echo $_SESSION['username']; ?> ❘ </span>
                <a class="block py-2 lg:py-0" href="logout.php">Odjava</a>
            </div>
            <div class="lg:hidden">
                <button class="navbar-toggler" id="navbar-toggler">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Ensure Tailwind JS is included for the responsive menu toggle -->
<script>
    document.getElementById('navbar-toggler').onclick = function () {
        var navDropdown = document.getElementById('navbarNavDropdown');
        if (navDropdown.classList.contains('hidden')) {
            navDropdown.classList.remove('hidden');
        } else {
            navDropdown.classList.add('hidden');
        }
    };

    // Handle dropdown delay
    document.querySelectorAll('.dropdown').forEach(function(dropdown) {
        dropdown.addEventListener('mouseenter', function() {
            var dropdownMenu = this.querySelector('.dropdown-menu');
            dropdownMenu.classList.remove('hidden');
        });

        dropdown.addEventListener('mouseleave', function() {
            var dropdownMenu = this.querySelector('.dropdown-menu');
            setTimeout(function() {
                dropdownMenu.classList.add('hidden');
            }, 300); // Adjust the delay as needed
        });
    });
</script>
</body>
</html>
