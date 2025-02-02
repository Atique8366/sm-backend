<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        return response()->json($this->customerRepository->getAllCustomers());
    }

    public function show($id)
    {
        return response()->json($this->customerRepository->getCustomerById($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'phone_no' => 'nullable|string',
            'is_active' => 'boolean',
            'payment_rcv' => 'numeric',
            'pending_payment' => 'numeric',
            'total_bill' => 'numeric',
            'discount' => 'numeric',
            'profit_from_customer' => 'numeric',
        ]);

        return response()->json($this->customerRepository->createCustomer($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'string',
            'address' => 'nullable|string',
            'phone_no' => 'nullable|string',
            'is_active' => 'boolean',
            'payment_rcv' => 'numeric',
            'pending_payment' => 'numeric',
            'total_bill' => 'numeric',
            'discount' => 'numeric',
            'profit_from_customer' => 'numeric',
        ]);

        return response()->json($this->customerRepository->updateCustomer($id, $data));
    }

    public function receivePayment(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer',
            'payment_rcv' => 'required|numeric',
            'discount' => 'required|numeric',
        ]);

        return response()->json($this->customerRepository->receivePayment($data));
    }

    public function payments()
    {
        return response()->json($this->customerRepository->getAllPayments());
    }

    public function paymentsByCustomer($customerId)
    {
        return response()->json($this->customerRepository->getPaymentsByCustomerId($customerId));
    }
}
