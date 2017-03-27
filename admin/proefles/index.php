<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>T.H. Sport - Admin - Proeflessen</title>

        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/admin.css">
        <link rel="stylesheet" type="text/css" href="proefles.css">

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
                <?php
                $link = databaseConnect();

                if (isset($_GET["status"]) && in_array($_GET["status"], array(0, 1, 2))) {
                    $status = $_GET["status"];
                } else {
                    $status = 1;
                }
                ?>

                <!-- Begin proefles header -->
                <table id="proefles_header">
                    <tr>
                        <td>
                            <h1>Administrator omgeving T.H. Sport</h1>
                            <h2>Proefles aanmeldingen beheren</h2>
                        </td>
                        <td rowspan="2">
                            <form method="get">
                                <table class="proefles_form" id="proefles_zoeken">
                                    <tr>
                                        <td>
                                            <input type="hidden" name="status" value="<?php print ($status); ?>">
                                            <?php if (isset($_GET["verborgen"])) { ?>
                                                <input type="hidden" name="verborgen" value="<?php print ($_GET["verborgen"]); ?>">
                                            <?php } ?>
                                            <input type="text" name="zoeken" placeholder="Willem Jansen" value="<?php
                                            if (isset($_GET["zoeken"])) {
                                                print ($_GET["zoeken"]);
                                            }
                                            ?>">
                                        </td>
                                        <td><input type="submit" value="Zoeken"></td>
                                    </tr>
                                </table>
                            </form>

                            <form id="zoek_form">
                                <table class="proefles_form" id="proefles_weergeven">
                                    <?php

                                    function printChecked($value) {
                                        global $status;
                                        if ($status == $value) {
                                            print ("checked");
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <th colspan="2">Weergeven</th>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="status" id="weerg_0" value="0" <?php printChecked(0); ?>></td>
                                        <td><label for="weerg_0">Niet bevestigd</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="status" id="weerg_1" value="1" <?php printChecked(1); ?>></td>
                                        <td><label for="weerg_1">Bevestigd</label></td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="status" id="weerg_2" value="2" <?php printChecked(2); ?>></td>
                                        <td><label for="weerg_2">Gepland</label></td>
                                    </tr>
                                    <script>
                                        $('input[type=radio]').change(function () {
                                            $('#zoek_form').submit();
                                        });
                                    </script>
                                </table>
                            </form>

                            <?php if ($status == 2) { ?>
                                <form id='verborgen_form'>
                                    <table>
                                        <tr>
                                            <?php

                                            function printChecked2() {
                                                if (isset($_GET["zoeken"]) || isset($_GET["verborgen"])) {
                                                    print ("checked");
                                                }
                                            }
                                            ?>
                                        <input type='hidden' name='status' value='<?php print ($status); ?>'>
                                        <?php if (isset($_GET["plan3"])) { ?>
                                            <input type='hidden' name='plan3' value='<?php print ($_GET["plan3"]); ?>'>
                                        <?php } ?>
                                        <td><input type='checkbox' id='verborgen' name='verborgen' <?php printChecked2(); ?>></td>
                                        <td><label for='verborgen'>Verborgen lessen weergeven</label></td>
                                        </tr>
                                        <script>
                                            $('input[type=checkbox]').change(function () {
                                                $('#verborgen_form').submit();
                                            });
                                        </script>
                                    </table>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p><?php
                                if ($status == 0) {
                                    print ("Hieronder staan de aanmeldingen waarvan het e-mailadres nog niet bevestigd is. Als een bepaalde aanmelding ongewenst is, dan kunt u deze verwijderen.");
                                } elseif ($status == 1) {
                                    print ("Hieronder staan de aanmeldingen waarvan het e-mailadres bevestigd is. U kunt contact opnemen met deze personen om een groepsles te plannen. Wanneer u een groepsles hebt gepland, kunt u de datum hiervan invoeren door op plannen te klikken.");
                                } else {
                                    print ("Hieronder staan de ingeplande proeflessen. Indien de geplande datum gewijzigd is kunt u dit hier invoeren. De proeflessen verdwijnen automatisch wanneer ze geweest zijn.");
                                }
                                ?></p>
                        </td>
                    </tr>
                </table>
                <!-- Eind proefles header -->

                <!-- Begin bewerken gegevens -->
                <?php
                if (isset($_GET["plan2"]) && !empty($_GET["plan2"]) || isset($_GET["plan4"]) && !empty($_GET["plan4"])) {
                    // Er is een aanmelding gepland
                    if (isset($_GET["plan2"])) {
                        $p_datum = $_GET["plan2"];
                    } else {
                        $p_datum = $_GET["plan4"];
                    }

                    $p_email = $_GET["p_email"];

                    $stmt = mysqli_prepare($link, "UPDATE proefles SET proefles_datum=?, status=2 WHERE email=?");
                    mysqli_stmt_bind_param($stmt, "ss", $p_datum, $p_email);
                    mysqli_stmt_execute($stmt);

                    $p_geslaagd = mysqli_affected_rows($link);

                    if (isset($_GET["plan2"])) {
                        if ($p_geslaagd) {
                            $p_geslaagd1 = TRUE;
                        } else {
                            $p_geslaagd1 = FALSE;
                        }
                    } else {
                        if ($p_geslaagd) {
                            $p_geslaagd2 = TRUE;
                        } else {
                            $p_geslaagd2 = FALSE;
                        }
                    }

                    mysqli_stmt_close($stmt);
                }

                if (isset($_GET["v_email"])) {
                    // Er wordt een record verwijderd
                    $v_email = $_GET["v_email"];

                    $stmt = mysqli_prepare($link, "DELETE FROM proefles WHERE email=?");
                    mysqli_stmt_bind_param($stmt, "s", $v_email);
                    mysqli_stmt_execute($stmt);

                    if (mysqli_affected_rows($link)) {
                        $v_geslaagd = TRUE;
                    } else {
                        $v_geslaagd = FALSE;
                    }

                    mysqli_stmt_close($stmt);
                }
                ?>
                <!-- Eind bewerken gegevens -->

                <!-- Begin aanmaken tabelgegevens -->
                <?php
                if (isset($_GET["zoeken"]) && !empty($_GET["zoeken"])) {
                    // Er is een zoekopdracht ingevoerd
                    ?>
                    <table id="resultaten_kop">
                        <tr>
                            <td><h3>Zoekresultaten:</h3></td>
                            <td id="resultaten_kop_knop">
                                <form>
                                    <input type='hidden' name='status' value='<?php print ($status); ?>'>
                                    <?php if (isset($_GET["verborgen"])) { ?>
                                        <input type="hidden" name="verborgen" value="<?php print ($_GET["verborgen"]); ?>">
                                    <?php } ?>
                                    <input type='submit' value='Terug'>
                                </form>
                            </td>
                        </tr>
                    </table>
                    <?php
                    if (!empty($_GET["zoeken"])) {
                        $trefwoorden = explode(" ", $_GET["zoeken"]);

                        foreach ($trefwoorden as $trefwoord) {
                            $zoeken = "%" . $trefwoord . "%";
                            $stmt = mysqli_prepare($link, "SELECT voornaam, achternaam, email, telefoonnr, ingestuurd, proefles_datum FROM proefles WHERE status=? AND (voornaam LIKE ? OR achternaam LIKE ?) ORDER BY proefles_datum, ingestuurd");
                            mysqli_stmt_bind_param($stmt, "iss", $status, $zoeken, $zoeken);
                            mysqli_stmt_execute($stmt);

                            mysqli_stmt_bind_result($stmt, $voornaam, $achternaam, $email, $telefoonnr, $ingestuurd, $proefles_datum);
                            while (mysqli_stmt_fetch($stmt)) {
                                $resultaten[] = array($voornaam, $achternaam, $email, $telefoonnr, $ingestuurd, $proefles_datum);
                            }

                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);
                        }
                    }
                } else {
                    date_default_timezone_set('Europe/Amsterdam');
                    $vandaag = date("Y-m-d");

                    if ($status == 2 && !isset($_GET["verborgen"])) {
                        $extra_query = "AND proefles_datum >= '$vandaag'";
                    } else {
                        $extra_query = "";
                    }

                    $stmt = mysqli_prepare($link, "SELECT voornaam, achternaam, email, telefoonnr, ingestuurd, proefles_datum FROM proefles WHERE status=? $extra_query ORDER BY proefles_datum, ingestuurd");
                    mysqli_stmt_bind_param($stmt, "i", $status);
                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_bind_result($stmt, $voornaam, $achternaam, $email, $telefoonnr, $ingestuurd, $proefles_datum);
                    while (mysqli_stmt_fetch($stmt)) {
                        $resultaten[] = array($voornaam, $achternaam, $email, $telefoonnr, $ingestuurd, $proefles_datum);
                    }

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                }
                ?>
                <!-- Eind aanmeken tabelgegevens -->

                <!-- Begin printen tabel -->
                <?php
                if (!empty($resultaten)) {
                    ?>
                    <table class="proefles_tabel">
                        <tr>
                            <th>Voornaam</th>
                            <th>Achternaam</th>
                            <th>E-mailadres</th>
                            <th>Telefoonnr.</th>
                            <th>Aangemeld</th>

                            <?php
                            if ($status == 1 || $status == 2) {
                                ?>
                                <th colspan="<?php
                                if ($status == 2) {
                                    print ('2');
                                } else {
                                    print ('1');
                                }
                                ?>">Gepland op</th>
                                    <?php
                                }
                                ?>

                            <th></th> <!-- Verwijderknop -->
                        </tr>
                        <tr>
                            <?php
                            $resultaten = array_map('unserialize', array_unique(array_map('serialize', $resultaten))); // Verwijdert dubbele resultaten
                            foreach ($resultaten as $resultaat) {
                                ?>
                                <td class="proefles_width1"><?php print ($resultaat[0]); ?></td> <!-- Voornaam -->
                                <td class="proefles_width1"><?php print ($resultaat[1]); ?></td> <!-- Achternaam -->
                                <td class="proefles_width2"><?php print ($resultaat[2]); ?></td> <!-- E-mailadres -->
                                <td class="proefles_width3"><?php print ($resultaat[3]); ?></td> <!-- Telefoonnr. -->
                                <td class="proefles_width3"><?php print ($resultaat[4]); ?></td> <!-- Aangemeld -->

                                <?php
                                if ($status == 1 || $status == 2) {
                                    ?>
                                    <td class="proefles_knop proefles_width3"><?php
                                        // Gepland op
                                        if ($status == 1) {
                                            if (!isset($_GET["plan1"]) || (isset($_GET["plan1"]) && $_GET["plan1"] != $resultaat[2])) {
                                                ?>
                                                <form>
                                                    <input type="hidden" name="status" value="<?php print ($status); ?>">
                                                    <?php if (isset($_GET["zoeken"])) { ?>
                                                        <input type="hidden" name="zoeken" value="<?php print ($_GET["zoeken"]); ?>">
                                                    <?php } ?>
                                                    <input type="hidden" name="plan1" value="<?php print ($resultaat[2]); ?>">
                                                    <input type="submit" value="Plannen">
                                                </form>
                                            <?php } else { ?>
                                                <form>
                                                    <input type="hidden" name="status" value="<?php print ($status); ?>">
                                                    <?php if (isset($_GET["zoeken"])) { ?>
                                                        <input type="hidden" name="zoeken" value="<?php print ($_GET["zoeken"]); ?>">
                                                    <?php } ?>
                                                    <input type="hidden" name="p_email" value="<?php print ($resultaat[2]); ?>">
                                                    <input type="date" name="plan2"><br>
                                                    <input type="submit" value="Plannen">
                                                </form>
                                                <?php
                                            }
                                        } elseif ($status == 2) {
                                            if (isset($_GET["plan3"]) && $_GET["plan3"] == $resultaat[2]) {
                                                ?>
                                                <form>
                                                    <input type="hidden" name="status" value="<?php print ($status); ?>">
                                                    <?php if (isset($_GET["zoeken"])) { ?>
                                                        <input type="hidden" name="zoeken" value="<?php print ($_GET["zoeken"]); ?>">
                                                        <?php
                                                    }
                                                    if (isset($_GET["verborgen"])) {
                                                        ?>
                                                        <input type="hidden" name="verborgen" value="<?php print ($_GET["verborgen"]); ?>">
                                                    <?php } ?>
                                                    <input type="hidden" name="p_email" value="<?php print ($resultaat[2]); ?>">
                                                    <input type="date" name="plan4" id="herplannen_datum">
                                                    <?php
                                                } else {
                                                    print ($resultaat[5]);
                                                }
                                            }
                                            ?></td> <!-- Gepland op -->
                                            <?php
                                            if ($status == 2) {
                                                ?>
                                                <td class="proefles_knop" id="herplannenknop">
                                                    <?php if (!isset($_GET["plan3"]) || (isset($_GET["plan3"]) && $_GET["plan3"] != $resultaat[2])) { ?>
                                                        <form>
                                                            <input type="hidden" name="status" value="<?php print ($status); ?>">
                                                            <?php if (isset($_GET["zoeken"])) { ?>
                                                                <input type="hidden" name="zoeken" value="<?php print ($_GET["zoeken"]); ?>">
                                                                <?php
                                                            }
                                                            if (isset($_GET["verborgen"])) {
                                                                ?>
                                                                <input type="hidden" name="verborgen" value="<?php print ($_GET["verborgen"]); ?>">
                                                            <?php } ?>
                                                            <input type="hidden" name="plan3" value="<?php print ($resultaat[2]); ?>">
                                                            <input type="submit" value="Herplannen">
                                                        </form>
                                                    <?php } else { ?>
                                                        <input type="submit" value="Herplannen">
                                                </form>
                                            </td>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                                <td class="proefles_knop" id="verwijderknop">
                                    <form id="verwijder_form">
                                        <input type="hidden" name="status" value="<?php print ($status); ?>">
                                        <?php
                                        if (isset($_GET["zoeken"])) {
                                            ?>
                                            <input type="hidden" name="zoeken" value="<?php print($_GET["zoeken"]); ?>">
                                            <?php
                                        }
                                        ?>
                                        <input type="hidden" name="v_email" value="<?php print ($resultaat[2]); ?>">
                                    </form>

                                    <button id="verwijder" onclick="verwijderMelding()">X</button>
                                    <script>
                                        function verwijderMelding() {
                                            var r = confirm("Let op: Wanneer een aanmelding verwijderd is, kan iemand zich met deze gegevens opnieuw aanmelden.\n\nKlik op OK om de aanmelding toch te verwijderen.");
                                            if (r == true) {
                                                $('#verwijder_form').submit();
                                            }
                                        }
                                    </script>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                } else {
                    print ("Niets gevonden in de ");
                    if ($status == 0) {
                        print ("niet-bevestigde");
                    } elseif ($status == 1) {
                        print ("bevestigde");
                    } else {
                        print ("geplande");
                    }
                    print (" proefles aanmeldingen.");
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
                                alert("De proefles is succesvol ingepland.");
                                window.location.href = '?status=2';
                            };
                        </script>
                    <?php } else { ?>
                        <script>
                            window.onload = function () {
                                alert("Er is een fout opgetreden. De proefles kon niet worden ingepland.");
                            };
                        </script>
                        <?php
                    }
                } elseif (isset($p_geslaagd2)) {
                    if ($p_geslaagd2) {
                        ?>
                        <script>
                            window.onload = function () {
                                alert("De proefles is succesvol herpland.");
                                window.location.href = '?status=2';
                            };
                        </script>
                    <?php } else { ?>
                        <script>
                            window.onload = function () {
                                alert("Er is een fout opgetreden. De proefles kon niet worden herpland.");
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
                                alert("De aanmelding is succesvol verwijderd.")
                            };
                        </script>
                    <?php } else { ?>
                        <script>
                            window.onload = function () {
                                alert("Er is een fout opgetreden. De aanmelding kon niet worden verwijderd.")
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

<!--
SET GLOBAL event_scheduler = ON;
CREATE EVENT IF NOT EXISTS 'verwijderproefles'
ON SCHEDULE
    EVERY 1 DAY

DO
    BEGIN

DELETE FROM proefles WHERE status= 0 AND (ingestuurd < DATE_SUB(curdate(), INTERVAL 7 DAY));

    END
-->