<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Contact</title>

        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="contact.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php include "../includes/header/header.php"; ?>

        <div id="inhoud_container">
            <div class="inhoud" id="contact">

                <!-- Inhoud 1 begin -->
                <table class="gesplitst">
                    <tr>
                        <!-- Google map weergeven -->
                        <td id="contact_map">
                            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                            <div id="gmap_groot">
                                <div id="gmap_canvas_groot"></div>
                            </div>

                            <script type="text/javascript">
                                function init_map() {
                                    var myOptions = {zoom: 16, center: new google.maps.LatLng(52.5911345, 6.280223699999965), mapTypeId: google.maps.MapTypeId.HYBRID};
                                    map = new google.maps.Map(document.getElementById("gmap_canvas_groot"), myOptions);
                                    marker = new google.maps.Marker({map: map, position: new google.maps.LatLng(52.5911345, 6.280223699999965)});
                                    infowindow = new google.maps.InfoWindow({content: "<b>T.H. Sport</b><br/>Burg. Baron van Dedemstraat 12<br/>7711HV Nieuwleusen"});
                                    google.maps.event.addListener(marker, "click", function () {
                                        infowindow.open(map, marker);
                                    });
                                    infowindow.open(map, marker);
                                }
                                google.maps.event.addDomListener(window, 'load', init_map);
                            </script>
                        </td>

                        <td id="contact_td">
                            <h1>Contactformulier</h1>
                            <p>Heeft u een vraag, klacht of opmerking? Vul dit formulier in en u krijgt zo snel mogelijk een bericht terug.</p>

                            <?php include "contactformulier.php"; ?>
                        </td>
                    <tr>
                </table>
                <!-- Inhoud 1 eind -->

            </div>
        </div>

        <?php include "../includes/footer/footer.php"; ?>
    </body>
</html>