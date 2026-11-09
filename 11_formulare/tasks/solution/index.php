<?php
// Willkommen bei Modul 295 - Lektion 11 (Formulare)
//
// Lösung inklusive Bonusaufgabe (Aufgabe 9).

// Aufgabe 9: Session für die gesammelten Bestellungen
session_start();

$shopName = "Hofladen Sonnenhof";

$produkte = [
    ["name" => "Äpfel", "preis" => 3.5],
    ["name" => "Birnen", "preis" => 4.2],
    ["name" => "Karotten", "preis" => 2.8],
    ["name" => "Kartoffeln", "preis" => 3.9],
    ["name" => "Bauernbrot", "preis" => 6.5],
    ["name" => "Zopf", "preis" => 7.8],
];

// Versandkosten bei Lieferung per Post
$versand = 8.5;

// Zusatzoptionen für Aufgabe 7
$extras = [
    "geschenk" => ["name" => "Geschenkverpackung", "preis" => 3.0],
    "karte" => ["name" => "Grusskarte", "preis" => 1.5],
    "express" => ["name" => "Expresslieferung", "preis" => 5.0],
];

function e(string $text): string
{
    return htmlspecialchars($text);
}

// Aufgabe 2: Suche
$suche = $_GET["suche"] ?? null;
$treffer = [];
if ($suche !== null) {
    foreach ($produkte as $p) {
        if (stripos($p["name"], $suche) !== false) {
            $treffer[] = $p;
        }
    }
}

// Aufgabe 8: Standardwerte, damit das Formular auch beim ersten Aufruf funktioniert
$name = "";
$produktId = 0;
$menge = 1;
$lieferung = "abholen";
$bemerkung = "";
$newsletter = false;
$gewaehlteExtras = [];
$bestellt = false;

// Aufgabe 4: Wurde das Formular abgeschickt?
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $produktId = (int) ($_POST["produkt"] ?? 0);
    $menge = (int) ($_POST["menge"] ?? 1);
    $lieferung = $_POST["lieferung"] ?? "abholen";
    $bemerkung = trim($_POST["bemerkung"] ?? "");
    // Aufgabe 6: Checkbox fehlt in $_POST, wenn sie nicht angehakt ist
    $newsletter = isset($_POST["newsletter"]);
    // Aufgabe 7: name="extras[]" ergibt ein Array
    $gewaehlteExtras = $_POST["extras"] ?? [];

    // Ungültige Produkt-ID: auf das erste Produkt zurückfallen
    // (richtige Validierung folgt in Lektion 12)
    $produkt = $produkte[$produktId] ?? $produkte[0];

    // Aufgabe 5: Preis immer auf dem Server berechnen, nie aus dem Formular übernehmen
    $total = $menge * $produkt["preis"];
    if ($lieferung === "post") {
        $total += $versand;
    }

    // Aufgabe 7: nur bekannte Zusatzoptionen berücksichtigen
    $extraNamen = [];
    foreach ($gewaehlteExtras as $key) {
        if (isset($extras[$key])) {
            $extraNamen[] = $extras[$key]["name"];
            $total += $extras[$key]["preis"];
        }
    }

    // Aufgabe 9: Bestellung in der Session speichern
    $_SESSION["bestellungen"][] = [
        "name" => $name,
        "produkt" => $produkt["name"],
        "menge" => $menge,
        "total" => $total,
    ];

    $bestellt = true;
}

// Aufgabe 9: Liste leeren
if (isset($_GET["leeren"])) {
    unset($_SESSION["bestellungen"]);
}
$bestellungen = $_SESSION["bestellungen"] ?? [];
$summe = 0;
foreach ($bestellungen as $b) {
    $summe += $b["total"];
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title><?= e($shopName) ?></title>
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

        .bestaetigung {
            border: 1px solid #7bd88f;
            background: #eefbf0;
            padding: 10px 16px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <h1><?= e($shopName) ?></h1>

    <!-- Aufgabe 2: Suchformular -->
    <form method="get">
        <input type="search" name="suche" value="<?= e($suche ?? "") ?>">
        <button>Suchen</button>
    </form>

    <?php if ($suche !== null): ?>
        <p>Suchergebnisse für: <?= e($suche) ?></p>
        <?php if (count($treffer) === 0): ?>
            <p>Keine Produkte gefunden.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($treffer as $p): ?>
                    <li><?= e($p["name"]) ?> (<?= number_format($p["preis"], 2) ?> CHF)</li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Aufgabe 4: Bestellbestätigung -->
    <?php if ($bestellt): ?>
        <div class="bestaetigung">
            <p>Danke, <?= e($name) ?>! Sie haben <?= $menge ?> x <?= e($produkt["name"]) ?> bestellt.</p>
            <p><?= $lieferung === "post" ? "Lieferung per Post" : "Abholung im Laden" ?></p>
            <?php if ($bemerkung !== ""): ?>
                <p>Bemerkung: <?= e($bemerkung) ?></p>
            <?php endif; ?>
            <?php if (count($extraNamen) > 0): ?>
                <p>Zusatzoptionen:</p>
                <ul>
                    <?php foreach ($extraNamen as $extraName): ?>
                        <li><?= e($extraName) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if ($newsletter): ?>
                <p>Sie erhalten ab jetzt unseren Newsletter.</p>
            <?php endif; ?>
            <p><b>Total: <?= number_format($total, 2) ?> CHF</b></p>
        </div>
    <?php endif; ?>

    <h2>Bestellung</h2>
    <!-- Aufgabe 3: Bestellformular, Aufgabe 8: mit erhaltenen Werten -->
    <form method="post">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= e($name) ?>">

        <label for="produkt">Produkt</label>
        <select id="produkt" name="produkt">
            <?php foreach ($produkte as $id => $p): ?>
                <option value="<?= $id ?>" <?= $id === $produktId ? "selected" : "" ?>>
                    <?= e($p["name"]) ?> (<?= number_format($p["preis"], 2) ?> CHF)
                </option>
            <?php endforeach; ?>
        </select>

        <label for="menge">Menge</label>
        <input type="number" id="menge" name="menge" min="1" value="<?= $menge ?>">

        <label>Lieferung</label>
        <span>
            <input type="radio" id="abholen" name="lieferung" value="abholen"
                <?= $lieferung === "abholen" ? "checked" : "" ?>>
            <label for="abholen">Im Laden abholen</label>
        </span>
        <span>
            <input type="radio" id="post" name="lieferung" value="post"
                <?= $lieferung === "post" ? "checked" : "" ?>>
            <label for="post">Per Post</label>
        </span>

        <!-- Aufgabe 7: Zusatzoptionen -->
        <label>Zusatzoptionen</label>
        <?php foreach ($extras as $key => $extra): ?>
            <span>
                <input type="checkbox" id="<?= $key ?>" name="extras[]" value="<?= $key ?>"
                    <?= in_array($key, $gewaehlteExtras) ? "checked" : "" ?>>
                <label for="<?= $key ?>"><?= e($extra["name"]) ?> (<?= number_format($extra["preis"], 2) ?> CHF)</label>
            </span>
        <?php endforeach; ?>

        <label for="bemerkung">Bemerkung</label>
        <textarea id="bemerkung" name="bemerkung" rows="3"><?= e($bemerkung) ?></textarea>

        <!-- Aufgabe 6: Newsletter -->
        <span>
            <input type="checkbox" id="newsletter" name="newsletter" value="ja"
                <?= $newsletter ? "checked" : "" ?>>
            <label for="newsletter">Newsletter abonnieren</label>
        </span>

        <button>Bestellen</button>
    </form>

    <!-- Aufgabe 9: Bonusaufgabe - alle Bestellungen aus der Session -->
    <?php if (count($bestellungen) > 0): ?>
        <h2>Bisherige Bestellungen</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Produkt</th>
                <th>Menge</th>
                <th>Total</th>
            </tr>
            <?php foreach ($bestellungen as $b): ?>
                <tr>
                    <td><?= e($b["name"]) ?></td>
                    <td><?= e($b["produkt"]) ?></td>
                    <td><?= $b["menge"] ?></td>
                    <td><?= number_format($b["total"], 2) ?> CHF</td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p>Summe aller Bestellungen: <?= number_format($summe, 2) ?> CHF</p>
        <p><a href="index.php?leeren=1">Liste leeren</a></p>
    <?php endif; ?>
</body>

</html>
