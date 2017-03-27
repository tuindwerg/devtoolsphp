<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>T.H. Sport - Admin - Weekagenda</title>

        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/admin.css">
        <link rel="stylesheet" type="text/css" href="week.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php
        if (!isset($_SESSION["gebruiker"])) {
            $_SESSION["gebruiker"] = "test";
        }

        include "../../includes/functies.php";

        // Deze pagina heeft hetzelfde principe als de normale agenda pagina
        ?>

        <div id="bodycontainer">
            <?php include "../includes/adminmenu.php"; ?>
            <div id="inhoud_act">

                <!-- Inhoud begin -->
                <?php $link = databaseConnect(); ?>

                <div id="header">
                    <h1>Administrator omgeving T.H. Sport</h1>
                    <h2>Wekelijkse agenda beheren</h2>
                </div>

                <!-- Gegevens bewerken begin -->
                <?php
                if (isset($_POST["a_bewerken"])) {
                    // Er wordt een activiteit bewerkt
                    if (!empty($_POST["b2_groepsles"]) &&
                            !empty($_POST["b2_week_dag"]) &&
                            !empty($_POST["b2_begintijd"])) {

                        $b2_groepsles = $_POST["b2_groepsles"];
                        $b2_week_dag = $_POST["b2_week_dag"];
                        $b2_begintijd = $_POST["b2_begintijd"];
                        $b2_eindtijd = $_POST["b2_eindtijd"];

                        $b3_groepsles = $_POST["b3_groepsles"];
                        $b3_week_dag = $_POST["b3_week_dag"];
                        $b3_begintijd = $_POST["b3_begintijd"];
                        $b3_eindtijd = $_POST["b3_eindtijd"];

                        date_default_timezone_set("Europe/Amsterdam");
                        $t_begintijd = strtotime($b2_begintijd);
                        $t_eindtijd = strtotime($b2_eindtijd);

                        if (!empty($b2_eindtijd) && $t_begintijd > $t_eindtijd) {
                            $melding = "<span class='act_faal'>De activiteit moet beginnen voordat deze eindigt</span>";
                        } elseif (!empty($b2_eindtijd) && $t_begintijd == $t_eindtijd) {
                            $melding = "<span class='act_faal'>De begintijd is gelijk aan de eindtijd</span>";
                        } else {
                            // Voorwaarden zijn voldaan, voer query uit
                            if (!empty($b2_eindtijd)) {
                                $stmt = mysqli_prepare($link, "UPDATE groepsles_activiteit SET groepsles=?, week_dag=?, begintijd=?, eindtijd=? WHERE groepsles=? AND week_dag=? AND begintijd=?");
                                mysqli_stmt_bind_param($stmt, "sisssis", $b2_groepsles, $b2_week_dag, $b2_begintijd, $b2_eindtijd, $b3_groepsles, $b3_week_dag, $b3_begintijd);
                            } elseif (empty($b2_eindtijd)) {
                                $stmt = mysqli_prepare($link, "UPDATE groepsles_activiteit SET groepsles=?, week_dag=?, begintijd=?, eindtijd=NULL WHERE groepsles=? AND week_dag=? AND begintijd=?");
                                mysqli_stmt_bind_param($stmt, "sissis", $b2_groepsles, $b2_week_dag, $b2_begintijd, $b3_groepsles, $b3_week_dag, $b3_begintijd);
                            }

                            mysqli_stmt_execute($stmt);
                            $updateGeslaagd = mysqli_affected_rows($link);
                            mysqli_stmt_close($stmt);

                            if ($updateGeslaagd == -1) {
                                $melding = "<span class='act_faal'>Deze activiteit bestaat al</span>";
                            } elseif ($updateGeslaagd) {
                                $melding = "<span class='act_succes'>Het bewerken van de activiteit is geslaagd</span>";
                                unset($_POST);
                            } else {
                                $melding = "<span class='act_faal'>De activiteit is niet bewerkt</span>";
                            }
                        }
                    } else {
                        $melding = "<span class='act_faal'>Alle velden zijn verplicht</span>";
                    }
                } elseif (isset($_POST["v_groepsles"])) {
                    // Er wordt een activiteit verwijderd
                    $v_groepsles = $_POST["v_groepsles"];
                    $v_week_dag = $_POST["v_week_dag"];
                    $v_begintijd = $_POST["v_begintijd"];

                    $stmt = mysqli_prepare($link, "DELETE FROM groepsles_activiteit WHERE groepsles=? AND week_dag=? AND begintijd=?");
                    mysqli_stmt_bind_param($stmt, "sis", $v_groepsles, $v_week_dag, $v_begintijd);

                    mysqli_stmt_execute($stmt);
                    $deleteGeslaagd = mysqli_affected_rows($link);
                    mysqli_stmt_close($stmt);

                    if ($deleteGeslaagd) {
                        $melding = "<span class='act_succes'>Het verwijderen van de activiteit is geslaagd</span>";
                        unset($_POST);
                    } else {
                        $melding = "<span class='act_faal'>De activiteit is niet verwijderd</span>";
                    }
                } elseif (isset($_POST["aanmaken"])) {
                    // Er wordt een nieuwe activiteit aangemaakt
                    if (!empty($_POST["a_groepsles"]) &&
                            !empty($_POST["a_week_dag"]) &&
                            !empty($_POST["a_begintijd"])) {
                        $a_groepsles = $_POST["a_groepsles"];
                        $a_week_dag = $_POST["a_week_dag"];
                        $a_begintijd = $_POST["a_begintijd"];
                        $a_eindtijd = $_POST["a_eindtijd"];

                        date_default_timezone_set("Europe/Amsterdam");
                        $t_begintijd = strtotime($a_begintijd);
                        $t_eindtijd = strtotime($a_eindtijd);

                        if (!empty($a_eindtijd) && $t_begintijd > $t_eindtijd) {
                            $melding = "<span class='act_faal'>De activiteit moet beginnen voordat deze eindigt</span>";
                        } elseif (!empty($a_eindtijd) && $t_begintijd == $t_eindtijd) {
                            $melding = "<span class='act_faal'>De begintijd is gelijk aan de eindtijd</span>";
                        } else {
                            // Er is aan de voorwaarden voldaan, de query wordt uitgevoerd
                            if (!empty($a_eindtijd)) {
                                $stmt = mysqli_prepare($link, "INSERT INTO groepsles_activiteit VALUES (?, ?, ?, ?)");
                                mysqli_stmt_bind_param($stmt, "siss", $a_groepsles, $a_week_dag, $a_begintijd, $a_eindtijd);
                            } else {
                                $stmt = mysqli_prepare($link, "INSERT INTO groepsles_activiteit VALUES (?, ?, ?, NULL)");
                                mysqli_stmt_bind_param($stmt, "sis", $a_groepsles, $a_week_dag, $a_begintijd);
                            }

                            mysqli_stmt_execute($stmt);
                            $insertGeslaagd = mysqli_affected_rows($link);
                            mysqli_stmt_close($stmt);

                            if ($insertGeslaagd == -1) {
                                $melding = "<span class='act_faal'>Deze activiteit bestaat al</span>";
                            } elseif ($insertGeslaagd) {
                                $melding = "<span class='act_succes'>Het toevoegen van de activiteit is geslaagd</span>";
                                unset($_POST);
                            } else {
                                $melding = "<span class='act_faal'>De activiteit is niet toegevoegd</span>";
                            }
                        }
                    } else {
                        $melding = "<span class='act_faal'>Alle velden zijn verplicht</span>";
                    }
                } elseif (isset($_POST["o_bewerken"])) {
                    // De openingstijden worden bewerkt
                    if (!empty($_POST["b2_openingstijd"]) && !empty($_POST["b2_sluitingstijd"])) {
                        $b2_week_dag = $_POST["b2_week_dag"];
                        $b2_openingstijd = $_POST["b2_openingstijd"];
                        $b2_sluitingstijd = $_POST["b2_sluitingstijd"];
                        if (isset($_POST["b2_gesloten"])) {
                            $b2_gesloten = TRUE;
                        } else {
                            $b2_gesloten = FALSE;
                        }

                        date_default_timezone_set("Europe/Amsterdam");
                        $t_openingstijd = strtotime($b2_openingstijd);
                        $t_sluitingstijd = strtotime($b2_sluitingstijd);

                        if (!$b2_gesloten && $t_openingstijd > $t_sluitingstijd) {
                            $melding = "<span class='act_faal'>De sportschool moet openen voordat deze sluit</span>";
                        } elseif (!$b2_gesloten && $t_openingstijd == $t_sluitingstijd) {
                            $melding = "<span class='act_faal'>De openingstijd is gelijk aan de sluitingstijd</span>";
                        } else {
                            // Er is aan de voorwaarden voldaan, de query wordt uitgevoerd
                            if (!$b2_gesloten) {
                                $stmt = mysqli_prepare($link, "UPDATE openingstijden SET openingstijd=?, sluitingstijd=? WHERE week_dag=?");
                                mysqli_stmt_bind_param($stmt, "ssi", $b2_openingstijd, $b2_sluitingstijd, $b2_week_dag);
                            } else {
                                $stmt = mysqli_prepare($link, "UPDATE openingstijden SET openingstijd=NULL, sluitingstijd=NULL WHERE week_dag=?");
                                mysqli_stmt_bind_param($stmt, "i", $b2_week_dag);
                            }

                            mysqli_stmt_execute($stmt);
                            $updateGeslaagd = mysqli_affected_rows($link);
                            mysqli_stmt_close($stmt);

                            if ($updateGeslaagd) {
                                $melding = "<span class='act_succes'>Het bewerken van de openingstijden is geslaagd</span>";
                                unset($_POST);
                            } else {
                                $melding = "<span class='act_faal'>De openingstijden zijn niet bewerkt</span>";
                            }
                        }
                    } else {
                        $melding = "<span class='act_faal'>Alle velden zijn verplicht</span>";
                    }
                }
                ?>
                <!-- Gegevens bewerken eind -->

                <!-- Gegevens ophalen begin -->
                <?php
                $dagen = array(
                    1 => "Maandag",
                    2 => "Dinsdag",
                    3 => "Woensdag",
                    4 => "Donderdag",
                    5 => "Vrijdag",
                    6 => "Zaterdag",
                    7 => "Zondag");

                if (isset($_POST["annuleren"])) {
                    // Het bewerken van een activiteit is geannuleerd
                    unset($_POST);
                }

                // Gesloten dagen ophalen
                $stmt = mysqli_prepare($link, "SELECT openingstijd, sluitingstijd FROM openingstijden");
                mysqli_stmt_execute($stmt);

                mysqli_stmt_bind_result($stmt, $openingstijd, $sluitingstijd);
                $i = 0;
                while (mysqli_stmt_fetch($stmt)) {
                    $i++;
                    if (empty($openingstijd) && empty($sluitingstijd)) {
                        $gesloten[$i] = TRUE;
                    } else {
                        $gesloten[$i] = FALSE;
                    }
                }

                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);

                function tijd($week_dag, $x) {
                    // Openingstijden opvragen
                    global $link;

                    if ($x == 1) {
                        $stmt = mysqli_prepare($link, "SELECT openingstijd FROM openingstijden WHERE week_dag=?");
                    } elseif ($x == 2) {
                        $stmt = mysqli_prepare($link, "SELECT sluitingstijd FROM openingstijden WHERE week_dag=?");
                    }
                    mysqli_stmt_bind_param($stmt, "i", $week_dag);
                    mysqli_stmt_execute($stmt);

                    mysqli_stmt_bind_result($stmt, $tijd);
                    mysqli_stmt_fetch($stmt);

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);

                    print ($tijd);
                }

                // Groepslessen ophalen
                $stmt = mysqli_prepare($link, "SELECT groepsles FROM groepsles ORDER BY groepsles");
                mysqli_stmt_execute($stmt);

                mysqli_stmt_bind_result($stmt, $groepsles);
                while (mysqli_stmt_fetch($stmt)) {
                    $groepslessen[] = $groepsles;
                }

                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);

                // Activiteiten ophalen
                $stmt = mysqli_prepare($link, "SELECT * FROM groepsles_activiteit ORDER BY groepsles, week_dag, begintijd, eindtijd");
                mysqli_stmt_execute($stmt);

                mysqli_stmt_bind_result($stmt, $activiteit, $week_dag, $begintijd, $eindtijd);
                while (mysqli_stmt_fetch($stmt)) {
                    $activiteiten[] = array($activiteit, $week_dag, $begintijd, $eindtijd);
                }

                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);
                ?>
                <!-- Gegevens ophalen eind -->

                <!-- Header begin -->
                <form method="post" id="header2">
                    <?php
                    // Kopjes weergeven
                    if (isset($_POST["b1_opening"]) || isset($_POST["o_bewerken"])) {
                        if (isset($_POST["b1_opening"])) {
                            $week_dag = $_POST["b1_opening"];
                        } else {
                            $week_dag = $_POST["b2_week_dag"];
                        }
                        ?>
                        <h3 class="act_bericht">De openingstijden van <?php print ($dagen[$week_dag]); ?> bewerken</h3>
                        <?php
                    } else {
                        if (isset($_POST["b1_groepsles"])) {
                            $act_bericht_les = "b1_groepsles";
                            $act_bericht_dag = "b1_week_dag";
                        } elseif (isset($_POST["a_bewerken"])) {
                            $act_bericht_les = "b3_groepsles";
                            $act_bericht_dag = "b3_week_dag";
                        }

                        if (isset($_POST["b1_groepsles"]) || isset($_POST["a_bewerken"])) {
                            ?>
                            <h3 class="act_bericht">De activiteit <?php print ($_POST[$act_bericht_les] . " van " . $dagen[$_POST[$act_bericht_dag]]); ?> bewerken</h3>
                            <?php
                        }
                    }
                    ?>

                    <table id="header_tabel">
                        <?php
                        if (isset($melding)) {
                            // Melding printen
                            ?>
                            <tr>
                                <td colspan="4" class="act_bericht"><i><?php print ($melding); ?></i></td>
                            </tr>
                            <?php
                        }

                        if (isset($_POST["b1_opening"]) || isset($_POST["o_bewerken"])) {
                            // Er worden openingstijden bewerkt
                            ?>
                            <input type="hidden" name="b2_week_dag" value="<?php print ($week_dag); ?>">
                            <tr id="tijden_inputs">
                                <th>Opening</th>
                                <td>
                                    <input type="time" name="b2_openingstijd" value="<?php
                                    if (isset($_POST["b2_openingstijd"])) {
                                        print ($_POST["b2_openingstijd"]);
                                    } else {
                                        tijd($week_dag, 1);
                                    }
                                    ?>">
                                </td>

                                <th>Sluiting</th>
                                <td>
                                    <input type="time" name="b2_sluitingstijd" value="<?php
                                    if (isset($_POST["b2_sluitingstijd"])) {
                                        print ($_POST["b2_sluitingstijd"]);
                                    } else {
                                        tijd($week_dag, 2);
                                    }
                                    ?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" id="gesloten_checkbox">
                                    <input type="checkbox" name="b2_gesloten" id="b2_gesloten" <?php
                                    if (isset($_POST["o_bewerken"]) && isset($_POST["b2_gesloten"])) {
                                        print ("checked");
                                    } elseif ($gesloten[$week_dag]) {
                                        print ("checked");
                                    }
                                    ?>> <label for="b2_gesloten">Gesloten op <?php print (strtolower($dagen[$week_dag])); ?></label>

                                    <script>
                                        $(document).ready(function () {
                                            $('#b2_gesloten').change(function () {
                                                if (!this.checked)
                                                    document.getElementById("tijden_inputs").style.display = 'block';
                                                else
                                                    document.getElementById("tijden_inputs").style.display = 'none';
                                            });
                                            $('#b2_gesloten').change();
                                        });
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="act_knop">
                                    <input type="submit" name="o_bewerken" value="Bewerken">
                                    <input type="submit" name="annuleren" value="Annuleren">
                                </td>
                            </tr>
                            <?php
                        } else {

                            function printSelected($postkey, $waarde) {
                                if (isset($_POST[$postkey]) && $_POST[$postkey] == $waarde) {
                                    return "selected";
                                }
                            }
                            ?>
                            <tr>
                                <th>Groepsles:</th>
                                <td>
                                    <?php
                                    if (isset($_POST["b1_groepsles"])) {
                                        // Er is op een bewerkknop geklikt
                                        $name1 = "b2_groepsles";
                                        $postkey1 = "b1_groepsles";

                                        $name2 = "b2_week_dag";
                                        $postkey2 = "b1_week_dag";

                                        $nameBegin = "b2_begintijd";
                                        $nameEind = "b2_eindtijd";
                                    } elseif (isset($_POST["b2_groepsles"])) {
                                        // Er is op "Bewerken" geklikt
                                        $name1 = "b2_groepsles";
                                        $postkey1 = "b2_groepsles";

                                        $name2 = "b2_week_dag";
                                        $postkey2 = "b2_week_dag";

                                        $nameBegin = "b2_begintijd";
                                        $nameEind = "b2_eindtijd";
                                    } else {
                                        $name1 = "a_groepsles";
                                        $postkey1 = "a_groepsles";

                                        $name2 = "a_week_dag";
                                        $postkey2 = "a_week_dag";

                                        $nameBegin = "a_begintijd";
                                        $nameEind = "a_eindtijd";
                                    }

                                    if (isset($_POST["b1_groepsles"])) {
                                        ?>
                                        <input type="hidden" name="b3_groepsles" value="<?php print ($_POST["b1_groepsles"]) ?>">
                                        <input type="hidden" name="b3_week_dag" value="<?php print ($_POST["b1_week_dag"]) ?>">
                                        <input type="hidden" name="b3_begintijd" value="<?php print ($_POST["b1_begintijd"]) ?>">
                                        <input type="hidden" name="b3_eindtijd" value="<?php print ($_POST["b1_eindtijd"]) ?>">
                                        <?php
                                    }
                                    if (isset($_POST["a_bewerken"])) {
                                        ?>
                                        <input type="hidden" name="b3_groepsles" value="<?php print ($_POST["b3_groepsles"]) ?>">
                                        <input type="hidden" name="b3_week_dag" value="<?php print ($_POST["b3_week_dag"]) ?>">
                                        <input type="hidden" name="b3_begintijd" value="<?php print ($_POST["b3_begintijd"]) ?>">
                                        <input type="hidden" name="b3_eindtijd" value="<?php print ($_POST["b3_eindtijd"]) ?>">
                                    <?php } ?>

                                    <select name="<?php print ($name1); ?>">
                                        <option value="">---</option>
                                        <?php
                                        foreach ($groepslessen as $groepsles) {
                                            print ("<option " . printSelected($postkey1, $groepsles) . ">$groepsles</option>");
                                        }
                                        ?>
                                    </select>
                                </td>

                                <th>Begintijd:</th>
                                <td>
                                    <input type="time" name="<?php print ($nameBegin) ?>" value="<?php
                                    if (isset($_POST["a_begintijd"])) {
                                        print ($_POST["a_begintijd"]);
                                    } elseif (isset($_POST["b1_begintijd"])) {
                                        print ($_POST["b1_begintijd"]);
                                    } elseif (isset($_POST["b2_begintijd"])) {
                                        print ($_POST["b2_begintijd"]);
                                    }
                                    ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Dag:</th>
                                <td>
                                    <select name="<?php print ($name2); ?>">
                                        <option value="">---</option>
                                        <?php
                                        for ($dag = 1; $dag <= 7; $dag++) {
                                            print ("<option value='" . $dag . "' " . printSelected($postkey2, $dag) . ">" . $dagen[$dag] . "</option>");
                                        }
                                        ?>
                                    </select>
                                </td>

                                <th>Eindtijd:</th>
                                <td>
                                    <input type="time" name="<?php print ($nameEind) ?>" value="<?php
                                    if (isset($_POST["a_eindtijd"])) {
                                        print ($_POST["a_eindtijd"]);
                                    } elseif (isset($_POST["b1_eindtijd"])) {
                                        print ($_POST["b1_eindtijd"]);
                                    } elseif (isset($_POST["b2_eindtijd"])) {
                                        print ($_POST["b2_eindtijd"]);
                                    }
                                    ?>">
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" class="act_knop">
                                    <?php if (isset($_POST["b1_groepsles"]) || isset($_POST["a_bewerken"])) { ?>
                                        <input type="submit" name="a_bewerken" value="Bewerken">
                                        <input type="submit" name="annuleren" value="Annuleren">
                                    <?php } else { ?>
                                        <input type="submit" name="aanmaken" value="Aanmaken">
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </form>
                <!-- Header eind -->

                <!-- Overzicht begin -->
                <?php

                function print_activiteit($activiteit, $begintijd, $eindtijd, $week_dag) {
                    // Plaats een activiteit in de agenda
                    global $activiteitnr;

                    if (!isset($activiteitnr)) {
                        $activiteitnr = 1;
                    } else {
                        $activiteitnr++;
                    }
                    ?>
                    <tr>
                        <td><?php
                            print ($begintijd);
                            if (!empty($eindtijd)) {
                                print ("<br>$eindtijd");
                            }
                            ?></td>
                        <th class='activiteit'><?php
                            print ($activiteit);
                            ?><br>

                    <form id="bewerk<?php print ($activiteitnr); ?>" method="post">
                        <input type="hidden" name="b1_groepsles" value="<?php print ($activiteit); ?>">
                        <input type="hidden" name="b1_week_dag" value="<?php print ($week_dag); ?>">
                        <input type="hidden" name="b1_begintijd" value="<?php print ($begintijd); ?>">
                        <input type="hidden" name="b1_eindtijd" value="<?php print ($eindtijd); ?>">
                    </form>

                    <form id="verwijder<?php print ($activiteitnr); ?>" method="post">
                        <input type="hidden" name="v_groepsles" value="<?php print ($activiteit); ?>">
                        <input type="hidden" name="v_week_dag" value="<?php print ($week_dag); ?>">
                        <input type="hidden" name="v_begintijd" value="<?php print ($begintijd); ?>">
                    </form>

                    <button class="knopje" onclick="bewerk<?php print ($activiteitnr); ?>()">
                        <img src='../includes/afb/bewerk.png' alt="bewerk">
                        <script>
                            function bewerk<?php echo json_encode($activiteitnr); ?>() {
                                document.getElementById("bewerk<?php echo json_encode($activiteitnr); ?>").submit();
                            }
                        </script>
                    </button>

                    <button class="knopje" onclick="verwijder<?php print ($activiteitnr); ?>()">
                        <img src="../includes/afb/verwijder.png" alt="verwijder">
                        <script>
                            function verwijder<?php echo json_encode($activiteitnr); ?>() {
                                document.getElementById("verwijder<?php echo json_encode($activiteitnr); ?>").submit();
                            }
                        </script>
                    </button>
                    </th>
                    </tr>
                    <?php
                }

                function activiteiten($dag) {
                    // Activiteiten met omschrijvingen en evenementen van een dag uit de database halen en in print_activiteit() stoppen
                    global $link;

                    $stmt = mysqli_prepare($link, "SELECT groepsles, begintijd, eindtijd FROM groepsles_activiteit WHERE week_dag=? ORDER BY begintijd, eindtijd, groepsles");
                    mysqli_stmt_bind_param($stmt, "i", $dag);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $groepsles, $begintijd, $eindtijd);

                    mysqli_stmt_store_result($stmt);
                    $aantalActiviteiten = mysqli_stmt_num_rows($stmt);
                    if ($aantalActiviteiten != 0) {
                        while (mysqli_stmt_fetch($stmt)) {
                            $begintijd = substr($begintijd, 0, 5);
                            $eindtijd = substr($eindtijd, 0, 5);
                            print_activiteit($groepsles, $begintijd, $eindtijd, $dag);
                        }
                    }

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                }

                function openingstijd($dag) {
                    // Openingstijd wordt geprint of "Gesloten op ..."
                    global $link, $dagen, $gesloten;

                    $stmt = mysqli_prepare($link, "SELECT openingstijd FROM openingstijden WHERE week_dag=?");
                    mysqli_stmt_bind_param($stmt, "i", $dag);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $openingstijd);
                    mysqli_stmt_fetch($stmt);

                    $openingstijd = substr($openingstijd, 0, 5);

                    if ($gesloten[$dag]) {
                        ?>
                        <tr>
                            <th colspan="2" class='gesloten'>Gesloten op <?php print ($dagen[$dag]); ?></th>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td><?php
                                print ($openingstijd);
                                ?></td>
                            <th class='activiteit'>Opening</th>
                        </tr>
                        <?php
                    }

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                }

                function sluitingstijd($dag) {
                    // Sluitingstijd wordt geprint indien niet gesloten
                    global $link, $gesloten;

                    $stmt = mysqli_prepare($link, "SELECT sluitingstijd FROM openingstijden WHERE week_dag=?");
                    mysqli_stmt_bind_param($stmt, "i", $dag);

                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $sluitingstijd);
                    mysqli_stmt_fetch($stmt);

                    $sluitingstijd = substr($sluitingstijd, 0, 5);

                    if (!$gesloten[$dag]) {
                        ?>
                        <td class="sluiting">
                            <table>
                                <colgroup>
                                    <col class="agenda_dag_col1">
                                    <col class="agenda_dag_col2">
                                </colgroup>
                                <tr>
                                    <td><?php
                                        print ($sluitingstijd);
                                        ?></td>
                                    <th class='activiteit'>Sluiting</th>
                                </tr>
                            </table>
                        </td>
                        <?php
                    } else {
                        ?>
                        <td></td>
                        <?php
                    }

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                }
                ?>

                <table id="agenda">
                    <colgroup>
                        <?php
                        for ($col = 0; $col < 7; $col++) {
                            ?>
                            <col class="agenda_col">
                        <?php } ?>
                    </colgroup>
                    <tr>
                        <?php
                        for ($dag = 1; $dag <= 7; $dag++) {
                            ?>
                        <form id="bewerk_opening<?php print ($dag); ?>" method="post">
                            <input type="hidden" name="b1_opening" value="<?php print ($dag); ?>">
                        </form>
                        <th>
                            <?php print ($dagen[$dag]); ?>
                            <button class="knopje" onclick="bewerk_opening<?php print ($dag); ?>()">
                                <img src='../includes/afb/bewerk.png' alt="bewerk">
                                <script>
                                    function bewerk_opening<?php echo json_encode($dag); ?>() {
                                        document.getElementById("bewerk_opening<?php echo json_encode($dag); ?>").submit();
                                    }
                                </script>
                            </button>
                        </th>
                    <?php } ?>
                    </tr>
                    <tr class="agenda_dag">
                        <?php
                        for ($dag = 1; $dag <= 7; $dag++) {
                            ?>
                            <td>
                                <table>
                                    <colgroup>
                                        <col class="agenda_dag_col1">
                                        <col class="agenda_dag_col2">
                                    </colgroup>
                                    <?php
                                    openingstijd($dag);
                                    activiteiten($dag);
                                    ?>
                                </table>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr class="agenda_dag">
                        <?php
                        for ($dag = 1; $dag <= 7; $dag++) {
                            ?>
                            <?php
                            sluitingstijd($dag);
                            ?>
                        <?php } ?>
                    </tr>
                </table>

                <input type="text" name="">
                <?php
                if ($_GET["x"] == "x") {


                    $stmt = mysqli_prepare($link, "UPDATE groepsles_activiteit SET groepsles=?, week_dag=?, begintijd=?, eindtijd=NULL WHERE groepsles=? AND week_dag=? AND begintijd=?");
                    mysqli_stmt_bind_param($stmt, "sissis", $b2_groepsles, $b2_week_dag, $b2_begintijd, $b3_groepsles, $b3_week_dag, $b3_begintijd);

                    mysqli_stmt_execute($stmt);
                    $updateGeslaagd = mysqli_affected_rows($link);
                    mysqli_stmt_close($stmt);
                }
                ?>
                <!-- Overzicht eind -->

                <?php mysqli_close($link); ?>
                <!-- Inhoud eind -->

            </div>
        </div>
    </body>
</html>