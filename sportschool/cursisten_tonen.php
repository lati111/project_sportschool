<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]===false){
        header("location: index.php#sign-in");
    }

    $err = "";
    $content = "";
	if(isset($_GET["error"])){
		$err = $_GET["error"];
	}

$data = [];
$servername = "localhost";
$username = "root";
$password = "root";
$database = "database1";

    $qry = "SELECT idcursist, voornaam, achternaam FROM cursist ORDER BY achternaam;";

    $mysqli = new mysqli($servername, $username, $password, $database);
    if ($stmt = $mysqli->prepare($qry)) {
        $stmt->execute();
        $stmt->bind_result($id, $firstName, $lastName);
        while ($stmt->fetch()) {
            $data[] = [$id, $firstName, $lastName];
        }
    } else {
        echo "Error in the SQL-statement: " . $mysqli->error;
    }

?>

<!doctype html>
<html lang="nl">
	<head>
		<meta charset="utf-8" />
		<title>Cursisten</title>

        <link rel="stylesheet" href="css/base.css">
	</head>
	<body>
    <div id="header">
        <a href="index.php" id="homeButton"><button>home</button></a>
        <h1>Cursisten administratie</h1>
        <h2>Lijst van cursisten</h2>
    </div>

    <div id="container">
        <div id="logIn">
            Je bent ingelogd als <i><?php echo $_SESSION["name"]; ?></i>
            <br>
            <a href='cursist_logout.php'>Log uit</a>
        </div>

        <?php
        if (!empty($_SESSION["message"])) {
            echo "<div class='message'>" . $_SESSION["message"] . "</div>";
            unset( $_SESSION["message"]);
        }
        else if (!empty($_SESSION["error"])) {
            echo "<div class='error'>" . $_SESSION["error"] . "</div>";
            unset( $_SESSION["error"]);
        }

        //    begin table
        echo "<table>";
        for ($x = 0; $x < count($data); $x++) {
            $info = $data[$x];
            echo "<tr>";
            echo "<td>" . htmlspecialchars($info[1]) . "</td>";
            echo "<td>" . htmlspecialchars($info[2]) . "</td>";
            $additions = "<a href='cursist_aanpassen.php?id=" . htmlspecialchars($info[0]) . "'>wijzigen</a>";
            $additions .= " - ";
            $additions .= "<a href='cursist_aanpassen.php?id=" . htmlspecialchars($info[0]) . "'>aanpassen</a>";
            $additions .= " - ";
            $additions .= "<a href='cursist_verwijderen.php?id=" . htmlspecialchars($info[0]) . "'>verwijderen</a>";
            echo "<td class='tableAddition'>" . $additions . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
        <div style="margin-top: 5px">
            <a href='cursist_toevoegen.php'>voeg cursist toe</a>
            <br>

        </div>
    </div>
	</body>
</html>