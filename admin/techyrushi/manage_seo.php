<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        try {
            if ($_POST['action'] === 'add') {
                $stmt = $pdo->prepare("INSERT INTO seo_metadata (route, page_title, meta_keywords, meta_description) VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['route'],
                    $_POST['page_title'],
                    $_POST['meta_keywords'],
                    $_POST['meta_description']
                ]);
                echo "<script>alert('SEO Entry Added Successfully');</script>";
            } elseif ($_POST['action'] === 'edit') {
                $stmt = $pdo->prepare("UPDATE seo_metadata SET route = ?, page_title = ?, meta_keywords = ?, meta_description = ? WHERE id = ?");
                $stmt->execute([
                    $_POST['route'],
                    $_POST['page_title'],
                    $_POST['meta_keywords'],
                    $_POST['meta_description'],
                    $_POST['id']
                ]);
                echo "<script>alert('SEO Entry Updated Successfully');</script>";
            } elseif ($_POST['action'] === 'delete') {
                $stmt = $pdo->prepare("DELETE FROM seo_metadata WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                echo "<script>alert('SEO Entry Deleted Successfully');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "');</script>";
        }
    }
}

// Pagination Configuration
$results_per_page = 10;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $results_per_page;
?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header with-border d-flex justify-content-between align-items-center">
                            <h4 class="box-title">SEO Management</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-seo" onclick="resetForm()">
                                Add New SEO Entry
                            </button>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Route/Page</th>
                                            <th>Title</th>
                                            <th>Keywords</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Count total records for pagination
                                        $count_stmt = $pdo->query("SELECT COUNT(*) FROM seo_metadata");
                                        $total_records = $count_stmt->fetchColumn();
                                        $total_pages = ceil($total_records / $results_per_page);

                                        $stmt = $pdo->prepare("SELECT * FROM seo_metadata ORDER BY route ASC LIMIT :offset, :limit");
                                        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                        $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                        $stmt->execute();
                                        
                                        while ($row = $stmt->fetch()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['route']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['page_title']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['meta_keywords']) . "</td>";
                                            echo "<td>" . htmlspecialchars(substr($row['meta_description'], 0, 50)) . "...</td>";
                                            echo '<td>
                                                <button class="btn btn-sm btn-info" onclick=\'editSeo(' . json_encode($row) . ')\'>Edit</button>
                                                <form method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="' . $row['id'] . '">
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>';
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <?php if ($total_pages > 1): ?>
                            <div class="row mt-15">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" role="status" aria-live="polite">
                                        Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $results_per_page, $total_records); ?> of <?php echo $total_records; ?> entries
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers">
                                        <ul class="pagination">
                                            <!-- Previous Page Link -->
                                            <li class="paginate_button page-item previous <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                                <a href="<?php echo ($page <= 1) ? '#' : '?page='.($page-1); ?>" class="page-link">Previous</a>
                                            </li>

                                            <!-- Page Number Links -->
                                            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                                <li class="paginate_button page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                                    <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <!-- Next Page Link -->
                                            <li class="paginate_button page-item next <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                                <a href="<?php echo ($page >= $total_pages) ? '#' : '?page='.($page+1); ?>" class="page-link">Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-seo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-title">Add SEO Entry</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" id="seo-action" value="add">
                    <input type="hidden" name="id" id="seo-id">
                    
                    <div class="form-group">
                        <label>Page Route (e.g., index, about, contact)</label>
                        <input type="text" class="form-control" name="route" id="seo-route" required>
                    </div>
                    <div class="form-group">
                        <label>Page Title</label>
                        <input type="text" class="form-control" name="page_title" id="seo-title" required>
                    </div>
                    <div class="form-group">
                        <label>Meta Keywords</label>
                        <textarea class="form-control" name="meta_keywords" id="seo-keywords" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description" id="seo-description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetForm() {
    $('#modal-title').text('Add SEO Entry');
    $('#seo-action').val('add');
    $('#seo-id').val('');
    $('#seo-route').val('');
    $('#seo-title').val('');
    $('#seo-keywords').val('');
    $('#seo-description').val('');
}

function editSeo(data) {
    $('#modal-title').text('Edit SEO Entry');
    $('#seo-action').val('edit');
    $('#seo-id').val(data.id);
    $('#seo-route').val(data.route);
    $('#seo-title').val(data.page_title);
    $('#seo-keywords').val(data.meta_keywords);
    $('#seo-description').val(data.meta_description);
    
    $('#modal-seo').modal('show');
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

<?php require_once 'includes/footer.php'; ?>
