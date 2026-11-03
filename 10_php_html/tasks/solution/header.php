<?php
// Aufgabe 8: Kopf der Seite
// Erwartet, dass $title und $shopName bereits definiert sind.
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title><?= e($title) ?> - <?= e($shopName) ?></title>
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
    <!-- Aufgabe 2: Überschrift -->
    <h1><?= e($shopName) ?></h1>
