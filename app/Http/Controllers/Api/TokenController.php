<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * @OA\Get(
     * path="/token",
     * summary="Get token",
     * description="Get token",
     * operationId="getToken",
     * tags={"TOKEN"},
     * @OA\Response(
     *    response=200,
     *    description="Bearer Token",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean",
     *                    description="Operation status", example="true"),
     *       @OA\Property(property="token", type="string",
     *                    description="Token", example="9|VGRydIOV9tmF0BPwDAl1FHolXLsh9CmuvvmP2rYb"),
     *     )
     * ),
     *
     *     )
     * )
     */
    public function token()
    {
        $user = User::where('is_admin', 1)->first();
        $user->tokens()->delete();
        $token = $user->createToken('create user token');

        return response()->json([
            'success' => true,
            'token' => $token->plainTextToken
        ]);
    }
}
