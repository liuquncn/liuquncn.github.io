<?
/*-------------------------------------------------------------------
SHOCKNET�ַ��������Բ�(Ver:20020629)
����:by shocker
E-mail:sh0cker@163.com
��ҳ:http://shocknet.126.com
��̳:shocknet.yeah.net
����㷢���˱����Բ���bug���ߴ��ڰ�ȫ����,��ô�����Ÿ�����,��ָ�л!
������кõĽ�������,Ҳ����ҷ�E-mail,�������ҵ���ҳ���Բ����
������Ϊ��ѳ���,Դ����ʹ���߿��������,���뱣������Ȩ��Ϣ!

����˵��:
1.�����Բ�Ϊ���û����Բ�,Ҳ��������ʱ���ʱ������ɶ��û���
2.��analysist����ѧ������javascript���ļ�ʱ������ʾ,��������1000��,��ֹ��ˮ
3.���Բ�֧��һ����ubb���
4.���ַ�����,����ٶȸ���,��ʵ��Ҫ��Ϊ������ҵ���ҳ���
5.�а����ظ���ɾ�����ԵĹ���,�����������޴λظ�����
6.�ܺõĽ�����ַ�̫��ʱ�����ε�����,�ڴ˸�л������������̳��������
7.�����˷���ˮ����,�����Լ��Ϊ10��
8.�������������ԵĹ���! new
9.���ʹ��IE5.0�����ϰ汾���
10.ʹ��ǰ�������ļ����ڵ��ļ���������Ϊ777,�����ļ���������Ϊ666
11.more...
--------------------------------------------------------------------*/

#���Բ�����������
$admin[path]="data";                                ##�����ģ����鲻Ҫ�޸ģ�����·��
$admin[home]="index.html";          ##��ҳ��ַ
$admin[password]="liuqun";                        ##����Ա����
$admin[email]="liuqun@ict.ac.cn";            ##����Ա����
$admin[name]="liuqun";                             ##����Ա�ʺ�
$admin[homename]="Liu Qun's homepage";                        ##��ҳ����
$admin[bbsname]="���Բ�";                   ##���Բ�����
$admin[ubb]=1;                                      ##UBB����֧�֣�0����
$admin[html]=0;                                     ##HTML����֧�֣�0����(�Ƽ���֧��)
$admin[copyright]="Copyright by LIU QUN";##ҳ�Ŵ���ʾ�İ�Ȩ��Ϣ
$admin[page]=6;                                     ##ÿҳ��ʾ������Ŀ
$admin[url]="guestbook.php";##���Բ�������URL


/*-----------------------------���ú���,ubb�����ǽ������,�Ǻ�--------------------------*/
#����ʱ�亯��
function posttime(){
  $date=date("Y-m-d.G:i:s");
  return $date;
}
#ȡ������id����
function getid(){
  $id=date("YmdHis");
  return $id;
}
#UBB������
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
  $Text=preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote><b>����:</b><hr>\\1<hr></blockquote>", $Text);
   $Text=preg_replace("/\[code\](.+?)\[\/code\]/is","<blockquote><font size='1' face='Times New Roman'>code:</font><hr color='lightblue'><i>\\1</i><hr color='lightblue'></blockquote>", $Text);
return $Text;
}
#�ַ���������
function str($msg){
  global $admin;
  if(!$admin[html]) $msg=htmlspecialchars($msg);
  if($admin[ubb]) $msg=ubb($msg);
  $msg=nl2br($msg);
  $msg= str_replace("\r","",$msg);
  $msg= str_replace("\t","",$msg);
  $msg=str_replace("|","��",$msg);
  return $msg;
}
#����ʼ�����
function checkmail($add){
if(ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+",$add))
	$ttt=true;
      else $ttt=false;
return $ttt;
}
#ȡ��ip����
function getip($REMOTE_ADDR){
$ip=$REMOTE_ADDR;
$iphide=explode(".",$ip);
$ip="$iphide[0].$iphide[1].$iphide[2].***";
return $ip;
}
#��ʾ������
function showerror($errormsg){
global $admin;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css">
<title>���Բ�����</title>
</head>
<body bgcolor="#ffffff">
<p align="center">����ԭ��:<b><?echo $errormsg;?></b></p>
<p align="center"><a href="javascript:history.go(-1);"><font color="#000000">������ﷵ����һҳ�����������Ƿ�����</font></a></p>
<p align="center">[ <a href="javascript:history.go(-1);">������һҳ</a> ]</p>
<p align="center"><?echo $admin[copyright];?></p>
</body></html>
<?}
#���һ�����Ժ���
function messageshow($line){
global $admin;
$info=explode("|","$line");
?>
  <table width="512" border="0" cellspacing="0" cellpadding="0" height="179">
    <tr> 
      <td width="122" height="20">[No.<?echo $info[0];?>]</td>
      <td colspan="3" height="20">������:<?echo $info[1];?> [<a href="<?echo $admin[url]."?action=reply&num=".$info[0]?>">�ظ�</a>][<a href="<?echo $admin[url]."?action=add&quote=1&num=".$info[0]?>">����</a>][<a href="<?echo $admin[url]."?action=del&num=".$info[0]?>">ɾ��</a>]</td>
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
			if (isset($info[$i])) echo "<p><font color=maroon>����ظ�:[".($i-8)."]<br>$info[$i]</font></p>";
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
/*------------------------------------------------��������-----------------------------------------------------*/
?><?
if ($action=="add") 
{   if ($submitadd)
{   if ($id=="") showerror("����д�ǳ�^_^");
	elseif (time()-$post_time<10) showerror ("Ϊ��ֹ��ˮ,�����Լ��Ϊ10��");
	elseif (!checkmail($email)) showerror("���ʼ�û����д����д�д���!");
	elseif (eregi("[<>(),#|;%/$\]",$email)) showerror("�ʼ���д���ܰ��������ַ�!");
	elseif (strlen($id)>15) showerror("�ǳ�̫��,�Ƿ�ID!");
	elseif (eregi("[<>(),#|;%/$\]+", $id)) showerror("�ǳ�ֻ������ĸ���ֻ�����,�벻Ҫ����< > | ?�������ַ�");
	elseif (eregi("[^[a-z]]",$sex)) showerror("�Ƿ��ύ!");
	elseif (eregi("[^[:digit:]δ֪]", $oicq)) showerror("oicq������д����!");
	elseif (eregi("[<>(),#|;%$\]+",$homepage)) showerror("��ҳ��д�д���,��ҳ����ֻ�ܰ�����ĸ�����»��ߺ�-��!");
	elseif (!eregi("^http://",$homepage)) showerror("��ҳ��ͷҪ��http://");
	elseif ($message=="") showerror("û����д����!");
	elseif (strlen($message)>2000) showerror("����̫����,������Բ��ű�ѽ!");
	else {  
		     if ($oicq=="") $oicq="δ֪";
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
			 echo "<HTML><HEAD><TITLE>��������</TITLE>";
			 echo "<META content=\"text/html; charset=gb2312\" http-equiv=Content-Type>";
			 echo "<link rel=\"stylesheet\" href=\"style.css\">";
			 echo "<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=$admin[url]\">";
			 echo "</head><body topmargin=\"0\"><br>";
			 echo "<ul>лл�㷢������,�����������Բ���ҳ.<br>";
		     echo "&nbsp;<br>��ȴ� ϵͳ���ڴ�������µ�����...<br>";
			 echo "&nbsp;<br></font>";
			 echo "<a href='$admin[url]'>�����������û���Զ��ķ��ص����Բ���ҳ�������㲻���ٵȴ���������ﷵ��.";
			 echo "</font></a></ul>";
		 }
}
else { if($user_homepage=="")$user_homepage="http://";
	   if($user_oicq=="")$user_oicq="δ֪"; ?>
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
        alert("���Բ��ܳ���1000����!");
    }
    else {
        used.value = message.value.length;
        remain.value = max - used.value;
    }
}
</script>
<title>�������</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<body bgcolor="#FFFFFF">
<div align="center">
  <table width="512" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="512"> 
        <div align="center"><h1>�������</h1></div>
      </td>
    </tr>
    <tr> 
      <td width="512">
        <div align="center"><hr>
          <form name="add" action="<? echo "$PHP_SELF?action=add"?>" method="post" >              
            <table width="512" border="0" cellspacing="1" cellpadding="1">
              <tr> 
                <td width="143"> 
                  <div align="right">*�ǳ�:</div>
                </td>
                <td width="360"> 
                  <input type="text" name="id" value="<?echo $user_id;?>">
                </td>
              </tr>
              <tr> 
                <td width="143"> 
                  <div align="right">�Ա�:</div>
                </td>
                <td width="360"> 
                  <select name="sex">
                    <option value="male">��</option>
                    <option value="female">Ů</option>
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
echo "\n����ظ�[".($i-8)."]:\n".$info[$i];}
							   echo "[/quote]";
							   break;
							}
					}
		 }	
?></textarea>
                  <br>
                  ��������� 
                  <input type="text" name="total" size="3" maxlength="3" value="1000" style="border-style: solid; border-color: #FFFFFF">
                  ���������� 
                  <input type="text" name="used" size="3" maxlength="3" value="0" style="border-style: solid; border-color: #FFFFFF">
                  ʣ�������� 
                  <input type="text" name="remain" size="3" maxlength="3" value="1000" style="border-style: solid; border-color: #FFFFFF">
                </td>
              </tr>
            </table>
            <p align="center">���Ǻŵ�Ϊ������!</p>
            <p align="center"> 
              <input type="submit" name="submitadd" value="�ύ" style='background-color:white;color:#000000;border:1 double'>
              &nbsp;&nbsp;&nbsp; 
              <input type="reset" name="submit2" value="���" style='background-color:white;color:#000000;border:1 double'>
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
		   echo "<HTML><HEAD><TITLE>�ظ�����</TITLE>";
		   echo "<META content=\"text/html; charset=gb2312\" http-equiv=Content-Type>";
		   echo "<link rel=\"stylesheet\" href=\"style.css\">";
		   echo "<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=$admin[url]\">";
		   echo "</head><body topmargin=\"0\"><br>";
		   echo "<ul>�ظ����Գɹ�,�����������Բ���ҳ.<br>";
		   echo "&nbsp;<br>��ȴ� ϵͳ���ڴ�������µ�ҳ��...<br>";
		   echo "&nbsp;<br></font>";
		   echo "<a href='$admin[url]'>�����������û���Զ��ķ��ص����Բ���ҳ�������㲻���ٵȴ���������ﷵ��.";
		   echo "</font></a></ul>";
		}
	    else { showerror("�û������������,û�й���ԱȨ��!"); }
	}
	else { ?> 
<html>
<head>
<title>�ظ�����(�������ܻظ�)</title>
<link rel="stylesheet" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>

<body bgcolor="#FFFFFF">
<div align="center">
  <table width="512" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td width="512"> 
        <div align="center">
          <h1>�ظ�����</h1>
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
                  <div align="right">����ID:</div>
                </td>
                <td width="360">
                  <input type="text" name="name">
                </td>
              </tr>
              <tr> 
                <td width="143"> 
                  <div align="right">��������:</div>
                </td>
                <td width="360">
                  <input type="password" name="password">
                </td>
              </tr>
              <tr> 
                <td valign="top" width="143"> 
                  <div align="right">�ظ�����:</div>
                </td>
                <td width="360"> 
                  <textarea name="replymessage" cols="50" rows="8"></textarea>
                </td>
              </tr>
            </table>
            <p align="center"> 
              <input type="submit" name="submitreply" value="�ύ" style='background-color:white;color:#000000;border:1 double'>
              &nbsp;&nbsp;&nbsp; 
              <input type="reset" name="Submit2" value="���" style='background-color:white;color:#000000;border:1 double'>
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
		        echo "<HTML><HEAD><TITLE>ɾ������</TITLE>";
		        echo "<META content=\"text/html; charset=gb2312\" http-equiv=Content-Type>";
		        echo "<link rel=\"stylesheet\" href=\"style.css\">";
				echo "<meta HTTP-EQUIV=\"REFRESH\" CONTENT=\"2;URL=$admin[url]\">";
				echo "</head><body topmargin=\"0\"><br>";
				echo "<ul>ɾ�����Գɹ�,�����������Բ���ҳ.<br>";
				echo "&nbsp;<br>��ȴ� ϵͳ���ڴ�������µ�ҳ��...<br>";
				echo "&nbsp;<br></font>";
				echo "<a href='$admin[url]'>�����������û���Զ��ķ��ص����Բ���ҳ�������㲻���ٵȴ���������ﷵ��.";
				echo "</font></a></ul>";
			}
		 else { showerror("�������,������ɾ��!"); }
		}
	else {?>
<html>
<head>
<title>ɾ������</title>
<link rel="stylesheet" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<body bgcolor="#FFFFFF">
<div align="center"><h1>ɾ������</h1>
  <form name="del" action="<? echo "$PHP_SELF?action=del&num=$num"; ?>" method="post" >
    <table width="512" border="0" cellspacing="0" cellpadding="0">
      <hr>
      <tr> 
        <td width="242">����ID: 
          <input type="text" name="name">
        </td>
        <td width="270">��������: 
          <input type="password" name="password">
        </td>
      </tr>
      <hr>
      <tr> 
        <td colspan="2" height="33"> 
          <div align="center"> 
            <input type="submit" name="submitdel" value="ɾ��" style='background-color:white;color:#000000;border:1 double'>
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
<title>���Ա�
</title>
<style>a{TEXT-DECORATION:none;color:000000}a:hover{color:515379}
</style>
</head>
<body>
<p align="center"><font color="#000000" size="+7" face="����"><strong>���Ա�</strong></font></p>
<p align="center"><font color="#000000" size="3" face="����_GB2312"><a href="index.html">��ҳ</a></font></p>
<div align="center">*<a href="<? echo "$admin[url]?action=add";?>">��Ҫ����</a>*</div>
<p align="center">
<?   
$fp=@file("$admin[path]/message") or die ("�޷����ļ�");
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
	//�����¼ƫ����
	$offset=$admin[page]*($page-1);
	//ѭ����ʾ
	$j=$total-$offset-$admin[page];   
	if ($j<0) $j=0;                //�ж������Ƿ�ĩβ
	for ($i=$total-$offset-1;$i>=$j;$i--)
		{	$line=$fp[$i];
			messageshow($line);
		}?>
	<table width="512" border="0" cellspacing="0" cellpadding="0" style="TABLE-LAYOUT: fixed; WORD-BREAK: break-all; WORD-WRAP: break-word">
    <tr>
      <td><div align="center">
		<?	
	for ($i=1;$i<$page;$i++)
	echo "<a href='$admin[url]?page=".$i."'>��".$i."ҳ</a> ";
	echo "��".$page."ҳ  ";
	for ($i=$page+1;$i<=$pages;$i++)
	echo "<a href='$admin[url]?page=".$i."'>��".$i."ҳ</a> ";
	//��ʾת��ҳ��
	echo "<form action='$admin[url]' method='post'> ";
	//������ҳ����һҳ����һҳ��βҳ��ҳ��ֵ
	$first=1;
	$prev=$page-1;
	$next=$page+1;
	$last=$pages;
	if ($page>1)
	{
	echo "<a href='$admin[url]?page=".$first."'>��ҳ</a>  ";
	echo "<a href='$admin[url]?page=".$prev."'>��һҳ</a>  ";
	}
	if ($page<$pages)
	{
	echo "<a href='$admin[url]?page=".$next."'>��һҳ</a>  ";
	echo "<a href='$admin[url]?page=".$last."'>βҳ</a>  ";
	}
	echo "ת��<input type=text name='topage' size='2' value=".$page.">ҳ";
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