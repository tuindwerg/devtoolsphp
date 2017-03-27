<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Template</title> <!-- Aanpassen -->

        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="template.css"> <!-- Aanpassen -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php include "../../includes/header/header.php"; ?>

        <div id="inhoud_container">
            <div class="inhoud">
                <?php
                $link = databaseConnect();

                $activatiecode = $_GET["code"];

                $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE activatiecode = ? AND status= 0");
                mysqli_stmt_bind_param($stmt, "s", $activatiecode);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $activatiecodeBestaat);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);

                $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE activatiecode = ? AND status= 1");
                mysqli_stmt_bind_param($stmt, "s", $activatiecode);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $proeflesBevestigd);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);

                $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE activatiecode = ? AND status= 2");
                mysqli_stmt_bind_param($stmt, "s", $activatiecode);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $proeflesGehad);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);

                if (empty($activatiecode)) {
                    print ("De activatiecode is niet ingevoerd");
                } elseif ($proeflesBevestigd) {
                    print ("U heeft zich al aangemeld voor een proefles, er wordt z.s.m. contact met u opgenomen. U kunt ook <a href='../../contact/'>contact</a> met ons opnemen.");
                } elseif ($proeflesGehad) {
                    print ("Volgens ons systeem is de proefles al ingepland. Indien dit niet het geval is, kunt u <a href='../../contact/'>contact</a> met ons opnemen. ");
                } elseif ($activatiecodeBestaat) {

                    $stmt = mysqli_prepare($link, "UPDATE proefles SET status = 1 WHERE activatiecode = ?");
                    mysqli_stmt_bind_param($stmt, "s", $activatiecode);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);

                    print ("<p>Uw proefles aanvraag is bevestigd. Er wordt z.s.m. contact met u opgenomen.</p>");
                } else {
                    print ("<p>Uw gegevens zijn niet gevonden. U kunt proberen om u nog een keer <a href=../>aan te melden</a>. "
                            . "Als het probleem dan nog niet opgelost is, kunt u <a href='../../contact/'>contact</a> met ons opnemen.</p>");
                }


                mysqli_close($link);
                ?>
            </div>
        </div>

        <?php include "../../includes/footer/footer.php"; ?>
    </body>
</html>
