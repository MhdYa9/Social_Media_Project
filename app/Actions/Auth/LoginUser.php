<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class LoginUser
{
    use AsAction;

    private $user;

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
    }

    public function withValidator(ActionRequest $request) : void
    {
        $user = User::where('email',$request->email)->first();
        if(!$user){
            throw ValidationException::withMessages([
                'email' => 'the provided credentials are incorrect'
            ]);
        }
        if(!Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => 'the provided credentials are not matching'
            ]);
        }

        $this->user = $user;
    }

    public function handle()
    {
        $user = $this->user;

        if(!$user->tokens->isEmpty()){
            $user->tokens()->delete();
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);

    }

    public function asController(ActionRequest $request)
    {
        return $this->handle();
    }
}
