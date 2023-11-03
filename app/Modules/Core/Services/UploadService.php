<?php

namespace Modules\Core\Services;

use App\Exceptions\ApiException;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Enums\UploadTypeEnum;

class UploadService
{

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $type = $request->post('type');
        if ($type === 'CHANEL') {
            return $this->uploadFileForChanel($file);
        } else if ($type === 'AVATAR') {
            $path = '/uploads/user/' . auth()->id();
            return $this->uploadImage($file, $path);
        } else if ($type === 'PROMOTION_REPORT') {
            $path = '/promotion_report_tmp';
            return $this->uploadImage($file, $path);
        } elseif ($type === 'AVATAR_WORKSPACE') {
            $path = '/avatar_workspace_tmp';
            return $this->uploadImage($file, $path);
        } elseif ($type === 'BACKGROUND_WORKSPACE') {
            $path = '/background_workspace_tmp';
            return $this->uploadImage($file, $path);
        }elseif ($type === 'WORKSPACE_WEBSITE_LOGO') {
            $path = '/workspace_website_logo_tmp';
            return $this->uploadImage($file, $path);
        }elseif ($type === 'WORKSPACE_WEBSITE_FAVICON') {
            $path = '/workspace_website_favicon_tmp';
            return $this->uploadImage($file, $path);
        }

        return false;
    }

    public function uploadFileForChanel($file)
    {
        $channel_alias = request()->input('channel_alias');
        // $chanel = auth()->user()->myChanel();
        $path = '/uploads/chanels/' . $channel_alias;
        return $this->uploadImage($file, $path);
    }

    public function uploadImage($file, $path)
    {
        if ($file) {
            $allowedExtension = ['jpg', 'png', 'jpeg'];
            $extension = $file->getClientOriginalExtension();
            $name = 'IMG_' . Carbon::now()->timestamp . '.' . $extension;

            $size = $file->getSize();
            if ($file->isValid()) { // nếu ảnh không lỗi
                if (in_array($extension, $allowedExtension)) { // nếu đúng định dạng ảnh
                    if ($size < 1048576 * 50) { // 50MB
                        $filename = Storage::putFileAs($path, $file, $name, 'public');
                        // $filename = $file->storeAs($path,$name);
                        return $filename;
                    } else {
                        throw new ApiException("$name vượt quá dung lượng 50Mb, vui lòng kiểm tra lại", 400);
                    }
                } else {
                    throw new ApiException("$name lỗi định dạng ảnh, vui lòng kiểm tra lại", 400);
                }
            } else {
                throw new ApiException("$name đã bị lỗi, vui lòng kiểm tra lại", 400);
            }
        } else {
            throw new ApiException('Bạn chưa chọn ảnh tải lên', 400);
        }
    }
}
