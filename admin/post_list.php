<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="./index.php?page=new_post"><i class="fa fa-plus"></i> Thêm mới</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Đã tạo</th>
						<th>Thể loại</th>
						<th>Tựa đề</th>
						<th>Trạng thái</th>
						<th>Ngày đăng</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT p.*,c.category FROM post_list p inner join category_list c on c.id = p.category_id order by unix_timestamp(p.date_created) desc,unix_timestamp(p.date_published) desc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<th class="text-center"><?php echo $i++ ?></th>
						<td><b><?php echo date("M d,Y h:i A",strtotime($row['date_created']))?></b></td>
						<td><b><?php echo ucwords($row['category']) ?></b></td>
						<td><b><?php echo ucwords($row['title']) ?></b></td>
						<td class="text-center">
							<div class="d-block">
							<?php if($row['status'] == 0): ?>
								<span class="badge badge-secondary">Unpublished</span>
							<?php elseif($row['status'] == 1): ?>
								<span class="badge badge-primary">Published</span>
							<?php endif; ?>
							</div>
						</td>
						<td><b><?php echo ($row['status'] == 1)? date("M d,Y h:i A",strtotime($row['date_published'])) : 'N/A' ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="./index.php?page=edit_post&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                         <a href="./index.php?page=view_post&id=<?php echo $row['id'] ?>" class="btn btn-info btn-flat">
		                          <i class="fas fa-eye"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_post" data-id="<?php echo $row['id'] ?>">
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
	$('.delete_post').click(function(){
	_conf("Are you sure to delete this post?","delete_post",[$(this).attr('data-id')])
	})

	$('.status_chk').change(function(){
		var status = $(this).prop('checked') == true ? 1 : 2;
		if($(this).attr('data-state-stats') !== undefined && $(this).attr('data-state-stats') == 'error'){
			$(this).removeAttr('data-state-stats')
			return false;
		}
		// return false;
		var id = $(this).attr('data-id');
		start_load()
		$.ajax({
			url:'ajax.php?action=update_post_stats',
			method:'POST',
			data:{id:id,status:status},
			error:function(err){
				console.log(err)
				alert_toast("Something went wrong while updating the post's status.",'error')
					$('#status_chk').attr('data-state-stats','error').bootstrapToggle('toggle')
					end_load()
			},
			success:function(resp){
				if(resp == 1){
					alert_toast("post status successfully updated.",'success')
					end_load()
				}else{
					alert_toast("Something went wrong while updating the post's status.",'error')
					$('#status_chk').attr('data-state-stats','error').bootstrapToggle('toggle')
					end_load()
				}
			}
		})
	})
	})
	function delete_post($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_post',
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