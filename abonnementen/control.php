<table>
    <?php
    $form = TRUE;
    foreach ($_SESSION as $vraag => $antwoord) {
        $nietWeergeven = array("stap", "form1", "form2"); // Alle indexen van $_SESSION die niet moeten worden geprint
        if (!in_array($vraag, $nietWeergeven)) {
            //lengte van de woord uitrekenen om te kijken of het leeg is of niet.
            $aantal = strlen($antwoord);

            // controle om naar formulier 1 of 2 te gaan bij het wijzigen. 3de tabel
            if ($vraag == "vraag1") {
                $form = FALSE;
            }
            //controleren of het formulier 1 is door de true false waarde
            if ($form) {

                // is het woord langer als 1 dan pas mag het laten zien worden.
                if ($aantal > 1) {
                    ?>
                    <tr>
					
                        <td><?php print ucfirst(($vraag)); ?></td>
                        <td><?php 
						if ($antwoord == "onb_jaar"){
						$antwoord = "Onbeperkt jaarcontract";}
						elseif($antwoord == "onb_kwart"){
						$antwoord = "Onbeperkt kwartaalcontract";}
						elseif($antwoord == "dag_jaar"){
						$antwoord = "Dagtraining jaarcontract";}
						elseif($antwoord == "dag_kwart"){
						$antwoord = "Dagtraining kwartaalcontract";}
						elseif($antwoord == "sport1"){
						$antwoord = ">Een keer per week sporten";}
						elseif($antwoord == "sport2"){
						$antwoord = "Twee keer per week sporten";}
						
						print ucfirst(($antwoord)); ?></td>
                        <td>
                            <form method="get">
                                <input type="hidden" name="stap" value="1">
                                <input type='submit' value='Wijzigen'>
                            </form>
                        </td>


                    </tr>
                    <?php
                }
            } else { // controleren of het formulier 2 is door de true false waarde
                if ($aantal > 1) {
                    ?>
                    <tr>
                        <td>
                            <?php
							if ($vraag == "vraag1"){
							print ("Sport u momenteel?");}
							if ($vraag == "vraag1_1"){
							print ("Welke sport:");}
							if ($vraag == "vraag1_2"){
							print ("Hoe lang:");}
							if ($vraag == "vraag2"){
							print ("Hebt u al eens eerder gefitnesst?");}
							if ($vraag == "vraag2_1"){
							print ("Hoelang geleden:");}
							if ($vraag == "vraag3"){
							print ("Hebt u last van blessures?");}
							if ($vraag == "vraag3_1"){
							print ("Ja, Welke:");}
							if ($vraag == "vraag4"){
							print ("Hebt u last van gewrichtsklachten?");}
							if ($vraag == "vraag4_1"){
							print ("Welke gewrichtsklachten?");} 
							if ($vraag == "vraag5"){
							print ("Hebt u last van rugklachten?");}
							if ($vraag == "vraag5_1"){
							print ("Rugklachten:");}
							if ($vraag == "vraag6"){
							print ("Hebt u last van hartklachten?");}
							if ($vraag == "vraag6_1"){
							print ("Hartklachten:");}
							if ($vraag == "vraag7"){
							print ("Heeft u diabetes?");}
							if ($vraag == "vraag8"){
							print ("Bent u onder behandeling bij een arts of therapeut?");}
							if ($vraag == "vraag8_1"){
							print ("Waarvoor:");}
							if ($vraag == "vraag9"){
							print ("Gebruikt u medicatie?");}
							if ($vraag == "vraag9_1"){
							print ("Welke medicatie:");}
							if ($vraag == "vraag10"){
							print ("Bent u langdurig ziek geweest?");}
							if ($vraag == "vraag10_1"){
							print ("Voor welke ziekte:");}
							if ($vraag == "vraag11"){
							print ("Met welke doelstellingen komt u trainen?");}
							if ($vraag == "vraag11_1"){
							print ("Doelstellingen:");}							
							if ($vraag == "vraag12"){
							print ("Wens u een uitgebruide intake gesprek");}
							if ($vraag == "vraag13"){
							print ("Heeft u kennis genomen van de huisregels?");}
						
							
?>
                        </td>
                        <td>
                            <?php 
							$isarray = is_array($antwoord);
							if ($antwoord == $isarray ){
							foreach ($antwoord as $input => $output){
							print ucfirst (substr($output, 5));  
							print("<br>");
							}} else {
							print ucfirst(($antwoord)); 
							
							}
							
							?>
							
                        </td>
                        <td>
                            <form method="get">
                                <input type="hidden" name="stap" value="2">
                                <input type='submit' value='Wijzigen'>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
    }
    ?>
	<tr><td> <form method="get">
                                <input type="hidden" name="stap" value="3">
                                <input type='submit' value='Accepteren'></td></tr>
</table>

