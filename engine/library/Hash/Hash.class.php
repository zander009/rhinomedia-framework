<?php

class Hash
{

	public static function make($value, $salt = '')							
	{
		return hash('sha256', $value . $salt);								
	}

	public static function salt($length)									
	{
		return mcrypt_create_iv($length);									
	}

	public static function unique()											
	{
		return self::make(uniqid());										
	}

	public static function encryptIt($q) 
	{
	    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';

	    $qEncoded=base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,md5($cryptKey),$q,MCRYPT_MODE_CBC,md5(md5($cryptKey))));

	    return $qEncoded;
	}

	public static function decryptIt($q) 
	{
	    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';

	    $qDecoded=rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,md5($cryptKey),base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");

	    return $qDecoded;
	}

}
