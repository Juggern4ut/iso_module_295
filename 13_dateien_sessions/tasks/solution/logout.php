<?php
// Aufgabe 7: Logout

session_start();

// nur den Login entfernen - andere Werte (z.B. die Flash-Meldung) bleiben erhalten
unset($_SESSION["benutzer"]);
session_regenerate_id(true);

$_SESSION["flash"] = "Sie wurden abgemeldet.";
header("Location: index.php");
exit;
