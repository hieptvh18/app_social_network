<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\Admin\CustomerFeedbackAdminController;
use Modules\Core\Http\Controllers\BlogController;
use Modules\Core\Http\Controllers\CustomerFeedbackPublicController;
use Modules\Core\Http\Controllers\UploadController;
use Modules\Core\Http\Controllers\ContactController;
use Modules\Core\Http\Controllers\UserPlanController;
use Modules\Core\Http\Controllers\PromotionController;
use Modules\Core\Http\Controllers\Admin\PlanController;
use Modules\Core\Http\Controllers\PublicPlanController;
use Modules\Core\Http\Controllers\ActivityLogController;
use Modules\Core\Http\Controllers\FaqCategoryController;
use Modules\Core\Http\Controllers\HistoryGiftController;
use Modules\Core\Http\Controllers\MissionGiftController;
use Modules\Core\Http\Controllers\UserMissionController;
use Modules\Core\Http\Controllers\Admin\FaqAdminController;
use Modules\Core\Http\Controllers\Admin\BlogAdminController;
use Modules\Core\Http\Controllers\Admin\AdminCacheController;
use Modules\Core\Http\Controllers\Admin\PlanFeatureController;
use Modules\Core\Http\Controllers\Admin\BlogTagAdminController;
use Modules\Core\Http\Controllers\Admin\ContactAdminController;
use Modules\Core\Http\Controllers\Admin\FaqCategoryAdminController;
use Modules\Core\Http\Controllers\Admin\InfoMissionAdminController;
use Modules\Core\Http\Controllers\Admin\MissionGiftAdminController;
use Modules\Core\Http\Controllers\Admin\UploadImageAdminController;
use Modules\Core\Http\Controllers\Admin\UserMissionAdminController;
use Modules\Core\Http\Controllers\Admin\BlogCategoryAdminController;
use Modules\Core\Http\Controllers\Admin\AdminPlanSubscriptionController;
use Modules\Core\Http\Controllers\Admin\BizappAdminController;
use Modules\Core\Http\Controllers\Admin\NotificationEmailTemplateAdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'prefix' => 'v1',
], function () {

    Route::group(['prefix' => 'public'], function () {
        Route::controller(FaqCategoryController::class)->group(function () {
            Route::get('faq-categories', 'index')->name('core.faq-category.index');
            Route::get('faq-categories/{id}/faqs', 'faqByCate')->name('core.faq-category.faqByCate');
        });
        Route::controller(PublicPlanController::class)->group(function () {
            Route::get('plans', 'index')->name('core.public-plan.index');
        });
        Route::controller(ContactController::class)->group(function () {
            Route::post('contacts', 'store')->name('core.send-contact.store');
        });
        Route::controller(BlogController::class)->group(function () {
            Route::get('featured-blog', 'getListFeatured')->name('core.getListFeatured');
            Route::get('category-blogs', 'categoryBlogHomepage')->name('core.categoryBlogHomepage');
            Route::get('most-view-blogs', 'mostViewBlogs')->name('core.mostViewBlogs');
            Route::get('blogs/meta-seo/{alias}', 'getBlogMetaSeo')->name('core.getBlogMetaSeo');
            Route::get('blogs/{alias}', 'showBlogByAlias')->name('core.showBlogByAlias');
            Route::get('blogs', 'blogByCategory')->name('core.blogByCategory');
            Route::get('categories/{alias}', 'blogCategoryByAlias')->name('core.blogCategoryByAlias');
            Route::get('related-blogs/{blog_id}', 'replatedBlogs')->name('core.replatedBlogs');
        });

        Route::controller(MissionGiftController::class)->group(function () {

            Route::get('mission-gifts', 'index')->name('mission-gifts-public.index');
        });

        Route::controller(PromotionController::class)->group(function () {

            Route::get('promotions', 'getListPromotion')->name('promotions.getListPromotion');

            Route::get('promotions/{item}', 'showPromotion')->name('promotions.showPromotion');
        });

        Route::controller(CustomerFeedbackPublicController::class)->group(function () {
            Route::get('customer-feedbacks', 'index')->name('customer-feedback-public.index');
        });
    });

    Route::group([
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::controller(UploadController::class)->group(function () {
            Route::post('upload', 'uploadFile')->name('core.uploadFile');
        });

        Route::group([
            'prefix' => 'user'
        ], function () {
            Route::controller(PublicPlanController::class)->group(function () {
                Route::post('register-plan', 'registerPlan')->name('core.registerPlan');
            });
            Route::controller(UserPlanController::class)->group(function () {
                Route::get('current-plan', 'currentPlan')->name('core.currentPlan');
            });

            Route::controller(UserMissionController::class)->group(function () {
                Route::get('my-points', 'getMyPoint')->name('core.user-missions.getMyPoint');
                Route::get('my-info-missions', 'index')->name('core.user-missions.index');

                Route::post('report-mission', 'reportMission')->name('core.user-missions.reportMission');
            });

            Route::controller(MissionGiftController::class)->group(function () {
                Route::post('gift-exchange', 'giftExchange')->name('core.user-gift-exchange.giftExchange');

            });

            Route::controller(HistoryGiftController::class)->group(function () {
                Route::get('history-gifts', 'index')->name('core.user-history-gift.index');

                // Route::post('history-gifts', 'store')->name('core.user-history-gift.store');
            });

            Route::controller(PromotionController::class)->group(function () {

                Route::get('promotions/{item}/join', 'joinPromotion')->name('user.promotions.joinPromotion');
            });
        });

        // For admin crm
        Route::group([
            'prefix' => 'admin',
            'middleware' => 'crm'
        ], function () {
            Route::apiResource('plans', PlanController::class);
            Route::apiResource('plan-features', PlanFeatureController::class);

            Route::controller(FaqAdminController::class)->group(function () {
                Route::get('faqs', 'index')->name('core.faq.index');
                Route::get('faqs/{id}', 'show')->name('core.faq.show');
                Route::post('faqs', 'store')->name('core.faq.store');
                Route::put('faqs/{id}', 'update')->name('core.faq.update');
                Route::delete('faqs/{id}', 'destroy')->name('core.faq.destroy');
            });

            Route::controller(FaqCategoryAdminController::class)->group(function () {
                Route::get('faq-categories', 'index')->name('core.admin.faq-category.index');
                Route::get('faq-categories/{id}', 'show')->name('core.faq-category.show');
                Route::post('faq-categories', 'store')->name('core.faq-category.store');
                Route::put('faq-categories/{id}', 'update')->name('core.faq-category.update');
                Route::delete('faq-categories/{id}', 'destroy')->name('core.faq-category.destroy');
            });

            Route::controller(ActivityLogController::class)->group(function () {
                Route::get('activity-logs', 'getListByAdmin')->name('core.activity-logs.getListByAdmin');
            });

            Route::controller(ContactAdminController::class)->group(function () {
                Route::get('contacts', 'index')->name('core.contact.index');
                Route::get('contacts/{id}', 'show')->name('core.contact.show');
                Route::put('contacts/{id}', 'update')->name('core.contact.update');
                Route::delete('contacts/{id}', 'destroy')->name('core.contact.destroy');
            });

            Route::controller(ContactAdminController::class)->group(function () {
                Route::put('contacts/{id}', 'update')->name('core.contact.update');
            });

            Route::controller(BlogCategoryAdminController::class)->group(function () {
                Route::get('blog-categories', 'index')->name('core.blog-category.index');
                Route::get('blog-categories/{id}', 'show')->name('core.blog-category.show');
                Route::post('blog-categories', 'store')->name('core.blog-category.store');
                Route::put('blog-categories/{id}', 'update')->name('core.blog-category.update');
                Route::delete('blog-categories/{id}', 'destroy')->name('core.blog-category.destroy');
            });

            Route::controller(BlogTagAdminController::class)->group(function () {
                Route::get('blog-tags', 'index')->name('core.blog-tag.index');
                Route::get('blog-tags/{id}', 'show')->name('core.blog-tag.show');
                Route::post('blog-tags', 'store')->name('core.blog-tag.store');
                Route::put('blog-tags/{id}', 'update')->name('core.blog-tag.update');
                Route::delete('blog-tags/{id}', 'destroy')->name('core.blog-tag.destroy');
            });

            Route::controller(BlogAdminController::class)->group(function () {
                Route::get('blogs', 'index')->name('core.blog.index');
                Route::get('blogs/{id}', 'show')->name('core.blog.show');
                Route::post('blogs', 'store')->name('core.blog.store');
                Route::put('blogs/{id}', 'update')->name('core.blog.update');
                Route::delete('blogs/{id}', 'destroy')->name('core.blog.destroy');
            });

            Route::controller(UploadImageAdminController::class)->group(function () {
                Route::post('upload-image', 'uploadImage')->name('core.uploadImage');
            });

            Route::controller(InfoMissionAdminController::class)->group(function () {
                Route::get('info-missions', 'index')->name('core.info-missions.index');
                Route::get('info-missions/{id}', 'show')->name('core.info-missions.show');
                Route::post('info-missions', 'store')->name('core.info-missions.store');
                Route::put('info-missions/{id}', 'update')->name('core.info-missions.update');
                Route::delete('info-missions/{id}', 'destroy')->name('core.info-missions.destroy');
            });

            Route::controller(UserMissionAdminController::class)->group(function () {
                Route::get('user-missions', 'index')->name('core.admin.user-missions.index');

                Route::post('approve-mission', 'approveMission')->name('core.user-missions.approveMission');

                Route::post('refused-approve-mission', 'refusedApproveMission')->name('core.user-missions.refusedApproveMission');
            });

            Route::controller(MissionGiftAdminController::class)->group(function () {
                Route::get('mission-gifts/histories', 'histories')->name('core.mission-gifts.histories');
                Route::get('mission-gifts/history-receive-gifts', 'promotionGiftHistories')->name('core.mission-gifts.promotionGiftHistories');
                Route::put('mission-gifts/histories/{id}/change-status', 'changeStatusHistoryGift')->name('core.mission-gifts.changeStatusHistoryGift');
                Route::get('mission-gifts', 'index')->name('core.mission-gifts.index');
                Route::get('mission-gifts/{id}', 'show')->name('core.mission-gifts.show');
                Route::post('mission-gifts', 'store')->name('core.mission-gifts.store');
                Route::put('mission-gifts/{id}', 'update')->name('core.mission-gifts.update');
                Route::delete('mission-gifts/{id}', 'destroy')->name('core.mission-gifts.destroy');



            });

            Route::controller(AdminPlanSubscriptionController::class)->group(function () {
                Route::post('active-plan-subscription', 'ActivePlanSubscriptionByAdmin')->name('core.ActivePlanSubscriptionByAdmin');
            });

            Route::controller(AdminCacheController::class)->prefix('cache')->group(function () {
                Route::get('flush', 'flush')->name('admin.cache.flush');

                Route::get('cache-options', 'cacheOptions')->name('admin.cache.cacheOptions');

                Route::post('clear-cache-by-option', 'clearCacheByOption')->name('admin.cache.clearCacheByOption');
            });

            Route::controller(CustomerFeedbackAdminController::class)->group(function () {
                Route::get('customer-feedbacks', 'index')->name('admin.customer-feedback.index');
                Route::post('customer-feedbacks', 'store')->name('admin.customer-feedback.store');
                Route::get('customer-feedbacks/{id}', 'show')->name('admin.customer-feedback.show');
                Route::put('customer-feedbacks/{id}', 'update')->name('admin.customer-feedback.update');
                Route::delete('customer-feedbacks/{id}', 'destroy')->name('admin.customer-feedback.destroy');
            });

            Route::controller(BizappAdminController::class)->group(function () {
                Route::get('bizapps', 'index')->name('core.bizapps.index');
                Route::get('bizapps/{id}', 'show')->name('core.bizapps.show');
                Route::post('bizapps', 'store')->name('core.bizapps.store');
                Route::put('bizapps/{id}', 'update')->name('core.bizapps.update');
                Route::delete('bizapps/{id}', 'destroy')->name('core.bizapps.destroy');
            });
        });
    });
});
