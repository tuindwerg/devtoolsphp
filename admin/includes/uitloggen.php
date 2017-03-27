<?php

include "../../includes/functies.php";
session_start();
session_unset();
session_destroy();
if (isAdminPagina()) {
    print "<script>window.open('../../', '_self')</script>";
} else {
    print "<script>location.reload()</script>";
}
?>