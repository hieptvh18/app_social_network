<?php

namespace Modules\SocialNetwork\Services;

use App\Http\Controllers\Api\AbstractApi;
use Modules\SocialNetwork\Entities\Follow;
use Modules\SocialNetwork\Entities\Stories;

class StoryService extends AbstractApi
{

    public function store($request)
    {
        try{
            $story = new Stories();
            $story->fill($request->all());
            $story->save();

            return  $this->respSuccess(['story'=>$story],'Save success');
        }catch(\Throwable $e){
            return $this->respError(false,'Have an error when save story! '.$e->getMessage());
        }
    }

    public function findStory($id)
    {
        return Stories::find($id);
    }

    public function fetchListStoryIsActive()
    {
        $followingIds = Follow::where('user_id',auth()->id())
                            ->pluck('following_id')->toArray();
        array_unshift($followingIds,auth()->id());

        $stories = Stories::whereIn('user_id',$followingIds)
                            ->get();


        $result = array();
        foreach($stories as $key=>$story){
            $story->storiesGroup = [];

            if(!checkIsAvailable24h($story->created_at)) continue;

            if(!count($result)){
                array_push($result, $story);
            }

            // cheeck if 1 account have many story-> format to group story
            $storyGroups = [];
            foreach($result as $keyRs=>$rs){
                if($rs->user_id == $story->user_id){

                    $rs->storiesGroup = [$story];
                }else{
                    array_push($result, $story);
                }
            }
        }

        return $result;
    }

    public function fetchMyStories()
    {
        try{
            $stories = Stories::query()->where('user_id',auth()->id())
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
            $story = Stories::find($id);
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
