<?php

use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('order_status')->insert([
            [   'id'=>1,
                'name' => 'Processed',
                'status'=>1,
            ],
            [   'id'=>2,
                'name' => 'Delivered',
                'status'=>1,
            ],
            [   'id'=>3,
                'name' => 'Canceled',
                'status'=>1,
            ],
        ]);
    }
}
