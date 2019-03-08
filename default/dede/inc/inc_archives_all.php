<?
//���һ�����ӱ���
//-----------------------------
function GetFormItem($ctag)
{
	$fieldname = $ctag->GetName();
	$formitem = "
		<table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
       <tr> 
        <td width=\"80\">~name~</td>
        <td width=\"720\">~form~</td>
       </tr>
    </table>\r\n";
	$innertext = trim($ctag->GetInnerText());
	if($innertext!=""){
		 if($ctag->GetAtt("type")=='select'){
		 	  $myformItem = '';
		 	  $items = explode(',',$innertext);
		 	  $myformItem = "<select name='$fieldname' style='width:150px'>";
		 	  foreach($items as $v){
		 	 	  $v = trim($v);
		 	 	  if($v!=''){ $myformItem.= "<option value='$v'>$v</option>\r\n"; }
		 	  }
		 	  $myformItem .= "</select>\r\n";
		 	  $formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		    $formitem = str_replace("~form~",$myformItem,$formitem);
		    return $formitem;
		 }else if($ctag->GetAtt("type")=='radio'){
		 	  $myformItem = '';
		 	  $items = explode(',',$innertext);
		 	  foreach($items as $v){
		 	 	  $v = trim($v);
		 	 	  $i = 0;
		 	 	  if($v!=''){
		 	 	  	if($i==0) $myformItem .= "<input type='radio' name='$fieldname' class='np' value='$v' checked>$v\r\n";
		 	 	  	else $myformItem .= "<input type='radio' name='$fieldname' class='np' value='$v'>$v\r\n";
		 	 	  }
		 	  }
		 	  $formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		    $formitem = str_replace("~form~",$myformItem,$formitem);
		    return $formitem;
		 }else{
		    $formitem = str_replace('~name~',$ctag->GetAtt('itemname'),$formitem);
		    $formitem = str_replace('~form~',$innertext,$formitem);
		    $formitem = str_replace('@value','',$formitem);
		    return $formitem;
		 }
	}
	
	if($ctag->GetAtt("type")=="htmltext"||$ctag->GetAtt("type")=="textdata")
	{
		$formitem = "";
		$formitem .= "<table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"80\">".$ctag->GetAtt('itemname')."</td><td>";
		$formitem .= GetEditor($fieldname,'',350,'Basic','string');
		$formitem .= "</td></tr></table>\r\n";
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="multitext")
	{
		$innertext = "<textarea name='$fieldname' id='$fieldname' style='width:100%;height:80'></textarea>\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="datetime")
	{
		$nowtime = GetDateTimeMk(mytime());
		$innertext = "<input name=\"$fieldname\" value=\"$nowtime\" type=\"text\" id=\"$fieldname\" style=\"width:200\">";
		$innertext .= "<input name=\"selPubtime\" type=\"button\" id=\"selkeyword\" value=\"ѡ��\" onClick=\"showCalendar('$fieldname', '%Y-%m-%d %H:%M:00', '24');\">";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="img")
	{
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300'><input name='".$fieldname."_bt' type='button' value='���...' onClick=\"SelectImage('form1.$fieldname','big')\">\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="media")
	{
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300'><input name='".$fieldname."_bt' type='button' value='���...' onClick=\"SelectMedia('form1.$fieldname')\">\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="addon")
	{
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300'><input name='".$fieldname."_bt' type='button' value='���...' onClick=\"SelectSoft('form1.$fieldname')\">\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="media")
	{
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:300'><input name='".$fieldname."_bt' type='button' value='���...' onClick=\"SelectMedia('form1.$fieldname')\">\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else
	{
		if($ctag->GetAtt('default')!="") $dfvalue = $ctag->GetAtt('default');
		else $dfvalue = "";
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:200' value='$dfvalue'>\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
}
//---------------------------
//������ͬ���͵�����
//---------------------------
function GetFieldValue($dvalue,$dtype,$aid=0,$job='add',$addvar='')
{
	if($dtype=="int"){
		$dvalue = trim(ereg_replace("[^0-9]","",$dvalue));
		if($dvalue=="") $dvalue = 0;
		return $dvalue;
	}
	else if($dtype=="float"){
		$dvalue = trim(ereg_replace("[^0-9\.]","",$dvalue));
		if($dvalue=="") $dvalue = 0;
		return $dvalue;
	}
	else if($dtype=="datetime"){
		return GetMkTime($dvalue);
	}
	else if($dtype=="textdata"){
		if($job=='edit'){
			$addvarDirs = explode('/',$addvar);
			$addvarDir = ereg_replace("/".$addvarDirs[count($addvarDirs)-1]."$","",$addvar);
			$mdir = $GLOBALS['cfg_basedir'].$addvarDir;
			if(!is_dir($mdir)){
				MkdirAll($mdir,$GLOBALS['cfg_dir_purview']);
			}
			$fp = fopen($GLOBALS['cfg_basedir'].$addvar,"w");
		  fwrite($fp,stripslashes($dvalue));
		  fclose($fp);
		  CloseFtp();
	    return $addvar;
	  }else{	
		  $ipath = $GLOBALS['cfg_cmspath']."/include/textdata";
		  $tpath = ceil($aid/5000);
		  if(!is_dir($GLOBALS['cfg_basedir'].$ipath)) MkdirAll($GLOBALS['cfg_basedir'].$ipath,777);
		  if(!is_dir($GLOBALS['cfg_basedir'].$ipath.'/'.$tpath)) MkdirAll($GLOBALS['cfg_basedir'].$ipath.'/'.$tpath,777);
		  $ipath = $ipath.'/'.$tpath;
		  $filename = "{$ipath}/{$aid}.txt";
		  $fp = fopen($GLOBALS['cfg_basedir'].$filename,"w");
		  fwrite($fp,stripslashes($dvalue));
		  fclose($fp);
		  CloseFtp();
	    return $filename;
	  }
	}
	else if($dtype=="img"){
		$iurl = stripslashes($dvalue);
    if(trim($iurl)=="") return "";
    $iurl = trim(str_replace($GLOBALS['cfg_basehost'],"",$iurl));
    $imgurl = "{dede:img text='' width='' height=''} ".$iurl." {/dede:img}";
    if(eregi("^http://",$iurl) && $GLOBALS['isUrlOpen']) //Զ��ͼƬ
    {
       $reimgs = "";
       if($isUrlOpen){
	       $reimgs = GetRemoteImage($iurl,$GLOBALS['adminID']);
	       if(is_array($reimgs)){
		        $imgurl = "{dede:img text='' width='".$reimgs[1]."' height='".$reimgs[2]."'} ".$reimgs[0]." {/dede:img}";
	       }
	     }else{
	     	 $imgurl = "{dede:img text='' width='' height=''} ".$iurl." {/dede:img}";
	     }
    }
    else if($iurl!=""){  //վ��ͼƬ
	     $imgfile = $GLOBALS['cfg_basedir'].$iurl;
	     if(is_file($imgfile)){
		     $imginfos = GetImageSize($imgfile,&$info);
		     $imgurl = "{dede:img text='' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}";
	     }
    }
    return addslashes($imgurl);
	}else{
		return $dvalue;
	}
}
//��ô�ֵ�ı���(�༭ʱ��)
//-----------------------------
function GetFormItemValue($ctag,$fvalue)
{
	$fieldname = $ctag->GetName();
	$formitem = "
		<table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
       <tr> 
        <td width=\"80\">~name~</td>
        <td width=\"720\">~form~</td>
       </tr>
    </table>\r\n";
  
  $innertext = trim($ctag->GetInnerText());
	if($innertext!=""){
		 if($ctag->GetAtt("type")=='select'){
		 	  $myformItem = '';
		 	  $items = explode(',',$innertext);
		 	  $myformItem = "<select name='$fieldname' style='width:150px'>";
		 	  foreach($items as $v){
		 	 	  $v = trim($v);
		 	 	  if($v!=''){
		 	 	  	if($fvalue==$v) $myformItem.= "<option value='$v' selected>$v</option>\r\n";
		 	 	  	else $myformItem.= "<option value='$v'>$v</option>\r\n";
		 	 	  }
		 	  }
		 	  $myformItem .= "</select>\r\n";
		 	  $formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		    $formitem = str_replace("~form~",$myformItem,$formitem);
		    return $formitem;
		 }else if($ctag->GetAtt("type")=='radio'){
		 	  $myformItem = '';
		 	  $items = explode(',',$innertext);
		 	  foreach($items as $v){
		 	 	  $v = trim($v);
		 	 	  if($v!=''){
		 	 	  	if($fvalue==$v) $myformItem.= "<input type='radio' name='$fieldname' class='np' value='$v' checked>$v\r\n";
		 	 	    else $myformItem.= "<input type='radio' name='$fieldname' class='np' value='$v'>$v\r\n";
		 	 	  }
		 	  }
		 	  $formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		    $formitem = str_replace("~form~",$myformItem,$formitem);
		    return $formitem;
		 }else{
		    $formitem = str_replace('~name~',$ctag->GetAtt('itemname'),$formitem);
		    $formitem = str_replace('~form~',$innertext,$formitem);
		    $formitem = str_replace('@value',$fvalue,$formitem);
		    return $formitem;
		 }
	}
  
  //�ı����ݵ����⴦��
  if($ctag->GetAtt("type")=="textdata")
  {
  	if(is_file($GLOBALS['cfg_basedir'].$fvalue)){
  	  $fp = fopen($GLOBALS['cfg_basedir'].$fvalue,'r');
		  $okfvalue = "";
		  while(!feof($fp)){ $okfvalue .= fgets($fp,1024); }
		  fclose($fp);
	  }else{ $okfvalue=""; }
		$formitem  = "<table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"80\">".$ctag->GetAtt('itemname')."</td>\r\n";
		$formitem .= "<td>\r\n".GetEditor($fieldname,$okfvalue,350,'Basic','string')."</td>\r\n";
		$formitem .= "</tr></table>\r\n";
		$formitem .= "<input type='hidden' name='{$fieldname}_file' value='{$fvalue}'>\r\n";
		return $formitem;
  }  
	else if($ctag->GetAtt("type")=="htmltext")
	{
		$formitem  = "<table width=\"800\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td width=\"80\">".$ctag->GetAtt('itemname')."</td>\r\n";
		$formitem .= "<td>\r\n".GetEditor($fieldname,$fvalue,350,'Basic','string')."</td>\r\n";
		$formitem .= "</tr></table>\r\n";
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="multitext")
	{
		$innertext = "<textarea name='$fieldname' id='$fieldname' style='width:100%;height:80'>$fvalue</textarea>\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="datetime")
	{
		$nowtime = GetDateTimeMk($fvalue);
		$innertext = "<input name=\"$fieldname\" value=\"$nowtime\" type=\"text\" id=\"$fieldname\" style=\"width:200\">";
		$innertext .= "<input name=\"selPubtime\" type=\"button\" id=\"selkeyword\" value=\"ѡ��\" onClick=\"showCalendar('$fieldname', '%Y-%m-%d %H:%M:00', '24');\">";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="img")
	{
		$ndtp = new DedeTagParse();
    $ndtp->LoadSource($fvalue);
    if(!is_array($ndtp->CTags)){
    	$ndtp->Clear();
    	$fvalue =  "";
    }
    $ntag = $ndtp->GetTag("img");
    $fvalue = trim($ntag->GetInnerText());
		$innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300'><input name='".$fieldname."_bt' type='button' value='���...' onClick=\"SelectImage('form1.$fieldname','big')\">\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="media")
	{
		$innertext = "<input type='text' name='$fieldname' value='$fvalue' id='$fieldname' style='width:300'><input name='".$fieldname."_bt' type='button' value='���...' onClick=\"SelectMedia('form1.$fieldname')\">\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else if($ctag->GetAtt("type")=="addon")
	{
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' value='$fvalue' style='width:300'><input name='".$fieldname."_bt' type='button' value='���...' onClick=\"SelectSoft('form1.$fieldname')\">\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
	else
	{
		$innertext = "<input type='text' name='$fieldname' id='$fieldname' style='width:200' value='$fvalue'>\r\n";
		$formitem = str_replace("~name~",$ctag->GetAtt('itemname'),$formitem);
		$formitem = str_replace("~form~",$innertext,$formitem);
		return $formitem;
	}
}
?>