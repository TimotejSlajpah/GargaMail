<?php
    session_start();
    $_SESSION["email"] = $_POST['email'];
    $_SESSION["geslo"] = $_POST['geslo'];
    header('Location: site.php');
?>