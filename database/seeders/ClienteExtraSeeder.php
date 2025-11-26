<?php

namespace Database\Seeders;

use App\Models\ClienteExtra;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienteExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClienteExtra::factory(5)->create();
    }
}
