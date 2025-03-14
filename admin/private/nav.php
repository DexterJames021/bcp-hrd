<?php
$path = "http://localhost/bcp-hrd/";
?>
<!--  rounded mt-4 ml-3 h-10 -->
<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list ">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="index.php">Human Resource Dept.</a>
            <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Human Resource Dept.
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link active" href="<?php echo $path . "admin/index.php" ?>">
                            <i class="fas fa-fw fa-home"></i> Dashboard
                        </a>
                    </li>
                    <!--- Selection and Recuitment -->
                    <li class="nav-item ">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fa fa-fw fa-user-circle"></i>Selection and Recuitment <span class="badge badge-success">6</span></a>
                        <div id="submenu-1" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-2" aria-controls="submenu-1-2">Lorem, ipsum.</a>
                                    <div id="submenu-1-2" class="collapse submenu">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="index.html">Lorem.</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">lorem1</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Lorem.</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Lorem.</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= $path ?>/Records.php">Lorem, ipsum dolor.</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="dashboard-sales.html">Lorem, ipsum dolor.</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1-1" aria-controls="submenu-1-1">Lorem, ipsum dolor.</a>
                                    <div id="submenu-1-1" class="collapse submenu">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Lorem, ipsum dolor.</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!--- Talent Management -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i>Talent Management</a>
                        <div id="submenu-2" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="talent/index.php">Dashboard<span class="badge badge-secondary">New</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="talent/recruitment.php">Recruitment</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="talent/onboarding.php">Onboarding</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="talent/talentretention.php">Talent Retention</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="talent/succession.php">Succession Planning</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="talent/career.php">Career Development</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/tabs.html">Tabs</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!--- Tech & Analytics -->
                    <li class="nav-item">
                        <a class="nav-link" href="./analytics/index.php" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-chart-pie"></i> Tech & Analytics</a>
                        <div id="submenu-3" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3-1" aria-controls="submenu-3-1">Facilities & Resources</a>
                                    <div id="submenu-3-1" class="collapse submenu">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link " href="./tech/index.php">Resources Management</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="./tech/room_book_list.php">Facility Management</a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" href="./tech/request.php">Bookings and Request</a>
                                            </li> -->
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./tech/records.php">Employee Personnel Records</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./tech/reports.php">Administrative Report</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./tech/records.php">Employee Personnel Records</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./tech/usercontrol.php">Roles and Permission Mangement</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3-2" aria-controls="submenu-3-2">Analytics</a>
                                    <div id="submenu-3-2" class="collapse submenu">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Engagement insight</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Performance metric</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Efficiency analysis</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Workforce optimazition</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Talent insight</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <!-- <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-sparkline.html">Sparkline</a>
                                        </li> -->
                                <!-- <li class="nav-item">
                                            <a class="nav-link" href="pages/chart-gauge.html">Guage</a>
                                        </li> -->
                            </ul>
                        </div>
                    </li>
                    <!--- Document and Legal -->
                    <li class="nav-item ">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fab fa-fw fa-wpforms"></i>Document and Legal</a>
                        <div id="submenu-4" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/form-elements.html">Form Elements</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/form-validation.html">Parsely Validations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/multiselect.html">Multiselect</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/datepicker.html">Date Picker</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/bootstrap-select.html">Bootstrap Select</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!--- Performance -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fas fa-fw fa-table"></i>Performance</a>
                        <div id="submenu-5" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Training management -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-columns"></i>Talent management</a>
                        <div id="submenu-6" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!--- Compensation & benefits -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-f fa-folder"></i>Compensation & benefits</a>
                        <div id="submenu-7" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/general-table.html">General Tables</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/data-tables.html">Data Tables</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-divider">
                        Features
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-fw fa-file"></i> Pages </a>
                        <div id="submenu-6" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/blank-page.html">Blank Page</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/blank-page-header.html">Blank Page Header</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/login.html">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/404-page.html">404 page</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/sign-up.html">Sign up Page</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/forgot-password.html">Forgot Password</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/pricing.html">Pricing Tables</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/timeline.html">Timeline</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/calendar.html">Calendar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/sortable-nestable-lists.html">Sortable/Nestable List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/widgets.html">Widgets</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/media-object.html">Media Objects</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/cropper-image.html">Cropper</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/color-picker.html">Color Picker</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-fw fa-inbox"></i>Apps <span class="badge badge-secondary">New</span></a>
                        <div id="submenu-7" class="collapse submenu">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/inbox.html">Inbox</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/email-details.html">Email Detail</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/email-compose.html">Email Compose</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="pages/message-chat.html">Message Chat</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-8" aria-controls="submenu-8"><i class="fas fa-fw fa-columns"></i>Icons</a>
                                <div id="submenu-8" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-fontawesome.html">FontAwesome Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-material.html">Material Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-simple-lineicon.html">Simpleline Icon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-themify.html">Themify Icon</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-flag.html">Flag Icons</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/icon-weather.html">Weather Icon</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-9" aria-controls="submenu-9"><i class="fas fa-fw fa-map-marker-alt"></i>Maps</a>
                                <div id="submenu-9" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/map-google.html">Google Maps</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="pages/map-vector.html">Vector Maps</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-10" aria-controls="submenu-10"><i class="fas fa-f fa-folder"></i>Menu Level</a>
                                <div id="submenu-10" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Level 1</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-11" aria-controls="submenu-11">Level 2</a>
                                            <div id="submenu-11" class="collapse submenu">
                                                <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Level 1</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#">Level 2</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Level 3</a>
                                        </li>
                                    </ul>
                                </div>
                            </li> -->
                </ul>
            </div>
        </nav>
    </div>
</div>