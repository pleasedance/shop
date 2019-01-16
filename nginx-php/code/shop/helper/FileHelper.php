<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageHelper
 *
 * @author Administrator
 */
class FileHelper {
    const nameSpaceImage="image";          //图片
    const nameSpaceAvatar="avatar";        //头像
    const nameSpaceExcel="excel";        //excel
    
    
    /**
     * 从网络下载文件
     * @param type $image
     * @return type
     */
    public static function downloadImage($image,$nameSpace){
        if(!$image){
            return "";
        }
        $parseUrl=parse_url($image);
        if(!isset($parseUrl['host'])){
            return "";
        }
        $avatarFileName="";
        $imageContent=NULL;
        $time=1;
        while (!$imageContent && $time<3){
            $imageContent=SocketHelper::request($image);
            $time++;
        }
        if($imageContent){
            $avatarFileName=self::saveFileByStr($imageContent, "jpg",$nameSpace);
        }
        return $avatarFileName;
    }
    
    /**
     * 是否是图片判断
     * @param type $file
     * @return type\
     */
    public static function isImage($file){
        $ext=$file->getClientOriginalExtension();
        return in_array(strtolower($ext),array(
            "jpg","jpeg",'png','gif'
        ));
    }
    
    /**
     * 保存文件
     * @param type $file        文件对象
     * @param type $dsFile      物理地址
     * @params type $fileName       文件名
     */
    private static function saveDH($file,$dir,$fileName){
        try {
            $file->move($dir,$fileName);
        } catch (Exception $ex) {
            throw new ServerExp("文件保存失败！请稍后重试");
        }
    }
    
    /**
     * 保存文件到OSS系统
     * @param type $fileName
     * @param type $nameSpace
     */
    private static function saveOSS($fileName,$nameSpace){
        try {
            $ossClient=new OssClient($nameSpace);
            $object=self::getFilePath($fileName,$nameSpace)."/".$fileName;
            $file=self::getFileHDPath($fileName,$nameSpace)."/".$fileName;
            $ossClient->upload(trim($object,"/"), $file);
        } catch (Exception $ex) {
            throw new ServerExp("文件传送失败！请稍后重试");
        }
    }
    
    /**
     * 保存文件
     * @param type $srcfile     源文件对象
     * @param type $nameSpace   文件区域命名
     * @return string           文件名称
     */
    public static function save($srcfile,$nameSpace){
        $fileName=self::bringFileName($srcfile);
        $dir=self::getFileHDPath($fileName,$nameSpace);         //获取物理路径
        self::saveDH($srcfile, $dir, $fileName);
        switch ($nameSpace){
            case self::nameSpaceImage:
            case self::nameSpaceAvatar:
                self::saveOSS($fileName, $nameSpace);           //上传阿里云OSS
                break;
        }
        
        
        return $fileName;
    }
    
        
    /**
     * base64格式保存为图片
     * @param type $base64Data
     * @return boolean|string
     */
    public static function base64ToImage($base64Data,$ext="png",$nameSpace){
        $fileName=self::bringFileName($ext);
        $imageData=base64_decode( $base64Data );
        self::saveImageByStr($imageData, $fileName,$nameSpace);
        self::saveOSS($fileName, $nameSpace);
        return $fileName;
    }
    
    /**
     * 保存数据到文件
     * @param type $str
     * @param type $ext
     * @param type $nameSpace
     */
    public static function saveFileByStr($str,$ext,$nameSpace){
        $fileName=self::bringFileName($ext);
        $dir=self::getFileHDPath($fileName,$nameSpace);
        if(!file_put_contents($dir."/".$fileName, $str)){
            throw new ServerExp("文件传送失败！请稍后重试");
        }
        switch ($ext){
            case "amr";
                $ossFile=str_replace("amr","mp3",$fileName);
                $command = "/usr/local/bin/ffmpeg -i ".$dir."/".$fileName." ".$dir."/".$ossFile;
                system($command,$error);
            break;
            default :
                $ossFile=$fileName;
            break;
        }
        self::saveOSS($ossFile, $nameSpace);
        return $ossFile;
    }
    
    /**
     * 保存字符串到图片文件
     * @param type $str
     * @param type $fileName
     * @throws ServerExp
     */
    public static function saveImageByStr($str,$fileName,$nameSpace){
        $dir=self::getFileHDPath($fileName,$nameSpace);
        if(!file_put_contents($dir."/".$fileName, $str)){
            throw new ServerExp("文件传送失败！请稍后重试");
        }
    }
    
    
    /**
     * 获取文件地址
     * @param type $file
     * @param type $size
     * @param type $default
     * @return type
     */
    public static function getFile($file,$nameSpace){
        if(!$file){
            if($nameSpace==FileHelper::nameSpaceAvatar){
                $file="1494324911Q2kA.png";
            }else{
                return "";
            }
        }
        $url=Config::get("qiniu.domain").self::getFilePath($file,$nameSpace)."/".$file;
        return $url;
    }
    
    /**
     * 生成一个文件名 用来添加文件的时候用
     * @param type $file        文件对象
     */
    public static function bringFileName($file){
        return time() . str_random(4) . "." . (is_object($file) ? $file->getClientOriginalExtension() : $file);
    }
    
    /**
     * 根据文件名获取文件所在目录访问路径
     * @param type $file
     */
    public static function getFilePath($file,$type){
        $dir=self::getFileDir($file);
        return "/upload/".$type."/".$dir;
    }


    /**
     * 根据文件名获取文件所在目录文件夹名称
     * @param type $file 文件名 1405144154JSGT.jpg
     * @return type     201606
     */
    private static function getFileDir($file){
        $timeStamp=self::getFileTimeStamp($file);
        return @date("Ym",$timeStamp);
    }
    
    /**
     * 根据文件名获取文件时间戳
     * @param type $file 文件名 1405144154JSGT.jpg
     * @return type     返回时间戳
     */
    private static function getFileTimeStamp($file){
        return substr($file,0,10);
    }
    
    
    /**
     * 获取文件物理路径
     * @param type $file
     */
    public static function getFileHDPath($file,$nameSpace){
        $dir=storage_path(trim(self::getFilePath($file,$nameSpace),"/"));
        if(!is_dir($dir)){
            mkdir($dir);
        }
        return $dir;
    }
    
    /**
     * 获取图片主色调的RGB格式
     * @param type $file
     */
    public static function getImageMainRGBColor($file){
        $result=  SocketHelper::request($file."@imageAve");
        if(!$result){
            return NULL;
        }
        $result=  json_decode($result,TRUE);
        $rgb=  array_get($result,"RGB");
        return "#".substr($rgb, 2,6);
    }
    
    public static function toLocal($file,$namespace){
        $imageFile=FileHelper::getFileHDPath($file, $namespace)."/".$file;
        if(!file_exists($imageFile)){
            $imageContent=SocketHelper::request(FileHelper::getFile($file, $namespace));
            if(!$imageContent){
                throw new ServerExp("媒体文件不存在");
            }
            file_put_contents($imageFile, $imageContent);
        }
        return $imageFile;
    }
    
    public static function createQr($string,$size=160){
        $fileName=self::bringFileName("png");
        $dir=self::getFileHDPath($fileName,FileHelper::nameSpaceImage);
        QrHelper::create($string, $dir."/".$fileName, $size);
        $ossFile=$fileName;
        self::saveOSS($ossFile, FileHelper::nameSpaceImage);
        return $ossFile;
    }
    
    public static function readXslx($file){
        $list=[];
        $header=[];
        try {
            $inputFileType = \PHPExcel_IOFactory::identify($file);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($file);
        } catch (\Exception $e) {
            throw new App\Exceptions\AppException("failed");
        }
        $sheet = $objPHPExcel->getSheet();
        $hightestRow = $sheet->getHighestRow();
        $hightestCoolum = $sheet->getHighestColumn();
        for ($row = 1; $row <= $hightestRow; $row++) {
            $rowData = $sheet->rangeToArray("A" . $row . ":" . $hightestCoolum . $row , NULL, true, False);
            if($rowData){
                $rowData=$rowData[0];
                if($row==1){
                    foreach ($rowData as $value){
                        $header[]=$value;
                    }
                }else{
                    $info=[];
                    foreach ($header as $key=>$value){
                        if(isset($rowData[$key])){
                            $info[$value]=$rowData[$key];
                        }
                    }
                    if($info){
                        $list[]=$info;
                    }
                }
            }
        }
        return $list;
    }

    /**
     * 保存文件到本地
     * @author chenyihua
     * @param type $srcfile     源文件对象
     * @param type $nameSpace   文件区域命名
     * @return string           文件名称
     */
    public static function saveLocal($srcfile,$nameSpace){
        $fileName=self::bringFileName($srcfile);
        $dir = self::getFileDir($fileName);
        $rDir = $dir =  "/uploads/".$nameSpace."/".$dir;
        $dir=public_path(trim($dir,"/"));//获取物理路径
        if(!is_dir($dir)){
            mkdir($dir);
        }
        self::saveDH($srcfile, $dir, $fileName);
        return $rDir."/".$fileName;
    }
}
