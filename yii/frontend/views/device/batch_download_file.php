<?php
/**
 * 作用：批量下载文件 压缩成zip格式的文件
 * 在php.ini的memory_limit的配置项中 必须设置大于128M的配置。否则
 * readfile()函数的大小讲受到限制
 */ 
try{
    $qrList = $download_file;

    if(count($qrList)>0){
        // 1.0 检测提交过来所有文件的大小是否大约1.4GB的容量
        $total_size = 0;
        foreach ($qrList as $val) {
            if(!file_exists($val)){
                exit('该文件'.substr($val,34).'已在服务端删除，请重新更换文件下载');
            }
            $file_size = filesize($val);
            $total_size = $total_size+ $file_size;
            if($total_size>600266407){
                exit('文件内容太大，请更换小文件下载');
            }
        }
        //1.1 提取文件压缩打包
        $filename = 'ZWA_fw-server'.time().\Yii::$app->session['name'].'.zip';
        $zip = new \ZipArchive();
        $zip->open($filename, ZipArchive::OVERWRITE|ZipArchive::CREATE);
        foreach ($qrList as $value) {
            $file_size = filesize($value);
            $fileData = readfile($value);
            if ($fileData) {
                $zip->addFile($value);
            }
            $zip->close();
            set_time_limit(0);
            ini_set('memory_limit', '2500M');
            Header('Content-Type: application/octet-stream');
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: ".filesize($filename));
            Header('Content-Disposition: attachment; filename='.$filename);
            Header('Content-Transfer-Encoding: binary');
            ob_end_clean();
            readfile($filename);
            unlink($filename); //删除文
        }
    }
}catch(\Exception $e){
    return '请重新刷新';
}
