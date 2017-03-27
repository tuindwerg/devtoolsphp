<?php
session_start();

//https://www.youtube.com/watch?v=HLxnw4Jt_AM link met video


// pagina 1
$vnaam = $_SESSION["voornaam"];
$anaam = $_SESSION["achternaam"];
$adres = $_SESSION["adres"];
$postcode = $_SESSION["postcode"];
$woonplaats = $_SESSION["woonplaats"];
$email = $_SESSION["email"];
$tnummer = $_SESSION["telefoonnummer"];
$gdatum = $_SESSION["geboortedatum"];
$contract = $_SESSION["abonnement"];

//Naam verandering voor de Abonomemt
	if ($contract == "onb_jaar"){
	$contract = "onbeperkt jaarcontract ";}
	elseif($contract == "onb_kwart"){
	$contract = "onbeperkt kwartaalcontract ";}
	elseif($contract == "dag_jaar"){
	$contract = "dagtraining jaarcontract ";}
	elseif($contract == "dag_kwart"){
	$contract = "dagtraining kwartaalcontract ";}
	elseif($contract == "sport1"){
	$contract = ">een keer per week sporten ";}
	elseif($contract == "sport2"){
	$contract = "twee keer per week sporten ";}

$keuze = "Ik kies voor contract nummer " . $contract . " " . "betaling eenmalig / maand*";
//pagina 2
$antwoord = "Ja";
$vraag1 = $_SESSION["vraag1"];
$vraag1_1 = $_SESSION["vraag1_1"];
$vraag1_2 = $_SESSION["vraag1_2"];
$vraag2 = $_SESSION["vraag2"];
$vraag2_1 = $_SESSION["vraag2_1"];
$vraag3 = $_SESSION["vraag3"];
$vraag3_1 = $_SESSION["vraag3_1"];
$vraag4 = $_SESSION["vraag4"];
$vraag4_1 = $_SESSION["vraag4_1"];
$vraag5 = $_SESSION["vraag5"];
$vraag5_1 = $_SESSION["vraag5_1"];
$vraag6 = $_SESSION["vraag6"];
$vraag6_1 = $_SESSION["vraag6_1"];
$vraag7 = $_SESSION["vraag7"];
$vraag7_1 = $_SESSION["vraag7_1"];
$vraag8 = $_SESSION["vraag8"];
$vraag8_1 = $_SESSION["vraag8_1"];
$vraag9 = $_SESSION["vraag9"];
$vraag9_1 = $_SESSION["vraag9_1"];
$vraag10 = $_SESSION["vraag10"];
$vraag10_1 = $_SESSION["vraag10_1"];
$vraag11 = $_SESSION["vraag11"];
$vraag11_1 = $_SESSION["vraag11_1"];
$vraag12 = $_SESSION["vraag12"];
$vraag13 = $_SESSION["vraag13"];


// fpdf.php word erbij gehaald.
require ("pdf/fpdf.php");
// Er word een nieuwe pdf aangemaakt
$pdf = new FPDF();
// pagina 1 begin
$pdf->AddPage();

$pdf->SetFont("Arial", "B", "20"); //lettertype,style ,lettergroote
$pdf->Cell(0, 15, "Inschijfformulier", 1, 1, "C"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie

$pdf->SetFont("Arial", "B", "12"); //lettertype,style ,lettergroote
//naam
$pdf->Cell(60, 10, "Naam: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, ucfirst($vnaam) . " " . ucfirst($anaam), 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
//adres
$pdf->Cell(60, 10, "Adres: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, ucfirst($adres), 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
// postcode
$pdf->Cell(60, 10, "Postcode: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, $postcode, 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
//woonplaats
$pdf->Cell(60, 10, "Woonplaats: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, ucfirst($woonplaats), 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
//email
$pdf->Cell(60, 10, "E-mail adres: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, $email, 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
//telefoonnummer
$pdf->Cell(60, 10, "Telefoonnummer: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, $tnummer, 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
//geboorte
$pdf->Cell(60, 10, "Geboorte datum: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, $gdatum, 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
//bankrekeningnummer
$pdf->Cell(60, 10, "Bankrekeningnummer: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, " ", 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
//bankrekeninghouder
$pdf->Cell(60, 10, "Bankrekening t.n.v: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 10, " ", 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
// lege vak
$pdf->Cell(0, 5, "", 1, 1, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
// voorwaarden
$pdf->SetFont("Arial", "B", "10"); //lettertype,style ,lettergroote
$pdf->Multicell(0, 7, "Ik kies voor contract nummer " . $contract . "betaling eenmalig / maand*\n" .
        "Hiervoor verklaar ik akkoord te gaan met automatische incasso** van de contributie van bovenstaande bankrekeningnummer, zoals omschreven in het contract en dat ik mij aan de algemene voorwaarden zal houden. Het is mij bekend dat ik 1 maand voor het einde van het contract, schriftelijk moet opzeggen. Bij niet tijdig opzeggen wordt het contract automatisch voor dezelfde periode verlengt.", 1, 1, "");
$pdf->Cell(0, 5, "", 1, 1, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.

$pdf->Multicell(0, 7, "*Doorhalen wat niet van toepassing is.\n" .
        "** Indien u het niet eens bent met de afschijving heeft u 30 kalender dagen de tijd om uw(post)bank opdracht te geven het bedrag terug te boeken.", 1, 1, "");
$pdf->Cell(0, 5, "", 1, 1, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
//datum inschijving
$pdf->Cell(60, 7, "Datum inschijving: ", 1, 0, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, " ", 1, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
// witregel
$pdf->Cell(70, 5, " ", "LT", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(20, 5, " ", "T", 0, "C"); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(40, 5, "", "T", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(60, 5, "", "RT", 1, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
// ondervak adres gegevens en handtekening  Left Right Top Bottom
// eerste regel
$pdf->Cell(70, 5, "T.H. Sport", "TLR", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(20, 5, " ", 0, 0, "C"); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(40, 5, "Handtekening", "TLR", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(60, 5, "", "R", 1, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
// 2de regel
$pdf->Cell(70, 5, "Burg. Baron van Dedemsstraat 12A", "LR", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(20, 5, " ", 0, 0, "C"); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(40, 5, " ", "L", 0, "C"); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(20, 5, " ", "RT", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(40, 5, " ", "R", 1, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
//3de regel
$pdf->Cell(70, 5, "7711 HV Nieuwleusen", "LR", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(20, 5, " ", 0, 0, "C"); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(60, 5, " ", "LR", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(40, 5, " ", "R", 1, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
//4de regel
$pdf->Cell(70, 5, "", "LRB", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(20, 5, " ", 0, 0, "C"); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(60, 5, " ", "LRB", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
$pdf->Cell(40, 5, " ", "R", 1, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
// onderregel

$pdf->Cell(0, 5, "", "LRB", 0, ""); // Dit moet een lege cel zijn zoals te zien is bij de documentatie van opdrachtgever.
// afbeelding footer
$pdf->Image('logo.png', 140, 250, -200);
// dit is pagina 2 hier komt de intake formulier
$pdf->AddPage();

$pdf->SetFont("Arial", "B", 20); //lettertype,style ,lettergroote
$pdf->Cell(0, 15, "Intake Formulier TH-Sport", 0, 1, "C"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie
// vraag 1
$pdf->SetFont("Arial", "B", 12);
$pdf->cell(0, 10, "1. Sport u momenteel?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag1, 0, 1, "");
if ($vraag1 == $antwoord) {
    $pdf->cell(0, 5, "Welke sport: " . $vraag1_1 . " Hoe lang " . $vraag1_2, 0, 1, "");
}
//vraag 2
$pdf->SetFont("Arial", "B", 12);
$pdf->cell(0, 10, "2. Hebt u al eens eerder gefitnesst?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag2, 0, 1, "");
if ($vraag2 == $antwoord) {
    $pdf->cell(60, 5, "Hoe lang geleden: " . $vraag2_1, 0, 1, "");
}
// vraag 3
$pdf->SetFont("Arial", "B", 12);
$pdf->cell(0, 10, "3. Hebt u last van blessures?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag3, 0, 1, "");
if ($vraag3 == $antwoord) {
        $pdf->cell(60, 5, "Zoja Welke: " . $vraag3_1, 0, 1, "");

}
// vraag 4
//$pdf->SetFont("Arial", "B", 12);
//$pdf->cell(0, 10, "1. Heeft U last van gewrichtsklachten?", 0, 1, "");
//vraag 4.1
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "4.1. Heeft U last van gewrichtsklachten?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag4, 0, 1, "");
if ($vraag4 == $antwoord) {
    $pdf->cell(0, 5, "Zo ja, welke: " . $vraag4_1, 0, 1, "");
}
//vraag 4.2
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "4.2. Heeft U last van rugklachten", 0, 1, ""); // bewerken
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag5, 0, 1, "");
if ($vraag5 == $antwoord) {
    $pdf->cell(0, 5, "Zo ja, welke: " . $vraag5_1, 0, 1, "");
}
//vraag 4.3
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "4.3. Heeft U last van gewrichtsklachten?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag6, 0, 1, "");
if ($vraag6 == $antwoord) {
    $pdf->cell(0, 5, "Zo ja, Welke: " . $vraag6_1, 0, 1, "");
}
//vraag 4.4
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "4.4. Heeft U last van diabetes?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag7, 0, 1, "");
if ($vraag7 == $antwoord) {
    $pdf->cell(0, 5, "Zo ja, welke: " . $vraag7_1, 0, 1, "");
}
//vraag 5
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "5. Bent u onder behandeling bij een arts of therapeut?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag8, 0, 1, "");
if ($vraag8 == $antwoord) {
    $pdf->cell(0, 5, "Zo ja, waarvoor: " . $vraag8_1, 0, 1, "");
}
//vraag 6
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "6. Gebruikt u medicatie?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag9, 0, 1, "");
if ($vraag9 == $antwoord) {
    $pdf->cell(0, 5, "Zo ja, medicatie: " . $vraag9_1, 0, 1, "");
}
//vraag 7
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "7. Bent u langdurig ziek geweest?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag10, 0, 1, "");
if ($vraag10 == $antwoord) {
    $pdf->cell(0, 5, "Zo ja, waarvoor: " . $vraag10_1, 0, 1, "");
}
//vraag 8
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "8. Welke doel komt u trainen? ", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
foreach ($vraag11 as $key => $input) {
    $pdf->cell(0, 5, $input, 0, 1, "");
}
//vraag 9
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "9. Wens je een uitgebreid intake gesprek en dat er een persoonlijk traingsschema voor u gemaakt word", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag12, 0, 1, "");

//vraag 10
$pdf->SetFont("Arial", "B", 10);
$pdf->cell(0, 10, "10. Heeft u kennis genomen van de huisregels en de algemene voorwaarden?", 0, 1, "");
$pdf->SetFont("Arial", "", 8);
$pdf->cell(0, 5, $vraag13, 0, 1, "");



$pdf->AddPage();
// nieuwe pagina machtiginsformulier


$pdf->SetFont("Arial", "B", "15"); //lettertype,style ,lettergroote
$pdf->Cell(0, 7, "T.h. Sport", 0, 1, "C"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie

$pdf->SetFont("Arial", "B", "7"); //lettertype,style ,
$pdf->Cell(0, 7, "machtingsformulier", 0, 1, "L"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 2, " ", 0, 1, "C"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, "Hierbij machtig ik,", 0, 1, "L"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, ucfirst($vnaam) . " " . ucfirst($anaam), 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, ucfirst($adres) . " " . $postcode, 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, ucfirst($woonplaats), 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, $tnummer, 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, "Om de maandelijkse contributie van de sportschool door T.H. Sport af te laten schijven van", 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, "Mijn IBAN rekeningnummer ...................................", 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, " ", 0, 1, "C"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, "Handtekening rekeninghouder", 0, 1, "C"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, "...........................", 0, 1, "C"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, " ", 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7,"inschijfnr k.v.k. 59428732 Rabobank vaart en vechtstreek NL71RABO01595.57.569 btwnr. NL.156136223B01", 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7,"..................................................................................................................................", 0, 1, "C"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie

$pdf->Cell(0, 7,"Graag dit document uitprinten en meenemen naar de sportschool, Dit document moet voorzien worden van de juiste rekeningnummer en handtekeningen,", 0, 1, "L"); // cell indeling breedte, hoogte, tekst,border, 1regel toekennen , tekst positie
$pdf->Cell(0, 7, "Vriendelijk bedankt, T.H. Sport", 0, 1, "C"); // cell indeling hoogte, breedte, tekst,border, 1regel toekennen , tekst positie

ob_end_clean();
//einde pdf en een uitvoering en welke bestandsnaam de document krijgt samen met de uitvoersoort.

$pdf->Output("Inschrijving.pdf","D");
?>
