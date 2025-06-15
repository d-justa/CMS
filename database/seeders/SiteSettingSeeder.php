<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
          'site_title' => 'CMS',
          'site_tag_line' => 'Your creativity made live'  
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate([
                'key' => $key,
                'value' => $value
            ]);
        }
    }
}
