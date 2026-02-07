<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$error = '';
$success = '';

// Handle GET Actions
if (isset($_GET['action']) && $_GET['action'] == 'delete_gallery_image' && isset($_GET['id'])) {
    $img_id = $_GET['id'];
    $project_id = $_GET['project_id'];

    // Get image path to delete file
    $stmt = $pdo->prepare("SELECT image_path FROM project_images WHERE id = ?");
    $stmt->execute([$img_id]);
    $img = $stmt->fetch();

    if ($img) {
        $file_path = "../../assets/images/project/gallery/" . $img['image_path'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        $stmt = $pdo->prepare("DELETE FROM project_images WHERE id = ?");
        $stmt->execute([$img_id]);

        // Redirect back to edit page
        header("Location: manage_projects.php?action=edit&id=" . $project_id);
        exit();
    }
}

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Project deleted successfully.";
    } elseif (isset($_POST['save_project'])) {
        $title = $_POST['title'];
        $slug = $_POST['slug'] ?: strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $industry = $_POST['industry'];
        $description = $_POST['description'];
        $client_name = $_POST['client_name'];
        $project_date = $_POST['project_date'];
        $project_link = $_POST['project_link'];
        $country = $_POST['country'];
        $core_technologies = $_POST['core_technologies'];
        $cost = $_POST['cost'];
        $id = $_POST['id'];

        // Handle Image Upload
        $image = $_POST['current_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            require_once 'includes/image_helper.php';
            $target_dir = "../../assets/images/project/";
            if (!is_dir($target_dir))
                mkdir($target_dir, 0777, true);

            $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $filename = time() . "_" . uniqid() . "." . $extension;
            $target_file = $target_dir . $filename;

            // Resize to 1200x650
            if (resizeImage($_FILES["image"]["tmp_name"], $target_file, 1200, 650)) {
                $image = $filename;
            } else {
                // Fallback
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image = $filename;
                }
            }
        }

        // Handle Brochure Upload
        $brochure = $_POST['current_brochure'];
        if (isset($_FILES['brochure']) && $_FILES['brochure']['error'] == 0) {
            $target_dir_bro = "../../assets/files/project/";
            if (!is_dir($target_dir_bro))
                mkdir($target_dir_bro, 0777, true);
            $filename_bro = time() . "_" . basename($_FILES["brochure"]["name"]);
            $target_file_bro = $target_dir_bro . $filename_bro;
            if (move_uploaded_file($_FILES["brochure"]["tmp_name"], $target_file_bro)) {
                $brochure = $filename_bro;
            }
        }

        if ($id) {
            // Update
            $sql = "UPDATE projects SET title=?, slug=?, industry=?, description=?, client_name=?, project_date=?, project_link=?, country=?, core_technologies=?, cost=?, image=?, brochure=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $slug, $industry, $description, $client_name, $project_date, $project_link, $country, $core_technologies, $cost, $image, $brochure, $id]);
            $success = "Project updated successfully.";
            $project_id = $id;
        } else {
            // Insert
            $sql = "INSERT INTO projects (title, slug, industry, description, client_name, project_date, project_link, country, core_technologies, cost, image, brochure) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$title, $slug, $industry, $description, $client_name, $project_date, $project_link, $country, $core_technologies, $cost, $image, $brochure]);
            $success = "Project added successfully.";
            $project_id = $pdo->lastInsertId();
        }

        // Handle Gallery Upload
        if (isset($_FILES['gallery_images'])) {
            require_once 'includes/image_helper.php';
            $total_files = count($_FILES['gallery_images']['name']);
            $target_dir_gallery = "../../assets/images/project/gallery/";
            if (!is_dir($target_dir_gallery))
                mkdir($target_dir_gallery, 0777, true);

            for ($i = 0; $i < $total_files; $i++) {
                if ($_FILES['gallery_images']['error'][$i] == 0) {
                    $extension = pathinfo($_FILES['gallery_images']['name'][$i], PATHINFO_EXTENSION);
                    $filename_gallery = time() . "_" . $i . "_" . uniqid() . "." . $extension;
                    $target_file_gallery = $target_dir_gallery . $filename_gallery;

                    // Resize to 1200x650 for consistency
                    $upload_success = false;
                    if (resizeImage($_FILES['gallery_images']['tmp_name'][$i], $target_file_gallery, 1200, 650)) {
                        $upload_success = true;
                    } elseif (move_uploaded_file($_FILES['gallery_images']['tmp_name'][$i], $target_file_gallery)) {
                        $upload_success = true;
                    }

                    if ($upload_success) {
                        $stmt_gal = $pdo->prepare("INSERT INTO project_images (project_id, image_path) VALUES (?, ?)");
                        $stmt_gal->execute([$project_id, $filename_gallery]);
                    }
                }
            }
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
                    $page = (int) $_GET['page'];
                } else {
                    $page = 1;
                }
                $offset = ($page - 1) * $results_per_page;

                // Count total records
                $stmt_count = $pdo->query("SELECT COUNT(*) FROM projects");
                $total_records = $stmt_count->fetchColumn();
                $total_pages = ceil($total_records / $results_per_page);
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Manage Projects</h3>
                        <a href="manage_projects.php?action=add" class="btn btn-primary pull-right">Add New Project</a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Industry</th>
                                        <th>Client</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT * FROM projects ORDER BY created_at DESC LIMIT :offset, :limit");
                                    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                                    $stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
                                    $stmt->execute();
                                    while ($row = $stmt->fetch()) {
                                        echo '<tr>';
                                        echo '<td>';
                                        if ($row['image']) {
                                            echo '<img src="../../assets/images/project/' . $row['image'] . '" width="50">';
                                        }
                                        echo '</td>';
                                        echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['industry']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['client_name']) . '</td>';
                                        echo '<td>
                                            <a href="manage_projects.php?action=edit&id=' . $row['id'] . '" class="btn btn-info btn-sm">Edit</a>
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
                                                <a class="page-link" href="?page=<?php echo ($page - 1); ?>&action=list"
                                                    aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                <a class="page-link"
                                                    href="?page=<?php echo $i; ?>&action=list"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $total_pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?php echo ($page + 1); ?>&action=list"
                                                    aria-label="Next">
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
                $project = ['id' => '', 'title' => '', 'slug' => '', 'industry' => '', 'description' => '', 'client_name' => '', 'project_date' => '', 'project_link' => '', 'country' => '', 'core_technologies' => '', 'cost' => '', 'image' => '', 'brochure' => ''];
                $gallery_images = [];
                if ($action == 'edit' && isset($_GET['id'])) {
                    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
                    $stmt->execute([$_GET['id']]);
                    $project = $stmt->fetch();

                    // Fetch Gallery Images
                    $stmt_gal = $pdo->prepare("SELECT * FROM project_images WHERE project_id = ?");
                    $stmt_gal->execute([$_GET['id']]);
                    $gallery_images = $stmt_gal->fetchAll();
                }
                ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo ucfirst($action); ?> Project</h3>
                        <a href="manage_projects.php" class="btn btn-secondary pull-right">Back to List</a>
                    </div>
                    <div class="box-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $project['image']; ?>">
                            <input type="hidden" name="current_brochure" value="<?php echo $project['brochure']; ?>">
                            <input type="hidden" name="save_project" value="1">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Project Title</label>
                                        <input type="text" name="title" class="form-control"
                                            value="<?php echo htmlspecialchars($project['title']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Slug (Optional)</label>
                                        <input type="text" name="slug" class="form-control"
                                            value="<?php echo htmlspecialchars($project['slug']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" id="editor"
                                            rows="10"><?php echo htmlspecialchars($project['description']); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Core Technologies</label>
                                        <input type="text" name="core_technologies" class="form-control"
                                            value="<?php echo htmlspecialchars($project['core_technologies']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Industry</label>
                                        <input type="text" name="industry" class="form-control"
                                            value="<?php echo htmlspecialchars($project['industry']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <input type="text" name="client_name" class="form-control"
                                            value="<?php echo htmlspecialchars($project['client_name']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Project Date</label>
                                        <input type="date" name="project_date" class="form-control"
                                            value="<?php echo htmlspecialchars($project['project_date']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Project Link</label>
                                        <input type="text" name="project_link" class="form-control"
                                            value="<?php echo htmlspecialchars($project['project_link']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="country" class="form-control"
                                            value="<?php echo htmlspecialchars($project['country']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Cost</label>
                                        <input type="text" name="cost" class="form-control"
                                            value="<?php echo htmlspecialchars($project['cost']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Main Image (800x800)</label>
                                        <input type="file" name="image" class="form-control">
                                        <?php if ($project['image']): ?>
                                            <div class="mt-2">
                                                <img src="../../assets/images/project/<?php echo $project['image']; ?>"
                                                    width="100">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Brochure (PDF)</label>
                                        <input type="file" name="brochure" class="form-control">
                                        <?php if ($project['brochure']): ?>
                                            <div class="mt-2">
                                                <a href="../../assets/files/project/<?php echo $project['brochure']; ?>"
                                                    target="_blank">View Brochure</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Gallery Images (Multiple)</label>
                                        <input type="file" name="gallery_images[]" class="form-control" multiple>
                                        <?php if (!empty($gallery_images)): ?>
                                            <div class="mt-2 row">
                                                <?php foreach ($gallery_images as $img): ?>
                                                    <div class="col-md-4 mb-2">
                                                        <img src="../../assets/images/project/gallery/<?php echo $img['image_path']; ?>"
                                                            class="img-fluid">
                                                        <a href="manage_projects.php?action=delete_gallery_image&id=<?php echo $img['id']; ?>&project_id=<?php echo $project['id']; ?>"
                                                            class="text-danger"
                                                            onclick="return confirm('Delete this image?')">Remove</a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg">Save Project</button>
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
    if (document.getElementById('editor')) {
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
    document.addEventListener('DOMContentLoaded', function () {
        var forms = document.querySelectorAll('form');
        forms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                var submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    var originalText = submitBtn.innerHTML;
                    setTimeout(function () {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
                    }, 10);
                }
            });
        });
    });
</script>
<?php require_once 'includes/footer.php'; ?>