<?php

// Plaats hier alleen functies die op verschillende pagina's worden gebruikt
// Functies die alleen op één pagina worden gebruikt kunnen op die pagina staan

if (!function_exists("huidigePagina")) {

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

}

function isAdminPagina() {
    if (substr(huidigePagina(), 0, 6) == "/admin") {
        return TRUE;
    } else {
        return FALSE;
    }
}

function databaseConnect() {
//    Gebruik: $link = databaseConnect();
    if ($_SERVER["HTTP_HOST"] == "localhost") {
        $link = mysqli_connect("localhost", "root", "usbw", "thsport", 3307);
    } else {
        $link = mysqli_connect("mysql12.000webhost.com", "a1916775_admin", "thsport123", "a1916775_admin", 3306);
    }

    if (!$link) {
        print ("Fout! Geen connectie met de database gemaakt: " . mysqli_connect_error());
    }
    return $link;
}

function activatiecode() {
    $string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($string), 0, 15);
}
// functie om te controleren of formulier is ingevuld
function formulier_ingevuld($veld) {
    if (isset($_POST["versturen"])) {
        if (empty($_POST[$veld])) {
            print ("Veld is verplicht");
        }
    }
}

function form_value_stap3($veld, $selectie = "") {/// alleen gebruiken voor de checkbox ivm array
    // form_value_stap3("vraag1", "nee")
    if (isset($_POST[$veld])) {

        $N = count($_POST[$veld]);
        for ($i = 0; $i < $N; $i++) {
            if ($_POST[$veld][$i] == $selectie) {
                print ("checked");
            }
        }
    }
}

function form_value_stap2($veld, $selectie = "") { // word gebruikt bij inschijfformulier met als verzendmethode POST[form]
    // form_value_stap2("vraag1", "nee")
    if (isset($_POST[$veld])) {
        if ($_POST[$veld] == $selectie) {
            print ("checked");
        }
        return;
    }
    if (isset($_SESSION[$veld])) {
        if ($_SESSION[$veld] == $selectie) {
            print ("checked");
        }
    }
}

function verbergen($vraag) {// met deze functie zorg je er voor dat de onderregel onzichtbaar word.
    if (isset($_POST[$vraag])) {
        if ($_POST[$vraag] == "Nee") {
            print ("verberg");
        }
    } else {
        print ("verberg");
    }
}

// Functies voor formulier:
function form_value($veld, $selectie = "") {
    if (isset($_POST[$veld])) {
        if (!empty($_POST[$veld])) {
            if ($veld != "abonnement") {
                print ($_POST[$veld]);
            } else {
                if ($_POST["abonnement"] == $selectie) {
                    print ("selected");
                }
            }
            return;
        }
    }
    if (isset($_SESSION[$veld])) {
        if (!empty($_SESSION[$veld])) {
            if ($veld != "abonnement") {
                print ($_SESSION[$veld]);
            } else {
                if ($_SESSION["abonnement"] == $selectie) {
                    print ("selected");
                }
            }
        }
    }
}

function ingevuld3($veld, $print = TRUE) {// dit hoort bij inschijving deel 2 form2 hiermee zorg je dat als er op ja word geklikt de velden verplicht worden wat erbij hoord.
    if (isset($_POST["form2"])) {
        if (!empty($_POST[$veld])) {
            if ($_POST[$veld] == "Ja") {
                if ($print) {
                    print ("*verplicht");
                } else {
                    return FALSE;
                }
            } else {
                if (!$print) {
                    return TRUE;
                }
            }
        }
    } elseif (isset($_SESSION["form2"])) {
        if (empty($_SESSION[$veld])) {
            if ($print) {
                print ("*verplicht");
            } else {
                return FALSE;
            }
        } else {
            if (!$print) {
                return TRUE;
            }
        }
    }
}

function ingevuld($veld, $print = FALSE) {
    if (isset($_POST[$veld])) {
        if (empty($_POST[$veld])) {
            if ($print) {
                print ("*verplicht");
            } else {
                return FALSE;
            }
        } else {
            if (!$print) {
                return TRUE;
            }
        }
    } elseif (isset($_SESSION[$veld])) {
        if (empty($_SESSION[$veld])) {
            if ($print) {
                print ("*verplicht");
            } else {
                return FALSE;
            }
        } else {
            if (!$print) {
                return TRUE;
            }
        }
    }
}

function ingevuld2($veld, $print = FALSE) {// dit is bedoeld voor inschijvingformulier. hiermee zorg je dat je op ja of nee moet worden geklikt.
    if (isset($_POST["form2"])) {
        if (empty($_POST[$veld])) {
            if ($print) {
                print ("*verplicht");
            } else {
                return FALSE;
            }
        } else {
            if (!$print) {
                return TRUE;
            }
        }
    } elseif (isset($_SESSION["form2"])) {
        if (empty($_SESSION[$veld])) {
            if ($print) {
                print ("*verplicht");
            } else {
                return FALSE;
            }
        } else {
            if (!$print) {
                return TRUE;
            }
        }
    }
}

function controlform2($vraag, $onderdeel, $sub = true) {
    $ingevuld = ingevuld4($vraag);
    if ($sub) {
        if (isset($_POST[$vraag]) && $_POST[$vraag] == "Ja" || isset($_SESSION[$vraag]) && $_SESSION[$vraag] == "Ja") {
            $ingevuld = ingevuld4($onderdeel);
        }
    }
    if (!$ingevuld) {
      
        return FALSE;
    } else {
        return TRUE;
    }
}

//controle of alle velden zijn ingevuld bij formulier 2
function ingevuld4($veld) {// dit hoort bij inschijving deel 2 form2 hiermee zorg je dat als er op ja word geklikt de velden verplicht worden wat erbij hoord.
    if (isset($_POST["form2"])) {
        if (!empty($_POST[$veld])) {

            return TRUE;
        } else {

            return FALSE;
        }
    }
    if (isset($_SESSION["form2"])) {
        if (!empty($_SESSION[$veld])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

?>