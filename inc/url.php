<?php
	$url=$_SERVER['REQUEST_URI'];
	if(strpos($url,"?"))
	$url=substr($url,0,strpos($url,"?"));
	$param=explode("/",$url);

	$i=0;
	if(isset($param[1])&&($param[1]!=""))
	{
   		$part=$param[1];
	}
	else
	{
		$part="main";
		$param[1] = "main";
	}

?>
