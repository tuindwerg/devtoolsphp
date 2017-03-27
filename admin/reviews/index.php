<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>T.H. Sport - Admin - Reviews</title> <!-- Aanpassen -->

        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/admin.css">
        <link rel="stylesheet" type="text/css" href="reviews.css"> <!-- Aanpassen -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php
        if (!isset($_SESSION["gebruiker"])) {
            print ("<script>window.open('/admin/', '_self')</script>"); // Word doorverwezen naar inlog-pagina
        }

        include "../../includes/functies.php";

        $link = databaseConnect();
        ?>

        <div id="bodycontainer">
            <?php include "../includes/adminmenu.php"; ?>
            <div id="inhoud">

               <?php
                if (isset($_GET["status"]) && in_array($_GET["status"], array(1, 2))) {
                    $status = $_GET["status"];
                } else {
                    $status = 1;
                }
                ?>

                <!-- Begin reviews header -->
                <table id="reviews_header">
                    <tr>
                        <td>
                            <h1>Administrator omgeving T.H. Sport</h1>
                            <h2>Reviews beheren</h2>
                            <p><?php
                                if ($status == 1) {?>
                                Op deze pagina kunt u de nieuw binnengekomen en geactiveerde reviews beheren. 
                                Onderstaand ziet u in een overzicht de gegevens. U kunt ervoor kiezen om deze 
                                te accepteren en toe te voegen aan de website, of deze juist te verwijderen uit
                                de database. 
                                <?php
                                } else { ?>
                                Op deze pagina kunt u de reviews die u geaccepteerd en toegevoegd heeft aan de 
                                website beheren. Onderstaand ziet u in een overzicht de gegevens. U kunt ervoor 
                                kiezen om deze te verwijderen uit de database. 
                            <?php } ?></p>
                        </td>
                        <td>
                            <form id="nieuw">
                                <table class="reviews_form" id="reviews_weergeven">
                                    <?php

                                    function printChecked($value) {
                                        global $status;
                                        if ($status == $value) {
                                            print ("checked");
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th colspan="2">Reviews:</th>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="status" id="weerg_1" value="1" <?php printChecked(1); ?>></td>
                                        <td><label for="weerg_1">Nieuwe reviews</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="status" id="weerg_2" value="2" <?php printChecked(2); ?>></td>
                                        <td><label for="weerg_2">Bevestigde reviews</label></td>
                                    </tr>
                                    <script>
                                        $('input[type=radio]').change(function () {
                                            $('#nieuw').submit();
                                        });
                                    </script>
                                </table>
                            </form>

                            <?php if ($status == 2) { ?>
                                <form id='bevestigd'>
                                    <table>
                                        <script>
                                            $('input[type=checkbox]').change(function () {
                                                $('#bevestigd').submit();
                                            });
                                        </script>
                                    </table>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
                <!-- Eind reviews header -->

                <!-- Begin bewerken gegevens -->
                
<?php 
// het verwijderen van een rij uit de huidige tabel.
if (isset($_GET["v_email"])) {
            $verwijder = $_GET["v_email"];
            $stmt = mysqli_prepare($link, "DELETE FROM review WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $verwijder);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);
//            header('Location: http://thsport.comoj.com/admin/reviews/nieuw.php');
        }
// het accepteren van een nieuwe review, en toevoegen aan de site
        if (isset($_GET["a_email"])) {
            $accepteer = $_GET["a_email"];
            $stmt = mysqli_prepare($link, "UPDATE review SET status = 2 WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $accepteer);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);
//            header('Location: http://thsport.comoj.com/admin/reviews/nieuw.php');
        }
        
        ?>
        
                <!-- Eind bewerken gegevens -->

                <!-- Begin printen tabel -->
                <?php 
                 $stmt = mysqli_prepare($link, "SELECT * FROM review WHERE status=?");
                            mysqli_stmt_bind_param($stmt, 'i', $status);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $vnaam, $anaam, $email, $bericht, $waardering, $status, $code, $aantal_mails);
                ?>
                
                
                <table class="reviews_tabel">
                        <tr>
                            <th>Naam</th>
                            <th>E-mailadres</th>
                            <th>Bericht</th>
                            <th>Waardering</th>
                            <?php
                            if ($status == 1 || $status == 2) {
                                ?>
                                <th colspan="<?php
                                if ($status == 2) {
                                    print ('1');
                                } else {
                                    print ('2');
                                }
                                ?>">Actie</th>
                            <?php } ?>
                        </tr>
                        <!--Hieronder de tabel met de nieuwe reviews.-->
                        <?php
                        
                        // query voor het opvragen van de reviews
                           
                            $geeftIets = FALSE;
                        while (mysqli_stmt_fetch($stmt)) {
                            $geeftIets = TRUE;
                            
                            $vnaam = ucfirst($vnaam);
                            $anaam = ucfirst($anaam);
                            $bericht = ucfirst($bericht);
                            ?>
                            <tr>
                                <td class="reviews_width1"><?php print ("$vnaam $anaam"); ?></td>
                                <td class="reviews_width2"><?php print ($email); ?></td>
                                <td class="reviews_width2"><i><?php print ($bericht); ?></i></td>
                                <td class="reviews_width1 reviews_center"><?php print ("$waardering"); ?></td>
                                <?php if ($status == 1) { ?>
                                <td class="reviews_width4 reviews_knop">
                                    <form>
                                        <input type='hidden' name='a_email' value='<?php print ($email); ?>'>
                                        <input type='submit' value='Accepteer'>
                                    </form>
                                </td>
                                <?php } ?>
                                <td class="reviews_knop" id="verwijderknop">
                                    <form id="verwijder_form">
                                        <input type='hidden' name='v_email' value='<?php print ($email); ?>'>
                                        </form>
                                    <button id="verwijder" onclick="verwijderMelding()">X</button>
                                    <script>
                                        function verwijderMelding() {
                                            var r = confirm("Let op: Wanneer een review verwijderd is, kan iemand zich met deze gegevens opnieuw aanmelden.\n\nKlik op OK om de review toch te verwijderen.");
                                            if (r == true) {
                                                $('#verwijder_form').submit();
                                            }
                                        }
                                    </script>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                    <?php
                    if (!$geeftIets) {
                        print ("<p>Geen reviews gevonden</p>");
                    }
                ?>
                <!-- Eind printen tabel -->

                <!-- Begin meldingen -->
                <?php
                if (isset($p_geslaagd1)) {
                    if ($p_geslaagd1) {
                        ?>
                        <script>
                            window.onload = function () {
                                alert("De review is succesvol toegevoegd.");
                                window.location.href = '?status=2';
                            };
                        </script>
                    <?php } else { ?>
                        <script>
                            window.onload = function () {
                                alert("Er is een fout opgetreden. De review kon niet worden toegevoegd.");
                            };
                        </script>
                        <?php
                    }
                }

                if (isset($v_geslaagd)) {
                    if ($v_geslaagd) {
                        ?>
                        <script>
                            window.onload = function () {
                                alert("De review is succesvol verwijderd.")
                            };
                        </script>
                    <?php } else { ?>
                        <script>
                            window.onload = function () {
                                alert("Er is een fout opgetreden. De review kon niet worden verwijderd.")
                            };
                        </script>
                        <?php
                    }
                }
                ?>
                <!-- Eind meldingen -->

                <?php mysqli_close($link); ?>
                <!-- Inhoud eind -->
                
                
            </div>
        </div>
    </body>
</html>