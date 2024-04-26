<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Start Dashboard -->
        <li class="nav-item"> <a href="<?php echo url('dashboard') ?>" class="nav-link <?php echo (@$_page->menu == 'dashboard') ? 'active' : '' ?>"> <i class="nav-icon fas fa-tachometer-alt"></i>
                <p> <?php echo lang('App.dashboard') ?> </p>
            </a> </li>
        <!-- End Dashboard -->


        <!-- Start Users Menu -->
        <?php if (hasPermissions('users_list')) : ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'users') ? 'menu-open' : '' ?>"> <a href="#" class="nav-link <?php echo (@$_page->menu == 'users') ? 'active' : '' ?>"> <i class="nav-icon fas fa-user"></i>
                    <p> Users <i class="right fas fa-angle-left"></i> </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"> <a href="<?php echo url('users') ?>" class="nav-link <?php echo (@$_page->submenu == 'view_users') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                            <p>View Users</p>
                        </a> </li>
                    <?php if (hasPermissions('view_onboarding_overview')) : ?>
                        <li class="nav-item"> <a href="<?php echo url('users/onboarding') ?>" class="nav-link <?php echo (@$_page->submenu == 'user_onboarding') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                                <p>Onboarding</p>
                            </a> </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endif ?>

        <!-- End Users Menu -->

        <!-- user shift schedule task start-->
        <li class="nav-item has-treeview <?php echo (@$_page->menu == 'create_schedule' || @$_page->menu == 'view_own_schedule' || @$_page->menu == 'view_asssied_location_schedule') ? 'menu-open' : '' ?>">
            <a href="#" class="nav-link <?php echo (@$_page->menu == 'create_schedule' || @$_page->menu == 'view_own_schedule' || @$_page->menu == 'view_asssied_location_schedule') ? 'active' : '' ?>">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p> Shift Schedule <i class="right fas fa-angle-left"></i> </p>
            </a>
            <ul class="nav nav-treeview">
                <?php if (hasPermissions('create_schedule')) : ?>
                    <li class="nav-item">
                        <a href="<?php echo url('CreateSchedule') ?>" class="nav-link <?php echo (@$_page->menu == 'create_schedule') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.schedule') ?> </p>
                        </a>
                    </li>
                <?php endif ?>
                <!-- <?php if (hasPermissions('view_own_schedule')) : ?>
            <li class="nav-item"> 
                <a href="<?php echo url('ViewOwnSchedule') ?>" class="nav-link <?php echo (@$_page->menu == 'view_own_schedule') ? 'active' : '' ?>"> 
                    <i class="far fa-circle nav-icon"></i>
                    <p> <?php echo lang('App.view_own_schedule') ?> </p> 
                </a> 
            </li>
        <?php endif ?> -->

                <?php if (hasPermissions('view_own_schedule') || hasPermissions('view_asssied_location_schedule')) : ?>
                    <li class="nav-item">
                        <a href="<?php echo url('ViewOwnSchedule') ?>" class="nav-link <?php echo (@$_page->menu == 'view_own_schedule') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.view_own_schedule') ?> </p>
                        </a>
                    </li>
                <?php endif ?>

                <!-- <?php if (hasPermissions('view_asssied_location_schedule')) : ?>
                    <li class="nav-item">
                        <a href="<?php echo url('ViewAsssiedLocationSchedule') ?>" class="nav-link <?php echo (@$_page->menu == 'view_asssied_location_schedule') ? 'active' : '' ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.view_asssied_location_schedule') ?> </p>
                        </a>
                    </li>
                <?php endif ?> -->
            </ul>
        </li>

        <!-- user shift schedule task end-->

        <!-- Start Location Menu -->
        <?php if (hasPermissions('view_location')) : ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'location') ? 'menu-open' : '' ?>"> <a href="#" class="nav-link <?php echo (@$_page->menu == 'location') ? 'active' : '' ?>"> <i class="nav-icon fas fa-map-marker-alt"></i>
                    <p> Locations <i class="right fas fa-angle-left"></i> </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"> <a href="<?php echo url('location') ?>" class="nav-link <?php echo (@$_page->submenu == 'view_location') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                            <p>View Locations</p>
                        </a> </li>
                    <?php if (hasPermissions('add_location')) : ?>
                        <li class="nav-item"> <a href="<?php echo url('location/add') ?>" class="nav-link <?php echo (@$_page->submenu == 'add_location') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                                <p>Add Location</p>
                            </a> </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endif ?>

        <!-- End Location Menu -->

        <!-- Start Expenses Menu -->
        <?php if (hasPermissions('view_expense_module')) : ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'expenses') ? 'menu-open' : '' ?>"> <a href="#" class="nav-link <?php echo (@$_page->menu == 'expenses') ? 'active' : '' ?>"> <i class="nav-icon fas fa-dollar-sign"></i>
                    <p> Expenses <i class="right fas fa-angle-left"></i> </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item"> <a href="<?php echo url('expenses') ?>" class="nav-link <?php echo (@$_page->submenu == 'view_expenses') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                            <p>View Expenses</p>
                        </a> </li>
                    <?php if (hasPermissions('add_expense')) : ?>
                        <li class="nav-item"> <a href="<?php echo url('expenses/add') ?>" class="nav-link <?php echo (@$_page->submenu == 'add_expenses') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                                <p>Add Expenses</p>
                            </a> </li>
                    <?php endif ?>
                </ul>
            </li>
        <?php endif ?>

        <!-- End Expenses Menu -->
        <!-- Start Activity Log Menu -->
        <?php if (hasPermissions('activity_log_list')) : ?>
            <li class="nav-item"> <a href="<?php echo url('activityLogs') ?>" class="nav-link <?php echo (@$_page->menu == 'activity_logs') ? 'active' : '' ?>"> <i class="nav-icon fas fa-history"></i>
                    <p> <?php echo lang('App.activity_logs') ?> </p>
                </a> </li>
        <?php endif ?>
        <!-- End Activity Log Menu -->

        <!-- Start Settings  Menu -->
        <?php if (hasPermissions('company_settings')) : ?>
            <li class="nav-item has-treeview <?php echo (@$_page->menu == 'settings') ? 'menu-open' : '' ?>"> <a href="#" class="nav-link  <?php echo (@$_page->menu == 'settings') ? 'active' : '' ?>"> <i class="nav-icon fas fa-cog"></i>
                    <p> <?php echo lang('App.settings') ?> <i class="right fas fa-angle-left"></i> </p>
                </a>
                <!-- Start Settings Submenu  -->
                <ul class="nav nav-treeview">
                    <li class="nav-item"> <a href="<?php echo url('settings/general') ?>" class="nav-link <?php echo (@$_page->submenu == 'general') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.general_setings') ?> </p>
                        </a> </li>
                    <li class="nav-item"> <a href="<?php echo url('settings/company') ?>" class="nav-link <?php echo (@$_page->submenu == 'company') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.company_setings') ?> </p>
                        </a> </li>
                    <li class="nav-item"> <a href="<?php echo url('settings/email_templates') ?>" class="nav-link <?php echo (@$_page->submenu == 'email_templates') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo lang('App.manage_email_template') ?></p>
                        </a> </li>
                    <?php if (hasPermissions('view_onboarding_steps')) : ?>
                        <li class="nav-item"> <a href="<?php echo url('settings/onboarding') ?>" class="nav-link <?php echo (@$_page->submenu == 'onboarding') ? 'active' : '' ?>"> <i class="far fa-circle nav-icon"></i>
                                <p>Onboard Settings</p>
                            </a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('roles_list')) : ?>
                        <li class="nav-item"> <a href="<?php echo url('roles') ?>" class="nav-link <?php echo (@$_page->submenu == 'roles') ? 'active' : '' ?>"> <i class="nav-icon fas fa-lock"></i>
                                <p> <?php echo lang('App.manage_roles') ?> </p>
                            </a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('permissions_list')) : ?>
                        <li class="nav-item"> <a href="<?php echo url('permissions') ?>" class="nav-link <?php echo (@$_page->submenu == 'permissions') ? 'active' : '' ?>"> <i class="nav-icon fas fa-user"></i>
                                <p> <?php echo lang('App.manage_permissions') ?> </p>
                            </a> </li>
                    <?php endif ?>
                    <?php if (hasPermissions('backup_db')) : ?>
                        <li class="nav-item"> <a href="<?php echo url('backup') ?>" class="nav-link <?php echo (@$_page->submenu == 'backup') ? 'active' : '' ?>"> <i class="nav-icon fas fa-database"></i>
                                <p> <?php echo lang('App.backup') ?> </p>
                            </a> </li>
                    <?php endif ?>
                </ul>
                <!-- End Settings  SubMenu -->
            </li>
        <?php endif ?>
        <!-- End Settings  Menu -->
        <?php
        /*
	if(hasModule('adminlte')): ?>
    <?= $this->include("Adminlte\Views\aside-nav") ?>
  <?php endif; */
        ?>
    </ul>
</nav>
<!-- /.sidebar-menu -->