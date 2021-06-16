<?php
session_start();
    header("location: index.php");
    unset($_SESSION["name"]);
    unset($_SESSION["loggedin"]);
