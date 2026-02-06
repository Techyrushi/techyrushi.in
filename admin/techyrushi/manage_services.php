<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Pagination Configuration
$results_per_page = 10;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}
$offset = ($page - 1) * $results_per_page;

$error = '';
$success = '';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Service deleted successfully.";
    } elseif (isset($_POST['save_service'])) {
        $title = $_POST['title'];
        $slug = $_POST['slug'] ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $short_description = $_POST['short_description'];
        $content = $_POST['content'];
        $icon = $_POST['icon'];
        $display_order = $_POST['display_order'];
        $id = $_POST['id']; // Empty if adding

        // Handle Image Upload
        $image = $_POST['current_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../../assets/images/service/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            $filename = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $filename;
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $filename;
            }
        }

        // Handle Brochure Upload
        $brochure = $_POST['current_brochure'];
        if (isset($_FILES['brochure']) && $_FILES['brochure']['error'] == 0) {
            $target_dir_bro = "../../assets/files/service/";
            if (!is_dir($target_dir_bro)) mkdir($target_dir_bro, 0777, true);
            $filename_bro = time() . "_" . basename($_FILES["brochure"]["name"]);
            $target_file_bro = $target_dir_bro . $filename_bro;
            if (move_uploaded_file($_FILES["brochure"]["tmp_name"], $target_file_bro)) {
                $brochure = $filename_bro;
            }
        }

        if ($id) {
            // Update
            $stmt = $pdo->prepare("UPDATE services SET title=?, slug=?, short_description=?, content=?, image=?, icon=?, display_order=?, brochure=? WHERE id=?");
            $stmt->execute([$title, $slug, $short_description, $content, $image, $icon, $display_order, $brochure, $id]);
            $success = "Service updated successfully.";
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO services (title, slug, short_description, content, image, icon, display_order, brochure) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $short_description, $content, $image, $icon, $display_order, $brochure]);
            $success = "Service added successfully.";
        }
        $action = 'list';
    }
}

?>

<div class="content-wrapper">
    <div class="container-full">
        <section class="content">
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($action == 'list'): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Manage Services</h3>
                        <a href="manage_services.php?action=add" class="btn btn-primary pull-right">Add New Service</a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Icon</th>
                                        <th>Order</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Count total records for pagination
                                    $count_stmt = $pdo->query("SELECT COUNT(*) FROM services");
                                    $total_records = $count_stmt->fetchColumn();
                                    $total_pages = ceil($total_records / $results_per_page);

                                    $stmt = $pdo->prepare("SELECT * FROM services ORDER BY display_order ASC, created_at DESC LIMIT :offset, :limit");
                                    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                    $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        if ($row['image']) {
                                            echo '<img src="../../assets/images/service/' . $row['image'] . '" width="50">';
                                        }
                                        echo '</td>';
                                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                                        echo '<td><i class="' . htmlspecialchars($row['icon']) . '"></i> ' . htmlspecialchars($row['icon']) . '</td>';
                                        echo '<td>' . $row['display_order'] . '</td>';
                                        echo '<td>
                                            <a href="manage_services.php?action=edit&id=' . $row['id'] . '" class="btn btn-info btn-sm">Edit</a>
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
                        <div class="row">
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
            <?php elseif ($action == 'add' || $action == 'edit'): 
                $service = ['id' => '', 'title' => '', 'slug' => '', 'short_description' => '', 'content' => '', 'image' => '', 'icon' => 'flaticon-web', 'display_order' => 0, 'brochure' => ''];
                if ($action == 'edit' && isset($_GET['id'])) {
                    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
                    $stmt->execute([$_GET['id']]);
                    $service = $stmt->fetch();
                }
            ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo ucfirst($action); ?> Service</h3>
                        <a href="manage_services.php" class="btn btn-secondary pull-right">Back to List</a>
                    </div>
                    <div class="box-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $service['image']; ?>">
                            <input type="hidden" name="current_brochure" value="<?php echo $service['brochure']; ?>">
                            <input type="hidden" name="save_service" value="1">
                            
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($service['title']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Slug (Leave empty to auto-generate)</label>
                                <input type="text" name="slug" class="form-control" value="<?php echo htmlspecialchars($service['slug']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Short Description</label>
                                <textarea name="short_description" class="form-control" rows="3"><?php echo htmlspecialchars($service['short_description']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="content" id="editor1" class="form-control" rows="10"><?php echo htmlspecialchars($service['content']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Icon Class (e.g., flaticon-web, fa fa-cog)</label>
                                <input type="text" name="icon" class="form-control" value="<?php echo htmlspecialchars($service['icon']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Display Order</label>
                                <input type="number" name="display_order" class="form-control" value="<?php echo $service['display_order']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control">
                                <?php if ($service['image']): ?>
                                    <div class="mt-2">
                                        <img src="../../assets/images/service/<?php echo $service['image']; ?>" width="100">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label>Brochure (PDF)</label>
                                <input type="file" name="brochure" class="form-control">
                                <?php if ($service['brochure']): ?>
                                    <div class="mt-2">
                                        <a href="../../assets/files/service/<?php echo $service['brochure']; ?>" target="_blank">View Current Brochure</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>

                <!-- CKEditor -->
                <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace( 'editor1', {
                        filebrowserUploadUrl: 'upload_image.php',
                        filebrowserUploadMethod: 'form'
                    });

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
            <?php endif; ?>
        </section>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
