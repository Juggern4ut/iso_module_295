<?php
// Willkommen bei Modul 295 - Lektion 02 (Variablen und Datentypen)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben unterhalb dieser Kommentare.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-datentypen/ im Browser.

// Aufgabe 2: Datentyp herausfinden
$city = "Bern";
$population = 133000;
$area = 51.6;
$isCapital = true;

echo gettype($city);
echo gettype($population);
echo gettype($area);
echo gettype($isCapital);

// Aufgabe 3: Datentyp prüfen
var_dump(is_string($city));
var_dump(is_int($population));
var_dump(is_float($area));
var_dump(is_bool($isCapital));

// Aufgabe 4: Type Juggling beobachten
echo "5" + 3;    // int(8) - Strings werden bei "+" zu Zahlen umgewandelt
echo "5" . 3;     // string("53") - "." konkateniert immer als String
echo "2.5" + "2.5"; // float(5) - beide Strings werden zu float umgewandelt

// Aufgabe 5: Type Casting
$input = "7";

var_dump((int) $input);
var_dump((float) $input);
var_dump((bool) $input);

// Aufgabe 6: Rechnen mit Casting
$quantity = "4";
$unitPrice = 12.50;

$total = (int) $quantity * $unitPrice;
echo $total;

// Aufgabe 7: Wahrheitswerte
var_dump((bool) 0);       // bool(false)
var_dump((bool) "0");     // bool(false)
var_dump((bool) "");      // bool(false)
var_dump((bool) "false"); // bool(true) - nicht-leerer String, gilt als true
var_dump((bool) []);      // bool(false)
var_dump((bool) null);    // bool(false)

// Aufgabe 8: Konstanten definieren
const VAT_RATE = 0.077;
const SHOP_NAME = "Modul 295 Shop";

echo VAT_RATE;
echo SHOP_NAME;

// Aufgabe 9: Rechnen mit Konstanten
$netPrice = 49.90;
$grossPrice = $netPrice * (1 + VAT_RATE);

echo $grossPrice;

// Aufgabe 10: Loser vs. strikter Vergleich
var_dump("10" == 10);  // bool(true) - Type Juggling wandelt "10" zu int um
var_dump("10" === 10); // bool(false) - unterschiedlicher Typ (string vs. int)
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Modul 295 - 02 Variablen und Datentypen</title>
</head>

<body>
    <h1>Variablen und Datentypen</h1>
</body>

</html>
