<?php

namespace App\Repositories;

use App\Models\Follow;
use App\Models\Post;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use URL;

class UserRepository implements UserRepositoryInterface
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

                // hdnale get list post
                $posts = [];
                if(count($user->posts)){
                    foreach($user->posts as $key=>$post){
                        $p = Post::find($post->id);
                        $post = [
                            'captions'=>$p->captions,
                            'id'=>$p->id,
                            'images' => $p->images
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
                return response()->json([
                    'data' => $data,
                    'message' => 'Get user data by username success',
                    'success' => true,
                ]);
            }
            return response()->json([
                'data' => [],
                'message' => 'User not found!',
                'success' => false,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => 'Get user by username fail!! ' . $e->getMessage(),
                'success' => false,
            ]);
        }
    }

    /**
     * order by history...
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function getUserFollowing(){
        try{
            $userId = Auth::id();
            $followingIds = Follow::where('user_id',$userId)->pluck('following_id');
            $users = User::select('id','name','username','avatar')->whereIn('id',$followingIds)
                            ->get();
            return response()->json([
                'success'=>true,
                'message'=>'Get list user followed success.',
                'data'=>$users
            ]);
        }catch(\Exception $e){
            report($e->getMessage());
            return response()->json([
               'success'=>false,
               'data'=>[],
               'message'=> 'get list user followed fail->detail: '.$e->getMessage()
            ]);
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
                    return response()->json([
                        'success' => true,
                        'data' => $user,
                        'message' => 'Update profile success'
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'Update fail!'
                ], 500);
            }
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Params id is invalid!'
            ]);
        } catch (Throwable $e) {
            report($e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Update profile fail! ' . $e->getMessage()
            ]);
        }
    }

    public function findUserByUsername($username)
    {
        try {
            if (!$username) {
                return response()->json([
                    "success" => false,
                    "data" => [],
                    "message" => "Params username is required!"
                ]);
            }
            $user = User::select('id', 'name', 'email', 'username', 'avatar')->where('username', 'like', $username . '%')->get();

            if ($user) {
                return response()->json([
                    "success" => true,
                    "data" => $user,
                    "message" => "Get success user!"
                ]);
            }

            return response()->json([
                "success" => true,
                "data" => [],
                "message" => "User not found!"
            ]);
        } catch (Throwable $e) {
            report($e->getMessage());
            return response()->json([
                "success" => false,
                "data" => [],
                "message" => $e->getMessage()
            ]);
        }
    }

    public function create($request)
    {
        $dataResponse = ['status' => true, 'data' => [], 'message' => ""];

        if (!$request->username || !$request->name || !$request->email || !$request->password) {
            return response()->json([
                'status' => false,
                'message' => 'Data is not valid!',
                'data' => $request->all()
            ]);
        }

        try {
            $userExistEmail = User::where('email', $request->email)->first();
            $userExistUsername = User::where('username', $request->username)->first();

            if ($userExistEmail) {
                $dataResponse['status'] = false;
                $dataResponse['message'] = 'Email exist customer!';
                return response()->json($dataResponse);
            }

            if ($userExistUsername) {
                $dataResponse['status'] = false;
                $dataResponse['message'] = 'Username exist customer!';
                return response()->json($dataResponse);
            }

            $model = new User();
            $model->fill($request->all());
            $model->password = Hash::make($request->password);
            $model->save();

            $dataResponse['data'] = $request->all();
            $dataResponse['message'] = 'Register success!';
            return response()->json($dataResponse);
        } catch (Throwable $e) {
            report($e);
            $dataResponse['status'] = false;
            $dataResponse['message'] = 'Error: ' . $e->getMessage();
            return response()->json($dataResponse);
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

            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Following success'
            ]);
        } catch (Throwable $e) {
            report($e->getMessage());
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => $e->getMessage()
            ]);
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
            return response()->json(['status' => 'fail', 'message' => 'Logout fail!']);
        }
    }

    public function unFollow($user_id, $following_id)
    {
        try {
            $followExist  = Follow::where('user_id', $user_id)
                ->where('following_id', $following_id)->exists();

            if (!$followExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not found user followed!'
                ]);
            }

            $delete = Follow::where('user_id', $user_id)
                ->where('following_id', $following_id)->first()->delete();
            if ($delete) {
                return response()->json([
                    'success' => true,
                    'message' => 'Unfollow success!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'UnFollow error! Pls try again!',
            ]);
        } catch (Throwable $er) {
            return response()->json([
                'success' => false,
                'message' => 'UnFollow error! ' . $er->getMessage(),
            ]);
        }
    }

    /**
     * upload avatar file
     */
    public function uploadAvatar(Request $request)
    {
        try {
            if (!$request->hasFile('avatar')) {
                return response()->json([
                    'success' => false,
                    'message' => 'File upload not exist!',
                    'data' => []
                ]);
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

                return response()->json([
                    'success' => true,
                    'message' => 'Upload success!',
                    'data' => [
                        'avatar' => $user->avatar
                    ]
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Upload not success!',
                'data' => []
            ]);
        } catch (Throwable $er) {
            return response()->json([
                'success' => false,
                'message' => 'Upload not success! ' . $er->getMessage(),
                'data' => []
            ]);
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
                return response()->json([
                    'data' => $users,
                    'message' => 'Recommended users to follow',
                    'success' => true,
                ]);
            }

            // case many followers

            // random
            $users = User::whereNotIn('id',$followingList)->get();
            return response()->json([
                'data' => $users,
                'message' => 'Recommended users to follow',
                'success' => true,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'data' => [],
                'message' => 'An error occurred.',
                'success' => false,
            ]);
        }
    }
}
