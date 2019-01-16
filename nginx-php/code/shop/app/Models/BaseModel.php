<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of BaseModel
 *
 * @author Administrator
 */
class BaseModel extends Model {
    
    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
//        $this->where("companys_id",4);
    }
    
}
