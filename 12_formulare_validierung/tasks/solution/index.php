<?php
// Willkommen bei Modul 295 - Lektion 12 (Formulare II & Validierung)
//
// Lösung inklusive Bonusaufgabe (Aufgabe 10).

session_start();

// Aufgabe 7: Validierung aus eigener Datei
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

// Eingaben einlesen - beim ersten Aufruf (GET) sind alle Werte leer
$daten = [
    "vorname" => trim($_POST["vorname"] ?? ""),
    "nachname" => trim($_POST["nachname"] ?? ""),
    "email" => trim($_POST["email"] ?? ""),
    "alter" => trim($_POST["alter"] ?? ""),
    "plz" => trim($_POST["plz"] ?? ""),
    "kurs" => $_POST["kurs"] ?? "",
    "agb" => isset($_POST["agb"]),
];

$anmeldungen = $_SESSION["anmeldungen"] ?? [];

// Aufgabe 3: vor der if-Abfrage initialisieren, damit $errors auch beim GET existiert
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Aufgabe 7 / 10: alle Prüfungen in der Funktion
    $errors = validiereAnmeldung($daten, $kurse, $anmeldungen);

    if (count($errors) === 0) {
        // Aufgabe 8: speichern, Flash-Meldung setzen und umleiten (Post/Redirect/Get)
        $_SESSION["anmeldungen"][] = $daten;
        $_SESSION["flash"] = "Vielen Dank, " . $daten["vorname"] . "! Ihre Anmeldung für "
            . $kurse[$daten["kurs"]]["name"] . " ist eingegangen.";
        header("Location: index.php");
        exit;
    }
}

// Aufgabe 8: Flash-Meldung lesen und sofort löschen, damit sie nur einmal erscheint
$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

// Aufgabe 6: kleine Hilfsfunktion für die CSS-Klasse ungültiger Felder
function klasse(array $errors, string $feld): string
{
    return isset($errors[$feld]) ? "ungueltig" : "";
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Kursanmeldung - Hofladen Sonnenhof</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        form {
            display: grid;
            gap: 6px;
            max-width: 400px;
        }

        label {
            margin-top: 8px;
            font-weight: bold;
        }

        .fehler {
            color: #c0392b;
            margin: 0;
        }

        input.ungueltig,
        select.ungueltig {
            border: 2px solid #c0392b;
        }

        .erfolg {
            border: 1px solid #7bd88f;
            background: #eefbf0;
            padding: 10px 16px;
        }
    </style>
</head>

<body>
    <h1>Kursanmeldung</h1>

    <!-- Aufgabe 8: Flash-Meldung -->
    <?php if ($flash !== null): ?>
        <p class="erfolg"><?= e($flash) ?></p>
    <?php endif; ?>

    <!-- Aufgabe 6: Hinweis statt Fehlerliste -->
    <?php if (count($errors) > 0): ?>
        <p class="fehler">Bitte korrigieren Sie die markierten Felder.</p>
    <?php endif; ?>

    <!-- novalidate aus Aufgabe 2 wurde am Ende wieder entfernt -->
    <form method="post">
        <label for="vorname">Vorname</label>
        <input type="text" id="vorname" name="vorname" required maxlength="50"
            class="<?= klasse($errors, "vorname") ?>" value="<?= e($daten["vorname"]) ?>">
        <?php if (isset($errors["vorname"])): ?>
            <p class="fehler"><?= e($errors["vorname"]) ?></p>
        <?php endif; ?>

        <label for="nachname">Nachname</label>
        <input type="text" id="nachname" name="nachname" required maxlength="50"
            class="<?= klasse($errors, "nachname") ?>" value="<?= e($daten["nachname"]) ?>">
        <?php if (isset($errors["nachname"])): ?>
            <p class="fehler"><?= e($errors["nachname"]) ?></p>
        <?php endif; ?>

        <label for="email">E-Mail</label>
        <input type="email" id="email" name="email" required
            class="<?= klasse($errors, "email") ?>" value="<?= e($daten["email"]) ?>">
        <?php if (isset($errors["email"])): ?>
            <p class="fehler"><?= e($errors["email"]) ?></p>
        <?php endif; ?>

        <label for="alter">Alter</label>
        <input type="number" id="alter" name="alter" required min="16" max="99"
            class="<?= klasse($errors, "alter") ?>" value="<?= e($daten["alter"]) ?>">
        <?php if (isset($errors["alter"])): ?>
            <p class="fehler"><?= e($errors["alter"]) ?></p>
        <?php endif; ?>

        <label for="plz">PLZ</label>
        <input type="text" id="plz" name="plz" required pattern="[0-9]{4}"
            class="<?= klasse($errors, "plz") ?>" value="<?= e($daten["plz"]) ?>">
        <?php if (isset($errors["plz"])): ?>
            <p class="fehler"><?= e($errors["plz"]) ?></p>
        <?php endif; ?>

        <label for="kurs">Kurs</label>
        <select id="kurs" name="kurs" required class="<?= klasse($errors, "kurs") ?>">
            <option value="">-- bitte wählen --</option>
            <?php foreach ($kurse as $key => $kurs): ?>
                <?php // Aufgabe 10: ausgebuchte Kurse deaktivieren ?>
                <?php $ausgebucht = anzahlAnmeldungen($anmeldungen, $key) >= $kurs["plaetze"]; ?>
                <option value="<?= $key ?>"
                    <?= $daten["kurs"] === $key ? "selected" : "" ?>
                    <?= $ausgebucht ? "disabled" : "" ?>>
                    <?= e($kurs["name"]) ?> (<?= $kurs["datum"] ?>)<?= $ausgebucht ? " (ausgebucht)" : "" ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors["kurs"])): ?>
            <p class="fehler"><?= e($errors["kurs"]) ?></p>
        <?php endif; ?>

        <span>
            <input type="checkbox" id="agb" name="agb" value="ja" required
                <?= $daten["agb"] ? "checked" : "" ?>>
            <label for="agb">Ich akzeptiere die AGB</label>
        </span>
        <?php if (isset($errors["agb"])): ?>
            <p class="fehler"><?= e($errors["agb"]) ?></p>
        <?php endif; ?>

        <button>Anmelden</button>
    </form>

    <!-- Aufgabe 9: Übersicht der Kurse -->
    <h2>Kurse</h2>
    <table>
        <tr>
            <th>Kurs</th>
            <th>Datum</th>
            <th>Belegt</th>
        </tr>
        <?php foreach ($kurse as $key => $kurs): ?>
            <tr>
                <td><?= e($kurs["name"]) ?></td>
                <td><?= $kurs["datum"] ?></td>
                <td><?= anzahlAnmeldungen($anmeldungen, $key) ?> von <?= $kurs["plaetze"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>
