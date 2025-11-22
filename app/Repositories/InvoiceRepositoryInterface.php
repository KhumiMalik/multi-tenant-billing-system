<?php
namespace App\Repositories;

interface InvoiceRepositoryInterface {
    public function list(array $filters = []);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
