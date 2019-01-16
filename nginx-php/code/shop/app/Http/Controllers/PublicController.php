<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of PublicController
 *
 * @author Administrator
 */
class PublicController {

    /**
     * 上传单个图片
     */
    public function postImage(){
        $curUser= \SessionHelper::get();
        $file= \FileHelper::saveLocal(\Illuminate\Support\Facades\Input::file("jUploaderFile"), \FileHelper::nameSpaceImage);
        return \ResponseHelper::success(["file"=>$file,"url"=> "https://".\Request::server('HTTP_HOST').$file]);
//        return \ResponseHelper::success(["file"=>$file,"url"=> \FileHelper::getFile($file, \FileHelper::nameSpaceImage)]);//以前的
    }

    /**
     * 上传多个图片
     */
    public function postImages(){
        $curUser= \SessionHelper::get();
        $file= \FileHelper::saveLocal(\Illuminate\Support\Facades\Input::file("file"), \FileHelper::nameSpaceImage);
        return \ResponseHelper::success(["file"=>$file,"url"=> "https://".\Request::server('HTTP_HOST').$file]);
    }

    /**
     * @return mixed
     * 提供前端的上传图片API
     */
    public function postApiImages()
    {
        $file= \FileHelper::saveLocal(\Illuminate\Support\Facades\Input::file("file"), \FileHelper::nameSpaceImage);
        return \ResponseHelper::success(["file"=>$file,"url"=> "https://".\Request::server('HTTP_HOST').$file]);
    }
    
}
