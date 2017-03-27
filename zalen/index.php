<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Zalen</title>

        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="zalen.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="zerobox.js"></script> <!-- Voor het vergroten van een foto -->
    </head>

    <body>
        <?php include "../includes/header/header.php"; ?>

        <div id="inhoud_container">
            <div class="inhoud">

                <!-- Inhoud begin -->
                <table class="gesplitst">
                    <tr>
                        <td>
                            <h1>Onze zalen</h1>
                            <p>Bij Total Health Sport hebben wij verschillende faciliteiten. Hieronder vindt u een overzicht.</p>

                            <h2>Balie/Koffiecorner</h2>
                            <p>Bij de balie kunt u uiteraard terecht voor informatie, maar ook voor een kopje koffie of thee. Ook bieden wij hier verscheidene sport shakes.</p>

                            <h2>Fitnessruimte</h2>
                            <p>Een ruimte van 700m<sup>2</sup> met o.a. de basislijn en de free weight lijn.</p>

                            <h2>Zaal 1</h2>
                            <p>Een ruimte van 100m<sup>2</sup> waarin de meeste groepslessen worden gegeven, van B.B.B. tot zelfverdediging. Kijk voor een volledig overzicht van de groepslessen op de lessen pagina.</p>

                            <h2>Zaal 2</h2>
                            <p>Een ruimte van 50m<sup>2</sup> waarin voornamelijk de spinning lessen worden gegeven.</p>

                            <h2>Fysioruimte</h2>
                            <p>Op verschillende momenten hebben wij bij T.H. Sport twee fysio-, manueel-, sport- en revalidatietherapeuten. Ook is er een Mensendieck- en kinderoefentherapeute van FysioHibma aanwezig. Dit gaat geheel onafhankelijk en conform de polisvoorwaarden van uw zorgverzekering.</p>

                            <h2>Massagesalon</h2>
                            <p>Hier kunt u terecht voor o.a. een sport-, baby-, zwangerschaps-, ontspannings- en wellnessmassage. Daarnaast kunnen wij u hier cure tapen tegen een gereduceerd tarief.</p>

                            <h2>Zonnebank</h2>
                            <p>Professionele snelbruiner tegen betaling. <i>(Niet bij abonnement inbegrepen.)</i></p>

                            <h2>Overige faciliteiten</h2>
                            <p>Verder zijn er ruime kleedkamers met douches, toiletten inclusief een invalide toilet en is het hele pand voorzien van airconditioning. <i>Bovendien is onze hele sportschool toegankelijk voor rolstoellen!</i></p>
                        </td>

                        <td>
                            <script>
                                $(function () {
                                    $('.zerobox').zerobox();
                                });
                            </script>

                            <table id="zalen_fotos">
                                <?php
                                for ($foto = 1; $foto <= 12; $foto++) {
                                    if (($foto + 1) % 2 == 0) {
                                        print ("<tr>");
                                        $tr_open = TRUE;
                                    }
                                    ?>
                                    <td>
                                        <div>
                                            <a class="zerobox" href="./afb/zaal<?php print ($foto); ?>.png">
                                                <div>
                                                    <img src="./afb/zaal<?php print ($foto); ?>.png" alt=""/>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <?php
                                    if ($foto % 2 == 0) {
                                        print ("</tr>");
                                        $tr_open = FALSE;
                                    }
                                }
                                if ($tr_open) {
                                    print ("</tr>");
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
                <!-- Inhoud eind -->

            </div>
        </div>

        <?php include "../includes/footer/footer.php"; ?>
    </body>
</html>