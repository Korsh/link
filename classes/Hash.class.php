<?

class Hash {

	var $db;

	function Hash($DBH) {
		$this->db = $DBH;

	}

	function getHashByUrl($url) {
		try
		{
			$get_hash_by_url = $this->db->prepare("
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
			return $hash_url;
		}
		else
		{
			return false;
		}
	}

	function saveHashUrl($hash_url, $url) {
		try
		{ 
			$insert_hash_url = $this->db->prepare("
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

	function getUrlByHash($hash) {
		try
		{
			$get_url_by_hash = $this->db->prepare("
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
			return $origin_url;
		}
		else
		{
			return false;
		}
	}
}

?>
