<?php
// Willkommen bei Modul 295 - Lektion 10 (PHP & HTML)
//
// Lösung nach Aufgabe 10: Die ursprüngliche index.php wurde in Aufgabe 8 auf
// daten.php, funktionen.php, header.php und footer.php aufgeteilt.

// Aufgabe 8: Dateien einbinden
require_once "daten.php";
require_once "funktionen.php";

// Aufgabe 7: Begrüssung
$besucher = $_GET["name"] ?? "Gast";

// Aufgabe 6: Anzahl verfügbarer Produkte
$anzahlVerfuegbar = 0;
foreach ($produkte as $p) {
    if ($p["vorrat"] > 0) {
        $anzahlVerfuegbar++;
    }
}

// Aufgabe 10: Bonusaufgabe - nach Kategorie filtern
// array_filter() behält die Schlüssel bei, die IDs für die Links bleiben also korrekt
$gewaehlt = $_GET["kategorie"] ?? null;
$angezeigt = $produkte;
if ($gewaehlt !== null) {
    $angezeigt = array_filter($produkte, fn($p) => $p["kategorie"] === $gewaehlt);
}

$title = "Produkte";
require "header.php";
?>
    <!-- Aufgabe 2: Datum -->
    <p>Heute ist der <?= date("d.m.Y") ?></p>

    <!-- Aufgabe 7: Begrüssung (mit e() gegen XSS geschützt) -->
    <p>Willkommen, <?= e($besucher) ?>!</p>

    <!-- Aufgabe 3: Liste der Kategorien -->
    <!-- Aufgabe 10: als Navigation mit Links -->
    <nav>
        <a href="index.php" class="<?= $gewaehlt === null ? "aktiv" : "" ?>">Alle</a>
        <?php foreach ($kategorien as $kategorie): ?>
            <a href="index.php?kategorie=<?= e($kategorie) ?>"
                class="<?= $gewaehlt === $kategorie ? "aktiv" : "" ?>"><?= e($kategorie) ?></a>
        <?php endforeach; ?>
    </nav>

    <?php if ($gewaehlt !== null): ?>
        <h2>Kategorie: <?= e($gewaehlt) ?></h2>
    <?php endif; ?>

    <!-- Aufgabe 4: Produkttabelle -->
    <table>
        <tr>
            <th>Produkt</th>
            <th>Kategorie</th>
            <th>Preis</th>
            <th>Vorrat</th>
        </tr>
        <?php foreach ($angezeigt as $id => $p): ?>
            <?php // Aufgabe 6: CSS-Klasse für ausverkaufte Produkte ?>
            <tr class="<?= $p["vorrat"] === 0 ? "ausverkauft" : "" ?>">
                <?php // Aufgabe 9: Link auf die Detailseite ?>
                <td><a href="produkt.php?id=<?= $id ?>"><?= e($p["name"]) ?></a></td>
                <td><?= e($p["kategorie"]) ?></td>
                <td><?= number_format($p["preis"], 2) ?> CHF</td>
                <?php // Aufgabe 5: Vorrat anzeigen ?>
                <td>
                    <?php if ($p["vorrat"] === 0): ?>
                        Ausverkauft
                    <?php elseif ($p["vorrat"] < 5): ?>
                        Nur noch <?= $p["vorrat"] ?> Stück
                    <?php else: ?>
                        An Lager
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Aufgabe 6: Anzahl verfügbarer Produkte -->
    <p><?= $anzahlVerfuegbar ?> von <?= count($produkte) ?> Produkten sind an Lager.</p>

<?php require "footer.php"; ?>
