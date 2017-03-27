<?php

function huidigePagina() {
    $huidigePagina = $_SERVER["REQUEST_URI"];

    $overigPos = strpos($huidigePagina, "?");
    if ($overigPos != FALSE) {
        $huidigePagina = substr($huidigePagina, 0, $overigPos);
    }

    if (substr($huidigePagina, -1) == "/") {
        $huidigePagina .= "index.php";
    }

    return $huidigePagina;
}

if (huidigePagina() == "/index.php") {
    $punt = "";
} elseif (huidigePagina() == "/proefles/activatie/index.php" || huidigePagina() == "/proefles/kwijt/index.php" || huidigePagina() == "/reviews/kwijt/index.php") {
    $punt = "../.";
} else {
    $punt = ".";
}

include ("$punt./includes/functies.php");

$link = databaseConnect();
?>

<script>
    var divID = 'reviewjs';

    function CollapseExpand() {
        var divObject = document.getElementById(divID);
        var currentCssClass = divObject.className;

        if (divObject.className === 'divVisible')
            divObject.className = 'divHidden';
        else
            divObject.className = "divVisible";
    }
</script>

<div class="topheader">
    <div class="headerfloatbox">

        <?php
        // Openingstijden ophalen
        $vandaag = date("N");

        $stmt = mysqli_prepare($link, "SELECT openingstijd, sluitingstijd FROM openingstijden WHERE week_dag=?");
        mysqli_stmt_bind_param($stmt, "i", $vandaag);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $openingstijd, $sluitingstijd);

        mysqli_stmt_fetch($stmt);
        $openingstijd = substr($openingstijd, 0, 5);
        $sluitingstijd = substr($sluitingstijd, 0, 5);

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);

        // Evenementen ophalen
        $vandaag = date("Y-m-d");

        $stmt = mysqli_prepare($link, "SELECT toelichting_kort, toelichting_lang, gesloten FROM evenement WHERE datum=?");
        mysqli_stmt_bind_param($stmt, "s", $vandaag);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);
        $evenement_vandaag = mysqli_stmt_num_rows($stmt);
        if ($evenement_vandaag > 0) {
            $evenement_vandaag = TRUE;
        } elseif ($evenement_vandaag == 0) {
            $evenement_vandaag = FALSE;
        } else {
            print ("FOUT");
        }

        mysqli_stmt_bind_result($stmt, $toelichting_kort, $toelichting_lang, $gesloten);
        mysqli_stmt_fetch($stmt);

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
        ?>

        <?php if (!empty($openingstijd)) { ?>
            <h4>Vandaag op de agenda:</h4>
            <h5>Geopend van <?php print ($openingstijd); ?> tot <?php print ($sluitingstijd); ?></h5>
        <?php } else { ?>
            <h4>Vandaag gesloten</h4>
        <?php } ?>

        <?php
        if ($evenement_vandaag) {
            if ($gesloten && !empty($toelichting_lang)) {
                ?>
                <h5><?php print ($toelichting_lang); ?></h5>
            <?php } else { ?>
                <h5><?php if (!empty($toelichting_lang)) { ?>
                        <b>
                        <?php } ?>
                        <?php print ($toelichting_kort); ?>
                        <?php if (!empty($toelichting_lang)) { ?>
                            :</b><i> <span id='niet_bold'><?php print ($toelichting_lang); ?></span></i>
                    <?php } ?></h5>
                <?php
            }
        }
        ?>

        <div id="agenda_vandaag_container">
            <table id="agenda_vandaag">
                <?php
                if (!$gesloten) {
                    $vandaag = date("N");

                    $stmt = mysqli_prepare($link, "SELECT groepsles, begintijd, eindtijd FROM groepsles_activiteit WHERE week_dag=? ORDER BY begintijd");
                    mysqli_stmt_bind_param($stmt, "i", $vandaag);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $groepsles, $begintijd, $eindtijd);

                    while (mysqli_stmt_fetch($stmt)) {
                        $begintijd = substr($begintijd, 0, 5);
                        $eindtijd = substr($eindtijd, 0, 5);
                        ?>
                        <tr>
                            <td class='header_links'><?php print ($groepsles); ?>:</td>
                            <td class='header_rechts'><?php
                                print ($begintijd);
                                if (!empty($eindtijd)) {
                                    print (" - $eindtijd");
                                }
                                ?></td>
                        </tr>
                        <?php
                    }

                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                }
                ?>
            </table>
        </div>
    </div>
</div>

<!-- Onderstaande print de logo's en de headerbar met daarin de inschrijflink en proefles link. -->
<div class="headerbar">
    <div class="headerbarinfo">
        <div id="headerbarinfo_child">
            <p id="header_inschrijvenlink"><b>
                    <a href="<?php print ($punt); ?>./abonnementen/">SCHRIJF JE IN!</a>
                </b></p>
            <p class="klein">
                <a href="<?php print ($punt); ?>./proefles/">GRATIS PROEFLES? KLIK HIER!</a>
            </p>
        </div>
    </div>
    <a href="/" id="logo_link">
        <img src="<?php print ($punt); ?>./includes/header/afb/logo.png" class="logo">
        <img src="<?php print ($punt); ?>./includes/header/afb/logo_tekst.png" class="textlogo">
    </a>
    <script>
        $(document).ready(function () {
            $("#logo_link").hover(function () {
                $("#homebutton").addClass("homebutton_hover");
            }, function () {
                $("#homebutton").removeClass("homebutton_hover");
            }
            );
        });
    </script>
</div>

<!-- Hier word de menubalk geprint. -->
<div class="navbar">
    <table>
        <tr>
            <?php

            function actievePaginaCheck($pad) {
                // Zorgt ervoor dat de actieve pagina anders wordt weergegeven in de navigatiebalk
                if (huidigePagina() == $pad) {
                    print ("id='nav_huidig'");
                }
            }
            ?>
            <td id="homebutton">
                <div>
                    <a href="<?php print ($punt); ?>./">Homepagina</a>
                </div>
            </td>
            <td <?php actievePaginaCheck("/agenda/index.php"); ?>>
                <div>
                    <a href="<?php print ($punt); ?>./agenda">Agenda</a>
                </div>
            </td>
            <td <?php actievePaginaCheck("/abonnementen/index.php"); ?>>
                <div>
                    <a href="<?php print ($punt); ?>./abonnementen">Abonnementen</a>
                </div>
            </td>
            <td <?php actievePaginaCheck("/lessen/index.php"); ?>>
                <div>
                    <a href="<?php print ($punt); ?>./lessen">Lessen</a>
                </div>
            </td>
            <td <?php actievePaginaCheck("/zalen/index.php"); ?>>
                <div>
                    <a href="<?php print ($punt); ?>./zalen">Zalen</a>
                </div>
            </td>
            <td <?php actievePaginaCheck("/contact/index.php"); ?>>
                <div>
                    <a href="<?php print ($punt); ?>./contact">Contact</a>
                </div>
            </td>
        </tr>
    </table>
</div>


<?php
// Het ophalen van de reviews uit de database die door de administrator bevestigd zijn.
$stmt3 = mysqli_prepare($link, "SELECT voornaam, achternaam, waardering, bericht FROM review WHERE status = 2");
mysqli_stmt_execute($stmt3);
mysqli_stmt_bind_result($stmt3, $voornaam, $achternaam, $waarde, $bericht);
?>

<!-- Hier word de ticker geprint waarin de reviews komen te staan. -->
<div class="tickerbg">
    <marquee>
        <?php
        while (mysqli_stmt_fetch($stmt3)) {
            print("<h4 class=\"ticker\">" . $voornaam . " " . $achternaam . "</h4>");
            for ($i = 0; $i < $waarde; $i++) {
                ?>
                <img src='<?php print ($punt); ?>./reviews/afb/sterklein.png'>
                <?php
            }
            $bericht = ucfirst($bericht);
            print(": " . $bericht . "\" - - - ");
        }

        mysqli_stmt_free_result($stmt3);
        mysqli_stmt_close($stmt3);
        ?>
    </marquee>
</div>


<?php mysqli_close($link); ?>