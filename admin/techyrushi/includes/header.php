<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Adjust path to config.php based on where this file is included from
// If included from admin/techyrushi/manage_*.php, then __DIR__ is admin/techyrushi/includes
// So we need to go up two levels to get to admin/config.php
$config_path = dirname(dirname(__DIR__)) . '/config.php';
if (file_exists($config_path)) {
    require_once $config_path;
} else {
    // Fallback if structure is different
    require_once '../../config.php';
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: auth_login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from master-admin-template.multipurposethemes.com/bs5/real-estate/addproperty.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Feb 2026 09:56:06 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://master-admin-template.multipurposethemes.com/bs5/images/favicon.ico">

    <title>Techyrushi Admin - Dashboard</title>

    <!-- Vendors Style-->
    <link rel="stylesheet" href="css/vendors_css.css">


    <!-- Style-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/skin_color.css">

</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">

    <div class="wrapper">
        <div id="loader"></div>

        <header class="main-header">
            <div class="d-flex align-items-center logo-box justify-content-start">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <!-- logo-->
                    <div class="logo-mini w-30">
                        <span class="light-logo"><img src="../images/favicon.png" alt="logo"></span>
                    </div>
                    <div class="logo-lg">
                        <span class="light-logo"><img src="../images/techyrushi.png" alt="logo"></span>
                    </div>
                </a>
            </div>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <div class="app-menu">
                    <ul class="header-megamenu nav">
                        <li class="btn-group nav-item">
                            <a href="#" class="waves-effect waves-light nav-link push-btn btn-outline no-border"
                                data-toggle="push-menu" role="button">
                                <img src="https://master-admin-template.multipurposethemes.com/bs5/images/svg-icon/collapse.svg"
                                    class="img-fluid svg-icon" alt="">
                            </a>
                        </li>
                       
                        <li class="btn-group nav-item d-none d-xl-inline-block">
                            <a href="extra_calendar.php"
                                class="waves-effect waves-light nav-link btn-outline no-border svg-bt-icon"
                                title="Chat">
                                <img src="https://master-admin-template.multipurposethemes.com/bs5/images/svg-icon/event.svg"
                                    class="img-fluid svg-icon" alt="">
                            </a>
                        </li>
                        <li class="btn-group nav-item d-none d-xl-inline-block">
                            <a href="extra_taskboard.php"
                                class="waves-effect waves-light btn-outline no-border nav-link svg-bt-icon"
                                title="Taskboard">
                                <img src="https://master-admin-template.multipurposethemes.com/bs5/images/svg-icon/correct.svg"
                                    class="img-fluid svg-icon" alt="">
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="navbar-custom-menu r-side">
                    <ul class="nav navbar-nav">
                        <li class="btn-group nav-item d-lg-inline-flex d-none">
                            <a href="#" data-provide="fullscreen"
                                class="waves-effect waves-light nav-link btn-outline no-border full-screen"
                                title="Full Screen">
                                <img src="https://master-admin-template.multipurposethemes.com/bs5/images/svg-icon/fullscreen.svg"
                                    class="img-fluid svg-icon" alt="">
                            </a>
                        </li>
                        <!-- Notifications -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="waves-effect waves-light dropdown-toggle btn-outline no-border"
                                data-bs-toggle="dropdown" title="Notifications">
                                <img src="https://master-admin-template.multipurposethemes.com/bs5/images/svg-icon/notifications.svg"
                                    class="img-fluid svg-icon" alt="">
                                <span class="badge bg-danger rounded-circle" id="notification-count" style="display:none; position:absolute; top:5px; right:5px; font-size:10px;">0</span>
                            </a>
                            <ul class="dropdown-menu animated bounceIn">

                                <li class="header">
                                    <div class="p-20">
                                        <div class="flexbox">
                                            <div>
                                                <h4 class="mb-0 mt-0">Notifications</h4>
                                            </div>
                                            <div>
                                                <a href="#" class="text-danger" id="clear-notifications"></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu sm-scrol" id="notification-list">
                                        <!-- Notifications loaded via JS -->
                                    </ul>
                                </li>
                                <!-- <li class="footer">
                                    <a href="#">View all</a>
                                </li> -->
                            </ul>
                        </li>

                        <!-- User Account-->
                        <li class="dropdown user user-menu">
                            <a href="#" class="waves-effect waves-light dropdown-toggle btn-outline no-border"
                                data-bs-toggle="dropdown" title="User">
                                <img src="https://master-admin-template.multipurposethemes.com/bs5/images/svg-icon/user.svg"
                                    class="img-fluid svg-icon" alt="">
                            </a>
                            <ul class="dropdown-menu animated flipInX">
                                <li class="user-body">
                                    <a class="dropdown-item" href="#"><i class="ti-lock text-muted me-2"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <li>
                            <a href="#" data-toggle="control-sidebar" title="Setting"
                                class="waves-effect waves-light btn-outline no-border">
                                <img src="https://master-admin-template.multipurposethemes.com/bs5/images/svg-icon/settings.svg"
                                    class="img-fluid svg-icon" alt="">
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>