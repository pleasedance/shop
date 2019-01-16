<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeller extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 商家表
         */
        if(!Schema::hasTable('seller')){
            Schema::create('seller', function (Blueprint $table) {
                $table->increments('seller_id')->comment("商家ID");
                $table->string('real_name')->comment("商家名");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->string('source')->nullable()->comment("商家来源");
                $table->string('province')->nullable()->comment("商家所属省份");
                $table->string('city')->nullable()->comment("商家所属城市");
                $table->string('area')->nullable()->comment("商家所属区域");
//                $table->timestamps();
                $table->dateTime('created_at');
                $table->dateTime('updated_at');
                $table->index("created_at");
            });
        }

        /**
         * 系统管理员表
         */
        if(!Schema::hasTable('system_user')){
            Schema::create('system_user', function (Blueprint $table) {
                $table->increments('id')->comment("系统管理员ID");
                $table->string('loginid')->comment("系统管理员名");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->string('password')->comment("密码");
//                $table->string('email')->nullable()->comment("邮箱地址");
//                $table->string('picture_url')->nullable()->comment("图片地址");
//                $table->integer('dept_id')->comment("所属部门ID")->default(0);
//                $table->integer('company_id')->comment("企业ID")->default(0);
                $table->integer('role_id')->comment("角色ID【默认0超级管理员】")->default(0);
                $table->string('role_name')->comment("角色名称");
//                $table->string('create_remake')->nullable()->comment("备注");
                $table->dateTime('created_at')->comment("系统管理员创建时间");
                $table->dateTime('updated_at')->comment("系统管理员最近修改信息时间");
//                $table->timestamps();
                $table->unique("loginid");
            });
        }

        /**
         * 商家管理员信息表
         */
        if(!Schema::hasTable('seller_user')){
            Schema::create('seller_user', function (Blueprint $table) {
                $table->increments('seller_user_id')->comment("商家管理员ID");
                $table->integer('seller_id')->comment("商家ID");
                $table->string('real_name')->comment("商家管理员名");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->string('password')->nullable()->comment("密码");
                $table->string('loginid')->nullable()->comment("登录账号");
                $table->string('phone')->comment("商家管理员手机号【默认0】");
                $table->string('source')->nullable()->comment("商家管理员来源");
                $table->tinyInteger('sex')->nullable()->comment("商家管理员性别【0:男1:女2:保密，默认0】")->default(0);
//                $table->timestamps();
                $table->dateTime('created_at')->comment("商家管理员创建时间");
                $table->dateTime('updated_at')->comment("商家管理员最近修改信息时间");
                $table->index("created_at");
                $table->unique("phone");
                $table->unique("loginid");
                $table->unique("real_name");
            });
        }

        /**
         * 商家收货地址表
         */
        if(!Schema::hasTable('seller_address')){
            Schema::create('seller_address', function (Blueprint $table) {
                $table->increments('id')->comment("收货地址ID");
                $table->integer('seller_id')->comment("收货地址关联商家ID");
                $table->string('seller_phone')->nullable()->comment("商家电话");
                $table->string('seller_real_name')->nullable()->comment("商家真实姓名");
                $table->string('seller_user_name')->nullable()->comment("商家用户名");
                $table->string('receive_name')->nullable()->comment("收货人姓名");
                $table->string('receive_phone')->nullable()->comment("收货人手机号");
                $table->string('receive_address')->nullable()->comment("收货地址");
                $table->string('post_number')->nullable()->comment("邮政编码")->default(0);
                $table->string('province')->nullable()->comment("收货地址所属省份")->default(0);
                $table->string('city')->nullable()->comment("收货地址所属城市")->default(0);
                $table->string('area')->nullable()->comment("收货地址所属区")->default(0);
                $table->tinyInteger('is_default')->nullable()->comment("是否为默认地址【0:否1:是，默认0】")->default(0);
                $table->tinyInteger('del_status')->nullable()->comment("是否删除【0未删除1已删除，默认0】")->default(0);
//                $table->timestamps();
                $table->index("seller_phone");
                $table->index("seller_user_name");
                $table->index("receive_phone");
            });
        }

        /**
         * 运费模板表
         */
        if(!Schema::hasTable('seller_fare_template')){
            Schema::create('seller_fare_template', function (Blueprint $table) {
                $table->increments('tpl_id')->comment("运费模板ID");
                $table->string('tpl_name')->comment("运费模板名称");
                $table->string('address')->nullable()->comment("宝贝地址");
                $table->dateTime('send_time')->nullable()->comment("发货时间");
                $table->tinyInteger('exemption_status')->comment("是否包邮【0:自定义运费1:卖家承担运费，默认0】")->default(0);
                $table->tinyInteger('pricing_model_type')->comment("计价方式【0按件计费1按重量计费2按体积，默认0】")->default(0);
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->tinyInteger('requirement_status')->comment("是否指定条件包邮【0:否1:是，默认0】")->default(0);
                $table->string('del_status')->comment("是否删除【0未删除1已删除，默认0】")->default(0);
                $table->string('seller_id')->nullable()->comment("商家ID");
                $table->dateTime('created_at')->comment("商家运费模板创建时间");
                $table->dateTime('updated_at')->comment("商家运费模板最近修改信息时间");
//                $table->timestamps();
                $table->index("seller_id");
                $table->index("created_at");
            });
        }

        /**
         * 包邮条件表
         */
        if(!Schema::hasTable('seller_incl_postage_proviso')){
            Schema::create('seller_incl_postage_proviso', function (Blueprint $table) {
                $table->increments('id')->comment("包邮条件ID");
                $table->integer('tpl_id')->comment("包邮条件关联运费模板");
                $table->string('area')->nullable()->comment("包邮地区");
                $table->integer('num')->nullable()->comment("包邮件数");
                $table->decimal('weight',8,2)->nullable()->comment("包邮重量");
                $table->decimal('volume',8,2)->nullable()->comment("包邮体积");
                $table->decimal('money',8,2)->nullable()->comment("包邮金额");
                $table->dateTime('created_at')->comment("包邮条件创建时间");
//                $table->timestamps();
                $table->index("created_at");
            });
        }

        /**
         * 运送方式表
         */
        if(!Schema::hasTable('seller_carry_mode')){
            Schema::create('seller_carry_mode', function (Blueprint $table) {
                $table->increments('transfer_id')->comment("运送方式ID");
                $table->integer('tpl_id')->comment("运送方式关联运费模板");
                $table->string('area')->comment("运送地区");
                $table->decimal('basics_weight')->nullable()->comment("首重");
                $table->integer('basics_number')->nullable()->comment("首件");
                $table->decimal('basics_volume',8,2)->nullable()->comment("首体积");
                $table->decimal('basics_price',8,2)->comment("首费");
                $table->decimal('extra_weight',8,2)->nullable()->comment("续重");
                $table->integer('extra_number')->nullable()->comment("续件");
                $table->decimal('extra_volume',8,2)->nullable()->comment("续体积");
                $table->decimal('extra_price',8,2)->comment("续费");
                $table->tinyInteger('transfer_type')->comment("运送方式【0:快递1:EMS2:平邮，默认0】")->default(0);
                $table->tinyInteger('default_status')->comment("是否默认【0:否1:是，默认1】")->default(1);
                $table->dateTime('created_at')->comment("运送方式创建时间");
//                $table->timestamps();
                $table->index("created_at");
            });
        }

        /**
         * 权限信息表
         */
        if(!Schema::hasTable('seller_authentication')){
            Schema::create('seller_authentication', function (Blueprint $table) {
                $table->increments('authc_id')->comment("权限ID");
                $table->integer('p_authc_id')->comment("父权限ID");
//                $table->string('group_name')->comment("权限组名称");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->string('authc_name')->nullable()->comment("权限名称");
                $table->string('authc_url')->nullable()->comment("权限url");
                $table->integer('seller_id')->comment("商家ID");
                $table->integer('role_id')->comment("角色ID");
                $table->dateTime('created_at')->comment("权限信息创建时间");
                $table->dateTime('updated_at')->comment("权限信息最近修改信息时间");
//                $table->timestamps();
                $table->index("status");
            });
        }

        /**
         * 角色信息表
         */
        if(!Schema::hasTable('seller_role')){
            Schema::create('seller_role', function (Blueprint $table) {
                $table->increments('role_id')->comment("角色ID");
                $table->string('role_name')->comment("角色名称");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->string('role_descr')->nullable()->comment("角色描述");
//                $table->integer('members_num')->comment("成员人数");
                $table->string('seller_id')->nullable()->comment("商家ID");
                $table->string('del_status')->comment("删除标记【0:未删除1:删除】")->default(0);
                $table->dateTime('created_at')->comment("角色信息创建时间");
                $table->dateTime('updated_at')->comment("角色信息最近修改信息时间");
//                $table->timestamps();
                $table->index("role_name");
            });
        }

        /**
         * 系统配置信息表
         */
        if(!Schema::hasTable('seller_config')){
            Schema::create('seller_config', function (Blueprint $table) {
                $table->increments('config_id')->comment("系统配置信息ID");
//                $table->string('config_group')->comment("配置组");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->tinyInteger('del_status')->comment("状态【0:未删除1:已删除，默认0】")->default(0);
                $table->string('config_item')->nullable()->comment("配置项名称");
                $table->string('config_value')->comment("配置项value");
                $table->integer('sort')->comment("排序设置")->default(1);
                $table->integer('seller_id')->comment("商家ID");
                $table->string('remark')->nullable()->comment("备注");
                $table->dateTime('created_at')->comment("系统配置信息创建时间");
                $table->dateTime('updated_at')->comment("系统配置信息最近修改信息时间");
//                $table->timestamps();
                $table->index("status");
            });
        }

        /**
         * 管理员权限表
         */
//        if(!Schema::hasTable('seller_own_authentication')){
//            Schema::create('seller_own_authentication', function (Blueprint $table) {
//                $table->increments('user_authc_id')->comment("管理员权限ID");
//                $table->string('authc_id')->comment("权限ID")->default(0);
//                $table->tinyInteger('role_id')->comment("角色ID")->default(0);
//                $table->string('seller_user_id')->comment("商家管理员ID")->default(0);
//                $table->string('seller_id')->comment("商家ID")->default(0);
//                $table->dateTime('created_at')->comment("管理员权限创建时间");
//                $table->dateTime('updated_at')->comment("管理员权限最近修改信息时间");
////                $table->timestamps();
//                $table->index("authc_id");
//                $table->index("role_id");
//            });
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('seller');
        Schema::drop('seller_user');
        Schema::drop('seller_address');
        Schema::drop('seller_fare_template');
        Schema::drop('seller_incl_postage_proviso');
        Schema::drop('seller_carry_mode');
        Schema::drop('seller_authentication');
        Schema::drop('seller_role');
        Schema::drop('seller_config');
        Schema::drop('system_user');
//        Schema::drop('seller_own_authentication');
    }
}
