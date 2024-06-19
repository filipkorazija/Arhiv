<?php
include('db.php');
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
    <title>MOS Servis - Arhiv Povratnih Letov</title>
    
    <!-- Tailwind CSS CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/utils/style.css?v=1.1">
    <style>
        .form-input, .form-select, .form-button {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
        }
        .form-button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        .form-button:hover {
            background-color: #0056b3;
        }
        .pagination {
            display: flex;
            justify-content: center;
            padding: 1rem;
        }
        .page-item {
            margin: 0 0.25rem;
        }
        .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            color: #007bff;
            text-decoration: none;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        .page-item.active .page-link {
            z-index: 1;
            color: white;
            background-color: #007bff;
            border-color: #007bff;
        }
        .alert-warning {
            background-color: #ffebcc;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 1rem;
            border-radius: 0.25rem;
            margin-top: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container mx-auto mt-5">
        <h2 class="text-center text-2xl font-bold mb-4">Arhiv povratnih letov</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <!-- Search Form -->
        <form method="GET" action="display_return_flights.php" class="search-form mb-5">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $country = isset($_GET['country']) ? $_GET['country'] : '';
            $filter_by = isset($_GET['filter_by']) ? $_GET['filter_by'] : 'all';
            $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'name';
            $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
            ?>
            <div class="flex flex-wrap justify-center gap-4">
                <div class="w-full md:w-1/4">
                    <input type="text" name="search" placeholder="Ključne besede" value="<?php echo htmlspecialchars($search); ?>" class="form-input">
                </div>
                <div class="w-full md:w-1/4">
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
                <div class="w-full md:w-1/4">
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
                        <option value="US-Memphis" <?php echo $country == 'US-Memphis' ? 'selected' : ''; ?>>US - Memphis</option>
                        <option value="US-Chicago" <?php echo $country == 'US-Chicago' ? 'selected' : ''; ?>>US - Chicago</option>
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <button type="submit" class="form-button">Search</button>
                </div>
            </div>
        </form>

        <?php
        // Split the search string into an array of keywords
        $keywords = array_map('trim', explode(',', $search));

        // Base SQL query
        $sql = "SELECT * FROM return_flights";

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

        // Join conditions with AND to include any record that matches any keyword
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        // Add sorting
        $sql .= " ORDER BY $sort_column $sort_order";

        // Get total number of records
        $total_result = $conn->query($sql);
        if (!$total_result) {
            die('Query Error: ' . $conn->error);
        }
        $total_records = $total_result->num_rows;

        // Add limit and offset for pagination
        $sql .= " LIMIT $limit OFFSET $offset";

        $result = $conn->query($sql);
        if (!$result) {
            die('Query Error: ' . $conn->error);
        }

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
            echo "<div class='overflow-x-auto'><table class='min-w-full bg-white border-collapse'>
                    <thead>
                        <tr>
                            <th class='border px-4 py-2'><a href='?sort_column=name&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Ime in priimek " . get_sort_icon('name', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=departure_airport&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Letališče odhoda " . get_sort_icon('departure_airport', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=departure_date&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Datum odhoda " . get_sort_icon('departure_date', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=departure_time&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Ura odhoda " . get_sort_icon('departure_time', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=arrival_airport&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Letališče prihoda " . get_sort_icon('arrival_airport', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=arrival_date&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Datum prihoda " . get_sort_icon('arrival_date', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=arrival_time&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Ura pristanka " . get_sort_icon('arrival_time', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=flight_type&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Tip leta " . get_sort_icon('flight_type', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=note&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Opomba " . get_sort_icon('note', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr data-id='".$row["id"]."'>
                        <td class='border px-4 py-2 editable' data-field='name'>".$row["name"]."</td>
                        <td class='border px-4 py-2 editable' data-field='departure_airport'>".$row["departure_airport"]."</td>
                        <td class='border px-4 py-2 editable' data-field='departure_date'>".$row["departure_date"]."</td>
                        <td class='border px-4 py-2 editable' data-field='departure_time'>".$row["departure_time"]."</td>
                        <td class='border px-4 py-2 editable' data-field='arrival_airport'>".$row["arrival_airport"]."</td>
                        <td class='border px-4 py-2 editable' data-field='arrival_date'>".$row["arrival_date"]."</td>
                        <td class='border px-4 py-2 editable' data-field='arrival_time'>".$row["arrival_time"]."</td>
                        <td class='border px-4 py-2 editable' data-field='flight_type'>".$row["flight_type"]."</td>
                        <td class='border px-4 py-2 editable' data-field='note'>".$row["note"]."</td>
                        <td class='border px-4 py-2'>
                            <button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded edit-btn'>Edit</button>
                            <a href='delete_return_flight.php?id=".$row["id"]."' onclick=\"return confirm('POZOR! Ali ste prepričani za želite izbrisati ta vnos?');\" class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Delete</a>
                        </td>
                      </tr>";
            }
            echo "</tbody></table></div>";

            echo "<div class='flex justify-center items-center mt-4'>";

            // Pagination logic
            $total_pages = ceil($total_records / $limit);
            $visible_pages = 5; // Number of pages to show in pagination
            $start_page = max(1, $page - floor($visible_pages / 2));
            $end_page = min($total_pages, $start_page + $visible_pages - 1);

            if ($end_page - $start_page + 1 < $visible_pages) {
                $start_page = max(1, $end_page - $visible_pages + 1);
            }

            echo '<nav>';
            echo '<ul class="pagination flex justify-center mb-0">';

            // First and Previous arrows
            if ($page > 1) {
                echo '<li class="page-item"><a class="page-link" href="?page=1&search='.urlencode($search).'&country='.urlencode($country).'&sort_column='.$sort_column.'&sort_order='.$sort_order.'&filter_by='.$filter_by.'" aria-label="First"><span aria-hidden="true">&laquo;&laquo;</span></a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page='.($page-1).'&search='.urlencode($search).'&country='.urlencode($country).'&filter_by='.$filter_by.'&sort_column='.$sort_column.'&sort_order='.$sort_order.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
            }

            // Pagination links
            for ($i = $start_page; $i <= $end_page; $i++) {
                echo '<li class="page-item'.($i == $page ? ' active' : '').'">';
                echo '<a class="page-link" href="?page='.$i.'&search='.urlencode($search).'&country='.urlencode($country).'&filter_by='.$filter_by.'&sort_column='.$sort_column.'&sort_order='.$sort_order.'">'.$i.'</a>';
                echo '</li>';
            }

            // Next and Last arrows
            if ($page < $total_pages) {
                echo '<li class="page-item"><a class="page-link" href="?page='.($page+1).'&search='.urlencode($search).'&country='.urlencode($country).'&filter_by='.$filter_by.'&sort_column='.$sort_column.'&sort_order='.$sort_order.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'&search='.urlencode($search).'&country='.urlencode($country).'&filter_by='.$filter_by.'&sort_column='.$sort_column.'&sort_order='.$sort_order.'" aria-label="Last"><span aria-hidden="true">&raquo;&raquo;</span></a></li>';
            }

            echo '</ul>';
            echo '</nav>';
            echo '</div>';
        } else {
            echo "<div class='alert-warning'>Podatki z temi parametri ne obstajajo!</div>";
        }
        $conn->close();
        ?>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.2/alpine.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                    cell.innerHTML = `<input type="text" class="form-input w-full" name="${field}" value="${value}">`;
                });
            } else {
                const id = row.getAttribute('data-id');
                const data = {};
                row.querySelectorAll('.editable input').forEach(input => {
                    const field = input.getAttribute('name');
                    data[field] = input.value;
                });
                fetch(`update_return_flight.php?id=${id}`, {
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
