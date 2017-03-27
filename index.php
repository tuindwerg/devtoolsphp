<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport</title>
        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="../reviews/reviews.css">
        <link rel="stylesheet" type="text/css" href="index.css">
        
        <!--jQuery word vanaf Google ingeladen en gebruikt op de pagina.-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        <!--De header word opgehaald vanuit de includes.-->
        <?php include "./includes/header/header.php";
        // Het formulier wordt ingeladen.
        include "reviews/formulier.php";?>

            <div class="inhoud" id="home">
                <!-- Inhoud begin -->
                <table id="home_tabel">
                    <tr>
                        <td>
                            <iframe id="facebook" src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FTH-Sport%2F302491886584302&amp;colorscheme=light&amp;show_faces=false&amp;header=false&amp;stream=true&amp;show_border=false"></iframe>
                        </td>

                        <td class="home_afb">
                            <a href="/agenda">
                                <img alt="Agenda" src="./afb/links.png">
                            </a>
                        </td>

                        <td class="home_afb">
                            <a href="/lessen">
                                <img alt="Lessen" src="./afb/rechts.png">
                            </a>
                        </td>
                    </tr>
                </table>
                <!-- Inhoud eind -->

            </div>
        </div>

        <!--De footer word opgehaald vanuit de includes.-->
        <?php include "./includes/footer/footer.php"; ?>
    </body>
</html>
