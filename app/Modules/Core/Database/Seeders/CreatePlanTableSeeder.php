<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\Plan;
use Modules\Core\Models\PlanFeature;
use Modules\Order\Models\PaymentMethod;

class CreatePlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement("SET foreign_key_checks=0");
        PlanFeature::truncate();
        Plan::truncate();
        PaymentMethod::truncate();
        DB::statement("SET foreign_key_checks=1");

        $plan = Plan::create([
            'name' => 'VIP',
            'description' => 'Gói nâng cấp vip',
            'price' => 40000,
            'signup_fee' => 0,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 0,
            'trial_interval' => 'day',
            'sort_order' => 1,
            'currency' => 'VNĐ',
            'user_type' => 'STUDENT',
            'bizapp' => 'EDUQUIZ'

        ]);

        // Create multiple plan features at once
        $plan->features()->saveMany([
            new PlanFeature(['name' => 'download_exam', "description" => 'Download đề thi không giới hạn',  'value' => 'Y', 'sort_order' => 1]),
            new PlanFeature(['name' => 'download_document', "description" => 'Download tài liệu không giới hạn',  'value' => 'Y', 'sort_order' => 2]),

            // new PlanFeature(['name' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
            // new PlanFeature(['name' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            // new PlanFeature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);
        $methods = [
            [
                'name' => 'Momo',
                'alias' => 'momo',
                'logo' => 'https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-MoMo-Square.png',
                'qr_code' => asset('assets/img/qr_code/momo.jpg', true)
            ],
            [
                'name' => 'Zalo Pay',
                'alias' => 'zalo',
                'logo' => 'https://cdn.haitrieu.com/wp-content/uploads/2022/10/Logo-ZaloPay-Square.png',
                'qr_code' => asset('assets/img/qr_code/IMG_5898.jpg', true)
            ],
            [
                'name' => 'Chuyển khoản ngân hàng',
                'alias' => 'banking',
                'logo' => 'https://api-dev.eduquiz.vn/assets/icon/payment.png',
                'qr_code' => asset('assets/qr_code/IMG_5896.jpg', true)
            ]
        ];
        foreach ($methods as $item) {
            PaymentMethod::create($item);
        };
        // $this->call("OthersTableSeeder");
    }
}
