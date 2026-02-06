<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="user-profile px-30 py-15">
            <div class="text-center">
                <div class="image">
                    <img src="../images/avatar/1.jpg" class="avatar avatar-xxxl box-shadowed" alt="User Image">
                </div>
                <div class="info mt-20">
                    <a class="px-20" href="#">Rushikesh Chavan</a>
                    <!-- <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="ti-user"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="ti-email"></i> Inbox</a>
                        <a class="dropdown-item" href="#"><i class="ti-link"></i> Connections</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
                    </div> -->
                </div>
            </div>
            <ul class="list-inline profile-setting mt-20 mb-0 d-flex justify-content-center">
                <li><a href="logout.php" data-bs-toggle="tooltip" data-bs-placement="top" title="Logout"><i
                            data-feather="log-out"></i></a></li>
            </ul>
        </div>
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MENU</li>
                    <li>
                        <a href="index.php">
                            <i data-feather="compass"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="header">MANAGEMENT</li>
                    <li>
                        <a href="manage_services.php">
                            <i data-feather="settings"></i>
                            <span>Services</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage_projects.php">
                            <i data-feather="briefcase"></i>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage_blogs.php">
                            <i data-feather="book-open"></i>
                            <span>Blogs</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage_testimonials.php">
                            <i data-feather="message-circle"></i>
                            <span>Testimonials</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage_enquiries.php">
                            <i data-feather="mail"></i>
                            <span>Enquiries</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage_appointments.php">
                            <i data-feather="calendar"></i>
                            <span>Appointments</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage_newsletter.php">
                            <i data-feather="send"></i>
                            <span>Newsletter</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage_seo.php">
                            <i data-feather="globe"></i>
                            <span>SEO Manager</span>
                        </a>
                    </li>
                </ul>

                <div class="sidebar-widgets">
                    <div class="copyright text-start m-25">
                        <p><strong class="d-block">Techyrushi Admin Panel</strong> ©
                            <?php echo date('Y'); ?> All Rights Reserved
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside>