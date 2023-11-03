<?php

namespace Modules\Core\Services\Admin;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Repositories\BizappRepository;

class BizappAdminService extends BaseService
{
    public function __construct(BizappRepository $bizappRepository)
    {
        $this->baseRepository = $bizappRepository;
    }

    public function create(Request $request)
    {
        $images_tmp = Storage::disk('s3')->allFiles('bizapp_tmp');
        $image = '';
        foreach ($images_tmp as $image_tmp) {
            if ($request->logo === $image_tmp) {
                $image = $image_tmp;
            }
        }

        $logo = str_replace('bizapp_tmp', 'bizapp', $image);
        DB::beginTransaction();
        $data = $request->all();
        $data['logo'] = $logo;
        $item = $this->baseRepository->create($data);

        DB::commit();
        if ($image) {
            Storage::disk('s3')->move($image, $logo);
        }

        Storage::disk('s3')->deleteDirectory('bizapp_tmp');

        return $item;
    }

    public function update(Request $request, $id)
    {
        try {
            if (in_array('update', $this->allowPolicies)) {
                $this->authorize('update', $id);
            }

            $images_tmp = Storage::disk('s3')->allFiles('bizapp_tmp');
            $image = '';
            foreach ($images_tmp as $image_tmp) {

                if ($request->logo === $image_tmp) {
                    $image = $image_tmp;
                    $logo = str_replace('bizapp_tmp', 'bizapp', $image);
                    Storage::disk('s3')->move($image, $logo);
                    Storage::disk('s3')->delete($image);
                }
            }
            if (!$image) {
                $logo = $request->logo;
            }

            DB::beginTransaction();
            $data = $request->all();
            $data['logo'] = $logo;
            $item = $this->baseRepository->update($data, $id);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
