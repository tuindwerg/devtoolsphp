<form id="contactformulier" method="post">

    <?php
    // Er wordt een mail verzonden naar de beheerder en een bevestigingsmail naar de gebruiker
    // Kan mogelijk niet werken i.v.m. host
    if (isset($_POST["verzend_contact"])) {
        $voornaam = ucfirst($_POST["voornaam"]);
        $achternaam = ucfirst($_POST["achternaam"]);
        $email = $_POST["email"];

        // Bericht samenstellen
        $afzender = "Naam: " . $voornaam . " " . $achternaam . "\r\n";
        $afzender .= "E-mailadres: " . $email . "\r\n\r\n---\r\n\r\n";
        $bericht = str_replace("\n.", "\n..", $afzender . $_POST["bericht"]);

        // Verzend naar admin
        $onderwerp = $voornaam[0] . ". " . $achternaam . " (contactformulier)";
        $headers = "From: " . $voornaam . " " . $achternaam . " <" . $email . ">" . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $omschrijving1 = "Iemand heeft het contactformulier ingevuld:\r\n\r\n";
        $mail1_verzonden = @mail("admin@thsport.webatu.com", $onderwerp, $omschrijving1 . $bericht, $headers);

        // Verzend naar gebruiker
        $onderwerp = "Uw bericht is verzonden (T.H. Sport)";
        $headers = "From: T.H. Sport <admin@thsport.webatu.com>" . "\r\n";
        $headers .= "Reply-To: admin@thsport.webatu.com" . "\r\n";
        $omschrijving2 = "Uw bericht is verzonden en wordt z.s.m. beantwoordt:\r\n\r\n";
        $mail2_verzonden = @mail($email, $onderwerp, $omschrijving2 . $bericht, $headers);

        // Controle
        if ($mail1_verzonden && $mail2_verzonden) {
            print ("<p id='succes'>Het bericht is succesvol verzonden</p>");
        } else {
            print ("<p id='faal'>Fout: Het bericht is niet verzonden (" . $mail1_verzonden . $mail2_verzonden . ")</p>");
        }
    }
    ?>

    <table>
        <tr>
            <th>Naam:</th>
            <td><input type="text" name="voornaam" placeholder="Voornaam" maxlength="35" required></td>
            <td id="contactformulier_ruimte"></td>
            <td><input type="text" name="achternaam" placeholder="Achternaam" maxlength="35" required></td>
        </tr>
        <tr>
            <th>E-mailadres:</th>
            <td colspan="3"><input type="email" name="email" maxlength="255" required></td>
        </tr>
        <tr>
            <th>Bericht:</th>
            <td colspan="3">
                <textarea name="bericht" rows="7" maxlength="500" required></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>
                <input type="submit" name="verzend_contact" value="Verzend">
            </td>
        </tr>
    </table>
</form>
