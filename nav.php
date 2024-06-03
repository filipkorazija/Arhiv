<nav class="navbar">
    <ul class="navbar-list">
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Stanovanja</a>
            <div class="dropdown-content">
                <a href="index.php">Vnos novih stanovanj</a>
                <a href="display_dn.php">Arhiv stanovanj</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Leti v države</a>
            <div class="dropdown-content">
                <a href="new_flight.php">Vnos novih letov</a>
                <a href="display_flights.php">Arhiv letov</a>
            </div>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Povratni leti</a>
            <div class="dropdown-content">
                <a href="new_return_flight.php">Vnos povratnih letov</a>
                <a href="display_return_flights.php">Arhiv povratnih letov</a>
            </div>
        </li>
        <li class="navbar-right">
            Pozdravljen, <?php echo $_SESSION['username'];?> | <a href="logout.php">Odjava</a>
        </li>
    </ul>
</nav>

