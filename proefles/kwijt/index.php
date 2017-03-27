<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Proefles Kwijt</title> <!-- Aanpassen -->

        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="template.css"> <!-- Aanpassen -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php include "../../includes/header/header.php"; ?>

        <div id="inhoud_container">
            <div class="inhoud">

                <form method="post">
                    <table>
                        <tr>
                            <td>E-mailadres:</td><td><input type="email" name="email"></td>
                        </tr>
                        <tr>
                            <td></td><td><input type="submit" value="Code opvragen" name="verzenden" align="right"></td>
                        </tr>
                    </table>
                </form>

                <?php
                if (isset($_POST[verzenden])) {
                    $link = databaseConnect();

                    $email = mysqli_real_escape_string($link, $_POST["email"]);

                    $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE email=? AND status= 1");
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $emailBevestigd);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);


                $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE email=? AND status= 2");
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $proeflesGehad);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_free_result($stmt);
                mysqli_stmt_close($stmt);

if($proeflesGehad){
print("Volgens ons systeem is de proefles al ingepland. Indien dit niet het geval is, kunt u <a href='../../contact/'>contact</a> met ons opnemen. ");
                    }elseif ($emailBevestigd) {
                        print("U bent al aangemeld voor een proefles, er wordt z.s.m. contact met u opgenomen. U kunt ook <a href='../../contact/'>contact</a> met ons opnemen.");
                    } else {

                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE email= ? AND status= 0 AND aantal_mails = 1");
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $count1);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);

                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE email= ? AND status= 0 AND aantal_mails = 2");
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $count2);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);

                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM proefles WHERE email= ? AND status= 0 AND aantal_mails = 3");
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $count3);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);

                        if ($count1) {

                            $stmt = mysqli_prepare($link, "SELECT activatiecode FROM proefles WHERE email=?");
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $activatiecode);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);

                            $stmt = mysqli_prepare($link, "UPDATE proefles SET aantal_mails = 2 WHERE email=?");
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);


                            $onderwerp = "Bevestig uw e-mailadres (T.H. Sport)";
                            $headers = "From: T.H. Sport <test@thsport.comoj.com>" . "\r\n";
                            $headers .= "Reply-To: test@thsport.comoj.com" . "\r\n";
                            $omschrijving = "U heeft een proefles aangevraagd bij T.H. Sport. Bevestig uw e-mailadres om de aanvraag te voltooien. "
                                    . "Houd er rekening mee dat u al eerder een mail van ons heeft ontvangen. De bevestigingslink is tot uiterlijk een week na het ontvangen van de eerste mail beschikbaar. "
                                    . "U kunt de bevestigingsmail na deze mail maximaal één keer opnieuw aanvragen.\r\n\r\n";
                            $bevestigingslink = "http://" . $_SERVER["SERVER_NAME"] . "/proefles/activatie/?code=" . $activatiecode;
                            $mail_verzonden = @mail($email, $onderwerp, $omschrijving . $bevestigingslink, $headers);


                            if ($mail_verzonden) {
                                print ("<p id='mail_succes'>Er is een mail gestuurd met een bevestigingslink naar $email. Klik op de bevestigingslink in de mail om uw aanmelding te voltooien.</p>");
                            } else {
                                print ("<p id='mail_faal'>Fout: Er is iets fout gegaan, excuses voor het ongemak.</p>");
                            }
                        } elseif ($count2) {

                            $stmt = mysqli_prepare($link, "SELECT activatiecode FROM proefles WHERE email=?");
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $activatiecode);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);

                            $stmt = mysqli_prepare($link, "UPDATE proefles SET aantal_mails = 3 WHERE email=?");
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);


                            $onderwerp = "Bevestig uw e-mailadres (T.H. Sport)";
                            $headers = "From: T.H. Sport <test@thsport.comoj.com>" . "\r\n";
                            $headers .= "Reply-To: test@thsport.comoj.com" . "\r\n";
                            $omschrijving = "U heeft een proefles aangevraagd bij T.H. Sport. Bevestig uw e-mailadres om de aanvraag te voltooien. "
                                    . "Houd er rekening mee dat u al eerder een mail van ons heeft ontvangen. De bevestigingslink is tot uiterlijk een week na het ontvangen van de eerste mail beschikbaar. "
                                    . "U kunt de bevestigingsmail niet meer aanvragen.\r\n\r\n";
                            $bevestigingslink = "http://" . $_SERVER["SERVER_NAME"] . "/proefles/activatie/?code=" . $activatiecode;
                            $mail_verzonden = @mail($email, $onderwerp, $omschrijving . $bevestigingslink, $headers);


                            if ($mail_verzonden) {
                                print ("<p id='mail_succes'>Er is een mail gestuurd met een bevestigingslink naar $email. Klik op de bevestigingslink in de mail om uw aanmelding te voltooien.</p>");
                            } else {
                                print ("<p id='mail_faal'>Fout: Er is iets fout gegaan, excuses voor het ongemak.</p>");
                            }
                        } elseif ($count3) {
                            print("U heeft al drie keer eerder een bevestigingsmail aangevraagd, Dus kunt u dit niet meer doen. De mail kan in de ongewest map van uw mailapplicatie terecht komen.");
                        } else {
                            print("<br>Dit e-mailadres is onbekend. <br>Heeft u al eerder een proefles aanvraagd bij T.H. Sport? "
                                    . "Houd er dan rekening mee dat uw gegevens na een week verwijderd worden als u uw e-mailadres niet heeft geactiveerd. <br><br> <a href='../index.php'>Klik hier</a>  om terug te gaan.");
                        }
                    }
                    mysqli_close($link);
                }
                ?>
            </div>
        </div>

        <?php include "../../includes/footer/footer.php"; ?>
    </body>
</html>
