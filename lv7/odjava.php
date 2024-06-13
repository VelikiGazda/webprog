<?php
session_start();

// Briši sesiju
session_destroy();

// Preusmjeri na početnu stranicu (index.php)
header("Location: index.php");
exit();
?>
