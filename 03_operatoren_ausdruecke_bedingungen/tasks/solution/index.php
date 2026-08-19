<?php
// Willkommen bei Modul 295 - Lektion 03 (Operatoren, Ausdrücke und Bedingungen)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben unterhalb dieser Kommentare.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-operatoren/ im Browser.

// Aufgabe 2: Arithmetische Operatoren
$a = 15;
$b = 4;

echo $a + $b;  // 19
echo $a - $b;  // 11
echo $a * $b;  // 60
echo $a / $b;  // 3.75
echo $a % $b;  // 3 - Rest der Division
echo $a ** 2;  // 225 - $a hoch 2

// Aufgabe 3: Zuweisungsoperatoren
$cartTotal = 0;
$cartTotal += 19.90;
$cartTotal += 12.50;
$cartTotal -= 5;

echo $cartTotal; // 27.4

$greeting = "Hallo";
$greeting .= " Welt!";

echo $greeting; // "Hallo Welt!"

// Aufgabe 4: Inkrement- und Dekrement-Operatoren
$stock = 10;

$stock++;
echo $stock; // 11

$stock--;
$stock--;
echo $stock; // 9

// Aufgabe 5: Vergleichsoperatoren
$x = 8;
$y = 12;

var_dump($x == $y);  // bool(false)
var_dump($x < $y);   // bool(true)
var_dump($x <=> $y); // int(-1) - $x ist kleiner als $y

// Aufgabe 6: Logische Operatoren
$age = 17;
$hasParentalConsent = true;

var_dump($age >= 18 || $hasParentalConsent); // bool(true)  - Oder: mind. eine Bedingung trifft zu
var_dump($age >= 18 && $hasParentalConsent); // bool(false) - Und: erste Bedingung ist false
var_dump(!$hasParentalConsent);              // bool(false) - Negation von true

// Aufgabe 7: Operatorrangfolge
echo 4 + 3 * 2;   // 10 - Punkt vor Strich: 3 * 2 zuerst
echo (4 + 3) * 2; // 14 - Klammer erzwingt Addition zuerst

// Aufgabe 8: Bedingungen mit if / elseif / else
$points = 68;

if ($points >= 90) {
    echo "Note 6";
} elseif ($points >= 75) {
    echo "Note 5";
} elseif ($points >= 60) {
    echo "Note 4";
} else {
    echo "Note ungenügend";
}

// Aufgabe 9: switch
$weekday = 5;

switch ($weekday) {
    case 1:
        echo "Montag";
        break;
    case 2:
        echo "Dienstag";
        break;
    case 3:
        echo "Mittwoch";
        break;
    case 4:
        echo "Donnerstag";
        break;
    case 5:
        echo "Freitag";
        break;
    case 6:
        echo "Samstag";
        break;
    case 7:
        echo "Sonntag";
        break;
    default:
        echo "Ungültiger Wochentag";
}

// Aufgabe 10: Ternärer Operator
$cartTotal = 120;
$discountText = $cartTotal >= 100 ? "10% Rabatt" : "Kein Rabatt";

echo $discountText;

// Aufgabe 11: Null-Coalescing-Operator
$username = $_GET["user"] ?? "Gast";

echo $username;
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Modul 295 - 03 Operatoren, Ausdrücke und Bedingungen</title>
</head>

<body>
    <h1>Operatoren, Ausdrücke und Bedingungen</h1>
</body>

</html>
