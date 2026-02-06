<?php
include 'includes/header.php';
include 'includes/sidebar.php';

// Handle Delete
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM contact_enquiries WHERE id = ?");
        $stmt->execute([$id]);
        echo '<div class="alert alert-success">Enquiry deleted successfully!</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

// Handle Read Status & Filter
$filter_id = isset($_GET['id']) ? $_GET['id'] : null;
if ($filter_id) {
    // Mark as read
    $stmt = $pdo->prepare("UPDATE contact_enquiries SET is_read = 1 WHERE id = ?");
    $stmt->execute([$filter_id]);
}

// Pagination Configuration
$results_per_page = 10;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $results_per_page;

// Count total records
if ($filter_id) {
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM contact_enquiries WHERE id = ?");
    $stmt_count->execute([$filter_id]);
} else {
    $stmt_count = $pdo->query("SELECT COUNT(*) FROM contact_enquiries");
}
$total_records = $stmt_count->fetchColumn();
$total_pages = ceil($total_records / $results_per_page);
?>

<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Manage Enquiries</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Enquiries</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Contact Enquiries</h4>
                    <?php if ($filter_id): ?>
                        <a href="manage_enquiries.php" class="btn btn-sm btn-info pull-right">Show All</a>
                    <?php endif; ?>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM contact_enquiries";
                                if ($filter_id) {
                                    $sql .= " WHERE id = " . intval($filter_id);
                                }
                                $sql .= " ORDER BY id DESC LIMIT :offset, :limit";
                                
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                $stmt->execute();
                                
                                $index = $offset;
                                while ($row = $stmt->fetch()) {
                                    $isRead = $row['is_read'] ? '<span class="badge bg-success">Read</span>' : '<span class="badge bg-danger">Unread</span>';
                                    echo '<tr>';
                                    echo '<td>' . ++$index . '</td>';   
                                    echo '<td>' . $isRead . '</td>';
                                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                                    echo '<td>' . htmlspecialchars(substr($row['message'], 0, 50)) . '...</td>';
                                    echo '<td>' . (isset($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A') . '</td>';
                                    echo '<td>
                                        <button type="button" class="btn btn-info btn-sm view-enquiry-btn" 
                                            data-name="'.htmlspecialchars($row['name']).'" 
                                            data-email="'.htmlspecialchars($row['email']).'" 
                                            data-phone="'.htmlspecialchars($row['phone']).'" 
                                            data-subject="'.htmlspecialchars($row['subject']).'" 
                                            data-message="'.htmlspecialchars($row['message']).'" 
                                            data-date="'.(isset($row['created_at']) ? htmlspecialchars($row['created_at']) : 'N/A').'"
                                            data-bs-toggle="modal" data-bs-target="#view-enquiry-modal">View</button>
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
                    <div class="mt-3">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm justify-content-center">
                                <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ($page - 1); ?><?php echo $filter_id ? '&id='.$filter_id : ''; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?><?php echo $filter_id ? '&id='.$filter_id : ''; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo ($page + 1); ?><?php echo $filter_id ? '&id='.$filter_id : ''; ?>" aria-label="Next">
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

<!-- View Enquiry Modal -->
<div class="modal fade" id="view-enquiry-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enquiry Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="view-name"></span></p>
                <p><strong>Email:</strong> <span id="view-email"></span></p>
                <p><strong>Phone:</strong> <span id="view-phone"></span></p>
                <p><strong>Date:</strong> <span id="view-date"></span></p>
                <hr>
                <p><strong>Subject:</strong> <span id="view-subject"></span></p>
                <p><strong>Message:</strong></p>
                <div class="p-3 bg-light rounded" id="view-message" style="white-space: pre-wrap;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Use event delegation or direct binding since we use data attributes
    var viewModal = document.getElementById('view-enquiry-modal');
    viewModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        
        document.getElementById('view-name').textContent = button.getAttribute('data-name');
        document.getElementById('view-email').textContent = button.getAttribute('data-email');
        document.getElementById('view-phone').textContent = button.getAttribute('data-phone');
        document.getElementById('view-date').textContent = button.getAttribute('data-date');
        document.getElementById('view-subject').textContent = button.getAttribute('data-subject');
        document.getElementById('view-message').textContent = button.getAttribute('data-message');
    });
});
</script>

<script>
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