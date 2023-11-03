<?php

namespace Modules\Core\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Core\Repositories\BlogCategoryRepository;


class BlogCategoryService extends BaseService
{

    public function __construct(BlogCategoryRepository $blogCategoryRepository)
    {
        $this->baseRepository = $blogCategoryRepository;
    }

    public function categoryBlogShowHomepage(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->select('id', 'name', 'alias')
            ->where(['is_active' => true, 'is_show_homepage' => true])
            // ->whereHas('blogs', function ($query) {
            //     $query->where([
            //         'core_blogs.status' => 'PUBLISHED'
            //     ]);
            // })
            ->with([
                'blogs' => function ($query) {
                    $query->select('core_blogs.id', 'name', 'alias', 'published_at', 'image_thumbnail', 'status', 'action_click_type')
                        ->where([
                            ['core_blogs.status', 'PUBLISHED'],
                            ['bizapp', 'EDUQUIZ'],
                            ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                            ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
                        ])
                        ->orWhere([
                            ['core_blogs.status', 'PUBLISHED'],
                            ['bizapp', 'EDUQUIZ'],
                            ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                            ['finished_at', '=', null]
                        ]);
                }
            ])
            ->get()->map(function ($query) {
                $query->setRelation('blogs', $query->blogs->take(6));
                return $query;
            });
        // ->orderBy($this->sort, $this->dir)
        // ->paginate($this->limit);
        return $collection;
    }

    public function findCategoryByAlias($alias)
    {
        $blog_category = $this->baseRepository->where(['is_active' => true, 'alias' => $alias])->firstOrFail();
        return $blog_category;
    }
}
