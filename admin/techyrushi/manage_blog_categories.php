<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<div class="content-wrapper">
    <div class="container-full">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="page-title">Manage Blog Categories</h3>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Blog Categories</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="row">
                <!-- Add/Edit Category Form -->
                <div class="col-12 col-lg-4">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <?php echo isset($_GET['edit']) ? 'Edit Category' : 'Add New Category'; ?>
                            </h4>
                        </div>
                        <div class="box-body">
                            <?php
                            $name = '';
                            $edit_id = 0;
                            if (isset($_GET['edit'])) {
                                $edit_id = (int)$_GET['edit'];
                                $stmt = $pdo->prepare("SELECT * FROM blog_categories WHERE id = ?");
                                $stmt->execute([$edit_id]);
                                $category = $stmt->fetch();
                                if ($category) {
                                    $name = $category['name'];
                                }
                            }

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $name = trim($_POST['name']);
                                
                                if (!empty($name)) {
                                    try {
                                        if (isset($_POST['update_id'])) {
                                            $update_id = (int)$_POST['update_id'];
                                            $stmt = $pdo->prepare("UPDATE blog_categories SET name = ? WHERE id = ?");
                                            $stmt->execute([$name, $update_id]);
                                            echo '<div class="alert alert-success">Category updated successfully!</div>';
                                            echo '<script>setTimeout(function(){ window.location.href="manage_blog_categories.php"; }, 1000);</script>';
                                        } else {
                                            $stmt = $pdo->prepare("INSERT INTO blog_categories (name) VALUES (?)");
                                            $stmt->execute([$name]);
                                            echo '<div class="alert alert-success">Category added successfully!</div>';
                                            $name = ''; // Reset form
                                        }
                                    } catch (PDOException $e) {
                                        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger">Name is required.</div>';
                                }
                            }
                            
                            // Handle Delete
                            if (isset($_POST['delete_id'])) {
                                $delete_id = (int)$_POST['delete_id'];
                                try {
                                    // Check if used in blogs
                                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM blog_posts WHERE category_id = ?");
                                    $stmt->execute([$delete_id]);
                                    if ($stmt->fetchColumn() > 0) {
                                        echo '<div class="alert alert-warning">Cannot delete: Category is used in blog posts.</div>';
                                    } else {
                                        $stmt = $pdo->prepare("DELETE FROM blog_categories WHERE id = ?");
                                        $stmt->execute([$delete_id]);
                                        echo '<div class="alert alert-success">Category deleted successfully!</div>';
                                    }
                                } catch (PDOException $e) {
                                    echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
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

                            <form method="POST">
                                <?php if ($edit_id): ?>
                                    <input type="hidden" name="update_id" value="<?php echo $edit_id; ?>">
                                <?php endif; ?>
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <?php echo $edit_id ? 'Update Category' : 'Add Category'; ?>
                                </button>
                                <?php if ($edit_id): ?>
                                    <a href="manage_blog_categories.php" class="btn btn-secondary">Cancel</a>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Category List -->
                <div class="col-12 col-lg-8">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">All Categories</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $index = 1;
                                        // Count total records for pagination
                                        $count_stmt = $pdo->query("SELECT COUNT(*) FROM blog_categories");
                                        $total_records = $count_stmt->fetchColumn();
                                        $total_pages = ceil($total_records / $results_per_page);

                                        $stmt = $pdo->prepare("SELECT * FROM blog_categories ORDER BY id DESC LIMIT :offset, :limit");
                                        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                        $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                        $stmt->execute();
                                        
                                        while ($row = $stmt->fetch()) {
                                            echo '<tr>';
                                            echo '<td>' . $index++ . '</td>';
                                            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                            echo '<td>
                                                <a href="manage_blog_categories.php?edit=' . $row['id'] . '" class="btn btn-info btn-sm">Edit</a>
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
