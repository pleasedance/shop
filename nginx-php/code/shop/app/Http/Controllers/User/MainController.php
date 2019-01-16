<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\User;

/**
 * Description of MainController
 *
 * @author Administrator
 */
class MainController extends BaseController {
    
    
    public function getIndex(){
        $list= \App\Models\UserModel::orderBy("id","desc")->paginate(20);
        return \View::make("user/main/index",["list"=>$list]);
    }
    
    public function postImport(){
        $curUser= \SessionHelper::get();
        $file= \FileHelper::save(\Illuminate\Support\Facades\Input::file("jUploaderFile"), \FileHelper::nameSpaceExcel);
        $server=new \App\Service\Import\MainService();
        $server->setFile($file);
        $server->setModule(\App\Models\ImportModel::moduleUser);
        $server->setAdmin($curUser);
        \DB::beginTransaction();
        try {
            $server->save();
            \DB::commit();
        } catch (\Exception $exc) {
            \DB::rollback();
            throw $exc;
        }
        return \ResponseHelper::success();
    }
    
}
