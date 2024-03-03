<?php include('db_connect.php') ?>
<!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-newspaper"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Số bài viết đã đăng</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM post_list where status = 1")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
           <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-newspaper"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Số bài viết đăng hôm nay</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM post_list where status = 1 and date(date_published) = date(now()) ")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Số thể loại</span>
                <span class="info-box-number">
                  <?php echo $conn->query("SELECT * FROM category_list ")->num_rows; ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
      </div>
