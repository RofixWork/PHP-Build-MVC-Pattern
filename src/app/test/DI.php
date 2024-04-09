<?php
class Product
{
    public function __construct(public string $name, public float $price, public int $quantity, public DateTime $created_at)
    {
    }

    public function calculatePriceWithTax()
    {
        
    }
}

class ShoppingOrder
{
    public string $shoppingId;
    public Product $product;
    public function __construct()
    {
        $this->shoppingId = uniqid("shopping_");
        //some implementation
    }

    public function setProduct(Product $product) : static
    {
        $this->product = $product;
        return $this;
    }

    public function calculateTotalPayment()
    {
       
    }

    public function __toString(): string
    {
        return <<<SHOPPING
    Number: {$this->shoppingId}
    Name: {$this->product->name}
    Price: {$this->product->price}
    Quantity: {$this->product->quantity}
    Created At: {$this->product->created_at->format("d/m/Y H:i")}
SHOPPING;

    }
}

final class ShoppingOrderDIContainer
{
    public function __construct(private readonly array $params)
    {
    }

    public function createProduct() : Product
    {
        return new Product($this->params['name'], $this->params['price'], $this->params['quantity'], $this->params['created_at']);
    }

    public function createShoppingOrder(Product $product) : ShoppingOrder
    {
        $order = new ShoppingOrder();
        return $order->setProduct($product);
    }
}


//$shoppingOrder = new ShoppingOrder();
//
//$shoppingOrder->setProduct(new Product("p1", 200, 3, new DateTime('now')));
//
//$container = new ShoppingOrderDIContainer([
//    'name' => "product 1",
//    "price" => 100,
//    'quantity' => 30,
//    'created_at' => new DateTime
//]);
//
//$shoppingOrder = $container->createShoppingOrder($container->createProduct());
//echo $shoppingOrder . PHP_EOL;
/**
 * connect = connect ith db and return pdo object
 * database = queries
 */

class Connect
{
    private ?PDO $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=my_db", 'root', 'root', [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }catch (PDOException $exception)
        {
            echo $exception->getMessage();
//            throw new PDOException($exception->getMessage(), $exception->getMessage());
        }

    }

    public function getConnection() : ?PDO
    {
        return $this->pdo ?? null;
    }

}

class Transaction
{
    public function __construct(private ?PDO $db)
    {
    }

    public function get() : array|false
    {
        $query = "select * from transactions";

        $statement = $this->db->query($query);

        return [
            "transactions" =>  $statement->fetchAll(),
            "count" => $statement->rowCount()
        ];
    }

    public function find(int $id) : ?array
    {
        $statement = $this->db->prepare("SELECT * FROM transactions WHERE id = :id");
        $statement->bindValue(":id", $id, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetch() ?: null;
    }

    public function delete(int $id) : bool
    {
        $transaction = $this->find($id);

        if($transaction)
        {
            $statement = $this->db->prepare("DELETE FROM transactions WHERE id = :id");
            $statement->bindValue(":id", $id, PDO::PARAM_INT);
            $result = $statement->execute();

            if($result)
            {
                return true;
            }

        }
        return false;
    }
}

class TransactionDIContainer
{
    public function createConnection() : PDO
    {
        return (new Connect())->getConnection();
    }

    public function createTransaction(PDO $pdo) : Transaction
    {
        return new Transaction($pdo);
    }
}

$container = new TransactionDIContainer();
$transaction = $container->createTransaction($container->createConnection());
var_dump($transaction->get());