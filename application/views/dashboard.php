<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Controle paneel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Small boxes (Stat box) -->
    <?php // if ($is_admin == true) : 
    ?>

    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?php //echo $total_products ?></h3>

            <p>Reseveringen</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-calendar"></i>
          </div>
          <a href="<?php echo base_url('admin/reseveringen') ?>" class="small-box-footer">Meer info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php //echo $total_uitgiftes ?></h3>

            <p>Facturen</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-attach"></i>
          </div>
          <a href="<?php echo base_url('admin/facturen/') ?>" class="small-box-footer">Meer info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?php //echo $totaal_ingeleverd ?></h3>

            <p>Statastieken</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="<?php echo base_url('admin/statsieken/') ?>" class="small-box-footer">Meer info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?php //echo $total_users; ?></h3>

            <p>Gebruikers</p>
          </div>
          <div class="icon">
            <i class="ion ion-android-people"></i>
          </div>
          <a href="<?php echo base_url('users/') ?>" class="small-box-footer">Meer info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->

    </div>
    <!-- /.row -->
    <?php //endif; 
    ?>


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboardMainMenu").addClass('active');
  });
</script>