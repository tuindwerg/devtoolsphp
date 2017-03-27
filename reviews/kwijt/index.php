<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Review activatiecode opvragen</title>
        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="template.css"> <!-- Aanpassen -->

        <!--jQuery word vanaf Google ingeladen en gebruikt op de pagina.-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php 
        // De header word opgehaald vanuit de includes.
        include "../../includes/header/header.php"; ?>

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
                    
                    // De variabele word beschermd tegen SQL injecties.
                    $email = mysqli_real_escape_string($link, $_POST["email"]);
                    // Controleert of het e-mailadres wel voorkomt in de database voordat de code verstuurd kan worden.
                    $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE email=? AND status= 1");
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $emailBevestigd);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                    
                    // Controleert of het e-mailadres wel voorkomt in de database én of de review niet al is toegevoegd. 
                    // Hierop wordt een ander antwoord gegeven in de tekst naar de gebruiker.
                    $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE email=? AND status= 2");
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $reviewToegevoegd);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);

                    // De controle of de review niet al bevestigd of zelfs toegevoegd is.
if($reviewToegevoegd){
print("Volgens ons systeem is uw review al toegevoegd. Indien dit niet het geval is, kunt u <a href='../../contact/'>contact</a> met ons opnemen. ");
                    }elseif ($emailBevestigd) {
                        print("U heeft al een review ingestuurd, deze word bekeken door de administrator. U kunt ook <a href='../../contact/'>contact</a> met ons opnemen.");
                    } else {
                        
                        // Als de review nog niet bevestigd is door gebruiker en/of door de administrator kan deze maximaal 3 keer zijn code opnieuw opvragen.
                        // Hieronder de controles voor hoe vaak de gebruiker al zijn code heeft opgevraagd.
                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE email= ? AND status= 0 AND aantal_mails = 1");
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $count1);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);

                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE email= ? AND status= 0 AND aantal_mails = 2");
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $count2);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);

                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE email= ? AND status= 0 AND aantal_mails = 3");
                        mysqli_stmt_bind_param($stmt, "s", $email);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $count3);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);

                        // Als er nog maar 1 e-mail verstuurd is word hierna bijgewerkt dat de tweede mail verstuurd is. 
                        // En vervolgens word de mail ook daadwerkelijk verstuurd naar de gebruiker.
                        if ($count1) {
                            
                            $stmt = mysqli_prepare($link, "SELECT activatiecode FROM review WHERE email=?");
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $activatiecode);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);

                            $stmt = mysqli_prepare($link, "UPDATE review SET aantal_mails = 2 WHERE email=?");
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);


                            $onderwerp = "Bevestig uw e-mailadres (T.H. Sport)";
                            $headers = "From: T.H. Sport <test@thsport.comoj.com>" . "\r\n";
                            $headers .= "Reply-To: test@thsport.comoj.com" . "\r\n";
                            $omschrijving = "U heeft een review ingestuurd bij T.H. Sport. Bevestig uw e-mailadres om de aanvraag te voltooien. "
                                    . "Houdt er rekening mee dat u al eerder een mail van ons heeft ontvangen. De bevestigingslink is tot uiterlijk een week na het ontvangen van de eerste mail beschikbaar. "
                                    . "U kunt de bevestigingsmail na deze mail nog maximaal één keer opnieuw aanvragen.\r\n\r\n";
                            $bevestigingslink = "http://" . $_SERVER["SERVER_NAME"] . "/reviews/confirm.php?code=" . $activatiecode;
                            $mail_verzonden = @mail($email, $onderwerp, $omschrijving . $bevestigingslink, $headers);


                            if ($mail_verzonden) {
                                print ("<p id='mail_succes'>Er is een mail gestuurd met een bevestigingslink naar $email. Klik op de bevestigingslink in de mail om uw aanmelding te voltooien.</p>");
                            } else {
                                print ("<p id='mail_faal'>Fout: Er is iets fout gegaan, excuses voor het ongemak.</p>");
                            }
                        } elseif ($count2) {

                            
                        // Als er al 2 e-mails verstuurd zijn word hierna bijgewerkt dat de derde en daarmee laatste mail verstuurd is. 
                        // En vervolgens word de mail ook daadwerkelijk verstuurd naar de gebruiker.
                            $stmt = mysqli_prepare($link, "SELECT activatiecode FROM review WHERE email=?");
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $activatiecode);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);

                            $stmt = mysqli_prepare($link, "UPDATE review SET aantal_mails = 3 WHERE email=?");
                            mysqli_stmt_bind_param($stmt, "s", $email);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);


                            $onderwerp = "Bevestig uw e-mailadres (T.H. Sport)";
                            $headers = "From: T.H. Sport <test@thsport.comoj.com>" . "\r\n";
                            $headers .= "Reply-To: test@thsport.comoj.com" . "\r\n";
                            $omschrijving = "U heeft een review ingestuurd bij T.H. Sport. Bevestig uw e-mailadres om de aanvraag te voltooien. "
                                    . "Houd er rekening mee dat u al eerder een mail van ons heeft ontvangen. De bevestigingslink is tot uiterlijk een week na het ontvangen van de eerste mail beschikbaar. "
                                    . "U kunt de bevestigingsmail niet meer aanvragen.\r\n\r\n";
                            $bevestigingslink = "http://" . $_SERVER["SERVER_NAME"] . "/reviews/confirm.php??code=" . $activatiecode;
                            $mail_verzonden = @mail($email, $onderwerp, $omschrijving . $bevestigingslink, $headers);


                            if ($mail_verzonden) {
                                print ("<p id='mail_succes'>Er is een mail gestuurd met een bevestigingslink naar $email. Klik op de bevestigingslink in de mail om uw review te activeren.</p>");
                            } else {
                                print ("<p id='mail_faal'>Fout: Er is iets fout gegaan, excuses voor het ongemak.</p>");
                            }
                        } elseif ($count3) {
                            print("U heeft al drie keer eerder een bevestigingsmail aangevraagd. De mail kan in de ongewenste e-mail map van uw mailapplicatie terecht zijn gekomen.");
                        } else {
                            print("<br>Dit e-mailadres is onbekend. <br>Heeft u al eerder een review ingestuurd bij T.H. Sport? "
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
