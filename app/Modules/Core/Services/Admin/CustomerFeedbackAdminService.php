<?php

namespace Modules\Core\Services\Admin;
use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Repositories\Criteria\FilterBizappAlias;
use Modules\Core\Repositories\CustomerFeedbackRepository;


class CustomerFeedbackAdminService extends BaseService{

    public function __construct(CustomerFeedbackRepository $customerFeedbackRepository)
    {
        $this->baseRepository = $customerFeedbackRepository;
        $this->baseRepository->pushCriteria(app(FilterBizappAlias::class));
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->orderBy($this->sort, $this->dir);
        return $collection->paginate($this->limit);
    }

    public function create(Request $request)
    {
        try {
            $images_core_feedback_tmp = Storage::disk('s3')->allFiles('core_feedback_tmp');
            $image_url = '';
            foreach ($images_core_feedback_tmp as $image_core_feedback_tmp) {
                if ($request->image_url === $image_core_feedback_tmp) {
                    $image_url = str_replace('core_feedback_tmp', 'core_feedback', $image_core_feedback_tmp);
                    Storage::disk('s3')->move($image_core_feedback_tmp, $image_url);
                    Storage::disk('s3')->delete($image_core_feedback_tmp);
                }
                if (!$image_url) {
                    $image_url = $request->image_url;
                } 
                DB::beginTransaction();
                $data = [ 
                    'description' => $request->description,
                    'customer_name' => $request->customer_name,
                    'bizapp_alias' => $request->bizapp_alias,
                    'is_active' => $request->is_active,
                    'image_url' => $image_url
                ];

                $item = $this->baseRepository->create($data);
                DB::commit();
                return $item;

            }
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
            $images_core_feedback_tmp = Storage::disk('s3')->allFiles('core_feedback_tmp');
            
            $image_url = '';
            foreach ($images_core_feedback_tmp as $image_core_feedback_tmp) {
                if ($request->image_url === $image_core_feedback_tmp) {
                    $image = $image_core_feedback_tmp;
                    $image_url = str_replace('core_feedback_tmp', 'core_feedback', $image);
                    Storage::disk('s3')->move($image, $image_url);
                    Storage::disk('s3')->delete($image);
                }
            }
            if (!$image_url) {
                $image_url = $request->image_url;
            }
            DB::beginTransaction();
            $data = [ 
                'description' => $request->description,
                'customer_name' => $request->customer_name,
                'bizapp_alias' => $request->bizapp_alias,
                'is_active' => $request->is_active,
                'image_url' => $image_url
            ];
            $item = $this->baseRepository->update($data, $id);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
