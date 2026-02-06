<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                
                <!-- Recent Enquiries -->
                <div class="col-xl-7 col-lg-6 col-12">
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Recent Enquiries</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recent-enquiries-table">
                                        <!-- Loaded via JS -->
                                        <tr><td colspan="5" class="text-center">Loading...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Engagement Chart -->
                <div class="col-xl-5 col-lg-6 col-12">
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Engagement Overview</h4>
                        </div>
                        <div class="box-body">
                            <div class="chart-responsive">
                                <div class="chart" id="bar-chart" style="height: 354px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visitor Analytics -->
                <div class="col-xl-6 col-12">
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Visitor Analytics (Last 7 Days)</h4>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="visitor-chart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Browser Stats -->
                <div class="col-xl-6 col-12">
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Browser Statistics</h4>
                        </div>
                        <div class="box-body chart-responsive">
                            <div class="chart" id="browser-chart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
<!-- /.content-wrapper -->

<?php include 'includes/footer.php'; ?>
