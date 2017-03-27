<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Proefles aanmelding</title>
        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        <?php include "../includes/header/header.php"; ?>
        <div id="inhoud_container">
            <div class="inhoud">
                <?php
                //Er wordt gecontroleerd of alle velden is ingevuld.
                $volledigIngevuld = TRUE;
                if (isset($_POST["versturen"])) {
                    // Er is op "Verstuur" geklikt
                    foreach ($_POST as $key => $value) {
                        if (empty($_POST[$key])) {
                            $volledigIngevuld = FALSE;
                        }
                    }
                } else {
                    $volledigIngevuld = FALSE;
                }
                //controle als het formulier volledig is ingevuld
                if ($volledigIngevuld) {
                    //Databaseconnectie word gemaakt.
                    $link = databaseConnect();
                    //worden de ingevulde velden en de datum worden gekoppeld aan de variabelen.
                    date_default_timezone_set("Europe/Berlin");
                    $voornaam = mysqli_real_escape_string($link, $_POST["voornaam"]);
                    $achternaam = mysqli_real_escape_string($link, $_POST["achternaam"]);
                    $email = mysqli_real_escape_string($link, $_POST["email"]);
                    $telnr = mysqli_real_escape_string($link, $_POST["telnr"]);
                    $ingestuurd = mysqli_real_escape_string($link, date("Y-m-d"));
                    $status = mysqli_real_escape_string($link, 0);
                    $aantal_mails = mysqli_real_escape_string($link, 1);
                    // Controle of e-mailadres al in proefles staat.
                    $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE email=? AND status = 0");
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $emailBestaat);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                    // Controle of e-mailadres al in proefles staat.
                    $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE email=? AND status = 1");
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $emailBevestigd);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                    // Controle of je al een proefes hebt gehad.
                    $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE email=? AND status = 2");
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $emailGehad);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                    //De uitkomst van de controle wordt weergegeven aan de gebruiker.
                    if ($emailBestaat) {
                        print ("De bevestigingsmail is reeds naar u verzonden. <a href='./kwijt/'>Klik hier</a> om de e-mail opnieuw te verzenden.");
                    } elseif ($emailBevestigd) {
                        print ("U heeft zich al aangemeld voor een proefles, er wordt z.s.m. contact met u opgenomen. U kunt ook <a href='../contact/'>contact</a> met ons opnemen.");
                    } elseif ($emailGehad) {
                        print ("Volgens ons systeem is de proefles al ingepland. Indien dit niet het geval is, kunt u <a href='../contact/'>contact</a> met ons opnemen. ");
                    } else {
                        //Als bij alle controles FALSE uitkomt, dan wordt er een unieke code aangemaakt.
                        $codeBestaat = TRUE;
                        while ($codeBestaat) {
                            $activatiecode1 = activatiecode();
                            $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE activatiecode=?");
                            mysqli_stmt_bind_param($stmt, "s", $activatiecode);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $codeBestaat);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);
                        }
                        //De gegevens worden in de database toegevoegd.
                        $stmt = mysqli_prepare($link, "INSERT INTO proefles VALUES (?, ?, ?, ?, ?, ?, NULL, ?, ?)");
                        mysqli_stmt_bind_param($stmt, "ssssssii", $email, $voornaam, $achternaam, $telnr, $activatiecode, $ingestuurd, $status, $aantal_mails);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);
                        // Verzend bevestigingsmail
                        $onderwerp = "Bevestig uw e-mailadres (T.H. Sport)";
                        $headers = "From: T.H. Sport <test@thsport.comoj.com>" . "\r\n";
                        $headers .= "Reply-To: test@thsport.comoj.com" . "\r\n";
                        $omschrijving = "U heeft een proefles aangevraagd bij T.H. Sport. Bevestig uw e-mailadres om de aanvraag te voltooien. "
                                . "De bevestigingslink is tot uiterlijk een week na het ontvangen van de mail beschikbaar. "
                                . "U kunt de bevestigingsmail maximaal twee keer opnieuw aanvragen. \r\n\r\n";
                        $bevestigingslink = "http://" . $_SERVER["SERVER_NAME"] . "/proefles/activatie/?code=" . $activatiecode;
                        $mail_verzonden = @mail($email, $onderwerp, $omschrijving . $bevestigingslink, $headers);

                        // Controle of de mail is verzonden
                        if ($mail_verzonden) {
                            print ("<p>Er is een bevestigingsmail verzonden met een bevestigingslink naar $email. Klik op deze link om uw aanmelding te voltooien.</p>");
                        } else {
                            print ("<p>Fout! Er is iets fout gegaan, excuses voor het ongemak. We raden u aan om <a href='../contact/'>contact</a> met ons opnemen. </p>");
                        }
                    }
                    //Databaseconnectie afsluiten
                    mysqli_close($link);
                } else {
                    ?>
                    <!-- Formulier wordt weergegeven, Als je een  veld leeg laat worden de ingevulde velden eer voor je ingevuld -->
                    <form method="post">
                        <table>
                            <tr><td>Voornaam:       </td><td><input type="text" name="voornaam" maxlength="45" value="<?php
                                    if (isset($_POST["voornaam"])) {
                                        print ($_POST["voornaam"]);
                                    }
                                    ?>"></td><td><?php formulier_ingevuld("voornaam"); ?></td></tr>
                            <tr><td>Achternaam:     </td><td><input type="text" name="achternaam" maxlength="45" value="<?php
                                    if (isset($_POST["achternaam"])) {
                                        print ($_POST["achternaam"]);
                                    }
                                    ?>"></td><td><?php formulier_ingevuld("achternaam"); ?></td></tr>
                            <tr><td>E-mailadres:    </td><td><input type="email" name="email" maxlength="255" value="<?php
                                    if (isset($_POST["email"])) {
                                        print ($_POST["email"]);
                                    }
                                    ?>"></td><td><?php formulier_ingevuld("email"); ?></td></tr>
                            <tr><td>Telefoonnummer: </td><td><input type="tel" name="telnr" maxlength="10" value="<?php
                                    if (isset($_POST["telnr"])) {
                                        print ($_POST["telnr"]);
                                    }
                                    ?>"></td><td><?php formulier_ingevuld("telnr"); ?></td></tr>
                            <tr><td></td><td><input type="submit" value="Aanmelden" name="versturen"></td></tr>
                        </table>
                    </form>
                    <a href="./kwijt">Activatiecode kwijt?</a>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php include "../includes/footer/footer.php"; ?>
    </body>
</html>
