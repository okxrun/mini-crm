<?php 
require_once __DIR__ . "/../../db.php";
require_once __DIR__ . "/../Interfaces/CustomerRepository.php";

class MySqlCustomerRepository implements CustomerRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    } 

    public function getAll() {
        $stmt = $this->pdo->query("SELECT id, name, email FROM customers ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC возвращает массив, индексированный именами столбцов результирубщего набора 
    }

    public function create($data) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO customers (name, email) VALUES (?, ?)");
            return $stmt->execute([$data['name'], $data['email']]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new Exception("duplicate_email");
            } else {
                throw $e;
            }
        }
        
    }

    public function update($id, $data) {
        try {
            $stmt = $this->pdo->prepare("UPDATE customers SET name = ?, email = ? WHERE id = ?");
            return $stmt->execute([$data['name'], $data['email'], $id]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new Exception("duplicate_email");
            } else {
                throw $e;
            }
        }
    }

    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT id, name, email FROM customers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM customers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>