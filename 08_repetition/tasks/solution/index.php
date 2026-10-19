<?php
// Willkommen bei Modul 295 - Lektion 08 (Repetition)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben unterhalb dieser Kommentare.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-repetition/ im Browser.

// Aufgabe 13: session_start() gehört ganz an den Anfang der Datei
session_start();

// Aufgabe 2: Variablen und Datentypen
$title = "Clean Code";
$pages = 464;
$rating = 4.5;
$available = true;

var_dump($title);     // string(10) "Clean Code"
var_dump($pages);     // int(464)
var_dump($rating);    // float(4.5)
var_dump($available); // bool(true)
echo "<br>";

const MAX_LOANS = 3;

// Aufgabe 3: Type Casting und Vergleiche
$input = "464";

var_dump($input == $pages);  // bool(true)  - nur der Wert wird verglichen
var_dump($input === $pages); // bool(false) - string ist nicht int

$input = (int) $input;
var_dump($input === $pages); // bool(true)  - jetzt stimmen Wert und Typ
echo "<br>";

// Aufgabe 4: Operatoren
$pagesPerDay = 25;
$fullDays = intdiv($pages, $pagesPerDay); // 18
$rest = $pages % $pagesPerDay;            // 14

$message = $fullDays;
$message .= " volle Tage, danach noch ";
$message .= $rest;
$message .= " Seiten";
echo $message . "<br>"; // 18 volle Tage, danach noch 14 Seiten

// Aufgabe 5: Bedingungen
if ($rating >= 4.5) {
    echo "Top<br>";
} elseif ($rating >= 3) {
    echo "Gut<br>";
} else {
    echo "Mittelmässig<br>";
}

echo ($available ? "ausleihbar" : "ausgeliehen") . "<br>";

$user = $_GET["user"] ?? "Gast";
echo "Hallo, " . $user . "!<br>"; // ?user=Mia -> Hallo, Mia!

// Aufgabe 6: Arrays
$books = [
    ["title" => "Clean Code", "author" => "Robert C. Martin", "pages" => 464, "available" => true],
    ["title" => "Der Hobbit", "author" => "J.R.R. Tolkien", "pages" => 336, "available" => false],
    ["title" => "Momo", "author" => "Michael Ende", "pages" => 304, "available" => true],
    ["title" => "Der kleine Prinz", "author" => "Antoine de Saint-Exupéry", "pages" => 96, "available" => true],
];

$books[] = ["title" => "Dune", "author" => "Frank Herbert", "pages" => 896, "available" => false];

echo "Anzahl Bücher: " . count($books) . "<br>"; // 5
echo "Zweites Buch: " . $books[1]["title"] . "<br>"; // Der Hobbit (Index beginnt bei 0)

// Aufgabe 7: Schleifen
$totalPages = 0;
foreach ($books as $book) {
    if (!$book["available"]) {
        continue; // ausgeliehene Bücher überspringen
    }
    echo $book["title"] . " von " . $book["author"] . " (" . $book["pages"] . " Seiten)<br>";
    $totalPages += $book["pages"];
}
echo "Seiten aller verfügbaren Bücher: " . $totalPages . "<br>"; // 864

for ($i = MAX_LOANS; $i >= 1; $i--) {
    echo $i . " "; // 3 2 1
}
echo "<br>";

// Aufgabe 8: Funktionen
function readingDays(int $pages, int $pagesPerDay = 25): int
{
    return (int) ceil($pages / $pagesPerDay);
}

echo readingDays(464) . "<br>";     // 19 - angefangener Tag zählt mit
echo readingDays(464, 50) . "<br>"; // 10

function formatBook(array $book): string
{
    return $book["title"] . " von " . $book["author"] . " (" . $book["pages"] . " Seiten)";
}

foreach ($books as $book) {
    echo formatBook($book) . "<br>";
}

// Aufgabe 9: Referenzen
function borrowBook(array &$book): void
{
    $book["available"] = false;
}

var_dump($books[0]["available"]); // bool(true)
borrowBook($books[0]);
var_dump($books[0]["available"]); // bool(false)
echo "<br>";
// Ohne & erhält die Funktion nur eine Kopie des Arrays. Die Änderung
// passiert dann nur in der Kopie und $books[0] bleibt unverändert (true).

// Aufgabe 10: Arrow Functions
$longBooks = array_filter($books, fn($book) => $book["pages"] > 300);
echo "Bücher mit mehr als 300 Seiten: " . count($longBooks) . "<br>"; // 4

$titles = array_map(fn($book) => $book["title"], $books);
echo implode(", ", $titles) . "<br>";

// Aufgabe 11: Klassen
class Book
{
    public function __construct(
        private string $title,
        private string $author,
        private int $pages,
        private bool $available = true
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function describe(): string
    {
        return $this->title . " von " . $this->author . " (" . $this->pages . " Seiten)";
    }

    public function borrow(): bool
    {
        if (!$this->available) {
            return false; // bereits ausgeliehen
        }
        $this->available = false;
        return true;
    }
}

$cleanCode = new Book("Clean Code", "Robert C. Martin", 464);
echo $cleanCode->describe() . "<br>";
var_dump($cleanCode->borrow()); // bool(true)  - erfolgreich ausgeliehen
var_dump($cleanCode->borrow()); // bool(false) - war bereits ausgeliehen
echo "<br>";

// Aufgabe 12: Vererbung
class EBook extends Book
{
    public function __construct(
        string $title,
        string $author,
        int $pages,
        private float $fileSizeMb
    ) {
        parent::__construct($title, $author, $pages);
    }

    public function describe(): string
    {
        return parent::describe() . " - E-Book, " . $this->fileSizeMb . " MB";
    }
}

$ebook = new EBook("Momo", "Michael Ende", 304, 2.5);
echo $ebook->describe() . "<br>"; // Momo von Michael Ende (304 Seiten) - E-Book, 2.5 MB

// Aufgabe 13: Sessions - Merkliste
$_SESSION["watchlist"] = $_SESSION["watchlist"] ?? [];

if (isset($_GET["remember"]) && !in_array($_GET["remember"], $_SESSION["watchlist"])) {
    $_SESSION["watchlist"][] = $_GET["remember"];
}

if (isset($_GET["clear"])) {
    unset($_SESSION["watchlist"]);
    $_SESSION["watchlist"] = []; // damit die Ausgabe unten weiterhin funktioniert
}

echo "Merkliste (" . count($_SESSION["watchlist"]) . "): ";
echo implode(", ", $_SESSION["watchlist"]) . "<br>";
// Aufruf z.B. mit index.php?remember=Momo, danach index.php?remember=Dune

// Aufgabe 14: Bonusaufgabe - Ausleih-Limit
$_SESSION["loans"] = $_SESSION["loans"] ?? [];

if (isset($_GET["borrow"])) {
    $bookTitle = $_GET["borrow"];

    if (in_array($bookTitle, $_SESSION["loans"])) {
        echo "Fehler: " . $bookTitle . " ist bereits ausgeliehen.<br>";
    } elseif (count($_SESSION["loans"]) >= MAX_LOANS) {
        echo "Fehler: Sie dürfen maximal " . MAX_LOANS . " Bücher ausleihen.<br>";
    } else {
        $_SESSION["loans"][] = $bookTitle;
        $_SESSION["flash"] = $bookTitle . " wurde ausgeliehen.";
    }
}

if (isset($_GET["return"])) {
    $index = array_search($_GET["return"], $_SESSION["loans"]);

    if ($index !== false) { // !== nötig, da Index 0 sonst als false gilt
        unset($_SESSION["loans"][$index]);
        $_SESSION["flash"] = $_GET["return"] . " wurde zurückgegeben.";
    }
}

// Flash-Message einmal ausgeben und danach sofort entfernen
if (isset($_SESSION["flash"])) {
    echo "<b>" . $_SESSION["flash"] . "</b><br>";
    unset($_SESSION["flash"]);
}

echo "Ausgeliehen (" . count($_SESSION["loans"]) . "/" . MAX_LOANS . "): ";
echo implode(", ", $_SESSION["loans"]) . "<br>";
// Aufruf z.B. mit index.php?borrow=Momo, index.php?return=Momo
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Modul 295 - 08 Repetition</title>
</head>

<body>
    <h1>Repetition</h1>
</body>

</html>
