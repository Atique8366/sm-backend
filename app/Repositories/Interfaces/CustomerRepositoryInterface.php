<?

namespace App\Repositories\Interfaces;

use App\Models\Customer;

interface CustomerRepositoryInterface
{
    public function getAllCustomers();
    public function getCustomerById($id);
    public function createCustomer(array $data);
    public function updateCustomer($id, array $data);
    public function receivePayment(array $data);
    public function getAllPayments();
    public function getPaymentsByCustomerId($customerId);
}