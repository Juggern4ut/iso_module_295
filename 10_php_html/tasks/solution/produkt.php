<?php
// Aufgabe 9: Detailseite eines Produkts, Aufruf z.B. mit produkt.php?id=2

require_once "daten.php";
require_once "funktionen.php";

// (int) macht aus jeder Eingabe eine Zahl, z.B. "abc" -> 0
$id = (int) ($_GET["id"] ?? -1);
$produkt = $produkte[$id] ?? null;

$title = $produkt === null ? "Nicht gefunden" : $produkt["name"];
require "header.php";
?>
    <?php if ($produkt === null): ?>
        <p>Produkt nicht gefunden.</p>
    <?php else: ?>
        <h2><?= e($produkt["name"]) ?></h2>
        <p>Kategorie: <?= e($produkt["kategorie"]) ?></p>
        <p>Preis: <?= number_format($produkt["preis"], 2) ?> CHF</p>
        <p>Vorrat: <?= $produkt["vorrat"] ?> Stück</p>
    <?php endif; ?>

    <p><a href="index.php">Zurück zur Übersicht</a></p>

<?php require "footer.php"; ?>
