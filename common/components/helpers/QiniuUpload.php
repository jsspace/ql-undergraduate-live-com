<?php

namespace components\helpers;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Yii;

/**
 * Upload provides concrete implementation for uploading image or video to oss.
 *
 * @author wfzhang <wfzhang@mobvoi.com>
 * @since 1.0
 */
class QiniuUpload
{
    public static function uploadToQiniu($image, $filePath, $folder) {
        // $filePath 要上传文件的本地路径
        // 初始化签权对象
        $auth = new Auth(Yii::$app->params['access_key'], Yii::$app->params['secret_key']);

        // 生成上传Token
        $bucket = Yii::$app->params['public_bucket'];
        $token = $auth->uploadToken($bucket);

        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();

        // 上传到七牛后保存的文件名
        $ext = $image->getExtension();
        $key = $folder . '/' . time() . rand(1000, 9999) . '.' . $ext;

        $response = $uploadMgr->putFile($token, $key, $filePath);

        return $response;
    }
}