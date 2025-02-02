<?

namespace App\Repositories\Interfaces;

use App\Models\GatePass;

interface GatePassRepositoryInterface
{
    public function getAllGatePasses();
    public function getGatePassById($id);
    public function createGatePass(array $data);
    public function updateGatePass($id, array $data);
}