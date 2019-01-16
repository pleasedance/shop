<?php
/**
 * 字符串可逆加密解密对象
 * @author laperlee
 */
class ValueEncodeDecode{
	private $secretkey;
	
	/**
	 * 设定密钥
	 * @param string $secret 密钥字符串
	 */
	public function setSecretkey($secret){
		$this->secretkey=$secret;
		return $this;
	}
	
	/**
	 * 加密字符串
	 * @param type $value
	 */
	public function encode($value) {
		$valen = strlen($value);
    	$valArr = array();
    	for ($i=0;$i<$valen;$i++) {
    		$valArr[] = substr($value, $i,1);
    	}
    	$varArr1=$varArr2=array();
    	foreach ($valArr as $k=>$val){
    		if($k%2){
    			$varArr1[]=$val;
    		}else{
    			$varArr2[]=$val;
    		}
    	}
    	$value1=implode("", $varArr1);
    	$value2=implode("", $varArr2);
    	return base64_encode(base64_encode($value1).strtoupper(md5($this->secretkey))."=".base64_encode($value2));
	}
	
	/**
	 * 解密字符串
	 * @return boolean
	 */
	public function decode($value){
		$secretkey=strtoupper(md5($this->secretkey))."=";
		$value=base64_decode($value);
		$arr=explode($secretkey, $value);
		if(count($arr)!=2){
			return FALSE;
		}
		$val1=base64_decode($arr[0]);
		$val2=base64_decode($arr[1]);
		$valen1=strlen($val1);
		$valen2=strlen($val2);
		$valArr=array();
		for($i=0;$i<$valen1;$i++){
			$valArr[($i*2)+1]=substr($val1, $i,1);
		}
		for($i=0;$i<$valen2;$i++){
			$valArr[$i*2]=substr($val2, $i,1);
		}
		ksort($valArr);
		return implode("", $valArr);
	}
}
