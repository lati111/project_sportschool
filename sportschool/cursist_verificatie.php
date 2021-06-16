<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]===false){
        header("location: index.php#sign-in");
    }

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $database = "database1";

    $qry = "SELECT wachtwoord FROM user WHERE gebruikersnaam = '";
    $qry .= $_POST["username"] . "'";
    $passHash = "";

    $captchaResult = false;
    $pattern = "";

    switch ($_POST["captchaType"]) {
        case "upperOnly":
            $pattern = "/[a-z0-9]+/";
        break;
        case "lowerOnly":
            $pattern = "/[A-Z0-9]+/";
            break;
        case "numberOnly":
            $pattern = "/[a-zA-Z]+/";
            break;
        case "noNumbers":
            $pattern = "/[0-9]+/";
            break;
        case "noLower":
            $pattern = "/[a-z]+/";
            break;
        case "noUpper":
            $pattern = "/[A-Z]+/";
            break;
    }

    $captchaAnswer = preg_filter($pattern, '', $_POST["captchaString"]);
//    $_SESSION["message"] = "answer:" . $captchaAnswer . " - input:" . $_POST["captchaInput"] . " - type:" . $_POST["captchaType"];
    if ($_POST["captchaInput"] === $captchaAnswer) {
        $mysqli = new mysqli($servername, $username, $password, $database);
        $stmt = $mysqli->prepare($qry);
        $stmt->execute();
        $stmt->bind_result($pass);
        while ($stmt->fetch()) {
            $passHash = password_hash($pass, PASSWORD_DEFAULT );
        }
        $stmt->close();

        if (password_verify($_POST["password"], $passHash) === true) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $_POST["username"];
            header("Location: cursisten_tonen.php");
        } else if (password_verify($_POST["password"], $passHash) === false) {
            header("index.php#sign-in");
        } else {
            echo "Error in contacting database";
        }
    } else {
        $_SESSION["error"] = "captcha was wrong!";
        header("location: index.php#sign-in");
    }

