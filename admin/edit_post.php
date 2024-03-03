<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM post_list where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	if($k == 'title')
		$k = 'ptitle';
	$$k = $v;
}
include 'new_post.php';
?>