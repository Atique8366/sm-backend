<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\InvoiceRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index()
    {
        return response()->json($this->invoiceRepository->getAllInvoices());
    }

    public function show($id)
    {
        $invoice = $this->invoiceRepository->getInvoiceById($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        return response()->json($invoice);
    }

    public function store(Request $request)
    {
        $invoice = $this->invoiceRepository->createInvoice($request->all());
        return response()->json($invoice, 201);
    }

    public function update($id, Request $request)
    {
        $invoice = $this->invoiceRepository->updateInvoice($id, $request->all());
        return response()->json($invoice);
    }
}