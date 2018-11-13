<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('phonebooks')->truncate();

        factory(App\Phonebook::class, 25)->create();
    }
}
