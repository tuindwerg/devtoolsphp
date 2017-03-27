<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>T.H. Sport - Admin - Evenementen</title>

        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/admin.css">
        <link rel="stylesheet" type="text/css" href="evenementen.css">

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
                <?php $link = databaseConnect(); ?>

                <!-- Gegevens bewerken begin -->
                <?php
                if (isset($_POST["annuleren"])) {
                    unset($_GET);
                }

                if (isset($_POST["bewerken"])) {
                    if (!empty($_POST["datum"]) &&
                            ((isset($_POST["gesloten"])) ||
                            (!isset($_POST["gesloten"]) && !empty($_POST["toelichting_kort"])))) {
                        // Er wordt een evenement bewerkt

                        $datum_oud = $_POST["datum_oud"];
                        $datum = $_POST["datum"];
                        $toelichting_kort = $_POST["toelichting_kort"];
                        $toelichting_lang = $_POST["toelichting_lang"];
                        if (empty($toelichting_lang)) {
                            $toelichting_lang = NULL;
                        }

                        if (isset($_POST["gesloten"])) {
                            $stmt = mysqli_prepare($link, "UPDATE evenement SET datum=?, toelichting_kort='Gesloten', toelichting_lang=?, gesloten=1 WHERE datum=?");
                            mysqli_stmt_bind_param($stmt, "sss", $datum, $toelichting_lang, $datum_oud);
                        } else {
                            $stmt = mysqli_prepare($link, "UPDATE evenement SET datum=?, toelichting_kort=?, toelichting_lang=?, gesloten=0 WHERE datum=?");
                            mysqli_stmt_bind_param($stmt, "ssss", $datum, $toelichting_kort, $toelichting_lang, $datum_oud);
                        }

                        mysqli_stmt_execute($stmt);
                        $geslaagd = mysqli_stmt_affected_rows($stmt);

                        if ($geslaagd == -1) {
                            $bericht_faal = "Fout: Er is al een evenement gepland op deze dag";
                        } elseif ($geslaagd) {
                            $bericht_succes = "Het evenement is succesvol bewerkt";
                        } else {
                            $bericht_faal = "Het evenement is niet bewerkt";
                        }

                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);
                    } else {
                        $bericht_faal = "Niet alle verplichte velden zijn ingevuld";
                    }
                } elseif (isset($_POST["aanmaken"])) {
                    if (!empty($_POST["datum"]) &&
                            ((isset($_POST["gesloten"])) ||
                            (!isset($_POST["gesloten"]) && !empty($_POST["toelichting_kort"])))) {
                        // Er wordt een evenement aangemaakt

                        $datum = $_POST["datum"];
                        $toelichting_kort = $_POST["toelichting_kort"];
                        $toelichting_lang = $_POST["toelichting_lang"];
                        if (empty($toelichting_lang)) {
                            $toelichting_lang = NULL;
                        }

                        if (isset($_POST["gesloten"])) {
                            $stmt = mysqli_prepare($link, "INSERT INTO evenement VALUES (?, 'Gesloten', ?, 1)");
                            mysqli_stmt_bind_param($stmt, "ss", $datum, $toelichting_lang);
                        } else {
                            $stmt = mysqli_prepare($link, "INSERT INTO evenement VALUES (?, ?, ?, 0)");
                            mysqli_stmt_bind_param($stmt, "sss", $datum, $toelichting_kort, $toelichting_lang);
                        }

                        mysqli_stmt_execute($stmt);
                        $geslaagd = mysqli_stmt_affected_rows($stmt);

                        if ($geslaagd == -1) {
                            $bericht_faal = "Fout: Er is al een evenement gepland op deze dag";
                        } elseif ($geslaagd) {
                            $bericht_succes = "Het evenement is succesvol aangemaakt";
                        } else {
                            $bericht_faal = "Het evenement is niet aangemaakt";
                        }

                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);
                    } else {
                        $bericht_faal = "Niet alle verplichte velden zijn ingevuld";
                    }
                } elseif (isset($_GET["verwijder"])) {
                    // Er wordt een evenement verwijderd
                    $datum = $_GET["verwijder"];

                    $stmt = mysqli_prepare($link, "DELETE FROM evenement WHERE datum=?");
                    mysqli_stmt_bind_param($stmt, "s", $datum);

                    mysqli_stmt_execute($stmt);
                    $geslaagd = mysqli_stmt_affected_rows($stmt);

                    if ($geslaagd) {
                        $bericht_succes = "Het evenement is succesvol verwijderd";
                    } else {
                        $bericht_faal = "Het evenement is niet verwijderd";
                    }

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                }
                ?>
                <!-- Gegevens bewerken eind -->

                <!-- Header begin -->
                <div id="header">
                    <div id="header1">
                        <h1>Administrator omgeving T.H. Sport</h1>
                        <h2>Evenementen beheren</h2>
                        <p>Hier zijn de datums waarop er een evenement plaatsvindt en de datums waarop de sportschool gesloten is te beheren.</p>
                    </div>

                    <!-- Evenement formulier begin -->
                    <div id="header2">

                        <?php
                        if (isset($bericht_succes)) {
                            unset($_GET);
                        } elseif (isset($bericht_faal) && isset($_POST["bewerken"])) {
                            $_GET["bewerk"] = str_replace("-", "", $_POST["datum_oud"]);
                        }

                        $bewerken = FALSE;
                        if (isset($_GET["bewerk"])) {
                            // Gegevens ophalen uit database
                            $get_datum = $_GET["bewerk"];
                            $datum = substr($get_datum, 0, 4) . "-" . substr($get_datum, 4, 2) . "-" . substr($get_datum, 6, 2);

                            $stmt = mysqli_prepare($link, "SELECT * FROM evenement WHERE datum=?");
                            mysqli_stmt_bind_param($stmt, "s", $datum);

                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $datum, $toelichting_kort, $toelichting_lang, $gesloten);
                            mysqli_stmt_fetch($stmt);

                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);

                            $bewerken = TRUE;
                        }
                        ?>

                        <?php if (isset($bericht_faal)) { ?>
                            <div id='bericht_faal'><i><?php print ($bericht_faal); ?></i></div>
                        <?php } if (isset($bericht_succes)) { ?>
                            <div id='bericht_succes'><i><?php print ($bericht_succes); ?></i></div>
                        <?php } ?>

                        <form method="post" action="./evenementen.php">
                            <?php if ($bewerken) { ?>
                                <input type="hidden" name="datum_oud" value="<?php print ($datum); ?>">
                            <?php } ?>
                            <table>
                                <colgroup>
                                    <col id="form_labels" class="width20">
                                    <col span="3" class="width40">
                                </colgroup>
                                <tr>
                                    <th><label for="datum">Datum *:</label></th>
                                    <td><input class="width100" id="datum" type="date" name="datum" value="<?php
                                        if ($bewerken) {
                                            print ($datum);
                                        }
                                        ?>"></td>
                                    <td>
                                        <input id="gesloten" type="checkbox" name="gesloten" <?php
                                        if ($bewerken && $gesloten) {
                                            print ("checked");
                                        }
                                        ?>> <label for="gesloten">Gesloten</label>

                                        <script>
                                            $(document).ready(function () {
                                                $('#gesloten').change(function () {
                                                    if (!this.checked)
                                                        document.getElementById("form_evenement").style.display = 'table-row';
                                                    else
                                                        document.getElementById("form_evenement").style.display = 'none';
                                                });
                                                $('#gesloten').change();
                                            });
                                        </script>
                                    </td>
                                </tr>
                                <tr id="form_evenement">
                                    <th><label for="toelichting_kort">Evenement *:</label></th>
                                    <td colspan="2">
                                        <input id="toelichting_kort" class="width100" type="text" name="toelichting_kort" maxlength="45" value="<?php
                                        if ($bewerken && !$gesloten) {
                                            print ($toelichting_kort);
                                        }
                                        ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <th><label for="toelichting_lang">Toelichting:</label></th>
                                    <td colspan="2">
                                        <textarea id="toelichting_lang" name="toelichting_lang" maxlength="500" rows="3" class="width100"><?php
                                            if ($bewerken) {
                                                print ($toelichting_lang);
                                            }
                                            ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" id="knoppen">
                                        <?php if (!$bewerken) { ?>
                                            <input type="submit" name="aanmaken" value="Aanmaken">
                                        <?php } else { ?>
                                            <input type="submit" name="bewerken" value="Bewerken">
                                            <input type="submit" name="annuleren" value="Annuleren">
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <!-- Evenement formulier eind -->
                <!-- Header eind -->

                <!-- Overzicht begin -->
                <div id="overzicht">
                    <table>
                        <tr>
                            <th id="overzicht_evenementen">Evenementen</th>
                            <th id="overzicht_gesloten">Gesloten dagen</th>
                        </tr>

                        <tr>
                            <!-- Overzicht 1 begin -->
                            <td>
                                <table id="overzicht1">
                                    <colgroup>
                                        <col class="overzicht_1">
                                        <col class="overzicht_2">
                                        <col>
                                        <col class="overzicht_3">
                                    </colgroup>

                                    <?php
                                    $stmt = mysqli_prepare($link, "SELECT toelichting_kort, datum, toelichting_lang FROM evenement WHERE gesloten=0 ORDER BY datum");
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_bind_result($stmt, $toelichting_kort, $datum, $toelichting_lang);

                                    while (mysqli_stmt_fetch($stmt)) {
                                        if (empty($toelichting_lang)) {
                                            $toelichting_lang = "<i>Geen toelichting</i>";
                                        }
                                        ?>
                                        <tr <?php
                                        if (isset($_GET["bewerk"]) && $_GET["bewerk"] == str_replace("-", "", $datum)) {
                                            print ('id="wordt_bewerkt"');
                                        } elseif (isset($_GET["verwijder"]) && $_GET["verwijder"] == str_replace("-", "", $datum)) {
                                            print ('id="wordt_verwijderd"');
                                        }
                                        ?>>
                                            <th><?php print ($toelichting_kort); ?></th>
                                            <td><?php print ($datum); ?></td>
                                            <td class="break_word"><?php print ($toelichting_lang); ?></td>
                                            <td>
                                                <?php $datum = str_replace("-", "", $datum); ?>

                                                <form id="bewerk_<?php print ($datum); ?>">
                                                    <input type="hidden" name="bewerk" value="<?php print ($datum); ?>">
                                                </form>

                                                <form id="verwijder_<?php print ($datum); ?>">
                                                    <input type="hidden" name="verwijder" value="<?php print ($datum); ?>">
                                                </form>

                                                <button class="knopje" onclick="bewerk_<?php print ($datum); ?>()">
                                                    <img src='../includes/afb/bewerk.png' alt="bewerk">
                                                    <script>
                                                        function bewerk_<?php print ($datum); ?>() {
                                                            document.getElementById("bewerk_<?php print ($datum); ?>").submit();
                                                        }
                                                    </script>
                                                </button>

                                                <button class="knopje" onclick="verwijder_<?php print ($datum); ?>()">
                                                    <img src='../includes/afb/verwijder.png' alt="verwijder">
                                                    <script>
                                                        function verwijder_<?php print ($datum); ?>() {
                                                            document.getElementById("verwijder_<?php print ($datum); ?>").submit();
                                                        }
                                                    </script>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }

                                    mysqli_stmt_free_result($stmt);
                                    mysqli_stmt_close($stmt);
                                    ?>
                                </table>
                            </td>
                            <!-- Overzicht 1 eind -->

                            <!-- Overzicht 2 begin -->
                            <td>
                                <table id="overzicht2">
                                    <colgroup>
                                        <col class="overzicht_1">
                                        <col>
                                        <col class="overzicht_3">
                                    </colgroup>

                                    <?php
                                    $stmt = mysqli_prepare($link, "SELECT toelichting_lang, datum FROM evenement WHERE gesloten=1 ORDER BY datum");
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_bind_result($stmt, $toelichting_lang, $datum);

                                    while (mysqli_stmt_fetch($stmt)) {
                                        ?>
                                        <tr <?php
                                        if (isset($_GET["bewerk"]) && $_GET["bewerk"] == str_replace("-", "", $datum)) {
                                            print ('id="wordt_bewerkt"');
                                        } elseif (isset($_GET["verwijder"]) && $_GET["verwijder"] == str_replace("-", "", $datum)) {
                                            print ('id="wordt_verwijderd"');
                                        }
                                        ?>>
                                            <th><?php
                                                if (!empty($toelichting_lang)) {
                                                    print ($toelichting_lang);
                                                } else {
                                                    print ("Gesloten");
                                                }
                                                ?></th>
                                            <td><?php print ($datum); ?></td>
                                            <td>
                                                <?php $datum = str_replace("-", "", $datum); ?>

                                                <form id="bewerk_<?php print ($datum); ?>">
                                                    <input type="hidden" name="bewerk" value="<?php print ($datum); ?>">
                                                </form>

                                                <form id="verwijder_<?php print ($datum); ?>">
                                                    <input type="hidden" name="verwijder" value="<?php print ($datum); ?>">
                                                </form>

                                                <button class="knopje" onclick="bewerk_<?php print ($datum); ?>()">
                                                    <img src='../includes/afb/bewerk.png' alt="bewerk">
                                                    <script>
                                                        function bewerk_<?php print ($datum); ?>() {
                                                            document.getElementById("bewerk_<?php print ($datum); ?>").submit();
                                                        }
                                                    </script>
                                                </button>

                                                <button class="knopje" onclick="verwijder_<?php print ($datum); ?>()">
                                                    <img src='../includes/afb/verwijder.png' alt="verwijder">
                                                    <script>
                                                        function verwijder_<?php print ($datum); ?>() {
                                                            document.getElementById("verwijder_<?php print ($datum); ?>").submit();
                                                        }
                                                    </script>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }

                                    mysqli_stmt_free_result($stmt);
                                    mysqli_stmt_close($stmt);
                                    ?>
                                </table>
                            </td>
                            <!-- Overzicht 2 eind -->
                        </tr>
                    </table>
                </div>
                <!-- Overzicht eind -->

                <?php mysqli_close($link); ?>
                <!-- Inhoud eind -->

            </div>
        </div>
    </body>
</html>