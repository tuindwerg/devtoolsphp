<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Review bevestigen</title> 

        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php 
        // De header word opgenomen in de pagina.
        include "../includes/header/header.php"; 
        ?>

        <div id="inhoud_container">
            <div class="inhoud">
               <?php
                // De connectie met de database word gemaakt.
                $link = databaseConnect();

                // Er word gecontroleerd of de activatiecode al bestaat in de database.
                $activatiecode = $_GET["code"];
                $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE activatiecode = ?");
                mysqli_stmt_bind_param($stmt, "s", $activatiecode);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $activatiecodeBestaat);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);

                // Er wordt gecontroleerd of de code goed is ingevoerd, en als deze voorkomt 
                // in de database, word de status bijgewerkt naar 1 (bevestigd).
                // De gebruiker krijgt hier een melding van te zien.
                if (empty($activatiecode)) {
                    print ("De activatiecode is niet (juist) ingevoerd");
                } elseif ($activatiecodeBestaat) {
                    $stmt = mysqli_prepare($link, "UPDATE review SET status = 1 WHERE activatiecode = ?");
                    mysqli_stmt_bind_param($stmt, "s", $activatiecode);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);

                    print ("<p>Uw review is succesvol ingestuurd en wordt gecontroleerd door de administrator.</p>");
                } else {
                    print ("<p>Uw gegevens zijn niet gevonden. U kunt proberen om een nieuwe review in te sturen via de homepage. "
                            . "Als het probleem dan nog niet opgelost is, kunt u <a href=contact.php>contact</a> met ons opnemen.</p>");
                }
                mysqli_close($link);
                ?>
            </div>
        </div>

        <?php 
        // De footer word opgenomen in de pagina.
        include "../includes/footer/footer.php"; 
        ?>
    </body>
</html>
