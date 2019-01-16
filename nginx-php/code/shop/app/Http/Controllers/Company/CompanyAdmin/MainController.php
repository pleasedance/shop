<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 15:08
 */

namespace App\Http\Controllers\Company\CompanyAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MainController extends BaseController
{
    /**
     * 添加企业
     */
    public function postAdd()
    {
        $request = \Request::all();
        $server = new \App\Service\Company\CompanyService();
        DB::beginTransaction();
        $server->setName($request['company_name']);
        $server->setStatusActive();
        $companyModel = $server->save();
        if (!$companyModel){
            DB::rollBack();
            return;
        }
        $server = new \App\Service\Company\CompanyUserService();
        $server->setUserName($request['username']);
        $server->setStatusActive();
        $server->setPassword($request['password']);
        $server->setLoginId($request['username']);
        $server->setEmail($request['email']);
        $server->setCompanyId($companyModel);
        if($request['role_id']){
            $companyRoleModel = \App\Models\CompanyRoleModel::where("role_id",$request['role_id'])->first();
            $server->setRole($companyRoleModel);
        }
        $companyUserModel = $server->save();

        if ($companyUserModel){
            DB::commit();
            return \ResponseHelper::success(["id"=>$companyUserModel->sys_user_id]);
        }else{
            DB::rollBack();
            return \ResponseHelper::error("新增企业失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 企业列表
     */
    public function getIndex()
    {
        $res = [];
        $res['user'] = $this->curUser;
        if ($this->curUser->company_id == 1){
            //超级管理员
            $model = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)->paginate(10);
            $res['list'] = $model;
            return \View::make("company/admin/index",$res);
        }else{
            //企业
            $model = \App\Models\CompanyUserModel::where("status",\App\Models\CompanyUserModel::statusActive)
                ->where("company_id",$this->curUser->company_id)
                ->paginate(10);
            $res['list'] = $model;
            return redirect()->action('Company\CompanyAdmin\MainController@getBuyers');
//            return \View::make("company/admin/users",$res);
        }
    }

    /**
     * @return mixed
     * 企业详情
     */
    public function getAdd($id=0)
    {
        $res = [];
        $res['user'] = $this->curUser;
        $res['roles'] = \App\Models\CompanyRoleModel::where("status",\App\Models\CompanyRoleModel::statusActive)
            ->get();
        if ($id){
            $model = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)
            ->where("company_id",$id)
            ->first();
            $res['model'] = $model;
        }
        return \View::make("company/admin/add",$res);
    }

    /**
     * @param int $id
     * 企业修改
     */
    public function putAdd($id=0)
    {
        $request = \Request::all();
        $model = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)
            ->where("company_id",$id)
            ->first();
        $server = new \App\Service\Company\CompanyService($model);
        $server->setName($request['company_name']);
        $companyModel = $server->save();

        if ($companyModel){
            return \ResponseHelper::success(["id"=>$companyModel->company_id]);
        }else{
            return \ResponseHelper::error("修改企业失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * 企业管理员列表
     */
    public function getUsers()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\CompanyUserModel::where("status",\App\Models\CompanyUserModel::statusActive)
            ->where("company_id",$this->curUser->company_id)
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("company/admin/users",$res);
    }

    /**
     * @return mixed
     * 添加管理员
     */
    public function postUser()
    {
        $request = \Request::all();
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)
            ->where("company_id",$this->curUser->company_id)
            ->first();
        $server = new \App\Service\Company\CompanyUserService();
        $server->setUserName($request['username']);
        $server->setStatusActive();
        $server->setPassword($request['password']);
        $server->setLoginId($request['username']);
        $server->setEmail($request['email']);
        $server->setCompanyId($model);
        if($request['role_id']){
            $companyRoleModel = \App\Models\CompanyRoleModel::where("role_id",$request['role_id'])->first();
            $server->setRole($companyRoleModel);
        }
        $companyUserModel = $server->save();
        if ($companyUserModel){
            return \ResponseHelper::success(["id"=>$companyUserModel->sys_user_id]);
        }else{
            return \ResponseHelper::error("新增管理员失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 修改管理员
     */
    public function putUser($id=0)
    {
        $request = \Request::all();
        $res = [];
        $res['user'] = $this->curUser;
        $companyModel = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)
            ->where("company_id",$this->curUser->company_id)
            ->first();
        $companyUserModel = \App\Models\CompanyUserModel::where("status",\App\Models\CompanyUserModel::statusActive)
            ->where("sys_user_id",$id)
            ->first();
        $server = new \App\Service\Company\CompanyUserService($companyUserModel);
        $server->setUserName($request['username']);
        $server->setStatusActive();
        $server->setPassword($request['password']);
        $server->setLoginId($request['username']);
        $server->setEmail($request['email']);
        $server->setCompanyId($companyModel);
        if($request['role_id']){
            $companyRoleModel = \App\Models\CompanyRoleModel::where("role_id",$request['role_id'])->first();
            $server->setRole($companyRoleModel);
        }
        $companyUserModel = $server->save();
        if ($companyUserModel){
            return \ResponseHelper::success(["id"=>$companyUserModel->sys_user_id]);
        }else{
            return \ResponseHelper::error("新增管理员失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * 管理员详情
     */
    public function getUser($id=0)
    {
        $res = [];
        $res['user'] = $this->curUser;
        $res['roles'] = \App\Models\CompanyRoleModel::where("status",\App\Models\CompanyRoleModel::statusActive)
            ->get();
        if ($id){
            $model = \App\Models\CompanyUserModel::where("status",\App\Models\CompanyUserModel::statusActive)
                ->where("sys_user_id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("company/admin/user",$res);
    }

    /**
     * @param $id
     * @return mixed
     * 角色详情
     */
    public function getRole($id=0)
    {
        $res = [];
        $res['user'] = $this->curUser;
        if ($id){
            $model = \App\Models\CompanyRoleModel::where("status",\App\Models\CompanyRoleModel::statusActive)
                ->where("role_id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("company/admin/role",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 新增角色
     */
    public function postRole()
    {
        $request = \Request::all();
        if(!$request['role_name']){
            throw new \App\Exceptions\AppException("角色名称未填写");
        }
        $server = new \App\Service\Company\CompanyRoleService();
        $server->setName($request['role_name']);
        $server->setDescr($request['role_descr']);
        $companyRoleModel = $server->save();
        if ($companyRoleModel){
            return \ResponseHelper::success(["id"=>$companyRoleModel->role_id]);
        }else{
            return \ResponseHelper::error("新增角色失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 修改角色
     */
    public function putRole($id=0)
    {
        $request = \Request::all();
        if(!$request['role_name']){
            throw new \App\Exceptions\AppException("角色名称未填写");
        }
        $model = \App\Models\CompanyRoleModel::where("status",\App\Models\CompanyRoleModel::statusActive)
            ->where("role_id",$id)
            ->first();
        $server = new \App\Service\Company\CompanyRoleService($model);
        $server->setName($request['role_name']);
        $server->setDescr($request['role_descr']);
        $companyRoleModel = $server->save();
        if ($companyRoleModel){
            return \ResponseHelper::success(["id"=>$companyRoleModel->role_id]);
        }else{
            return \ResponseHelper::error("新增角色失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * 角色列表
     */
    public function getRoleList()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\CompanyRoleModel::where("status",\App\Models\CompanyRoleModel::statusActive)
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("company/admin/rolelist",$res);
    }

    /**
     * @return mixed
     * 会员列表
     */
    public function getBuyers()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\BuyerModel::where("company_id",$this->curUser->company_id)
            ->with("depart")
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("company/admin/buyers",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 修改会员
     */
    public function putBuyer($id=0)
    {
        $request = \Request::all();
        if(!$request['loginid']){
            throw new \App\Exceptions\AppException("会员账号未填写");
        }
//        if(!$request['password']){
//            throw new \App\Exceptions\AppException("会员密码未填写");
//        }
        if(!$request['real_name']){
            throw new \App\Exceptions\AppException("会员真实姓名未填写");
        }
        if(!$request['phone']){
            throw new \App\Exceptions\AppException("会员手机号未填写");
        }

        $buyerModel = \App\Models\BuyerModel::where("status",\App\Models\BuyerModel::statusActive)
            ->where("buyer_id",$id)
            ->first();
        $server = new \App\Service\Company\BuyerService($buyerModel);
        $server->setLoginid($request['loginid']);
//        $server->setPassword($request['password']);
        $server->setName($request['real_name']);
        $server->setJobNumber($request['job_number']);
        if ($request['sex']){
            $server->sexWoman();
        }else{
            $server->sexMan();
        }
        $server->setPhone($request['phone']);
        $server->setProvince($request['province']);
        $server->setCity($request['city']);
        $server->setArea($request['area']);
//        $server->setSource($request['source']);
        $server->setWechat($request['wechat_openid']);
        $server->setQQ($request['qq_openid']);
        $companyModel = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)
            ->where("company_id",$this->curUser->company_id)
            ->first();
        $departModel = \App\Models\DepartModel::where("status",\App\Models\DepartModel::statusActive)
            ->where("depart_id",$request['depart_id'])
            ->first();
        $server->setCompany($companyModel);
        $server->setDepart($departModel);
        $buyerModel = $server->save();
        if ($buyerModel){
            return \ResponseHelper::success(["id"=>$buyerModel->buyer_id]);
        }else{
            return \ResponseHelper::error("修改会员失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 新增会员
     */
    public function postBuyer()
    {
        $request = \Request::all();
        if(!$request['loginid']){
            throw new \App\Exceptions\AppException("会员账号未填写");
        }
//        if(!$request['password']){
//            throw new \App\Exceptions\AppException("会员密码未填写");
//        }
        if(!$request['real_name']){
            throw new \App\Exceptions\AppException("会员真实姓名未填写");
        }
        if(!$request['phone']){
            throw new \App\Exceptions\AppException("会员手机号未填写");
        }

        $server = new \App\Service\Company\BuyerService();
        $server->setLoginid($request['loginid']);
//        $server->setPassword($request['password']);
        $server->setName($request['real_name']);
        $server->setJobNumber($request['job_number']);
        if ($request['sex']){
            $server->sexWoman();
        }else{
            $server->sexMan();
        }
        $server->setPhone($request['phone']);
        $server->setProvince($request['province']);
        $server->setCity($request['city']);
        $server->setArea($request['area']);
//        $server->setSource($request['source']);
        $server->setWechat($request['wechat_openid']);
        $server->setQQ($request['qq_openid']);
        $companyModel = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)
            ->where("company_id",$this->curUser->company_id)
            ->first();
        $departModel = \App\Models\DepartModel::where("status",\App\Models\DepartModel::statusActive)
            ->where("depart_id",$request['depart_id'])
            ->first();
        $server->setCompany($companyModel);
        $server->setDepart($departModel);
        $buyerModel = $server->save();
        if ($buyerModel){
            return \ResponseHelper::success(["id"=>$buyerModel->buyer_id]);
        }else{
            return \ResponseHelper::error("新增会员失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * 用户详情
     */
    public function getBuyer($id=0)
    {
        $res = [];
        $res['user'] = $this->curUser;
        $res['depart'] = \App\Models\DepartModel::where("status",\App\Models\DepartModel::statusActive)
            ->where("del_status",\App\Models\DepartModel::delInactive)
            ->where("company_id",$this->curUser->company_id)
            ->get();
        if ($id){
            $model = \App\Models\BuyerModel::where("status",\App\Models\DepartModel::statusActive)
                ->where("buyer_id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("company/admin/buyer",$res);
    }

    /**
     * @param $id
     * 会员禁用与启用
     */
    public function putBuyerStat()
    {
        $request = \Request::all();
        $model = \App\Models\BuyerModel::where("buyer_id",$request['id'])->first();
        $server = new \App\Service\Company\BuyerService($model);
        if ($request['todo']){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->buyer_id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * 部门详情
     */
    public function getDepart($id=0)
    {
        $res = [];
        $res['user'] = $this->curUser;
        $res['depart'] = \App\Models\DepartModel::where("status",\App\Models\DepartModel::statusActive)
            ->where("del_status",\App\Models\DepartModel::delInactive)
            ->whereNotIn('depart_id', [$id])
            ->where("company_id",$this->curUser->company_id)
            ->get();
        if ($id){
            $model = \App\Models\DepartModel::where("status",\App\Models\DepartModel::statusActive)
                ->where("depart_id",$id)
                ->first();
            $res['model'] = $model;
        }
        return \View::make("company/admin/depart",$res);
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 新增部门
     */
    public function postDepart()
    {
        $request = \Request::all();
        if(!$request['depart_name']){
            throw new \App\Exceptions\AppException("部门名称未填写");
        }

        $server = new \App\Service\Company\DepartService();
        $server->setName($request['depart_name']);
        $server->setDescr($request['depart_descr']);
        $server->setParent($request['parent_id']);
        $companyModel = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)
            ->where("company_id",$this->curUser->company_id)
            ->first();
        $server->setCompany($companyModel);
        $departModel = $server->save();
        if ($departModel){
            return \ResponseHelper::success(["id"=>$departModel->depart_id]);
        }else{
            return \ResponseHelper::error("新增部门失败",NULL,NULL,500);
        }
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 部门修改
     */
    public function putDepart($id=0)
    {
        $request = \Request::all();
        if(!$request['depart_name']){
            throw new \App\Exceptions\AppException("部门名称未填写");
        }

        $thisModel = \App\Models\DepartModel::where("depart_id",$id)
            ->first();
        $server = new \App\Service\Company\DepartService($thisModel);
        $server->setName($request['depart_name']);
        $server->setDescr($request['depart_descr']);
        $server->setParent($request['parent_id']);
        $companyModel = \App\Models\CompanyModel::where("status",\App\Models\CompanyModel::statusActive)
            ->where("company_id",$this->curUser->company_id)
            ->first();
        $server->setCompany($companyModel);
        $departModel = $server->save();
        if ($departModel){
            return \ResponseHelper::success(["id"=>$departModel->depart_id]);
        }else{
            return \ResponseHelper::error("新增部门失败",NULL,NULL,500);
        }
    }

    public function getDeparts()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\DepartModel::where("del_status",\App\Models\DepartModel::delInactive)
            ->where("company_id",$this->curUser->company_id)
            ->paginate(10);
        $res['list'] = $model;
        // echo '<pre>';
        // print_r($res['list']);
        // exit;
        return \View::make("company/admin/departs",$res);
    }

    /**
     * @param $id
     * 分类禁用与启用
     */
    public function putDepartStat()
    {
        $request = \Request::all();
        $model = \App\Models\DepartModel::where("depart_id",$request['id'])->first();
        $server = new \App\Service\Company\DepartService($model);
        if ($request['todo']){
            $server->setStatusActive();
        }else{
            $server->setStatusInactive();
        }
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->depart_id]);
        }else{
            return \ResponseHelper::error("修改失败",NULL,NULL,500);
        }
    }

    /**
     * @param $id
     * 分类删除
     */
    public function putDepartDel()
    {
        $request = \Request::all();
        $model = \App\Models\DepartModel::where("depart_id",$request['id'])->first();
        $server = new \App\Service\Company\DepartService($model);
        $server->setDelActive();
        $r = $server->save();
        if ($r){
            return \ResponseHelper::success(["id"=>$r->depart_id]);
        }else{
            return \ResponseHelper::error("删除失败",NULL,NULL,500);
        }
    }

    /**
     * @return mixed
     * @throws \App\Exceptions\AppException
     * 企业充值
     */
    public function postCompanyRecharge()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $request = \Request::all();
//        \Log::info($request);return;
        //金额不能为负数
        if ($request['money'] <= 0){
            throw new \App\Exceptions\AppException("金额必须大于0");
        }
        DB::beginTransaction();
        foreach ($request['company_ids'] as $v){
            try{
                //给企业充值
                $companyModel = \App\Models\CompanyModel::where("company_id",$v)->first();
                $server = new \App\Service\Company\CompanyService($companyModel);
                $server->setMoney($request['money']);
                $server->save();

                //日志新增
                $log = [
                    'company' => $companyModel,
                    'status' => \App\Models\MoneyLogModel::statusRecharge,
                    'type' => \App\Models\MoneyLogModel::cpTocpRecharge,
                    'user_money' => $request['money'],
                    'ip' => \DataBaseHelper::getIp(),
                    'remark' => "充值成功"
                ];
//                    \Log::info($log);
                DB::commit();
                //刷新企业信息缓存
                \App\Data\CompanyUserData::flash($v);
                \App\Data\CompanyUserData::flash($this->curUser->sys_user_id);
                $this->dispatch((new \App\Jobs\Queue($log))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
            }catch (\Exception $e){
                //日志新增
                $log = [
                    'company' => $companyModel,
                    'status' => \App\Models\MoneyLogModel::statusRecharge,
                    'type' => \App\Models\MoneyLogModel::cpTocpRecharge,
                    'user_money' => $request['money'],
                    'ip' => \DataBaseHelper::getIp(),
                    'remark' => "充值失败"
                ];
                $this->dispatch((new \App\Jobs\Queue($log))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
                DB::rollBack();
                return \ResponseHelper::error("充值失败",NULL,NULL,500);
//            throw $e;
            }
        }
        return \ResponseHelper::success();
    }

    /**
     * @return mixed
     * 员工充值
     */
    public function postBuyerRecharge()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $request = \Request::all();
//        \Log::info($request);return;
        //金额不能为负数
        if ($request['money'] <= 0){
            throw new \App\Exceptions\AppException("金额必须大于0");
        }
        $companyModel = \App\Models\CompanyModel::where("company_id", $this->curUser->company_id)->first();
        DB::beginTransaction();
        foreach ($request['buyer_ids'] as $v) {
            try {
                //给员工充值
                $buyerModel = \App\Models\BuyerModel::where("buyer_id", $v)
                    ->with("company")
                    ->first();

                //判断余额是否足够
                if ($buyerModel->company->money < $request['money']) {
                    throw new \App\Exceptions\AppException("余额不足请充值");
                }

                //扣除企业金额
                $companyModel = \App\Models\CompanyModel::where("company_id", $buyerModel->company->company_id)->first();
                $server = new \App\Service\Company\CompanyService($companyModel);
                $server->setMoney(-$request['money']);
                $server->save();

                //充值员工金额
                $server = new \App\Service\Company\BuyerService($buyerModel);
                $server->setMoney($request['money']);
                $server->save();

                //日志新增
                $log = [
                    'status' => \App\Models\MoneyLogModel::statusRecharge,
                    'type' => \App\Models\MoneyLogModel::companyRecharge,
                    'buyer' => $buyerModel,
                    'company' => $companyModel,
                    'ip' => \DataBaseHelper::getIp(),
                    'user_money' => $request['money'],
                    'remark' => "充值成功"
                ];
                DB::commit();
                \App\Data\BuyerData::flash($v);
                \App\Data\CompanyUserData::flash($this->curUser->sys_user_id);
                $this->dispatch((new \App\Jobs\Queue($log))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
            }catch (\Exception $e){
                //日志新增
                $log = [
                    'status' => \App\Models\MoneyLogModel::statusRecharge,
                    'type' => \App\Models\MoneyLogModel::companyRecharge,
                    'buyer' => $buyerModel,
                    'company' => $companyModel,
                    'ip' => \DataBaseHelper::getIp(),
                    'user_money' => $request['money'],
                    'remark' => "充值失败"
                ];
                $this->dispatch((new \App\Jobs\Queue($log))->onConnection(env("QUEUE_DRIVER"))->onQueue(env("RABBITMQ_QUEUE")));
                DB::rollBack();
                return \ResponseHelper::error("充值失败",NULL,NULL,500);
//            throw $e;
            }
        }
        return \ResponseHelper::success();
    }

    /**
     * @return mixed
     * 企业充值明细
     */
    public function getAmountLog()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\MoneyLogModel::where("company_id",$this->curUser->company_id)
            ->where("status",\App\Models\MoneyLogModel::statusRecharge)
            ->where("type",\App\Models\MoneyLogModel::cpTocpRecharge)
            ->with("company")
            ->with("buyer")
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("company/admin/amountlog",$res);
    }

    /**
     * @return mixed
     * 企业发放明细
     */
    public function getAmountUserLog()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $model = \App\Models\MoneyLogModel::where("company_id",$this->curUser->company_id)
            ->where("status",\App\Models\MoneyLogModel::statusRecharge)
            ->where("type",\App\Models\MoneyLogModel::companyRecharge)
            ->with("company")
            ->with("buyer")
            ->paginate(10);
        $res['list'] = $model;
        return \View::make("company/admin/amountuserlog",$res);
    }

    /**
     * @return mixed
     * 二维码注册
     */
    public function getRegistered()
    {
        $res = [];
        $res['user'] = $this->curUser;
        $access_token = \WxHelper::getAccessToken();
        $getWXACodeUnlimitUrl = str_replace(["ACCESS_TOKEN"],[$access_token],config("company.getWXACodeUnlimit"));
        $curl = new \JSocket();
        $curl->setUrl($getWXACodeUnlimitUrl);
        $curl->setRetFormat(\JSocket::retFormatText);
        $curl->setParam("scene","companyid_".$this->curUser->company_id);
        $curl->setTimeout(30);
        $curl->setHeader("Content-Type:application/json");
        $curl->setRequestType(\JSocket::retFormatJson);
        $curl->setMethod(\JSocket::methodPost);
        $curl->exe();
        $r = $curl->getRet();
        $res["registered_img"] = "data:image/png;base64,".base64_encode($r);
        return \View::make("company/admin/registered",$res);
    }
}