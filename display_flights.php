<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$limit = 20; // Number of entries to show per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MOS Servis - Arhiv Letov</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container mt-5">
        <h2 class="text-center">Arhiv letov</h2>
        <!-- Search Form -->
        <form method="GET" action="display_flights.php" class="mb-3">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $country = isset($_GET['country']) ? $_GET['country'] : '';
            $filter_by = isset($_GET['filter_by']) ? $_GET['filter_by'] : 'all';
            $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'name';
            $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
            ?>
            <div class="row justify-content-center g-4">
                <div class="col-md-4">
                    <input type="text" name="search" placeholder="Ključne besede" value="<?php echo htmlspecialchars($search); ?>" class="form-control">
                </div>
                <div class="col-md-3">
                    <select name="filter_by" class="form-select">
                        <option value="all" <?php echo $filter_by == 'all' ? 'selected' : ''; ?>>Vsi stolpci</option>
                        <option value="name" <?php echo $filter_by == 'name' ? 'selected' : ''; ?>>Ime in priimek</option>
                        <option value="departure_airport" <?php echo $filter_by == 'departure_airport' ? 'selected' : ''; ?>>Letališče odhoda</option>
                        <option value="departure_date" <?php echo $filter_by == 'departure_date' ? 'selected' : ''; ?>>Datum odhoda</option>
                        <option value="departure_time" <?php echo $filter_by == 'departure_time' ? 'selected' : ''; ?>>Ura odhoda</option>
                        <option value="arrival_airport" <?php echo $filter_by == 'arrival_airport' ? 'selected' : ''; ?>>Letališče prihoda</option>
                        <option value="arrival_date" <?php echo $filter_by == 'arrival_date' ? 'selected' : ''; ?>>Datum prihoda</option>
                        <option value="arrival_time" <?php echo $filter_by == 'arrival_time' ? 'selected' : ''; ?>>Ura pristanka</option>
                        <option value="flight_type" <?php echo $filter_by == 'flight_type' ? 'selected' : ''; ?>>Tip leta</option>
                        <option value="note" <?php echo $filter_by == 'note' ? 'selected' : ''; ?>>Opomba</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="country" class="form-select">
                        <option value="">Vse Države</option>
                        <option value="AT-Dunaj" <?php echo $country == 'AT-Dunaj' ? 'selected' : ''; ?>>AT - Dunaj</option>
                        <option value="AT-Graz" <?php echo $country == 'AT-Graz' ? 'selected' : ''; ?>>AT - Graz</option>
                        <option value="HR-Zagreb" <?php echo $country == 'HR-Zagreb' ? 'selected' : ''; ?>>HR - Zagreb</option>
                        <option value="CA-Toronto" <?php echo $country == 'CA-Toronto' ? 'selected' : ''; ?>>CA - Toronto</option>
                        <option value="CA-Montreal" <?php echo $country == 'CA-Montreal' ? 'selected' : ''; ?>>CA - Montreal</option>
                        <option value="DE-Frankfurt" <?php echo $country == 'DE-Frankfurt' ? 'selected' : ''; ?>>DE - Frankfurt</option>
                        <option value="US-Greenville" <?php echo $country == 'US-Greenville' ? 'selected' : ''; ?>>US - Greenville SC</option>
                        <option value="US-Guatemala" <?php echo $country == 'US-Guatemala' ? 'selected' : ''; ?>>US - Guatemala</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
        <?php
        include('db.php');

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
                    if ($filter_by == 'all') {
                        $conditions[] = "name LIKE '%$escaped_keyword%' OR 
                                         departure_airport LIKE '%$escaped_keyword%' OR 
                                         departure_date LIKE '%$escaped_keyword%' OR 
                                         departure_time LIKE '%$escaped_keyword%' OR 
                                         arrival_airport LIKE '%$escaped_keyword%' OR 
                                         arrival_date LIKE '%$escaped_keyword%' OR 
                                         arrival_time LIKE '%$escaped_keyword%' OR 
                                         flight_type LIKE '%$escaped_keyword%' OR 
                                         note LIKE '%$escaped_keyword%'";
                    } else {
                        $conditions[] = "$filter_by LIKE '%$escaped_keyword%'";
                    }
                }
            }
        }
        if ($country) {
            $escaped_country = $conn->real_escape_string($country);
            $conditions[] = "country = '$escaped_country'";
        }

        // Join conditions with OR to include any record that matches any keyword
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        // Add sorting
        $sql .= " ORDER BY $sort_column $sort_order";

        // Get total number of records
        $total_result = $conn->query($sql);
        $total_records = $total_result->num_rows;

        // Add limit and offset for pagination
        $sql .= " LIMIT $limit OFFSET $offset";

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
            echo "<div class='table-responsive'><table class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th><a href='?sort_column=name&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Ime in priimek " . get_sort_icon('name', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=departure_airport&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Letališče odhoda " . get_sort_icon('departure_airport', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=departure_date&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Datum odhoda " . get_sort_icon('departure_date', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=departure_time&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Ura odhoda " . get_sort_icon('departure_time', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=arrival_airport&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Letališče prihoda " . get_sort_icon('arrival_airport', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=arrival_date&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Datum prihoda " . get_sort_icon('arrival_date', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=arrival_time&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Ura pristanka " . get_sort_icon('arrival_time', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=flight_type&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Tip leta " . get_sort_icon('flight_type', $sort_column, $sort_order) . "</a></th>
                            <th><a href='?sort_column=note&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Opomba " . get_sort_icon('note', $sort_column, $sort_order) . "</a></th>
                            <th>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr data-id='".$row["id"]."'>
                        <td class='editable' data-field='name'>".$row["name"]."</td>
                        <td class='editable' data-field='departure_airport'>".$row["departure_airport"]."</td>
                        <td class='editable' data-field='departure_date'>".$row["departure_date"]."</td>
                        <td class='editable' data-field='departure_time'>".$row["departure_time"]."</td>
                        <td class='editable' data-field='arrival_airport'>".$row["arrival_airport"]."</td>
                        <td class='editable' data-field='arrival_date'>".$row["arrival_date"]."</td>
                        <td class='editable' data-field='arrival_time'>".$row["arrival_time"]."</td>
                        <td class='editable' data-field='flight_type'>".$row["flight_type"]."</td>
                        <td class='editable' data-field='note'>".$row["note"]."</td>
                        <td>
                            <button class='btn btn-primary btn-sm edit-btn'>Edit</button>
                            <a href='delete_flight.php?id=".$row["id"]."' onclick=\"return confirm('POZOR! Ali ste prepričani za želite izbrisati ta vnos?');\" class='btn btn-danger btn-sm'>Izbriši</a>
                        </td>
                      </tr>";
            }
            echo "</tbody></table></div>";

            // Pagination logic
            $total_pages = ceil($total_records / $limit);
            $visible_pages = 5; // Number of pages to show in pagination
            $start_page = max(1, $page - floor($visible_pages / 2));
            $end_page = min($total_pages, $start_page + $visible_pages - 1);

            if ($end_page - $start_page + 1 < $visible_pages) {
                $start_page = max(1, $end_page - $visible_pages + 1);
            }

            echo '<nav>';
            echo '<ul class="pagination justify-content-center">';

            // First and Previous arrows
            if ($page > 1) {
                echo '<li class="page-item"><a class="page-link" href="?page=1&search='.urlencode($search).'&country='.urlencode($country).'&sort_column='.$sort_column.'&sort_order='.$sort_order.'&filter_by='.$filter_by.'" aria-label="First"><span aria-hidden="true">&laquo;&laquo;</span></a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'&search='.urlencode($search).'&country='.urlencode($country).'&sort_column='.$sort_column.'&sort_order='.$sort_order.'&filter_by='.$filter_by.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
            }

            // Pagination links
            for ($i = $start_page; $i <= $end_page; $i++) {
                echo '<li class="page-item'.($i == $page ? ' active' : '').'">';
                echo '<a class="page-link" href="?page='.$i.'&search='.urlencode($search).'&country='.urlencode($country).'&sort_column='.$sort_column.'&sort_order='.$sort_order.'&filter_by='.$filter_by.'">'.$i.'</a>';
                echo '</li>';
            }

            // Next and Last arrows
            if ($page < $total_pages) {
                echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'&search='.urlencode($search).'&country='.urlencode($country).'&sort_column='.$sort_column.'&sort_order='.$sort_order.'&filter_by='.$filter_by.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'&search='.urlencode($search).'&country='.urlencode($country).'&sort_column='.$sort_column.'&sort_order='.$sort_order.'&filter_by='.$filter_by.'" aria-label="Last"><span aria-hidden="true">&raquo;&raquo;</span></a></li>';
            }

            echo '</ul>';
            echo '</nav>';
        } else {
            echo "<div class='alert alert-warning'>Podatki z temi parametri ne obstajajo!</div>";
        }
        $conn->close();
        ?>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            if (this.textContent === 'Edit') {
                this.textContent = 'Save';
                row.querySelectorAll('.editable').forEach(cell => {
                    const field = cell.getAttribute('data-field');
                    const value = cell.textContent;
                    cell.innerHTML = `<input type="text" class="form-control" name="${field}" value="${value}">`;
                });
            } else {
                const id = row.getAttribute('data-id');
                const data = {};
                row.querySelectorAll('.editable input').forEach(input => {
                    const field = input.getAttribute('name');
                    data[field] = input.value;
                });
                fetch(`update_flight.php?id=${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.querySelectorAll('.editable').forEach(cell => {
                            const field = cell.getAttribute('data-field');
                            cell.textContent = data.data[field];
                        });
                        this.textContent = 'Edit';
                    } else {
                        alert('Error updating data: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});

    </script>
</body>
</html>
