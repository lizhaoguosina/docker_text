<?
require_once(dirname(__FILE__)."/config.php");
require_once(dirname(__FILE__)."/../include/pub_datalist_dm.php");
require_once(dirname(__FILE__)."/../include/inc_functions.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

function MediaType($tid,$nurl)
{
	if($tid==1) return "ͼƬ<a href=\"javascript:;\" onClick=\"ChangeImage('$nurl');\"><img src='../include/dialog/img/picviewnone.gif' name='picview' border='0' alt='Ԥ��'></a>";
	else if($tid==2) return "FLASH";
	else if($tid==3) return "��Ƶ/��Ƶ";
	else return "����/����";
}

function GetFileSize($fs){
	$fs = $fs/1024;
	return sprintf("%10.1f",$fs)." K";
}

function UploadAdmin($adminid,$memberid)
{
	if($adminid!='') return $adminid;
	else return $memberid;
}


if(empty($keyword)) $keyword = "";
$addsql = " where (u.title like '%$keyword%' Or u.url like '%$keyword%') ";

if(empty($membertype)) $membertype = 0;
if($membertype==1) $addsql .= " And u.adminID>0 ";
else if($membertype==2) $addsql .= " And u.memberID>0 ";

if(empty($mediatype)) $mediatype = 0;
if($mediatype>1) $addsql .= " And u.mediatype='$membertype' ";

$sql = "Select u.aid,u.title,u.url,u.mediatype,u.filesize,u.memberID,u.uptime
,a.userid as adminname,m.userid as membername
From #@__uploads u
Left join #@__admin a on  a.ID = u.adminID
Left join #@__member m on m.ID = u.memberID
$addsql order by u.aid desc";

$dlist = new DataList();
$dlist->pageSize = 20;
$dlist->Init();
$dlist->SetParameter("mediatype",$mediatype);
$dlist->SetParameter("keyword",$keyword);
$dlist->SetParameter("membertype",$membertype);
$dlist->SetSource($sql);
include(dirname(__FILE__)."/templets/media_main.htm");
$dlist->Close();
?>