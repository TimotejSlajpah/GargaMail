<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="loading.css">
</head>
<body>
    <?php   

        $direktorij = "uploads/";
        $dokument = $direktorij . basename($_FILES["datoteka"]["name"]);
        $uploadano = 1;
        $tipDokumenta = strtolower(pathinfo($dokument,PATHINFO_EXTENSION));
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["datoteka"]["tmp_name"]);
        if($check !== false) {
            $uploadano = 1;
        } else {
            $uploadano = 0;
        }
        }

        if ($_FILES["datoteka"]["size"] > 2000000) {
            echo "Datoteka je prevelika";
            $uploadano = 0;
        }

        else {
            if (move_uploaded_file($_FILES["datoteka"]["tmp_name"], $dokument)) {
            echo "Dokument ". htmlspecialchars( basename( $_FILES["datoteka"]["name"])). " je bil prenešen.";
            } else {
            echo "Error.";
            }
        }

        $tekst = "";
        $newURL = 'site.php';
        $zadeva = $_POST['zadeva'];
        $tekst = $_POST['tekst'];
        $CC = $_POST['CC'];
        $email = $_SESSION["email"];
        $geslo = $_SESSION["geslo"];
        $za = $_POST['za'];

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        
        require 'plugins/PHPMailer-master/src/Exception.php';
        require 'plugins/PHPMailer-master/src/PHPMailer.php';
        require 'plugins/PHPMailer-master/src/SMTP.php';

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $email;
            $mail->Password = $geslo;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->AllowEmpty = true;



            $mail->setFrom($email);
            $mail->AddAddress($za);
            if(!empty($CC)){$mail->addCC($CC);}
            if($dokument != "uploads/"){$mail->addAttachment($dokument);}
            $mail->WordWrap = 78;



            $mail->isHTML(true);
            $mail->Subject = $zadeva;
            $mail->Body = $tekst;

            $mail->send();
        } catch (Exception $e) {
            echo "Error: {$mail->ErrorInfo}";
        }
        
    ?>
    <script>
        window.location = "site.php"

    </script>

</body>
</html>