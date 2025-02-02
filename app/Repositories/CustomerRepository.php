<?
namespace App\Repositories;

use App\Models\Customer;
use App\Models\PayementRecord;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function getCustomerById($id)
    {
        return Customer::findOrFail($id);
    }

    public function createCustomer(array $data)
    {
        return Customer::create($data);
    }

    public function updateCustomer($id, array $data)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        return $customer;
    }

    public function receivePayment(array $data)
    {
        $customer = Customer::findOrFail($data['id']);
        $totalPay = $data['payment_rcv'] + $data['discount'];

        $customer->update([
            'payment_rcv' => $customer->payment_rcv + $data['payment_rcv'],
            'pending_payment' => $customer->pending_payment - $totalPay,
            'discount' => $customer->discount + $data['discount'],
            'profit_from_customer' => $customer->profit_from_customer - $data['discount'],
        ]);

        PayementRecord::create([
            'customer_id' => $data['id'],
            'payement_date' => now(),
            'payement_rcv' => $data['payment_rcv'],
            'discount' => $data['discount'],
            'pending_amount' => $customer->pending_payment,
        ]);

        return $customer;
    }

    public function getAllPayments()
    {
        return PayementRecord::all();
    }

    public function getPaymentsByCustomerId($customerId)
    {
        return PayementRecord::where('customer_id', $customerId)->get();
    }
}