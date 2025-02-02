<?
namespace App\Repositories;

use App\Models\GatePass;
use App\Repositories\Interfaces\GatePassRepositoryInterface;

class GatePassRepository implements GatePassRepositoryInterface
{
    public function getAllGatePasses()
    {
        return GatePass::all();
    }

    public function getGatePassById($id)
    {
        return GatePass::findOrFail($id);
    }

    public function createGatePass(array $data)
    {
        return GatePass::create($data);
    }

    public function updateGatePass($id, array $data)
    {
        $gatePass = GatePass::findOrFail($id);
        $gatePass->update($data);
        return $gatePass;
    }
}