<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PositionCollection;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * @OA\Get(
     * path="/positions",
     * summary="Get all positions",
     * description="Get all positions",
     * operationId="getAllPositions",
     * tags={"POSITIONS"},
     * @OA\Response(
     *    response=200,
     *    description="Show all positions",
     *    @OA\JsonContent(
     *     @OA\Property(property="success", type="strind", example="true"),
     *     @OA\Property(property="positions", type="object", collectionFormat="multi",
     *       @OA\Property(property="id", type="number", description="Position ID", example="1"),
     *       @OA\Property(property="name", type="string", description="Position name", example="Developer"),
     *      ),
     *    ),
     *  ),
     * @OA\Response(
     *    response=422,
     *    description="Positions not found",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="Positions not found")
     *       )
     *    )
     * )
     */
    public function index ()
    {
        $positions = Position::all();
        if($positions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Positions not found'], 422);
        }

        return PositionCollection::make($positions);
    }
}
