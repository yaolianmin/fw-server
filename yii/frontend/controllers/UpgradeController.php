<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use frontend\models\Common;
use frontend\models\Log;
use frontend\models\Upgrade;

/**
 * 模块：网站升级页面
 * 功能：使用shell脚本，实现代码与数据库的更换
 * 说明：1）Yii::t()函数的翻译请查找\yii\vendor\yiisoft\yii2\messages\zh-CN 目录
 *       里面的含有所有的翻译中文语言
 *      2）此模块为升级网站操作，升级的源码包名称必须大于上一版本名称
 *         Vx.x.x.x.tar.gz格式结尾的 例如: V1.0.0.1.tar.gz
 *      3）
 *
 */
class UpgradeController extends Controller{

    //升级页面显示
    public function actionUpgrade(){
        //判断是否存在session用户,没有则返回登陆页面
        if(!isset(Yii::$app->session['name'])){
           return $this->redirect(['login/quit']);  
        }
        //判断是否是语言切换提交的内容
        if(Yii::$app->request->isGet){
            $language = Yii::$app->request->get('lang'); 
            $result = Common::change_language($language);
            if($result == 'success'){
                return $this->redirect(['upgrade/upgrade']);
            }
        }

        $history_ver = Upgrade::find_history_version(); //搜索所有历史版本
        $version_now = Upgrade::find_now_version();//搜索当前最新版本
        //备份操作
        if(Yii::$app->request->isGet){   
            $backups = Yii::$app->request->get('backups');
            if($backups == 'backups'){
                $backups = Upgrade::backups_db();
            }
        }  
        //升级操作
        $action = Yii::$app->request->post();
        if($action){
            if($_FILES['yuanmabao']['name']){
                // 1.0 检测这次上传的源码包名称是否已存在
                $upload_path = '/var/www/'.$_FILES['yuanmabao']['name'];
                if(file_exists($upload_path)){
                    $infor = Yii::t('yii','The source package name has already existed, please update the latest version');
                }
                // 1.1 检测这次上传的源码包格式
                $hou_zhui_ming= substr($_FILES['yuanmabao']['name'], -6);
                if($hou_zhui_ming !='tar.gz'){
                    $infor = Yii::t('yii','Please upload the compressed package in tar.gz format');
                }
                // 1.2 检测版本是否比这次的大 上传的源码包命名行必须是Vx.x.x.x.tar.gz格式结尾的 例如: V1.0.0.1.tar.gz
                $now_version = Upgrade::find()->select('version')->where(['statue'=>1])->asArray()->one();
                $now_version = substr($now_version['version'], 1);
                $upgrade_version = substr($_FILES['yuanmabao']['name'],-14,7);
                if($now_version > $upgrade_version){
                     $infor = Yii::t('yii','Cannot upgrade previous versions');
                }
                if(isset($infor)&&$infor){
                     return $this->renderpartial('upgrade',[
                                                 'history_ver'=>$history_ver,
                                                 'version_now'=>$version_now,
                                                 'infor'=>$infor,
                                                 'file_name'=>$_FILES['yuanmabao']['name']
                                            ]);
                }
                // 1.3 执行 上传 升级脚本   每次升级时升级的脚本名必须固定 为upgrade.sh 存放于/var/www/fw-server/Upgrade_version_package/ 下
                exec('chmod -R 777 /var/www'); // 赋予/var/www 的全部权限
                move_uploaded_file($_FILES["yuanmabao"]["tmp_name"],$upload_path); 
                exec('cd /var/www;tar -zvxf /var/www/'.$_FILES['yuanmabao']['name']); //切换至www目录下，并解压源码包 
                exec('sh /var/www/fw-server/Upgrade_version_package/upgrade.sh'); // 执行升级的脚本 updrade.sh
                Log::add_log(1,9,'update','fw-server system'); // 添加一条升级日志
                return $this->redirect(['upgrade/gohome']); //返回登录页面
            }else{
                $infor = Yii::t('yii','Please upload the source package and upgrade');
                return $this->renderpartial('upgrade',['history_ver'=>$history_ver,'version_now'=>$version_now,'infor'=>$infor]);
            } 
        }
        return $this->renderpartial('upgrade',['history_ver'=>$history_ver,'version_now'=>$version_now]);
    }
    

    //返回主页的功能
    public function actionGohome(){
        
        return $this->renderpartial('gohome');
    }


}

