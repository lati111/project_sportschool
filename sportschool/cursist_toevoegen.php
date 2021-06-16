<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]===false){
        header("location: index.php#sign-in");
    }
?>
<!doctype html>
<html lang="nl">
	<head>
		<meta charset="utf-8" />
		<title>Cursist toevoegen</title>
        <link rel="stylesheet" href="css/base.css">
        <style>
            td {
                border: none;
            }
            .error {
                color: red;
            }
        </style>
	</head>
	<body>
    <div id="header">
        <h1>Cursisten administratie</h1>
        <h2>Voeg cursist toe</h2>
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

        <form action="cursist_doorvoeren.php?mode=add" method="post">
            <table>
                <tr>
                    <td> <label for="">voornaam:</label> </td>
                    <td> <input type="text" name="name1"> </td>
                </tr>
                <tr>
                    <td> <label for="name2">achternaam:</label> </td>
                    <td> <input type="text" name="name2"> </td>
                </tr>
                <tr>
                    <td><input type="submit"></td>
                    <td><a href="cursisten_tonen.php"><button>cancel</button></a></td>
                </tr>
            </table>
        </form>
    </div>
	</body>
</html>