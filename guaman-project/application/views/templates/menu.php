<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar"
    style="z-index: 2">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img src="<?php echo $this->config->item("website_logo_url") ?>" class="website-logo">
        </div>
        <div class="sidebar-brand-text mx-3"><?php echo $this->config->item("website_title"); ?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Heading -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        <?php echo lang("modules_title"); ?>
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDatabase"
           aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-database"></i>
            <span><?php echo lang("database_system_title") ?></span>
        </a>
        <div id="collapseDatabase" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php //<h6 class="collapse-header">Login Screens:</h6> ?>

                <?php
                if (has_permission("admin")) {
                    echo '<a class="collapse-item" href="' . base_url("statistics") . '"><i class="fas fa-chart-line"></i> ' . lang("statistics_label") . '</a>';
                }

                ?>
                <a class="collapse-item " href="<?php echo base_url("database/") ?>">
                    <i class="fas fa-table"></i>
                    <?php echo lang("tables_title") ?>
                </a>

                <div class="collapse-divider"></div>

            </div>
        </div>


    </li>


    <?php

    if (false) { ?>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
               aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-tools"></i>
                <span><?php echo lang("admin_menu_title") ?></span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <?php //<h6 class="collapse-header">Login Screens:</h6> ?>
                    <a class="collapse-item" href="<?php echo base_url("permissions/manage_permissions") ?>">
                        <i class="fas fa-unlock-alt"></i>
                        <?php echo lang("manage_permissions_title"); ?>
                    </a>

                    <div class="collapse-divider"></div>

                </div>
            </div>
        </li>
    <?php } ?>


    <!-- Nav Item - Tables -->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Search -->


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->


                <!-- Nav Item - Alerts -->
                <!--<li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                         Counter - Alerts -->
                <!--<span class="badge badge-danger badge-counter">3+</span>
            </a>
             Dropdown - Alerts -->
                <!--<div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                     aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alerts Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 12, 2019</div>
                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-donate text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 7, 2019</div>
                            $290.29 has been deposited into your account!
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 2, 2019</div>
                            Spending Alert: We've noticed unusually high spending for your account.
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
            </li>

            <!-- Nav Item - Messages -->
                <!--<li class="nav-item dropdown no-arrow mx-1">
                     <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="fas fa-envelope fa-fw"></i>
                         <!-- Counter - Messages -->
                <!--     <span class="badge badge-danger badge-counter">7</span>
                 </a>
                 <!-- Dropdown - Messages -->
                <!-- <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                      aria-labelledby="messagesDropdown">
                     <h6 class="dropdown-header">
                         Message Center
                     </h6>
                     <a class="dropdown-item d-flex align-items-center" href="#">
                         <div class="dropdown-list-image mr-3">
                             <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60"
                                  alt="">
                             <div class="status-indicator bg-success"></div>
                         </div>
                         <div class="font-weight-bold">
                             <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                 problem I've been having.
                             </div>
                             <div class="small text-gray-500">Emily Fowler · 58m</div>
                         </div>
                     </a>
                     <a class="dropdown-item d-flex align-items-center" href="#">
                         <div class="dropdown-list-image mr-3">
                             <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60"
                                  alt="">
                             <div class="status-indicator"></div>
                         </div>
                         <div>
                             <div class="text-truncate">I have the photos that you ordered last month, how would
                                 you like them sent to you?
                             </div>
                             <div class="small txt-gray-500">Jae Chun · 1d</div>
                         </div>
                     </a>
                     <a class="dropdown-item d-flex align-items-center" href="#">
                         <div class="dropdown-list-image mr-3">
                             <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60"
                                  alt="">
                             <div class="status-indicator bg-warning"></div>
                         </div>
                         <div>
                             <div class="text-truncate">Last month's report looks great, I am very happy with the
                                 progress so far, keep up the good work!
                             </div>
                             <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                         </div>
                     </a>
                     <a class="dropdown-item d-flex align-items-center" href="#">
                         <div class="dropdown-list-image mr-3">
                             <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                  alt="">
                             <div class="status-indicator bg-success"></div>
                         </div>
                         <div>
                             <div class="text-truncate">Am I a good boy? The reason I ask is because someone told
                                 me that people say this to all dogs, even if they aren't good...
                             </div>
                             <div class="small text-gray-500">Chicken the Dog · 2w</div>
                         </div>
                     </a>
                     <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                 </div>
             </li>
-->
                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span
                                class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo Account_model::$nice_username ?></span>
                        <img class="img-profile rounded-circle" src="<?php echo img_url("avatar.png") ?>">

                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                         aria-labelledby="userDropdown">

                        <a class="dropdown-item" href="<?php echo base_url("account/settings") ?>">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            <?php echo lang("settings_label"); ?>
                        </a>

                        <a class="dropdown-item" href="<?php echo base_url("account/profile") ?>">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            <?php echo lang("profile_label"); ?>
                        </a>
                        <?php
                        if (has_permission("admin")) {
                            echo "<a class=\"dropdown-item\" href=\"" . base_url("account/admin") . "\">
                            <i class=\"fas fa-at fa-sm fa-fw mr-2 text-gray-400\"></i>
                            " . lang("admin_label") . "
                        </a>";
                        }
                        ?>

                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url("account/logout") ?>">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            <?php echo lang("logout_label") ?>
                        </a>

                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->
