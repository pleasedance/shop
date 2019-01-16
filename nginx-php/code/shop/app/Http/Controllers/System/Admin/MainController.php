<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17
 * Time: 17:48
 */

namespace App\Http\Controllers\System\Admin;


class MainController extends BaseController
{
    /**
     * 首页
     */
    public function getIndex()
    {
        $res = [];
        $model = \App\Models\SystemUserModel::paginate(10);
        $res['list'] = $model;
        return \View::make("system/admin/adminlist",$res);
    }

    /**
     * @param int $id
     * @return mixeda
     * 管理员详情
     */
    public function getUser($id=0)
    {
        $res = [];
        $res['user'] = $this->curUser;
        $res['roles'] = \App\Models\SellerRoleModel::where("status",\App\Models\SystemUserModel::statusActive)
            ->get();
        if ($id){
            $model = \App\Models\SystemUserModel::where("status",\App\Models\SystemUserModel::statusActive)
                ->where("id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("system/admin/user",$res);
    }

    /**
     * @return mixed
     * 添加管理员
     */
    public function postUser()
    {
        $request = \Request::all();
        if(empty($request['role_id'])){
            return \ResponseHelper::error("请选择角色",NULL,NULL,500);
            exit;
        }
        $res = [];
        $res['user'] = $this->curUser;
        $server = new \App\Service\System\SystemUserService();
        $server->setStatusActive();
        $server->setPassword($request['password']);
        $server->setLoginId($request['loginid']);
        if($request['role_id']){
            $sellerRoleModel = \App\Models\SellerRoleModel::where("role_id",$request['role_id'])->first();
            $server->setRole($sellerRoleModel);
        }
        $systemUserModel = $server->save();
        if ($systemUserModel){
            return \ResponseHelper::success(["id"=>$systemUserModel->id]);
        }else{
            return \ResponseHelper::error("新增管理员失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * 管理员修改
     */
    public function putUser($id=0)
    {
        $request = \Request::all();
        $res = [];
        $res['user'] = $this->curUser;
        $systemUserModel = \App\Models\SystemUserModel::where("status",\App\Models\SystemUserModel::statusActive)
            ->where("id",$id)
            ->first();
        $server = new \App\Service\System\SystemUserService($systemUserModel);
        $server->setStatusActive();
        $server->setPassword($request['password']);
        $server->setLoginId($request['loginid']);
        if($request['role_id']){
            $sellerRoleModel = \App\Models\SellerRoleModel::where("role_id",$request['role_id'])->first();
            $server->setRole($sellerRoleModel);
        }
        $systemUserModel = $server->save();
        if ($systemUserModel){
            return \ResponseHelper::success(["id"=>$systemUserModel->id]);
        }else{
            return \ResponseHelper::error("修改管理员失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 会员禁用与启用
     */
    public function putUserStat()
    {
        $request = \Request::all();
        $model = \App\Models\SystemUserModel::where("id",$request['id'])->first();
        $server = new \App\Service\System\SystemUserService($model);
        if ($request['todo']){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
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
        return \View::make("system/admin/sellerlist",$res);
    }

    /**
     * @param int $id
     * @return mixed
     * 商户详情
     */
    public function getSeller($id=0)
    {
        $res = [];
        $res['user'] = $this->curUser;
        if ($id){
            $model = \App\Models\SellerUserModel::where("seller_user_id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("system/admin/seller",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 添加商户
     */
    public function postSeller()
    {
        $realname = \Jinput::get("real_name");
        if(!$realname){
            throw new \App\Exceptions\AppException("请先填写商家名");
        }
//        $source = \Jinput::get("source");
//        if(!$source){
//            throw new \App\Exceptions\AppException("请填写商家来源");
//        }
        $province = \Jinput::get("province");
        if(!$province){
            throw new \App\Exceptions\AppException("请填写商家省份");
        }
        $city = \Jinput::get("city");
        if(!$city){
            throw new \App\Exceptions\AppException("请填写商家城市");
        }
        $area = \Jinput::get("area");
        if(!$area){
            throw new \App\Exceptions\AppException("请填写商家区域");
        }
        $phone = \Jinput::get("phone");
        if(!$phone){
            throw new \App\Exceptions\AppException("请填写手机号");
        }
        $loginid = \Jinput::get("loginid");
        if(!$loginid){
            throw new \App\Exceptions\AppException("请填写账号");
        }
        $password = \Jinput::get("password");
        if(!$password){
            throw new \App\Exceptions\AppException("请填写密码");
        }

        \DB::beginTransaction();
        try{
            //检测手机号是否重复
            $mobile_repetition = \App\Models\SellerUserModel::where('phone',$phone)->first()->toArray();
            
            if($mobile_repetition){
                throw new \App\Exceptions\AppException("该手机号已存在！");
            }

            $loginid_repetition = \App\Models\SellerUserModel::where('loginid',$loginid)->first()->toArray();
            
            if($loginid_repetition){
                throw new \App\Exceptions\AppException("该账户已存在！");
            }

            $real_name_repetition = \App\Models\SellerUserModel::where('real_name',$real_name)->first()->toArray();
            
            if($real_name_repetition){
                throw new \App\Exceptions\AppException("该商家已存在！");
            }

            //添加商户信息
            $server = new \App\Service\Seller\MainService();
            $server->setRealname($realname);
//            $server->setSource($source);
            $server->setProvince($province);
            $server->setCity($city);
            $server->setArea($area);
            $sellerModel = $server->save();

            //添加商户账号
            $server = new \App\Service\Seller\SellerUserService();
            $server->setSeller($sellerModel);
            $server->setPassword(\DataBaseHelper::setPassword($password));
            $server->setLoginId($loginid);
            $server->setPhone($phone);
            $server->setSource("wap");
            if (\Jinput::get("sex")){
                $server->setMan();
            }else{
                $server->setWoman();
            }
            $server->save();
            \DB::commit();
            return \ResponseHelper::success();
        }catch(\Exception $e){
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 商家修改
     */
    public function putSeller($id)
    {
        $realname = \Jinput::get("real_name");
        if(!$realname){
            throw new \App\Exceptions\AppException("请先填写商家名");
        }
//        $source = \Jinput::get("source");
//        if(!$source){
//            throw new \App\Exceptions\AppException("请填写商家来源");
//        }
        $province = \Jinput::get("province");
        if(!$province){
            throw new \App\Exceptions\AppException("请填写商家省份");
        }
        $city = \Jinput::get("city");
        if(!$city){
            throw new \App\Exceptions\AppException("请填写商家城市");
        }
        $area = \Jinput::get("area");
        if(!$area){
            throw new \App\Exceptions\AppException("请填写商家区域");
        }
        $phone = \Jinput::get("phone");
        if(!$phone){
            throw new \App\Exceptions\AppException("请填写手机号");
        }
        $loginid = \Jinput::get("loginid");
        if(!$loginid){
            throw new \App\Exceptions\AppException("请填写账号");
        }
        $password = \Jinput::get("password");
        if(!$password){
            throw new \App\Exceptions\AppException("请填写密码");
        }

        \DB::beginTransaction();
        try{
            //修改商户信息
            $model = \App\Models\SellerModel::where("seller_id",$id)
                ->with("user")
                ->first();
            $server = new \App\Service\Seller\MainService($model);
            $server->setRealname($realname);
//            $server->setSource($source);
            $server->setProvince($province);
            $server->setCity($city);
            $server->setArea($area);
            $sellerModel = $server->save();

            //修改商户账号
            $server = new \App\Service\Seller\SellerUserService($model->user);
            $server->setSeller($sellerModel);
            $server->setPassword(\DataBaseHelper::setPassword($password));
            $server->setLoginId($loginid);
            $server->setPhone($phone);
            $server->setSource("wap");
            if (\Jinput::get("sex")){
                $server->setMan();
            }else{
                $server->setWoman();
            }
            $server->save();
            \DB::commit();
            return \ResponseHelper::success();
        }catch(\Exception $e){
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param $id
     * 商家禁用
     */
    public function putSellerStat()
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
     * 角色列表
     */
    public function getRoleList()
    {
        $res = [];
        $model = \App\Models\SellerRoleModel::paginate(10);
        $res['list'] = $model;
        return \View::make("system/admin/rolelist",$res);
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
        return \View::make("system/admin/role",$res);
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
     * 发放给企业明细
     */
    public function getAmountLog()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\MoneyLogModel::where("status",\App\Models\MoneyLogModel::statusRecharge)
            ->where("type",\App\Models\MoneyLogModel::cpTocpRecharge)
            ->with("company")
            ->with("buyer")
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("system/admin/amountlog",$res);
    }

    /**
     * 用户充值明细
     */
    public function getAmountUserLog()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\MoneyLogModel::where("status",\App\Models\MoneyLogModel::statusRecharge)
            ->where("type",\App\Models\MoneyLogModel::userRecharge)
            ->with("company")
            ->with("buyer")
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("system/admin/amountuserlog",$res);
    }
}