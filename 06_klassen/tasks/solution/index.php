<?php
// Willkommen bei Modul 295 - Lektion 06 (Klassen)
//
// Schreiben Sie Ihren PHP-Code für die Aufgaben unterhalb dieser Kommentare.
// Legen Sie diesen Ordner in das htdocs-Verzeichnis Ihrer XAMPP-Installation,
// starten Sie Apache über das XAMPP Control Panel und öffnen Sie danach
// http://localhost/php-klassen/ im Browser.

// Aufgabe 2: Erste Klasse
class Product
{
    public string $name;
    public float $price;

    public function printInfo()
    {
        echo $this->name . ": " . $this->price . " CHF";
    }
}

$apple = new Product();
$apple->name = "Apfel";
$apple->price = 0.50;
$apple->printInfo(); // "Apfel: 0.5 CHF"

$bread = new Product();
$bread->name = "Brot";
$bread->price = 3.20;
$bread->printInfo(); // "Brot: 3.2 CHF"

// Aufgabe 3: Konstruktor
// (Konstruktor wird direkt in Aufgabe 4 mit Property Promotion umgesetzt,
// die beiden Schreibweisen sind gleichwertig - siehe Folien "Konstruktor"
// und "Constructor Property Promotion")

// Aufgabe 4: Constructor Property Promotion
class ProductWithConstructor
{
    public function __construct(
        public string $name,
        public float $price
    ) {}

    public function printInfo()
    {
        echo $this->name . ": " . $this->price . " CHF";
    }
}

$apple2 = new ProductWithConstructor("Apfel", 0.50);
$apple2->printInfo(); // "Apfel: 0.5 CHF"

$bread2 = new ProductWithConstructor("Brot", 3.20);
$bread2->printInfo(); // "Brot: 3.2 CHF"

// Ab hier wird die Klasse Product schrittweise um die restlichen
// Aufgaben erweitert - sie fasst somit den Stand aller vorherigen
// Aufgaben zusammen.

// Aufgabe 5: Sichtbarkeit und Getter/Setter
// Aufgabe 6: Statische Eigenschaft und Methode
// Aufgabe 7: Klassenkonstante
class FinalProduct
{
    public const TAX_RATE = 0.077;

    private static int $count = 0;

    public function __construct(
        public string $name,
        private float $price
    ) {
        self::$count++;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        if ($price >= 0) {
            $this->price = $price;
        }
    }

    public static function getCount(): int
    {
        return self::$count;
    }

    public function priceWithTax(): float
    {
        return $this->price * (1 + self::TAX_RATE);
    }

    public function printInfo()
    {
        echo $this->name . ": " . $this->price . " CHF";
    }
}

$p1 = new FinalProduct("Apfel", 0.50);
echo $p1->getPrice(); // 0.5

$p1->setPrice(0.80);
echo $p1->getPrice(); // 0.8 - gültiger Wert wurde übernommen

$p1->setPrice(-5);
echo $p1->getPrice(); // 0.8 - negativer Wert wurde ignoriert

$p2 = new FinalProduct("Brot", 3.20);
$p3 = new FinalProduct("Milch", 1.10);
echo FinalProduct::getCount(); // 3

echo $p1->priceWithTax(); // 0.8 * 1.077 = 0.8616

// Aufgabe 8: Vererbung
// Aufgabe 9: Methode überschreiben
class SaleProduct extends FinalProduct
{
    public function __construct(
        string $name,
        float $price,
        public float $discount
    ) {
        parent::__construct($name, $price);
    }

    public function priceWithTax(): float
    {
        $reducedPrice = $this->getPrice() * (1 - $this->discount);
        return $reducedPrice * (1 + self::TAX_RATE);
    }
}

$sale = new SaleProduct("Apfel", 1.00, 0.2);
$sale->printInfo(); // geerbt von FinalProduct: "Apfel: 1 CHF"

$normal = new FinalProduct("Apfel", 1.00);
echo $normal->priceWithTax(); // 1.077 - ohne Rabatt
echo $sale->priceWithTax();   // 0.8616 - mit 20% Rabatt, überschriebene Version

// Aufgabe 10: Abstrakte Klasse
abstract class Shape
{
    abstract public function calculateArea(): float;

    public function printArea(): void
    {
        echo "Fläche: " . $this->calculateArea();
    }
}

// Aufgabe 11: Interface
interface Describable
{
    public function describe(): string;
}

class Circle extends Shape implements Describable
{
    public function __construct(private float $radius) {}

    public function calculateArea(): float
    {
        return M_PI * $this->radius ** 2;
    }

    public function describe(): string
    {
        return "Kreis mit Radius " . $this->radius;
    }
}

class Rectangle extends Shape implements Describable
{
    public function __construct(private float $width, private float $height) {}

    public function calculateArea(): float
    {
        return $this->width * $this->height;
    }

    public function describe(): string
    {
        return "Rechteck " . $this->width . " x " . $this->height;
    }
}

$circle = new Circle(3);
$circle->printArea(); // "Fläche: 28.27..."

$rectangle = new Rectangle(4, 5);
$rectangle->printArea(); // "Fläche: 20"

$shapes = [$circle, $rectangle];
foreach ($shapes as $shape) {
    echo $shape->describe();
    $shape->printArea();
}

// Aufgabe 12: Readonly-Eigenschaften
class Point
{
    public function __construct(
        public readonly float $x,
        public readonly float $y
    ) {}
}

$point = new Point(3, 4);
echo $point->x; // 3
echo $point->y; // 4
// $point->x = 10; // Fehler: readonly-Eigenschaften dürfen nach der
// Initialisierung im Konstruktor nicht mehr verändert werden (Error)

// Aufgabe 13: instanceof
$mixedItems = [$circle, $rectangle, new FinalProduct("Milch", 1.10)];

foreach ($mixedItems as $item) {
    if ($item instanceof Shape) {
        $item->printArea(); // nur bei Circle und Rectangle, nicht bei FinalProduct
    }
}

// Aufgabe 14: Bonusaufgabe - Warenkorb mit Klassen
class ShoppingCart
{
    private array $items = [];

    public function addProduct(FinalProduct $product, int $quantity): void
    {
        $this->items[] = ["product" => $product, "quantity" => $quantity];
    }

    public function getSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item["product"]->getPrice() * $item["quantity"];
        }
        return $subtotal;
    }

    public function getShipping(): float
    {
        return $this->getSubtotal() >= 15 ? 0 : 5.90;
    }

    public function printReceipt(): void
    {
        foreach ($this->items as $item) {
            $product = $item["product"];
            $quantity = $item["quantity"];
            $lineTotal = $product->getPrice() * $quantity;

            echo $product->name . ": " . $quantity . " x " . $product->getPrice()
                . " = " . number_format($lineTotal, 2) . " CHF";
        }

        echo "Zwischensumme: " . number_format($this->getSubtotal(), 2) . " CHF";
        echo "Versand: " . number_format($this->getShipping(), 2) . " CHF";
        echo "Total: " . number_format($this->getSubtotal() + $this->getShipping(), 2) . " CHF";
    }
}

$cart = new ShoppingCart();
$cart->addProduct(new FinalProduct("Apfel", 0.50), 6);
$cart->addProduct(new FinalProduct("Brot", 3.20), 2);
$cart->addProduct(new FinalProduct("Milch", 1.10), 3);

$cart->printReceipt();
// Apfel: 6 x 0.5 = 3.00 CHF
// Brot: 2 x 3.2 = 6.40 CHF
// Milch: 3 x 1.1 = 3.30 CHF
// Zwischensumme: 12.70 CHF
// Versand: 5.90 CHF, da unter 15
// Total: 18.60 CHF
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Modul 295 - 06 Klassen</title>
</head>

<body>
    <h1>Klassen</h1>
</body>

</html>
