<?php
interface CustomerRepository {
    public function getAll();
    public function create($data);
}

?>