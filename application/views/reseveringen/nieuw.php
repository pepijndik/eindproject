<style>
  .modal-lg {
    max-width: 100% !important;
  }
</style><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Beheer
      <small>uitgiftes</small>
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
            <h3 class="box-title">Nieuwe reservering</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" id="reserveringFormadd" action="<?php base_url('admin/reseveringen/create') ?>" method="post" class="form-horizontal">
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
                    <select name="klant" id="klanten" style="width: 250px;">
                      <option value="">Selecteer klant</option>
                      <option value="n">Nieuwe klant</option>
                      <?php foreach ($klanten as $k => $v) : ?>
                        <option value="<?php echo $v['id'] ?>"><?php echo $v['voornaam'] . " " . $v['achternaam'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-success" data-toggle="modal" onclick="resizewindow()" data-target="#kiesplaats"><i class="fa fa-map-marker" aria-hidden="true"></i> Kies een staanplaats</button>
                  <label style="display:none;" id="placelabelId">
                    Gekozen plaats
                    <input type="text" class="form-control" readonly id="chosenplace" style="display: none;">
                  </label>

                </div>
                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Aankomst datum</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="aankomst_datum" name="aankomst_datum" placeholder="<?php echo $v = date('d-m-Y') ?>" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="gross_amount" class="col-sm-5 control-label" style="text-align:left;">Vertrek datum</label>
                  <div class="col-sm-7">
                    <input type="hidden" name="plaats_id" id="plaats_id" value="0">
                    <input type="text" class="form-control" id="vertrek_datum" name="vertrek_datum" placeholder="<?php echo  date('d-m-Y', strtotime($v . ' + 2 days')); ?>" autocomplete="off">
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
                    if ($option['type'] == "number") {
                  ?>
                      <tr>
                        <td>
                          <label for=" <?php echo $option['id'] ?>" class="control-label" style="text-align:left;">aantal <?php echo $option['what'] ?></label>
                        </td>
                        <td>
                          <input type="hidden" name="option_id[]" value="<?php echo $option['id'] ?>">
                          <input class="form-control" name="value[]" value="0" onchange="calc('<?php echo $option['id'] ?>')" id="<?php echo $option['id'] ?>" <?php if (isset($option['max '])) {
                                                                                                                                                                  $max = $option['max'];
                                                                                                                                                                  echo "max=\"$max\"";
                                                                                                                                                                } ?> min="0" type="<?php echo $option['type'] ?>">
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

                            <input type="hidden" name="option_id[]" value="<?php echo $option['id'] ?>">
                            <input id="<?php echo $option['id'] ?>_hidden" name="value[]" value="off" type="hidden">
                            <input id="<?php echo $option['id'] ?>" name="value[]" onclick="checkbox(this,<?php echo $option['id'] ?>, 'reserveringFormadd')" value="on" type="checkbox">
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
                    <input type="text" class="form-control" id="discount" name="korting" placeholder="Korting" onkeyup="subAmount()" autocomplete="off">
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
              <button type="submit" class="btn btn-primary">Maak reservering</button>
              <a href="<?php echo base_url('reseveringen/') ?>" class="btn btn-warning">Terug</a>
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



<!-- Kies staan plaats -->
<div class="modal fade" tabindex="-1" role="dialog" id="kiesplaats">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Kies een staan plaats</h4>
      </div>
      <div class="modal-body">
        <div class="col-lg-12" style="width: 100%;" id="image-map-wrapper">
          <div id="image-map-container">
            <div id="image-map" class="image-mapper">
              <img class="image-mapper-img" width="100%" usemap="#plategrond" src="<?php echo base_url('assets/images/camping_map.jpg') ?>">
            </div>
          </div>
          <map name="plategrond" id="plategrond">
            <area href="javascript:;" alt="1" title="1" coords="1074,414,1122,435,1115,459,1064,445" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="2" title="2" coords="1160,412,1205,435,1191,457,1142,440" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="3" title="3" coords="1137,463,1186,482,1181,515,1132,503" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="4" title="4" coords="1055,480,1102,492,1095,519,1048,508" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="5" title="5" coords="1123,527,1174,541,1169,573,1116,559" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="6" title="6" coords="1039,541,1088,553,1080,585,1033,569" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="7" title="7" coords="1106,587,1116,595,1158,606,1146,637,1101,623,1109,606" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="8" title="8" coords="1026,599,1071,613,1066,641,1020,632" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="9" title="9" coords="1095,648,1144,663,1139,695,1087,684" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="10" title="10" coords="1017,660,1057,672,1052,704,1008,690" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="11" title="11" coords="1080,702,1083,714,1127,725,1123,749,1069,742" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="12" title="12" coords="996,721,1039,732,1038,759,992,749" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="13" title="13" coords="985,779,1026,791,1024,817,994,812" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="14" title="14" coords="1034,869,1050,862,1057,871,1099,882,1085,911,1033,889" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="15" title="15" coords="1020,924,1064,938,1057,959,1013,952" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="16" title="16" coords="940,883,966,894,956,943,921,932" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="17" title="17" coords="879,878,905,882,902,924,868,920" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="18" title="18" coords="820,859,846,866,844,911,807,906" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="19" title="19" coords="888,972,933,997,919,1027,874,995" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="20" title="20" coords="847,1039,895,1056,884,1088,840,1063" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="21" title="21" coords="821,1088,863,1116,856,1140,816,1117" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="22" title="22" coords="797,1165,846,1172,842,1203,797,1186" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="23" title="23" coords="863,1203,924,1224,923,1243,867,1236" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="24" title="24" coords="785,936,832,962,825,981,778,971" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="25" title="25" coords="758,1000,809,1027,799,1041,755,1028" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="26" title="26" coords="738,1046,725,1082,743,1088,774,1100,785,1079,751,1069" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="27" title="27" coords="706,941,753,960,744,985,701,966" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="28" title="28" coords="685,999,734,1016,724,1051,673,1021,675,1016" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="29" title="29" coords="608,997,628,1006,628,1053,596,1048" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="30" title="30" coords="552,988,573,995,568,1041,537,1034" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="31" title="31" coords="486,976,511,983,507,1030,474,1021" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="32" title="32" coords="423,959,449,971,446,1018,408,1011" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="32" title="32" coords="678,1086,706,1096,697,1123,675,1121" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="33" title="33" coords="621,1081,648,1084,640,1110,617,1112" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="34" title="34" coords="561,1065,558,1100,582,1095,589,1074" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="35" title="35" coords="491,1049,497,1082,521,1076,526,1060" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="36" title="36" coords="436,1041,441,1069,463,1067,467,1048" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="37" title="37" coords="713,1198,739,1208,738,1254,703,1248" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="38" title="38" coords="652,1187,676,1192,676,1240,643,1233,648,1208" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="39" title="39" coords="591,1177,614,1179,612,1229,580,1220" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="40" title="40" coords="531,1165,549,1172,549,1215,517,1213" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="41" title="41" coords="467,1151,493,1156,491,1203,456,1198" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="42" title="42" coords="401,1137,430,1140,430,1192,392,1184" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="43" title="43" coords="655,1273,659,1285,654,1341,673,1350,683,1290,699,1280" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="44" title="44" coords="596,1254,603,1269,593,1327,615,1336,624,1273,635,1262" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="45" title="45" coords="537,1241,540,1254,532,1316,552,1318,563,1262,572,1254" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="46" title="46" coords="474,1231,484,1245,472,1306,493,1313,507,1248,519,1240" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="47" title="47" coords="422,1222,420,1236,406,1285,437,1290,441,1234,453,1231" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="48" title="48" coords="357,1206,362,1220,350,1268,373,1278,390,1217" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="49" title="49" coords="923,1283,879,1306,896,1330,933,1311" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="50" title="50" coords="917,1360,963,1341,971,1364,935,1379" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="51" title="51" coords="959,1409,973,1435,1013,1414,998,1390" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="52" title="52" coords="1003,1458,1038,1437,1048,1458,1017,1474" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="53" title="53" coords="806,1540,828,1554,818,1598,792,1585" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="54" title="54" coords="863,1554,886,1568,877,1615,847,1603" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="55" title="55" coords="926,1575,947,1585,937,1632,905,1620" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="56" title="56" coords="985,1594,1010,1610,994,1652,968,1641" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="57" title="57" coords="1045,1617,1066,1624,1053,1669,1022,1662" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="58" title="58" coords="1050,1694,1036,1739,1062,1751,1078,1704" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="59" title="59" coords="985,1671,987,1687,978,1725,1001,1734,1020,1688" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="60" title="60" coords="928,1650,923,1702,940,1709,966,1669" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="61" title="61" coords="870,1631,874,1648,860,1687,881,1692,896,1652,905,1646" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="62" title="62" coords="813,1615,813,1632,802,1666,825,1669,835,1634,847,1631" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="63" title="63" coords="793,1701,790,1722,811,1725,814,1711" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="64" title="64" coords="854,1725,840,1765,861,1776,877,1732" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="65" title="65" coords="909,1742,937,1753,924,1776,903,1774" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="66" title="66" coords="968,1762,957,1805,977,1811,992,1770" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="67" title="67" coords="1033,1783,1052,1793,1043,1819,1019,1819" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="68" title="68" coords="1113,1708,1163,1720,1155,1746,1111,1737" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="69" title="69" coords="1125,1645,1181,1660,1170,1694,1122,1681" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="70" title="70" coords="1258,892,1293,903,1272,948,1249,941" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="71" title="71" coords="1321,910,1326,922,1308,959,1331,967,1354,924" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="72" title="72" coords="1266,501,1312,515,1303,545,1258,536" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="73" title="73" coords="1244,567,1291,581,1280,609,1232,597" shape="poly" onclick="kiesplaats(this)">
            <area href="javascript:;" alt="74" title="74" coords="1223,644,1268,658,1254,688,1216,677" shape="poly" onclick="kiesplaats(this)">
          </map>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sluit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- The modal -->
<div class="modal fade" id="placeinfo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalLabel">Staan Plaats: <span id="placeid"></span> </h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <th>
            <tr>
              <td>Elkectriciteit</td>
              <td>Water aansluiting</td>
            </tr>

          </th>
          <tbody>
            <tr>
              <td><span id="placeElktra"></span></td>
              <td><span id="placeWater"></span></td>
            </tr>

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="kiesplaatsBnt" onclick="" class="btn btn-success">Kies plaats</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="newCustomer">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 100%">
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
<script src="<?php echo base_url('assets/js/imageMapResizer.min.js') ?>"></script>
<script type="text/javascript">
  $('#plategrond').imageMapResize();
  var base_url = "<?php echo base_url(); ?>";
  var booked_dates = null;
  var $window = $(window);


  var dates = new Array;

  function DisableDates(date) {
    var string = jQuery.datepicker.formatDate('yyyy-mm-dd', date);
    return [dates.indexOf(string) == -1];
  }

  function resizewindow() {
    console.log("test");
    this.window.resizeTo(100, 100);

  }

  function place(id) {
    //  alert("Gekozen plaats: " + id.title)
    $("#aankomst_datum").attr("disabled", false);
    //Getting the disabled dates for this place i
    $.ajax({
      url: base_url + '/admin/reseveringen/booked/' + id,
      type: 'post',
      dataType: 'json',
      success: function(response) {

        console.log(response);
        $.each(response, function(index, value) {
          console.log(getDateArray(new Date(value.aankomst), new Date(value.vertrek)));
          console.log("index " + index + " aankomst " + value.aankomst + " Vertrek " + value.vertrek);
          $("#placeinfo").modal("hide");
          $("#kiesplaats").modal("hide");
          $("#chosenplace").val(id);
          var placeid = document.getElementById("chosenplace");
          var label = document.getElementById("placelabelId");
          label.style.display = "block";
          placeid.style.display = "block";
        });
      }
    });
  }

  function kiesplaats(id) {

    $("#plaats_id").val(id.title);
    //Get Place 
    $.ajax({
      url: base_url + 'api/places/' + id.title,
      type: 'post',
      dataType: 'json',
      success: function(place) {
        console.log(place.id);
        $("#placeid").html(place.id);
        var water = "Geen";
        var Elktra = "Geen";
        if (place.water == 1) {
          var water = "Aanwezig";
        }
        if (place.elktra == 1) {
          var Elktra = "Aanwezig";
        }
        $("#placeWater").html(water);
        $("#placeElktra").html(Elktra);
        $("#placeinfo").modal("show");
        $("#kiesplaatsBnt").attr('onclick', 'place(' + place.id + ')');
      }
    });

  }
  $(document).ready(function() {
    $("#aankomst_datum").attr("disabled", true);
    $("#aankomst_datum").after('<p>Kies eerst een plaats</p>');
    $("#plaats_id").on('change', function() {
      if (this.value === "") {
        $("#aankomst_datum").attr("disabled", true);
      } else {
        $("#aankomst_datum").attr("disabled", false);

      }

    });
    $(".select_group").select2();
    // $("#description").wysihtml5();
    //var booked_dates = getBookedDates();

    $("#mainOrdersNav").addClass('active');
    $("#addOrderNav").addClass('active');

    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
      'onclick="alert(\'Call your custom code here.\')">' +
      '<i class="glyphicon glyphicon-tag"></i>' +
      '</button>';

    $("#klanten").select2();
    $("#klanten").on('change', function() {
      if (this.value == "n") {
        console.log("create new customer");
        $("#newCustomer").modal('show');
      }

    });


  }); // /document
  $('#aankomst_datum').datepicker({
    format: "yyyy-mm-dd",
    language: "nl",
    keyboardNavigation: false,
    minDate: new Date(),
    beforeShowDay: function(date) {
      var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
      return [dates.indexOf(string) == -1]
    }
  });

  $('#vertrek_datum').datepicker({
    format: "yyyy-mm-dd",
    language: "nl",
    keyboardNavigation: false,
    beforeShowDay: function(date) {
      var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
      return [dates.indexOf(string) == -1]
    }
  });



  function removeElement(elementId) {
    // Removes an element from the document
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
  }

  function calc(response) {

    //console.log("calc");
    // console.log(response);

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


  var getDateArray = function(start, end) {

    var

      dt = new Date(start);

    while (dt <= end) {
      var d = new Date(dt)
      const ye = new Intl.DateTimeFormat('en', {
        year: 'numeric'
      }).format(d);
      const mo = new Intl.DateTimeFormat('en', {
        month: 'numeric'
      }).format(d);
      const da = new Intl.DateTimeFormat('en', {
        day: '2-digit'
      }).format(d);
      dates.push(ye + "-" + mo + "-" + da);
      dt.setDate(dt.getDate() + 1);
    }

    return dates;

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