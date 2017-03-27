<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>T.H. Sport - Admin - Lessen</title>
        <link rel="stylesheet" type="text/css" href="../../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/admin.css">
        <link rel="stylesheet" type="text/css" href="lessen.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
        // Word doorverwezen naar inlog-pagina
        if (!isset($_SESSION["gebruiker"])) {
            print ("<script>window.open('/admin/', '_self')</script>");
        } else {
            include "../../includes/functies.php";
            ?>
            <div id="bodycontainer">
                <?php include "../includes/adminmenu.php"; ?>
                <div id="inhoud">
                    <h1>Administrator omgeving T.H. Sport</h1>
                    <h2>Groepslessen beheren</h2>
                    <?php
                    //Databaseconnectie word gestart
                    $link = databaseConnect();
                    //Als er op wijzigen is geklikt (naast elke les staat een wijzig knop) dan wordt de naam van de groeples uit de link gehaald en gekoppeld aan een variabel.
                    if (isset($_GET["wijzigen"])) {
                        $oud_groepsles = mysqli_real_escape_string($link, $_GET["wijzigen"]);
                        if (isset($_POST["wijzigen"])) {
                            //Als je het hebt gewijzigd en op wijzigen (wijzigen knop onder de invoervelden) klikt dan worden de ingevulde velden gekkopeld aan variabelen.
                            $groepsles = mysqli_real_escape_string($link, $_POST["groepsles"]);
                            $omschrijving = mysqli_real_escape_string($link, $_POST["omschrijving"]);
                            //Controle of de groepsles naam wel ingevuld is (omschrijving is optioneel).
                            $volledigIngevuld = TRUE;
                            if (isset($_POST["wijzigen"])) {
                                if (empty($_POST["groepsles"])) {
                                    $volledigIngevuld = FALSE;
                                }
                            } else {
                                $volledigIngevuld = FALSE;
                            }
                            //Als de wijziging correct is ingevuld dan wordt het in de database gewijzigd.
                            if ($volledigIngevuld) {
                                $stmt = mysqli_prepare($link, "UPDATE groepsles SET groepsles= ? , omschrijving = ? WHERE groepsles=?");
                                mysqli_stmt_bind_param($stmt, "sss", $groepsles, $omschrijving, $oud_groepsles);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_free_result($stmt);
                                mysqli_stmt_close($stmt);
                                header('Location: /admin/lessen');
                            }
                        }
                    }
                    //Als je op toevoegen klikt dan worden de ingevulde velden aan variabelen gekoppeld.
                    if (isset($_POST["versturen"])) {
                        $groepsles = mysqli_real_escape_string($link, $_POST["groepsles"]);
                        $omschrijving = mysqli_real_escape_string($link, $_POST["omschrijving"]);
                        //Controle of de groepsles naam wel ingevuld is (omschrijving is optioneel).
                        $volledigIngevuld = TRUE;
                        if (isset($_POST["versturen"])) {
                            if (empty($_POST["groepsles"])) {
                                $volledigIngevuld = FALSE;
                            }
                        } else {
                            $volledigIngevuld = FALSE;
                        }
                        //Controle of de groepsles al bestaat.
                        if ($volledigIngevuld) {
                            $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM groepsles WHERE groepsles=?");
                            mysqli_stmt_bind_param($stmt, "s", $groepsles);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $groepslesBestaat);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);
                            //De uitkomst van de controle wordt weergegeven aan de gebruiker.
                            if ($groepslesBestaat) {
                                print("Deze groepsles bestaat al");
                            }
                            //Als de formulier correct ingevuld is en de groepsles niet bestaat, dan wordt het toegevoegd aan de database.
                            else {
                                $stmt = mysqli_prepare($link, "INSERT INTO groepsles VALUES (?, ?)");
                                mysqli_stmt_bind_param($stmt, "ss", $groepsles, $omschrijving);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_free_result($stmt);
                                mysqli_stmt_close($stmt);
                                print("Groepsles is succesvol toegevoegd");
                            }
                        }
                    }
                    ?>
                    <table>
                        <form  method="post">
                            <!-- De formulier wordt weergegeven en als het niet correct is ingevuld word er onthouden wat je ingevuld hebt. -->
                            <!-- Als er op wijzigen (naast elke les staat een wijzigen knop) is geklikt, dan wordt de naam van de groepsles uit de link gehaald en word het weergegeven in de "Naam groepsles" veld-->
                            <tr><td>Naam groepsles: </td><td><input type="text" name="groepsles" maxlength="45" value=<?php
                                    if (isset($_POST["groepsles"])) {
                                        print($_POST["groepsles"]);
                                    }
                                    if (isset($_GET["wijzigen"])) {
                                        print($_GET["wijzigen"]);
                                    }
                                    ?> ></td><td><?php
                                        //Als je een groepsles toevoegt of wijzigt en de naam is leeg dan wordt er een melding weergegeven.
                                        if (isset($_POST["versturen"]) || isset($_POST["wijzigen"])) {
                                            if (empty($_POST["groepsles"])) {
                                                print("Dit vak is verplicht");
                                            }
                                        }
                                        ?></td></tr>
                            <tr><td>Omschrijving: </td><td><textarea rows="10" cols="60" maxlength="500" name="omschrijving"><?php
                                        if (isset($_POST["omschrijving"])) {
                                            print($_POST["omschrijving"]);
                                        }
                                        //Als er op wijzigen (naast elke les staat een wijzigen knop) is geklikt, dan word de omschrijving van de groepsles uit de database gehaald en word het weergegeven in de "Omschrijving" veld
                                        if (!isset($_POST["wijzigen"])) {
                                            if (isset($_GET["wijzigen"])) {
                                                $naam = mysqli_real_escape_string($link, $_GET["wijzigen"]);
                                                $stmt = mysqli_prepare($link, "SELECT omschrijving FROM groepsles WHERE groepsles=?");
                                                mysqli_stmt_bind_param($stmt, "s", $naam);
                                                mysqli_stmt_execute($stmt);
                                                mysqli_stmt_bind_result($stmt, $omschrijving);
                                                mysqli_stmt_fetch($stmt);
                                                mysqli_stmt_free_result($stmt);
                                                mysqli_stmt_close($stmt);
                                                print($omschrijving);
                                            }
                                        }
                                        ?></textarea></td></tr>
                            <!-- Als er op wijzigen (naast elke les staat een wijzigen knop) is geklikt, dan word de wijzigknop (onder de invoervelden) weergegeven en anders de toevoeg knop -->
                            <tr><?php if (isset($_GET["wijzigen"])) { ?><td></td><td><input type="submit" value="Wijzigen" name="wijzigen"<?php $groepsles ?>></td></form> <td><form>
                                    <input type='submit' value='Terug'></td></form><?php } else {
                                            ?><td></td><td><form method='post'><input type="submit" value="Toevoegen" name="versturen"></td></form> <?php } ?></tr>
                            </form>
                    </table>
                    <br>
                    <?php
                    //Als er op verwijderen (rood kruisje) is geklikt dan controleert het eerst of de groespsles in de agenda voorkomt.
                    if (isset($_GET["verwijderen"])) {
                        $verwijder = $_GET["verwijderen"];
                        $stmt = mysqli_prepare($link, "SELECT COUNT(*) FROM groepsles_activiteit WHERE groepsles=?");
                        mysqli_stmt_bind_param($stmt, "s", $verwijder);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $groepslesactiviteit);
                        mysqli_stmt_fetch($stmt);
                        mysqli_stmt_free_result($stmt);
                        mysqli_stmt_close($stmt);
                        //De uitkomst van de controle wordt weergegeven aan de gebruiker.
                        if ($groepslesactiviteit) {
                            print ("<script>alert('Verwijder eerst deze les uit de agenda.');</script>");
                            print ("<script> window.location.href = '/admin/lessen';  </script>");
                        }
                        //Als de groeples niet in de agenda voorkomt, dan wordt het verwijderd uit de database.
                        else {
                            $stmt = mysqli_prepare($link, "DELETE FROM groepsles WHERE groepsles = ?");
                            mysqli_stmt_bind_param($stmt, "s", $verwijder);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_free_result($stmt);
                            mysqli_stmt_close($stmt);
                            header('Location: /admin/lessen');
                        }
                    }
                    //De groepslessen worden uit de database gehaald en onder elkaar weergegeven.
                    $stmt = mysqli_prepare($link, "SELECT groepsles, omschrijving FROM groepsles ORDER BY groepsles");
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $groepsles, $omschrijving);
                    print("<table class='tabel'>");
                    ?>
                    <!-- javascript om na te vragen of je een groepsles zeker wilt verwijderen. -->
                    <script type="text/javascript">
                        function verwijder() {
                            return confirm('Weet je zeker dat je deze les wilt verwijderen?');
                        }
                    </script>
                    <!-- Per groesples word er een wijzig en verwijder (rood kruisje) knop weergegeven. -->
                    <?php while (mysqli_stmt_fetch($stmt)) { ?>
                        <tr><td><br><h3><?php print $groepsles; ?></h3></td>
                        <form>
                            <input type='hidden' name='wijzigen' value=<?php print $groepsles; ?>>
                            <td><input type='submit' value='Wijzigen'></td>
                        </form><form>
                            <input type='hidden' name='verwijderen' value=<?php print $groepsles; ?>>
                            <!-- Als je op verwijderen (rood kruisje) klikt, dan krijg je een pop-up om na te vragen of je een groepsles zeker wilt verwijderen. -->
                            <td id='verwijderknop'>   <input type='submit' value='X' onclick='return verwijder()'></td></tr>
                        </form>
                        <tr><td> <?php print $omschrijving; ?> <hr size=1> </td></tr>
                        <?php
                    }
                    print("</table>");
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                    //Databaseconnectie afsluiten
                    mysqli_close($link);
                }
                ?>
            </div>
        </div>
    </body>
</html>