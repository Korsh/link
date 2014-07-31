<?
	define('INCLUDE_DIR', 'inc/');
	define('LIB_DIR', 'libs/');
	define('CLASS_DIR', 'classes/');
	require_once(INCLUDE_DIR . 'data.php');
	require_once(INCLUDE_DIR . 'url.php');
	require_once(CLASS_DIR . 'Hash.class.php');

	define('SMARTY_DIR', LIB_DIR . 'Smarty/');
	require_once(SMARTY_DIR . 'Smarty.class.php');
	define('SMARTY_TEMPLATE_DIR', 'templates/');
	define('SMARTY_TEMPLATE_С_DIR', SMARTY_TEMPLATE_DIR . 'templates_c/');

	$smarty = new Smarty;
	$smarty->compile_check = true;
	$smarty->debugging = false;
	$smarty->template_dir = SMARTY_TEMPLATE_DIR;
	$smarty->compile_dir = SMARTY_TEMPLATE_С_DIR;
	$display_page = 'index.tpl';

	$hash_class = new Hash($DBH);
	$server_uri = $_SERVER['REQUEST_URI'];


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
				$smarty->assign("hash_url", false);
				$smarty->assign("error", "We can`t find that url");
		} 
	}

	if(!empty($_GET['hash']))
	{
		$hash = $_GET['hash'];
		$origin_url = $hash_class->getUrlByHash($hash);
		if($origin_url)
		{
			header("Location: $origin_url");			
		}
		else
		{
			$smarty->assign("hash_url", false);
			$smarty->assign("error", "We can`t find that url");
		}
	}	

	$smarty->display($display_page);
?>
