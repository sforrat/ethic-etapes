<?
    $nomfic = basename($_REQUEST['src']);
	header("Content-disposition: attachment; filename=$nomfic");
	header("Content-Type: application/force-download");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($_REQUEST['src']));
	header("Pragma: no-cache");
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header("Expires: 0");
    readfile($_REQUEST['src']);
?>
