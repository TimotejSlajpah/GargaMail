<?php
    $direktorij = "uploads/";
    $dokument = $direktorij . basename($_FILES["datoteka"]["name"]);
    $uploadano = 1;
    $tipDokumenta = strtolower(pathinfo($dokument,PATHINFO_EXTENSION));
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadano = 1;
    } else {
        $uploadano = 0;
    }
    }

    if ($_FILES["fileToUpload"]["size"] > 2000000) {
        echo "Datoteka je prevelika";
        $uploadano = 0;
      }

      else {
        if (move_uploaded_file($_FILES["datoteka"]["tmp_name"], $dokument)) {
          echo "Dokument ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " je bil prenešen.";
        } else {
          echo "Error.";
        }
      }





?>