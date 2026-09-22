<?php
// Willkommen bei Modul 295 - Lektion 07 (Sessions)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben unterhalb dieser Kommentare.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-sessions/ im Browser.

// Aufgabe 2: Erste Session
session_start();

$_SESSION["name"] = "Lukas";
echo $_SESSION["name"]; // "Lukas" - bleibt auch nach dem Neuladen erhalten

// Aufgabe 3: Seitenaufrufe zählen
$_SESSION["views"] = ($_SESSION["views"] ?? 0) + 1;
echo "Sie haben diese Seite " . $_SESSION["views"] . " Mal aufgerufen";
// 1, 2, 3, ... bei jedem Neuladen der Seite

// Aufgabe 4: Session-ID
echo session_id(); // z.B. "8f3ac9d2e1b4..." - bleibt beim Neuladen gleich

// Aufgabe 5: isset() und Begrüssung
if (isset($_SESSION["name"])) {
    echo "Hallo, " . $_SESSION["name"] . "!";
} else {
    echo "Hallo, Gast!";
}

// Aufgabe 9: Einzelnen Wert entfernen
// (theme wird unabhängig vom Login-Status gesetzt und bleibt beim Logout erhalten)
if (!isset($_SESSION["theme"])) {
    $_SESSION["theme"] = "dark";
}

// Aufgabe 6: Login simulieren
// Aufgabe 10: session_regenerate_id()
// (echtes Formular folgt erst in einer späteren Lektion - hier über
// URL-Parameter simuliert, z.B. index.php?user=admin&pass=geheim)
if (($_GET["user"] ?? "") === "admin" && ($_GET["pass"] ?? "") === "geheim") {
    echo "Session-ID vor dem Login: " . session_id();

    session_regenerate_id(true); // true = alte Session-Datei löschen
    $_SESSION["username"] = "admin";

    // Aufgabe 12: Flash-Message
    $_SESSION["flash"] = "Login erfolgreich!";

    echo "Session-ID nach dem Login: " . session_id(); // unterscheidet sich von oben
}

// Aufgabe 12: Flash-Message (Anzeige)
// Wird ganz am Anfang der eigentlichen Seiten-Ausgabe geprüft, damit sie
// nur genau einmal - direkt nach dem Login - erscheint.
if (isset($_SESSION["flash"])) {
    echo $_SESSION["flash"];
    unset($_SESSION["flash"]); // danach entfernen, damit sie nicht erneut erscheint
}

// Aufgabe 7: Geschützte Inhalte
if (isset($_SESSION["username"])) {
    echo "Willkommen, " . $_SESSION["username"] . "!";
} else {
    echo "Bitte zuerst einloggen: index.php?user=admin&pass=geheim";
}

// Aufgabe 8: Logout
// Aufgabe 9: Einzelnen Wert entfernen
if (isset($_GET["logout"])) {
    echo "Sie wurden ausgeloggt.";

    unset($_SESSION["username"]); // nur der Login-Status wird entfernt
    echo "Theme ist weiterhin gesetzt: " . $_SESSION["theme"]; // z.B. "dark"

    exit;
}

// Aufgabe 11: Session-Timeout
// (in der Praxis direkt nach session_start() geprüft - hier am Ende
// platziert, damit die vorherigen Ausgaben dieser Lektion sichtbar bleiben)
$timeout = 15; // Sekunden
if (isset($_SESSION["lastActivity"]) && time() - $_SESSION["lastActivity"] > $timeout) {
    session_destroy();
    session_start(); // neue, leere Session für den weiteren Verlauf des Skripts
    echo "Ihre Session war inaktiv und wurde zurückgesetzt.";
}
$_SESSION["lastActivity"] = time();

// Aufgabe 13: Bonusaufgabe - Mini-Warenkorb mit Sessions
class CartItem
{
    public function __construct(
        public string $name,
        public float $price
    ) {}
}

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if (isset($_GET["add"]) && isset($_GET["price"])) {
    $_SESSION["cart"][] = new CartItem($_GET["add"], (float) $_GET["price"]);
}

$total = 0;
foreach ($_SESSION["cart"] as $item) {
    echo $item->name . ": " . $item->price . " CHF";
    $total += $item->price;
}
echo "Total: " . $total . " CHF";
// Aufruf z.B. mit index.php?add=Apfel&price=0.50, danach nochmals mit
// index.php?add=Brot&price=3.20 - der Warenkorb wächst über beide Requests
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Modul 295 - 07 Sessions</title>
</head>

<body>
    <h1>Sessions</h1>
</body>

</html>
