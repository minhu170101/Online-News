<?php 
include 'admin/db_connect.php' ;
$qry = $conn->query("SELECT p.*,c.category FROM post_list p inner join category_list c on c.id = p.category_id where md5(p.id) = '{$_GET['c']}'")->fetch_array();
foreach($qry as $k =>$v){
	$$k = $v;
}
?>
<div class="col-lg-12 py-2">
	<div class="row">
		<div class="col-md-8">
			<div class="container-fluid">
				<div class="d-flex w-100 justify-content-center image-fluid">
				<img src="assets/uploads/content_images/<?php echo $cover_img ?>" class="image-fluid" style="min-width: calc(75%)" alt="">
				</div>
			</div>
			<br>
			<h4 class="border-bottom border-info"><b><?php echo ucwords($title) ?></b></h4>
			<div class="d-flex w-100 justify-content-between w-100">
				<small><i><b>Thể loại: <?php echo ucwords($category); ?></b></i></small><small><i><b>Ngày đăng: <?php echo date("F d,Y", strtotime($date_published)) ?></b></i></small>
			</div>
			<div class="d-block px-1 py-3">
				<?php echo html_entity_decode($content) ?>
			</div>
		</div>
		 <div class="col-md-3 py-2 px-3 offset-md-1 border-left">
	        <div class="card card-outline card-primary">
	          <div class="card-header py-1 px-2">
	          <b>Thể loại:</b>
	          </div>
	          <div class="card-body px-0">
	             <ul>
	            <?php 
	            $categories = $conn->query("SELECT * FROM category_list order by category asc");
	                while($row=$categories->fetch_assoc()):
	                  ?>
	                  <li><a href="./index.php?q=<?php echo md5($row['id']) ?>"><b><?php echo ucwords($row['category']) ?></b></a></li>
	             <?php      
	                endwhile;
	            ?>
	          </ul>
	          </div>
	        </div>
	        <div class="card card-outline card-primary">
	          <div class="card-header py-1 px-2">
	          <b>Các bài viết gần đây:</b>
	          </div>
	          <div class="card-body px-0">
	             <ul>
	            <?php 
	            $events = $conn->query("SELECT p.*,c.category from post_list p inner join category_list c on c.id = p.category_id where status = 1 order by unix_timestamp(date_published) desc limit 15");
	                while($row=$events->fetch_assoc()):
	                  ?>
	                  <li><a href="./index.php?page=read_news&c=<?php echo md5($row['id']) ?>" target="_blank" class="truncate-2"><b><?php echo ucwords($row['title']) ?></b></a></li>
	             <?php      
	                endwhile;
	            ?>
	          </ul>
	          </div>
	        </div>
	      </div>
	</div>
</div>