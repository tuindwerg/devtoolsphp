<?php

function adminActive($pagina, $isDropdown) {
    // Print class='active' als de ingevoerde pagina de huidige is

    if ($isDropdown) {
        $huidigeMap = trim(substr(dirname(huidigePagina()) . PHP_EOL, 7));

        if ($pagina == $huidigeMap) {
            print ("active");
        }
    } else {
        $huidigPad = trim(substr(dirname(huidigePagina()) . PHP_EOL, 7)) . "/" . trim(basename(huidigePagina()));

        if ($pagina == $huidigPad) {
            print ("class='active'");
        }
    }
}
?>
<!--Admin navigatie menu-->
<div id="adminmenu">
    <ul>
        <li class="uitlog">
            <a href="../includes/uitloggen.php">Uitloggen</a>
        </li>

        <li <?php adminActive("overzicht/index.php", FALSE) ?>>
            <a href="../overzicht/">Overzicht</a>
        </li>

        <li class="dropdown <?php adminActive("agenda", TRUE) ?>">
            <a>Agenda</a>
            <ul>
                <li <?php adminActive("agenda/week.php", FALSE) ?>><a href="../agenda/week.php">Wekelijkse agenda beheren</a></li>
                <li <?php adminActive("agenda/evenementen.php", FALSE) ?>><a href="../agenda/evenementen.php">Evenementen beheren</a></li>
            </ul>
        </li>

        <li <?php adminActive("lessen/index.php", FALSE) ?>>
            <a href="../lessen/">Groepslessen</a>
        </li>

        <li <?php adminActive("proefles/index.php", FALSE) ?>>
            <a href="../proefles/">Proeflessen</a>
        </li>

        <li <?php adminActive("reviews/index.php", FALSE) ?>>
            <a href="../reviews/">Reviews</a>
        </li>
    </ul>
</div>
<!--Einde navigatie menu-->