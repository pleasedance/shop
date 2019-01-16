<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LogHelper
 *
 * @author Administrator
 */
class LogHelper {
    public static function Warning($code,$message,$content=[]){
        Log::useDailyFiles(storage_path().'/logs/warning_'.$code.'.log');
        Log::warning($message,$content);
    }
    
    
    public static function Info($code,$message,$content=[]){
        Log::useDailyFiles(storage_path().'/logs/info_'.$code.'.log');
        Log::warning($message,$content);
    }
    
    public static function Error($code,$message,$content=[]){
        Log::useDailyFiles(storage_path().'/logs/error_'.$code.'.log');
        Log::warning($message,$content);
    }
}
