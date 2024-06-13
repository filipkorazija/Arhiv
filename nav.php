<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="https://mos.si">MOS Servis</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="stanovanjaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Stanovanja
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="stanovanjaDropdown">
                        <li><a class="dropdown-item" href="index.php">Vnos novih stanovanj</a></li>
                        <li><a class="dropdown-item" href="display_dn.php">Arhiv stanovanj</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="letiDrzaveDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Leti v države
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="letiDrzaveDropdown">
                        <li><a class="dropdown-item" href="new_flight.php">Vnos novih letov</a></li>
                        <li><a class="dropdown-item" href="display_flights.php">Arhiv letov</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="povratniLetiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Povratni leti
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="povratniLetiDropdown">
                        <li><a class="dropdown-item" href="new_return_flight.php">Vnos povratnih letov</a></li>
                        <li><a class="dropdown-item" href="display_return_flights.php">Arhiv povratnih letov</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center">
                    <span class="navbar-text">Pozdravljen/a, <?php echo $_SESSION['username']; ?> ❘ </span>
                    <a class="nav-link" href="logout.php">Odjava</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Ensure Bootstrap JS and Popper.js are included -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
