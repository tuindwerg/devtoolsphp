<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Abonnementen</title>

        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="abonnementen.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="hideshow.js" ></script> <!-- Voor de hide en show functie -->
    </head>

    <body>
        <?php
        include "../includes/header/header.php";

        // als sessie stap nog niet bestaat zet die hem op stap 1
        if (!isset($_SESSION["stap"])) {
            $_SESSION["stap"] = 1;
        }

        // Wijzigen knop controle pagina.
        if ($_SESSION["stap"] == 3 && isset($_GET["stap"])) {
            if ($_GET["stap"] == 1) {
                $_SESSION["stap"] = 1;
            } elseif ($_GET["stap"] == 2) {
                $_SESSION["stap"] = 2;
            } elseif ($_GET["stap"] == 3) {
                $_SESSION["stap"] = 4;
            }
        }

        // Alle inputs die geprint moeten worden in de foreach
        $form1 = array(
            "voornaam" => "text",
            "achternaam" => "text",
            "adres" => "text",
            "postcode" => "text",
            "woonplaats" => "text",
            "email" => "email",
            "telefoonnummer" => "text",
            "geboortedatum" => "date",
        );

// Controle of alle velden zijn ingevuld bij formulier 1
        if (isset($_POST["form1"])) {
            foreach ($form1 as $input => $type) {
                if (ingevuld($input)) {
                    $_SESSION["stap"] = 2;
                } else {
                    $_SESSION["stap"] = 1;
                    break;
                }
            }
            if (!ingevuld("abonnement")) {
                $_SESSION["stap"] = 1;
            }
        }
// controle of alle velden zijn ingevuld bij formulier 2
        if (isset($_POST["form2"])) {
            $allesingevuld = TRUE;

            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag1", "vraag1_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag1", "vraag1_2");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag2", "vraag2_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag3", "vraag3_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag4", "vraag4_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag5", "vraag5_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag6", "vraag6_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag7", "vraag7_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag8", "vraag8_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag9", "vraag9_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag10", "vraag10_1");
            }
            if ($allesingevuld) {
                $allesingevuld = controlform2("vraag11", "", FALSE);
            }if ($allesingevuld) {
                $allesingevuld = controlform2("vraag12", "", FALSE);
            }if ($allesingevuld) {
                $allesingevuld = controlform2("vraag13", "", FALSE);
            }
            if ($allesingevuld) {
                // Alles opslaan in een sessie mocht alles ingevuld zijn.
                foreach ($_POST as $key => $value) {
                    $_SESSION[$key] = $_POST[$key];
                }
                $_SESSION["stap"] = 3;
            }
        }
        print ("<div id = 'inhoud_container'>");
        print ("<div class = 'inhoud'>");
// als stap op 1 staat moet die dit laten zien
        if ($_SESSION["stap"] == 1) {
            ?>


            <!-- Inhoud begin -->
            <table id="abonnementen" class="gesplitst">
                <tr>
                    <td>
                        <h1>Abonnementen</h1>
                        <table id="abo_tabel1">
                            <tr>
                                <th>Abonnement</th>
                                <th>Incl. groepslessen</th>
                                <th>Prijs (p/m)</th>
                            </tr>
                            <tr>
                                <td>Onbeperkt jaarcontract</td>
                                <td class="centreer_tekst">Ja</td>
                                <td>€27,50</td>
                            </tr>
                            <tr>
                                <td>Onbeperkt kwartaalcontract</td>
                                <td class="centreer_tekst">Ja</td>
                                <td>€30,-</td>
                            </tr>
                            <tr>
                                <td>Dagtraining jaarcontract</td>
                                <td class="centreer_tekst">Ja</td>
                                <td>€22,50</td>
                            </tr>
                            <tr>
                                <td>Dagtraining kwartaalcontract</td>
                                <td class="centreer_tekst">Ja</td>
                                <td>€25,-</td>
                            </tr>
                            <tr>
                                <td>Eén keer per week sporten</td>
                                <td class="centreer_tekst">Nee</td>
                                <td>€17,50</td>
                            </tr>
                            <tr>
                                <td>Twee keer per week sporten</td>
                                <td class="centreer_tekst">Nee</td>
                                <td>€22,50</td>
                            </tr>
                        </table>

                        <br>

                        <table id="abo_tabel2">
                            <tr>
                                <th>Voor alle abonnementen geldt:</th>
                            </tr>
                            <tr>
                                <td>
                                    <ul>
                                        <li>Inschrijfgeld €20,-</li>
                                        <li>Ledenkaart €5,-</li>
                                        <li>Eén maand opzegtermijn</li>
                                    </ul>
                                </td>
                            </tr>
                        </table>

                        <br>

                        <h3>Voorwaarden:</h3>
                        <p id="abo_voorwaarden">
                            Jaar- en kwartaalabonnementen zijn alleen te gebruiken op de volgende tijdstippen:<br>
                        </p>
                        <ul id="abo_voorwaarden_ul">
                            <li>Maandag t/m vrijdag van 08:30 tot 17:00 uur</li>
                            <li>Zaterdag van 08:30 tot 13:00 uur</li>
                        </ul>

                        <br>

                        <p><i>Ook bieden wij jeugd- en gezinsabonnementen aan. Neem voor meer info hierover <a href="../contact">contact</a> met ons op.</i></p>
                    </td>
                    <td>
                        <div id="inschrijfformulier">
                            <h1>Schrijf je in</h1>
                            <?php include "inschrijfformulier.php" ?>
                        </div>
                    </td>
                <tr>
            </table>
            <!-- Inhoud eind -->




            <?php
// nu zijn we bij stap 2
        } elseif ($_SESSION["stap"] == 2) {
// alle gegevens opslaan van post naar sessie
            if (isset($_POST["form1"])) {
                foreach ($form1 as $input => $type) {
                    $_SESSION[$input] = $_POST[$input];
                }
// deze zijn appart omdat dit niet in een array staat.
                $_SESSION["abonnement"] = $_POST["abonnement"];
                $_SESSION["form1"] = $_POST["form1"];
            }
            print("<div class='intakeformulier'>");
            include "intakeformulier.php";
            print ("</div>");
// als stap 3 is dan moet die control.php include.
        } elseif ($_SESSION["stap"] == 3) {
            include "control.php";
// als stap 4 is dan moet die tmp.php include.
        } elseif ($_SESSION["stap"] == 4) {
            include "tmp.php"; // hier staan de gegevens om een mail te sturen naar de gebruiker en de database koppeling dat alle gegevens worden opgeslagen.
        }
        print ("</div>");
        print ("</div>");
        include "../includes/footer/footer.php";
        ?>
    </body>
</html>