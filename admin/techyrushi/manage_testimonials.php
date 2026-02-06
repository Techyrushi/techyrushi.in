<?php
include 'includes/header.php';
include 'includes/sidebar.php';

// Handle Image Upload
function uploadImage($file) {
    $target_dir = "../../assets/images/testimonial/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $unique_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $unique_name;
    
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $unique_name;
        }
    }
    return false;
}

// Handle Add/Edit/Delete
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_testimonial'])) {
        $name = trim($_POST['name']);
        $designation = trim($_POST['designation']);
        $content = trim($_POST['content']);
        $image = '';
        
        if (!empty($_FILES['image']['name'])) {
            $image = uploadImage($_FILES['image']);
        }
        
        try {
            $stmt = $pdo->prepare("INSERT INTO testimonials (name, designation, content, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $designation, $content, $image]);
            $success = "Testimonial added successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['update_testimonial'])) {
        $id = $_POST['id'];
        $name = trim($_POST['name']);
        $designation = trim($_POST['designation']);
        $content = trim($_POST['content']);
        
        try {
            if (!empty($_FILES['image']['name'])) {
                $image = uploadImage($_FILES['image']);
                $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, designation = ?, content = ?, image = ? WHERE id = ?");
                $stmt->execute([$name, $designation, $content, $image, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE testimonials SET name = ?, designation = ?, content = ? WHERE id = ?");
                $stmt->execute([$name, $designation, $content, $id]);
            }
            $success = "Testimonial updated successfully!";
            echo '<script>setTimeout(function(){ window.location.href="manage_testimonials.php"; }, 1000);</script>';
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        try {
            $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            $success = "Testimonial deleted successfully!";
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Manage Testimonials</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($action == 'edit' && isset($_GET['id'])): 
                $stmt = $pdo->prepare("SELECT * FROM testimonials WHERE id = ?");
                $stmt->execute([$_GET['id']]);
                $testimonial = $stmt->fetch();
                if ($testimonial):
            ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h4 class="box-title">Edit Testimonial</h4>
                    </div>
                    <div class="box-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($testimonial['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Designation</label>
                                <input type="text" name="designation" class="form-control" value="<?php echo htmlspecialchars($testimonial['designation']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea name="content" class="form-control" rows="4" required><?php echo htmlspecialchars($testimonial['content']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Current Image</label><br>
                                <?php if ($testimonial['image']): ?>
                                    <img src="../../assets/images/testimonial/<?php echo $testimonial['image']; ?>" width="100"><br>
                                <?php endif; ?>
                                <label>Change Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <button type="submit" name="update_testimonial" class="btn btn-primary">Update Testimonial</button>
                            <a href="manage_testimonials.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            <?php endif; elseif ($action == 'list'): ?>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">Add New Testimonial</h4>
                            </div>
                            <div class="box-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <input type="text" name="designation" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="content" class="form-control" rows="4" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" name="image" class="form-control">
                                    </div>
                                    <button type="submit" name="add_testimonial" class="btn btn-primary">Add Testimonial</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-8">
                        <div class="box">
                            <div class="box-header with-border">
                                <h4 class="box-title">All Testimonials</h4>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th>Content</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Count total records for pagination
                                            $count_stmt = $pdo->query("SELECT COUNT(*) FROM testimonials");
                                            $total_records = $count_stmt->fetchColumn();
                                            $total_pages = ceil($total_records / $results_per_page);

                                            $stmt = $pdo->prepare("SELECT * FROM testimonials ORDER BY created_at DESC LIMIT :offset, :limit");
                                            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                            $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                            $stmt->execute();
                                            
                                            while ($row = $stmt->fetch()) {
                                                echo '<tr>';
                                                echo '<td>';
                                                if ($row['image']) {
                                                    echo '<img src="../../assets/images/testimonial/' . $row['image'] . '" width="50">';
                                                }
                                                echo '</td>';
                                                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['designation']) . '</td>';
                                                echo '<td>' . htmlspecialchars(substr($row['content'], 0, 50)) . '...</td>';
                                                echo '<td>
                                                    <a href="manage_testimonials.php?action=edit&id=' . $row['id'] . '" class="btn btn-info btn-sm">Edit</a>
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
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>

<script>
// Form Submission Safeguard (Spinner & Disable)
document.addEventListener('DOMContentLoaded', function() {
    var forms = document.querySelectorAll('form');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            var submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                // For delete forms, we need to let the confirm dialog happen first
                // The onsubmit in the HTML handles the confirm, if it returns true, this runs
                // However, the inline onsubmit runs BEFORE this event listener usually.
                // But to be safe, we can just check if it's a delete action if needed.
                // Actually, standard submit events bubble. The inline onsubmit returns false to cancel.
                // If we are here, it wasn't cancelled.
                
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
