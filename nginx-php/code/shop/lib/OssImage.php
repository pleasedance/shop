<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OssImage
 *
 * @author Administrator
 */
class OssImage {
    
    const limitTrue=1;                  //指定当目标缩略图大于原图时处理
    const limitFalse=0;                 //指定当目标缩略图大于原图时不处理
    
    const resizeLfit="lfit";            //等比缩放，限制在设定在指定w与h的矩形内的最大图片
    const resizeMfit="mfit";            //等比缩放，延伸出指定w与h的矩形框外的最小图片。
    const resizeFill="fill";            //固定宽高，将延伸出指定w与h的矩形框外的最小图片进行居中裁剪。
    const resizePad="pad";            //固定宽高，缩略填充
    const resizeFixed="fixed";        //固定宽高，强制缩略
    
    const formatJpg="jpg";          //png格式
    const formatPng="png";          //png格式
    const formatWebp="webp";          //webp格式
    const formatBmp="bmp";          //bmp格式
    const formatGif="gif";          //gif格式
    
    
    private $url;               //图片基础地质
    private $resize;            //缩放方式
    private $circle;            //内切圆
    private $roundedCorners;        //圆角矩形
    private $format;            //格式
    private $waterMark;         //水印
    
    /**
     * 设置裁剪尺寸
     * @param type $m
     * @param type $w
     * @param type $h
     * @param type $limit
     * @param type $color
     * @return \OssImage
     */
    public function setResize($m=NULL,$w=NULL,$h=NULL,$limit=NULL,$color=NULL){
        $this->resize=[
            "m"=>$m,
            "w"=>$w,
            "h"=>$h,
            "limit"=>$limit,
            "color"=>$color,
        ];
        return $this;
    }
    
    /**
     * 设置内切圆
     */
    public function setCircle($r){
        $this->circle=[
            "r"=>$r,
        ];
        return $this;
    }
    
    /**
     * 设置格式
     */
    public function setFormat($format){
        $this->format=[
            $format
        ];
        return $this;
    }
    
    /**
     * 设置圆角矩形
     */
    public function setRoundedCorners($r){
        $this->roundedCorners=[
            "r"=>$r,
        ];
        return $this;
    }
    
    public function setWatermark($object,$x,$y,$t=100){
        $object=$object->getImage();
        $object=trim($object,"/");
        $this->waterMark[]=[
            "image"=>DataBaseHelper::urlsafe_b64encode($object),
            "x"=>$x,
            "y"=>$y,
            "t"=>$t,
        ];
        return $this;
    }
    
    public function setUrl($url){
        $this->url=$url;
        return $this;
    }
    
    /**
     * 获取最终图片地址
     * @param type $url
     * @return string
     */
    public function getImage($url=NULL){
        if(!$url){
            $url=$this->url;
            if(!$url){
                return NULL;
            }
        }
        $image=$url;
        
        $query=[];
        if($this->waterMark){           //水印
            foreach ($this->waterMark as $waterMark){
                $query[]=implode(",", $this->setOpt("watermark",$waterMark));
            }
        }
        if($this->resize){      //配置裁剪
            $query[]=implode(",", $this->setOpt("resize",$this->resize));
        }
        if($this->circle){          //配置内切圆
            $query[]=implode(",", $this->setOpt("circle",$this->circle));
        }
        if($this->roundedCorners){          //配置内切圆
            $query[]=implode(",", $this->setOpt("rounded-corners",$this->roundedCorners));
        }
        if($this->format){          //配置内切圆
            $query[]=implode(",", $this->setOpt("format",$this->format,FALSE));
        }
        
        if($query){
            $image.="?x-oss-process=image".implode("", $query);
        }
        return $image;
    }
    
    /**
     * 参数配置
     * @param type $key
     * @param type $param
     * @return string
     */
    private function setOpt($key,$param,$keys=TRUE){
        $query=[];
        if($param){
            $query[]="/".$key;
            foreach ($param as $key=>$value){
                if(!is_null($value)){
                    if($keys){
                        $query[]=$key."_".$value;
                    }else{
                        $query[]=$value;
                    }
                }
            }
        }
        return $query;
    }
    
    
}
