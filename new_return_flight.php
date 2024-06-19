<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vnos povratnih letov</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Vnos povratnih letov</h2>
        <form class="grid grid-cols-1 md:grid-cols-2 gap-6" action="save_return_flight.php" method="post">
            <div class="form-group">
                <label for="name" class="block text-sm font-medium text-gray-700">Ime in priimek:</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="form-group">
                <label for="departure_airport" class="block text-sm font-medium text-gray-700">Letališče odhoda:</label>
                <input type="text" id="departure_airport" name="departure_airport" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="form-group">
                <label for="departure_date" class="block text-sm font-medium text-gray-700">Datum odhoda:</label>
                <input type="date" id="departure_date" name="departure_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="form-group">
                <label for="departure_time" class="block text-sm font-medium text-gray-700">Ura odhoda:</label>
                <input type="time" id="departure_time" name="departure_time" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="form-group">
                <label for="arrival_airport" class="block text-sm font-medium text-gray-700">Letališče prihoda:</label>
                <input type="text" id="arrival_airport" name="arrival_airport" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="form-group">
                <label for="arrival_date" class="block text-sm font-medium text-gray-700">Datum prihoda:</label>
                <input type="date" id="arrival_date" name="arrival_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="form-group">
                <label for="arrival_time" class="block text-sm font-medium text-gray-700">Ura pristanka:</label>
                <input type="time" id="arrival_time" name="arrival_time" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
            </div>
            <div class="form-group col-span-2">
                <label for="country" class="block text-sm font-medium text-gray-700">Država - Kraj:</label>
                <select id="country" name="country" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="AT-Dunaj">AT - Dunaj</option>
                    <option value="AT-Graz">AT - Graz</option>
                    <option value="HR-Zagreb">HR - Zagreb</option>
                    <option value="SI-Ljubljana">SI - Ljubljana</option>
                    <option value="CA-Toronto">CA - Toronto</option>
                    <option value="CA-Montreal">CA - Montreal</option>
                    <option value="DE-Frankfurt">DE - Frankfurt</option>
                    <option value="US-Greenville">US - Greenville SC</option>
                    <option value="US-Guatemala">US - Guatemala</option>
                    <option value="US-Memphis">US - Memphis</option>
                    <option value="US-Chicago">US - Chicago</option>
                </select>
            </div>
            <div class="form-group col-span-2">
                <label for="flight_type" class="block text-sm font-medium text-gray-700">Tip leta:</label>
                <div class="mt-1 flex">
                    <div class="flex items-center mr-4">
                        <input id="direct_flight" name="flight_type" type="radio" value="Direkten let" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" onclick="toggleNoteField(false)" checked>
                        <label for="direct_flight" class="ml-3 block text-sm font-medium text-gray-700">Direkten let</label>
                    </div>
                    <div class="flex items-center">
                        <input id="connecting_flight" name="flight_type" type="radio" value="Prestopen let" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" onclick="toggleNoteField(true)">
                        <label for="connecting_flight" class="ml-3 block text-sm font-medium text-gray-700">Prestopni let</label>
                    </div>
                </div>
            </div>
            <div class="form-group col-span-2" id="note_field" style="display: none;">
                <label for="note" class="block text-sm font-medium text-gray-700">Opomba:</label>
                <textarea id="note" name="note" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
            <div class="btn-container col-span-2 text-right">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Shrani</button>
            </div>
        </form>
    </div>

    <?php include('footer.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function toggleNoteField(show) {
            document.getElementById('note_field').style.display = show ? 'block' : 'none';
        }
    </script>

</body>
</html>
