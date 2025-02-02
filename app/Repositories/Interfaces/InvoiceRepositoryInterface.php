<?php
namespace App\Repositories\Interfaces;

use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function getAllInvoices();
    public function getInvoiceById(int $id);
    public function createInvoice(array $data);
    public function updateInvoice(int $id, array $data);
}