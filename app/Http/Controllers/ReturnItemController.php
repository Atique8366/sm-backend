<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ReturnItemRepositoryInterface;
use Illuminate\Http\Request;

class ReturnItemController extends Controller
{
    protected $returnItemRepository;

    public function __construct(ReturnItemRepositoryInterface $returnItemRepository)
    {
        $this->returnItemRepository = $returnItemRepository;
    }

    public function index()
    {
        return response()->json($this->returnItemRepository->getAllReturnItems());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'customer_id' => 'required|exists:customers,id',
            'return_quantity' => 'required|numeric|min:1',
            'return_date' => 'required|date',
        ]);

        return response()->json($this->returnItemRepository->createReturnItem($data), 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'return_quantity' => 'nullable|numeric|min:1',
            'return_price' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
            'return_date' => 'nullable|date',
        ]);

        return response()->json($this->returnItemRepository->updateReturnItem($id, $data));
    }
}