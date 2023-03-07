<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if ($this->session->userdata('level') == 'Anggota') {
  redirect(base_url('transaksi'));
} ?>
<!-- Content Wrapper. Contains page content -->
<!-- Content Header (Page header) -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-sm-12">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <!-- <h3><?= $count_pengguna; ?></h3> -->

              <p>Report</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            <br>
            <br>
            <a href="report" class="small-box-footer"> </a>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!--small box-->
          <div class="small-box bg-blue">
            <div class="inner">
              <!-- <h3><?= $count_buku; ?></h3> -->

              <p>Project</p>
            </div>
            <div class="icon">
            </div>
            <br>
            <br>
            <a href="report" class="small-box-footer"> </a>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
          </div>
        </div>

      </div>

    </div>
</div>
</section>
</div>
<!-- /.content -->