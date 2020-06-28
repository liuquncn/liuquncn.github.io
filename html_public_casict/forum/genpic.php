<?
	session_start();	
	session_register("authnum");

	//生成新的四位整数验证码
	$authnum = ''; 
	$str = '467222abcdaefdd8222gxhijkm91+npqrstuvwxy%z123456789*'; 
	$l = strlen($str); 
	for($i=1;$i<=4;$i++)
	{ 
		$num=rand(0,$l); 
		$authnum.= $str[$num]; 
	}
	
//	setcookie ("authnum",$authnum);
//	$_SESSION['authnum'] = $authnum
	$HTTP_SESSION_VARS[authnum] = $authnum;
	
	//生成验证码图片
	Header("Content-type: image/PNG");
	srand((double)microtime()*1000000);
	$im = imagecreate(50,20);
	$black = ImageColorAllocate($im, 0,0,0);
	$white = ImageColorAllocate($im, 255,255,255);
	$gray = ImageColorAllocate($im, 200,200,200);
	imagefill($im,68,30,$gray);
	
	//将四位整数验证码绘入图片
	imagestring($im, 5, 6, 3, $authnum, $white);
	for($i=0;$i<180;$i++) //加入干扰象素
	{
		imagesetpixel($im, rand()%70 , rand()%30 , $gray);
	}
	ImagePNG($im);
	ImageDestroy($im);
?>
