<?php 

?>
<div class="col-lg-12">
	<h4 class="text-center"><b>About</b></h4>
	<div class="card card-outline card-primary">
		<div class="card-body">
			<div class="container-fluid py-2 px-1">
				<?php echo file_exists('about.html') ?  file_get_contents('about.html') : '' ?>
			</div>
		</div>
	</div>
</div>