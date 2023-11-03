<?php

namespace Modules\Core\Services\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Storage;


class UploadImageService
{
    public function uploadImage(Request $request)
    {
        $file = $request->file('file');
        $type = $request->post('type');
        if($type === 'category'){
            $path='/category_tmp';
        }
        if($type === 'blog'){
            $path = '/blog_tmp';
        }
        if($type === 'BANNER'){
            $path = '/banner_tmp';
        }
        if($type == 'PROMOTION_AVATAR'){
            $path = '/promotion_avatar_tmp';
        }
        if($type == 'PROMOTION_BANNER'){
            $path = '/promotion_banner_tmp';
        }
        if($type == 'CATEGORY_BOOK'){
            $path = '/category_book_tmp';
        }
        if($type == 'EBOOK_BOOK'){
            $path = '/ebook_book_tmp';
        }
        if($type == 'QUIZ_SUBJECT'){
            $path = '/quiz_subject_tmp';
        }
        if($type == 'QUIZ_SKILL'){
            $path = '/quiz_skill_tmp';
        }
        if($type == 'QUIZ_TOPIC'){
            $path = '/quiz_topic_tmp';
        }
        if($type == 'QUIZ_LEVEL'){
            $path = '/quiz_level_tmp';
        }
        if($type == 'QUIZ_MAJOR'){
            $path = '/quiz_major_tmp';
        }
        if($type == 'CORE_FEEDBACK'){
            $path = '/core_feedback_tmp';
        }
        if($type === 'BIZAPP'){
            $path = '/bizapp_tmp';
        }
        if ($file) {
            $allowedExtension = ['jpg', 'png', 'jpeg', 'gif'];

            $extension = $file->getClientOriginalExtension();

            // $name = $file->getClientOriginalName();
            $name = 'IMG_' . Carbon::now()->timestamp . '.' . $extension;

            $size = $file->getSize();
            if ($file->isValid()) { // nếu ảnh không lỗi

                if (in_array($extension, $allowedExtension)) { // nếu đúng định dạng ảnh

                    if ($size < 5242880) { // 5MB

                        $filename = Storage::disk('s3')->putFileAs($path, $file, $name, 'public');
                        return $filename;
                    } else {

                        throw new ApiException("$name vượt quá dung lượng 5Mb, vui lòng kiểm tra lại", 400);
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
