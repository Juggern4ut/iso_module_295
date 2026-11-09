<?php
// Willkommen bei Modul 295 - Lektion 11 (Formulare)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben in diese Datei.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-formulare/ im Browser.

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

// Aufgabe 4: Formular verarbeiten

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

    <!-- Aufgabe 4: Bestellbestätigung -->

    <h2>Bestellung</h2>
    <!-- Aufgabe 3: Bestellformular -->

</body>

</html>
