<?php
/**
 * @author Lycan
 * @time 2017/07/07
 * @email LycanCoder@gmail.com
 * @check_email()		验证邮箱
 * @check_url()			验证网址
 * @check_chinese_character()	是否含有汉字
 * @check_invalide_str()	是否含有非法字符
 * @check_post_num()		邮证编码
 * @check_personal_card()	身份证号码
 * @check_ip()			验证IP地址
 * @check_book_isbn()		出版物的ISBN号
 * @check_mobile()		手机号码(中国大陆区)
 * @check_str_null()		字符串是否为空
 * @check_length()		字符串长度
 * @send_email()		发送电子邮件验证
 * @send_email_verify()		发送电话验证
 * @xml_to_array()		xml转换成数组
 * @curl()			http访问
 */

/*
 * 正则表达式验证邮箱
 * @author Lycan
 * @time 2017/07/07
 * @param string $str 所要验证的邮箱
 * @return boolean
 */
function check_email($str) {
	if (!$str) {
		return false;
	}
	return preg_match('/[a-z0-9&\-_.]+@[\w\-_]+([\w\-.]+)?\.[\w\-]+/is', $str) ? true : false;
}

/*
 * 正则表达式验证网址
 * @author Lycan
 * @time 2017/07/07
 * @param string $str 所要验证的网址
 * @return boolean
 */
function check_url($str) {
	if (!$str) {
		return false;
	}
	return preg_match('#(http|https|ftp|ftps)://([\w-]+\.)+[\w-]+(/[\w-./?%&=]*)?#i', $str) ? true : false;
}

/*
 * 验证字符串中是否含有汉字
 * @author Lycan
 * @time 2017/07/07
 * @param string $string 所要验证的字符串。注：字符串编码仅支持UTF-8
 * @return boolean
 */
function check_chinese_character($string) {
	if (!$string) {
		return false;
	}
	return preg_match('/[\x{4e00}-\x{9fa5}]+/u', $string) ? true : false;
}

/*
 * 验证字符串中是否含有非法字符
 * @author Lycan
 * @time 2017/07/07
 * @param string $string 待验证的字符串
 * @return boolean
 */
function check_invalide_str($string) {
	if (!$string) {
		return false;
	}
	return preg_match('#[!#$%^&*(){}~`"\';:?+=<>/\[\]]+#', $string) ? true : false;
}

/*
 * 用正则表达式验证邮证编码
 * @author Lycan
 * @time 2017/07/07
 * @param int $num 所要验证的邮政编码
 * @return boolean
 */
function check_post_num($num) {
	if (!$num) {
		return false;
	}
	return preg_match('/^[1-9][0-9]{5}$/', $num) ? true : false;
}

/*
 * 正则表达式验证身份证号码
 * @author Lycan
 * @time 2017/07/07
 * @param int $num 所要验证的身份证号码
 * @return boolean
 */
function check_personal_card($num) {
	if (!$num) {
		return false;
	}
	return preg_match('/^[\d]{15}$|^[\d]{18}$/', $num) ? true : false;
}

/*
 * 正则表达式验证IP地址, 注:仅限IPv4
 * @author Lycan
 * @time 2017/07/07
 * @param string $str 所要验证的IP地址
 * @return boolean
 */
function check_ip($str) {
	if (!$str) {
		return false;
	}
	if (!preg_match('#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $str)) {
		return false;
	}
	$ipArray = explode('.', $str);
	//真实的ip地址每个数字不能大于255（0-255）
	return (($ipArray[0] <= 255) && ($ipArray[1] <= 255) && ($ipArray[2] <= 255) && ($ipArray[3] <= 255)) ? true : false;
}

/*
 * 用正则表达式验证出版物的ISBN号
 * @author Lycan
 * @time 2017/07/07
 * @param int $str 所要验证的ISBN号,通常是由13位数字构成
 * @return boolean
 */
function check_book_isbn($str) {
	if (!$str) {
		return false;
	}
	return preg_match('#^978[\d]{10}$|^978-[\d]{10}$#', $str) ? true : false;
}

/*
 * 用正则表达式验证手机号码(中国大陆区)
 * @author Lycan
 * @time 2017/07/07
 * @param int $num 所要验证的手机号
 * @return boolean
 */
function check_mobile($num) {
	if (!$num) {
		return false;
	}
	return preg_match('#^1[\d]{10}$#', $num) ? true : false;
}

/*
 * 检查字符串是否为空
 * @author Lycan
 * @time 2017/07/07
 * @access public
 * @param string $string 字符串内容
 * @return boolean
 */
function check_str_null($string = null) {
	if (is_null($string)) {
		return false;
	}
	return empty($string) ? false : true;
}

/*
 * 检查字符串长度
 * @author Lycan
 * @time 2017/07/07
 * @param string $string 字符串内容
 * @param int $min 最小的字符串数
 * @param int $max 最大的字符串数
 * @return boolean
 */
function check_length($string = null, $min = 0, $max = 255) {
	if (is_null($string)) {
		return false;
	}
	//获取字符串长度
	$length = strlen(trim($string));
	return (($length >= (int)$min) && ($length <= (int)$max)) ? true : false;
}

/*
 * 电子邮件发送方法
 * @author Lycan
 * @time 2017/07/07
 * @param string $to 收件人地址
 * @param string $name 收件人名字
 * @param string $subject 邮件标题
 * @param string $body 邮件内容HTML
 * @param array() $attachment 附件磁盘路径
 * @return true|errorinfo
 */
function send_email($to, $name, $subject = '', $body = '', $attachment = null) {
	Vendor('PHPMailer.PHPMailerAutoload');		// 引入三方邮箱库
	$config = C('EMAIL_CONFIG');	// 加载配置文件里的邮箱发件箱服务器参数
	$mail = new PHPMailer(); // PHPMailer对象
	$mail->CharSet = 'UTF-8'; // 设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	$mail->IsSMTP(); // 设定使用SMTP服务
	$mail->SMTPDebug	= 0;			// 关闭SMTP调试功能  1 = errors and messages  2 = messages only
	$mail->SMTPAuth		= true;			// 启用 SMTP 验证功能
	$mail->SMTPSecure	= $config['smtp_ssl'];	// 使用安全协议 ssl\tcp
	$mail->Host		= $config['smtp_host'];	// SMTP 服务器
	$mail->Port		= $config['smtp_port']; // SMTP服务器的端口号
	$mail->Username		= $config['smtp_user']; // SMTP服务器用户名
	$mail->Password		= $config['smtp_pass']; // SMTP服务器密码
	$mail->SetFrom($config['from_email'], $config['from_name']);	// 设置邮件来源地址和名字
	$replyEmail = $config['reply_email'] ? $config['reply_email'] : $config['from_email'];	// 添加邮件回复地址
	$replyName = $config['reply_name'] ? $config['reply_name'] : $config['from_name']; // 添加邮件回复名字
	$mail->AddReplyTo($replyEmail, $replyName);		// 添加邮件回复地址
	$mail->Subject = $subject;	// 设置邮件标题
	$mail->AltBody = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";	// 邮件客户端不支持HTML时的提示内容
	$mail->MsgHTML($body);		// 设置邮件内容
	$mail->AddAddress($to, $name);	// 设置收件人地址和名字
	if(is_array($attachment)) {	// 添加附件
		foreach ($attachment as $file){
			is_file($file) && $mail->AddAttachment($file);
		}
	}
	return $mail->Send() ? true : $mail->ErrorInfo;
}

/*
 * 电子邮件发送方法
 * @author Lycan
 * @time 2017/07/07
 * @param string $tel 电话号码
 * @return array()
 */
function send_email_verify($tel) {
	$config = C('TEL_CONFIG');
	$r = rand(1000, 9999);
	$result = file_get_contents('http://106.ihuyi.com/webservice/sms.php?method=Submit&account=' . $config['APIID'] . '&password=' . $config['APIKEY'] . '&mobile=' . $tel . '&content=【公司名】您的验证码是：' . $r . '。请不要把验证码泄露给其他人。');
	$arr = xml_to_array($result);   // array('SubmitResult'=>array('code'=>2,'msg'=>'成功','smsid'=>''));
	if($arr['SubmitResult']['code'] == 2){
		S('verify_' . $tel, $r, 180);
	}
	return array(
		'code' => $arr['SubmitResult']['code'],
		'msg'  => $arr['SubmitResult']['msg']
	);
}

/*
 * xml转换成数组
 * @author Lycan
 * @time 2017/07/07
 * @param string $xml xml格式内容
 * @return xml|array()
 */
function xml_to_array($xml) {
	$reg = "/<(\\w+)[^>]*?>([\\x00-\\xFF]*?)<\\/\\1>/";
	if (preg_match_all($reg, $xml, $matches)) {
		$count = count($matches[0]);
		$arr = array();
		for($i = 0; $i < $count; $i++) {
			$key = $matches[1][$i];
			$val = xml_to_array( $matches[2][$i] );  // 调用自己方法递归
			if(array_key_exists($key, $arr)) {
				if(is_array($arr[$key])) {
					if(!array_key_exists(0, $arr[$key])) {
						$arr[$key] = array($arr[$key]);
					}
				} else {
					$arr[$key] = array($arr[$key]);
				}
				$arr[$key][] = $val;
			} else {
				$arr[$key] = $val;
			}
		}
		return $arr;
	} else {
		return $xml;
	}
}

/*
 * HTTP访问
 * @author Lycan 
 * @time 2017/08/18
 * @params string $url url地址
 * @params string $params post请求参数
 * @params string $method 请求方式
 * @params array $head 请求报头
 * @params Boolean $https https请求方式
 * @return mixed
 */
function curl($url = '', $params = '', $method = 'POST', $head = array(), $https = false){
	$ch = curl_init($url);	// 创建连接
	// 设置请求参数
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);	// 请求方式
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);		// POST请求内容(string/关联array)
	curl_setopt($ch, CURLOPT_HTTPHEADER, $head);		// 请求报头(非关联array)
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		// 返回内容处理(false直接输出)
	//是否为https请求
	if($https){
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	// 连接地址验证SSL证书
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);	// 验证服务器SSL证书
	}
	$result = curl_exec($ch); // 开始访问指定URL
	$result = json_decode($result, true);
	curl_close($ch);
	return $result;
}
