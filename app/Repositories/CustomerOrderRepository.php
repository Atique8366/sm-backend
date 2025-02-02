<?
namespace App\Repositories;

use App\Models\CustomerOrder;
use App\Models\Customer;
use App\Models\Item;
use App\Models\GatePass;
use App\Repositories\Interfaces\CustomerOrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CustomerOrderRepository implements CustomerOrderRepositoryInterface
{
    public function getAllCustomerOrders()
    {
        return CustomerOrder::all();
    }

    public function createCustomerOrder(array $data)
    {
        return CustomerOrder::create($data);
    }

    public function updateCustomerOrder(int $id, array $data)
    {
        $order = CustomerOrder::findOrFail($id);
        $order->update($data);
        return $order;
    }

    public function createNewOrder(int $customerId, array $orders)
    {
        $gatePassNumber = $this->generateGatePassNumber();

        DB::transaction(function () use ($customerId, $orders, $gatePassNumber) {
            GatePass::create([
                'customer_id' => $customerId,
                'gate_pass_no' => $gatePassNumber,
                'gate_pass_date' => now(),
            ]);

            foreach ($orders as $order) {
                $item = Item::find($order['item_id']);
                $customer = Customer::find($customerId);

                $realCost = $item->real_item_cost * $order['item_quantity'];
                $fakeCost = $order['item_quantity'] * $order['set_price'];
                $profit = $fakeCost - $realCost;

                $item->update([
                    'total_quantity' => $item->total_quantity - $order['item_quantity'],
                    'total_amount' => $item->total_amount - $realCost,
                ]);

                $customer->update([
                    'total_bill' => $customer->total_bill + $fakeCost,
                    'pending_payment' => $customer->pending_payment + $fakeCost,
                    'profit_from_customer' => $customer->profit_from_customer + $profit,
                ]);

                CustomerOrder::create(array_merge($order, [
                    'gate_pass_number' => $gatePassNumber,
                    'profit' => $profit,
                    'item_name' => $item->item_name,
                ]));
            }
        });

        return $orders;
    }

    public function getItemProfit()
    {
        $items = Item::all();
        $profits = [];

        foreach ($items as $item) {
            $totalProfit = CustomerOrder::where('item_id', $item->id)->sum('profit');
            $profits[] = [
                'item_id' => $item->id,
                'profit' => $totalProfit,
            ];
        }

        return $profits;
    }

    private function generateGatePassNumber()
    {
        return rand(100000, 999999) . now()->timestamp;
    }
}