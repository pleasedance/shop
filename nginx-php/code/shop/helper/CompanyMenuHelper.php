<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 菜单
 *
 * @author Laperlee
 */
class CompanyMenuHelper {
    
    
    public static function get(App\Models\CompanyUserModel $CompanyUserModel){
//        $menu = App\Data\SellerUserData::getMenu($SellerUserModel);
//        $menus = self::getInvId($menu);
//        print_r($menus);
//        return $menus;
        /**/
        $menu = \Config::get("menu_company");
        $menus = [];
        foreach ($menu as $value){
            $permission = array_get($value,'permission');
            if($permission === FALSE){
                if($CompanyUserModel->role_name == App\Models\CompanyUserModel::roleRoot){
                    $menus[] = $value;
                }
            }elseif($permission){
                if(CompanyPermissionHelper::can($CompanyUserModel, $value['permission'])){
                    $menus[] = $value;
                }
            }else{
                $menus[] = $value;
            }
        }
        return $menus;
    }

    public static function getInvId($data, $pid = 0)
    {
        $arr = [];
        $data = json_decode(json_encode($data),TRUE);
        foreach ($data as $key => $val) {
            if ($val['p_authc_id'] == $pid) {
                $child = self::getInvId($data, $val['authc_id']);
                if($child){
                    $val['data'] = $child;
                }
                $arr[] = $val;
            }

        }
        return $arr;
    }
    
    public static function isActive($data,$code){
        if(array_get($data, "code")==$code){
            return TRUE;
        }
        $items=  array_get($data, "items");
        if($items){
            foreach ($items as $value){
                if(self::isActive($value, $code)){
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
    
    public static function getHref($data){
        return array_get($data, "href","javascript:;");
    }
    
    public static function getName($data){
        return array_get($data, "name");
    }
    
    public static function getIcon($data){
        return array_get($data, "icon");
    }
    
    public static function getItems($data){
        return array_get($data, "items");
    }
    
}
