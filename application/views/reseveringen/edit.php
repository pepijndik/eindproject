<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Beheer
      <small>Reservering</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Reservering</li>
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
            <h3 class="box-title">Edit reservering</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('admin/reseveringen/edit') ?>" method="post" id="reserveringEditForm" class="form-horizontal">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="gross_amount" class="col-sm-12 control-label">Datum: <?php echo date('Y-m-d') ?></label>
              </div>
              <div class="form-group">
                <label for="gross_amount" class="col-sm-12 control-label">Tijd: <?php echo date('h:i') ?></label>
              </div>

              <div class="col-md-4 col-xs-12 pull pull-left">

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Klant</label>
                  <div class="col-sm-7">
                    <select name="klant" id="editklanten" style="width: 250px;">
                      <option value="">Selecteer klant</option>
                      <option value="n">Nieuwe klant</option>
                      <?php foreach ($klanten as $k => $v) : ?>
                        <option <?= $reservering['klant_id'] == $v['id'] ? ' selected="selected"' : ''; ?> value="<?php echo $v['id'] ?>"><?php echo $v['voornaam'] . " " . $v['achternaam'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Aankomst datum</label>
                  <div class="col-sm-7">
                    <input type="hidden" name="reservering_id" value="<?php echo $reservering['id'] ?>" />
                    <input type="text" class="form-control" id="aankomst_datum" name="aankomst_datum" value="<?php echo $reservering['aankomst'] ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Vertrek datum</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="vertrek_datum" name="vertrek_datum" value="<?php echo $reservering['vertrek'] ?>" autocomplete="off">
                  </div>
                </div>
              </div>
            </div>

            <div class="box-body">


              <div class="col-md-12 col-xs-12">
                <table class="rform table table-bordered">

                  <?php
                  //Create custom form options
                  foreach ($form_options as $option) {
                    // var_dump($option);
                    // echo "<br></br>";
                    if ($option['type'] == "number") {
                  ?>
                      <tr>
                        <td>
                          <label for=" <?php echo $option['id'] ?>" class="control-label" style="text-align:left;">aantal <?php echo $option['what'] ?></label>
                        </td>
                        <td>
                          <input type="hidden" name="options[]" value="<?php echo $option['selected_option'] ?>">
                          <input class="form-control" name="value[]" onchange="calc('<?php echo $option['id'] ?>')" value="<?php echo $option['value'] ?>" id="<?php echo $option['id'] ?>" <?php if (isset($option['max '])) {
                                                                                                                                                                                              $max = $option['max'];
                                                                                                                                                                                              echo "max=\"$max\"";
                                                                                                                                                                                            } ?> min="0" type="<?php echo $option['type'] ?>" value="">
                        </td>
                      </tr>
                    <?php
                    }
                    if ($option['type'] == "switch") {
                    ?>
                      <tr>
                        <td>
                          <label for="<?php echo $option['id'] ?>" class="control-label" style="text-align:left;"><?php echo $option['what'] ?></label>
                        </td>
                        <td>
                          <label class="switch">
                            <input type="hidden" name="options[]" value="<?php echo $option['selected_option'] ?>">
                            <?php if ($option['value'] == 'off') {
                            ?>
                              <input id="<?php echo $option['id'] ?>_hidden" name="value[]" value="off" type="hidden">
                            <?php
                            }
                            ?>
                            <input id="<?php echo $option['id'] ?>" name="value[]" onclick="checkbox(this,<?php echo $option['id'] ?>, 'reserveringEditForm')" value="on" type="checkbox" <?php echo ($option['value'] == 'on' ? 'checked' : ''); ?>>
                            <span class="slider round"></span>
                          </label>
                        </td>
                      </tr>
                  <?php
                    }
                  }
                  ?>
                </table>

                <!-- Optie's voor auto 
                optie's voor huisdier.
                aantal kinderen t/m 4
                aantal kinderen v4_t12
                aantal volwassenen
                vertrek
                elektra -->
              </div>

              <br /> <br />

              <div class="col-md-6 col-xs-12 pull pull-right">



                <?php if ($is_vat_enabled == true) : ?>
                  <div class="form-group">
                    <label for="vat_charge" class="col-sm-5 control-label">Btw <?php echo $company_data['vat_charge_value'] ?> %</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="vat_charge" name="vat_charge" disabled autocomplete="off">
                      <input type="hidden" class="form-control" id="vat_charge_value" value="<?php echo $company_data['vat_charge_value'] ?>" name="vat_charge_value" autocomplete="off">
                    </div>
                  </div>
                <?php endif; ?>
                <div class="form-group">
                  <label for="discount" class="col-sm-5 control-label">Korting</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="discount" name="korting" placeholder="Korting" onkeyup="subAmount()" value=" <?php echo $reservering['discount'] ?>" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label">Totaal</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="" name="gross_amount" disabled autocomplete="off">
                  </div>
                </div>


              </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Bewerk reservering</button>
              <a href="<?php echo base_url('reseveringen/view') ?>" class="btn btn-warning">Terug</a>
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
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="newCustomer">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nieuwe klant</h4>
      </div>

      <form role="form" action="<?php echo base_url('admin/klant/create') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <div class="">
            <input type="name" name="naam" placeholder="naam">
            <input type="middlename" name="tvoegsel" placeholder="Tussen voegsel">

            <input type="lastname" name="achternaam" placeholder="Achternaam">
          </div>

          <input type="email" name="email" placeholder="Email">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
          <button type="submit" class="btn btn-primary">Toevoegen</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
  var base_url = "<?php echo base_url(); ?>";


  $(document).ready(function() {
    $(".select_group").select2();
    // $("#description").wysihtml5();
    //var booked_dates = getBookedDates();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
      'onclick="alert(\'Call your custom code here.\')">' +
      '<i class="glyphicon glyphicon-tag"></i>' +
      '</button>';

    $("#editklanten").select2();
    $("#editklanten").on('change', function() {
      if (this.value == "n") {
        console.log("create new customer");
        $("#newCustomer").modal('show');
      }

    });
  }); // /document
  $('#aankomst_datum').datepicker({
    format: "yyyy-mm-dd",
    language: "nl",
    keyboardNavigation: false

  });

  $('#vertrek_datum').datepicker({
    format: "yyyy-mm-dd",
    language: "nl",
    keyboardNavigation: false
  });

  function removeElement(elementId) {
    // Removes an element from the document
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
  }

  function calc(response) {

    console.log("calc");
    console.log(response);

    var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value'] : 0; ?>;
    var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value'] : 0; ?>;

    var amount_adult = $("#a_adult").val(); //Get adults

    var amount_child_4 = $("#a_child_v4").val();

    var amount_child_12 = $("#a_child_v4_t12").val();

    var totalSubAmount = 0;


    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    // vat
    var vat = (Number($("#gross_amount").val()) / 100) * vat_charge;
    vat = vat.toFixed(2);
  }

  function getTotal(row = null) {
    if (row) {
      var total = Number($("#rate_value_" + row).val()) * Number($("#qty_" + row).val());
      total = total.toFixed(2);
      $("#amount_" + row).val(total);
      $("#amount_value_" + row).val(total);

      subAmount();

    } else {
      alert('no row !! please refresh the page');
    }
  }




  // calculate the total amount of the order
  function subAmount() {
    console.log("test");


    //    getPrices("Volwassenen");
    // var tableProductLength = $("#product_info_table tbody tr").length;
    var totalSubAmount = 0;


    // for (x = 0; x < tableProductLength; x++) {
    //   var tr = $("#product_info_table tbody tr")[x];
    //   var count = $(tr).attr('id');
    //   count = count.substring(4);

    //   totalSubAmount = Number(totalSubAmount) + Number($("#amount_" + count).val());
    // } // /for

    totalSubAmount = totalSubAmount.toFixed(2);

    // sub total
    $("#gross_amount").val(totalSubAmount);
    $("#gross_amount_value").val(totalSubAmount);

    // vat
    var vat = (Number($("#gross_amount").val()) / 100) * vat_charge;
    vat = vat.toFixed(2);
    $("#vat_charge").val(vat);
    $("#vat_charge_value").val(vat);

    // service
    var service = (Number($("#gross_amount").val()) / 100) * service_charge;
    service = service.toFixed(2);
    $("#service_charge").val(service);
    $("#service_charge_value").val(service);

    // total amount
    var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
    totalAmount = totalAmount.toFixed(2);
    // $("#net_amount").val(totalAmount);
    // $("#totalAmountValue").val(totalAmount);

    var discount = $("#discount").val();
    if (discount) {
      var grandTotal = Number(totalAmount) - Number(discount);
      grandTotal = grandTotal.toFixed(2);
      $("#net_amount").val(grandTotal);
      $("#net_amount_value").val(grandTotal);
    } else {
      $("#net_amount").val(totalAmount);
      $("#net_amount_value").val(totalAmount);

    } // /else discount 

  } // /sub total amount
</script>