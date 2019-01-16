<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of ImportController
 *
 * @author Administrator
 */
class ImportController extends BaseController {
    
    public function getIndex(){
        $module= \Jinput::get("module", \App\Models\ImportModel::moduleUser);
        $curUser= \SessionHelper::get();
        $list=\App\Models\ImportModel::where("admin_id",$curUser->id)->where("module",$module)->orderBy("id","desc")->paginate(20);
        return \View::make("import/index",["list"=>$list,"module"=>$module]);
    }
    
    public function getDownload(){
        $id= \Jinput::get("id");
        $curUser= \SessionHelper::get();
        $model=\App\Models\ImportModel::where("admin_id",$curUser->id)->find($id);
        $file= \FileHelper::getFileHDPath($model->file, \FileHelper::nameSpaceExcel)."/".$model->file;
        try {
            return \ResponseHelper::download($file,"导入文件(".$model->created_at.").xlsx");
        } catch (\Exception $exc) {
            throw new \App\Exceptions\AppException("文件找不到");
        }

    }
    
}
