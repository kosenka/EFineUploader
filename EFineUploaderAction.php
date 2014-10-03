<?php

class EFineUploaderAction extends CAction {

    public function run() {
        $tempFolder = Yii::getPathOfAlias('webroot.upload.efineuploader') . DIRECTORY_SEPARATOR;

        @mkdir($tempFolder, 0777, TRUE);
        @mkdir($tempFolder . 'chunks', 0777, TRUE);

        Yii::import("ext.EFineUploader.qqFileUploader");

        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('jpg', 'jpeg');
        $uploader->sizeLimit = 2 * 1024 * 1024; //maximum file size in bytes
        $uploader->chunksFolder = $tempFolder . 'chunks';

        $result = $uploader->handleUpload($tempFolder);
        $result['filename'] = $uploader->getUploadName();
        $result['folder'] = dirname($result['filename']);

        header("Content-Type: text/plain");
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        Yii::app()->end();
    }

}
