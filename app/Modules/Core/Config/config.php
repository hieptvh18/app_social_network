<?php

return [
    'name' => 'Core',
    // Subscriptions Database Tables
    'tables' => [

        'plans' => 'core_plans',
        'plan_features' => 'core_plan_features',
        'plan_subscriptions' => 'core_plan_subscriptions',
        'plan_subscription_usage' => 'core_plan_subscription_usage',

    ],

    'cache_group_key' => [
        'exam' => [
            'label' => 'Đề thi',
            'class' => [
                Modules\Quiz\Services\Homepage\ExamPublicService::class,

            ]
        ],
        'document' => [
            'label' => 'Tài liệu',
            'class' => [
                Modules\Quiz\Services\Homepage\DocumentPublicService::class
            ]
        ],
        'master_data' => [
            'label' => 'Master Data',
            'class' => [
                Modules\Quiz\Services\Homepage\MasterDataService::class,
                Modules\Quiz\Http\Controllers\Homepage\ExamPublicController::class,
                Modules\Quiz\Http\Controllers\Homepage\ExamChanelPublicController::class
            ]
        ],
        'banner' => [
            'label' => 'Banner',
            'class' => [
                Modules\Affiliate\Services\BannerPositionService::class
            ]
        ],
        'ranking' => [
            'label' => 'Bảng xếp hạng',
            'class' => [
                Modules\Quiz\Services\Homepage\RankingService::class
            ]
        ],
        'ebook' => [
            'label' => 'Sách điện tử',
            'class' => [
                Modules\Book\Services\EbookPublicService::class,
                Modules\Book\Services\EbookSetPublicService::class
            ]
        ],
        'all_cache' => [
            'label' => 'Tất Cả',
            'class' => [
                Modules\Quiz\Services\Homepage\ExamPublicService::class,
                Modules\Quiz\Services\Homepage\DocumentPublicService::class,
                Modules\Quiz\Services\Homepage\MasterDataService::class,
                Modules\Affiliate\Services\BannerPositionService::class,
                Modules\Quiz\Services\Homepage\RankingService::class,
                Modules\Quiz\Http\Controllers\Homepage\ExamPublicController::class,
                Modules\Quiz\Http\Controllers\Homepage\ExamChanelPublicController::class,
                Modules\Book\Services\EbookPublicService::class,
                Modules\Book\Services\EbookSetPublicService::class
            ]
        ]

    ]
];
