<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Beheer
      <small>Nieuws</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Nieuws</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if ($this->session->flashdata('success')) : ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif ($this->session->flashdata('error')) : ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>


        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Voeg Nieuws toe</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('admin/news/create') ?>" method="post" class="form-horizontal">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="gross_amount" class="col-sm-12 control-label">Datum: <?php echo date('Y-m-d') ?></label>
              </div>
              <div class="form-group">
                <label for="gross_amount" class="col-sm-12 control-label">Tijd: <?php echo date('h:i a') ?></label>
              </div>

              <div class="col-md-4 col-xs-12 pull pull-left">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Title</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="news_title" name="news_title" placeholder="Nieuws titel" autocomplete="off" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Beschrijving</label>
                  <div class="col-sm-7">
                  <textarea name="news_beschrijving"  class="form-control"></textarea> 
                    <!-- <input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="Enter Customer Address" autocomplete="off"> -->
                  </div>
                </div>
              </div>


              <br /> <br />


              <div class="col-md-6 col-xs-12 pull pull-right">
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Voeg toe</button>
              <a href="<?php echo base_url('/admin/dashboard') ?>" class="btn btn-warning">Terug</a>
            </div>
          </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();

    $("#mainNewsNav").addClass('active');
    $("#addNewsNav").addClass('active');


  }); // /document
</script>