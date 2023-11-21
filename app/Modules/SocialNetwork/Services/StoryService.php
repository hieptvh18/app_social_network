<?php

namespace Modules\SocialNetwork\Services;

use App\Http\Controllers\Api\AbstractApi;
use Modules\SocialNetwork\Models\Follow;
use Modules\SocialNetwork\Models\Stories;
use Modules\SocialNetwork\Repositories\StoryRepository;

class StoryService extends AbstractApi
{

    protected $baseRepository;

    public function __construct(StoryRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function store($request)
    {
        try{
            $story = $this->baseRepository->create($request->all());

            return  $this->respSuccess(['story'=>$story],'Save success');
        }catch(\Throwable $e){
            return $this->respError(false,'Have an error when save story! '.$e->getMessage());
        }
    }

    public function findStory($id)
    {
        return Stories::find($id);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchListStoryIsActive()
    {
        // @codingStandardsIgnoreStart

        $followingIds = Follow::where('user_id',auth()->id())
                            ->pluck('following_id')->toArray();
        array_unshift($followingIds,auth()->id());

        $stories = $this->baseRepository->whereIn('user_id',$followingIds)
                            ->with(['author'=>function($q){
                                $q->select('id','username','avatar');
                            }])
                            ->get();

        $result = array();
        foreach($stories as $key=>$story){
            $story->storiesGroup = [];

            if(!checkIsAvailable24h($story->created_at)) continue;

            if(!count($result)){
                $result[] = $story;
            }

            // cheeck if 1 account have many story-> format to group story
            $keyUnset = '';
            foreach($result as $keyRs=>$rs){
                if($rs->user_id == $story->user_id){

                    $rs->storiesGroup = [$story];
                   if($key != 0){
                       $keyUnset = $key;
                   }
                }else{
                    $result[] = $story;
                }
            }

            if($keyUnset) unset($result[$keyUnset]);
        }

        return $this->respSuccess(['stories'=>$result]);
        // @codingStandardsIgnoreEnd
    }

    public function fetchMyStories()
    {
        try{
            $stories = $this->baseRepository->where('user_id',auth()->id())
                                ->with(['author'=>function($q){
                                    $q->select('id','username','avatar');
                                }])
                                ->get();
            return $this->respSuccess(['stories'=>$stories]);
        }catch(\Throwable $e){
            report($e->getMessage());
            return $this->respError(false,'Have an error when get my story!'.$e->getMessage());
        }
    }

    public function softDelete($id)
    {
        try{
            $story = $this->baseRepository->find($id);
            if(!$story){
                return $this->respError(false,'Not found story!');
            }
            $story->is_active = 0;
            $story->save();
            return $this->respSuccess(false,'soft delete success!');
        }catch(\Throwable $e){
            return $this->respError(false,'Have an error when force delete story!'.$e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try{
            if(!Stories::find($id)){
                return $this->respError(false,'Not found story!');
            }
            Stories::destroy($id);
            return $this->respSuccess(false,'force delete success!');
        }catch(\Throwable $e){
            return $this->respError(false,'Have an error when force delete story!'.$e->getMessage());
        }
    }
}
