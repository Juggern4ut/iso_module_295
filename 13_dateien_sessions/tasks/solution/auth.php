<?php
// Aufgabe 7: Zugriffsschutz für alle Seiten der Verwaltung
//
// Wird nach app.php eingebunden (dort steht session_start()).

if (!isset($_SESSION["benutzer"])) {
    header("Location: login.php");
    exit;
}
