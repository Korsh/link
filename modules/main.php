<?

	if(!empty($_POST['short_url_form']) && !empty($_POST['url']))
	{
		$url = $_POST['url'];

		try
		{
			$get_hash_by_url = $DBH->prepare("
				SELECT
					`hash_url`
				FROM
					`links`
				WHERE `url` = :url LIMIT 1
				;");    		
			$get_hash_by_url->bindValue(':url', $url);
			$get_hash_by_url->execute();
		}		
		catch(PDOException $e) 
		{  
			echo $e->getMessage();
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
		}      

		if($get_hash_by_url->rowCount() > 0)
		{
			$i = 0;
			$rows = $get_hash_by_url->fetchAll();
			foreach($rows as $row){
				$hash_url = $row['hash_url'];		
			}
			$smarty->assign("origin_url", $url);
			$smarty->assign("hash_url", $hash_url);
		}
		else
		{
			$hash_url =  substr(md5($url),0,8);
			try
			{ 
				$insert_hash_url = $DBH->prepare("
				INSERT INTO 
					`links` (
					`hash_url`,
					`url`
				)
				VALUES (
					:hash_url,
					:url
				)
				ON DUPLICATE KEY UPDATE            
					`url` = :url2
				;"); 
				$insert_hash_url->bindValue(':url', $url);
				$insert_hash_url->bindValue(':url2', $url);
				$insert_hash_url->bindValue(':hash_url', $hash_url);
				$insert_hash_url->execute();
			}
			catch(PDOException $e) 
			{
				echo $e->getMessage();          
				file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
			}
		} 
 
		header('Location: '.$_SERVER['SCRIPT_URI'].'?url='.$hash_url);
	}
	
	$hash_url = !empty($_GET['url']) ? $_GET['url'] : false;
	if($hash_url)
	{
		try
		{
			$get_url_by_hash = $DBH->prepare("
				SELECT
					`url`
				FROM
					`links`
				WHERE `hash_url` = :hash_url LIMIT 1
				;");    		
			$get_url_by_hash->bindValue(':hash_url', $hash_url);
			$get_url_by_hash->execute();
		}		
		catch(PDOException $e) 
		{  
			echo $e->getMessage();
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
		}      

		if($get_url_by_hash->rowCount() > 0)
		{
			$i = 0;
			$rows = $get_url_by_hash->fetchAll();
			foreach($rows as $row){
				$origin_url = $row['url'];		
			}
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
