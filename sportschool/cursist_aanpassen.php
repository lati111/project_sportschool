<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]===false){
        header("location: index.php#sign-in");
    }

    $content = "";
    if (!empty($_GET["id"])) {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $database = "database1";

        $name1 = "";
        $name2 = "";

        $query = "SELECT voornaam, achternaam FROM cursist WHERE idcursist = " . $_GET["id"];

        $mysqli = new mysqli($servername, $username, $password, $database);
        if ($stmt = $mysqli->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($name1, $name2);
            $stmt->fetch();
        }
    }
    else {
        header("location", "cursist_aanpassen.php");
    }
?>
<!doctype html>
<html lang="nl">
	<head>
		<meta charset="utf-8" />
		<title>Cursist aanpassen</title>

        <link rel="stylesheet" href="css/base.css">
        <style>
            td {
                border: none;
            }
        </style>
	</head>
	<body>
    <div id="header">
        <h1>Cursisten administratie</h1>
        <h2>pas cursist aan</h2>
    </div>
    <div id="container">
        <?php
        if (!empty($_SESSION["message"])) {
            echo "<div class='message'>" . $_SESSION["message"] . "</div>";
            unset( $_SESSION["message"]);
        }
        else if (!empty($_SESSION["error"])) {
            echo "<div class='error'>" . $_SESSION["error"] . "</div>";
            unset( $_SESSION["error"]);
        }
        ?>

        <form action="cursist_doorvoeren.php?id=<?php echo $_GET["id"] ?>&mode=edit" method="post">
            <table>
                <tr>
                    <td> <label for="">voornaam:</label> </td>
                    <td> <input type="text" name="name1" value="<?php echo $name1 ?>"> </td>
                </tr>
                <tr>
                    <td> <label for="name2">achternaam:</label> </td>
                    <td> <input type="text" name="name2" value="<?php echo $name2 ?>"> </td>
                </tr>
                <tr>
                    <td><input type="submit"></td>
                    <td><a href="cursisten_tonen.php?mode='edit'"><button>cancel</button></a></td>
                </tr>
            </table>
        </form>
    </div>
	</body>
</html>