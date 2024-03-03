<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<button class="btn btn-block btn-sm btn-default btn-flat border-primary" type="button" id="manage_category"><i class="fa fa-plus"></i> Thêm mới</button>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="10%">
					<col width="30%">
					<col width="50%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Tên</th>
						<th>Mô tả</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM category_list order by unix_timestamp(date_created) desc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo ucwords($row['category']) ?></b></td>
						<td><b class="truncate"><?php echo ($row['description']) ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <button data-id="<?php echo $row['id'] ?>" class="btn btn-primary btn-flat edit_category" type="button">
		                          <i class="fas fa-edit"></i>
		                        </button>
		                        <button type="button" class="btn btn-danger btn-flat delete_category" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
	$('.delete_category').click(function(){
	_conf("Are you sure to delete this category?","delete_category",[$(this).attr('data-id')])
	})
	$('#manage_category').click(function(){
		uni_modal("New Category",'manage_category.php')
	})
	$('.edit_category').click(function(){
		uni_modal("New Category",'manage_category.php?id='+$(this).attr('data-id'))
	})
	})
	function delete_category($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_category',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>