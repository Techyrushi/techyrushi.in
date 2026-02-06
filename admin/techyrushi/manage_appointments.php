<?php 
require_once '../config.php';
require_once '../../includes/email_helper.php';

include 'includes/header.php';
include 'includes/sidebar.php';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ?");
            $stmt->execute([$id]);
            echo '<div class="alert alert-success">Appointment deleted successfully!</div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    } elseif (isset($_POST['update_status'])) {
        $id = $_POST['status_id'];
        $status = $_POST['status'];
        try {
            $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            
            // Send email based on status
            if (in_array($status, ['confirmed', 'completed', 'cancelled'])) {
                $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
                $stmt->execute([$id]);
                $appt = $stmt->fetch();

                if ($appt) {
                    $to = $appt['email'];
                    $name = htmlspecialchars($appt['name']);
                    $topic = htmlspecialchars($appt['topic']);
                    $date = htmlspecialchars($appt['appointment_date']);
                    $time = htmlspecialchars($appt['appointment_time']);
                    
                    $subject = "";
                    $body_content = "";
                    
                    if ($status == 'confirmed') {
                        $subject = "Appointment Confirmed - Techyrushi";
                        $body_content = "
                            <h2>Appointment Confirmed</h2>
                            <p>Hi <strong>$name</strong>,</p>
                            <p>Your appointment for <strong>$topic</strong> has been confirmed.</p>
                            <table>
                                <tr><th>Date</th><td>$date</td></tr>
                                <tr><th>Time</th><td>$time</td></tr>
                                <tr><th>Topic</th><td>$topic</td></tr>
                            </table>
                            <p>We look forward to meeting you!</p>
                        ";
                    } elseif ($status == 'completed') {
                        $subject = "Appointment Completed - Techyrushi";
                        $body_content = "
                            <h2>Appointment Completed</h2>
                            <p>Hi <strong>$name</strong>,</p>
                            <p>Your appointment for <strong>$topic</strong> has been marked as completed.</p>
                            <p>Thank you for choosing Techyrushi. It was a pleasure serving you.</p>
                        ";
                    } elseif ($status == 'cancelled') {
                        $subject = "Appointment Cancelled - Techyrushi";
                        $body_content = "
                            <h2>Appointment Cancelled</h2>
                            <p>Hi <strong>$name</strong>,</p>
                            <p>Your appointment for <strong>$topic</strong> scheduled on <strong>$date</strong> at <strong>$time</strong> has been cancelled.</p>
                            <p>If you did not request this cancellation or would like to reschedule, please contact us immediately.</p>
                        ";
                    }

                    $body_content .= "<br><p>Best Regards,<br><strong>Techyrushi Team</strong></p>";
                    
                    try {
                        send_email($to, $subject, $body_content, 'crushikesh74@gmail.com', 'Techyrushi Admin');
                        echo '<div class="alert alert-success">Status updated to ' . ucfirst($status) . ' and email sent!</div>';
                    } catch (Exception $e) {
                        echo '<div class="alert alert-warning">Status updated, but email failed: ' . $e->getMessage() . '</div>';
                    }
                } else {
                     echo '<div class="alert alert-success">Status updated successfully!</div>';
                }
            } else {
                echo '<div class="alert alert-success">Status updated successfully!</div>';
            }
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
        }
    }
}
?>

<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Manage Appointments</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Appointments</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Appointments List</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Contact</th>
                                    <th>Topic</th>
                                    <th>Date/Time</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Pagination Configuration
                                $results_per_page = 10;
                                
                                // Get current page
                                if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                                    $page = (int)$_GET['page'];
                                } else {
                                    $page = 1;
                                }
                                
                                // Calculate offset
                                $offset = ($page - 1) * $results_per_page;
                                
                                // Get total records
                                $stmt_count = $pdo->query("SELECT COUNT(*) FROM appointments");
                                $total_records = $stmt_count->fetchColumn();
                                $total_pages = ceil($total_records / $results_per_page);
                                
                                // Fetch records with limit
                                $stmt = $pdo->prepare("SELECT * FROM appointments ORDER BY created_at DESC LIMIT :offset, :limit");
                                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                $stmt->execute();
                                
                                $index = $offset + 1;
                                while ($row = $stmt->fetch()) {
                                    echo '<tr>';
                                    echo '<td>' . $index++ . '</td>';
                                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                    echo '<td>
                                        <i class="fa fa-envelope"></i> ' . htmlspecialchars($row['email']) . '<br>
                                        <i class="fa fa-phone"></i> ' . htmlspecialchars($row['phone']) . '
                                    </td>';
                                    echo '<td>' . htmlspecialchars($row['topic']) . '</td>';
                                    echo '<td>
                                        <span class="label label-primary">' . htmlspecialchars($row['appointment_date']) . '</span><br>
                                        <span class="label label-info">' . htmlspecialchars($row['appointment_time']) . '</span>
                                    </td>';
                                    echo '<td>' . htmlspecialchars(substr($row['message'], 0, 50)) . '...</td>';
                                    
                                    // Status Logic
                                    $statusColor = 'warning';
                                    if ($row['status'] == 'confirmed') $statusColor = 'success';
                                    if ($row['status'] == 'completed') $statusColor = 'info';
                                    if ($row['status'] == 'cancelled') $statusColor = 'danger';
                                    
                                    echo '<td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-info btn-sm view-appointment-btn" 
                                                data-name="'.htmlspecialchars($row['name']).'" 
                                                data-email="'.htmlspecialchars($row['email']).'" 
                                                data-phone="'.htmlspecialchars($row['phone']).'" 
                                                data-topic="'.htmlspecialchars($row['topic']).'" 
                                                data-message="'.htmlspecialchars($row['message']).'" 
                                                data-date="'.htmlspecialchars($row['appointment_date']).'"
                                                data-time="'.htmlspecialchars($row['appointment_time']).'"
                                                data-bs-toggle="modal" data-bs-target="#view-appointment-modal">View</button>
                                            <button type="button" class="btn btn-' . $statusColor . ' btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                                ' . ucfirst($row['status']) . '
                                            </button>
                                            <div class="dropdown-menu">
                                                <form method="POST" style="margin:0;">
                                                    <input type="hidden" name="status_id" value="' . $row['id'] . '">
                                                    <input type="hidden" name="update_status" value="1">
                                                    <button type="submit" name="status" value="pending" class="dropdown-item">Pending</button>
                                                    <button type="submit" name="status" value="confirmed" class="dropdown-item">Confirmed</button>
                                                    <button type="submit" name="status" value="completed" class="dropdown-item">Completed</button>
                                                    <button type="submit" name="status" value="cancelled" class="dropdown-item">Cancelled</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>';
                                    
                                    echo '<td>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\')">
                                            <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <div class="d-flex justify-content-center mt-30">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm">
                                <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ($page - 1); ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ($page + 1); ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- View Appointment Modal -->
<div class="modal fade" id="view-appointment-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="view-appt-name"></span></p>
                <p><strong>Contact:</strong> <span id="view-appt-contact"></span></p>
                <p><strong>Topic:</strong> <span id="view-appt-topic"></span></p>
                <p><strong>Date & Time:</strong> <span id="view-appt-datetime"></span></p>
                <hr>
                <p><strong>Message:</strong></p>
                <div class="p-3 bg-light rounded" id="view-appt-message" style="white-space: pre-wrap;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var viewModal = document.getElementById('view-appointment-modal');
    viewModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        
        document.getElementById('view-appt-name').textContent = button.getAttribute('data-name');
        document.getElementById('view-appt-contact').textContent = button.getAttribute('data-email') + ' / ' + button.getAttribute('data-phone');
        document.getElementById('view-appt-topic').textContent = button.getAttribute('data-topic');
        document.getElementById('view-appt-datetime').textContent = button.getAttribute('data-date') + ' at ' + button.getAttribute('data-time');
        document.getElementById('view-appt-message').textContent = button.getAttribute('data-message');
    });
});
</script>

<?php
include 'includes/footer.php';
?>
