<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PermissionHelper
 *
 * @author Administrator
 */
class PermissionHelper {
    const seller="seller";    //商户管理
//    const user="user";    //流量管理
    const sellerOrder="sellerOrder";    //商户订单
    
    
    public static function get(){
        return [
            self::seller=>"商户管理",
//            self::user=>"流量管理",
            self::sellerOrder=>"商户订单",
        ];
    }
    
    public static function getCodeByName($code){
        $name=self::get();
        return array_get($name,$code,"未知权限");
    }
    
    /**
     * 判断是否有权限
     * @param App\Models\AdminModel $model  管理员对象
     * @param type $code    权限编码
     * @return boolean
     */
    public static function can(App\Models\SellerUserModel $model, $code){
//        if($model->role_name == App\Models\SellerUserModel::roleRoot){
//            return TRUE;
//        }
//        $roleModel= App\Data\SellerRoleData::info($model->role_name);
//        if($roleModel->role_name && ($code==$roleModel->role_name)){
//            return TRUE;
//        }
//        if($roleModel->role_name && in_array($code, $roleModel->role_name)){
//            return TRUE;
//        }
        return TRUE;
    }
    
    private static $roleList=[];
    /**
     * 根据权限获取角色列表
     * @param type $code 权限编号
     * @return array
     */
    public static function getRoleByCode($code){
        if(isset(self::$roleList[$code])){
            return self::$roleList[$code];
        }
        $roles= App\Data\AdminRoleData::all();
        self::$roleList[$code]=[];
        if($roles->toArray()){
            foreach($roles as $roleModel){
                if($roleModel->permission && in_array($code, $roleModel->permission)){
                    self::$roleList[$code][]=$roleModel;
                }
            }
        }
        return self::$roleList[$code];
    }
    
    private static $adminList=[];
    /**
     * 根据权限编码获取所有管理员
     * @param type $code 权限编号
     * @var type 
     */
    public static function getAdminByCode($code){
        if(isset(self::$adminList[$code])){
            return self::$adminList[$code];
        }
        $rolesList=self::getRoleByCode($code);
        $roleCodes=[App\Models\AdminModel::roleRoot];
        foreach ($rolesList as $roleModel){
            $roleCodes[]=$roleModel->code;
        }
        $result=App\Models\AdminModel::whereIn("role",$roleCodes)->get();
        if($result->toArray()){
            foreach ($result as $adminModel){
                self::$adminList[$code][]=$adminModel;
            }
        }
        return self::$adminList;
    }
    
    
    
}
