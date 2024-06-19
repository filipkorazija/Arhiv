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
    <title>MOS Servis - Arhiv Stanovanj</title>
    
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
        <h2 class="text-center text-2xl font-bold mb-4">Arhiv stanovanj</h2>
        <!-- Search Form -->
        <form method="GET" action="display_dn.php" class="search-form mb-5">
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $country = isset($_GET['country']) ? $_GET['country'] : '';
            $sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'dn';
            $sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
            $filter_by = isset($_GET['filter_by']) ? $_GET['filter_by'] : 'all';
            ?>
            <div class="flex flex-wrap justify-center gap-4">
                <div class="w-full md:w-1/4">
                    <input type="text" name="search" placeholder="Ključne besede" value="<?php echo htmlspecialchars($search); ?>" class="form-input">
                </div>
                <div class="w-full md:w-1/4">
                    <select name="filter_by" class="form-select">
                        <option value="all" <?php echo $filter_by == 'all' ? 'selected' : ''; ?>>Vsi filtri</option>
                        <option value="dn" <?php echo $filter_by == 'dn' ? 'selected' : ''; ?>>DN + VP</option>
                        <option value="naslov_stanovanja" <?php echo $filter_by == 'naslov_stanovanja' ? 'selected' : ''; ?>>Naslov Stanovanja</option>
                        <option value="postna_st" <?php echo $filter_by == 'postna_st' ? 'selected' : ''; ?>>Poštna Št.</option>
                        <option value="kontakt" <?php echo $filter_by == 'kontakt' ? 'selected' : ''; ?>>Kontakt</option>
                        <option value="imena" <?php echo $filter_by == 'imena' ? 'selected' : ''; ?>>Št. oseb</option>
                        <option value="cena_oseba_dan" <?php echo $filter_by == 'cena_oseba_dan' ? 'selected' : ''; ?>>Cena na dan</option>
                        <option value="opombe" <?php echo $filter_by == 'opombe' ? 'selected' : ''; ?>>Opombe</option>
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <select name="country" class="form-select">
                        <option value="">Vse Države</option>
                        <option value="Anglija" <?php echo $country == 'Anglija' ? 'selected' : ''; ?>>Anglija</option>
                        <option value="Avstrija" <?php echo $country == 'Avstrija' ? 'selected' : ''; ?>>Avstrija</option>
                        <option value="Belgija" <?php echo $country == 'Belgija' ? 'selected' : ''; ?>>Belgija</option>
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
                    </select>
                </div>
                <div class="w-full md:w-1/4">
                    <button type="submit" class="form-button">Search</button>
                </div>
            </div>
        </form>
        <?php
        
        // Revised
        include('db.php');
        
        // Base SQL query
        $sql = "SELECT * FROM delovni_nalog";
        
        // Initialize an array to hold the conditions and parameters
        $conditions = [];
        $params = [];
        $types = '';
        
        // Modify SQL query to include search condition if keywords are provided
        if ($search) {
            $escaped_search = '%' . $search . '%';
            if ($filter_by == 'all') {
                $conditions[] = "(dn LIKE ? OR 
                                 naslov_stanovanja LIKE ? OR 
                                 postna_st LIKE ? OR 
                                 kontakt LIKE ? OR 
                                 imena LIKE ? OR 
                                 cena_oseba_dan LIKE ? OR 
                                 st_racuna LIKE ? OR 
                                 opombe LIKE ?)";
                $params = array_fill(0, 8, $escaped_search);
                $types .= str_repeat('s', 8);
            } else {
                $conditions[] = "$filter_by LIKE ?";
                $params[] = $escaped_search;
                $types .= 's';
            }
        }
        if ($country) {
            $conditions[] = "country = ?";
            $params[] = $country;
            $types .= 's';
        }
        
        // Join conditions with AND to ensure all conditions are met
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        
        // Add sorting
        $sql .= " ORDER BY $sort_column $sort_order";
        
        // Prepare statement for total records count
        $stmt = $conn->prepare($sql);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $total_result = $stmt->get_result();
        $total_records = $total_result->num_rows;
        
        // Add limit and offset for pagination
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';
        
        // Prepare statement for the main query with limit and offset
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        
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
                            <th class='border px-4 py-2'><a href='?sort_column=dn&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>DN + VP" . get_sort_icon('dn', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=naslov_stanovanja&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Naslov Stanovanja " . get_sort_icon('naslov_stanovanja', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=postna_st&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Poštna Št. " . get_sort_icon('postna_st', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=kontakt&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Kontakt " . get_sort_icon('kontakt', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=imena&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Št. oseb " . get_sort_icon('imena', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=cena_oseba_dan&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Cena na dan " . get_sort_icon('cena_oseba_dan', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=opombe&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Opombe " . get_sort_icon('opombe', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'><a href='?sort_column=country&sort_order=$next_sort_order&search=" . urlencode($search) . "&country=" . urlencode($country) . "&filter_by=$filter_by'>Država " . get_sort_icon('country', $sort_column, $sort_order) . "</a></th>
                            <th class='border px-4 py-2'>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr data-id='".$row["id"]."'>
                        <td class='border px-4 py-2 editable' data-field='dn'>".$row["dn"]."</td>
                        <td class='border px-4 py-2 editable' data-field='naslov_stanovanja'>".$row["naslov_stanovanja"]."</td>
                        <td class='border px-4 py-2 editable' data-field='postna_st'>".$row["postna_st"]."</td>
                        <td class='border px-4 py-2 editable' data-field='kontakt'>".$row["kontakt"]."</td>
                        <td class='border px-4 py-2 editable' data-field='imena'>".$row["imena"]."</td>
                        <td class='border px-4 py-2 editable' data-field='cena_oseba_dan'>".$row["cena_oseba_dan"]."</td>
                        <td class='border px-4 py-2 editable' data-field='opombe'>".$row["opombe"]."</td>
                        <td class='border px-4 py-2 editable' data-field='country'>".$row["country"]."</td>
                        <td class='border px-4 py-2'>
                            <button class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded edit-btn'>Edit</button>
                            <a href='delete_dn.php?id=".$row["id"]."' onclick=\"return confirm('POZOR! Ali ste prepričani za želite izbrisati ta vnos?');\" class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Delete</a>
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
                echo '<li class="page-item"><a class="page-link" href="?page=1&search='.urlencode($search).'&country='.urlencode($country).'&filter_by='.$filter_by.'&sort_column='.$sort_column.'&sort_order='.$sort_order.'" aria-label="First"><span aria-hidden="true">&laquo;&laquo;</span></a></li>';
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
                fetch(`update_dn.php?id=${id}`, {
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
