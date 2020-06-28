<?
/*-------------------------------------------------------------------
SHOCKNET字符界面留言簿(Ver:20020629)
程序:by shocker
E-mail:sh0cker@163.com
主页:http://shocknet.126.com
论坛:shocknet.yeah.net
如果你发现了本留言簿有bug或者存在安全问题,那么请来信告诉我,万分感谢!
如果你有好的建议或意见,也请给我发E-mail,或者来我的主页留言簿提出
本程序为免费程序,源代码使用者可任意更改,但请保留本版权信息!

程序说明:
1.本留言簿为单用户留言簿,也许在我有时间的时候会做成多用户版
2.从analysist那里学到的用javascript作的即时字数显示,留言限制1000字,防止灌水
3.留言簿支持一部分ubb标记
4.纯字符界面,浏览速度更快,其实主要是为了配合我的主页风格
5.有版主回复和删除留言的功能,版主可以无限次回复留言
6.很好的解决了字符太长时表格变形的问题,在此感谢易奈特数码论坛的朋友们
7.加入了防灌水功能,发留言间隔为10秒
8.加入了引用留言的功能! new
9.最好使用IE5.0及以上版本浏览
10.使用前将数据文件所在的文件夹属性设为777,数据文件的属性设为666
11.more...
--------------------------------------------------------------------*/

#留言簿的设置数组
$admin[path]="data";                                ##数据文（建议不要修改）件的路径
$admin[home]="index.html";          ##主页地址
$admin[password]="liuqun";                        ##管理员密码
$admin[email]="liuqun@ict.ac.cn";            ##管理员邮箱
$admin[name]="liuqun";                             ##管理员帐号
$admin[homename]="Liu Qun's homepage";                        ##主页名称
$admin[bbsname]="留言簿";                   ##留言簿名称
$admin[ubb]=1;                                      ##UBB代码支持，0＝否
$admin[html]=0;                                     ##HTML代码支持，0＝否(推荐不支持)
$admin[copyright]="Copyright by LIU QUN";##页脚处显示的版权信息
$admin[page]=6;                                     ##每页显示留言数目
$admin[url]="guestbook.php";##留言簿主程序URL


/*-----------------------------常用函数,ubb函数是借鉴来的,呵呵--------------------------*/
#发表时间函数
function posttime(){
  $date=date("Y-m-d.G:i:s");
  return $date;
}
#取得贴子id函数
function getid(){
  $id=date("YmdHis");
  return $id;
}
#UBB处理函数
function ubb($Text) {
  $Text=ereg_replace("\r\n","<br>",$Text);
  $Text=ereg_replace("\r","<br>",$Text);
  $Text=preg_replace("/\\t/is","  ",$Text);
  $Text=preg_replace("/\[url\](http:\/\/.+?)\[\/url\]/is","<a href=\\1>\\1</a>",$Text);
  $Text=preg_replace("/\[url\](.+?)\[\/url\]/is","<a href=\"http://\\1\">http://\\1</a>",$Text);
  $Text=preg_replace("/\[url=(http:\/\/.+?)\](.*)\[\/url\]/is","<a href=\\1>\\2</a>",$Text);
  $Text=preg_replace("/\[url=(.+?)\](.*)\[\/url\]/is","<a href=http://\\1>\\2</a>",$Text);
  $Text=preg_replace("/\[pre\](.+?)\[\/pre\]/is","<pre>\\1</pre>",$Text);
  $Text=preg_replace("/\[email\](.+?)\[\/email\]/is","<a href=\\1>\\1</a>",$Text);
  $Text=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$Text);
  $Text=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$Text);
  $Text=preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote><b>引用:</b><hr>\\1<hr></blockquote>", $Text);
   $Text=preg_replace("/\[code\](.+?)\[\/code\]/is","<blockquote><font size='1' face='Times New Roman'>code:</font><hr color='lightblue'><i>\\1</i><hr color='lightblue'></blockquote>", $Text);
return $Text;
}
#字符串处理函数
function str($msg){
  global $admin;
  if(!$admin[html]) $msg=htmlspecialchars($msg);
  if($admin[ubb]) $msg=ubb($msg);
  $msg=nl2br($msg);
  $msg= str_replace("\r","",$msg);
  $msg= str_replace("\t","",$msg);
  $msg=str_replace("|","│",$msg);
  return $msg;
}
#检查邮件函数
function checkmail($add){
if(ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+",$add))
	$ttt=true;
      else $ttt=false;
return $ttt;
}
#取得ip函数
function getip($REMOTE_ADDR){
$ip=$REMOTE_ADDR;
$iphide=explode(".",$ip);
$ip="$iphide[0].$iphide[1].$iphide[2].***";
return $ip;
}
#显示错误函数
function showerror($errormsg){
global $admin;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css">
<title>留言簿出错</title>
</head>
<body bgcolor="#ffffff">
<p align="center">错误原因:<b><?echo $errormsg;?></b></p>
<p align="center"><a href="javascript:history.go(-1);"><font color="#000000">请点这里返回上一页检查你的输入是否有误</font></a></p>
<p align="center">[ <a href="javascript:history.go(-1);">返回上一页</a> ]</p>
<p align="center"><?echo $admin[copyright];?></p>
</body></html>
<?}
#输出一条留言函数
function messageshow($line){
global $admin;
$info=explode("|","$line");
?>
  <table width="512" border="0" cellspacing="0" cellpadding="0" height="179">
    <tr> 
      <td width="122" height="20">[No.<?echo $info[0];?>]</td>
      <td colspan="3" height="20">发表于:<?echo $info[1];?> [<a href="<?echo $admin[url]."?action=reply&num=".$info[0]?>">回复</a>][<a href="<?echo $admin[url]."?action=add&quote=1&num=".$info[0]?>">引用</a>][<a href="<?echo $admin[url]."?action=del&num=".$info[0]?>">删除</a>]</td>
    </tr>
    <tr> 
      <td width="122" height="125" valign="top"> 
        <div align="center"> 
          <p>id:<b><?echo $info[2];?></b></p>
          <p>[<a href="mailto:<?echo $info[4];?>">E-mail</a>]<br>
            [<a href="<?echo $info[7];?>" target="_blank">HomePage</a>]<br>
            [<a href="http://search.tencent.com/cgi-bin/friend/user_show_info?ln=<?echo $info[6];?>" target="_blank">Oicq</a>]</p>
		   <p>IP:<?echo $info[5];?></p>
        </div>
      </td>
      <td width="390" colspan="3" height="125" valign="top" style="TABLE-LAYOUT: fixed; WORD-BREAK: break-all; WORD-WRAP: break-word">
        <div align="left"><font color=green>
<?   echo $info[8]."\n";
	 for ($i=9;$i<count($info);$i++) 
		{
			if (isset($info[$i])) echo "<p><font color=maroon>斑竹回复:[".($i-8)."]<br>$info[$i]</font></p>";
		}
?>
        </font>
        </div>
      </td>
    </tr>
    <tr> 
      <hr>
    </tr>
  </table>
<?}
/*------------------------------------------------函数结束-----------------------------------------------------*/
?><?
if ($action=="add") 
{   if ($submitadd)
{   if ($id=="") showerror("请填写昵称^_^");
	elseif (time()-$post_time<10) showerror ("为防止灌水,发留言间隔为10秒");
	elseif (!checkmail($email)) showerror("你邮件没有填写或填写有错误!");
	elseif (eregi("[<>(),#|;%/$\]",$email)) showerror("邮件填写不能包含特殊字符!");
	elseif (strlen($id)>15) showerror("昵称太长,非法ID!");
	elseif (eregi("[<>(),#|;%/$\]+", $id)) showerror("昵称只能是字母数字或中文,请不要包含< > | ?等特殊字符");
	elseif (eregi("[^[a-z]]",$sex)) showerror("非法提交!");
	elseif (eregi("[^[:digit:]未知]", $oicq)) showerror("oicq号码填写错误!");
	elseif (eregi("[<>(),#|;%$\]+",$homepage)) showerror("主页填写有错误,主页名字只能包含字母数字下划线和-号!");
	elseif (!eregi("^http://",$homepage)) showerror("主页开头要加http://");
	elseif ($message=="") showerror("没有填写留言!");
	elseif (strlen($message)>2000) showerror("留言太长了,想把留言簿撑爆呀!");
	else {  
		     if ($oicq=="") $oicq="未知";
			 if ($homepage=="") $homepage="http://";
			if ($sex!="male") $sex="female"; 
		     $message=str($message);
			 $date=posttime();
			 $ip=getip($REMOTE_ADDR);
			 if (!file_exists("$admin[path]/message")) $num=1;
			 else {  $fp1=file("$admin[path]/message"); $num=count($fp1)+1;   }
			 $arr="$num|$date|$id|$sex|$email|$ip|$oicq|$homepage|$message\n";
			 $fp=fopen("$admin[path]/message","a");
			 fputs($fp,"$arr");
			 fclose($fp);
			 $cookietime=time()+31536000;
			 $posttime=time();
             setcookie(user_homepage,$homepage,$cookietime);
			 setcookie(user_sex,$sex,$cookietime);
             setcookie(user_email,$email,$cookietime);
             setcookie(user_id,$id,$cookietime);
             setcookie(user_oicq,$oicq,$cookietime);
			 setcookie(post_time,$posttime,60);
			 echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">";
			 echo "<HTML><HEAD><TITLE>发表文章</TITLE>";
			 echo "<META content=\"text/html; charset=gb2312\" http-equiv=Content-Type>";
			 echo "<link rel=\"stylesheet\" href=\"style.css\">";
			 echo "<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=$admin[url]\">";
			 echo "</head><body topmargin=\"0\"><br>";
			 echo "<ul>谢谢你发表留言,即将返回留言簿首页.<br>";
		     echo "&nbsp;<br>请等待 系统正在创建这个新的留言...<br>";
			 echo "&nbsp;<br></font>";
			 echo "<a href='$admin[url]'>如果你的浏览器没有自动的返回到留言簿首页，或者你不想再等待，请点这里返回.";
			 echo "</font></a></ul>";
		 }
}
else { if($user_homepage=="")$user_homepage="http://";
	   if($user_oicq=="")$user_oicq="未知"; ?>
<html>
<head>
<link rel="stylesheet" href="style.css">
<script>
function gbcount(message,total,used,remain) {
    var max;
    max = total.value;
    if (message.value.length > max) {
        message.value = message.value.substring(0,max);
        used.value = max;
        remain.value = 0;
        alert("留言不能超过1000个字!");
    }
    else {
        used.value = message.value.length;
        remain.value = max - used.value;
    }
}
</script>
<title>添加留言</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<body bgcolor="#FFFFFF">
<div align="center">
  <table width="512" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="512"> 
        <div align="center"><h1>添加留言</h1></div>
      </td>
    </tr>
    <tr> 
      <td width="512">
        <div align="center"><hr>
          <form name="add" action="<? echo "$PHP_SELF?action=add"?>" method="post" >              
            <table width="512" border="0" cellspacing="1" cellpadding="1">
              <tr> 
                <td width="143"> 
                  <div align="right">*昵称:</div>
                </td>
                <td width="360"> 
                  <input type="text" name="id" value="<?echo $user_id;?>">
                </td>
              </tr>
              <tr> 
                <td width="143"> 
                  <div align="right">性别:</div>
                </td>
                <td width="360"> 
                  <select name="sex">
                    <option value="male">男</option>
                    <option value="female">女</option>
                  </select>
                </td>
              </tr>
              <tr> 
                <td width="143"> 
                  <div align="right">*E-mail:</div>
                </td>
                <td width="360"> 
                  <input type="text" name="email" value="<?echo $user_email;?>">
                </td>
              </tr>
              <tr> 
                <td width="143"> 
                  <div align="right">Oicq: </div>
                </td>
                <td width="360"> 
                  <input type="text" name="oicq" value="<?echo $user_oicq;?>">
                </td>
              </tr>
              <tr> 
                <td width="143"> 
                  <div align="right">Homepage:</div>
                </td>
                <td width="360"> 
                  <input type="text" name="homepage" value="<?echo $user_homepage;?>">
                </td>
              </tr>
              <tr> 
                <td valign="top" width="143"> 
                  <div align="right">*Message: </div>
                </td>
                <td width="360"> 
<textarea rows="8" name="message" cols="50" onKeyDown="gbcount(this.form.message,this.form.total,this.form.used,this.form.remain);" onKeyUp="gbcount(this.form.message,this.form.total,this.form.used,this.form.remain);"><?if ($quote==1)
		 {      $fp=@file("$admin[path]/message");
				$n=count($fp);
				for ($i=$n-1;$i>=0;$i--)
					{	$arr=$fp[$i];
						$info=explode("|",$arr);
						if ($info[0]==$num)  
							{            
$info[8]=preg_replace("/<blockquote>(.+?)<\/blockquote>((<br>)*)/is","",$info[8]);
$info[8]=preg_replace("/<br>/","\n",$info[8]);
						       echo "[quote]".$info[8];
							   if (isset($info[9])) 
for ($i=9;$i<count($info);$i++) {
$info[$i]=preg_replace("/<br>/","\n",$info[$i]);
echo "\n斑竹回复[".($i-8)."]:\n".$info[$i];}
							   echo "[/quote]";
							   break;
							}
					}
		 }	
?></textarea>
                  <br>
                  最大字数： 
                  <input type="text" name="total" size="3" maxlength="3" value="1000" style="border-style: solid; border-color: #FFFFFF">
                  已用字数： 
                  <input type="text" name="used" size="3" maxlength="3" value="0" style="border-style: solid; border-color: #FFFFFF">
                  剩余字数： 
                  <input type="text" name="remain" size="3" maxlength="3" value="1000" style="border-style: solid; border-color: #FFFFFF">
                </td>
              </tr>
            </table>
            <p align="center">带星号的为必填项!</p>
            <p align="center"> 
              <input type="submit" name="submitadd" value="提交" style='background-color:white;color:#000000;border:1 double'>
              &nbsp;&nbsp;&nbsp; 
              <input type="reset" name="submit2" value="清空" style='background-color:white;color:#000000;border:1 double'>
            </p>
            </form>
        </div>
      </td>
    </tr>
    <tr> 
      <td width="454">&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html>
<?}}
elseif ($action=="reply")
{
	if ($submitreply) 
	{
		if ($name==$admin[name] and $password==$admin[password]) 
		{  $fp=@file("$admin[path]/message");$t=1;
		   $n=count($fp);
		   for ($i=$n;$i>=0;$i--)
			if ($t!=0)
		   {  $info=$fp[$i];
			  $arr=explode ("|",$info);
		      if ($arr[0]==$num) { $t=0;$replymessage=str($replymessage);
				  $arr[reply]=$replymessage."\n";
				  $info=str_replace("\n","",$info);
				  $newinfo=$info."|".$arr[reply];
				  $fp[$i]=$newinfo;
				  $fp1=fopen ("$admin[path]/message","w");
			      for ($j=0;$j<$n;$j++)  fputs ($fp1,"$fp[$j]");
			      fclose($fp1); }
			}
		   echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">";
		   echo "<HTML><HEAD><TITLE>回复留言</TITLE>";
		   echo "<META content=\"text/html; charset=gb2312\" http-equiv=Content-Type>";
		   echo "<link rel=\"stylesheet\" href=\"style.css\">";
		   echo "<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=$admin[url]\">";
		   echo "</head><body topmargin=\"0\"><br>";
		   echo "<ul>回复留言成功,即将返回留言簿首页.<br>";
		   echo "&nbsp;<br>请等待 系统正在创建这个新的页面...<br>";
		   echo "&nbsp;<br></font>";
		   echo "<a href='$admin[url]'>如果你的浏览器没有自动的返回到留言簿首页，或者你不想再等待，请点这里返回.";
		   echo "</font></a></ul>";
		}
	    else { showerror("用户名或密码错误,没有管理员权限!"); }
	}
	else { ?> 
<html>
<head>
<title>回复留言(版主才能回复)</title>
<link rel="stylesheet" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>

<body bgcolor="#FFFFFF">
<div align="center">
  <table width="512" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="512"> 
        <div align="center">
          <h1>回复留言</h1>
        </div>
      </td>
    </tr>
    <tr> 
      <td width="512"> 
        <div align="center"><hr> 
          <form name="reply" action="<?echo "$PHP_SELF?action=reply&num=$num";?>" method="post" >
            <table width="512" border="0" cellspacing="1" cellpadding="1">
              <tr> 
                <td width="143">
                  <div align="right">版主ID:</div>
                </td>
                <td width="360">
                  <input type="text" name="name">
                </td>
              </tr>
              <tr> 
                <td width="143"> 
                  <div align="right">版主密码:</div>
                </td>
                <td width="360">
                  <input type="password" name="password">
                </td>
              </tr>
              <tr> 
                <td valign="top" width="143"> 
                  <div align="right">回复内容:</div>
                </td>
                <td width="360"> 
                  <textarea name="replymessage" cols="50" rows="8"></textarea>
                </td>
              </tr>
            </table>
            <p align="center"> 
              <input type="submit" name="submitreply" value="提交" style='background-color:white;color:#000000;border:1 double'>
              &nbsp;&nbsp;&nbsp; 
              <input type="reset" name="Submit2" value="清空" style='background-color:white;color:#000000;border:1 double'>
            </p>
          </form>
        </div>
      </td>
    </tr>
    <tr> 
      <td width="454">&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html><?}
}
elseif ($action=="del")
{   if ($submitdel)
		{if ($name==$admin[name] and $password==$admin[password])
			{	$fp=@file("$admin[path]/message");
				$n=count($fp);
				for ($i=0;$i<$n;$i++)
					{	$arr=$fp[$i];
						$info=explode("|",$arr);
						if ($info[0]==$num) 
							{
								for ($j=$i;$j<$n;$j++)
								{
									$fp[$j]=$fp[$j+1];
									$arr1=$fp[$j];
									$info=explode("|",$arr1);
									$info[0]=$j+1;
									$newinfo=implode("|",$info);
									$fp[$j]=$newinfo;
								}
							}
					}
				$fp1=fopen ("$admin[path]/message","w");
				for ($i=0;$i<$n-1;$i++)  {fputs ($fp1,"$fp[$i]");}
				fclose($fp1);
			    echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">";
		        echo "<HTML><HEAD><TITLE>删除留言</TITLE>";
		        echo "<META content=\"text/html; charset=gb2312\" http-equiv=Content-Type>";
		        echo "<link rel=\"stylesheet\" href=\"style.css\">";
				echo "<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=$admin[url]\">";
				echo "</head><body topmargin=\"0\"><br>";
				echo "<ul>删除留言成功,即将返回留言簿首页.<br>";
				echo "&nbsp;<br>请等待 系统正在创建这个新的页面...<br>";
				echo "&nbsp;<br></font>";
				echo "<a href='$admin[url]'>如果你的浏览器没有自动的返回到留言簿首页，或者你不想再等待，请点这里返回.";
				echo "</font></a></ul>";
			}
		 else { showerror("密码错误,不允许删除!"); }
		}
	else {?>
<html>
<head>
<title>删除留言</title>
<link rel="stylesheet" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<body bgcolor="#FFFFFF">
<div align="center"><h1>删除留言</h1>
  <form name="del" action="<? echo "$PHP_SELF?action=del&num=$num"; ?>" method="post" >
    <table width="512" border="0" cellspacing="0" cellpadding="0">
      <hr>
      <tr> 
        <td width="242">版主ID: 
          <input type="text" name="name">
        </td>
        <td width="270">版主密码: 
          <input type="password" name="password">
        </td>
      </tr>
      <hr>
      <tr> 
        <td colspan="2" height="33"> 
          <div align="center"> 
            <input type="submit" name="submitdel" value="删除" style='background-color:white;color:#000000;border:1 double'>
          </div>
        </td>
      </tr>
    </table>
    </form>
</div>
</body>
</html>
	<?}}
else {?>
<html>
<head>
<title>留言本
</title>
<style>a{TEXT-DECORATION:none;color:000000}a:hover{color:515379}
</style>
</head>
<body>
<p align="center"><font color="#000000" size="+7" face="隶书"><strong>留言本</strong></font></p>
<p align="center"><font color="#000000" size="3" face="楷体_GB2312"><a href="index.html">首页</a></font></p>
<div align="center">*<a href="<? echo "$admin[url]?action=add";?>">我要留言</a>*</div>
<p align="center">
<?   
$fp=@file("$admin[path]/message") or die ("无法打开文件");
$total=count($fp);
if ($total<=$admin[page]) 
{
	for($i=$total-1;$i>=0;$i--)
	{  
	$line=$fp[$i];
    messageshow($line);
	}
}
else 
{
    $pages=intval($total/$admin[page]);
	if (($total%$admin[page])!=0) $pages++;
	if (isset($topage))
	{		
	if ($topage>$pages) $page=$pages;
	else $page=$topage;
	}
	if (!isset($page))
	$page=1;
	//计算记录偏移量
	$offset=$admin[page]*($page-1);
	//循环显示
	$j=$total-$offset-$admin[page];   
	if ($j<0) $j=0;                //判断数组是否到末尾
	for ($i=$total-$offset-1;$i>=$j;$i--)
		{	$line=$fp[$i];
			messageshow($line);
		}?>
	<table width="512" border="0" cellspacing="0" cellpadding="0" style="TABLE-LAYOUT: fixed; WORD-BREAK: break-all; WORD-WRAP: break-word">
    <tr>
      <td><div align="center">
		<?	
	for ($i=1;$i<$page;$i++)
	echo "<a href='$admin[url]?page=".$i."'>第".$i."页</a> ";
	echo "第".$page."页  ";
	for ($i=$page+1;$i<=$pages;$i++)
	echo "<a href='$admin[url]?page=".$i."'>第".$i."页</a> ";
	//显示转到页数
	echo "<form action='$admin[url]' method='post'> ";
	//计算首页、上一页、下一页、尾页的页数值
	$first=1;
	$prev=$page-1;
	$next=$page+1;
	$last=$pages;
	if ($page>1)
	{
	echo "<a href='$admin[url]?page=".$first."'>首页</a>  ";
	echo "<a href='$admin[url]?page=".$prev."'>上一页</a>  ";
	}
	if ($page<$pages)
	{
	echo "<a href='$admin[url]?page=".$next."'>下一页</a>  ";
	echo "<a href='$admin[url]?page=".$last."'>尾页</a>  ";
	}
	echo "转到<input type=text name='topage' size='2' value=".$page.">页";
	echo "<input type=submit name='more' value='Go' style='background-color:white;color:#000000;border:1 double'>";
	echo "</form>"; ?>
		</div></td>
    </tr>
	</table><?

}
}
?>
</p>
</div>
<p align="center"><font size="2">All Rights Reserved by LIU QUN</font></p>
</body>
</html>