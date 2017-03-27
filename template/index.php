<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Template</title> <!-- Aanpassen -->

        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="template.css"> <!-- Aanpassen -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php include "../includes/header/header.php"; ?>

        <div id="inhoud_container">
            <div class="inhoud">

                <!-- Inhoud 1 begin -->
                <h1>Lorem ipsum</h1>
                <h2>Sapien sit amet</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin ligula sit amet erat pretium fermentum. Suspendisse tellus mi, porta in massa nec, imperdiet vehicula ipsum. Donec ac turpis facilisis, efficitur eros sed, vehicula urna. Maecenas dolor nisl, consectetur at finibus at, imperdiet id nunc. Phasellus mattis pellentesque nisi, nec ultrices odio euismod eu. Nam massa turpis, ornare ac lacus at, volutpat porta sem. Integer tincidunt risus quis maximus convallis.</p>

                <h2>Facilisis sed</h2>
                <p>Donec vel nulla fringilla, rhoncus magna sit amet, egestas sem. Proin sit amet massa placerat, varius libero eu, accumsan libero. Morbi ex nisl, vehicula et mauris in, iaculis suscipit mi. Proin rhoncus sapien hendrerit dolor interdum, sed aliquet libero interdum. Fusce porttitor, sapien quis tempus tincidunt, sapien erat semper sem, at volutpat magna orci in diam. Curabitur vitae nulla lacinia, consequat mi sit amet, luctus metus. Suspendisse potenti. Quisque quis posuere massa. Donec justo nisi, imperdiet non finibus a, tempus eget libero. Morbi sagittis non tellus at mollis. Fusce placerat odio vel justo varius, eu fermentum turpis varius.</p>
                <p>Quisque turpis est, volutpat et consectetur ut, tincidunt et erat. Cras fermentum ac lectus at malesuada. Proin at tellus a odio venenatis consequat in eu sem. Praesent felis ligula, egestas vitae gravida vel, tempus ac dolor. Nam a interdum purus. Vivamus luctus turpis est, a bibendum magna facilisis sed. Etiam vitae velit luctus, dignissim ex eu, rhoncus arcu.</p>
                <!-- Inhoud 1 eind -->

            </div>
            <div class="inhoud2">

                <!-- Inhoud 2 begin -->
                <table class="gesplitst">
                    <tr>
                        <td>
                            <h1>Lorem ipsum</h1>
                            <h2>Sapien sit amet</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin ligula sit amet erat pretium fermentum. Suspendisse tellus mi, porta in massa nec, imperdiet vehicula ipsum. Donec ac turpis facilisis, efficitur eros sed, vehicula urna. Maecenas dolor nisl, consectetur at finibus at, imperdiet id nunc. Phasellus mattis pellentesque nisi, nec ultrices odio euismod eu. Nam massa turpis, ornare ac lacus at, volutpat porta sem. Integer tincidunt risus quis maximus convallis.</p>
                        </td>
                        <td>
                            <h2>Facilisis sed</h2>
                            <p>Donec vel nulla fringilla, rhoncus magna sit amet, egestas sem. Proin sit amet massa placerat, varius libero eu, accumsan libero. Morbi ex nisl, vehicula et mauris in, iaculis suscipit mi. Proin rhoncus sapien hendrerit dolor interdum, sed aliquet libero interdum. Fusce porttitor, sapien quis tempus tincidunt, sapien erat semper sem, at volutpat magna orci in diam. Curabitur vitae nulla lacinia, consequat mi sit amet, luctus metus. Suspendisse potenti. Quisque quis posuere massa. Donec justo nisi, imperdiet non finibus a, tempus eget libero. Morbi sagittis non tellus at mollis. Fusce placerat odio vel justo varius, eu fermentum turpis varius.</p>
                            <p>Quisque turpis est, volutpat et consectetur ut, tincidunt et erat. Cras fermentum ac lectus at malesuada. Proin at tellus a odio venenatis consequat in eu sem. Praesent felis ligula, egestas vitae gravida vel, tempus ac dolor. Nam a interdum purus. Vivamus luctus turpis est, a bibendum magna facilisis sed. Etiam vitae velit luctus, dignissim ex eu, rhoncus arcu.</p>
                        </td>
                    <tr>
                </table>
                <!-- Inhoud 2 eind -->

            </div>
        </div>

        <?php include "../includes/footer/footer.php"; ?>
    </body>
</html>
