<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/inc/inc_catalog_options.php");
require_once(dirname(__FILE__)."/../include/pub_dedetag.php");
$aid = ereg_replace("[^0-9]","",$aid);
$channelid="2";
$dsql = new DedeSql(false);
//读取归档信息
//------------------------------
$arcQuery = "Select 
#@__channeltype.typename as channelname,
#@__arcrank.membername as rankname,
#@__archives.* 
From #@__archives
left join #@__channeltype on #@__channeltype.ID=#@__archives.channel 
left join #@__arcrank on #@__arcrank.rank=#@__archives.arcrank
where #@__archives.ID='$aid'";
$addQuery = "Select * From #@__addonimages where aid='$aid'";

$dsql->SetQuery($arcQuery);
$arcRow = $dsql->GetOne($arcQuery);
if(!is_array($arcRow)){
	$dsql->Close();
	ShowMsg("读取档案基本信息出错!","-1");
	exit();
}

$addRow = $dsql->GetOne($addQuery);
if(!is_array($addRow)){
	$imgurls = "";
	$pagestyle = 1;
	$maxwidth = $cfg_album_width;
	$irow = 4;
	$icol = 4;
	$isrm = 1;
}
else
{
	$imgurls = $addRow["imgurls"];
	$maxwidth = $addRow["maxwidth"];
	$pagestyle = $addRow["pagestyle"];
	$irow = $addRow["row"];
	$icol = $addRow["col"];
	$isrm = $addRow["isrm"];
	$maxwidth = $addRow["maxwidth"];
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>修改图片集</title>
<style type="text/css">
<!--
body { background-image: url(img/allbg.gif); }
-->
</style>
<link href="base.css" rel="stylesheet" type="text/css">
<script language='javascript' src='main.js'></script>
<script language="javascript">
<!--
function checkSubmit()
{
   if(document.form1.title.value==""){
	   alert("文档标题不能为空！");
	   return false;
  }
  //myimage = document.getElementById("myimages");
  //document.form1.imagebody = myimage.innerHTML;
  return true;
}

var startNum = 1;
function MakeUpload(mnum)
{
   var endNum = 0;
   var upfield = document.getElementById("uploadfield");
   var pnumObj = document.getElementById("picnum");
   var fhtml = "";
 
   if(mnum==0) endNum = startNum + Number(pnumObj.value);
   else endNum = mnum;
   if(endNum>120) endNum = 120;
   
   for(startNum;startNum < endNum;startNum++){
	   fhtml = "";
	   fhtml += "<table width='600'><tr><td><input type='checkbox' name='isokcheck"+startNum+"' id='isokcheck"+startNum+"' value='1' class='np' onClick='CheckSelTable("+startNum+")'>显示/隐藏图片["+startNum+"]的选框</td></tr></table>";
	   fhtml += "<table width=\"600\" border=\"0\" id=\"seltb"+startNum+"\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#E8F5D6\" style=\"margin-bottom:6px;margin-left:10px\"><tobdy>";
	   fhtml += "<tr bgcolor=\"#F4F9DD\">\r\n";
	   fhtml += "<td height=\"25\" colspan=\"2\">　<strong>图片"+startNum+"：</strong></td>";
	   fhtml += "</tr>";
	   fhtml += "<tr bgcolor=\"#FFFFFF\"> ";
	   fhtml += "<td width=\"429\" height=\"25\"> 　本地上传： ";
	   fhtml += "<input type=\"file\" name='imgfile"+startNum+"' style=\"width:330px\"  onChange=\"SeePic(document.picview"+startNum+",document.form1.imgfile"+startNum+");\"></td>";
	   fhtml += "<td width=\"164\" rowspan=\"3\" align=\"center\"><img src=\"img/pview.gif\" width=\"150\" id=\"picview"+startNum+"\" name=\"picview"+startNum+"\"></td>";
	   fhtml += "</tr>";
	   fhtml += "<tr bgcolor=\"#FFFFFF\"> ";
	   fhtml += "<td height=\"25\"> 　指定网址： ";
	   fhtml += "<input type=\"text\" name='imgurl"+startNum+"' style=\"width:260px\"> ";
	   fhtml += "<input type=\"button\" name='selpic"+startNum+"' value=\"选取\" style=\"width:65px\" onClick=\"SelectImageN('form1.imgurl"+startNum+"','big','picview"+startNum+"')\">";
	   fhtml += "</td></tr>";
	   fhtml += "<tr bgcolor=\"#FFFFFF\"> ";
	   fhtml += "<td height=\"56\">　图片简介： ";
	   fhtml += "<textarea name='imgmsg"+startNum+"' style=\"height:46px;width:330px\"></textarea> </td>";
	   fhtml += "</tr></tobdy></table>\r\n";
	   upfield.innerHTML += fhtml;
  }
}

function CheckSelTable(nnum){
	var cbox = $Obj('isokcheck'+nnum);
	var seltb = $Obj('seltb'+nnum);
	if(cbox.checked) seltb.style.display = 'none';
	else seltb.style.display = 'block';
}
-->
</script>
</head>
<body topmargin="8">
<form name="form1" action="album_edit_action.php" enctype="multipart/form-data" method="post" onSubmit="return checkSubmit();">
<input type="hidden" name="channelid" value="<?=$channelid?>">
<input type="hidden" name="ID" value="<?=$aid?>">
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="4%" height="30"><IMG height=14 src="img/book1.gif" width=20> 
        &nbsp;</td>
      <td width="85%"><a href="catalog_do.php?cid=<?=$arcRow["typeid"]?>&dopost=listArchives"><u>图集列表</u></a>&gt;&gt;更改图集</td>
      <td width="10%">&nbsp; <a href="catalog_main.php">[<u>栏目管理</u>]</a> </td>
      <td width="1%">&nbsp;</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head1" style="border-bottom:1px solid #CCCCCC">
    <tr> 
      <td colspan="2"> <table width="168" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" height="24" align="center" background="img/itemnote1.gif">&nbsp;常规参数&nbsp;</td>
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem2()"><u>图集内容</u></a>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" id="head2" style="border-bottom:1px solid #CCCCCC;display:none">
    <tr> 
      <td colspan="2"> <table width="168" height="24" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="84" align="center" background="img/itemnote2.gif"><a href="#" onClick="ShowItem1()"><u>常规参数</u></a>&nbsp;</td>
            <td width="84" align="center" background="img/itemnote1.gif">图集内容&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td height="2"></td></tr>
</table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr> 
      <td width="400%" height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">图集标题：</td>
            <td width="240">
<input name="title" type="text" id="title" style="width:200" value="<?=$arcRow["title"]?>">
            </td>
            <td width="90">附加参数：</td>
            <td> 
              <input name="iscommend" type="checkbox" id="iscommend" value="11" class="np"<? if($arcRow["iscommend"]>10) echo " checked";?>>
              推荐 
              <input name="isbold" type="checkbox" id="isbold" value="5" class="np"<? if($arcRow["iscommend"]==5||$arcRow["iscommend"]==16) echo " checked";?>>
              加粗
              <input name="isjump" type="checkbox" onClick="ShowUrlTrEdit()" id="isjump" value="1" class="np"<? echo $arcRow["redirecturl"]=="" ? "" : " checked";?>>
              跳转网址
            </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline" id="redirecturltr" style="display:<? echo $arcRow["redirecturl"]=="" ? "none" : "block";?>">
	   <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">&nbsp;跳转网址：</td>
            <td> <input name="redirecturl" type="text" id="redirecturl" style="width:300" value="<?=$arcRow["redirecturl"]?>"> 
            </td>
          </tr>
       </table>
	 </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">简略标题：</td>
            <td width="240">
<input name="shorttitle" type="text" value="<?=$arcRow["shorttitle"]?>" id="shorttitle" style="width:200">
            </td>
            <td width="90">自定属性：</td>
            <td> 
              <select name='arcatt' style='width:150'>
                <option value='0'>普通文档</option>
                <?
            	$dsql->SetQuery("Select * From #@__arcatt order by att asc");
            	$dsql->Execute();
            	while($trow = $dsql->GetObject())
            	{
            		if($arcRow["arcatt"]==$trow->att) echo "<option value='{$trow->att}' selected>{$trow->attname}</option>";
            		else echo "<option value='{$trow->att}'>{$trow->attname}</option>";
            	}
            	?>
              </select>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr id="pictable"> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="40"> &nbsp;缩 略 图：<br/> &nbsp; <input type='checkbox' class='np' name='ddisremote' value='1'>
              远程 </td>
            <td> <table width="98%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="56%" height="107"> 
                    <input name="picname" type="text" id="picname" style="width:300" value="<?=$arcRow["litpic"]?>"> 
                    <input type="button" name="Submit" value="浏览..." style="width:60" onClick="SelectImage('form1.picname','');"></td>
                  <td width="44%"><img src="<?=$arcRow["litpic"]?>" width="150" id="picview" name="picview"></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">图片来源：</td>
            <td width="240"> 
              <input name="source" type="text" id="source" style="width:200" value="<?=$arcRow["source"]?>">
            </td>
            <td width="90">&nbsp;</td>
            <td width="159">&nbsp; </td>
            <td>&nbsp; </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">内容排序：</td>
            <td width="240"> 
              <select name="sortup" id="sortup" style="width:150">
                <?
                $subday = SubDay($arcRow["sortrank"],$arcRow["senddate"]);
                echo "<option value='0'>正常排序</option>\r\n";
                if($subday>0) echo "<option value='$subday' selected>置顶 $subday 天</option>\r\n";
                ?>
                <option value="7">置顶一周</option>
                <option value="30">置顶一个月</option>
                <option value="90">置顶三个月</option>
                <option value="180">置顶半年</option>
                <option value="360">置顶一年</option>
              </select>
            </td>
            <td width="90">标题颜色：</td>
            <td width="159"> <input name="color" type="text" id="color" style="width:120" value="<?=$arcRow["color"]?>"> 
            </td>
            <td> 
              <input name="modcolor" type="button" id="modcolor" value="选取" onClick="ShowColor()"></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">阅读权限：</td>
            <td width="240"> 
              <select name="arcrank" id="arcrank" style="width:150">
                <option value='<?=$arcRow["arcrank"]?>'>
                <?=$arcRow["rankname"]?>
                </option>
                <?
              $urank = $cuserLogin->getUserRank();
              $dsql = new DedeSql(false);
              $dsql->SetQuery("Select * from #@__arcrank where adminrank<='$urank'");
              $dsql->Execute();
              while($row = $dsql->GetObject()){
              	echo "     <option value='".$row->rank."'>".$row->membername."</option>\r\n";
              }
              ?>
              </select>
            </td>
            <td width="90">发布选项：</td>
            <td><input name="ishtml" type="radio" class="np" value="1"<?if($arcRow["ismake"]!=-1) echo " checked";?>>
              生成HTML 
              <input type="radio" name="ishtml" class="np" value="0"<?if($arcRow["ismake"]==-1) echo " checked";?>>
              仅动态浏览</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="75" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90" height="51">图集说明：</td>
            <td width="240"> 
              <textarea name="description" rows="3" id="description" style="width:200"><?=$arcRow["description"]?></textarea>
            </td>
            <td width="90">关 键 字：</td>
            <td> <textarea name="keywords" rows="3" id="keywords" style="width:200"><?=$arcRow["keywords"]?></textarea></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">录入时间：</td>
            <td> 
              <?
			         $addtime = GetDateTimeMk($arcRow["senddate"]);
			         echo "$addtime (标准排序和生成HTML名称的依据时间) <input type='hidden' name='senddate' value='".$arcRow["senddate"]."'>";
			        ?>
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">发布时间：</td>
            <td width="240"> 
              <?
			$nowtime = GetDateTimeMk($arcRow["pubdate"]);
			echo "<input name=\"pubdate\" value=\"$nowtime\" type=\"text\" id=\"pubdate\" style=\"width:200\">";
			?>
            </td>
            <td width="90" align="center">消费点数：</td>
            <td>
<input name="money" type="text" id="money" value="<?=$arcRow["money"]?>" size="10">
            </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">主分类：</td>
            <td width="400"> 
          <?
           	$typeOptions = GetOptionList($arcRow["typeid"],$cuserLogin->getUserChannel(),$channelid);
           	echo "<select name='typeid' style='width:300'>\r\n";
            if($arcRow["typeid"]=="0") echo "<option value='0' selected>请选择主分类...</option>\r\n";
            echo $typeOptions;
            echo "</select>";
			    ?>
            </td>
            <td> （只允许在白色选项的栏目中发布当前类型内容）</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" bgcolor="#FFFFFF" class="bline2">
<table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">副分类：</td>
            <td width="400"> 
           <?
            $typeOptions = GetOptionList($arcRow["typeid2"],$cuserLogin->getUserChannel(),$channelid);
            echo "<select name='typeid2' style='width:300'>\r\n";
            echo "<option value='0' selected>请选择副分类...</option>\r\n";
            echo $typeOptions;
            echo "</select>";
            ?>
            </td>
            <td>&nbsp; </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr> 
      <td height="24" colspan="4" bgcolor="#FFFFFF" class="bline2">&nbsp; </td>
    </tr>
  </table>
  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" style="display:none" id="adset">
    <tr> 
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">表现方式：</td>
            <td> <input name="pagestyle" type="radio" class="np" value="1"<? if($pagestyle==1) echo " checked"; ?>>
              单页显示 
              <input name="pagestyle" class="np" type="radio" value="2"<? if($pagestyle==2) echo " checked"; ?>>
              分多页显示 
              <input name="pagestyle" class="np" type="radio" value="3"<? if($pagestyle==3) echo " checked"; ?>>
              多行多列显示</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">多列式参数：</td>
            <td>行 
              <input name="row" type="text" id="row" size="6" value="<?=$irow?>">
              　列 
              <input name="col" type="text" id="col" size="6" value="<?=$icol?>">
              　图片宽度限制： 
              <input name="ddmaxwidth" type="text" id="ddmaxwidth" size="6" value="150">
              像素
			  </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">限制宽度：</td>
            <td> <input name="maxwidth" type="text" id="maxwidth" size="10" value="<?=$maxwidth?>">
              (防止图片太宽在模板页中溢出) </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td height="24" colspan="4" class="bline"><table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">远程图片：</td>
            <td>
			<input name="isrm" type="checkbox" id="isrm" class="np" value="1"<?if($isrm==1) echo " checked";?>>
            下载远程图片
			 </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="100%" height="24" colspan="4" class="bline"> <table width="800" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="90">图片：</td>
            <td> <input name="picnum" type="text" id="picnum" size="8" value="10"> 
              <input name='kkkup' type='button' id='kkkup2' value='增加表单' onClick="MakeUpload(0);">
              注：最大40幅，图片链接允许填写远程网址 </td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td height="24" colspan="4" class="bline"> 
        <?
       $j = 1;
       if($imgurls!=""){
       	 $dtp = new DedeTagParse();
       	 $dtp->LoadSource($imgurls);
       	 if(is_array($dtp->CTags))
       	 {
       	 	 foreach($dtp->CTags as $ctag){
       	 	 	 if($ctag->GetName()=="img"){
                     $fhtml = "";
	   $fhtml .= "<table width='600'><tr><td><input type='checkbox' name='isokcheck$j' id='isokcheck$j' value='1' class='np' onClick='CheckSelTable($j)'>显示/隐藏图片[$j]的选框</td></tr></table>";
	   $fhtml .= "<table width=\"600\" border=\"0\" id=\"seltb$j\" cellpadding=\"1\" cellspacing=\"1\" bgcolor=\"#E8F5D6\" style=\"margin-bottom:6px;margin-left:10px\"><tobdy>";
	   $fhtml .= "<tr bgcolor=\"#F4F9DD\">\r\n";
	   $fhtml .= "<td height=\"25\" colspan=\"2\">　<strong>图片{$j}：</strong></td>";
	   $fhtml .= "</tr>";
	   $fhtml .= "<tr bgcolor=\"#FFFFFF\"> ";
	   $fhtml .= "<td width=\"429\" height=\"25\"> 　本地上传： ";
	   $fhtml .= "<input type=\"file\" name='imgfile$j' style=\"width:330px\" onChange=\"SeePic(document.picview$j,document.form1.imgfile$j);\"></td>";
	   $fhtml .= "<td width=\"164\" rowspan=\"3\" align=\"center\"><img src=\"".trim($ctag->GetInnerText())."\" width=\"150\" id=\"picview$j\" name=\"picview$j\"></td>";
	   $fhtml .= "</tr>";
	   $fhtml .= "<tr bgcolor=\"#FFFFFF\"> ";
	   $fhtml .= "<td height=\"25\"> 　指定网址： ";
	   $fhtml .= "<input type=\"text\" name='imgurl$j' style=\"width:260px\" value=\"".trim($ctag->GetInnerText())."\" > ";
	   $fhtml .= "<input type=\"button\" name='selpic$j' value=\"选取\" style=\"width:65px\" onClick=\"SelectImageN('form1.imgurl$j','big','picview$j')\">";
	   $fhtml .= "</td></tr>";
	   $fhtml .= "<tr bgcolor=\"#FFFFFF\"> ";
	   $fhtml .= "<td height=\"56\">　图片简介： ";
	   $fhtml .= "<textarea name='imgmsg$j' style=\"height:46px;width:330px\">".$ctag->GetAtt("text")."</textarea> </td>";
	   $fhtml .= "</tr></tobdy></table>\r\n";
       	 	 	 	 echo $fhtml; 
       	 	 	 	 $j++;
       	 	 	 }
       	 	 }
       	 }
       	 $dtp->Clear();
       }
       ?>
        <span id="uploadfield"></span>
		<script language="JavaScript">
		startNum = <?=$j?>;
		</script>
		</td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="56">
	<table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td width="17%">&nbsp;</td>
            <td width="83%"><table width="214" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="115"><input name="imageField" type="image" src="img/button_ok.gif" width="60" height="22" border="0"></td>
                  <td width="99"> <img src="img/button_reset.gif" width="60" height="22" border="0" onClick="location.reload();" style="cursor:hand"> 
                  </td>
                </tr>
              </table></td>
          </tr>
        </table></td>
  </tr>
</table>
</form>
<script language='javascript'>if($Nav()!="IE") ShowObj('adset');</script>
<?
$dsql->Close();
?>
</body>
</html>