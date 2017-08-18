<?php

	/**
	 * create by Lycan 
	 * @params $params
	 * @params string $url url地址
	 * @params string $params post请求参数
	 * @params string $method 请求方式
	 * @params array $head 请求报头
	 * @params Boolean $https https请求方式
	 * return array
	 * create time 2017/08/18
	 * 
	 */
	function curl($url='',$params='',$method='POST',$head=array(),$https=false){
        $ch = curl_init($url);	//创建连接
		//设置请求参数
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);	//请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);		//POST请求内容(string/关联array)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);		//请求报头(非关联array)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		//返回内容处理(false直接输出)
		//是否为https请求
        if($https){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	//连接地址验证SSL证书
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);	//验证服务器SSL证书
        }
        $result = curl_exec($ch);	//发送请求
        $result = json_decode($result,true);
        curl_close($ch);
        return $result;
    }