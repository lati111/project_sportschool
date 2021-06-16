<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]===false){
        header("location: index.php#sign-in");
    }

if (!empty($_GET["id"])) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $database = "database1";

    $name1 = "";
    $name2 = "";

    $query = "DELETE FROM cursist WHERE idcursist = " . $_GET["id"];

    $mysqli = new mysqli($servername, $username, $password, $database);
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->execute();
        $stmt->close();

        $_SESSION["message"] = "cursist " . $_GET["id"] . " is verwijderd";
        header('Location: cursisten_tonen.php');
    }
}