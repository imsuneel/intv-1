<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $now = date('Y-m-d H:i:s');
        \DB::table('products')->insert([
            ['name' => 'Book',
            'quantity'=>'999999',
            'price'=>'9999.0000',
            'status'=>1,
            'created_at' => $now,
            'updated_at' => $now,
        ],
        ['name' => 'Phone',
            'quantity'=>'999999',
            'price'=>'99999.0000',
            'status'=>1,
            'created_at' => $now,
            'updated_at' => $now,
            ]
        ]);
    }
}
