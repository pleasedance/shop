<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 商品分类信息表
         */
        if(!Schema::hasTable('pd_category')){
            Schema::create('pd_category', function (Blueprint $table) {
                $table->increments('category_id')->comment("分类编号ID");
                $table->integer('parent_id')->comment("父分类编号ID【默认0】")->default(0);
                $table->integer('brand_id')->comment("品牌ID【默认0】")->default(0);
                $table->string('name')->comment("分类名称");
                $table->string('descr')->nullable()->comment("分类描述");
                $table->string('picture_url')->nullable()->comment("分类图标URL");
                $table->tinyInteger('level')->comment("级别");
                $table->integer('sort')->comment("排序【默认1】")->default(1);
//                $table->string('unit')->comment("分类商品单位");
                $table->tinyInteger('navigation_status')->comment("导航栏是否显示【0不显示1显示，默认0】")->default(0);
                $table->tinyInteger('status')->comment("是否显示【0不显示1显示，默认0】")->default(0);
                $table->dateTime('created_at')->comment("商品分类信息创建时间");
                $table->dateTime('updated_at')->comment("商品分类信息最近修改信息时间");
                $table->tinyInteger('del_status')->comment("删除标记【0未删除1删除，默认0】")->default(0);
                $table->index("sort");
            });
        }

        /**
         * 商品参数表
         */
        if(!Schema::hasTable('pd_product_param')){
            Schema::create('pd_product_param', function (Blueprint $table) {
                $table->increments('param_id')->comment("商品参数编号ID");
                $table->string('param_number')->comment("参数编号");
                $table->string('product_number')->comment("商品唯一code");
                $table->string('param_name')->comment("参数组");
                $table->tinyInteger('is_search')->comment("能否进行检索【0不需要1关键字2范围】")->default(0);
                $table->integer('sort')->comment("排序【默认1】")->default(1);
                $table->tinyInteger('status')->comment("是否显示【0不显示1显示，默认0】")->default(0);
                $table->dateTime('created_at')->comment("创建时间");
                $table->dateTime('updated_at')->comment("修改信息时间");
                $table->tinyInteger('del_status')->comment("删除标记【0未删除1删除，默认0】")->default(0);
                $table->index("param_number");
            });
        }

        /**
         * 商品参数值表
         */
        if(!Schema::hasTable('pd_product_param_properties')){
            Schema::create('pd_product_param_properties', function (Blueprint $table) {
                $table->increments('cpp_id')->comment("参数属性编号ID");
                $table->string('param_number')->comment("参数编号");
                $table->string('param_name')->comment("参数组");
                $table->string('param_propertie_value')->comment("参数项");
                $table->dateTime('created_at')->comment("商品分类信息创建时间");
                $table->dateTime('updated_at')->comment("商品分类信息最近修改信息时间");
                $table->index("param_number");
            });
        }

        /**
         * 商品sku表
         */
        if(!Schema::hasTable('pd_product_sku')){
            Schema::create('pd_product_sku', function (Blueprint $table) {
                $table->increments('id')->comment("编号ID");
                $table->string('name')->comment("sku名称");
                $table->string('product_number')->comment("商品唯一code");
                $table->tinyInteger('is_mult_choose')->comment("是否可以多选【0否1是】")->default(0);
                $table->string('value')->comment("sku值");
                $table->tinyInteger('del_status')->comment("删除标记【0未删除1删除，默认0】")->default(0);
                $table->dateTime('created_at')->comment("商品分类信息创建时间");
                $table->dateTime('updated_at')->comment("商品分类信息最近修改信息时间");
            });
        }

        /**
         * 商品sku表

        if(!Schema::hasTable('pd_product_sku')){
            Schema::create('pd_product_sku', function (Blueprint $table) {
                $table->increments('propertie_id')->comment("商品属性编号ID");
                $table->string('sku_number')->comment("商品属性编号");
                $table->string('propertie_name')->comment("属性组名称");
                $table->integer('product_id')->comment("商品编号ID");
                $table->tinyInteger('is_search')->comment("能否进行检索【0不需要1关键字2范围】")->default(0);
                $table->tinyInteger('is_mult_choose')->comment("是否可以多选【0否1是】")->default(0);
                $table->integer('sort')->comment("排序【默认1】")->default(1);
                $table->tinyInteger('status')->comment("是否显示【0不显示1显示，默认0】")->default(0);
                $table->tinyInteger('del_status')->comment("删除标记【0未删除1删除，默认0】")->default(0);
                $table->dateTime('created_at')->comment("创建时间");
                $table->dateTime('updated_at')->comment("修改信息时间");
                $table->index("sku_number");
                $table->index("propertie_name");
            });
        }*/

        /**
         * 商品sku属性值表

        if(!Schema::hasTable('pd_product_sku_properties')){
            Schema::create('pd_product_sku_properties', function (Blueprint $table) {
                $table->increments('sp_id')->comment("商品sku属性表ID");
                $table->string('sku_number')->comment("sku编号");
                $table->integer('product_id')->comment("商品编号ID");
                $table->string('propertie_name')->comment("属性组名称");
                $table->string('sku_propertie_value')->comment("属性项");
                $table->dateTime('created_at')->comment("创建时间");
                $table->dateTime('updated_at')->comment("修改信息时间");
                $table->index("sku_number");
            });
        }*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pd_category');
        Schema::drop('pd_product_param');
        Schema::drop('pd_product_param_properties');
        Schema::drop('pd_product_sku');
//        Schema::drop('pd_product_sku');
//        Schema::drop('pd_product_sku_properties');
    }
}
