<?php
require_once SCRIPT_PATH . 'PhpThumb' . DS . 'ThumbLib.inc.php';
class Upload{
    public function uploadFile($fileObj, $folderUpload, $width = 60, $height = 90, $options = null){
        if($options == null){
            if($fileObj['tmp_name'] != null){
                $uploadDir		= UPLOAD_PATH . $folderUpload . DS;
                $fileName = $this->randomString(8) . '.' . pathinfo($fileObj['name'], PATHINFO_EXTENSION);
                @copy($fileObj['tmp_name'], $uploadDir . $fileName);
                $thumb = PhpThumbFactory::create($uploadDir . $fileName);
				$thumb->adaptiveResize(60, 90);
                $prefix	= $width . 'x' . $height . '-';
				$thumb->save($uploadDir . $prefix . $fileName);
            }
        }
        return $fileName;
    }

    public function removeFile($folderUpload, $fileName){
        $fileName	= UPLOAD_PATH . $folderUpload . DS . $fileName;
		@unlink($fileName);
    }

    private function randomString($length = 5){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}