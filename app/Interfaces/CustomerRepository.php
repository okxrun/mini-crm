<?php
interface CustomerRepository {
    public function getAll();
    public function create($data);
    public function update($id, $data);
    public function find($id);
}

?>