<?php
include('db.php');
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
    <title>MOS Servis - Arhiv 2</title>
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container">
        <h2>Arhiv letov</h2>

        <!-- Search Form -->
        <form method="GET" action="display_flights.php" class="search-form">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $country = isset($_GET['country']) ? $_GET['country'] : '';
            $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'name'; // Update with actual column name
            $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
            ?>
            <div class="input-group">
                <input type="text" name="search" placeholder="Ključne besede (deljene z vejico)" value="<?php echo htmlspecialchars($search); ?>" class="search-input">
                <select name="country" class="search-select">
                    <option value="">Vse Države</option>
                    <option value="AT-Dunaj" <?php echo $country == 'AT-Dunaj' ? 'selected' : ''; ?>>AT - Dunaj</option>
                    <option value="AT-Graz" <?php echo $country == 'AT-Graz' ? 'selected' : ''; ?>>AT - Graz</option>
                    <option value="HR-Zagreb" <?php echo $country == 'HR-Zagreb' ? 'selected' : ''; ?>>HR - Zagreb</option>
                    <option value="CA-Toronto" <?php echo $country == 'CA-Toronto' ? 'selected' : ''; ?>>CA - Toronto</option>
                    <option value="DE-Frankfurt" <?php echo $country == 'DE-Frankfurt' ? 'selected' : ''; ?>>DE - Frankfurt</option>
                    <option value="US-Greenville" <?php echo $country == 'US-Greenville' ? 'selected' : ''; ?>>US - Greenville SC</option>
                    <option value="US-Guatemala" <?php echo $country == 'US-Guatemala' ? 'selected' : ''; ?>>US - Guatemala</option>
                </select>
                <input type="submit" value="Search" class="btn btn-primary">
            </div>
        </form>

        <?php

        // Split the search string into an array of keywords
        $keywords = array_map('trim', explode(',', $search));

        // Base SQL query
        $sql = "SELECT * FROM flights";

        // Modify SQL query to include search condition if keywords are provided
        $conditions = [];
        if ($search) {
            foreach ($keywords as $keyword) {
                // Ensure the keyword is not empty before adding to conditions
                if (!empty($keyword)) {
                    $escaped_keyword = $conn->real_escape_string($keyword);  // Escape the keyword for security
                    $conditions[] = "name LIKE '%$escaped_keyword%' OR 
                                     departure_airport LIKE '%$escaped_keyword%' OR 
                                     departure_date LIKE '%$escaped_keyword%' OR 
                                     departure_time LIKE '%$escaped_keyword%' OR 
                                     arrival_airport LIKE '%$escaped_keyword%' OR 
                                     arrival_date LIKE '%$escaped_keyword%' OR 
                                     arrival_time LIKE '%$escaped_keyword%' OR 
                                     flight_type LIKE '%$escaped_keyword%' OR 
                                     note LIKE '%$escaped_keyword%'";
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
                            <th><a href='?sort_column=name&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Ime in priimek " . get_sort_icon('name', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=departure_airport&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Letališče odhoda " . get_sort_icon('departure_airport', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=departure_date&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Datum odhoda " . get_sort_icon('departure_date', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=departure_time&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Ura odhoda " . get_sort_icon('departure_time', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=arrival_airport&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Letališče prihoda " . get_sort_icon('arrival_airport', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=arrival_date&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Datum prihoda " . get_sort_icon('arrival_date', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=arrival_time&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Ura pristanka " . get_sort_icon('arrival_time', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=flight_type&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Tip leta " . get_sort_icon('flight_type', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=note&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "'>Opomba " . get_sort_icon('note', $sort_column, $sort_order) . "</a></th>
                            <th>Brisanje</th>
                        </tr>
                    </thead>
                    <tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["name"]."</td>
                        <td>".$row["departure_airport"]."</td>
                        <td>".$row["departure_date"]."</td>
                        <td>".$row["departure_time"]."</td>
                        <td>".$row["arrival_airport"]."</td>
                        <td>".$row["arrival_date"]."</td>
                        <td>".$row["arrival_time"]."</td>
                        <td>".$row["flight_type"]."</td>
                        <td>".$row["note"]."</td>
                        <td><a href='delete_flight.php?id=".$row["id"]."' onclick=\"return confirm('POZOR! Ali ste prepričani za želite izbrisati ta vnos?');\" class='btn btn-secondary'>Izbriši</a></td>
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
