<?
	include_once('common.php');
	$cpass =isset($_REQUEST['cpass'])?$_REQUEST['cpass']:'';
	
    $iCompanyId = $_SESSION['sess_iCompanyId'];
    $iDriverId = $_SESSION['sess_iUserId'];
	$iUserId = $_SESSION['sess_iUserId'];
	$iOrganizationId = $_SESSION['sess_iOrganizationId'];


	if($_SESSION['sess_user'] == 'rider'){
		$tbl = 'register_user';
		$where = " WHERE `iUserId` = '".$iUserId."'";
	}
	if($_SESSION['sess_user'] == 'driver')
	{
		$tbl = 'register_driver';
		$where = " WHERE `iDriverId` = '".$iDriverId."'";
	}
	if($_SESSION['sess_user'] == 'company')
	{
		$tbl = 'company';
		$where = " WHERE `iCompanyId` = '".$iCompanyId."'";
	}

	if($_SESSION['sess_user'] == 'organization')
	{
		$tbl = 'organization';
		$where = " WHERE `iOrganizationId` = '".$iOrganizationId."'";
	}
	
	$sql = "SELECT vPassword FROM $tbl $where";
	$db_login = $obj->MySQLSelect($sql);
	
	$hash = $db_login[0]['vPassword'];
	$checkValid = $generalobj->check_password($cpass, $hash);
	echo $checkValid;
	exit;
?>
