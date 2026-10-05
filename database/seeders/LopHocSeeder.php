<?php
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\LopHoc;

 class LopHocSeeder extends Seeder
 {
    public function run(): void
    {
        LopHoc::factory() ->count(10) ->create();
    }
 }
 