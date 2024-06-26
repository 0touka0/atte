<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = Carbon::today()->setTime(rand(9, 10), 0);
        $end = (clone $start)->addHours(rand(7, 8));

        return [
            'user_id' => User::inRandomOrder()->First()->id,
            'start' => $start,
            'end' => $end,
        ];
    }
}
