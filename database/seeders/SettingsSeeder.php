<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            'company_name'              => 'COINPEL',
            'company_cnpj'              => '00.000.000/0001-00',
            'company_email'             => 'contato@coinpel.com',
            'company_phone'             => '(53) 3000-0000',
            'company_address'           => 'Pelotas, RS',
            'allow_booking'             => 'true',
            'require_driver_assignment' => 'true',
            'notify_on_new_trip'        => 'false',
            'maintenance_mode'          => 'false',
        ];

        foreach ($defaults as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
