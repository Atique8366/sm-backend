<?
namespace App\Repositories;

use App\Models\Invoice;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getAllInvoices()
    {
        return Invoice::all();
    }

    public function getInvoiceById(int $id)
    {
        return Invoice::find($id);
    }

    public function createInvoice(array $data)
    {
        return Invoice::create($data);
    }

    public function updateInvoice(int $id, array $data)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($data);
        return $invoice;
    }
}