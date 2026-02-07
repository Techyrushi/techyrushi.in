<?php
// Ensure this file is only accessed by authenticated users (handled in header.php)
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// Fetch Counts
$stmt = $pdo->query("SELECT COUNT(*) FROM services");
$service_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM projects");
$project_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM blog_posts");
$blog_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM contact_enquiries");
$enquiry_count = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) FROM contact_enquiries WHERE is_read = 0");
$unread_enquiry_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM appointments");
$appt_count = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'");
$pending_appt_count = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers");
$subscriber_count = $stmt->fetchColumn();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <style>
        .box {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: none;
            margin-bottom: 30px;
            background: #fff;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .box-header {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f2f5;
            background: transparent;
        }
        .box-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }
        .box-body {
            padding: 1.5rem;
        }
        
        /* Chart Containers */
        #visitor-chart, #browser-chart, #engagement-chart {
            width: 100% !important;
            height: 350px !important;
            max-height: 350px !important;
        }
        
        .box-body {
            overflow: hidden; /* Prevent chart overflow */
        }
        
        /* Stats Cards */
        .box.pull-up {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            position: relative;
        }
        .box.pull-up::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 0.5s, transform 0.5s;
        }
        .box.pull-up:hover::before {
            opacity: 1;
            transform: scale(1);
        }
        .box .font-size-60 {
            font-size: 80px !important;
            line-height: 1;
            opacity: 0.4;
            transition: all 0.3s;
        }
        .box.pull-up:hover .font-size-60 {
            opacity: 0.8;
            transform: scale(1.1) rotate(5deg);
        }
    </style>
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body bg-primary pull-up" style="border-radius: 10px;">
                        <div class="flexbox align-items-center">
                            <div class="text-start">
                                <span class="font-size-18 text-white">Appointments</span>
                                <h1 class="fw-700 m-0 text-white" style="font-size: 3.5rem;"><?php echo $appt_count; ?></h1>
                            </div>
                            <div class="font-size-60 text-white-50">
                                <i class="mdi mdi-calendar-clock"></i>
                            </div>
                        </div>
                        <div class="mt-3 text-white-50 font-size-16">
                            <i class="mdi mdi-alert-circle-outline"></i> <?php echo $pending_appt_count; ?> Pending
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body bg-danger pull-up" style="border-radius: 10px;">
                        <div class="flexbox align-items-center">
                            <div class="text-start">
                                <span class="font-size-18 text-white">Enquiries</span>
                                <h1 class="fw-700 m-0 text-white" style="font-size: 3.5rem;"><?php echo $enquiry_count; ?></h1>
                            </div>
                            <div class="font-size-60 text-white-50">
                                <i class="mdi mdi-email-open"></i>
                            </div>
                        </div>
                        <div class="mt-3 text-white-50 font-size-16">
                            <i class="mdi mdi-email-alert"></i> <?php echo $unread_enquiry_count; ?> Unread
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body bg-success pull-up" style="border-radius: 10px;">
                        <div class="flexbox align-items-center">
                            <div class="text-start">
                                <span class="font-size-18 text-white">Subscribers</span>
                                <h1 class="fw-700 m-0 text-white" style="font-size: 3.5rem;"><?php echo $subscriber_count; ?></h1>
                            </div>
                            <div class="font-size-60 text-white-50">
                                <i class="mdi mdi-email-check"></i>
                            </div>
                        </div>
                        <div class="mt-3 text-white-50 font-size-16">
                            <i class="mdi mdi-account-plus"></i> Newsletter Users
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body bg-info pull-up" style="border-radius: 10px;">
                        <div class="flexbox align-items-center">
                            <div class="text-start">
                                <span class="font-size-18 text-white">Projects</span>
                                <h1 class="fw-700 m-0 text-white" style="font-size: 3.5rem;"><?php echo $project_count; ?></h1>
                            </div>
                            <div class="font-size-60 text-white-50">
                                <i class="mdi mdi-briefcase"></i>
                            </div>
                        </div>
                        <div class="mt-3 text-white-50 font-size-16">
                            <i class="mdi mdi-folder-image"></i> Portfolio Items
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body bg-warning pull-up" style="border-radius: 10px;">
                        <div class="flexbox align-items-center">
                            <div class="text-start">
                                <span class="font-size-18 text-white">Services</span>
                                <h1 class="fw-700 m-0 text-white" style="font-size: 3.5rem;"><?php echo $service_count; ?></h1>
                            </div>
                            <div class="font-size-60 text-white-50">
                                <i class="mdi mdi-settings"></i>
                            </div>
                        </div>
                        <div class="mt-3 text-white-50 font-size-16">
                            <i class="mdi mdi-blogger"></i> <?php echo $blog_count; ?> Blogs
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Charts -->
            <div class="row">
                <div class="col-xl-8 col-lg-7 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title text-primary"><i class="mdi mdi-chart-line me-2"></i> Visitor Analytics (Last 7 Days)</h4>
                        </div>
                        <div class="box-body">
                            <div id="visitor-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title text-info"><i class="mdi mdi-google-chrome me-2"></i> Browser Usage</h4>
                        </div>
                        <div class="box-body">
                            <div id="browser-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Engagement Chart -->
             <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title text-success"><i class="mdi mdi-chart-bar me-2"></i> Engagement (Enquiries vs Appointments) - Last 6 Months</h4>
                        </div>
                        <div class="box-body">
                            <div id="engagement-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data -->
            <div class="row">
                <!-- Recent Enquiries -->
                <div class="col-lg-6 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Recent Enquiries</h4>
                            <ul class="box-controls pull-right">
                                <li><a class="box-btn-slide" href="#"></a></li>
                            </ul>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $pdo->query("SELECT * FROM contact_enquiries ORDER BY created_at DESC LIMIT 5");
                                        while ($row = $stmt->fetch()) {
                                            $badge = $row['is_read'] ? '<span class="badge badge-success">Read</span>' : '<span class="badge badge-danger">Unread</span>';
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                            echo "<td>" . htmlspecialchars(substr($row['subject'], 0, 20)) . "...</td>";
                                            echo "<td><span class='text-muted'><i class='fa fa-clock-o'></i> " . date('M j, Y', strtotime($row['created_at'])) . "</span></td>";
                                            echo "<td>$badge</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <a href="manage_enquiries.php" class="text-uppercase">View All Enquiries</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="col-lg-6 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">Recent Appointments</h4>
                            <ul class="box-controls pull-right">
                                <li><a class="box-btn-slide" href="#"></a></li>
                            </ul>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Topic</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $pdo->query("SELECT * FROM appointments ORDER BY created_at DESC LIMIT 5");
                                        while ($row = $stmt->fetch()) {
                                            $statusColor = 'warning';
                                            if ($row['status'] == 'confirmed') $statusColor = 'success';
                                            if ($row['status'] == 'completed') $statusColor = 'info';
                                            if ($row['status'] == 'cancelled') $statusColor = 'danger';
                                            
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['topic']) . "</td>";
                                            echo "<td><span class='text-muted'><i class='fa fa-calendar'></i> " . htmlspecialchars($row['appointment_date']) . "</span></td>";
                                            echo "<td><span class='badge badge-$statusColor'>" . ucfirst($row['status']) . "</span></td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer text-center">
                            <a href="manage_appointments.php" class="text-uppercase">View All Appointments</a>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
</div>
<!-- /.content-wrapper -->

<?php require_once 'includes/footer.php'; ?>
<script src="js/pages/dashboard_analytics.js"></script>