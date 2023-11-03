<?php

namespace Modules\Core\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Repositories\InfoMissionRepository;

class InfoMissionAdminService extends BaseService
{

    public function __construct(InfoMissionRepository $infoMissionRepository)
    {
        $this->baseRepository = $infoMissionRepository;
    }

    public function create(Request $request)
    {
        try {
            $image_avatar_promotions_tmp = Storage::disk('s3')->allFiles('promotion_avatar_tmp');
            $image_url = '';
            foreach ($image_avatar_promotions_tmp as $image_avatar_promotion_tmp) {
                if ($request->image_url === $image_avatar_promotion_tmp) {
                    $image_url = str_replace('promotion_avatar_tmp', 'promotion_avatar', $image_avatar_promotion_tmp);
                    Storage::disk('s3')->move($image_avatar_promotion_tmp, $image_url);
                    Storage::disk('s3')->deleteDirectory('promotion_avatar_tmp');
                }
            }
            $image_banner_promotions_tmp = Storage::disk('s3')->allFiles('promotion_banner_tmp');
            $banner_url = '';
            foreach ($image_banner_promotions_tmp as $image_banner_promotion_tmp) {
                if ($request->banner_url === $image_banner_promotion_tmp) {
                    $banner_url = str_replace('promotion_banner_tmp', 'promotion_banner', $image_banner_promotion_tmp);
                    Storage::disk('s3')->move($image_banner_promotion_tmp, $banner_url);
                    Storage::disk('s3')->deleteDirectory('promotion_banner_tmp');
                }
            }
            DB::beginTransaction();
            $data = $request->all();
            $data['image_url'] = $image_url;
            $data['banner_url'] = $banner_url;
            $item = $this->baseRepository->create($data);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        try {

            if (in_array('update', $this->allowPolicies)) {
                $this->authorize('update', $id);
            }

            DB::beginTransaction();
            $data = $request->all();

            if ($request->assign_user_type == 'PROMOTION') {
                $images_avatar_tmp = Storage::disk('s3')->allFiles('promotion_avatar_tmp');
                $image_url = '';
                foreach ($images_avatar_tmp as $image_avatar_tmp) {
                    if ($request->image_url === $image_avatar_tmp) {
                        $image_url = str_replace('promotion_avatar_tmp', 'promotion_avatar', $image_avatar_tmp);
                        Storage::disk('s3')->move($image_avatar_tmp, $image_url);
                        Storage::disk('s3')->deleteDirectory('promotion_avatar_tmp');
}
                }

                if (!$image_url) {
                    $image_url = $request->image_url;
                }

                $images_banner_tmp = Storage::disk('s3')->allFiles('promotion_banner_tmp');
                $banner_url = '';
                foreach ($images_banner_tmp as $image_banner_tmp) {
                    if ($request->banner_url === $image_banner_tmp) {
                        $banner_url = str_replace('promotion_banner_tmp', 'promotion_banner', $image_banner_tmp);
                        Storage::disk('s3')->move($image_banner_tmp, $banner_url);
                        Storage::disk('s3')->deleteDirectory('promotion_banner_tmp');
                    }
                }

                if (!$banner_url) {
                    $banner_url = $request->banner_url;
                }

                $data['image_url'] = $image_url;
                $data['banner_url'] = $banner_url;
            }
            $item = $this->baseRepository->update($data, $id);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
