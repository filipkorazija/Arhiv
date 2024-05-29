<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <ul class="navbar-list">
        <li><a href="index.php">Vnos novih stanovanj</a></li>
        <li><a href="display_dn.php">Arhiv stanovanj</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li class="navbar-right">Pozdravljen, <?php echo htmlspecialchars($_SESSION['username']); ?></li>
            <li class="navbar-right"><a href="logout.php">Odjava</a></li>
        <?php else: ?>
            <li class="navbar-right"><a href="login.php">Prijava</a></li>
        <?php endif; ?>
    </ul>
</nav>
