<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CookieHelper
 *
 * @author Administrator
 */
class CookieHelper extends Cookie {
    
	/**
	 * 设定cookies信息
	 * @param type $key
	 * @param type $value
	 * @param type $timeout
	 */
	public static function set($key,$value,$timeout=NULL)
	{
		return Cookie::make($key, $value, $timeout, Config::get("cookies.path",NULL), Config::get("cookies.domain",NULL), Config::get("cookies.secure",FALSE), Config::get("cookies.httpOnly",TRUE));
	}
	
	public static function forget($key)
	{
		return Cookie::forget($key, Config::get("cookies.path",NULL), Config::get("cookies.domain",NULL));
	}
}
