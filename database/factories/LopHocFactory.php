<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LopHocFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Các cột cũ giữ nguyên
            'ma_lop'     => fake()->unique()->bothify('??###'),
            'ten_lop'    => 'Lớp ' . fake()->words(2, true),
            'giao_vien'  => fake()->name(),
            'si_so'      => fake()->numberBetween(30, 80),
            
            // BỔ SUNG 3 CỘT NÀY ĐỂ TRÁNH LỖI NOT NULL
            'sdt_gvcn'   => fake()->numerify('09########'), 
            'ghi_chu'    => fake()->realText(30), 
            'trang_thai' => fake()->randomElement(['Hoạt động', 'Không hoạt động']),
        ];
    }
}