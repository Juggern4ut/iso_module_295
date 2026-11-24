<?php
// Aufgabe 3: gemeinsamer Code für alle Seiten
//
// Jede Seite bindet diese Datei als Erstes mit require_once "app.php"; ein.

session_start();

require_once "validierung.php";

$kurse = [
    "brot" => ["name" => "Brot backen", "datum" => "05.12.2026", "plaetze" => 3],
    "kaese" => ["name" => "Käse herstellen", "datum" => "12.12.2026", "plaetze" => 2],
    "konfituere" => ["name" => "Konfitüre einkochen", "datum" => "19.12.2026", "plaetze" => 4],
];

function e(string $text): string
{
    return htmlspecialchars($text);
}

/**
 * Lädt eine JSON-Datei aus dem Ordner data/ als Array.
 * Gibt es die Datei (noch) nicht, wird ein leeres Array zurückgegeben.
 */
function ladeJson(string $datei): array
{
    $pfad = __DIR__ . "/data/" . $datei;
    if (!file_exists($pfad)) {
        return [];
    }
    // ?? [] - falls die Datei kein gültiges JSON enthält, gibt json_decode() null zurück
    return json_decode(file_get_contents($pfad), true) ?? [];
}

/**
 * Speichert ein Array als JSON-Datei im Ordner data/.
 * Eine bestehende Datei wird dabei überschrieben.
 */
function speichereJson(string $datei, array $daten): void
{
    $json = json_encode($daten, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(__DIR__ . "/data/" . $datei, $json);
}
