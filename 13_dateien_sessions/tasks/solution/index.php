<?php
// Willkommen bei Modul 295 - Lektion 13 (Dateien & Sessions)
//
// Lösung inklusive Bonusaufgabe (Aufgabe 10).
//
// Aufgabe 1: Im zweiten Browser steht überall "0 von ...". Die Anmeldungen lagen in
// der Session, und jeder Browser hat seine eigene Session (eigenes Cookie PHPSESSID).
//
// Aufgabe 4: Die Flash-Meldung ist nur für den Besucher bestimmt, der sich gerade
// angemeldet hat. In einer Datei würde sie jeder sehen, der die Seite als Nächstes lädt.

// Aufgabe 3: session_start(), Validierung, $kurse, e() und die JSON-Funktionen stehen in app.php
require_once "app.php";

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

// Aufgabe 4: Anmeldungen aus der Datei statt aus der Session
$anmeldungen = ladeJson("anmeldungen.json");

// Aufgabe 9: Dateinamen der Kursbilder, z.B. ["brot" => "zopf.jpg"]
$bilder = ladeJson("bilder.json");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = validiereAnmeldung($daten, $kurse, $anmeldungen);

    if (count($errors) === 0) {
        // Aufgabe 4: laden - ändern - speichern
        $anmeldungen[] = $daten;
        speichereJson("anmeldungen.json", $anmeldungen);

        // die Flash-Meldung gehört nur diesem Besucher - sie bleibt in der Session
        $_SESSION["flash"] = "Vielen Dank, " . $daten["vorname"] . "! Ihre Anmeldung für "
            . $kurse[$daten["kurs"]]["name"] . " ist eingegangen.";
        header("Location: index.php");
        exit;
    }
}

$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

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

    <?php if ($flash !== null): ?>
        <p class="erfolg"><?= e($flash) ?></p>
    <?php endif; ?>

    <?php if (count($errors) > 0): ?>
        <p class="fehler">Bitte korrigieren Sie die markierten Felder.</p>
    <?php endif; ?>

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

    <h2>Kurse</h2>
    <table>
        <tr>
            <th>Kurs</th>
            <th>Datum</th>
            <th>Belegt</th>
            <th>Bild</th>
        </tr>
        <?php foreach ($kurse as $key => $kurs): ?>
            <tr>
                <td><?= e($kurs["name"]) ?></td>
                <td><?= $kurs["datum"] ?></td>
                <td><?= anzahlAnmeldungen($anmeldungen, $key) ?> von <?= $kurs["plaetze"] ?></td>
                <!-- Aufgabe 9: Kursbild anzeigen, falls eines hochgeladen wurde -->
                <td>
                    <?php if (isset($bilder[$key])): ?>
                        <img src="bilder/<?= e($bilder[$key]) ?>" alt="<?= e($kurs["name"]) ?>" width="120">
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Aufgabe 7: Link zur Verwaltung -->
    <p><a href="admin.php">Verwaltung</a></p>
</body>

</html>
