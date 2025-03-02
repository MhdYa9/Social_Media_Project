<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateUser
{
    use AsAction;

    public function rules() : array
    {
        return [
            'name' => 'required|min:3|max:255',
            'username' => 'required|unique:users,username|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|max:255',
            'profile_image' => 'sometimes|image',
            'cover_image' => 'sometimes|image',
            'birthday' => 'sometimes|date'
        ];
    }


    public function handle(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        if(isset($data['profile_image'])) $data['profile_image'] = $data['profile_image']->store('images', 'public');
        if(isset($data['cover_image'])) $data['cover_image'] = $data['cover_image']->store('images', 'public');

        $user = User::create($data);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }

    public function asController(ActionRequest $request)
    {
        return $this->handle($request->validated());
    }
}
