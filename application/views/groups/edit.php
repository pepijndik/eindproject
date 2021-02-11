<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Beheer
      <small>Groepen</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('groups/') ?>">Groepen</a></li>
      <li class="active">Edit</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

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
            <h3 class="box-title">Bewerk Groep</h3>
          </div>
          <form role="form" action="<?php base_url('groups/update') ?>" method="post">
            <div class="box-body">

              <?php echo validation_errors(); ?>

              <div class="form-group">
                <label for="group_name">Groep naam</label>
                <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter group name" value="<?php echo $group_data['group_name']; ?>">
              </div>
              <div class="form-group">
                <label for="permission">Rechten</label>

                <?php $serialize_permission = unserialize($group_data['permission']); ?>

                <table class="table table-responsive">
                  <thead>
                    <tr>
                      <th></th>
                      <th>aanmaken</th>
                      <th>Bewerken</th>
                      <th>Bekijken</th>
                      <th>Verwijderen</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Gebruikers</td>
                      <td><input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="createUser" <?php if ($serialize_permission) {
                                                                                                                                          if (in_array('createUser', $serialize_permission)) {
                                                                                                                                            echo "checked";
                                                                                                                                          }
                                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateUser" <?php
                                                                                                                        if ($serialize_permission) {
                                                                                                                          if (in_array('updateUser', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        }
                                                                                                                        ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewUser" <?php
                                                                                                                      if ($serialize_permission) {
                                                                                                                        if (in_array('viewUser', $serialize_permission)) {
                                                                                                                          echo "checked";
                                                                                                                        }
                                                                                                                      }
                                                                                                                      ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteUser" <?php
                                                                                                                        if ($serialize_permission) {
                                                                                                                          if (in_array('deleteUser', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        }
                                                                                                                        ?>></td>
                    </tr>
                    <tr>
                      <td>Groepen</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createGroup" <?php
                                                                                                                          if ($serialize_permission) {
                                                                                                                            if (in_array('createGroup', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          }
                                                                                                                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateGroup" <?php
                                                                                                                          if ($serialize_permission) {
                                                                                                                            if (in_array('updateGroup', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          }
                                                                                                                          ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewGroup" <?php
                                                                                                                        if ($serialize_permission) {
                                                                                                                          if (in_array('viewGroup', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        }
                                                                                                                        ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteGroup" <?php
                                                                                                                          if ($serialize_permission) {
                                                                                                                            if (in_array('deleteGroup', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          }
                                                                                                                          ?>></td>
                    </tr>
                    <tr>
                      <td>Facturen</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="CreateFactuur" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('CreateFactuur', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="UpdateFactuur" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('UpdateFactuur', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="ViewFactuur" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('ViewFactuur', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="DeleteFactuur" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('DeleteFactuur', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                    </tr>
                    <tr>
                      <td>Niews</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="CreateNews" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('CreateNews', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="UpdateNews" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('UpdateNews', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="ViewNews" <?php if ($serialize_permission) {
                                                                                                                        if (in_array('ViewNews', $serialize_permission)) {
                                                                                                                          echo "checked";
                                                                                                                        }
                                                                                                                      } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="DeleteNews" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('DeleteNews', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                    </tr>
                    <!--
                    <tr>
                      <td>Uitgifte punten</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createStore" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('createStore', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateStore" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('updateStore', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewStore" <?php if ($serialize_permission) {
                                                                                                                          if (in_array('viewStore', $serialize_permission)) {
                                                                                                                            echo "checked";
                                                                                                                          }
                                                                                                                        } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteStore" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('deleteStore', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                    </tr>
                    <tr>
                      <td>Attributes</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createAttribute" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('createAttribute', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateAttribute" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('updateAttribute', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewAttribute" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('viewAttribute', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteAttribute" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('deleteAttribute', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                    </tr>
                    <tr>
                      <td>Uitgiftes</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="nieuw_uitgifte" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('nieuw_uitgifte', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="update_uitgifte" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('update_uitgifte', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="bekijk_uitgifte" <?php if ($serialize_permission) {
                                                                                                                                if (in_array('bekijk_uitgifte', $serialize_permission)) {
                                                                                                                                  echo "checked";
                                                                                                                                }
                                                                                                                              } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="verwijder_uitgifte" <?php if ($serialize_permission) {
                                                                                                                                  if (in_array('verwijder_uitgifte', $serialize_permission)) {
                                                                                                                                    echo "checked";
                                                                                                                                  }
                                                                                                                                } ?>></td>
                    </tr> -->
                    <!-- <tr>
                      <td>Products</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="createProduct" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('createProduct', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateProduct" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updateProduct', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProduct" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewProduct', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="deleteProduct" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('deleteProduct', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                    </tr> -->
                    <tr>
                      <td>Reserveringen</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="CreateReserveringen" <?php if ($serialize_permission) {
                                                                                                                                    if (in_array('CreateReserveringen', $serialize_permission)) {
                                                                                                                                      echo "checked";
                                                                                                                                    }
                                                                                                                                  } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="UpdateReserveringen" <?php if ($serialize_permission) {
                                                                                                                                    if (in_array('UpdateReserveringen', $serialize_permission)) {
                                                                                                                                      echo "checked";
                                                                                                                                    }
                                                                                                                                  } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="ViewReserveringen" <?php if ($serialize_permission) {
                                                                                                                                  if (in_array('ViewReserveringen', $serialize_permission)) {
                                                                                                                                    echo "checked";
                                                                                                                                  }
                                                                                                                                } ?>></td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="DeleteReserveringen" <?php if ($serialize_permission) {
                                                                                                                                    if (in_array('DeleteReserveringen', $serialize_permission)) {
                                                                                                                                      echo "checked";
                                                                                                                                    }
                                                                                                                                  } ?>></td>
                    </tr>
                    <tr>
                      <td>Reports</td>
                      <td> - </td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewReports" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewReports', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Bedrijf</td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateCompany" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updateCompany', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td> - </td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Profiel</td>
                      <td> - </td>
                      <td> - </td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="viewProfile" <?php if ($serialize_permission) {
                                                                                                                            if (in_array('viewProfile', $serialize_permission)) {
                                                                                                                              echo "checked";
                                                                                                                            }
                                                                                                                          } ?>></td>
                      <td> - </td>
                    </tr>
                    <tr>
                      <td>Settings</td>
                      <td>-</td>
                      <td><input type="checkbox" name="permission[]" id="permission" class="minimal" value="updateSetting" <?php if ($serialize_permission) {
                                                                                                                              if (in_array('updateSetting', $serialize_permission)) {
                                                                                                                                echo "checked";
                                                                                                                              }
                                                                                                                            } ?>></td>
                      <td> - </td>
                      <td> - </td>
                    </tr>
                  </tbody>
                </table>

              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Update verandering</button>
              <a href="<?php echo base_url('groups/') ?>" class="btn btn-warning">Terug</a>
            </div>
          </form>
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
  $(document).ready(function() {
    $("#mainGroupNav").addClass('active');
    $("#manageGroupNav").addClass('active');

    $('input[type="checkbox"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });
  });
</script>