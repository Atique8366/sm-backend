<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\CustomerOrder;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Carbon\Carbon;

class ItemRepository implements ItemRepositoryInterface
{
    public function getAllItems()
    {
        return Item::all();
    }

    public function getItemById($id)
    {
        return Item::find($id);
    }

    public function createItem(array $data)
    {
        $data['total_amount'] = $data['cost_of_item'] * $data['total_quantity'];
        return Item::create($data);
    }

    public function updateItem($id, array $data)
    {
        $item = Item::find($id);

        if ($item) {
            $item->update($data);
        }

        return $item;
    }

    public function stockWithDate(array $dates)
    {
        $startAt = Carbon::parse($dates['date_from']);
        $endAt = Carbon::parse($dates['date_to']);

        $orders = CustomerOrder::whereBetween('second_order_date', [$startAt, $endAt])->get();
        $items = Item::all();

        $totalSale = 0;
        $totalProfit = 0;
        $itemList = [];

        foreach ($items as $item) {
            $quantity = 0;
            $profit = 0;
            $sale = 0;

            foreach ($orders as $order) {
                if ($order->item_id == $item->id) {
                    $quantity += $order->item_quantity;
                    $sale += $order->yourbill;
                    $profit += $order->profit;
                }
            }

            $totalProfit += $profit;
            $totalSale += $sale;

            $itemList[] = [
                'item_name' => $item->item_name,
                'total_amount' => $sale,
                'total_quantity' => $quantity,
                'type_of_item' => $item->type_of_item,
                'cost_of_item' => $profit,
            ];
        }

        return [
            'list_item' => $itemList,
            'total_sale' => $totalSale,
            'total_profit' => $totalProfit,
        ];
    }

    public function stockAdd(array $data)
    {
        $item = Item::find($data['id']);

        if ($item) {
            $newStockAmount = $data['cost_of_item'] * $data['total_quantity'];

            $item->update([
                'total_quantity' => $item->total_quantity + $data['total_quantity'],
                'total_amount' => $item->total_amount + $newStockAmount,
                'real_item_cost' => ($item->total_amount + $newStockAmount) / ($item->total_quantity + $data['total_quantity']),
            ]);
        }

        return $item;
    }
}