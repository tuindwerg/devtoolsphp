<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>T.H. Sport - Admin - Overzicht</title>

        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/admin.css">
        <link rel="stylesheet" type="text/css" href="overzicht.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php
        // als gebruiker niet is ingevuld
        if (!isset($_SESSION["gebruiker"])) {
            print ("<script>window.open('/admin/', '_self')</script>"); // Word doorverwezen naar inlog-pagina
        }

        include "../../includes/functies.php";
        ?>

        <div id="bodycontainer">
            <?php include "../includes/adminmenu.php"; ?>
            <div id="inhoud">

                <!-- Inhoud begin -->
                <?php
                if (isset($_POST["uitloggen"])) {
                    session_unset();
                    session_destroy();
                    if (isAdminPagina()) {
                        print "<script>window.open('../index.php', '_self')</script>";
                    } else {
                        print "<script>location.reload()</script>";
                    }
                }
                ?>
                <h1>Administrator omgeving T.H. Sport</h1>
                <h2>Overzicht</h2>

                <table id="overzicht">
                    <col id="overzicht1">
                    <col>
                    <col id="overzicht3">
                    <tr>
                        <?php
                        date_default_timezone_set('Europe/Amsterdam');

                        // Evenementen vandaag
                        $link = databaseConnect();
                        $stmt = mysqli_prepare($link, "SELECT toelichting_kort FROM evenement WHERE datum=?");
                        mysqli_stmt_bind_param($stmt, "s", date("Y-m-d"));

                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        $geslaagd = mysqli_stmt_num_rows($stmt);
                        mysqli_stmt_bind_result($stmt, $toelichting_kort);
                        mysqli_stmt_fetch($stmt);
                        ?>

                        <th>Evenement vandaag:</th>

                        <?php if ($geslaagd == 1) { ?>

                            <td><?php print ($toelichting_kort); ?></td>

                        <?php } else { ?>

                            <td>Geen</td>

                            <?php
                        }
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);
                        ?>

                        <td>
                            <form method="post" action="../agenda/evenementen.php">
                                <input type="submit" value="Bekijken">
                            </form>
                        </td>
                    </tr>

                    <tr>
                        <?php
                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE status=2 AND proefles_datum=?");
                        mysqli_stmt_bind_param($stmt, "s", date("Y-m-d"));

                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $proeflessen_vandaag);
                        mysqli_stmt_fetch($stmt);
                        ?>

                        <th>Proeflessen vandaag:</th>
                        <td><?php print ($proeflessen_vandaag); ?></td>
                        <td>
                            <form method="post" action="../proefles/?status=2">
                                <input type="submit" value="Bekijken">
                            </form>
                        </td>

                        <?php
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);
                        ?>
                    </tr>

                    <tr>
                        <?php
                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE status=1");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $nieuwe_proeflessen);
                        mysqli_stmt_fetch($stmt);
                        ?>

                        <th>Nieuwe proefles aanmeldingen:</th>
                        <td><?php print ($nieuwe_proeflessen); ?></td>
                        <td>
                            <form method="post" action="../proefles/">
                                <input type="submit" value="Bekijken">
                            </form>
                        </td>

                        <?php
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);
                        ?>
                    </tr>

                    <tr>
                        <?php
// Nieuwe aanmeldingen:
                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE status=1");

                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $nieuwe_reviews);
                        mysqli_stmt_fetch($stmt);
                        ?>

                        <th>Nieuwe reviews:</th>
                        <td><?php print ($nieuwe_reviews); ?></td>
                        <td>
                            <form method="post" action="../reviews/">
                                <input type="submit" value="Bekijken">
                            </form>
                        </td>

                        <?php
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);
                        ?>
                    </tr>

                </table>
                <!-- Inhoud eind -->

            </div>
        </div>
    </body>
</html>