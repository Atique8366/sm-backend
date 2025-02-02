<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\CustomerOrderRepositoryInterface;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    protected $customerOrderRepository;

    public function __construct(CustomerOrderRepositoryInterface $customerOrderRepository)
    {
        $this->customerOrderRepository = $customerOrderRepository;
    }

    public function index()
    {
        return response()->json($this->customerOrderRepository->getAllCustomerOrders());
    }

    public function store(Request $request)
    {
        $order = $this->customerOrderRepository->createCustomerOrder($request->all());
        return response()->json($order, 201);
    }

    public function update($id, Request $request)
    {
        $order = $this->customerOrderRepository->updateCustomerOrder($id, $request->all());
        return response()->json($order);
    }

    public function newOrder($customerId, Request $request)
    {
        $orders = $this->customerOrderRepository->createNewOrder($customerId, $request->all());
        return response()->json($orders);
    }

    public function itemProfit()
    {
        return response()->json($this->customerOrderRepository->getItemProfit());
    }
}
