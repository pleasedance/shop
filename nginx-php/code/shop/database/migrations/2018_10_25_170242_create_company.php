<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 企业表
         */
        if(!Schema::hasTable('company')){
            Schema::create('company', function (Blueprint $table) {
                $table->increments('company_id')->comment("企业ID");
                $table->string('name')->comment("企业名");
                $table->decimal('money')->comment("企业余额【默认0】")->default(0);
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->dateTime('created_at')->comment("企业创建时间");
                $table->dateTime('updated_at')->comment("企业最近修改信息时间");
//                $table->timestamps();
                $table->index("created_at");
            });
        }

        /**
         * 系统管理员表
         */
        if(!Schema::hasTable('company_user')){
            Schema::create('company_user', function (Blueprint $table) {
                $table->increments('sys_user_id')->comment("系统管理员ID");
                $table->string('username')->comment("系统管理员名");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->string('password')->comment("密码");
                $table->string('loginid')->comment("登录账号");
                $table->string('email')->nullable()->comment("邮箱地址");
//                $table->string('picture_url')->nullable()->comment("图片地址");
//                $table->integer('dept_id')->comment("所属部门ID")->default(0);
                $table->integer('company_id')->comment("企业ID")->default(0);
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
         * 角色信息表
         */
        if(!Schema::hasTable('company_role')){
            Schema::create('company_role', function (Blueprint $table) {
                $table->increments('role_id')->comment("角色ID");
                $table->string('role_name')->comment("角色名称");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->string('role_descr')->nullable()->comment("角色描述");
//                $table->integer('members_num')->comment("成员人数");
//                $table->string('company_id')->nullable()->comment("商家ID");
                $table->string('del_status')->comment("删除标记【0:未删除1:删除】")->default(0);
                $table->dateTime('created_at')->comment("角色信息创建时间");
                $table->dateTime('updated_at')->comment("角色信息最近修改信息时间");
//                $table->timestamps();
                $table->index("role_name");
            });
        }

        /**
         * 部门信息表
         */
        if(!Schema::hasTable('company_depart')){
            Schema::create('company_depart', function (Blueprint $table) {
                $table->increments('depart_id')->comment("部门ID");
                $table->integer('parent_id')->comment("部门父级ID")->default(0);
                $table->string('depart_name')->comment("部门");
                $table->tinyInteger('status')->comment("状态【0:未启用1:启用，默认1】")->default(1);
                $table->string('depart_descr')->nullable()->comment("角色描述");
//                $table->integer('members_num')->comment("成员人数");
                $table->string('company_id')->comment("企业ID");
                $table->string('del_status')->comment("删除标记【0:未删除1:删除】")->default(0);
                $table->dateTime('created_at')->comment("角色信息创建时间");
                $table->dateTime('updated_at')->comment("角色信息最近修改信息时间");
//                $table->timestamps();
                $table->index("depart_name");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company');
        Schema::drop('company_user');
        Schema::drop('company_role');
        Schema::drop('company_depart');
    }
}
