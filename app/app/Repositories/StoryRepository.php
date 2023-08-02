<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\StoryRepositoryInterface;
use App\Models\Stories;

class StoryRepository extends AbstractApi implements StoryRepositoryInterface
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

    public function fetchStoryByFriend()
    {
        
    }

    public function fetchMyStories()
    {
        try{
            $stories = Stories::where('user_id',auth()->id())
                                ->with(['author'])
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
