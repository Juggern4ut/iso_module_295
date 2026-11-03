<?php
// Willkommen bei Modul 295 - Lektion 10 (PHP & HTML)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben in diese Datei.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-html/ im Browser.

$shopName = "Hofladen Sonnenhof";

$kategorien = ["Obst", "Gemüse", "Brot"];

$produkte = [
    ["name" => "Äpfel", "kategorie" => "Obst", "preis" => 3.5, "vorrat" => 12],
    ["name" => "Birnen", "kategorie" => "Obst", "preis" => 4.2, "vorrat" => 0],
    ["name" => "Karotten", "kategorie" => "Gemüse", "preis" => 2.8, "vorrat" => 25],
    ["name" => "Kartoffeln", "kategorie" => "Gemüse", "preis" => 3.9, "vorrat" => 4],
    ["name" => "Bauernbrot", "kategorie" => "Brot", "preis" => 6.5, "vorrat" => 3],
    ["name" => "Zopf", "kategorie" => "Brot", "preis" => 7.8, "vorrat" => 0],
];

// Aufgabe 7: Funktion e() und Begrüssung

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Hofladen</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 10px;
            text-align: left;
        }

        tr.ausverkauft {
            color: #999;
            text-decoration: line-through;
        }

        nav a {
            margin-right: 12px;
        }

        nav a.aktiv {
            font-weight: bold;
        }

        footer {
            margin-top: 40px;
            color: #777;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <!-- Aufgabe 2: Überschrift und Datum -->
    <h1>Hofladen</h1>

    <!-- Aufgabe 7: Begrüssung -->

    <!-- Aufgabe 3: Liste der Kategorien -->

    <!-- Aufgabe 4-6: Produkttabelle -->

</body>

</html>
