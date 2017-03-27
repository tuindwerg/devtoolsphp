<?php
if ($_SESSION["stap"] == 1) {
// Formulier 1 weergeven
    ?>
    <form method="post">
        <table>
    <?php
    // Formulier 1 (grotendeels) aanmaken via een array
    foreach ($form1 as $input => $type) {
        ?>
                <tr>
                    <th><?php print (ucfirst($input) . ":"); ?></th>
                    <td>
                        <input
                            type="<?php print ($type); ?>"
                            name="<?php print ($input); ?>"
                            value="<?php form_value($input); ?>"
                            >
                    </td>
                    <td class="verplicht"><?php ingevuld($input, TRUE); ?></td>
                </tr>
        <?php
    }
    ?>

            <!-- Deze tr kan niet in de foreach -->
            <tr>
                <th>Abonnement:</th>
                <td>
                    <select name="abonnement" value="<?php form_value("abonnement"); ?>">
                        <option value="">--- Kies een abonnement ---</option>
                        <option value="onb_jaar" <?php form_value("abonnement", "onb_jaar"); ?>>Onbeperkt jaarcontract</option>
                        <option value="onb_kwart" <?php form_value("abonnement", "onb_kwart"); ?>>Onbeperkt kwartaalcontract</option>
                        <option value="dag_jaar" <?php form_value("abonnement", "dag_jaar"); ?>>Dagtraining jaarcontract</option>
                        <option value="dag_kwart" <?php form_value("abonnement", "dag_kwart"); ?>>Dagtraining kwartaalcontract</option>
                        <option value="sport1" <?php form_value("abonnement", "sport1"); ?>>Een keer per week sporten</option>
                        <option value="sport2" <?php form_value("abonnement", "sport2"); ?>>Twee keer per week sporten</option>
                    </select>
                </td>
                <td class="verplicht"><?php ingevuld("abonnement", TRUE); ?></td>
            </tr>

            <tr>
                <td></td>
                <td><input type="submit" name="form1" value="Ga verder"></td>
            </tr>
        </table>
	
    </form>
    <?php
	
}
?>
