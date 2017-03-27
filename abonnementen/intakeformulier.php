 <!-- Dit is de intake formulier. Hier in word alle gecontroles uitgevoerd via functions. functions worden bescheven in de functie.php -->
<form  method="post">

    <table>
        <tr>
            <th>
                1. Sport u momenteel?
            </th>
            <td>
                <input type="radio" name="vraag1"  id="vraag1show" value="Ja" <?php form_value_stap2("vraag1", "Ja") ?> > Ja
                <input type="radio" name="vraag1"  id="vraag1hide" value="Nee" <?php form_value_stap2("vraag1", "Nee") ?> > Nee
                <?php ingevuld2("vraag1", TRUE); ?>
            </td>
        </tr>

        <tr class="vraag1 <?php verbergen('vraag1') ?>">
            <td class="links" >
                Welke sport:
            </td>
            <td colspan="2">
                <input type="text" name="vraag1_1" value="<?php form_value("vraag1_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag1", TRUE); ?>
            </td>
        </tr>

        <tr  class="vraag1 <?php verbergen('vraag1') ?>" >
            <td class="links" >
                En hoe lang:
            </td>
            <td colspan="2">
                <input type="text" name="vraag1_2" value="<?php form_value("vraag1_2"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag1", TRUE); ?>
            </td>
        </tr>

        <tr>
            <th>
                2. Hebt u al eens eerder gefitnesst?
            </th>
            <td>
                <input type="radio" name="vraag2" id="vraag2show" value="Ja" <?php form_value_stap2("vraag2", "Ja") ?>> Ja
                <input type="radio" name="vraag2" id="vraag2hide" value="Nee" <?php form_value_stap2("vraag2", "Nee") ?>> Nee
                <?php ingevuld2("vraag2", TRUE); ?>
            </td>
        </tr>
        <tr class="vraag2  <?php verbergen('vraag2') ?>">
            <td class="links" >
                Welke sportschool:
            </td>
            <td colspan="2">
                <input type="text" name="vraag2_1" value="<?php form_value("vraag2_1"); ?>" >
            </td>
            <td> <?php ingevuld3("vraag2", TRUE); ?>
            </td>


        <tr>
            <th>
                3. Hebt u last van blessures?
            </th>
            <td>
                <input type="radio" name="vraag3" id="vraag3show" value="Ja" <?php form_value_stap2("vraag3", "Ja") ?>> Ja

                <input type="radio" name="vraag3" id="vraag3hide" value="Nee" <?php form_value_stap2("vraag3", "Nee") ?>> Nee
                <?php ingevuld2("vraag3", TRUE); ?>
            </td>
        </tr>
        <tr class="vraag3 <?php verbergen("vraag3") ?>">
            <td class="links" >
                Welke blessures:
            </td>
            <td colspan="2">
                <input type="text" name="vraag3_1" value="<?php form_value("vraag3_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag3", TRUE); ?>
            </td>
        </tr>
        <tr>
            <th>
                4. Hebt u klachten?
            </th>
        </tr>
        <tr>
            <td class="links">
                Hebt u last van gewrichtsklachten.
            </td>
            <td>
                <input type="radio" name="vraag4" id="vraag4-1show" value="Ja" <?php form_value_stap2("vraag4", "Ja") ?>> Ja
                <input type="radio" name="vraag4" id="vraag4-1hide" value="Nee" <?php form_value_stap2("vraag4", "Nee") ?>>  Nee
                <?php ingevuld2("vraag4", TRUE); ?>
            </td>
        </tr>
        <tr class="vraag4-1 <?php verbergen('vraag4') ?>">
            <td class="links"  >
                Welke gewrichtsklachten:
            </td>
            <td colspan="2">
                <input type="text" name="vraag4_1"  value="<?php form_value("vraag4_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag4", TRUE); ?>
            </td>
        </tr>

        <tr>
            <td class="links">
                Hebt u last van rugklachten.
            </td>
            <td>
                <input type="radio" name="vraag5" id="vraag4-2show" value="Ja" <?php form_value_stap2("vraag5", "Ja") ?>> Ja
                <input type="radio" name="vraag5" id="vraag4-2hide" value="Nee"<?php form_value_stap2("vraag5", "Nee") ?>>  Nee
                <?php ingevuld2("vraag5", TRUE); ?>
            </td>
        </tr>
        <tr class="vraag4-2  <?php verbergen('vraag5') ?>">
            <td class="links">
                Welke rugklachten:
            </td>
            <td colspan="2">
                <input type="text"  name="vraag5_1"  value="<?php form_value("vraag5_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag5", TRUE); ?>
            </td>
        </tr>
        <tr>
            <td class="links">
                Hebt u last van hartklachten.
            </td>
            <td>
                <input type="radio" name="vraag6" id="vraag4-3show" value="Ja" <?php form_value_stap2("vraag6", "Ja") ?>> Ja
                <input type="radio" name="vraag6" id="vraag4-3hide" value="Nee" <?php form_value_stap2("vraag6", "Nee") ?>>  Nee
                <?php ingevuld2("vraag6", TRUE); ?>
            </td>
        </tr>
        <tr class="vraag4-3 <?php verbergen('vraag6') ?>">
            <td class="links" >
                Welke hartklachten:
            </td>
            <td colspan="2">
                <input type="text" name="vraag6_1"  value="<?php form_value("vraag6_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag6", TRUE); ?>
            </td>
        </tr>
        <tr>
            <td class="links">
                Hebt u last van diabetes.
            </td>
            <td>
                <input type="radio" name="vraag7" id="vraag4-4show" value="Ja" <?php form_value_stap2("vraag7", "Ja") ?>> Ja
                <input type="radio" name="vraag7" id="vraag4-4hide" value="Nee" <?php form_value_stap2("vraag7", "Nee") ?>>  Nee
                <?php ingevuld2("vraag7", TRUE); ?>
            </td>
        </tr>
        <tr class="vraag4-4 <?php verbergen('vraag7') ?>">
            <td class="links" >
                Welke soort diabetes:
            </td>
            <td colspan="2">
                <input type="text"  name="vraag7_1"  value="<?php form_value("vraag7_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag7", TRUE); ?>
            </td>
        </tr>
        <tr>
            <th>
                5. Bent u onder behandeling bij een arts of therapeut?
            </th>

            <td>
                <input type="radio" name="vraag8" id="vraag5show" value="Ja" <?php form_value_stap2("vraag8", "Ja") ?>> Ja
                <input type="radio" name="vraag8" id="vraag5hide" value="Nee" <?php form_value_stap2("vraag8", "Nee") ?>> Nee
                <?php ingevuld2("vraag8", TRUE); ?>
            </td>
        </tr>
        <tr class="vraag5 <?php verbergen('vraag8') ?>">
            <td class="links" >
                Waarvoor:
            </td>
            <td colspan="2" >
                <input type="text" name="vraag8_1" value="<?php form_value("vraag8_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag8", TRUE); ?>
            </td>
        </tr>
        <tr>
            <th>
                6. Gebruikt u medicatie?
            </th>
            <td>
                <input type="radio" name="vraag9" id="vraag6show" value="Ja" <?php form_value_stap2("vraag9", "Ja") ?>> Ja
                <input type="radio" name="vraag9" id="vraag6hide" value="Nee" <?php form_value_stap2("vraag9", "Nee") ?>> Nee
                <?php ingevuld2("vraag9", TRUE); ?></p></td></tr>

        <tr class="vraag6 <?php verbergen('vraag9') ?>">
            <td class="links" >
                welke medicatie:
            </td>
            <td colspan="2">
                <input type="text" name="vraag9_1" value="<?php form_value("vraag9_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag9", TRUE); ?>
            </td>
        </tr>


        <tr>
            <th>
                7. Bent u langdurig ziek geweest?
            </th>
            <td>
                <input type="radio" name="vraag10" id="vraag7show" value="Ja" <?php form_value_stap2("vraag10", "Ja") ?>> Ja
                <input type="radio" name="vraag10" id="vraag7hide" value="Nee" <?php form_value_stap2("vraag10", "Nee") ?>> Nee
                <?php ingevuld2("vraag10", TRUE); ?>
            </td>
        </tr>

        <tr class="vraag7 <?php verbergen('vraag10') ?>">
            <td class="links" >
                Waarvoor:
            </td>
            <td colspan="2">
                <input type="text" name="vraag10_1" value="<?php form_value("vraag10_1"); ?>" >
            </td>
            <td>
                <?php ingevuld3("vraag10", TRUE); ?>
            </td>
        </tr>
        <tr>
            <th>
                8. Met welke Doelstelling(en) komt u trainen:?
            </th>
        </tr>
        <tr>
            <td class="links">
                <input type="checkbox" name="vraag11[]" value="doel afvallen" <?php form_value_stap3("vraag11", "doel afvallen") ?>>Afvallen<BR>
                <input type="checkbox" name="vraag11[]" value="doel aankomen"<?php form_value_stap3("vraag11", "doel aankomen") ?> >Aankomen<BR>
                <input type="checkbox" name="vraag11[]" value="doel sterker worden" <?php form_value_stap3("vraag11", "doel sterker worden") ?> >Sterker worden<BR>
                <input type="checkbox" name="vraag11[]" value="doel meer spier" <?php form_value_stap3("vraag11", "doel meer spier") ?>>Meer spiermassa<BR>
                <input type="checkbox" name="vraag11[]" value="doel conditie" <?php form_value_stap3("vraag11", "doel conditie") ?>>Meer uithoudingsvermogen(conditie)<BR>
                <input type="checkbox" name="vraag11[]" value="doel anders" <?php form_value_stap3("vraag11", "doel anders") ?>> Anders, namelijk<input type="text" name="vraag11_1" >
                <?php ingevuld2("vraag11", TRUE);
                ?>
            </td>
        </tr>
        <tr>
            <th>
                9. Wenst u een uitgebreid intake gesprek en dat er een persoonlijk trainingschema voor u gemaakt word?
            </th>
            <td>
                <input type="radio" name="vraag12" value="Ja" <?php form_value_stap2("vraag12", "Ja") ?> > Ja
                <input type="radio" name="vraag12" value="Nee" <?php form_value_stap2("vraag12", "Nee") ?>> Nee
                <?php ingevuld2("vraag12", TRUE); ?>
            </td>
        </tr>
        <tr>
            <th>
                10. heeft u kennisgenomen van de huisregels en de algemene voorwaarden?
            </th>
            <td>
                <input type="radio" name="vraag13" value="Ja" <?php form_value_stap2("vraag13", "Ja") ?>> Ja
                <input type="radio" name="vraag13" value="Nee" <?php form_value_stap2("vraag13", "Nee") ?>> Nee
                <?php ingevuld2("vraag13", TRUE); ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <input type="submit" name="form2" value="Ga verder">
            </td>
        </tr>
    </table>
