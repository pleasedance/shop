<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

/**
 * Description of ImportModel
 *
 * @author Administrator
 */
class ImportModel  extends BaseModel {
    protected $table="import";
    
    const moduleUser="user";
    
    const statusInit="init";
    const statusSuccess="success";
    const statusFail="fail";
}
