<?

	if(!empty($_POST['short_url_form']) && !empty($_POST['url']))
	{
		$url = $_POST['url'];
		$hash_url = $hash_class->getHashByUrl($url);
		if($hash_url)
		{			
			$smarty->assign("origin_url", $url);
			$smarty->assign("hash_url", $hash_url);

		}
		else
		{
			$hash_url =  substr(md5($url),0,8);
			$hash_class->saveHashUrl($hash_url, $url);
		} 
 
		header('Location: '.$_SERVER['SCRIPT_URI'].'?url='.$hash_url);
	}
	
	$hash_url = !empty($_GET['url']) ? $_GET['url'] : false;
	if($hash_url)
	{
		$origin_url = $hash_class->getUrlByHash($hash_url);
		if($origin_url)
		{
			$smarty->assign("origin_url", $origin_url);
			$smarty->assign("hash_url", $hash_url);
		}
		else
		{
			$smarty->assign("hash_url", false);
			echo "We can`t find that url";
		} 
	}

?>
