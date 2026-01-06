<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Shift;
use App\Models\Instansi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'), // default password
            'instansi' => Instansi::inRandomOrder()->value('nama_instansi'),
            'status' => fake()->randomElement(['PKL', 'KARYAWAN']),
            'mode_kerja' => fake()->randomElement(['WFO', 'WFH']),
            'shift_id' => Shift::inRandomOrder()->value('id'), // penting untuk FK
        ];
    }
}
