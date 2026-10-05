<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
  {
        \Illuminate\Support\Facades\DB::table('lop_hocs')->updateOrInsert(
            ['id' => 1],
            [
                'ten_lop'    => '68PM2',
                'ma_lop'     => '68PM2',
                'giao_vien'  => 'Thầy Nguyễn Văn A',
                'si_so'      => 60,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
