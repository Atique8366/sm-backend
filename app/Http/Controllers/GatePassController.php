<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\GatePassRepositoryInterface;
use Illuminate\Http\Request;

class GatePassController extends Controller
{
    private $gatePassRepository;

    public function __construct(GatePassRepositoryInterface $gatePassRepository)
    {
        $this->gatePassRepository = $gatePassRepository;
    }


    public function index()
    {
        return response()->json($this->gatePassRepository->getAllGatePasses());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|integer',
            'gate_pass_date' => 'nullable|string',
            'gate_pass_no' => 'nullable|string',
        ]);

        return response()->json($this->gatePassRepository->createGatePass($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'gate_pass_date' => 'nullable|string',
            'gate_pass_no' => 'nullable|string',
        ]);

        return response()->json($this->gatePassRepository->updateGatePass($id, $data));
    }

}
