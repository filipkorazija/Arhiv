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
    <title>MOS Servis - Arhiv 1</title>
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <h2>Arhiv stanovanj</h2>

        <!-- Search Form -->
        <form method="GET" action="display_dn.php" class="search-form">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $country = isset($_GET['country']) ? $_GET['country'] : '';
            $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'dn';
            $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
            ?>
            <div class="input-group">
                <input type="text" name="search" placeholder="Ključne besede (deljene z vejico)" value="<?php echo htmlspecialchars($search); ?>" class="search-input">
                <select name="country" class="search-select">
                    <option value="">Vse Države</option>
                    <option value="Anglija" <?php echo $country == 'Anglija' ? 'selected' : ''; ?>>Anglija</option>
                    <option value="Avstrija" <?php echo $country == 'Avstrija' ? 'selected' : ''; ?>>Avstrija</option>
                    <option value="Belgija" <?php echo $country == 'Belgjia' ? 'selected' : ''; ?>>Belgija</option>
                    <option value="Bolgarija" <?php echo $country == 'Bolgarija' ? 'selected' : ''; ?>>Bolgarija</option>
                    <option value="Češka" <?php echo $country == 'Češka' ? 'selected' : ''; ?>>Češka</option>
                    <option value="Danska" <?php echo $country == 'Danska' ? 'selected' : ''; ?>>Danska</option>
                    <option value="Finska" <?php echo $country == 'Finska' ? 'selected' : ''; ?>>Finska</option>
                    <option value="Francija" <?php echo $country == 'Francija' ? 'selected' : ''; ?>>Francija</option>
                    <option value="Hrvaška" <?php echo $country == 'Hrvaška' ? 'selected' : ''; ?>>Hrvaška</option>
                    <option value="Kanada" <?php echo $country == 'Kanada' ? 'selected' : ''; ?>>Kanada</option>
                    <option value="Italija" <?php echo $country == 'Italija' ? 'selected' : ''; ?>>Italija</option>
                    <option value="Islandija" <?php echo $country == 'Islandija' ? 'selected' : ''; ?>>Islandija</option>
                    <option value="Nemčija" <?php echo $country == 'Nemčija' ? 'selected' : ''; ?>>Nemčija</option>
                    <option value="Nizozemska" <?php echo $country == 'Nizozemska' ? 'selected' : ''; ?>>Nizozemska</option>
                    <option value="Norveška" <?php echo $country == 'Norveška' ? 'selected' : ''; ?>>Norveška</option>
                    <option value="Madžarska" <?php echo $country == 'Madžarska' ? 'selected' : ''; ?>>Madžarska</option>
                    <option value="Poljska" <?php echo $country == 'Poljska' ? 'selected' : ''; ?>>Poljska</option>
                    <option value="Portugalska" <?php echo $country == 'Portugalska' ? 'selected' : ''; ?>>Portugalska</option>
                    <option value="Romunija" <?php echo $country == 'Romunija' ? 'selected' : ''; ?>>Romunija</option>
                    <option value="Slovaška" <?php echo $country == 'Slovaška' ? 'selected' : ''; ?>>Slovaška</option>
                    <option value="Španija" <?php echo $country == 'Španija' ? 'selected' : ''; ?>>Španija</option>
                    <option value="Švedska" <?php echo $country == 'Švedska' ? 'selected' : ''; ?>>Švedska</option>
                    <option value="Švica" <?php echo $country == 'Švica' ? 'selected' : ''; ?>>Švica</option>
                    <option value="ZDA" <?php echo $country == 'ZDA' ? 'selected' : ''; ?>>ZDA</option>
                    <!-- Add more countries as needed -->
                </select>
                <input type="submit" value="Search" class="btn btn-primary">
            </div>
        </form>

        <?php
        include('db.php');

        // Split the search string into an array of keywords
        $keywords = array_map('trim', explode(',', $search));

        // Base SQL query
        $sql = "SELECT * FROM delovni_nalog";

        // Modify SQL query to include search condition if keywords are provided
        $conditions = [];
        if ($search) {
            foreach ($keywords as $keyword) {
                // Ensure the keyword is not empty before adding to conditions
                if (!empty($keyword)) {
                    $escaped_keyword = $conn->real_escape_string($keyword);  // Escape the keyword for security
                    $conditions[] = "dn LIKE '%$escaped_keyword%' OR 
                                     naslov_stanovanja LIKE '%$escaped_keyword%' OR 
                                     postna_st LIKE '%$escaped_keyword%' OR 
                                     kontakt LIKE '%$escaped_keyword%' OR 
                                     imena LIKE '%$escaped_keyword%' OR 
                                     cena_oseba_dan LIKE '%$escaped_keyword%' OR 
                                     st_racuna LIKE '%$escaped_keyword%' OR 
                                     opombe LIKE '%$escaped_keyword%'";
                }
            }
        }
        if ($country) {
            $escaped_country = $conn->real_escape_string($country);
            $conditions[] = "country = '$escaped_country'";
        }
    
        // Join conditions with OR to include any record that matches any keyword
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' OR ', $conditions);
        }
    
        // Add sorting
        $sql .= " ORDER BY $sort_column $sort_order";
    
        $result = $conn->query($sql);
    
        // Function to toggle sort order
        function toggle_sort_order($current_order) {
            return $current_order === 'ASC' ? 'DESC' : 'ASC';
        }
    
        // Determine the next sort order for each column
        $next_sort_order = toggle_sort_order($sort_order);
    
        // Function to get sort icon
        function get_sort_icon($column, $current_column, $current_order) {
            if ($column === $current_column) {
                return $current_order === 'ASC' ? '▲' : '▼';
            }
            return '';
        }
    
        if ($result->num_rows > 0) {
            echo "<table>
                    <thead>
                        <tr>
                            <th><a href='?sort_column=dn&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>DN " . get_sort_icon('dn', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=naslov_stanovanja&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Naslov Stanovanja " . get_sort_icon('naslov_stanovanja', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=postna_st&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Poštna Št. " . get_sort_icon('postna_st', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=kontakt&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Kontakt " . get_sort_icon('kontakt', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=imena&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Imena " . get_sort_icon('imena', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=cena_oseba_dan&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Cena/Oseba/Dan " . get_sort_icon('cena_oseba_dan', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=st_racuna&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Št. Računa " . get_sort_icon('st_racuna', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=opombe&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Opombe " . get_sort_icon('opombe', $sort_column, $sort_order) . "</a></th>
                            <th>Brisanje</th>
                        </tr>
                    </thead>
                    <tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["dn"]."</td>
                        <td>".$row["naslov_stanovanja"]."</td>
                        <td>".$row["postna_st"]."</td>
                        <td>".$row["kontakt"]."</td>
                        <td>".$row["imena"]."</td>
                        <td>".$row["cena_oseba_dan"]."</td>
                        <td>".$row["st_racuna"]."</td>
                        <td>".$row["opombe"]."</td>
                        <td><a href='delete_dn.php?id=".$row["id"]."' onclick=\"return confirm('POZOR! Ali ste prepričani za želite izbrisati ta vnos?');\" class='btn btn-secondary'>Izbriši</a></td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='message-box'>Podatki z temi parametri ne obstajajo!</div>";
        }
        $conn->close();
        ?>
    </div>

    <?php include('footer.php'); ?>

    </body>
</html>
