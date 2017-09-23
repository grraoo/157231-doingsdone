<?php
$con = mysqli_connect("localhost", "root", "", "schema");
$dbConError = false;

if(!$con) {
    $dbConError = mysqli_connect_error();
    print(renderTemplate('templates/error.php', ['dbConError' => $dbConError]));
    exit;
}?>
