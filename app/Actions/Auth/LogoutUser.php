<?php

namespace App\Actions\Auth;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class LogoutUser
{
    use AsAction;

    public function handle(ActionRequest $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
