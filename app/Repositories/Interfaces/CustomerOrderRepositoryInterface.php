<?

namespace App\Repositories\Interfaces;

use App\Models\CustomerOrder;

interface CustomerOrderRepositoryInterface
{
    public function getAllCustomerOrders();
    public function createCustomerOrder(array $data);
    public function updateCustomerOrder(int $id, array $data);
    public function createNewOrder(int $customerId, array $orders);
    public function getItemProfit();
}