<?php

namespace Modules\Core\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Repositories\BlogCategoryRepository;


class BlogCategoryService extends BaseService
{

    public function __construct(BlogCategoryRepository $blogCategoryRepository)
    {
        $this->baseRepository = $blogCategoryRepository;
    }

    public function create(Request $request)
    {
        try {
            $images_category_tmp = Storage::disk('s3')->allFiles('category_tmp');
            foreach ($images_category_tmp as $image_category_tmp) {
                if ($request->image === $image_category_tmp) {
                    DB::beginTransaction();
                    $image_url = str_replace('category_tmp', 'blog_category', $image_category_tmp);
                    $data = [
                        'name' => $request->name,
                        'description' => $request->description,
                        'is_active' => $request->is_active,
                        'is_show_homepage' => $request->is_show_homepage,
                        'image' => $image_url
                    ];
                    $item = $this->baseRepository->create($data);
                    DB::commit();
                    Storage::disk('s3')->move($image_category_tmp, $image_url);
                    Storage::disk('s3')->delete($image_category_tmp);
                    return $item;
                }
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
            $images_tmp = Storage::disk('s3')->allFiles('category_tmp');
            $image_url='';
            foreach ($images_tmp as $image_tmp) {
                if ($request->image === $image_tmp) {
                    $image = $image_tmp;
                    $image_url = str_replace('category_tmp', 'blog_category', $image);

                    Storage::disk('s3')->move($image, $image_url);
                    Storage::disk('s3')->delete($image);
                }
            }
            if(!$image_url){
                $image_url = $request->image;
            }
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'is_show_homepage' => $request->is_show_homepage,
                'image' => $image_url
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
