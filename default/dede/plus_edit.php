<?
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_plus');
$aid = ereg_replace("[^0-9]","",$aid);
if($dopost=="show")
{
	$dsql = new DedeSql(false);
	$dsql->SetQuery("update #@__plus set isshow=1 where aid='$aid';");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����һ�����,��ˢ�µ����˵�!","plus_main.php");
	exit();
}
else if($dopost=="hide")
{
	$dsql = new DedeSql(false);
	$dsql->SetQuery("update #@__plus set isshow=0 where aid='$aid';");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ�����һ�����,��ˢ�µ����˵�!","plus_main.php");
	exit();
}
else if($dopost=="delete")
{
	if(empty($job)) $job="";
  if($job=="") //ȷ����ʾ
  {
  	require_once(dirname(__FILE__)."/../include/pub_oxwindow.php");
  	$wintitle = "ɾ�����";
	  $wecome_info = "<a href='plus_main.php'>�������</a>::ɾ�����";
	  $win = new OxWindow();
	  $win->Init("plus_edit.php","js/blank.js","POST");
	  $win->AddHidden("job","yes");
	  $win->AddHidden("dopost",$dopost);
	  $win->AddHidden("aid",$aid);
	  $win->AddTitle("��ȷʵҪɾ��'".$title."'��������");
	  $winform = $win->GetWindow("ok");
	  $win->Display();
	  exit();
  }
  else if($job=="yes") //����
  {
  	$dsql = new DedeSql(false);
	  $dsql->SetQuery("Delete From #@__plus where aid='$aid';");
	  $dsql->ExecuteNoneQuery();
	  $dsql->Close();
	  ShowMsg("�ɹ�ɾ��һ�����,��ˢ�µ����˵�!","plus_main.php");
	  exit();
  }
}
else if($dopost=="saveedit") //�������
{
	$dsql = new DedeSql(false);
	$dsql->SetQuery("Update #@__plus set plusname='$plusname',menustring='$menustring',filelist='$filelist' where aid='$aid';");
	$dsql->ExecuteNoneQuery();
	$dsql->Close();
	ShowMsg("�ɹ����Ĳ��������!","plus_main.php");
  exit();
}
$dsql = new DedeSql(false);
$row = $dsql->GetOne("Select * From #@__plus where aid='$aid'");
$dsql->Close();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>�޸Ĳ��</title>
<style type="text/css">
<!--
body {
	background-image: url(img/allbg.gif);
}
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="8">
<table width="98%"  border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
  <form name="form1" action="plus_edit.php" method="post">
   <input type='hidden' name='dopost' value='saveedit'>
   <input type='hidden' name='aid' value='<?=$aid?>'>
    <tr> 
      <td height="20" colspan="2" background="img/tbg.gif"> <b>&nbsp;<a href="plus_main.php"><u>�������</u></a> 
        &gt; �޸Ĳ����</b> </td>
    </tr>
    <tr> 
      <td width="19%" align="center" bgcolor="#FFFFFF">�������</td>
      <td width="81%" bgcolor="#FFFFFF">
      	<input type='text' name='plusname' style='width:180px' value='<?=$row['plusname']?>'>
      </td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">����</td>
      <td bgcolor="#FFFFFF">
      	<?=$row['writer']?>
      </td>
    </tr>
     <tr> 
      <td align="center" bgcolor="#FFFFFF">�˵�����</td>
      <td bgcolor="#FFFFFF">
      	<textarea name="menustring" rows="6" id="menustring" style="width:80%"><?=$row['menustring']?></textarea>
      </td>
    </tr>
    <tr> 
      <td align="center" bgcolor="#FFFFFF">�ļ��б�</td>
      <td bgcolor="#FFFFFF">�ļ���&quot;,&quot;�ֿ���·������ڹ���Ŀ¼����ǰĿ¼��<br>
        <textarea name="filelist" rows="8" id="filelist" style="width:80%"><?=$row['filelist']?></textarea></td>
    </tr>
    <tr bgcolor="#F9FDF0"> 
      <td height="28" colspan="2">
      	<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="26%">&nbsp;</td>
            <td width="15%"><input name="imageField" class="np" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
            <td width="59%"><img src="img/button_back.gif" width="60" height="22" onClick="location='plus_main.php';" style="cursor:hand"></td>
          </tr>
        </table>
        </td>
    </tr>
  </form>
</table>
</body>
</html>