<?php

namespace Modules\Core\Traits;

use Modules\Quiz\Models\ExamChanel;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Builder;

trait CoreHasUserAudit
{

    use Userstamps;

    /**
     * Scope a query to only create by me
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedByMe($query)
    {
        return $query->where('created_by', auth()->id());
    }

    /**
     * Scope a query to only active
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope a query to only system
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrSystem($query)
    {
        if (request()->has('level_school_ids')) {
            $level_school_ids = request()->query('level_school_ids');
            $query = $query->orWhereHas('levelSchools', function (Builder $query) use ($level_school_ids) {
                $query->whereIn('level_school_id', $level_school_ids);
            })->where([['is_active', true], ['type', 'SYSTEM']]);
        } elseif (request()->has('is_active')) {
            $query = $query->orWhere([['is_active', request()->query('is_active') === 'true' ? 1 : 0], ['type', 'SYSTEM']]);
        } else {
            $query = $query->orWhere([['is_active', true], ['type', 'SYSTEM']]);
        }
        return $query;
    }

    public function scopeMasterDataSystem($query)
    {
        $query = $query->orWhere([['is_active', true], ['type', 'SYSTEM']]);
        return $query;
    }

    public function scopeExamCount($query, ExamChanel $exam_chanel)
    {
        return $query->withCount(['exams' => function ($q) use ($exam_chanel) {
            $q->where([['status', 'PUBLISH'], ['total_question', '>', 0], ['chanel_id', $exam_chanel->id]]);
        }]);
    }

    public function scopeExamCountMasterDataChanel($query, $type, $ids = [], $exam_chanel)
    {
        if ($type == 'major') {
            return $query->withCount(['exams' => function ($que) use ($ids, $exam_chanel) {
                $que->where(['chanel_id' => $exam_chanel->id])->whereHas('majors', function ($q) use ($ids) {
                    $q->whereIn('major_id', $ids);
                });
            }])->whereHas('exams', function ($que) use ($ids, $exam_chanel) {
                $que->where(['chanel_id' => $exam_chanel->id])->whereHas('majors', function ($q) use ($ids) {
                    $q->whereIn('major_id', $ids);
                });
            });
        }
        if ($type == 'subject') {
            return $query->withCount(['exams' => function ($que) use ($ids, $exam_chanel) {
                $que->where(['chanel_id' => $exam_chanel->id])->whereHas('subjects', function ($q) use ($ids) {
                    $q->whereIn('subject_id', $ids);
                });
            }])->whereHas('exams', function ($que) use ($ids, $exam_chanel) {
                $que->where(['chanel_id' => $exam_chanel->id])->whereHas('subjects', function ($q) use ($ids) {
                    $q->whereIn('subject_id', $ids);
                });
            });
        }
        if ($type == 'skill') {
            return $query->withCount(['exams' => function ($que) use ($ids, $exam_chanel) {
                $que->where(['chanel_id' => $exam_chanel->id])->whereHas('majorSkills', function ($q) use ($ids) {
                    $q->whereIn('skill_id', $ids);
                });
            }]);
        }
        if ($type == 'topic') {
            return $query->withCount(['exams' => function ($que) use ($ids, $exam_chanel) {
                $que->where(['chanel_id' => $exam_chanel->id])->whereHas('topics', function ($q) use ($ids) {
                    $q->whereIn('topic_id', $ids);
                });
            }]);
        }
        if ($type == 'school') {
            return $query->withCount(['exams' => function ($que) use ($ids, $exam_chanel) {
                $que->where(['chanel_id' => $exam_chanel->id])->whereHas('schools', function ($q) use ($ids) {
                    $q->whereIn('school_id', $ids);
                });
            }]);
        }
        if ($type == 'level_school') {
            return $query->withCount(['exams' => function ($que) use ($ids, $exam_chanel) {
                $que->where(['chanel_id' => $exam_chanel->id])->whereHas('levelSchools', function ($q) use ($ids) {
                    $q->whereIn('level_school_id', $ids);
                });
            }]);
        }
    }

    // public function whereHasExam($query){
    //     $query->where(['chanel_id' => $exam_chanel->id])->whereHas('majors', function ($q) use ($ids) {
    //         $q->whereIn('major_id', $ids);
    //     });
    //     return $query;
    // }

    public function scopeExamCountMasterData($query, $type, $ids = [])
    {
        if ($type == 'major') {
            return $query->withCount(['exams' => function ($que) use ($ids) {
                $que->whereHas('majors', function ($q) use ($ids) {
                    $q->whereIn('major_id', $ids);
                });
            }]);
        }
        if ($type == 'subject') {
            return $query->withCount(['exams' => function ($que) use ($ids) {
                $que->whereHas('subjects', function ($q) use ($ids) {
                    $q->whereIn('subject_id', $ids);
                });
            }]);
        }
        if ($type == 'skill') {
            return $query->withCount(['exams' => function ($que) use ($ids) {
                $que->whereHas('majorSkills', function ($q) use ($ids) {
                    $q->whereIn('skill_id', $ids);
                });
            }]);
        }
        if ($type == 'topic') {
            return $query->withCount(['exams' => function ($que) use ($ids) {
                $que->whereHas('topics', function ($q) use ($ids) {
                    $q->whereIn('topic_id', $ids);
                });
            }]);
        }
        if ($type == 'school') {
            return $query->withCount(['exams' => function ($que) use ($ids) {
                $que->whereHas('schools', function ($q) use ($ids) {
                    $q->whereIn('school_id', $ids);
                });
            }]);
        }
        if ($type == 'level_school') {
            return $query->withCount(['exams' => function ($que) use ($ids) {
                $que->whereHas('levelSchools', function ($q) use ($ids) {
                    $q->whereIn('level_school_id', $ids);
                });
            }]);
        }
    }
}
