<?php
// Aufgabe 6: Login für die Verwaltung

require_once "app.php";

// bereits eingeloggt? Dann direkt weiter zur Verwaltung
if (isset($_SESSION["benutzer"])) {
    header("Location: admin.php");
    exit;
}

$benutzername = trim($_POST["benutzername"] ?? "");
$fehler = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $benutzer = ladeJson("benutzer.json"); // ["admin" => "$2y$10$..."]
    $hash = $benutzer[$benutzername] ?? null;

    if ($hash !== null && password_verify($_POST["passwort"] ?? "", $hash)) {
        // neue Session-ID nach dem Login - Schutz vor Session-Fixation
        session_regenerate_id(true);
        $_SESSION["benutzer"] = $benutzername;
        header("Location: admin.php");
        exit;
    }

    // gleiche Meldung für falschen Benutzer und falsches Passwort - sonst könnte ein
    // Angreifer zuerst herausfinden, welche Benutzernamen es gibt
    $fehler = "Benutzername oder Passwort ist falsch.";
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Login - Hofladen Sonnenhof</title>
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
            max-width: 300px;
        }

        label {
            margin-top: 8px;
            font-weight: bold;
        }

        .fehler {
            color: #c0392b;
        }
    </style>
</head>

<body>
    <h1>Login Verwaltung</h1>

    <?php if ($fehler !== null): ?>
        <p class="fehler"><?= e($fehler) ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="benutzername">Benutzername</label>
        <input type="text" id="benutzername" name="benutzername" required
            value="<?= e($benutzername) ?>">

        <!-- das Passwort wird absichtlich nicht wieder ins Feld geschrieben -->
        <label for="passwort">Passwort</label>
        <input type="password" id="passwort" name="passwort" required>

        <button>Einloggen</button>
    </form>

    <p><a href="index.php">Zurück zur Anmeldung</a></p>
</body>

</html>
