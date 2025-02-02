<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    private $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        return response()->json($this->itemRepository->getAllItems());
    }

    public function store(Request $request)
    {
        $item = $this->itemRepository->createItem($request->all());

        if (!$item) {
            return response()->json(['message' => 'No Item Found'], 400);
        }

        return response()->json($item, 201);
    }

    public function filterWithDate(Request $request)
    {
        return response()->json($this->itemRepository->stockWithDate($request->all()));
    }

    public function update(Request $request, $id)
    {
        $item = $this->itemRepository->updateItem($id, $request->all());

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }

    public function stockAdd(Request $request)
    {
        $item = $this->itemRepository->stockAdd($request->all());

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }
}