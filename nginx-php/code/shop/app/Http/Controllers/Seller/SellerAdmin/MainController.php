<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/30
 * Time: 11:12
 */

namespace App\Http\Controllers\Seller\SellerAdmin;


class MainController extends BaseController
{
    /**
     * @return mixed
     * 首页
     */
    public function getIndex(){
        return \View::make("seller/admin/index");
    }

    /**
     * @return mixed
     * 商户地址详情页
     */
    public function getAddress($id = 0){
        $res = [];
        $res['user'] = $this->curUser;
        if ($id){
            $model = \App\Models\SellerAddressModel::where("id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("seller/admin/address",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 新增商家收货地址
     */
    public function postAddress()
    {
        $receiveName = \Jinput::get("receive_name");
        if(!$receiveName){
            throw new \App\Exceptions\AppException("请填写收货人姓名");
        }
        $receivePhone = \Jinput::get("receive_phone");
        if(!$receivePhone){
            throw new \App\Exceptions\AppException("请填写收货人手机号");
        }
        $receiveAddress = \Jinput::get("receive_address");
        if(!$receiveAddress){
            throw new \App\Exceptions\AppException("请填写收货地址");
        }
        $postNumber = \Jinput::get("post_number");
        if(!$postNumber){
            throw new \App\Exceptions\AppException("请填写邮政编码");
        }
        $province = \Jinput::get("province");
        if(!$province){
            throw new \App\Exceptions\AppException("请填写收货地址所属省份");
        }
        $city = \Jinput::get("city");
        if(!$city){
            throw new \App\Exceptions\AppException("请填写收货地址所属城市");
        }
        $area = \Jinput::get("area");
        if(!$area){
            throw new \App\Exceptions\AppException("请填写收货地址所属区");
        }
        $seller_id = \Jinput::get("seller_id");
        $seller_phone = \Jinput::get("seller_phone");
        $seller_real_name = \Jinput::get("seller_real_name");
        $seller_user_name = \Jinput::get("seller_user_name");

        $server = new \App\Service\Seller\SellerAddressService();
        $server->setReceiveName($receiveName);
        $server->setReceivePhone($receivePhone);
        $server->setReceiveAddress($receiveAddress);
        $server->setPostNumber($postNumber);
        $server->setProvince($province);
        $server->setCity($city);
        $server->setArea($area);
        $server->setSellerId($seller_id);
        $server->setSellerPhone($seller_phone);
        $server->setSellerRealName($seller_real_name);
        $server->setSellerUserName($seller_user_name);
        $sellerAddressModel = $server->save();
        if ($sellerAddressModel){
            return \ResponseHelper::success(["id"=>$sellerAddressModel->id]);
        }else{
            return \ResponseHelper::error("新增商家收货地址失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 修改商家地址
     */
    public function putAddress($id = 0)
    {
        $receiveName = \Jinput::get("receive_name");
        if(!$receiveName){
            throw new \App\Exceptions\AppException("请填写收货人姓名");
        }
        $receivePhone = \Jinput::get("receive_phone");
        if(!$receivePhone){
            throw new \App\Exceptions\AppException("请填写收货人手机号");
        }
        $receiveAddress = \Jinput::get("receive_address");
        if(!$receiveAddress){
            throw new \App\Exceptions\AppException("请填写收货地址");
        }
        $postNumber = \Jinput::get("post_number");
        if(!$postNumber){
            throw new \App\Exceptions\AppException("请填写邮政编码");
        }
        $province = \Jinput::get("province");
        if(!$province){
            throw new \App\Exceptions\AppException("请填写收货地址所属省份");
        }
        $city = \Jinput::get("city");
        if(!$city){
            throw new \App\Exceptions\AppException("请填写收货地址所属城市");
        }
        $area = \Jinput::get("area");
        if(!$area){
            throw new \App\Exceptions\AppException("请填写收货地址所属区");
        }
        $seller_phone = \Jinput::get("seller_phone");
        $seller_real_name = \Jinput::get("seller_real_name");
        $seller_user_name = \Jinput::get("seller_user_name");

        $model = \App\Models\SellerAddressModel::find($id);
        $server = new \App\Service\Seller\SellerAddressService($model);
        $server->setReceiveName($receiveName);
        $server->setReceivePhone($receivePhone);
        $server->setReceiveAddress($receiveAddress);
        $server->setPostNumber($postNumber);
        $server->setProvince($province);
        $server->setCity($city);
        $server->setArea($area);
        $server->setSellerPhone($seller_phone);
        $server->setSellerRealName($seller_real_name);
        $server->setSellerUserName($seller_user_name);
        $sellerAddressModel = $server->save();
        if ($sellerAddressModel){
            return \ResponseHelper::success(["id"=>$sellerAddressModel->id]);
        }else{
            return \ResponseHelper::error("新增商家收货地址失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 商户地址列表
     */
    public function getAddressList(){
        $res = [];
        $model = \App\Models\SellerAddressModel::where("seller_id",$this->curUser->seller_id)
            ->where("del_status",0)
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/addresslist",$res);
    }

    /**
     * 商户管理员列表
     */
    public function getAdminList()
    {
        $res = [];
        $model = \App\Models\SellerUserModel::paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/adminlist",$res);
    }

    /**
     * 角色列表
     */
    public function getRoleList()
    {
        $res = [];
        $model = \App\Models\SellerRoleModel::paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/rolelist",$res);
    }

    /**
     * @param $id
     * 角色详情
     */
    public function getRole($id=0)
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\SellerRoleModel::where("role_id",$id)->first();
        $res['model'] = $model;
        return \View::make("seller/admin/role",$res);
    }

    /**
     * 角色添加
     */
    public function postRole()
    {
        $roleName = \Jinput::get("role_name");
        if(!$roleName){
            throw new \App\Exceptions\AppException("请填写角色名称");
        }
        $roleDescr = \Jinput::get("role_descr");
        $sellerId = \Jinput::get("seller_id");
        $status = \Jinput::get("status");

        $server = new \App\Service\Seller\RoleService();
        $server->setRoleName($roleName);
        $server->setRoleDescr($roleDescr);
        $server->setSellerId($sellerId);
        if ($status){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $role = $server->save();
        if ($role){
            return \ResponseHelper::success(["id"=>$role->role_id]);
        }else{
            return \ResponseHelper::error("新增角色失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 角色修改
     */
    public function putRole($id=0)
    {
        $roleName = \Jinput::get("role_name");
        if(!$roleName){
            throw new \App\Exceptions\AppException("请填写角色名称");
        }
        $roleDescr = \Jinput::get("role_descr");
        $sellerId = \Jinput::get("seller_id");
        $status = \Jinput::get("status");

        $model = \App\Models\SellerRoleModel::where("role_id",$id)->first();
        $server = new \App\Service\Seller\RoleService($model);
        $server->setRoleName($roleName);
        $server->setRoleDescr($roleDescr);
        $server->setSellerId($sellerId);
        if ($status){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $role = $server->save();
        if ($role){
            return \ResponseHelper::success(["id"=>$role->role_id]);
        }else{
            return \ResponseHelper::error("修改角色失败",NULL,NULL,500);
        }
    }

    /**
     * 商家列表
     */
    public function getSellerList()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\SellerModel::paginate(10);
        $res['list'] = $model;
        return \View::make("seller/admin/sellerlist",$res);
    }

    /**
     * @param $id
     * 商家禁用
     */
    public function putSeller()
    {
        $request = \Request::all();
        $model = \App\Models\SellerModel::where("seller_id",$request['id'])->first();
        $server = new \App\Service\Seller\SellerService($model);
        if ($request['todo']){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->seller_id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 评价回复
     */
    public function postReply()
    {
        $request = \Request::all();
        $server = new \App\Service\Api\EvaluationReplyService();
        $server->setContent($request['content']);
        $model = \App\Models\SellerModel::where("seller_id",$this->curUser->seller_id)->first();
        $server->setSeller($model);
        $model = \App\Models\EvaluationModel::where("evaluation_id",$request['evaluation_id'])->first();
        $server->setEvaluation($model);
        $model = $server->save();
        if ($model){
            return \ResponseHelper::success();
        }else{
            return \ResponseHelper::error("回复失败",NULL,NULL,500);
        }
    }
     /**
     * @return mixed
     * 修改收货地址为默认地址
     */
    public function setAddress(){
        $request = \Request::all();
        $model = \App\Models\SellerAddressModel::where("id",$request['id'])->first();
        $server = new \App\Service\Seller\SellerAddressService($model);
        $server->setDefault($request['todo']);
        $model = $server->save();
        if ($model){
            return \ResponseHelper::success();
        }else{
            return \ResponseHelper::error("设置失败！",NULL,NULL,500);
        }
    }
}