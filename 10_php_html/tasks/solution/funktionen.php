<?php
// Aufgabe 7: Hilfsfunktion zum Maskieren von Ausgaben
// Aufgabe 8: in eigene Datei ausgelagert

function e(string $text): string
{
    return htmlspecialchars($text);
}
