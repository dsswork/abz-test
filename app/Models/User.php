<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'position_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function createNew(StoreUserRequest $request)
    {
        $fields = $request->validated();
        if($request->file('photo')) {
            $image = $request->file('photo');
            $filename = rand(111111, 999999).'.'.$image->getClientOriginalExtension();
            $folder = "images";
            Storage::disk('public')->putFileAs($folder, $image, $filename);
            $fields['photo'] = asset("storage/$folder/$filename");
        }

        $user = User::create($fields);

        \Tinify\setKey("TP7G8sTs2864Rnbb7H50fpJwYQsR5j3G");
        $source = \Tinify\fromFile(storage_path("app/public/$folder/$filename"));
        $resized = $source->resize(array(
            "method" => "fit",
            "width" => 70,
            "height" => 70
        ));
        $resized->toFile(storage_path("app/public/$folder/$filename"));

        return $user;
    }
}
