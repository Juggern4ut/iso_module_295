<?php
// Willkommen bei Modul 295 - Lektion 01 (Einführung in PHP)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben unterhalb dieser Kommentare.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-intro/ im Browser.

// Aufgabe 2: Hello World
echo "Hallo Welt!";

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Modul 295 - 01 Einführung in PHP</title>
</head>

<body>
    <h1><?php echo "Lukas Meier"; // Aufgabe 3: Hello World mit HTML
        ?></h1>

    <?php
    // Aufgabe 4: Variablen - Name und Alter
    $name = "Lukas";
    $age = 32;

    echo $name;
    echo $age;

    // Aufgabe 5: Variablen - weitere Datentypen
    $isStudent = false;
    $height = 1.82;

    var_dump($isStudent);
    var_dump($height);

    // Aufgabe 6: String-Konkatenation
    echo $name . " ist " . $age . " Jahre alt.";

    // Aufgabe 7: String-Interpolation
    echo "$name ist $age Jahre alt.";

    // Aufgabe 8: Eigene Variablen
    $productName = "Mechanische Tastatur";
    $productPrice = 89.90;
    $productInStock = true;

    echo "Produkt: $productName";
    var_dump($productPrice);
    var_dump($productInStock);

    // Aufgabe 9: Rechnen mit Variablen
    $priceWithVat = $productPrice * 1.077;
    echo "Preis inkl. MwSt.: " . $priceWithVat;
    ?>

</body>

</html>
