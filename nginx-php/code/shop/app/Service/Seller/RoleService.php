<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/23
 * Time: 17:47
 */

namespace App\Service\Seller;


class RoleService
{
    private $model;
    private $create=FALSE;
    public function __construct(\App\Models\SellerRoleModel $model=NULL) {
        if(!$model){
            $model=new \App\Models\SellerRoleModel();
            $this->create=TRUE;
        }
        $this->model=$model;
        $this->model->status = 1;
        return $this;
    }

    public function setRoleName($roleName){
        $this->model->role_name=$roleName;
        return $this;
    }

    public function setRoleDescr($roleDescr){
        $this->model->role_descr=$roleDescr;
        return $this;
    }

    public function setSellerId($sellerId){
        $this->model->seller_id=$sellerId;
        return $this;
    }

    public function setStatusActive(){
        $this->model->status=\App\Models\SellerRoleModel::statusActive;
        return $this;
    }

    public function setStatusInactive(){
        $this->model->status=\App\Models\SellerRoleModel::statusInactive;
        return $this;
    }

    public function setDelActive(){
        $this->model->del_status=\App\Models\SellerRoleModel::delActive;
        return $this;
    }

    public function setDelInactive(){
        $this->model->del_status=\App\Models\SellerRoleModel::delInactive;
        return $this;
    }

    public function save(){
        $this->model->save();
        return $this->model;
    }
}