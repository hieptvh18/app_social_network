<?php

if(!function_exists('fileUploader')){
    function fileUploader($file, $prefixName = '', $folder)
    {
        $fileName = $file->hashName();
        $fileName = $prefixName
            ? $prefixName . '_' . $fileName
            : time() . '_' . $fileName;

        return $file->storeAs($folder, $fileName);
    }
}

if(!function_exists('removeFilePath')){
    function removeFilePath($path){
        if(file_exists($path)){
            return unlink($path);
        }
    }
}