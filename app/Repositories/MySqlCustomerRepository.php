<?php 
require_once __DIR__ . "/../../db.php";
require_once __DIR__ . "/../Interfaces/CustomerRepository.php";

class MySqlCustomerRepository implements CustomerRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    } 

    public function getAll() {
        $stmt = $this->pdo->query("SELECT name, email FROM customers ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC возвращает массив, индексированный именами столбцов результирубщего набора 
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO customers (name, email) VALUES (?, ?)");
        $stmt->execute([$data['name'], $data['email']]);
    }
}
?>