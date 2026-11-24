<?php
// Aufgabe 2: Besucherzähler und Protokoll

$datei = __DIR__ . "/data/zaehler.txt";

// Zähler lesen - beim allerersten Aufruf gibt es die Datei noch nicht
$anzahl = 0;
if (file_exists($datei)) {
    $anzahl = (int) file_get_contents($datei);
}

$anzahl++;
file_put_contents($datei, $anzahl);

// Protokoll: jede Zeile wird angehängt, nicht überschrieben
file_put_contents(__DIR__ . "/data/protokoll.txt", date("d.m.Y H:i:s") . "\n", FILE_APPEND);

echo "Diese Seite wurde " . $anzahl . " Mal aufgerufen.";
