<?php
	
	function parseUrl($request_uri) {	
		$request_uri = strpos($url,"?") ? substr($request_uri,0,strpos($request_uri,"?")) : $request_uri;
		$param = explode("/",$request_uri);
		$param[1] = !empty($param[1]) ? $param[1] : "main";
		return $param;
	}

?>
