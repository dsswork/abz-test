<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\GetUsersRequest;
use App\Http\Requests\Api\User\UserIdRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * @OA\Get(
     * path="/users",
     * summary="Get all users",
     * description="Get all users",
     * operationId="getAllUsers",
     * tags={"USERS"},
     * @OA\Parameter (description="Specify the page that you want to retrieve", in="query", name="page",
     *                required=false, example="1"),
     * @OA\Parameter (description="Specify the missing record number", in="query", name="offset",
     *                required=false, example="0"),
     * @OA\Parameter (description="Specify the amount of items that will be retrieved per page", in="query", name="count",
     *                required=false, example="5"),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function index(GetUsersRequest $request)
    {
        $count = $request->count;
        $page = $request->page;
        $requestOffset = $request->offset;

        $offset = $requestOffset ?: $count * ($page - 1);

        $users = User::with('position')
            ->where('is_admin', 0)
            ->limit($count)
            ->offset($offset)
            ->get();

        $totalUsers = User::count();
        $totalPages = ceil($totalUsers / $count);

        if ($users->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Users not found'], 422);
        }

        $userCollection = UserCollection::make($users);

        $link = url()->current();

        if ($page == $totalPages) {
            $next = null;
        } else {
            $next = $link . '&page=' . ($page + 1) . '&count=' . $count . '&offset=' . $requestOffset;
        }

        if ($page == 1) {
            $prev = null;
        } else {
            $prev = $link . '&page=' . ($page - 1) . '&count=' . $count . '&offset=' . $requestOffset;
        }

        return [
                'success' => true,
                'page' => (int)$request->page,
                'total_pages' => $totalPages,
                'total_users' => $totalUsers,
                'count' => (int)$request->count,
                'links' => [
                    'next_url' => $next,
                    'prev_url' => $prev
                ]
            ] + json_decode($userCollection->toJson(), true);
    }


    /**
     * @OA\Post(
     * path="/users",
     * summary="Add new user",
     * description="Add new user",
     * operationId="addNewUser",
     * tags={"USERS"},
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(type="object",
     *               @OA\Property(property="photo", type="array",
     *                  @OA\Items(type="string", format="binary"),
     *               ),
     *       @OA\Property(property="name", type="string",
     *                    description="User's Name", example="Vasya"),
     *       @OA\Property(property="phone", type="string",
     *                    description="User's phone", example="+380671234567"),
     *       @OA\Property(property="email", type="string",
     *                    description="User's email", example="vasiliev@gmail.com"),
     *       @OA\Property(property="position_id", type="integer",
     *                    description="Position ID", example="2"),
     *
     *          )
     *       )
     *   ),
     * @OA\Response(
     *    response=200,
     *    description="Profile info",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean",
     *                    description="Operation status", example="true"),
     *       @OA\Property(property="user_id", type="integer",
     *                    description="User's id", example="46"),
     *       @OA\Property(property="message", type="string",
     *                    description="Success message", example="New user successfully registered"),
     *     )
     *  ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated."),
     *    )
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function store(StoreUserRequest $request)
    {

        $fields = $request->validated();
        if ($request->file('photo')) {
            $image = $request->file('photo');
            $filename = rand(111111, 999999) . $image->getClientOriginalExtension();
            $folder = "images";
            Storage::disk('public')->putFileAs($folder, $image, $filename);
            $fields['photo'] = asset("storage/$folder/$filename");
        }

        $user = User::create($fields);

        $responce = Http::withHeaders([
            'Authorization' => 'Basic TP7G8sTs2864Rnbb7H50fpJwYQsR5j3G',
            'Content-Type' => 'application/json'
        ])->post('api.tinify.com', [
            'source' => [
                'url' => $fields['photo']
            ],
        ]);

        dd($responce);



//        User::where('is_admin', 1)->first()->tokens()->delete();

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'message' => 'New user successfully registered'
        ]);
    }

    /**
     * @OA\Get(
     * path="/users/{id}",
     * summary="Get user info by ID",
     * description="Get user info by ID",
     * operationId="getUserInfo",
     * tags={"USERS"},
     * @OA\Parameter (description="User ID", in="path", name="id",
     *                 required=true, example="1"),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */

    public function show(UserIdRequest $request)
    {
        $user = User::find($request->id);
        return [
            'success' => true,
            'user' => UserResource::make($user)
        ];
    }

}
