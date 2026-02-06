<!-- /.content-wrapper -->
<footer class="main-footer">
    &copy; 2026 <a href="https://techyrushi.in/">Techyrushi</a>. All Rights Reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar">

    <div class="rpanel-title"><span class="pull-right btn btn-circle btn-danger"><i class="ion ion-close text-white"
                data-toggle="control-sidebar"></i></span> </div> <!-- Create the tabs -->
    <ul class="nav nav-tabs control-sidebar-tabs">
        <li class="nav-item"><a href="#control-sidebar-home-tab" data-bs-toggle="tab" class="active"><i
                    class="mdi mdi-message-text"></i></a></li>
        <li class="nav-item"><a href="#control-sidebar-settings-tab" data-bs-toggle="tab"><i
                    class="mdi mdi-playlist-check"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <div class="flexbox">
                <a href="javascript:void(0)" class="text-grey">
                    <i class="ti-more"></i>
                </a>
                <p>Users</p>
                <a href="javascript:void(0)" class="text-end text-grey"><i class="ti-plus"></i></a>
            </div>
            <div class="lookup lookup-sm lookup-right d-none d-lg-block">
                <input type="text" name="s" placeholder="Search" class="w-p100">
            </div>
            <div class="media-list media-list-hover mt-20">
                <?php
                try {
                    if (isset($pdo)) {
                        $stmt = $pdo->query("SELECT * FROM admins ORDER BY created_at DESC LIMIT 10");
                         while ($admin = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // Status colors
                            $statusColors = ['success', 'warning', 'danger', 'primary'];
                            $status = $statusColors[array_rand($statusColors)];
                            
                            // Avatar logic
                            if (!empty($admin['avatar'])) {
                                $avatarSrc = "../images/avatar/" . htmlspecialchars($admin['avatar']);
                            } else {
                                // Default avatar or random one
                                $avatarId = rand(1, 8);
                                $avatarSrc = "../images/avatar/" . $avatarId . ".jpg";
                            }
                            
                            echo '<div class="media py-10 px-0">
                                <a class="avatar avatar-lg status-'.$status.'" href="#">
                                    <img src="'.$avatarSrc.'" alt="...">
                                </a>
                                <div class="media-body">
                                    <p class="fs-16">
                                        <a class="hover-primary" href="#"><strong>'.htmlspecialchars($admin['username']).'</strong></a>
                                    </p>
                                    <p>'.htmlspecialchars($admin['email']).'</p>
                                    <span>Admin</span>
                                </div>
                            </div>';
                        }
                    }
                } catch (Exception $e) {
                    echo '<p class="text-danger">Error loading users</p>';
                }
                ?>
            </div>

        </div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <div class="flexbox">
                <a href="javascript:void(0)" class="text-grey">
                    <i class="ti-more"></i>
                </a>
                <p>Todo List</p>
                <a href="extra_taskboard.php" class="text-end text-grey"><i class="ti-plus"></i></a>
            </div>
            <ul class="todo-list mt-20">
                <?php
                // Fetch latest tasks for the sidebar
                try {
                    // Re-use existing $pdo connection if available, or create new if not (but footer is included where $pdo exists)
                    if (isset($pdo)) {
                        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE status != 'done' ORDER BY created_at DESC LIMIT 10");
                        $stmt->execute();
                        $sidebarTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($sidebarTasks) > 0) {
                            foreach ($sidebarTasks as $task) {
                                $badgeClass = 'bg-warning';
                                if ($task['status'] == 'in_progress') $badgeClass = 'bg-primary';
                                
                                // Calculate duration
                                $timeDisplay = 'N/A';
                                if (!empty($task['start_date']) && !empty($task['end_date'])) {
                                    try {
                                        $start = new DateTime($task['start_date']);
                                        $end = new DateTime($task['end_date']);
                                        $duration = $start->diff($end);
                                        
                                        $parts = [];
                                        if ($duration->d > 0) $parts[] = $duration->d . 'd';
                                        if ($duration->h > 0) $parts[] = $duration->h . 'h';
                                        if ($duration->i > 0) $parts[] = $duration->i . 'm';
                                        
                                        $timeDisplay = !empty($parts) ? implode(' ', $parts) : '0m';
                                    } catch (Exception $e) {
                                        $timeDisplay = 'Invalid Date';
                                    }
                                } else {
                                    // Fallback to Created vs Now if no start/end
                                    $created = new DateTime($task['created_at']);
                                    $now = new DateTime();
                                    $interval = $now->diff($created);
                                    if ($interval->d > 0) $timeDisplay = $interval->d . ' days ago';
                                    else if ($interval->h > 0) $timeDisplay = $interval->h . ' hrs ago';
                                    else $timeDisplay = $interval->i . ' mins ago';
                                }

                                echo '
                                <li class="py-15 px-5 by-1">
                                    <input type="checkbox" id="sidebar_task_' . $task['id'] . '" class="filled-in">
                                    <label for="sidebar_task_' . $task['id'] . '" class="mb-0 h-15"></label>
                                    <span class="text-line">' . htmlspecialchars($task['title']) . '</span>
                                    <small class="badge ' . $badgeClass . '"><i class="fa fa-clock-o"></i> ' . $timeDisplay . '</small>
                                </li>';
                            }
                        } else {
                            echo '<li class="py-15 px-5">No pending tasks.</li>';
                        }
                    }
                } catch (Exception $e) {
                    echo '<li class="py-15 px-5 text-danger">Error loading tasks</li>';
                }
                ?>
            </ul>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->


<!-- Vendor JS -->
<script src="js/vendors.min.js"></script>
<script src="js/pages/chat-popup.js"></script>
<script src="../assets/icons/feather-icons/feather.min.js"></script>

<script src="../assets/vendor_components/dropzone/dropzone.js"></script>

<!-- Techyrushi Admin App -->
<script src="js/template.js"></script>
<script src="js/notifications.js"></script>

</body>

<!-- Mirrored from master-admin-template.multipurposethemes.com/bs5/real-estate/addproperty.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Feb 2026 09:56:06 GMT -->

</html>