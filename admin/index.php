<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Admin</title>

        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="admin.css">
        <link rel="stylesheet" type="text/css" href="index.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
        include "../includes/functies.php";
        // als gebruiker al bestaat. en gebruiker bestaat alleen als die al is ingelogt. Dan word die met een script automatisch doorgestuurd naar de overzichtpagina.
        if (isset($_SESSION["gebruiker"])) {
            print ("<script>window.open('/admin/overzicht/', '_self')</script>"); // Word doorverwezen naar admin-pagina
        }
        ?>
        <div class="bodycontainer">
            <div class="inhoud" align="center">
                <h1>Administrator omgeving T.H. Sport</h1>
                <div class="content admin_content border">
                    <form method="post">
                        <table>
                            <tr>
                                <td>Gebruikersnaam:</td>
                                <td><input type="text" name="gebruikersnaam" required="required" size="15"></td>
                            </tr>
                            <tr>
                                <td>Wachtwoord:</td>
                                <td><input type="password" name="wachtwoord" required="required" size="15"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" name="login" value="Login"/></td>
                            </tr>
                        </table>
                    </form>
                </div>

                <?php
// dit is de gedeelde of we kijken of de ingevoerde gegevens van boven kloppen
                if (isset($_POST['login'])) {
                    $link = databaseConnect();

                    $user = $_POST["gebruikersnaam"];
                    $pass = $_POST["wachtwoord"];
// We Gaan eerst kijken of de gebruikersnaam en wachtwoord kloppen in de database.
                    $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM beheerder WHERE gebruikersnaam=? AND wachtwoord=MD5(?)");
                    mysqli_stmt_bind_param($stmt, "ss", $user, $pass);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $combinatieBestaat);
                    mysqli_stmt_fetch($stmt);

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                    mysqli_close($link);

                    if ($combinatieBestaat) { // Ingevoerde gebruikersnaam en wachtwoord is gevonden in de database
                        $_SESSION['gebruiker'] = $user;
                        print ("<script>window.open('/admin/overzicht/', '_self')</script>"); // Word doorverwezen naar admin-pagina
                    } else {// als gegevens niet zijn gevonden.
                        print ("<script>alert('Gebruikersnaam of wachtwoord incorrect. Probeer het opnieuw.')</script>"); // komt een alert dat gegevens niet kloppen.
                    }
                }
                ?>
            </div>
        </div>
    </body>
</html>
