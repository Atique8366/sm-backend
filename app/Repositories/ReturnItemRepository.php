<?
namespace App\Repositories;

use App\Models\ReturnItem;
use App\Models\Item;
use App\Models\Customer;
use App\Models\CustomerOrder;

class ReturnItemRepository
{
    public function getAllReturnItems()
    {
        return ReturnItem::with(['item', 'customer'])->get();
    }

    public function getReturnItemById($id)
    {
        return ReturnItem::with(['item', 'customer'])->findOrFail($id);
    }

    public function createReturnItem($data)
    {
        $item = Item::findOrFail($data['item_id']);
        $customer = Customer::findOrFail($data['customer_id']);

        $lastOrder = CustomerOrder::where('customer_id', $data['customer_id'])
            ->where('item_id', $data['item_id'])
            ->orderByDesc('id')
            ->first();

        if (!$lastOrder) {
            return response()->json(['error' => 'No order found for this item'], 400);
        }

        $realCost = $item->real_item_cost * $data['return_quantity'];
        $customerReturnPrice = $data['return_quantity'] * $lastOrder->set_price;
        $returnProfit = $customerReturnPrice - $realCost;

        // Update item stock
        $item->total_quantity += $data['return_quantity'];
        $item->total_amount += $realCost;
        $item->save();

        // Update customer balances
        $customer->total_bill -= $customerReturnPrice;
        $customer->pending_payment -= $customerReturnPrice;
        $customer->profit_from_customer -= $returnProfit;
        $customer->save();

        // Create return item record
        return ReturnItem::create([
            'item_id' => $data['item_id'],
            'customer_id' => $data['customer_id'],
            'return_quantity' => $data['return_quantity'],
            'return_price' => $lastOrder->set_price,
            'total_amount' => $customerReturnPrice,
            'return_date' => $data['return_date']
        ]);
    }

    public function updateReturnItem($id, $data)
    {
        $returnItem = ReturnItem::findOrFail($id);
        $returnItem->update($data);
        return $returnItem;
    }
}