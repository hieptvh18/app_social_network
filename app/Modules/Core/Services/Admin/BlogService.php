<?php

namespace Modules\Core\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Models\BlogTag;
use Modules\Core\Repositories\BlogRepository;


class BlogService extends BaseService
{

    public function __construct(BlogRepository $blogRepository)
    {
        $this->baseRepository = $blogRepository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository->select(
            '*',
            DB::raw("(
                    select count('id')
                    from activity_log
                    where core_blogs.id=activity_log.subject_id and activity_log.event= 'viewed' and activity_log.log_name= 'blog'
                ) as total_view")
        )
            ->with('creator')

            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

    public function create(Request $request)
    {
        try {
            $images_tmp = Storage::disk('s3')->allFiles('blog_tmp');
            $image_thumbnail = '';
            $image_cover = '';
            foreach ($images_tmp as $image_tmp) {

                if ($request->image_thumbnail === $image_tmp) {
                    $image_thumbnail = $image_tmp;
                }
                if ($request->image_cover === $image_tmp) {
                    $image_cover = $image_tmp;
                }
            }

            $tags = BlogTag::where('is_active', true)->whereIn('id', $request->tag_ids)->pluck('name')->toArray();
            $keyword = implode(', ', $tags);

            $image_thumbnail_url = str_replace('blog_tmp', 'blog', $image_thumbnail);
            $image_cover_url = str_replace('blog_tmp', 'blog', $image_cover);

            DB::beginTransaction();
            $data = array_merge(
                $request->only(
                    ['name', 'alias', 'short_description', 'description', 'type', 'published_at', 'finished_at', 'status', 'show_type', 'action_click_type', 'is_featured', 'bizapp']
                ),
                [
                    'image_thumbnail' => $image_thumbnail_url,
                    'image_cover' => $image_cover_url,
                    'meta_title' => $request->meta_title ?? $request->name,
                    'meta_description' => $request->meta_description ?? $request->short_description,
                    'meta_url' => $request->meta_url ?? $request->alias,
                    'meta_keyword' => $request->meta_keyword ?? $keyword
                ]
            );
            $item = $this->baseRepository->create($data);
            $item->tags()->attach($request->tag_ids);
            $item->categories()->attach($request->category_ids);
            DB::commit();
            if ($image_thumbnail) {
                Storage::disk('s3')->move($image_thumbnail, $image_thumbnail_url);
            }
            if ($image_cover) {
                Storage::disk('s3')->move($image_cover, $image_cover_url);
            }
            Storage::disk('s3')->deleteDirectory('blog_tmp');
            // Storage::disk('s3')->delete($image_thumbnail, $image_cover);
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
            $images_tmp = Storage::disk('s3')->allFiles('blog_tmp');
            $image_thumbnail_url = '';
            $image_cover_url = '';
            foreach ($images_tmp as $image_tmp) {

                if ($request->image_thumbnail === $image_tmp) {
                    $image_thumbnail = $image_tmp;
                    $image_thumbnail_url = str_replace('blog_tmp', 'blog', $image_thumbnail);
                    Storage::disk('s3')->move($image_thumbnail, $image_thumbnail_url);
                    Storage::disk('s3')->delete($image_thumbnail);
                }
                if ($request->image_cover === $image_tmp) {
                    $image_cover = $image_tmp;
                    $image_cover_url = str_replace('blog_tmp', 'blog', $image_cover);
                    Storage::disk('s3')->move($image_cover, $image_cover_url);
                    Storage::disk('s3')->delete($image_cover);
                }
            }
            if(!$image_thumbnail_url){
                $image_thumbnail_url = $request->image_thumbnail;
            }
            if(!$image_cover_url){
                $image_cover_url = $request->image_cover;
            }

            DB::beginTransaction();
            $data = array_merge(
                $request->only(
                    ['name', 'alias', 'short_description', 'description', 'type', 'published_at', 'finished_at', 'status', 'show_type', 'action_click_type', 'is_featured', 'bizapp', 'meta_title', 'meta_description', 'meta_url', 'meta_keyword']
                ),
                [
                    'image_thumbnail' => $image_thumbnail_url,
                    'image_cover' => $image_cover_url,
                ]
            );
            $item = $this->baseRepository->update($data, $id);
            $item->tags()->sync($request->tag_ids);
            $item->categories()->sync($request->category_ids);
            DB::commit();

            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function find($id)
    {
        $item = $this->baseRepository->find($id)->load(['tags', 'categories']);
        return $item;
    }
}
