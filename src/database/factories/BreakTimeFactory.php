<?php

namespace Database\Factories;

use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BreakTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $start = Carbon::today()->setTime(rand(12, 13), 0);
        $end = (clone $start)->addHours(rand(1, 2));

        return [
            'work_id' => Work::inRandomOrder()->First()->id,
            'start' => $start,
            'end' => $end,
        ];
    }
}
