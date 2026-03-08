<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $settings = [
        // بيانات التواصل
        ['key' => 'address', 'value' => 'شارع التحرير، القاهرة، مصر', 'group' => 'contact'],
        ['key' => 'phone_1', 'value' => '0123456789', 'group' => 'contact'],
        ['key' => 'phone_2', 'value' => '0109876543', 'group' => 'contact'],
        ['key' => 'email_info', 'value' => 'info@restaurant.com', 'group' => 'contact'],
        
        // ساعات العمل
        ['key' => 'work_hours_week', 'value' => 'السبت - الخميس: 10 ص - 12 م', 'group' => 'contact'],
        ['key' => 'work_hours_friday', 'value' => 'الجمعة: 2 م - 12 م', 'group' => 'contact'],

        // التواصل الاجتماعي
        ['key' => 'facebook_url', 'value' => '#', 'group' => 'social'],
        ['key' => 'instagram_url', 'value' => '#', 'group' => 'social'],
        ['key' => 'whatsapp_num', 'value' => '20123456789', 'group' => 'social'],

        // الخريطة
        ['key' => 'google_map_iframe', 'value' => '', 'group' => 'maps'],
    ];
    }
}
