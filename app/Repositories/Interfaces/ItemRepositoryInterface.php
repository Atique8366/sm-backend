<?
namespace App\Repositories\Interfaces;

use App\Models\Item;

interface ItemRepositoryInterface
{
    // public function getAllItems();
    // public function getItemById($id);
    // public function createItem(array $data);
    // public function updateItem($id, array $data);
    // public function stockWithDate(StockWithDateRequest $request);
    // public function addStock($id, array $data);
    public function getAllItems();
    public function getItemById($id);
    public function createItem(array $data);
    public function updateItem($id, array $data);
    public function stockWithDate(array $dates);
    public function stockAdd(array $data);
}