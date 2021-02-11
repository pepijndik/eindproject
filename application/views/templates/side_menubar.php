<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">

      <li id="dashboardMainMenu">
        <a href="<?php echo base_url('/admin/dashboard') ?>">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>

      <?php if ($user_permission) : ?>
        <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
          <li class="treeview" id="mainUserNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Gebruikers</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('createUser', $user_permission)) : ?>
                <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-circle-o"></i> Voeg gebruiker toe</a></li>
              <?php endif; ?>

              <?php if (in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
                <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> Beheer gebruikers</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
          <li class="treeview" id="mainGroupNav">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Gebruiker groepen</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('createGroup', $user_permission)) : ?>
                <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-circle-o"></i> Voeg groep toe</a></li>
              <?php endif; ?>
              <?php if (in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i> Beheer groepen</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>




        <?php if (in_array('CreateFactuur', $user_permission) || in_array('UpdateFactuur', $user_permission) || in_array('ViewFactuur', $user_permission) || in_array('deleteCategory', $user_permission)) : ?>
          <li id="categoryNav">
            <a href="<?php echo base_url('admin/facturen') ?>">
              <i class="fa fa-dollar"></i> <span>Facturen</span>
            </a>
          </li>
        <?php endif; ?>






        <?php if (in_array('CreateReserveringen', $user_permission) || in_array('UpdateReserveringen', $user_permission) || in_array('ViewReserveringen', $user_permission) || in_array('verwijder_uitgifte', $user_permission)) : ?>
          <li class="treeview" id="mainOrdersNav">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Reseveringen</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('CreateReserveringen', $user_permission)) : ?>
                <li id="addOrderNav"><a href="<?php echo base_url('admin/reseveringen/add') ?>"><i class="fa fa-circle-o"></i> Voeg een resevering toe</a></li>
              <?php endif; ?>
              <?php if (in_array('UpdateReserveringen', $user_permission) || in_array('ViewReserveringen', $user_permission) || in_array('DeleteReservering', $user_permission)) : ?>
                <li id="manageOrdersNav"><a href="<?php echo base_url('admin/reseveringen/view') ?>"><i class="fa fa-circle-o"></i> Beheer resevering</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>

        <?php if (in_array('viewReports', $user_permission)) : ?>
          <li id="reportNav">
            <a href="<?php echo base_url('/reports') ?>">
              <i class="glyphicon glyphicon-stats"></i> <span>Raporten</span>
            </a>
          </li>
        <?php endif; ?>


        <?php if (in_array('ViewNews', $user_permission) || in_array('CreateNews', $user_permission)) : ?>
          <li class="treeview" id="mainNewsNav">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Nieuws</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if (in_array('ViewNews', $user_permission)) : ?>
                <li id="addNewsNav"><a href="<?php echo base_url('admin/news/create') ?>"> <i class="fa fa-envelope"></i> Voeg nieuws toe</a></li>
              <?php endif; ?>
              <?php if (in_array('ViewNews', $user_permission) || in_array('CreateNews', $user_permission)) : ?>
                <li id="manageNewsNav"><a href="<?php echo base_url('admin/news') ?>"> <i class="fa fa-envelope"></i> Beheer resevering</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>
        <?php if (in_array('updateCompany', $user_permission)) : ?>
          <li id="categoryNav">
            <a href="<?php echo base_url('admin/tarieven/view') ?>">
              <i class="fa fa-dollar"></i> <span>Beheer tarieven</span>
            </a>
          </li>
        <?php endif; ?>



        <!-- <li class="header">Settings</li> -->

        <?php if (in_array('viewProfile', $user_permission)) : ?>
          <li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-user-o"></i> <span>Profiel</span></a></li>
        <?php endif; ?>
        <?php if (in_array('updateSetting', $user_permission)) : ?>
          <li><a href="<?php echo base_url('company') ?>"><i class="fa fa-wrench"></i> <span>Setting</span></a></li>
        <?php endif; ?>

      <?php endif; ?>
      <!-- user permission info -->
      <li><a href="<?php echo base_url('admin/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>