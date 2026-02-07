<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$error = '';
$success = '';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Blog post deleted successfully.";
    } elseif (isset($_POST['save_post'])) {
        $title = $_POST['title'];
        $slug = $_POST['slug'] ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $category_id = $_POST['category_id'];
        $author = $_POST['author'];
        $status = $_POST['status'];
        $content = $_POST['content'];
        $tags = $_POST['tags'];
        $video_url = $_POST['video_url'];
        $meta_title = $_POST['meta_title'];
        $meta_description = $_POST['meta_description'];
        $id = $_POST['id'];

        // Handle Image Upload
        $image = $_POST['current_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            require_once 'includes/image_helper.php';
            $target_dir = "../../assets/images/blog/";
            if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
            
            $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $filename = time() . "_" . uniqid() . "." . $extension;
            $target_file = $target_dir . $filename;
            
            // Resize to 1200x650
            if (resizeImage($_FILES["image"]["tmp_name"], $target_file, 1200, 650)) {
                $image = $filename;
            } else {
                // Fallback if resize fails
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $filename;
                }
            }
        }

        // Handle Attachment Upload
        $attachment = $_POST['current_attachment'];
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
            $target_dir_att = "../../assets/files/blog/";
            if (!is_dir($target_dir_att)) mkdir($target_dir_att, 0777, true);
            $filename_att = time() . "_" . basename($_FILES["attachment"]["name"]);
            $target_file_att = $target_dir_att . $filename_att;
            if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file_att)) {
                $attachment = $filename_att;
            }
        }

        if ($id) {
            // Update
            $stmt = $pdo->prepare("UPDATE blog_posts SET title=?, slug=?, category_id=?, author=?, status=?, content=?, tags=?, image=?, video_url=?, meta_title=?, meta_description=?, attachment=? WHERE id=?");
            $stmt->execute([$title, $slug, $category_id, $author, $status, $content, $tags, $image, $video_url, $meta_title, $meta_description, $attachment, $id]);
            $success = "Blog post updated successfully.";
        } else {
            // Insert
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, category_id, author, status, content, tags, image, video_url, meta_title, meta_description, attachment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$title, $slug, $category_id, $author, $status, $content, $tags, $image, $video_url, $meta_title, $meta_description, $attachment]);
            $success = "Blog post added successfully.";
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
                $stmt_count = $pdo->query("SELECT COUNT(*) FROM blog_posts");
                $total_records = $stmt_count->fetchColumn();
                $total_pages = ceil($total_records / $results_per_page);
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Manage Blog Posts</h3>
                        <div class="pull-right">
                            <a href="manage_blog_categories.php" class="btn btn-warning">Manage Categories</a>
                            <a href="manage_blogs.php?action=add" class="btn btn-primary">Add New Post</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT b.*, c.name as category_name FROM blog_posts b LEFT JOIN blog_categories c ON b.category_id = c.id ORDER BY b.created_at DESC LIMIT :offset, :limit");
                                    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                    $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                    $stmt->execute();
                                    while ($row = $stmt->fetch()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        if ($row['image']) {
                                            echo '<img src="../../assets/images/blog/' . $row['image'] . '" width="50">';
                                        }
                                        echo '</td>';
                                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['category_name'] ?? 'Uncategorized') . '</td>';
                                        echo '<td>' . htmlspecialchars($row['author']) . '</td>';
                                        echo '<td><span class="label label-' . ($row['status'] == 'published' ? 'success' : 'warning') . '">' . ucfirst($row['status']) . '</span></td>';
                                        echo '<td>
                                            <a href="manage_blogs.php?action=edit&id=' . $row['id'] . '" class="btn btn-info btn-sm">Edit</a>
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
            <?php elseif ($action == 'add' || $action == 'edit'): 
                $post = ['id' => '', 'title' => '', 'slug' => '', 'category_id' => '', 'author' => 'Admin', 'status' => 'published', 'content' => '', 'tags' => '', 'image' => '', 'video_url' => '', 'meta_title' => '', 'meta_description' => '', 'attachment' => ''];
                if ($action == 'edit' && isset($_GET['id'])) {
                    $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
                    $stmt->execute([$_GET['id']]);
                    $post = $stmt->fetch();
                }
            ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo ucfirst($action); ?> Blog Post</h3>
                        <a href="manage_blogs.php" class="btn btn-secondary pull-right">Back to List</a>
                    </div>
                    <div class="box-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $post['image']; ?>">
                            <input type="hidden" name="current_attachment" value="<?php echo $post['attachment']; ?>">
                            <input type="hidden" name="save_post" value="1">
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Slug (Optional, auto-generated)</label>
                                        <input type="text" name="slug" class="form-control" value="<?php echo htmlspecialchars($post['slug']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="content" class="form-control" id="editor" rows="10"><?php echo htmlspecialchars($post['content']); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                            <?php
                                            $cats = $pdo->query("SELECT * FROM blog_categories ORDER BY name ASC");
                                            while ($c = $cats->fetch()) {
                                                $selected = ($c['id'] == $post['category_id']) ? 'selected' : '';
                                                echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="published" <?php echo ($post['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                                            <option value="draft" <?php echo ($post['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Author</label>
                                        <input type="text" name="author" class="form-control" value="<?php echo htmlspecialchars($post['author']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Tags (comma separated)</label>
                                        <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($post['tags']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Featured Image (1200x650)</label>
                                        <input type="file" name="image" class="form-control">
                                        <?php if ($post['image']): ?>
                                            <div class="mt-2">
                                                <img src="../../assets/images/blog/<?php echo $post['image']; ?>" width="100">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Attachment (PDF/Doc)</label>
                                        <input type="file" name="attachment" class="form-control">
                                        <?php if ($post['attachment']): ?>
                                            <div class="mt-2">
                                                <a href="../../assets/files/blog/<?php echo $post['attachment']; ?>" target="_blank">View Current Attachment</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Video URL (YouTube/Vimeo)</label>
                                        <input type="text" name="video_url" class="form-control" value="<?php echo htmlspecialchars($post['video_url']); ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            <h4>SEO Metadata</h4>
                            <div class="form-group">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="<?php echo htmlspecialchars($post['meta_title']); ?>">
                            </div>
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2"><?php echo htmlspecialchars($post['meta_description']); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg">Save Post</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>

<!-- TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    if(document.getElementById('editor')) {
        tinymce.init({
            selector: '#editor',
            height: 400,
            plugins: 'image link lists media table code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code',
            images_upload_url: 'upload_image.php',
            automatic_uploads: true,
            file_picker_types: 'image',
            branding: false,
            promotion: false
        });
    }

    // Form Submission Safeguard (Spinner & Disable)
    document.addEventListener('DOMContentLoaded', function() {
        var forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                // If it's a delete form, we already have onsubmit="return confirm..." which runs first.
                // If confirmed, this runs.
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    var originalText = submitBtn.innerHTML;
                    // slight delay to ensure form submission starts
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