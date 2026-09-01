<?php
// Willkommen bei Modul 295 - Lektion 04 (Arrays und Schleifen)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben unterhalb dieser Kommentare.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-arrays-schleifen/ im Browser.

// Aufgabe 2: Indizierte Arrays
$fruits = ["Apfel", "Birne", "Kiwi"];

echo $fruits[0]; // "Apfel" - erstes Element
echo $fruits[2]; // "Kiwi"  - letztes Element

$fruits[1] = "Mango"; // zweites Element ändern
$fruits[] = "Orange";  // Element anhängen

print_r($fruits); // Array ( [0] => Apfel [1] => Mango [2] => Kiwi [3] => Orange )

// Aufgabe 3: Assoziative Arrays
$person = [
    "firstname" => "Anna",
    "lastname"  => "Muster",
    "age"       => 23,
];

echo $person["firstname"]; // "Anna"
echo $person["age"];       // 23

$person["age"] = 24; // Wert ändern

print_r($person);

// Aufgabe 4: Elemente hinzufügen und entfernen
$stock = ["Apfel", "Birne", "Kiwi"];

array_push($stock, "Mango"); // Element am Ende hinzufügen

$removedLast = array_pop($stock); // letztes Element entfernen
echo $removedLast; // "Mango"

array_unshift($stock, "Orange"); // Element am Anfang hinzufügen

$removedFirst = array_shift($stock); // erstes Element entfernen
echo $removedFirst; // "Orange"

print_r($stock); // Array ( [0] => Apfel [1] => Birne [2] => Kiwi )

// Aufgabe 5: Im Array suchen
$fruits = ["Apfel", "Birne", "Kiwi", "Mango"];

var_dump(in_array("Kiwi", $fruits));       // bool(true)
var_dump(array_search("Mango", $fruits));  // int(3)
var_dump(array_key_exists(10, $fruits));   // bool(false)

// Aufgabe 6: Arrays sortieren
$numbers = [5, 3, 8, 1, 9];

sort($numbers);
print_r($numbers); // [1, 3, 5, 8, 9]

rsort($numbers);
print_r($numbers); // [9, 8, 5, 3, 1]

$prices = [
    "Kiwi"  => 2.20,
    "Apfel" => 1.50,
    "Birne" => 0.90,
];

asort($prices); // nach Werten (Preisen) sortiert
print_r($prices); // Birne 0.9, Apfel 1.5, Kiwi 2.2

ksort($prices); // nach Schlüsseln (Namen) sortiert
print_r($prices); // Apfel, Birne, Kiwi

// Aufgabe 7: Mehrdimensionale Arrays
$persons = [
    ["firstname" => "Anna", "age" => 23],
    ["firstname" => "Bruno", "age" => 31],
    ["firstname" => "Clara", "age" => 27],
];

echo $persons[1]["firstname"]; // "Bruno" - Vorname der zweiten Person
echo $persons[2]["age"];       // 27     - Alter der dritten Person

// Aufgabe 8: while-Schleife
$fruits = ["Apfel", "Birne", "Kiwi", "Mango"];

$i = 0;
while ($i < count($fruits)) {
    echo $fruits[$i];
    $i++;
}

// Aufgabe 9: do-while-Schleife
$countdown = 5;
do {
    echo $countdown;
    $countdown--;
} while ($countdown >= 1);
// Ausgabe: 54321

// Aufgabe 10: for-Schleife
// Verwendet dasselbe Array wie in Aufgabe 8
for ($i = 0; $i < count($fruits); $i++) {
    echo $i . ": " . $fruits[$i];
}

// Aufgabe 11: foreach-Schleife
// Verwendet erneut dasselbe Array wie in Aufgabe 8
foreach ($fruits as $fruit) {
    echo $fruit;
}
// foreach ist am einfachsten - kein Zähler nötig und keine Gefahr,
// sich beim Index zu vertun.

// Aufgabe 12: foreach mit Schlüssel und Wert
foreach ($prices as $name => $price) {
    echo $name . " kostet " . $price;
}

// Aufgabe 13: break und continue
for ($n = 1; $n <= 20; $n++) {
    if ($n % 7 == 0) {
        break; // stoppt, sobald eine Zahl durch 7 teilbar ist
    }
    echo $n;
}
// Ausgabe: 123456

for ($n = 1; $n <= 10; $n++) {
    if ($n % 2 == 0) {
        continue; // gerade Zahlen überspringen
    }
    echo $n;
}
// Ausgabe: 13579

// Aufgabe 14: Schleife, Array und Bedingung kombiniert
$prices = [19.90, 45.00, 8.50, 120.00, 3.20];

// a) Summe aller Preise
$sum = 0;
foreach ($prices as $price) {
    $sum += $price;
}
echo $sum; // 196.6

// b) Anzahl Preise ab 20
$countAbove20 = 0;
foreach ($prices as $price) {
    if ($price >= 20) {
        $countAbove20++;
    }
}
echo $countAbove20; // 2

// c) Höchster Preis, ohne max()
$highest = $prices[0];
foreach ($prices as $price) {
    if ($price > $highest) {
        $highest = $price;
    }
}
echo $highest; // 120

// Aufgabe 15: Bonusaufgabe - Einkaufsliste
$cart = [
    ["name" => "Apfel", "price" => 0.50, "quantity" => 6],
    ["name" => "Brot",  "price" => 3.20, "quantity" => 2],
    ["name" => "Milch", "price" => 1.10, "quantity" => 3],
];

$total = 0;
foreach ($cart as $item) {
    $subtotal = $item["price"] * $item["quantity"];
    $total += $subtotal;

    echo $item["name"] . ": " . $item["quantity"] . " x " . $item["price"] . " = " . $subtotal;
}

echo "Gesamtbetrag: " . $total; // 3 + 6.4 + 3.3 = 12.7

if ($total >= 15) {
    echo "Versand gratis";
} else {
    echo "Versand: 5.90";
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Modul 295 - 04 Arrays und Schleifen</title>
</head>

<body>
    <h1>Arrays und Schleifen</h1>
</body>

</html>
