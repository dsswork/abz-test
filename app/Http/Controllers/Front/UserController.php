<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->where('is_admin', 0)->with('position')->simplePaginate(6);
        return view('users.index', compact(['users']));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $fields = $request->validated();
        if($request->file('photo')) {
            $image = $request->file('photo');
            $filename = rand(111111, 999999).$image->getClientOriginalExtension();
            $folder = "images";
            Storage::disk('public')->putFileAs($folder, $image, $filename);
            $fields['photo'] = asset("storage/$folder/$filename");
        }

        User::create($fields);

        return to_route('users.index');
    }
}