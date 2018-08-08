<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Payment_methodsTableSeeder::class);
        $this->call(Quality_typesTableSeeder::class);
        $this->call(Role_typesTableSeeder::class);
        $this->call(Subscription_typesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(QualitiesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(GiftsTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(Template_mailsTableSeeder::class);
        $this->call(Template_newslettersTableSeeder::class);
    }
}
