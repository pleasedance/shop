<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 商品表
         */
        if(!Schema::hasTable('pd_product')){
            Schema::create('pd_product', function (Blueprint $table) {
                $table->increments('product_id')->comment("商品编号ID");
                $table->string('product_art_no')->comment("商品货号");
                $table->string('product_number')->comment("商品唯一code");
                $table->string('pd_name')->comment("商品名称");
                $table->string('pd_subtitle')->nullable()->comment("商品副标题");
                $table->string('pd_descs')->nullable()->comment("商品介绍");
                $table->integer('pd_category_id')->comment("商品一级分类编号ID");
                $table->integer('pd_seller_id')->comment("商家ID");
                $table->integer('pd_brand_id')->comment("商品品牌编号ID");
                $table->integer('express_tpl_id')->comment("运费模版编号ID");
                $table->integer('sales_num')->comment("销量")->default(0);
                $table->string('pd_unit')->comment("商品计量单位");
                $table->decimal('pd_weight')->comment("商品单位重量");
                $table->string('pd_weight_unit')->comment("商品重量单位");
                $table->decimal('pd_volume')->comment("商品单位体积");
                $table->string('pd_volume_unit')->comment("商品体积单位");
                $table->decimal('market_price')->comment("商品市场价");
//                $table->decimal('member_price')->comment("商品会员价");
                $table->decimal('min_price')->comment("最小价格");
                $table->tinyInteger('pd_is_sell')->comment("是否上架【0未上架1上架，默认0】")->default(0);
                $table->tinyInteger('pd_recommend_type')->comment("商品推荐【二进制转十进制存储】")->default(0);
                $table->tinyInteger('pd_service_guarantee')->nullable()->comment("服务保证【二进制转十进制存储】");
                $table->string('detail_descr')->comment("详情页描述");
                $table->string('pd_key_word')->comment("商品关键词【商品关键词json】");
                $table->string('pd_remark')->comment("商品备注");
                $table->string('pd_picture_prefix')->comment("商品图片集合前缀【使用0-N拼接】");
                $table->binary('pd_detail_info')->nullable()->comment("商品信息图文详情");
                $table->text('pd_image_url')->nullable()->comment("商品图片URL");
                $table->text('pd_translation_pic')->nullable()->comment("商品缩略图URL");
                $table->integer('pd_sort')->comment("排序")->default(1);
                $table->tinyInteger('verify_status')->comment("审核状态【0未审核1已审核，默认0】")->default(0);
                $table->string('detail_title')->comment("详情页标题");
                $table->tinyInteger('del_status')->comment("删除标记【0未删除1删除，默认0】")->default(0);
                $table->dateTime('created_at')->comment("商品创建时间");
                $table->dateTime('updated_at')->comment("商品最近修改信息时间");
                $table->index("product_art_no");
                $table->index("pd_name");
                $table->index("pd_seller_id");
                $table->index("pd_key_word");
            });
            \Illuminate\Support\Facades\DB::statement(
                "ALTER TABLE coupon AUTO_INCREMENT=10000");
        }

        /**
         * 商品品牌表
         */
        if(!Schema::hasTable('pd_product_brand')){
            Schema::create('pd_product_brand', function (Blueprint $table) {
                $table->increments('brand_id')->comment("品牌编号ID");
                $table->string('brand_name')->comment("品牌名称");
                $table->char('brand_initials')->comment("品牌首字母");
                $table->string('brand_logo_url')->nullable()->comment("logo图片URL");
                $table->string('brand_detail_url')->nullable()->comment("品牌专区大图URL");
                $table->string('brand_introduce')->nullable()->comment("品牌故事介绍");
                $table->tinyInteger('is_show')->comment("是否显示【0不显示1显示】")->default(0);
//                $table->tinyInteger('is_manufacturer')->comment("是否为品牌制造商【0否1是】")->default(0);
                $table->integer('sort')->comment("排序")->default(1);
                $table->tinyInteger('del_status')->comment("删除标记【0未删除1删除，默认0】")->default(0);
                $table->dateTime('created_at')->comment("商品分类信息创建时间");
                $table->dateTime('updated_at')->comment("商品分类信息最近修改信息时间");
                $table->index("brand_name");
                $table->index("brand_initials");
            });
        }

        /**
         * 商品关联参数表
         */
        if(!Schema::hasTable('pd_param')){
            Schema::create('pd_param', function (Blueprint $table) {
                $table->increments('pd_param_id')->comment("商品关联参数编号");
                $table->string('param_item')->comment("参数项");
                $table->char('param_value')->comment("参数值");
                $table->string('product_number')->comment("商品唯一code");
            });
        }

        /**
         * 商品SKU表
         */
        if(!Schema::hasTable('pd_sku')){
            Schema::create('pd_sku', function (Blueprint $table) {
                $table->increments('sku_id')->comment("商品sku编号ID");
                $table->string('product_number')->comment("商品唯一code");
//                $table->string('sku_item')->comment("商品sku属性名");
//                $table->string('sku_value')->comment("商品sku属性值");
                $table->string('property')->comment("商品sku属性");
//                $table->integer('sku_sort')->comment("属性排序")->default(1);
                $table->string('sku_code')->comment("sku编号");
                $table->string('sku_unique_code')->comment("sku属性组唯一code");
                $table->tinyInteger('del_status')->comment("删除标记【0未删除1删除】")->default(0);
                $table->index("sku_unique_code");
            });
        }

        /**
         * 商品sku库存表
         */
        if(!Schema::hasTable('pd_sku_properties')){
            Schema::create('pd_sku_properties', function (Blueprint $table) {
                $table->increments('properties_id')->comment("编号id");
                $table->decimal('pd_price')->comment("价格")->default(0);
                $table->decimal('member_price')->comment("会员价")->default(0);
                $table->integer('pd_stocks')->comment("库存")->default(0);
                $table->integer('pd_frozen_stocks')->comment("冻结库存")->default(0);
                $table->integer('pd_alarm_stocks')->comment("库存预警值")->default(0);
                $table->string('sku_unique_code')->comment("sku属性组唯一code");
                $table->tinyInteger('des_match')->comment("0非常差1差2一般3好4非常好")->default(0);
                $table->string('sku_picture_url')->nullable()->comment("属性图片地址");
                $table->string('sku_code')->comment("sku编号");
                $table->string('product_number')->comment("商品唯一code");
                $table->integer('version')->nullable()->comment("更新版本号");
                $table->index("sku_unique_code");
                $table->unique("sku_code");
            });
        }

        /**
         * 商品评价
         */
        if(!Schema::hasTable('pd_evaluation')){
            Schema::create('pd_evaluation', function (Blueprint $table) {
                $table->increments('evaluation_id')->comment("评价编号id");
                $table->text('content')->nullable()->comment("评价内容");
                $table->text('img_url')->nullable()->comment("上传图片");
                $table->string('order_sn')->nullable()->comment("订单编号");
                $table->string('order_sub_sn')->nullable()->comment("子订单编号");
                $table->integer('buyer_id')->comment("会员ID")->default(0);
                $table->string('product_number')->comment("商品唯一code");
                $table->string('sku_code')->comment("sku编号");
//                $table->string('sku_picture_url')->nullable()->comment("属性图片地址");
                $table->tinyInteger('des_match')->comment("0非常差1差2一般3好4非常好");
                $table->tinyInteger('has_img')->comment("是否有图0否1是")->default(0);
                $table->dateTime('created_at')->comment("创建时间");
                $table->dateTime('updated_at')->comment("修改信息时间");
            });
        }

        /**
         * 商家回复
         */
        if(!Schema::hasTable('pd_evaluation_reply')){
            Schema::create('pd_evaluation_reply', function (Blueprint $table) {
                $table->increments('reply_id')->comment("回复编号id");
                $table->text('content')->nullable()->comment("回复内容");
                $table->integer('evaluation_id')->comment("评价ID");
                $table->integer('seller_id')->comment("商家ID");
                $table->dateTime('created_at')->comment("创建时间");
                $table->dateTime('updated_at')->comment("修改信息时间");
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
        Schema::drop('pd_product');
        Schema::drop('pd_product_brand');
        Schema::drop('pd_param');
        Schema::drop('pd_sku');
        Schema::drop('pd_sku_properties');
        Schema::drop('pd_evaluation');
        Schema::drop('pd_evaluation_reply');
    }
}
