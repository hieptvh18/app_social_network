<?php

namespace Modules\Core\Services\Admin;

use Exception;
use Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\ContactRepository;
use Modules\Core\Notifications\NotifyContactUser;
use Modules\Core\Notifications\NotifyContactAdmin;


class ContactService extends BaseService
{

    public function __construct(ContactRepository $contactRepository)
    {
        $this->baseRepository = $contactRepository;
    }

    public function sendContact(Request $request)
    {
        $data = $this->baseRepository->create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'bizapp' => $request->bizapp,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);
        $user = User::whereHas('info', function ($query) {
            $query->where('type', 'ADMIN');
        })->first();
        $notify_admin = [
            'name' => $user->info->first_name . $user->info->last_name,
            'body' =>  $data,
        ];
        $notify_user = [
            'name' => $data['name'],
            'body' =>  $data,
        ];
        Notification::send($user, new NotifyContactAdmin($notify_admin));

        Notification::route('mail', $data['email'])->notify(new NotifyContactUser($notify_user));
        return $data;
    }

    public function updateStatus(Request $request, $id){
        try{
            DB::beginTransaction();
            $contact = $this->baseRepository->find($id);
            $contact->update(['status' => $request->status]);
            DB::commit();
            return $contact;
        }catch(Exception $e){
            DB::rollback();
            throw $e;
        }

    }
}
