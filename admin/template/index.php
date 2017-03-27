<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>T.H. Sport - Admin - Template</title> <!-- Aanpassen -->

        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/admin.css">
        <link rel="stylesheet" type="text/css" href="template.css"> <!-- Aanpassen -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php
        if (!isset($_SESSION["gebruiker"])) {
            print ("<script>window.open('/admin/', '_self')</script>"); // Word doorverwezen naar inlog-pagina
        }

        include "../../includes/functies.php";
        ?>

        <div id="bodycontainer">
            <?php include "../includes/adminmenu.php"; ?>
            <div id="inhoud">

                <!-- Inhoud begin -->
                <h1>Administrator omgeving T.H. Sport</h1>
                <h2>Template pagina</h2>
                <p>Blablabla.</p>
                <!-- Inhoud eind -->

            </div>
        </div>
    </body>
</html>
