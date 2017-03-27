<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>T.H. Sport - Agenda</title>

        <link rel="stylesheet" type="text/css" href="../includes/stijl.css">
        <link rel="stylesheet" type="text/css" href="../includes/header/header.css">
        <link rel="stylesheet" type="text/css" href="../includes/footer/footer.css">
        <link rel="stylesheet" type="text/css" href="agenda.css">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="./agenda_popup.js"></script> <!-- Voor de hover-tekst met omschrijving -->

        <!-- Voor de hover kleur: -->
        <script>
            function VeranderKleur(tableRow, highLight) {
                if (highLight) {
                    tableRow.style.backgroundColor = '#6ECA5F';
                } else {
                    tableRow.style.backgroundColor = '#F0F0F0';
                }
            }
        </script>
    </head>

    <body>
        <?php
        include "../includes/header/header.php";

        $link = databaseConnect();

        date_default_timezone_set('Europe/Amsterdam');
        setlocale(LC_ALL, 'nl_NL'); // Bij Engelse weergave veranderen naar 'nld_nld'

        function evenement($dag) {
            // Plaats een evenement in de agenda
            global $link;

            // Maak van een dagnr een datum
            if (isset($_GET["d"])) {
                $datum = $_GET["d"];
                $jaar = date("o", strtotime($datum));
                $weeknr = date("W", strtotime($datum));
            } else {
                $weeknr = date("W");
                $jaar = date("Y");
            }

            $datum = new DateTime();
            $datum->setISODate($jaar, $weeknr, $dag);

            $d_datum = $datum->format('Y-m-d');

            // Evenement uit de database halen
            $stmt = mysqli_prepare($link, "SELECT toelichting_kort, toelichting_lang FROM evenement WHERE gesloten=0 AND datum = ?");
            mysqli_stmt_bind_param($stmt, "s", $d_datum);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $evenement, $toelichting);
            mysqli_stmt_fetch($stmt);

            mysqli_stmt_free_result($stmt);
            mysqli_stmt_close($stmt);

            // Printen
            if (!empty($evenement)) {
                ?>
            <th colspan='2' class='gesloten'
            <?php if (!empty($toelichting)) { ?>
                    onmouseover="VeranderKleur(this, true);
                                        nhpup.popup('<?php print($toelichting); ?>');"
                    onmouseout="VeranderKleur(this, false);"
                <?php } ?>
                >
                    <?php print ($evenement); ?>
            </th>
            <?php
        }
    }

    function print_activiteit($activiteit, $begintijd, $eindtijd, $omschrijving) {
        // Plaats een activiteit in de agenda
        $begintijd = substr($begintijd, 0, 5);
        $eindtijd = substr($eindtijd, 0, 5);

        // Ongeldige tekens vervangen
        $omschrijving = str_replace("'", "&quot;", $omschrijving);
        $omschrijving = str_replace('"', "&quot;", $omschrijving);
        $omschrijving = preg_replace('/[^(\x20-\x7F)]*/', '', $omschrijving);

        // Printen
        ?>
        <tr onmouseover="VeranderKleur(this, true);
                    nhpup.popup('<?php print($omschrijving); ?>');"
            onmouseout="VeranderKleur(this, false);">
            <td><?php
                print ($begintijd);
                if (!empty($eindtijd)) {
                    print ("<br>$eindtijd");
                }
                ?></td>
            <th class='activiteit'><?php print ($activiteit); ?></th>
        </tr>
        <?php
    }

    function activiteiten($dag) {
        // Activiteiten met omschrijvingen van een weekdag uit de database halen en in print_activiteit() stoppen
        global $link;

        // Activiteiten ophalen
        //$stmt = mysqli_prepare($link, "SELECT groepsles, begintijd, eindtijd FROM groepsles_activiteit WHERE week_dag=? ORDER BY begintijd");
        $stmt = mysqli_prepare($link, "SELECT A.groepsles, A.begintijd, A.eindtijd, L.omschrijving "
                . "FROM groepsles_activiteit A "
                . "JOIN groepsles L ON A.groepsles = L.groepsles "
                . "WHERE week_dag=? "
                . "ORDER BY begintijd");
        mysqli_stmt_bind_param($stmt, "i", $dag);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $groepsles, $begintijd, $eindtijd, $omschrijving);

        mysqli_stmt_store_result($stmt);
        $aantalActiviteiten = mysqli_stmt_num_rows($stmt);
        if ($aantalActiviteiten != 0) {
            while (mysqli_stmt_fetch($stmt)) {
                // Plaats activiteit in de agenda
                print_activiteit($groepsles, $begintijd, $eindtijd, $omschrijving);
            }
        }

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }

    function openingstijd($dag) {
        // Print de openingstijd van een dag of print "Gesloten"
        global $link;

        // Ophalen uit database
        $stmt = mysqli_prepare($link, "SELECT openingstijd FROM openingstijden WHERE week_dag=?");
        mysqli_stmt_bind_param($stmt, "i", $dag);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $openingstijd);
        mysqli_stmt_fetch($stmt);

        $openingstijd = substr($openingstijd, 0, 5);

        if (!empty($openingstijd)) {
            // Vandaag open
            ?>
            <tr>
                <td><?php print ($openingstijd); ?></td>
                <th class='activiteit'>Opening</th>
            </tr>
            <?php
        } else {
            // Vandaag gesloten, dag van de week aanmaken, gebaseerd op datum
            if (isset($_GET["d"])) {
                $datum = $_GET["d"];
                $jaar = date("o", strtotime($datum));
                $weeknr = date("W", strtotime($datum));
            } else {
                $weeknr = date("W");
                $jaar = date("Y");
            }

            $datum = new DateTime();
            $datum->setISODate($jaar, $weeknr, $dag);

            $d_maand = $datum->format('m');
            $d_dag = $datum->format('d');
            $d_jaar = $datum->format('Y');

            $d_week_dag = strftime("%A", mktime(0, 0, 0, $d_maand, $d_dag, $d_jaar));
            ?>
            <tr>
                <th colspan='2' class='gesloten'>Gesloten op <?php print (strtolower($d_week_dag)); ?></th>
            </tr>
            <?php
        }

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    }

    function sluitingstijd($dag) {
        // Return de sluitingstijd van een dag
        global $link;

        // Ophalen uit database
        $stmt = mysqli_prepare($link, "SELECT sluitingstijd FROM openingstijden WHERE week_dag = ?");
        mysqli_stmt_bind_param($stmt, "i", $dag);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $sluitingstijd);
        mysqli_stmt_fetch($stmt);

        $sluitingstijd = substr($sluitingstijd, 0, 5);

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);

        return $sluitingstijd;
    }

    function datum($week_dag) {
        // Input: 2014 (jaar), 48 (weeknr), 3 (dag v/d week) | Output: 26 november 2014
        if (isset($_GET["d"])) {
            $datum = $_GET["d"];
            $jaar = date("o", strtotime($datum));
            $weeknr = date("W", strtotime($datum));
        } else {
            $weeknr = date("W");
            $jaar = date("Y");
        }

        $datum = new DateTime();
        $datum->setISODate($jaar, $weeknr, $week_dag);

        $d_maand = $datum->format('m');
        $d_dag = $datum->format('d');
        $d_jaar = $datum->format('Y');

        $d_datum = strftime("%e %B %Y", mktime(0, 0, 0, $d_maand, $d_dag, $d_jaar));
        print ("<th>" . $d_datum . "</th>");
    }

    function gesloten($week_dag) {
        // Kijk of een bepaalde dag gesloten (evenement) is en return de reden hiervan indien aanwezig
        if (isset($_GET["d"])) {
            $datum = $_GET["d"];
            $jaar = date("o", strtotime($datum));
            $weeknr = date("W", strtotime($datum));
        } else {
            $weeknr = date("W");
            $jaar = date("Y");
        }

        $datum = new DateTime();
        $datum->setISODate($jaar, $weeknr, $week_dag);

        $d_datum = $datum->format('Y-m-d');

        global $link;
        $stmt = mysqli_prepare($link, "SELECT toelichting_lang FROM evenement WHERE gesloten=1 AND datum=?");
        mysqli_stmt_bind_param($stmt, "s", $d_datum);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $reden);
        mysqli_stmt_fetch($stmt);

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);

        return $reden;
    }
    ?>

    <div id="inhoud_container">
        <div id="agenda_kop" class="inhoud">

            <!-- Inhoud 1 begin -->
            <h1>Agenda</h1>
            <table>
                <tr>
                    <td>
                        <a href="?d=<?php
                        // Verander GET["d"] in de url naar de datum voorafgaand aan de huidige
                        if (isset($_GET["d"])) {
                            print (date('Y-m-d', strtotime($_GET["d"] . " -1 week")));
                        } else {
                            print (date('Y-m-d', strtotime("-1 week")));
                        }
                        ?>#inhoud_container">
                            < Vorige week
                        </a>
                    </td>
                    <td>
                        <form action="#inhoud_container">
                            Datum: <input type="date" name="d" value="<?php
                            // Verander GET["d"] naar wat er in het veld is ingevuld
                            if (isset($_GET["d"])) {
                                print($_GET["d"]);
                            } else {
                                print (date("Y-m-d"));
                            }
                            ?>">
                            <input type="submit" value="Ga">
                        </form>
                    </td>
                    <td>
                        <a href="?d=<?php
                        // Verander GET["d"] in de url naar de datum voorafgaand aan de huidige
                        if (isset($_GET["d"])) {
                            print (date('Y-m-d', strtotime($_GET["d"] . " +1 week")));
                        } else {
                            print (date('Y-m-d', strtotime("+1 week")));
                        }
                        ?>#inhoud_container">
                            Volgende week >
                        </a>
                    </td>
            </table>
            <!-- Inhoud 1 eind -->

        </div>
        <div class="inhoud2">

            <!-- Inhoud 2 begin -->
            <table id="agenda">
                <colgroup>
                    <?php
                    for ($col = 0; $col < 7; $col++) {
                        ?>
                        <col class="agenda_col">
                    <?php } ?>
                </colgroup>
                <tr>
                    <th>Maandag</th>
                    <th>Dinsdag</th>
                    <th>Woensdag</th>
                    <th>Donderdag</th>
                    <th>Vrijdag</th>
                    <th>Zaterdag</th>
                    <th>Zondag</th>
                </tr>
                <tr id="datums">
                    <?php
                    for ($dag = 1; $dag <= 7; $dag++) {
                        // Voor iedere dag wordt de datum geprint
                        datum($dag);
                    }
                    ?>
                </tr>
                <tr class="agenda_dag">
                    <?php
                    for ($dag = 1; $dag <= 7; $dag++) {
                        // Voor iedere dag wordt alles in de agenda gezet
                        ?>
                        <td>
                            <table>
                                <colgroup>
                                    <col class="agenda_dag_col1">
                                    <col class="agenda_dag_col2">
                                </colgroup>
                                <?php
                                $reden = gesloten($dag);
                                if (empty($reden)) {
                                    // Niet gesloten
                                    evenement($dag);
                                    openingstijd($dag);
                                    activiteiten($dag);
                                } else {
                                    // Wel gesloten
                                    ?>
                                    <tr>
                                        <th colspan='2' class='gesloten'
                                            onmouseover="VeranderKleur(this, true);
                                                            nhpup.popup('<?php print($reden); ?>');"
                                            onmouseout="VeranderKleur(this, false);">
                                            Gesloten
                                        </th>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
                <tr class="agenda_dag">
                    <?php for ($dag = 1; $dag <= 7; $dag++) { ?>
                        <td><?php
                            // Voor iedere dag wordt de sluitingstijd geprint
                            $reden = gesloten($dag);
                            $sluitingstijd = sluitingstijd($dag);
                            if (empty($reden) && !empty($sluitingstijd)) {
                                // Als vandaag niet gesloten is
                                ?>
                                <table>
                                    <colgroup>
                                        <col class="agenda_dag_col1">
                                        <col class="agenda_dag_col2">
                                    </colgroup>

                                    <tr>
                                        <td><?php print (sluitingstijd($dag)); ?></td>
                                        <th class='activiteit'>Sluiting</th>
                                    </tr>
                                </table>
                            <?php } ?></td>
                    <?php } ?>
                </tr>
            </table>
            <!-- Inhoud 2 eind -->

        </div>
    </div>

    <?php
    mysqli_close($link);
    include "../includes/footer/footer.php";
    ?>
</body>
</html>