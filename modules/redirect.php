<?

	if(!empty($hash))
	{
		$origin_url = $hash_class->getUrlByHash($hash);
		if($origin_url)
		{
			header("Location: $origin_url");			
		}
		else
		{
			$smarty->assign("hash_url", false);
			echo "We can`t find that url";
		}
	}
	else
	{
		$smarty->assign("hash_url", false);
		echo "We can`t find that url";
	}
	
?>
