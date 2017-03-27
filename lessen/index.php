<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Lessen</title>

        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="lessen.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>

    <body>
        <?php include "../includes/header/header.php"; ?>

        <div id="inhoud_container">
            <div class="inhoud">

                <!-- Inhoud 1 begin -->
                <table>
                    <?php
                    // Groepslessen ophalen
                    $link = databaseConnect();

                    $stmt = mysqli_prepare($link, "SELECT groepsles, omschrijving FROM groepsles ORDER BY groepsles");
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $groepsles, $beschrijving);

                    $teller = 0;
                    while (mysqli_stmt_fetch($stmt)) {
                        // Groepsles printen
                        $teller++;
                        if ($teller % 2 != 0) {
                            $tr_open = TRUE;
                            ?>
                            <tr>
                            <?php } ?>
                            <td class='groepsles'>
                                <h2><?php print ($groepsles); ?></h2>
                                <p><?php print ($beschrijving); ?></p>
                            </td>

                            <?php
                            if ($teller % 2 == 0) {
                                $tr_open = FALSE;
                                ?>
                            </tr>
                            <?php
                        }
                    }

                    if ($tr_open) {
                        // Als er nog een <tr> open stond, wordt deze nu gesloten
                        ?>
                        </tr>
                        <?php
                    }

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                    mysqli_close($link);
                    ?>
                </table>
                <!-- Inhoud 1 eind -->

            </div>
        </div>

        <?php include "../includes/footer/footer.php"; ?>
    </body>
</html>