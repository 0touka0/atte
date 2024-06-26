<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input): User
    {
        // バリデーションを実行
        $validator = Validator::make($input, (new RegisterRequest())->rules());

        // バリデーション失敗時の処理
        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validated = $validator->validated();

        return User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    }
}
