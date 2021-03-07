<?php

defined('_TEXEC') || exit('Restricted access');
$parts = explode(DS, TPATH_BASE);
define('TPATH_ROOT', TPATH_BASE);
define('TPATH_CLASS', TPATH_ROOT . DS . 'assets' . DS . 'libraries/');
include_once 'db_info.php';
define('PAYPAL_CLIENT_ID', 'AXE55Ggx7B1NpuhxfmKTcYipHIen2Lc1l9ZTU5Qt-4LbTpNmRm0vqCivgr1xkJF5uvg5rrzDwvB_30U-');
define('PAYPAL_SECRET', 'EMRwFwWhwXOQbD085uJN-3lugC00D2A2OGH-jQkowzwqQGiY14kwnsxrEuOu0dXmbZZ_xAR547Q1tghd');

if (!isset($obj)) {
	require_once TPATH_CLASS . 'class.dbquery.php';
	$obj = new DBConnection(TSITE_SERVER, TSITE_DB, TSITE_USERNAME, TSITE_PASS);
}

if (!isset($generalobj)) {
	require_once TPATH_CLASS . 'class.general.php';
	$generalobj = new General();
}

$generalobj->xss_cleaner_all();
$generalobj->getGeneralVar();
$date_before = date('Y-m-d');
$date_new = date('Y-m-d 00:00:00', strtotime('-1 week', strtotime($date_before)));
define('WEEK_DATE', $date_new);
define('SITE_TYPE', 'Live');
define('PAYMENT_OPTION', 'Manual');
define('SITE_COLOR', '#1fbad6');
if (!isset($_SESSION['sess_lang']) || ($_SESSION['sess_lang'] == '')) {
	$_SESSION['sess_lang'] = $generalobj->get_default_lang();
}

$sql22 = 'select vValue from configurations where vName=\'EASY_EDITING_TOKEN\'';
$db_config = $obj->MySQLSelect($sql22);
$sql = 'select vLabel,vValue,LanguageLabelId from language_label where vCode=\'' . $_SESSION['sess_lang'] . '\'';
$db_lbl = $obj->MySQLSelect($sql);

foreach ($db_lbl as $key => $value) {
	if (isset($_SESSION['sess_editingToken']) && ($_SESSION['sess_editingToken'] == $db_config[0]['vValue'])) {
		$langage_lbl[$value['vLabel']] = '<em class=\'label-dynmic\'><i class=\'fa fa-edit label-i\' data-id=\'' . $value['LanguageLabelId'] . '\' data-value=\'main\'></i>' . $value['vValue'] . '</em>';
	}
	else {
		$langage_lbl[$value['vLabel']] = $value['vValue'];
	}
}

$sql = 'select vLabel,vValue,LanguageLabelId from language_label_other where vCode=\'' . $_SESSION['sess_lang'] . '\'';
$db_lbl = $obj->MySQLSelect($sql);

foreach ($db_lbl as $key => $value) {
	if (isset($_SESSION['sess_editingToken']) && ($_SESSION['sess_editingToken'] == $db_config[0]['vValue'])) {
		$langage_lbl[$value['vLabel']] = '<em class=\'label-dynmic\'><i class=\'fa fa-edit label-i\' data-id=\'' . $value['LanguageLabelId'] . '\' data-value=\'other\'></i>' . $value['vValue'] . '</em>';
	}
	else {
		$langage_lbl[$value['vLabel']] = $value['vValue'];
	}
}

$sql = 'select vLabel,vValue from language_label where vCode=\'EN\'';
$db_lbl_admin = $obj->MySQLSelect($sql);

foreach ($db_lbl_admin as $key => $value) {
	$langage_lbl_admin[$value['vLabel']] = $value['vValue'];
}

$sql = 'select vLabel,vValue from language_label_other where vCode=\'EN\'';
$db_lbl_admin = $obj->MySQLSelect($sql);

foreach ($db_lbl_admin as $key => $value) {
	$langage_lbl_admin[$value['vLabel']] = $value['vValue'];
}

define('RIIDE_LATER', 'YES');
define('PROMO_CODE', 'YES');
$SITE_VERSION = $generalobj->getConfigurations('configurations', 'SITE_VERSION');
$ALLOW_SERVICE_PROVIDER_AMOUNT = $generalobj->getConfigurations('configurations', 'ALLOW_SERVICE_PROVIDER_AMOUNT');
if ((strpos($_SERVER['HTTP_HOST'], 'bbcsproducts.net') !== false) || (strpos($_SERVER['HTTP_HOST'], 'mobileappsdemo.com') !== false) || (strpos($_SERVER['HTTP_HOST'], 'mobileappsdemo.net') !== false) || (strpos($_SERVER['HTTP_HOST'], 'bbcsproducts.com') !== false) || (strpos($_SERVER['HTTP_HOST'], 'webprojectsdemo.com') !== false) || ($_SERVER['HTTP_HOST'] == '192.168.1.141') || ($_SERVER['HTTP_HOST'] == '192.168.1.131')) {
}
else if (strpos($_SERVER['HTTP_HOST'], 'ride.foodcyclebd.com') !== false) {
}
else {
	exit();
}

$sql_en = 'SELECT  `vLabel` , `vValue`  FROM  `language_label` WHERE  `vCode` = \'EN\' UNION SELECT `vLabel` , `vValue`  FROM  `language_label_other` WHERE  `vCode` = \'EN\'';
$all_label_en = $obj->MySQLSelect($sql_en);

if (0 < count($all_label_en)) {
	for ($i = 0; $i < count($all_label_en); $i++) {
		$vLabel_tmp = $all_label_en[$i]['vLabel'];
		$vValue_tmp = $all_label_en[$i]['vValue'];
		if (isset($x[$vLabel_tmp]) || array_key_exists($vLabel_tmp, $x)) {
			if ($x[$vLabel_tmp] == '') {
				$x[$vLabel_tmp] = $vValue_tmp;
			}

			continue;
		}

		$x[$vLabel_tmp] = $vValue_tmp;
	}
}

?>