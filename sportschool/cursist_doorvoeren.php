<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]===false){
        header("location: index.php#sign-in");
    }

    $header = "";
    switch ($_GET["mode"]) {
        case "add":
        $header = 'Location: cursist_toevoegen.php';
        break;
        case "edit":
        $header = 'Location: cursist_aanpassen.php';
        break;
    }

    if(empty($_POST["name1"]) && empty($_POST["name2"])) {
        $_SESSION["error"] = "de voor- en achternaam velden zijn veplicht!";
        header($header);
    }
    else if (empty($_POST["name1"])) {
        $_SESSION["error"] = "voornaam is niet ingevuld";
        header($header);
    }
    else if (empty($_POST["name2"])) {
        $_SESSION["error"] = "achternaam is niet ingevuld";
        header($header);
    }
    else if (!preg_match("/^[a-zA-Z]+$/", $_POST["name1"])) {
        $_SESSION["error"] = "voornaam mag geen cijfers of symbolen bevatten";
        header($header);
    }
    else if (!preg_match("/^[a-zA-Z]+$/", $_POST["name2"])) {
        $_SESSION["error"] = "achternaam mag geen cijfers of symbolen bevatten";
        header($header);
    }
    else {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $database = "database1";
        switch ($_GET["mode"]) {
            case "add":
                $query = "INSERT INTO cursist (idcursist, voornaam, achternaam) VALUES (NULL, '" . $_POST["name1"] . "', '" . $_POST["name2"] . "');";

                $mysqli = new mysqli($servername, $username, $password, $database);
                if ($stmt = $mysqli->prepare($query)) {
                    $stmt->execute();
                }
                $_SESSION["message"] = "cursist " . $_GET["id"] . " is toegevoegd";
                break;
            case "edit":
                $query = "UPDATE cursist SET voornaam='" . $_POST["name1"] .  "', achternaam='" . $_POST["name2"] . "' WHERE idcursist = " . $_GET["id"];

                $mysqli = new mysqli($servername, $username, $password, $database);
                if ($stmt = $mysqli->prepare($query)) {
                    $stmt->execute();
                }

                $_SESSION["message"] = "cursist " . $_GET["id"] . " is aangepast";
                break;
        }
        header('Location: cursisten_tonen.php');
    }
    
