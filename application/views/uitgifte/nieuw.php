<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Beheer
            <small>uitgiftes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Uitgifte</li>
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
                        <h3 class="box-title">Voeg uitgifte toe</h3>
                    </div>
                    <!-- /.box-header -->
                    <form role="form" action="<?php base_url('uitgifte/nieuw') ?>" method="post" class="form-horizontal">
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
                                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Groep Nummer</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="groep_id" name="groep_id" placeholder="Groep nummer" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Customer Address</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="Enter Customer Address" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Customer Phone</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" placeholder="Enter Customer Phone" autocomplete="off">
                                    </div>
                                </div>
                            </div>


                            <br /> <br />
                            <table class="table table-bordered" id="product_info_table">
                                <thead>
                                    <tr>
                                        <th style="width:50%">Product</th>
                                        <th style="width:10%">Qty</th>

                                        <th style="width:20%">Aantal</th>
                                        <th style="width:10%"><button type="button" id="add_row" class="btn btn-default"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr id="row_1">
                                        <td>
                                            <select class="form-control select_group product" data-row-id="row_1" id="product_1" name="product[]" style="width:100%;" onchange="getProductData(1)" required>
                                                <option value=""></option>
                                                <?php foreach ($products as $k => $v) : ?>
                                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </td>
                                        <td><input type="text" name="qty[]" id="qty_1" class="form-control" required onkeyup="getTotal(1)"></td>

                                        <td>
                                            <input type="text" name="aantal[]" id="aantal_1" class="form-control" disabled autocomplete="off">
                                            <input type="hidden" name="aantal[]" id="aabtak_value_1" class="form-control" autocomplete="off">
                                        </td>
                                        <td><button type="button" class="btn btn-default" onclick="removeRow('1')"><i class="fa fa-close"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Nieuwe uitgifte</button>
                            <a href="<?php echo base_url('uitgifte/') ?>" class="btn btn-warning">Terug</a>
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

        $("#mainOrdersNav").addClass('active');
        $("#addOrderNav").addClass('active');

        var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
            'onclick="alert(\'Call your custom code here.\')">' +
            '<i class="glyphicon glyphicon-tag"></i>' +
            '</button>';

        // Add new row in the table 
        $("#add_row").unbind('click').bind('click', function() {
            var table = $("#product_info_table");
            var count_table_tbody_tr = $("#product_info_table tbody tr").length;
            var row_id = count_table_tbody_tr + 1;

            $.ajax({
                url: base_url + '/uitgifte/getTableProductRow/',
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    // console.log(reponse.x);
                    var html = '<tr id="row_' + row_id + '">' +
                        '<td>' +
                        '<select class="form-control select_group product" data-row-id="' + row_id + '" id="product_' + row_id + '" name="product[]" style="width:100%;" onchange="getProductData(' + row_id + ')">' +
                        '<option value=""></option>';
                    $.each(response, function(index, value) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });

                    html += '</select>' +
                        '</td>' +
                        '<td><input type="number" name="qty[]" id="qty_' + row_id + '" class="form-control" onkeyup="getTotal(' + row_id + ')"></td>' +

                        '<td><input type="text" name="aantal[]" id="aantal_' + row_id + '" class="form-control" disabled><input type="hidden" name="amount_value[]" id="amount_value_' + row_id + '" class="form-control"></td>' +
                        '<td><button type="button" class="btn btn-default" onclick="removeRow(\'' + row_id + '\')"><i class="fa fa-close"></i></button></td>' +
                        '</tr>';

                    if (count_table_tbody_tr >= 1) {
                        $("#product_info_table tbody tr:last").after(html);
                    } else {
                        $("#product_info_table tbody").html(html);
                    }

                    $(".product").select2();

                }
            });

            return false;
        });

    }); // /document

    function getTotal(row = null) {
        if (row) {
            var total = Number($("#rate_value_" + row).val()) * Number($("#qty_" + row).val());
            total = total.toFixed(2);
            $("#aantal_" + row).val(total);
            $("#aantal_value_" + row).val(total);

            subAmount();

        } else {
            alert('no row !! please refresh the page');
        }
    }

    // get the product information from the server
    function getProductData(row_id) {
        var product_id = $("#product_" + row_id).val();
        if (product_id == "") {


            $("#qty_" + row_id).val("");

            $("#aantal" + row_id).val("");
            $("#aantal_value" + row_id).val("");

        } else {
            $.ajax({
                url: base_url + 'uitgifte/getProductValueById',
                type: 'post',
                data: {
                    product_id: product_id
                },
                dataType: 'json',
                success: function(response) {
                    // setting the rate value into the rate input field


                    $("#qty_" + row_id).val(1);
                    $("#qty_value_" + row_id).val(1);

                    var total = Number(response.price) * 1;
                    total = total.toFixed(2);
                    $("#aantal" + row_id).val(total);
                    $("#aantal_value_" + row_id).val(total);

                    subAmount();
                } // /success
            }); // /ajax function to fetch the product data 
        }
    }



    function removeRow(tr_id) {
        $("#product_info_table tbody tr#row_" + tr_id).remove();
        subAmount();
    }
</script>