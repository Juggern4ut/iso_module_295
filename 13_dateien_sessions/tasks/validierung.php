<?php
// Validierung der Kursanmeldung (aus Lektion 12, unverändert)

/**
 * Zählt, wie viele Anmeldungen es für einen Kurs gibt.
 */
function anzahlAnmeldungen(array $anmeldungen, string $kurs): int
{
    $anzahl = 0;
    foreach ($anmeldungen as $anmeldung) {
        if ($anmeldung["kurs"] === $kurs) {
            $anzahl++;
        }
    }
    return $anzahl;
}

/**
 * Prüft die Eingaben der Kursanmeldung und gibt die Fehlermeldungen zurück.
 * Der Schlüssel ist jeweils der Name des Feldes. Ein leeres Array bedeutet: alles gültig.
 */
function validiereAnmeldung(array $daten, array $kurse, array $anmeldungen = []): array
{
    $errors = [];

    // Pflichtfelder mit maximaler Länge
    if ($daten["vorname"] === "") {
        $errors["vorname"] = "Bitte geben Sie Ihren Vornamen ein.";
    } elseif (mb_strlen($daten["vorname"]) > 50) {
        $errors["vorname"] = "Der Vorname darf höchstens 50 Zeichen lang sein.";
    }

    if ($daten["nachname"] === "") {
        $errors["nachname"] = "Bitte geben Sie Ihren Nachnamen ein.";
    } elseif (mb_strlen($daten["nachname"]) > 50) {
        $errors["nachname"] = "Der Nachname darf höchstens 50 Zeichen lang sein.";
    }

    // E-Mail und Alter mit filter_var() - immer mit === false vergleichen
    if (filter_var($daten["email"], FILTER_VALIDATE_EMAIL) === false) {
        $errors["email"] = "Bitte geben Sie eine gültige E-Mail-Adresse ein.";
    }

    $alter = filter_var($daten["alter"], FILTER_VALIDATE_INT, [
        "options" => ["min_range" => 16, "max_range" => 99],
    ]);
    if ($alter === false) {
        $errors["alter"] = "Das Alter muss eine ganze Zahl zwischen 16 und 99 sein.";
    }

    // PLZ, Kurs (Whitelist) und AGB
    if (preg_match('/^[0-9]{4}$/', $daten["plz"]) !== 1) {
        $errors["plz"] = "Die PLZ besteht aus genau 4 Ziffern.";
    }

    if (!isset($kurse[$daten["kurs"]])) {
        $errors["kurs"] = "Bitte wählen Sie einen Kurs aus.";
    } elseif (anzahlAnmeldungen($anmeldungen, $daten["kurs"]) >= $kurse[$daten["kurs"]]["plaetze"]) {
        // Kurs ausgebucht
        $errors["kurs"] = "Dieser Kurs ist leider ausgebucht.";
    }

    if (!$daten["agb"]) {
        $errors["agb"] = "Bitte akzeptieren Sie die AGB.";
    }

    // dieselbe E-Mail-Adresse darf pro Kurs nur einmal angemeldet sein
    if (!isset($errors["email"]) && !isset($errors["kurs"])) {
        foreach ($anmeldungen as $anmeldung) {
            if (
                $anmeldung["kurs"] === $daten["kurs"]
                && strtolower($anmeldung["email"]) === strtolower($daten["email"])
            ) {
                $errors["email"] = "Mit dieser E-Mail-Adresse sind Sie bereits angemeldet.";
                break;
            }
        }
    }

    return $errors;
}
