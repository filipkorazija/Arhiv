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
<html>
<head>
    <title>MOS Servis</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
    
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Vnos novega stanovanja</h2>
        <form class="grid grid-cols-1 md:grid-cols-2 gap-6" action="save_dn.php" method="post">
            <div class="form-group">
                <label for="dn" class="block text-sm font-medium text-gray-700">DN:</label>
                <input type="text" id="dn" name="dn" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group">
                <label for="naslov_stanovanja" class="block text-sm font-medium text-gray-700">Naslov Stanovanja:</label>
                <input type="text" id="naslov_stanovanja" name="naslov_stanovanja" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group">
                <label for="postna_st" class="block text-sm font-medium text-gray-700">Poštna Št.:</label>
                <input type="text" id="postna_st" name="postna_st" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group">
                <label for="kontakt" class="block text-sm font-medium text-gray-700">Kontakt:</label>
                <input type="text" id="kontakt" name="kontakt" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group">
                <label for="imena" class="block text-sm font-medium text-gray-700">Število oseb:</label>
                <input type="text" id="imena" name="imena" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group">
                <label for="cena_oseba_dan" class="block text-sm font-medium text-gray-700">Cena/Oseba/Dan:</label>
                <input type="text" id="cena_oseba_dan" name="cena_oseba_dan" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="form-group col-span-2">
                <label for="country" class="block text-sm font-medium text-gray-700">Države:</label>
                <select id="country" name="country" required class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Izberi Državo</option>
                    <option value="Anglija">Anglija</option>
                    <option value="Avstrija">Avstrija</option>
                    <option value="Belgija">Belgija</option>
                    <option value="Bolgarija">Bolgarija</option>
                    <option value="Češka">Češka</option>
                    <option value="Danska">Danska</option>
                    <option value="Finska">Finska</option>
                    <option value="Francija">Francija</option>
                    <option value="Hrvaška">Hrvaška</option>
                    <option value="Kanada">Kanada</option>
                    <option value="Italija">Italija</option>
                    <option value="Islandija">Islandija</option>
                    <option value="Nemčija">Nemčija</option>
                    <option value="Nizozemska">Nizozemska</option>
                    <option value="Norveška">Norveška</option>
                    <option value="Madžarska">Madžarska</option>
                    <option value="Poljska">Poljska</option>
                    <option value="Portugalska">Portugalska</option>
                    <option value="Romunija">Romunija</option>
                    <option value="Slovaška">Slovaška</option>
                    <option value="Španija">Španija</option>
                    <option value="Švedska">Švedska</option>
                    <option value="Švica">Švica</option>
                    <option value="ZDA">ZDA</option>
                </select>
            </div>
            <div class="form-group col-span-2">
                <label for="opombe" class="block text-sm font-medium text-gray-700">Opombe:</label>
                <textarea id="opombe" name="opombe" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
            </div>
            <div class="btn-container col-span-2 text-right">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Shrani</button>
            </div>
        </form>
    </div>

    <?php include('footer.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>
</html>
