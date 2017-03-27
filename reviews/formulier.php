<head>
<link rel="stylesheet" type="text/css" href="../includes/header/header.css">
</head>

<?php 
// De verbinding met de database word geopend vanuit de daarvoor aangemaakte functie.
$link = databaseConnect();

if (isset($_POST["submit"])) {
    // Hier worden ingevoerde waardes uit het formulier weggeschreven in beveiligde variabelen.
    $vnaam = mysqli_real_escape_string($link, $_POST["vnaam"]);
    $anaam = mysqli_real_escape_string($link, $_POST["anaam"]);
    $email = mysqli_real_escape_string($link, $_POST["email"]);
    $bericht = mysqli_real_escape_string($link, $_POST["bericht"]);
    $ster = mysqli_real_escape_string($link, $_POST["ster"]);
    $bevestiging = mysqli_real_escape_string($link, 0);
    $aantal_mails = mysqli_real_escape_string($link, 1);
    
    // Query die nakijkt of de gegenereerde sleutel niet al bestaat en zoniet een nieuwe aanmaakt.
    $checkcode = TRUE;
        while ($checkcode) {
            $code = activatiecode(15);
            $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE activatiecode=?");
            mysqli_stmt_bind_param($stmt, "s", $code);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $checkcode);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);
        }
        
    // Controleren of het ingevoerde e-mailadres al bestaat in de database.
        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM review WHERE email=? AND (status = 0 OR status = 1 OR status = 2)");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $emailBestaat);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        
    // Het opnemen van de nieuwe review in de database.
        $stmt = mysqli_prepare($link, "INSERT INTO review VALUES (?,?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, "ssssiisi", $vnaam, $anaam, $email, $bericht, $ster, $bevestiging, $code, $aantal_mails);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);

    // Activatiemail die vanaf server verstuurd word na het insturen van formulier.
    $onderwerp = "Bevestig uw e-mailadres (T.H. Sport)";
    $headers = "From: T.H. Sport <noreply@th-sport.nl>" . "\r\n";
    $headers .= "Reply-To: noreply@th-sport.nl" . "\r\n";
    $omschrijving = "Beste $vnaam $anaam,\r\n\r\n"
            . " "
            . " Bedankt voor het insturen van een review op de website van T.H. Sport. "
            . "Voordat deze geplaatst kan worden moet deze geactiveerd worden met de code in deze e-mail. "
            . "De bevestigingslink is tot uiterlijk een week na het ontvangen van de mail beschikbaar. "
            . "U kunt de activeringsmail maximaal twee keer opnieuw aanvragen. \r\n\r\n"
            . "\r\n"
            . "Hieronder de door u ingestuurde review:\r\n\r\n"
            . "Waardering: $ster \r\n"
            . "Uw bericht: $bericht \r\n\r\n"
            . "Uw activatie link, kopieer deze in uw browser om uw review in te sturen:\r\n\r\n";
    $bevestigingslink = "http://thsport.comoj.com/reviews/confirm.php?code=" . $code;
    $mail_verzonden = @mail($email, $onderwerp, $omschrijving . $bevestigingslink, $headers);
}
?>
<!--De div waarin het formulier word geplaatst-->
<div id="inhoud_container">
            <div class="review">
                <div class="header">
                    <!--Hier word het jQuery script gebruikt voor het uitschijven of dichtklappen van het formulier.-->
                    <a class="review2" value="Collapse/Expand" onclick="return CollapseExpand()">Review schrijven</a>
                </div>
                <div class="content">
                  <?php
                    // Als het formulier NIET leeg is en word ingestuurd, en het e-mailadres bestaat nog niet in de database, word er een bevestiging geprint.
                    // Anders, als het e-mailadres al bestaat, word dit weergegeven en heeft de gebruiker een optie om terug te gaan of een nieuwe code op te vragen, indien deze kwijt is.
                    // Daarnaast word het formulier desbetreffend geopend of gesloten.
                    if (!empty($_POST["vnaam"]) &&
                        !empty($_POST["anaam"]) &&
                        !empty($_POST["email"]) &&
                        !empty($_POST["bericht"]) &&
                        !empty($_POST["ster"]) &&
                        isset($_POST["submit"])) {
                            if ($emailBestaat) {
                                print("<div id='reviewjs' class='divVisible'>"
                                . "<p class=\"wit\">Het e-mailadres wat u heeft ingevoerd (".$_POST["email"].")is al bekend in onze database. "
                                . "U kunt per persoon slechts 1 review insturen.<br><br> Mogelijk bent u uw activatiecode vergeten. "
                                . "Deze kunt u <a href='/reviews/kwijt'>hier</a> opvragen."
                                . "<a href='/'>Klik hier om terug te gaan naar de thuispagina.</a></p></div>");
                            } else {
                                print("<div id='reviewjs' class='divVisible'>"
                                . "<p class=\"wit\">Uw review is aangemaakt, maar <b>nog niet bevestigd</b>. "
                                . "We hebben een mail verzonden naar " . $_POST["email"] . " met een activatiecode."
                                . "<br> Voordat uw review toegevoegd kan worden, moet u deze per e-mail bevestigen. "
                                . "<br><b>Let op:</b> Je review moet binnen 7 dagen bevestigd worden.<br><br> "
                                . "<a href='/'>Klik hier om terug te gaan naar de thuispagina.</a></p></div>");
                            }
                    } elseif (empty($_POST["vnaam"]) ||
                            empty($_POST["anaam"]) ||
                            empty($_POST["email"]) ||
                            empty($_POST["bericht"]) ||
                            empty($_POST["ster"])) {
                        print("<div id='reviewjs' class='");
                            if (!isset($_POST["submit"])) {
                                print("divHidden'>"); // Als alle waarden leeg zijn en het formulier is nog niet ingestuurd is het formulier nog dicht.
                        } else {
                            print("divVisible'>"); // Anders wordt de div uitgeklapt en word het formulier zichtbaar.
                        }
                        ?>
                            <form method="POST" id="review">
                                 <table>
                                     <?php
                                     // Als het formulier wordt ingestuurd met ergens een lege waarde verschijnt de melding dat alle velden verplicht zijn.
                                     if (isset($_POST["submit"]) && (
                                         empty($_POST["vnaam"]) ||
                                         empty($_POST["anaam"]) ||
                                         empty($_POST["email"]) ||
                                         empty($_POST["bericht"]) ||
                                         empty($_POST["ster"]))) { 
                                     ?>
                                     <tr>
                                         <td colspan="2">
                                            <?php print("<h5>De velden met een * zijn verplicht.</h5>");?>
                                         </td>
                                     </tr>
                                     <?php } ?>
                                     <tr>
                                         <td><label>
                                                 Voornaam: <?php
                                                 // Er word per veld nagekeken of de waarde niet leeg is, 
                                                 // anders wordt er bij het desbetreffende veld een rode asterisk geprint.
                                                 if (isset($_POST["submit"]) && (empty($_POST["vnaam"]))) {
                                                     print("<rood>*</rood>");
                                                     } 
                                                 ?></label></td>
                                         <td><input class="form" type="text" name="vnaam" maxlength="50" placeholder="Voornaam" value="<?php
                                         if (isset($_POST["submit"]) && (isset($vnaam))) {
                                                 print($vnaam);
                                             } 
                                             ?>"></td>
                                     </tr>
                                     <tr>
                                         <td><label>
                                                 Achternaam: <?php
                                                 if (isset($_POST["submit"]) && (empty($_POST["anaam"]))) {
                                                     print("<rood>*</rood>");
                                                 } 
                                                 ?></label></td>
                                         <td><input class="form" type="text" name="anaam" maxlength="50" placeholder="Achternaam" value="<?php
                                             if (isset($anaam)) {
                                                 print($anaam);
                                             }
                                             ?>"></td>
                                     </tr>
                                     <tr>
                                         <td><label>
                                                 E-mail: <?php
                                                 if (isset($_POST["submit"]) && (empty($_POST["email"]))) {
                                                     print("<rood>*</rood>");
                                                 } 
                                                 ?></label></td>
                                         <td><input class="form" type="email" name="email" maxlength="50" placeholder="E-mailadres" value="<?php
                                             if (isset($email)) {
                                                 print($email);
                                             }
                                             ?>"></td>
                                     </tr>
                                     <tr>
                                         <td><label>Review:
                                                 <?php
                                                 if (isset($_POST["submit"]) && (empty($_POST["bericht"]))) {
                                                     print("<rood>*</rood>");
                                                 } 
                                                 ?></label></td>
                                         <td><textarea class="form" form="review" rows="5" cols="15" name="bericht" maxlength="140" placeholder="Maximaal 140 tekens" value="<?php
                                             if (isset($bericht)) {
                                                 print($bericht);
                                             }
                                             ?>"></textarea></td>
                                     </tr>
                                     <tr>
                                         <td></td>
                                     </tr>
                                     <tr>
                                         <td>
                                             <label>Waardering: <?php
                                                 if (isset($_POST["submit"]) && (empty($_POST["ster"]))) {
                                                     print("<rood>*</rood>");
                                                 } 
                                                 ?></label>
                                         </td>
                                         <td>
                                             <div class="sterren">
                                                 <input class="form" type="radio" name="ster" class="ster-1" id="ster-1" value="
                                                        <?php
                                             if (isset($ster)) {
                                                 print($ster);
                                             }
                                             ?>"/>
                                                 <label class="ster-1" for="ster-1">1</label>
                                                 <input type="radio" name="ster" class="ster-2" id="ster-2" value="2"/>
                                                 <label class="ster-2" for="ster-2">2</label>
                                                 <input type="radio" name="ster" class="ster-3" id="ster-3" value="3"/>
                                                 <label class="ster-3" for="ster-3">3</label>
                                                 <input type="radio" name="ster" class="ster-4" id="ster-4" value="4"/>
                                                 <label class="ster-4" for="ster-4">4</label>
                                                 <input type="radio" name="ster" class="ster-5" id="ster-5" value="5"/>
                                                 <label class="ster-5" for="ster-5">5</label>
                                                 <span></span>
                                             </div>
                                         </td>
                                     </tr>
                                     <tr>
                                         <!--Een mogelijkheid om een nieuwe activatiecode op te vragen.-->
                                         <td></td><td><a class="form" href='/reviews/kwijt'>Activatiecode kwijt?</a></td>
                                     </tr>
                                     <tr>
                                         <td></td><td><button type="submit" name=submit>Insturen</button></td>
                                     </tr>
                                 </table>
                             </form>
                         <?php
                        print("</div>");
                    } else {
                        print("<div id='reviewjs' class='divHidden'></div>");
                    }
                    ?>

                </div>
            </div>