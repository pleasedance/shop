<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 18:30
 */

class SystemPermissionHelper
{
    const user="user";    //企业用户
//    const user="user";    //流量管理


    public static function get(){
        return [
            self::user=>"普通用户",
//            self::user=>"流量管理",
        ];
    }

    public static function getCodeByName($code){
        $name=self::get();
        return array_get($name,$code,"未知权限");
    }

    /**
     * 判断是否有权限
     * @param App\Models\SystemUserModel $model  管理员对象
     * @param type $code    权限编码
     * @return boolean
     */
    public static function can(App\Models\SystemUserModel $model, $code){
        if($model->role_name == App\Models\SystemUserModel::roleRoot){
            return TRUE;
        }
        if ($model->role_name == $code){
            return TRUE;
        }
//        $roleModel= App\Data\CompanyUserData::info($model->sys_user_id);
//        if($roleModel->role_name && ($code==$roleModel->role_name)){
//            return TRUE;
//        }
//        if($roleModel->role_name && in_array($code, $roleModel->role_name)){
//            return TRUE;
//        }
        return FALSE;
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