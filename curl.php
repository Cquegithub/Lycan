<?php

	/*
	 * create by Lycan 
	 * params 
	 * return object 
	 * 
	 */
	function curl($url='',$params='',$method='POST',$head=array(),$https=false){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($https){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        $result = curl_exec($ch);
        $result = json_decode($result,true);
        curl_close($ch);
        return $result;
    }