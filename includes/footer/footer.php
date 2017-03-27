<!--Deze pagina toont de openingstijden, contactgegevens en een google maps plugin en wordt opgenomen in de homepage, waar de opmaak word benaderd. -->
<footer>
    <table class="tabel">
        <tr>
            <td>
                <h2>OPENINGSTIJDEN</h2>
                <div class="footertextlinks">
                    <br>
                    Maandag:<br>
                    Dinsdag:<br>
                    Woensdag:<br>
                    Donderdag:<br>
                    Vrijdag:<br>
                    Zaterdag:<br>
                    Zondag:
                </div>
                <div class="footertextrechts">
                    <br>
                    <?php
                    // Laat de juiste openingstijden per week zien.
                    $link = databaseConnect();

                    $stmt = mysqli_prepare($link, "SELECT openingstijd, sluitingstijd FROM openingstijden ORDER BY week_dag");
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $openingstijd, $sluitingstijd);

                    while (mysqli_stmt_fetch($stmt)) {
                        $openingstijd = substr($openingstijd, 0, 5);
                        $sluitingstijd = substr($sluitingstijd, 0, 5);

                        if (!empty($openingstijd)) {
                            print ("$openingstijd - $sluitingstijd");
                        } else {
                            print ("Gesloten");
                        }
                        print ("<br>");
                    }

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);

                    mysqli_close($link);
                    ?>
                </div>
            </td>
            <td><h2>CONTACT</h2>
                <br>
                Burg. Baron van Dedemstraat 12<br />
                7711HV Nieuwleusen<br />
                <br />
                <div class="footertextlinks">
                    Telefoon:<br>
                    E-mail:
                </div>
                <div class="footertextrechts">
                    <a href="tel:(0529)482385">(0529)-482385</a><br />
                    <a href="mailto:contact@th-sport.nl">contact@th-sport.nl</a>
                </div>
            </td>
            <td class="rechts"><h2>VIND ONS</h2>

                <!-- Google map (klein) -->
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                <div style="overflow:hidden;height:175px;width:100%;">
                    <div id="gmap_canvas" style="height:360px;width:100%;"></div>
                    <style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
                </div>

                <script type="text/javascript">
                    function init_map() {
                        var myOptions = {zoom: 13, center: new google.maps.LatLng(52.5808217, 6.279703299999937), mapTypeId: google.maps.MapTypeId.ROADMAP};
                        map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
                        marker = new google.maps.Marker({map: map, position: new google.maps.LatLng(52.5908217, 6.279703299999937)});
                        infowindow = new google.maps.InfoWindow({content: "<b>T.H. Sport</b><br/>Burg. Baron van Dedemstraat 21<br/>7711HV Nieuwleusen"});
                        google.maps.event.addListener(marker, "click", function () {
                            infowindow.open(map, marker);
                        });
                    }
                    google.maps.event.addDomListener(window, 'load', init_map);
                </script>

            </td>
        </tr>
    </table>
    Copyright Windesheim ICT 2014-2015  <img src="<?php print ($punt); ?>./includes/footer/afb/info.png" alt="info"
                                             title="Duncan Lukkenaer, Idris Oncul, Leroy Helledoorn, Shekib Hamidi"
                                             id="footer_info">
</footer>