<?php
// Willkommen bei Modul 295 - Lektion 12 (Formulare II & Validierung)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben in diese Datei.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-validierung/ im Browser.

session_start();

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

$angemeldet = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Aufgabe 3-5: Eingaben validieren

    $angemeldet = true;
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

    <?php if ($angemeldet): ?>
        <p class="erfolg">
            Vielen Dank, <?= e($daten["vorname"]) ?>! Ihre Anmeldung ist eingegangen.
        </p>
    <?php endif; ?>

    <form method="post">
        <label for="vorname">Vorname</label>
        <input type="text" id="vorname" name="vorname" required maxlength="50"
            value="<?= e($daten["vorname"]) ?>">

        <label for="nachname">Nachname</label>
        <input type="text" id="nachname" name="nachname" required maxlength="50"
            value="<?= e($daten["nachname"]) ?>">

        <label for="email">E-Mail</label>
        <input type="email" id="email" name="email" required
            value="<?= e($daten["email"]) ?>">

        <label for="alter">Alter</label>
        <input type="number" id="alter" name="alter" required min="16" max="99"
            value="<?= e($daten["alter"]) ?>">

        <label for="plz">PLZ</label>
        <input type="text" id="plz" name="plz" required pattern="[0-9]{4}"
            value="<?= e($daten["plz"]) ?>">

        <label for="kurs">Kurs</label>
        <select id="kurs" name="kurs" required>
            <option value="">-- bitte wählen --</option>
            <?php foreach ($kurse as $key => $kurs): ?>
                <option value="<?= $key ?>" <?= $daten["kurs"] === $key ? "selected" : "" ?>>
                    <?= e($kurs["name"]) ?> (<?= $kurs["datum"] ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <span>
            <input type="checkbox" id="agb" name="agb" value="ja" required
                <?= $daten["agb"] ? "checked" : "" ?>>
            <label for="agb">Ich akzeptiere die AGB</label>
        </span>

        <button>Anmelden</button>
    </form>

    <!-- Aufgabe 9: Übersicht der Kurse -->

</body>

</html>
