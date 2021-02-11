<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Beheer
      <small>Tarieven</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Tarieven</li>
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
            <h3 class="box-title">Beheer tarieven</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTarieven" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>wat</th>
                  <th>prijs</th>
                  <th>type</th>
                  <th>max</th>
                  <?php if (in_array('updateCompany', $user_permission)) : ?>
                    <th>Actie</th>
                  <?php endif; ?>
                </tr>
              </thead>

            </table>
          </div>
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


<div class="modal fade" tabindex="-1" role="dialog" id="editPrice">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Verander prijzen</h4>
      </div>

      <form role="form" action="<?php echo base_url('admin/tarieven/update') ?>" method="post" id="updateForm">

        <div class="modal-body">

          <div class="form-group">
            <input type="text" class="form-control" id="what" name="what" placeholder="Wat is het" value="" autocomplete="off">
            <input type="number" class="form-control" id="price" name="price" placeholder="Prijs" value="" autocomplete="off">
          </div>
          <div class="form-group">

            <input type="number" class="form-control" id="max" name="max" placeholder="Maximale waarde" value="" autocomplete="off">
          </div>
          <div class="form-group">
            <label>Type prijs</label>
            <select id="type" name="type">
              <option value="number">Nummerieke waarde</option>
              <option value="switch">Enkele keuze</option>
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
          <button type="submit" class="btn btn-success">sla op</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php if (in_array('updateCompany', $user_permission)) : ?>
  <!-- remove brand modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Verwijder tarief</h4>
        </div>

        <form role="form" action="<?php echo base_url('admin/remove') ?>" method="post" id="editPriceModal">
          <div class="modal-body">
            <p>Zeker weten dat u deze wilt verwijderen?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
            <button type="submit" class="btn btn-primary">Sla wijzigingen op</button>
          </div>
        </form>


      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
<?php endif; ?>

<script>
  var manageTarieven;
  var base_url = "<?php echo base_url(); ?>";

  $(document).ready(function() {
    // initialize the datatable 
    manageTarieven = $('#manageTarieven').DataTable({
      'ajax': base_url + 'admin/tarieven/get',
      'data': []
    });

  });

  function editPrice(id) {

    if (id) {
      $.ajax({
        url: base_url + 'admin/tarieven/get/' + id,
        dataType: 'json',
        success: function(response) {
          console.log(response);
          $("#price").val(response.price);
          $("#what").val(response.what);
          $("#max").val(response.max);
          $("#type").val(response.type);
        }
      });
      $("#updateForm").on('submit', function() {
        console.log("Update");
        var form = $(this);
        //Get selected val

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {

            manageTarieven.ajax.reload(null, false);
            console.log(response);
            if (response.success === true) {
              console.log("Geupdate");
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                '</div>');

              // hide the modal
              $("#editPrice").modal('hide');

            } else {

              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        });

        return false;
      });
    }
  }
  // remove functions 
  function removeFunc(id) {
    if (id) {
      $("#removeForm").on('submit', function() {

        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: {
            order_id: id
          },
          dataType: 'json',
          success: function(response) {

            manageTable.ajax.reload(null, false);

            if (response.success === true) {
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>' + response.messages +
                '</div>');

              // hide the modal
              $("#removeModal").modal('hide');

            } else {

              $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + response.messages +
                '</div>');
            }
          }
        });

        return false;
      });
    }
  }
</script>