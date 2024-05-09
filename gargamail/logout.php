    <?php
        session_start();
        $newURL = "login_front.php";
        session_unset();
        session_destroy();
        header('Location:'. $newURL);
    ?>