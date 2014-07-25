<?

	if(!empty($hash))
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
			$get_url_by_hash->bindValue(':hash_url', $hash);
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
