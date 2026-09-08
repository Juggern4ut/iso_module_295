<?php
// Willkommen bei Modul 295 - Lektion 05 (Funktionen)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben unterhalb dieser Kommentare.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-funktionen/ im Browser.

// Aufgabe 2: Erste Funktion
function greet() {
    echo "Hallo zusammen!";
}

greet(); // "Hallo zusammen!"
greet(); // "Hallo zusammen!" - nochmals aufgerufen

// Aufgabe 3: Funktion mit Parameter
function greetByName($name) {
    echo "Hallo " . $name . "!";
}

greetByName("Anna");  // "Hallo Anna!"
greetByName("Bruno"); // "Hallo Bruno!"

// Aufgabe 4: Funktion mit Rückgabewert
function add($a, $b) {
    return $a + $b;
}

$result = add(3, 4);
echo $result;        // 7
echo add(10, 5) * 2; // 30

// Aufgabe 5: Funktion mit mehreren Parametern
function calculateRectangleArea($width, $height) {
    return $width * $height;
}

echo calculateRectangleArea(4, 5);  // 20
echo calculateRectangleArea(10, 3); // 30

// Aufgabe 6: Default-Werte
function greetWithGreeting($name, $greeting = "Hallo") {
    echo $greeting . " " . $name . "!";
}

greetWithGreeting("Anna");           // "Hallo Anna!"
greetWithGreeting("Anna", "Servus"); // "Servus Anna!"

// Aufgabe 7: Type Hints
function multiply(int $a, int $b): int {
    return $a * $b;
}

echo multiply(3, 4); // 12
var_dump(multiply(3, 4)); // int(12)

// Aufgabe 8: Benannte Argumente
// Verwendet dieselbe Funktion wie in Aufgabe 6
greetWithGreeting(name: "Clara", greeting: "Servus"); // "Servus Clara!"
greetWithGreeting(greeting: "Servus", name: "Clara"); // Reihenfolge egal - dasselbe Ergebnis

// Aufgabe 9: Variable Anzahl Argumente
function sum(...$numbers) {
    $total = 0;
    foreach ($numbers as $n) {
        $total += $n;
    }
    return $total;
}

echo sum(1, 2, 3);        // 6
echo sum(5, 10, 15, 20);  // 50

// Aufgabe 10: Array zurückgeben
function minMax($numbers) {
    return [min($numbers), max($numbers)];
}

$range = minMax([5, 3, 8, 1]);
echo $range[0]; // 1 (Minimum)
echo $range[1]; // 8 (Maximum)

[$smallest, $largest] = minMax([12, 4, 9, 27, 3]);
echo $smallest; // 3
echo $largest;  // 27

// Aufgabe 11: Gültigkeitsbereich (Scope)
$counter = 0;

function incrementLocal() {
    $counter = 0; // lokale Variable - unabhängig von der globalen
    $counter++;
    echo $counter; // immer 1, da bei jedem Aufruf neu angelegt
}

incrementLocal(); // 1
incrementLocal(); // 1 - die globale $counter wurde nicht verändert
echo $counter;     // 0

function incrementGlobal() {
    global $counter;
    $counter++;
}

incrementGlobal();
incrementGlobal();
echo $counter; // 2

// Aufgabe 12: Statische Variable
function countCalls() {
    static $count = 0;
    $count++;
    echo "Aufruf Nr. " . $count;
}

countCalls(); // "Aufruf Nr. 1"
countCalls(); // "Aufruf Nr. 2"
countCalls(); // "Aufruf Nr. 3"

// Aufgabe 13: Pass by Reference
function addOne($n) {
    $n = $n + 1; // wirkt sich nicht nach aussen aus
}
function addOneByRef(&$n) {
    $n = $n + 1; // verändert die Original-Variable
}

$x = 5;
addOne($x);
echo $x; // 5 - unverändert

addOneByRef($x);
echo $x; // 6 - verändert

// Aufgabe 14: Rekursion
function factorial($n) {
    if ($n <= 1) {
        return 1; // Abbruchbedingung
    }
    return $n * factorial($n - 1); // Selbstaufruf
}

echo factorial(5); // 5*4*3*2*1 = 120
echo factorial(1); // 1 - Abbruchbedingung greift sofort

// Aufgabe 15: Anonyme Funktion (Closure)
$discount = 0.1;

$applyDiscount = function ($price) use ($discount) {
    return $price * (1 - $discount);
};

echo $applyDiscount(100); // 90
echo $applyDiscount(50);  // 45

$numbers = [1, 2, 3, 4];
$squares = array_map(function ($n) {
    return $n * $n;
}, $numbers);
print_r($squares); // [1, 4, 9, 16]

// Aufgabe 16: Arrow Function
// Löst dieselbe Aufgabe wie 15, aber kompakter
$applyDiscountArrow = fn($price) => $price * (1 - $discount);

echo $applyDiscountArrow(100); // 90

$squaresArrow = array_map(fn($n) => $n * $n, $numbers);
print_r($squaresArrow); // [1, 4, 9, 16]

// Aufgabe 17: Bonusaufgabe - Warenkorb mit Funktionen
function calculateSubtotal($price, $quantity) {
    return $price * $quantity;
}

function formatCurrency($amount) {
    return number_format($amount, 2) . " CHF";
}

function calculateShipping($total) {
    if ($total >= 15) {
        return 0;
    }
    return 5.90;
}

$cart = [
    ["name" => "Apfel", "price" => 0.50, "quantity" => 6],
    ["name" => "Brot",  "price" => 3.20, "quantity" => 2],
    ["name" => "Milch", "price" => 1.10, "quantity" => 3],
];

$total = 0;
foreach ($cart as $item) {
    $subtotal = calculateSubtotal($item["price"], $item["quantity"]);
    $total += $subtotal;

    echo $item["name"] . ": " . $item["quantity"] . " x " . $item["price"] . " = " . formatCurrency($subtotal);
}

echo "Zwischensumme: " . formatCurrency($total);    // 12.70 CHF
echo "Versand: " . formatCurrency(calculateShipping($total)); // 5.90 CHF, da unter 15

$total += calculateShipping($total);
echo "Total: " . formatCurrency($total); // 18.60 CHF
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Modul 295 - 05 Funktionen</title>
</head>

<body>
    <h1>Funktionen</h1>
</body>

</html>
