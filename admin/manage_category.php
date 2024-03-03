<?php
include 'db_connect.php';
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM category_list where id={$_GET['id']}")->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-category">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="category" class="control-label">Thể loại</label>
			<input type="text" class="form-control form-control-sm" name="category" id="category" value="<?php echo isset($category) ? $category : '' ?>">
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Mô tả</label>
			<textarea name="description" id="description" cols="30" rows="3" class="form-control"><?php echo isset($description) ? $description : "" ?></textarea>
		</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('#manage-category').submit(function(e){
			e.preventDefault();
			start_load()
			$.ajax({
				url:'ajax.php?action=save_category',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp == 1){
						alert_toast("Data successfully saved.","success");
						setTimeout(function(){
							location.reload()	
						},1750)
					}
				}
			})
		})
	})

</script>