<?php

namespace Modules\SocialNetwork\Services;

use App\Http\Controllers\Api\AbstractApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Modules\SocialNetwork\Models\Follow;
use Modules\SocialNetwork\Models\Post;
use Modules\SocialNetwork\Models\Room;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserService extends AbstractApi
{

    public function getUserByUsername($username)
    {
        try {
            if ($username && User::where('username', $username)->exists()) {
                $user = User::where('username', $username)->first();

                $listFollowingId = $user->following->pluck('following_id')->toArray();
                $listFollowerId = $user->follower->pluck('user_id')->toArray();

                $listFollower = $this->getInfobyId($listFollowerId);
                $listFollowing = $this->getInfobyId($listFollowingId);

                // handle get list post
                $posts = [];
                if(count($user->posts)){
                    foreach($user->posts as $key=>$post){
                        $p = Post::query()->where('id',$post->id)
                                    ->withCount(['comments','likers'])->first();

                        $post = [
                            'captions'=>$p->captions,
                            'id'=>$p->id,
                            'images' => $p->images,
                            'comments_count'=>$p->comments_count,
                            'likes_count'=>count($p->likers)
                        ];
                        array_push($posts,$post);
                    }
                }

                $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'bio' => $user->bio,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'avatar' => $user->avatar,
                    'google_id' => $user->google_id,
                    'facebook_id' => $user->facebook_id,
                    'follower_list' => $listFollower,
                    'following_list' => $listFollowing,
                    'posts' => $posts,

                ];

                return $this->respSuccess(['data'=>$data],'Get user data by username success!');
            }

            return $this->respError(false,'User not found!');
        } catch (Throwable $e) {
            return $this->respError(false,'User user by username fail! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserById($id)
    {
        try{
            if(!User::find($id)) {
                return response()->json([
                    'success'=>false,
                    'message'=>'User not found!',
                    'data'=>[]
                ]);
            }

            return $this->respSuccess(['data'=>User::find($id)],'Get user by id success!');
        }catch(\Throwable $e){
            report($e->getMessage());
            return $this->respError(false,'Something wrong when get user by id! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * order by history...
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function getFriendsUser(){
        try{
            $userId = Auth::id();
            // condition 1: get following
            $followingIds = Follow::where('user_id',$userId)
                            ->pluck('following_id')->toArray();

            // condition 2: get history chat
            $userChatIds = Room::select('from','to')->where('from',$userId)
                            ->orWhere('to',$userId)
                            ->get()->toArray();

            $userChatIdsArr = array_unique(array_values(collect($userChatIds)->flatten()->toArray()));

            $userIdOutPut = array_unique(array_merge($followingIds,$userChatIdsArr));

            // unset my id
            if($key = array_search($userId,$userIdOutPut)){
                unset($userIdOutPut[$key]);
            }

            $users = User::select('id','name','username','avatar')
                            ->whereIn('id',$userIdOutPut)
                            ->get();

            return $this->respSuccess(['data'=>$users],'Get list user followed success!');
        }catch(\Exception $e){
            report($e->getMessage());
            return $this->respError(false,'get list user followed fail->detail: '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateUserById($request)
    {
        try {
            if ($user = User::find($request->id)) {

                $user->username = $request->username;
                $user->email = $request->email;
                $user->bio = $request->bio;
                $user->phone = $request->phone;

                $userSave = $user->save();
                if ($userSave) {
                    return $this->respSuccess(['data'=>$user],'Update profile success!');
                }

                return $this->respError(false,'Update fail!');
            }

            return $this->respError(false,'Params id is invalid!');
        } catch (Throwable $e) {
            report($e->getMessage());
            return $this->respError(false,'Something wrong when update profile! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findUserByUsername($username)
    {
        try {
            if (!$username) {
                return $this->respError(false,'Params username is required!');
            }
            $user = User::select('id', 'name', 'email', 'username', 'avatar')->where('username', 'like', $username . '%')->get();

            if ($user) {
                return $this->respSuccess(['data'=>$user],'Get user success!');
            }

            return $this->respError(false,'User not found!');
        } catch (Throwable $e) {
            report($e->getMessage());
            return $this->respError(false,'Something wrong when get user! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create($request)
    {
        $dataResponse = ['status' => true, 'data' => [], 'message' => ""];

        if (!$request->username || !$request->name || !$request->email || !$request->password) {
            return $this->respError(['data'=>$request->all()],'Data is not valid!');
        }

        try {
            $userExistEmail = User::where('email', $request->email)->first();
            $userExistUsername = User::where('username', $request->username)->first();

            if ($userExistEmail) {
                return $this->respError(false,'Email exist customer!');
            }

            if ($userExistUsername) {
                return $this->respError(false,'Username exist customer!');
            }

            $model = new User();
            $model->fill($request->all());
            $model->password = Hash::make($request->password);
            $model->save();

            return $this->respSuccess(['data'=>$request->all()],'Register success!');
        } catch (Throwable $e) {
            report($e);
            return $this->respError(false,'Something wrong! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function follow($user_id, $following_id)
    {
        try {
            // action following
            $userFollow = new Follow();
            $userFollow->user_id = $user_id;
            $userFollow->following_id = $following_id;
            $userFollow->save();

            return $this->respSuccess(false,'Following success');
        } catch (Throwable $e) {
            report($e->getMessage());
            return $this->respError(false,'Something error! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getInfobyId($id)
    {
        $list = [];

        foreach ($id as $key) {
            $data = User::where('id', $key)->first(['id', 'name', 'avatar', 'username']);
            if ($data) {
                $userAttributes = [
                    'id' => $data->id,
                    'name' => $data->name,
                    'avatar' => $data->avatar,
                    'username' => $data->username
                ];

                $list[] = $userAttributes;
            }
        }
        return $list;
    }

    public function logout($request)
    {
        try {
            $cookie = Cookie::forget('jwtlogin');
            $request->user()->currentAccessToken()->delete();
            return response()->json(['status' => 'ok', 'message' => 'Logout success!']);
        } catch (Throwable $e) {
            report($e->getMessage());
            return response()->json(['status' => 'fail', 'message' => 'Logout fail!'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function unFollow($user_id, $following_id)
    {
        try {
            $followExist  = Follow::where('user_id', $user_id)
                ->where('following_id', $following_id)->exists();

            if (!$followExist) {
                return $this->respError(false,'Not found user followed!');
            }

            $delete = Follow::where('user_id', $user_id)
                ->where('following_id', $following_id)->first()->delete();
            if ($delete) {
                return $this->respSuccess(false,'Un follow success!');
            }

            return $this->respError(false,'Un follow error! Pls try again!');
        } catch (Throwable $er) {
            return $this->respError(false,'UnFollow error! ' . $er->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * upload avatar file
     */
    public function uploadAvatar(Request $request)
    {
        try {
            if (!$request->hasFile('avatar')) {
                return $this->respError(false,'File upload not exist!');
            }

            $filePath = fileUploader($request->file('avatar'), 'avatar', 'uploads/avatars');

            if ($filePath) {
                // save data
                $baseUrl = url('/');
                $user = User::find(Auth::user()->id);

                // remove old file
                $oldAvatar = $user->avatar;
                if ($oldAvatar) removeFilePath($oldAvatar);

                $user->avatar = $baseUrl . '/' . $filePath;
                $user->save();

                return $this->respSuccess(['data'=>['avatar' => $user->avatar]],'Upload success!');
            }
            return $this->respError(false,'Upload not success!');
        } catch (Throwable $er) {
            return $this->respError(false,'Upload not success! '.$er->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function recommendFollow()
    {
        try {
            $userId = Auth::id();

            $followingList = Follow::where('user_id', $userId)->pluck('following_id');
            $followingList = $followingList->push($userId);
            $recommendedUsers = Follow::whereIn('user_id', $followingList)
                ->whereNotIn('following_id', $followingList) // Loại bỏ những người mà người dùng đã theo dõi
                ->pluck('following_id')
                ->unique();

            if(count($recommendedUsers)){
                $users = User::whereIn('id', $recommendedUsers)->get();
                return $this->respSuccess(['data'=>$users],'get Recommended users to follow!');
            }

            // case many followers

            // random
            $users = User::inRandomOrder()->whereNotIn('id',$followingList)
                            ->limit(10)->get();
            return $this->respSuccess(['data'=>$users],'Get recommended users to follow!');

        } catch (\Throwable $e) {
            return $this->respSuccess(false,'An error occurred! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // update password
    public function updatePassword($oldPassRequest,$newPassRequest)
    {
        try{
            if(!$oldPassRequest || !$newPassRequest) return $this->respError(false,'Param required oldPass and newPass');

            $user = User::find(auth()->id());

            if(Hash::check($oldPassRequest,$user->password)){
                //update pass
                $user->password = bcrypt($newPassRequest);
                $user->save();
                return $this->respSuccess(false,'Update new password success!');
            }

            return $this->respError(false,'Old password fail!');
        }catch(\Throwable $e){
            return $this->respError(false,'Have an error when update password! '.$e->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
