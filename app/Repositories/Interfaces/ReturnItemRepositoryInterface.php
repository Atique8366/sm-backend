<?
namespace App\Repositories\Interfaces;

use App\Models\ReturnItem;

interface ReturnItemRepositoryInterface
{
    public function getAllReturnItems();
    public function getReturnItemById($id);
    public function createReturnItem(array $data);
    public function updateReturnItem($id, array $data);
}