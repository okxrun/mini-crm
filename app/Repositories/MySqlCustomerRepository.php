<?php 
require_once __DIR__ . "/../../db.php";
require_once __DIR__ . "/../Interface/CustomerRepository.php";

class MySqlCustomerRepository implements CustomerRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    } 
}
?>