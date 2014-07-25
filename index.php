<?
	define('INCLUDE_DIR', 'inc/');
	define('LIB_DIR', 'libs/');
	define('MODULE_DIR', 'modules/');
	require_once(INCLUDE_DIR . 'data.php');
	require_once(INCLUDE_DIR . 'url.php');


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

	switch($param[1])
	{
		case "hash":
			$hash = !empty($param[2]) ? $param[2] : false;
			require_once(MODULE_DIR.'redirect.php');	
		default:
			require_once(MODULE_DIR.'main.php');
			break;
	}
	

	$smarty->display($display_page);
?>
