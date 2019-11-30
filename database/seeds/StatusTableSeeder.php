<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('status')->get()->count() == 0){
            DB::table('status')->insert([
                ['name' => 'booked'],
                ['name' => 'paid'],
                ['name' => 'cancelled'],
            ]);
        }
    }
}
