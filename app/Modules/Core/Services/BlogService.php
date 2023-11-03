<?php

namespace Modules\Core\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Core\Models\ActivityLog;
use Modules\Core\Models\Blog;
use Modules\Core\Repositories\BlogRepository;

class BlogService extends BaseService
{

    public function __construct(BlogRepository $blogRepository)
    {
        $this->baseRepository = $blogRepository;
    }

    public function getListBlogFeatured(Request $request)
    {
        // $this->limit = request()->query('size') ?? 12;
        $blogs_features = $this->baseRepository->select('id', 'alias', 'name', 'image_thumbnail', 'is_featured', 'status', 'published_at', 'finished_at', 'action_click_type')
            ->where([
                ['status', 'PUBLISHED'],
                ['is_featured', true],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
            ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['is_featured', true],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '=', null]
            ])

            ->limit(5)->get();
        return $blogs_features;
    }

    public function mostViewBlog(Request $request)
    {
        $most_view_blog = $this->baseRepository->select(
            '*',
            DB::raw("(
                    select count('id')
                    from activity_log
                    where core_blogs.id=activity_log.subject_id and activity_log.event= 'viewed' and activity_log.log_name= 'blog'
                ) as total_view")
        )
            ->where(DB::raw("(
                select count('id')
                from activity_log
                where core_blogs.id=activity_log.subject_id and activity_log.event= 'viewed' and activity_log.log_name= 'blog'
            )"), '>', 0)
            ->where([
                ['status', 'PUBLISHED'],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
            ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '=', null]
            ])
            ->limit(10)
            ->orderBy('total_view', $this->dir)
            ->get();
        return $most_view_blog;
    }

    public function findPublicBlog($alias)
    {
        $blog = $this->baseRepository
            ->select(
                'id',
                'name',
                'short_description',
                'description',
                'published_at',
                'action_click_type'
            )
            ->where([
                ['status', 'PUBLISHED'],
                ['alias', $alias],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
            ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['alias', $alias],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '=', null]
            ])->firstOrFail();
        $blog->load(['creator', 'categories:id,name,alias,is_active']);

        $viewed_count = ActivityLog::where([
            'event' => 'viewed',
            'log_name' => 'blog',
            'subject_id' => $blog->id
        ])->count();
        $blog->viewed_count = $viewed_count;

        // get previous blog id
        $previousId = Blog::where('id', '<', $blog->id)->where('status', 'PUBLISHED')->max('id');

        // get next blog id
        $nextId = Blog::where('id', '>', $blog->id)->where(['status' => 'PUBLISHED', 'bizapp' => 'EDUQUIZ'])->min('id');
        $blog->previous = Blog::select('id', 'name', 'alias', 'status')->find($previousId);
        $blog->next = Blog::select('id', 'name', 'alias', 'status')->find($nextId);
        activity('blog')->causedByAnonymous()->performedOn($blog)->event('viewed')->log('viewed');
        return $blog;
    }

    public function getBlogByCategory(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $collection = $this->baseRepository
            ->where([
                ['status', 'PUBLISHED'],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
            ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '=', null]
            ])
            ->with('creator')
            ->orderBy('created_at', $this->dir);

        $category_id = request()->query('category_id');
        if ($category_id) {
            $collection->whereHas('categories', function ($query) use ($category_id) {
                $query->where(['category_id' => $category_id, 'is_active' => true]);
            });
        }
        return $collection->paginate($this->limit);
    }

    public function getRelatedBlog($blog_id)
    {
        $blog = $this->baseRepository->where([
            ['status', 'PUBLISHED'],
            ['id', $blog_id],
            ['bizapp', 'EDUQUIZ'],
            ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
            ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
        ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['id', $blog_id],
                ['bizapp', 'EDUQUIZ'],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
            ])->firstOrFail();
        $category_id_blog = $blog->categories->pluck('id');
        $related_blog = $this->baseRepository->where([
            ['status', 'PUBLISHED'],
            ['bizapp', 'EDUQUIZ'],
            ['id', '<>', $blog_id],
            ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
            ['finished_at', '>', Carbon::now('Asia/Ho_Chi_Minh')]
        ])
            ->orWhere([
                ['status', 'PUBLISHED'],
                ['bizapp', 'EDUQUIZ'],
                ['id', '<>', $blog_id],
                ['published_at', '<', Carbon::now('Asia/Ho_Chi_Minh')],
                ['finished_at', '=', null]
            ])->whereHas('categories', function ($query) use ($category_id_blog) {
                $query->whereIn('category_id', $category_id_blog);
            })->inRandomOrder()->limit(5)->get();
        return $related_blog;
    }
}
