<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
require_once '../../includes/email_helper.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$error = '';
$success = '';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM newsletter_subscribers WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Subscriber deleted successfully.";
    } elseif (isset($_POST['send_bulk_email'])) {
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        
        // Handle Attachment
        $attachment_path = null;
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
            $target_dir = "../../assets/files/temp/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $filename = time() . "_" . basename($_FILES["attachment"]["name"]);
            $attachment_path = $target_dir . $filename;
            move_uploaded_file($_FILES["attachment"]["tmp_name"], $attachment_path);
        }

        // Fetch all subscribers
        $stmt = $pdo->query("SELECT email FROM newsletter_subscribers");
        $subscribers = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $sent_count = 0;
        foreach ($subscribers as $email) {
            // send_email($to, $subject, $body, $reply_to, $reply_to_name, $attachment)
            if (send_email($email, $subject, $message, null, '', $attachment_path)) {
                $sent_count++;
            }
        }

        // Clean up attachment
        if ($attachment_path && file_exists($attachment_path)) {
            unlink($attachment_path);
        }

        $success = "Newsletter sent to $sent_count subscribers successfully.";
        $action = 'list';
    }
}
?>

<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Newsletter Manager</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Newsletter</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($action == 'list'): ?>
                <?php
                // Pagination Configuration
                $results_per_page = 10;
                if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                    $page = (int)$_GET['page'];
                } else {
                    $page = 1;
                }
                $offset = ($page - 1) * $results_per_page;
                
                // Count total records
                $stmt_count = $pdo->query("SELECT COUNT(*) FROM newsletter_subscribers");
                $total_records = $stmt_count->fetchColumn();
                $total_pages = ceil($total_records / $results_per_page);
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Subscribers List</h3>
                        <div class="pull-right">
                            <a href="manage_newsletter.php?action=compose" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Send Bulk Email</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Subscribed At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT * FROM newsletter_subscribers ORDER BY created_at DESC LIMIT :offset, :limit");
                                    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                    $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                    $stmt->execute();
                                    
                                    $index = $offset + 1;
                                    while ($row = $stmt->fetch()) {
                                        echo '<tr>';
                                        echo '<td>' . $index++ . '</td>';
                                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                        echo '<td>' . date('M j, Y H:i', strtotime($row['created_at'])) . '</td>';
                                        echo '<td>
                                            <form method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this subscriber?\')">
                                                <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                        </td>';
                                        echo '</tr>';
                                    }
                                    if ($total_records == 0) {
                                        echo '<tr><td colspan="4" class="text-center">No subscribers found.</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                        <div class="mt-3">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm justify-content-center">
                                    <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo ($page - 1); ?>&action=list" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&action=list"><?php echo $i; ?></a>
                                    </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo ($page + 1); ?>&action=list" aria-label="Next">
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

            <?php elseif ($action == 'compose'): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Compose Bulk Email</h3>
                        <a href="manage_newsletter.php" class="btn btn-secondary pull-right">Back to List</a>
                    </div>
                    <div class="box-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="send_bulk_email" value="1">
                            
                            <div class="form-group">
                                <label>Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" class="form-control" required placeholder="Enter email subject">
                            </div>

                            <div class="form-group">
                                <label>Attachment (Optional)</label>
                                <input type="file" name="attachment" class="form-control">
                                <small class="text-muted">Supported formats: PDF, DOC, JPG, PNG</small>
                            </div>

                            <div class="form-group">
                                <label>Message <span class="text-danger">*</span></label>
                                <textarea name="message" id="editor1" class="form-control" rows="10" required></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-paper-plane"></i> Send to All Subscribers</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    if(document.getElementById('editor1')) {
        CKEDITOR.replace('editor1');
    }

    // Form Submission Safeguard (Spinner & Disable)
    document.addEventListener('DOMContentLoaded', function() {
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    var originalText = submitBtn.innerHTML;
                    setTimeout(function() {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
                    }, 10);
                }
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
