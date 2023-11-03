<?php

namespace Modules\Core\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Quiz\Models\ExamChanel;
use Modules\Core\Models\ActivityLog;
// use Modules\Core\Models\ActivityLog;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Validators\ActivityLogValidator;
use Modules\Core\Repositories\ActivityLogRepository;
use Modules\Core\Repositories\Criteria\FilterCreatedAtCriteria;
use Modules\Quiz\Models\Exam;

/**
 * Class ActivityLogRepositoryEloquent.
 *
 * @package namespace Modules\Core\Repositories;
 */
class ActivityLogRepositoryEloquent extends BaseRepository implements ActivityLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ActivityLog::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCreatedAtCriteria::class));
    }

    public function getStatisChanel($start_date, $end_date, $type)
    {
        $this->skipCriteria(true);
        $user_id = auth()->id();
        $chanel = ExamChanel::where('user_id', $user_id)->first();
        $data = $this->select(DB::raw("(DATE_FORMAT(created_at, '%d/%m/%Y')) as day"), DB::raw("count('id') as total_type_chanel"))
        ->whereBetween('created_at', [$start_date, $end_date])
        ->when(true, function ($query) {
            $query->where([['event', '<>', 'updated'], ['event', '<>', 'created'], ['event', '<>', 'deleted']]);
        });

        if($type == 'VIEWED'){
            $data = $data->where([
                'log_name' => 'exam',
                'event' => 'viewed'
            ])
            ->whereHasMorph('subject', Exam::class, function ($query) use ($chanel) {
                $query->where(['chanel_id' => $chanel->id]);
            });
        }elseif($type == 'FOLLOW'){
            $data = $data->where([
                ['causer_id', '<>', $user_id],
                'log_name' => 'chanel',
                'event' => 'subcribe',
            ])
            ->whereHasMorph('subject', ExamChanel::class, function ($query) use ($chanel) {
                $query->where(['id' => $chanel->id]);
            });
        }elseif($type == 'DOWNLOAD'){
            $data = $data->where([
                ['causer_id', '<>', $user_id],
                'log_name' => 'exam',
                'event' => 'download',
            ])
            ->whereHasMorph('subject', Exam::class, function ($query) use ($chanel) {
                $query->where(['chanel_id' => $chanel->id]);
            });
        }else{
            return $data = [];
        }

        $data = $data->groupBy(DB::raw("DATE_FORMAT(created_at, '%d/%m/%Y')"))
            ->orderBy('created_at', 'ASC')->get();

        return $data;
    }
}
