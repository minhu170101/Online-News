<?php
include 'db_connect.php' ;	

$qry = $conn->query("SELECT p.*,c.category FROM post_list p inner join category_list c on c.id = p.category_id where p.id = {$_GET['id']}")->fetch_array();
foreach($qry as $k =>$v){
	$$k = $v;
}
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-outline card-info">
				<div class="card-body">
					<div class="">
						<dl class="callout callout-info">
							<dt>Tựa đề</dt>
							<dd><?php echo ucwords($title) ?></dd>
						</dl>
						<dl class="callout callout-info">
							<dt>Thể loại</dt>
							<dd><?php echo ucwords($category) ?></dd>
						</dl>
						<dl class="callout callout-info">
							<dt>Nội dung</dt>
							<dd><?php echo html_entity_decode($content) ?></dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#manage-registrar').click(function(){
		uni_modal("Manage Event's Assigned Registrar/s","manage_registrar.php?id=<?php echo $id ?>");
	})
</script>