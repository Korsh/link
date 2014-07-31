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
			$get_hash_by_url->execute(array('url' => $url));
		}		
		catch(PDOException $e) 
		{  
			echo $e->getMessage();
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
		}
		if($get_hash_by_url->rowCount() > 0)
		{
			$hash_url = $get_hash_by_url->fetch(PDO::FETCH_ASSOC);	
			return $hash_url['hash_url'];
		}
		else
		{
			$flag = true;
			$i = 0;
			while($flag == true)
			{
				$hash_url = substr(md5($url.$i),0,8);
				$flag = $this->getUrlByHash($hash);
				$i++;
			}

			$this->saveHashUrl($hash_url, $url);
			return $hash_url;
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
				`url` = :url
			;"); 

			$insert_hash_url->execute(array('url' => $url, 'hash_url' => $hash_url));
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
			$get_url_by_hash->execute(array('hash_url' => $hash));
		}		
		catch(PDOException $e) 
		{  
			echo $e->getMessage();
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
		}	
		if($get_url_by_hash->rowCount() > 0)
		{
			$origin_url = $get_url_by_hash->fetch(PDO::FETCH_ASSOC);
			return $origin_url['url'];
		}
		else
		{
			return false;
		}
	}
}

?>
