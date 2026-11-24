<?php
// Aufgabe 7: geschützte Verwaltung
// Aufgabe 8: Kursbilder hochladen
// Aufgabe 10: Bonusaufgabe - Anmeldungen löschen und alte Bilder entfernen
//
// Beide Formulare schicken an admin.php. Das versteckte Feld "aktion" sagt,
// welches Formular abgeschickt wurde.

require_once "app.php";
require_once "auth.php"; // ab hier ist sicher jemand eingeloggt

$anmeldungen = ladeJson("anmeldungen.json");
$bilder = ladeJson("bilder.json"); // z.B. ["brot" => "zopf.jpg"]

$errors = [];
$aktion = $_POST["aktion"] ?? "";

// Aufgabe 8: Kursbild hochladen
if ($_SERVER["REQUEST_METHOD"] === "POST" && $aktion === "bild") {
    $kurs = $_POST["kurs"] ?? "";
    $bild = $_FILES["bild"] ?? null;
    $erlaubt = ["image/jpeg" => "jpg", "image/png" => "png"];

    if (!isset($kurse[$kurs])) {
        $errors["kurs"] = "Bitte wählen Sie einen Kurs aus.";
    }

    if ($bild === null || $bild["error"] !== UPLOAD_ERR_OK) {
        $errors["bild"] = "Bitte wählen Sie ein Bild aus.";
    } elseif ($bild["size"] > 2 * 1024 * 1024) {
        $errors["bild"] = "Das Bild darf höchstens 2 MB gross sein.";
    } elseif (!isset($erlaubt[mime_content_type($bild["tmp_name"])])) {
        $errors["bild"] = "Nur JPG- und PNG-Bilder sind erlaubt.";
    }

    if (count($errors) === 0) {
        // Uploadname übernehmen - basename() entfernt Pfadangaben wie ../
        $name = basename($bild["name"]);
        move_uploaded_file($bild["tmp_name"], __DIR__ . "/bilder/" . $name);

        // Aufgabe 10: altes Bild dieses Kurses löschen - aber nicht, wenn es gleich heisst
        // wie das neue (dann wurde es eben überschrieben und würde sonst gelöscht)
        if (
            isset($bilder[$kurs])
            && $bilder[$kurs] !== $name
            && file_exists(__DIR__ . "/bilder/" . $bilder[$kurs])
        ) {
            unlink(__DIR__ . "/bilder/" . $bilder[$kurs]);
        }

        $bilder[$kurs] = $name;
        speichereJson("bilder.json", $bilder);

        $_SESSION["flash"] = "Das Bild für " . $kurse[$kurs]["name"] . " wurde gespeichert.";
        header("Location: admin.php");
        exit;
    }
}

// Aufgabe 10: Anmeldung löschen
if ($_SERVER["REQUEST_METHOD"] === "POST" && $aktion === "loeschen") {
    $index = filter_var($_POST["index"] ?? "", FILTER_VALIDATE_INT);

    if ($index !== false && isset($anmeldungen[$index])) {
        $name = $anmeldungen[$index]["vorname"] . " " . $anmeldungen[$index]["nachname"];
        unset($anmeldungen[$index]);
        // Schlüssel neu durchnummerieren, sonst wird in JSON ein Objekt statt einer Liste
        // gespeichert, z.B. {"1": {...}} statt [{...}]
        speichereJson("anmeldungen.json", array_values($anmeldungen));
        $_SESSION["flash"] = "Die Anmeldung von " . $name . " wurde gelöscht.";
    }

    header("Location: admin.php");
    exit;
}

$flash = $_SESSION["flash"] ?? null;
unset($_SESSION["flash"]);

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Verwaltung - Hofladen Sonnenhof</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px 8px;
            text-align: left;
        }

        form.upload {
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

        .erfolg {
            border: 1px solid #7bd88f;
            background: #eefbf0;
            padding: 10px 16px;
        }
    </style>
</head>

<body>
    <h1>Verwaltung</h1>
    <p>
        Angemeldet als <b><?= e($_SESSION["benutzer"]) ?></b> ·
        <a href="logout.php">Logout</a> ·
        <a href="index.php">Zur Kursanmeldung</a>
    </p>

    <?php if ($flash !== null): ?>
        <p class="erfolg"><?= e($flash) ?></p>
    <?php endif; ?>

    <h2>Anmeldungen</h2>
    <?php if (count($anmeldungen) === 0): ?>
        <p>Es sind noch keine Anmeldungen eingegangen.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Kurs</th>
                <th></th>
            </tr>
            <?php foreach ($anmeldungen as $index => $anmeldung): ?>
                <tr>
                    <td><?= e($anmeldung["vorname"] . " " . $anmeldung["nachname"]) ?></td>
                    <td><?= e($anmeldung["email"]) ?></td>
                    <td><?= e($kurse[$anmeldung["kurs"]]["name"]) ?></td>
                    <td>
                        <!-- Aufgabe 10: Löschen per POST, nie per Link (GET). GET-Requests sollen
                             nichts verändern: Links werden vom Browser vorausgeladen, landen im
                             Verlauf und können anderen untergeschoben werden. -->
                        <form method="post">
                            <input type="hidden" name="aktion" value="loeschen">
                            <input type="hidden" name="index" value="<?= $index ?>">
                            <button>Löschen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <h2>Kursbild hochladen</h2>
    <form class="upload" method="post" enctype="multipart/form-data">
        <input type="hidden" name="aktion" value="bild">

        <label for="kurs">Kurs</label>
        <select id="kurs" name="kurs" required>
            <option value="">-- bitte wählen --</option>
            <?php foreach ($kurse as $key => $kurs): ?>
                <option value="<?= $key ?>" <?= ($_POST["kurs"] ?? "") === $key ? "selected" : "" ?>>
                    <?= e($kurs["name"]) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors["kurs"])): ?>
            <p class="fehler"><?= e($errors["kurs"]) ?></p>
        <?php endif; ?>

        <label for="bild">Bild (JPG oder PNG, max. 2 MB)</label>
        <input type="file" id="bild" name="bild" accept="image/jpeg, image/png" required>
        <?php if (isset($errors["bild"])): ?>
            <p class="fehler"><?= e($errors["bild"]) ?></p>
        <?php endif; ?>

        <button>Hochladen</button>
    </form>
</body>

</html>
