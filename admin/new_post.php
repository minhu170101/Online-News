	<?php if(!isset($conn)){ include 'db_connect.php'; } ?>

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-post">

        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name="date_published" value="<?php echo isset($date_published) && $status == 1 ? $date_published : '' ?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="" class="control-label">Tựa đề</label>
							<input type="text" class="form-control form-control-sm" name="title" value="<?php echo isset($ptitle) ? $ptitle : '' ?>">
						</div>
					</div>
				</div>
        <div class="row">
           <div class="col-md-6">
            <div class="form-group">
              <label for="" class="control-label">Thể loại</label>
              <select name="category_id" id="category_id" class="custom-select select2">
              	<option value=""></option>
              <?php
              	$categories = $conn->query("SELECT * FROM category_list order by category asc");
              	while($row=$categories->fetch_assoc()):
              ?>
              <option value="<?php echo $row['id'] ?>" <?php echo isset($category_id) && $category_id == $row['id']? 'selected' : '' ?>><?php echo ucwords($row['category']) ?></option>
          	<?php endwhile; ?>
              </select>
            </div>
          </div>
        </div>
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					<label for="" class="control-label">Nội dung</label>
					<textarea name="content" id="" cols="30" rows="10" class="summernote2 form-control">
						<?php echo isset($content) ? $content : '' ?>
					</textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo isset($cover_img) ? '../assets/uploads/content_images/'.$cover_img :'' ?>" alt="No Image" id="cimg" class=" img-thumbnail">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<label for="" class="control-label">Ảnh bìa</label>
				<div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" name="cover" onchange="displayImg(this,$(this))" <?php echo isset($cover_img) && is_file('../assets/uploads/content_images/'.$cover_img) ? '':'required' ?>>
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="custom-control custom-switch">
                  <input type="checkbox" name="status" class="custom-control-input" id="publishToggle" <?php echo isset($status) && $status == 1 ? 'checked' : '' ?>>
                  <label class="custom-control-label" for="publishToggle">Publish</label>
                </div>
			</div>
		</div>
        </form>
    	</div>
    	<div class="card-footer border-top border-info">
    		<div class="d-flex w-100 justify-content-center align-items-center">
    			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-post">Save</button>
    			<button class="btn btn-flat bg-gradient-secondary mx-2" type="button" onclick="location.href='index.php?page=post_list'">Cancel</button>
    		</div>
    	</div>
	</div>
</div>
<style>
	.note-editor .note-dropzone { opacity: 0 !important; }
	img#cimg{
		max-height: 25vh !important;
		max-width: 35vw !important;
	}
</style>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$(document).ready(function(){
		$('.summernote2').summernote({
        height: 300,
        toolbar: [
            [ 'style', [ 'style' ] ],
            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
            [ 'fontname', [ 'fontname' ] ],
            [ 'fontsize', [ 'fontsize' ] ],
            [ 'color', [ 'color' ] ],
            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
            [ 'table', [ 'table' ] ],
            [ 'insert', [ 'link','picture' ] ],
            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
        ],
        callbacks:{
	        onImageUpload: function(files) {
		      saveImg(files[0]);
		    }
        }

    })
		function saveImg(_file){
		var data = new FormData();
    		data.append("file", _file);
			$.ajax({
		      data: data,
		      type: "POST",
		      url: "ajax.php?action=save_image",
		      cache: false,
		      contentType: false,
		      processData: false,
		      success: function(resp) {
		        var image = $('<img>').attr('src', resp);
           		 $('.summernote2').summernote("insertNode", image[0]);
		      }
		    });
		}
	})

	$('#manage-post').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_post',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
						location.href = 'index.php?page=post_list'
					},2000)
				}
			}
		})
	})
</script>