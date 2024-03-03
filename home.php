<?php include('admin/db_connect.php') ?>
<div class="col-lg-12">
  <div class="row">
<!-- 
      <div class="input-group">
          <input type="search" id="filter" class="form-control form-control-lg" placeholder="Type your keywords here">
          <div class="input-group-append">
              <button type="button" id="search" class="btn btn-lg btn-default">
                  <i class="fa fa-search"></i>
              </button>
          </div>
      </div> -->
      <div class="col-md-8 py-2">
            <?php
            $where = '';
            if(isset($_GET['q'])){
               $where = " and md5(p.category_id) = '{$_GET['q']}' ";

            }
              $news = $conn->query("SELECT p.*,c.category from post_list p inner join category_list c on c.id = p.category_id where status = 1 $where order by unix_timestamp(date_published) desc");
              if($news->num_rows > 0):
              while($row = $news->fetch_assoc()):
                $trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
                  unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                  $desc = strtr(html_entity_decode($row['content']),$trans);
                  $desc=str_replace(array("<li>","</li>"), array("",", "), $desc);
            ?>
            <a class="event-item text-white" href="./index.php?page=read_news&c=<?php echo md5($row['id']) ?>" data-id = '<?php echo $row['id'] ?>'>
              <div class="card my-2" style="">
                <!-- Add the bg color to the header using any of the bg-* classes -->
               <div class="card-img-top position-relative">
                 <img src="assets/uploads/content_images/<?php echo $row['cover_img'] ?>" class="image-fluid w-100" alt="...">
                 <div class="position-absolute d-flex w-100 d-block py-2 px-1 news-title" style="height:calc(100%);top:0;left: 0">
                  <div class="align-self-end mb-2">
                    <h4 class=""><b><?php echo $row['title'] ?></b></h4>
                    <p class="truncate text-white"><?php echo strip_tags($desc) ?></p>
                  </div>
                 </div>
               </div>
              </div>
            </a>
          <?php endwhile; ?>
          <?php else: ?>
            <h6 class="text-center my-4 pt-4"><b>Không có dữ liệu để hiển thị.</b></h6>
          <?php endif; ?>
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
<style>
  .item-img{
    height: 13rem;
    overflow:hidden;
  }
.news-title{
    background: linear-gradient(180deg, rgba(255,255,255,0) 46%, rgb(0 0 0 / 120%) 100%);
}
</style>
<script>
  $('.event-item').hover(function(){
    $(this).find('.card').addClass('border border-info')
  })
  $('.event-item').mouseleave(function(){
    $(this).find('.card').removeClass('border border-info')
  })
  function _search(){
    var _f = $('#filter').val()
        _f = _f.toLowerCase();
    $('.event-item').each(function(){
        var txt = $(this).text().toLowerCase()
        if(txt.includes(_f) == true){
              $(this).toggle(true)

        }else{
            $(this).toggle(false)

        }
    })
  }
  $('#search').click(function(){
    _search()
  })
  $('#filter').on('keypress',function(e){
    if(e.which ==13){
    _search()
     return false; 
    }
  })
  $('#filter').on('search', function () {
      _search()
  });
</script>