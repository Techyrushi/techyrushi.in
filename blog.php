<?php 
// Include DB first to handle logic before output if needed, 
// but we need header for structure.
// Use include_once to prevent redeclaration if header also includes it.
include_once 'includes/db.php';

// Initialize variables to prevent undefined variable errors
$where = "WHERE status='published'";
$params = [];
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$total_posts = 0;
$total_pages = 0;
$posts = [];
$error_msg = "";

try {
    // Filter Logic
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $where .= " AND title LIKE ?";
        $params[] = "%" . $_GET['search'] . "%";
    }

    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $where .= " AND category_id = ?";
        $params[] = $_GET['category'];
    }

    // Count Total
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM blog_posts $where");
    $stmt_count->execute($params);
    $total_posts = $stmt_count->fetchColumn();
    $total_pages = ceil($total_posts / $limit);

    // Fetch Posts
    $sql = "SELECT b.*, c.name as category_name 
            FROM blog_posts b 
            LEFT JOIN blog_categories c ON b.category_id = c.id 
            $where 
            ORDER BY b.created_at DESC 
            LIMIT $limit OFFSET $offset";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $posts = $stmt->fetchAll(); // Fetch all now to avoid issues later

} catch (Exception $e) {
    $error_msg = "Error loading posts: " . $e->getMessage();
}

// AJAX Request Handler
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    include 'includes/blog_posts_loop.php';
    exit;
}

include 'includes/header.php'; 
?>

<!--======== Blog Standard Page Banner Start ========-->
<section class="rs-page-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="rs-page-banner__content">
                    <h1 class="title">Blog Standard</h1>
                    <ul>
                        <li><i class="ri-home-wifi-line"></i> <a href="index.php">Home</a></li>
                        <li><i class="ri-arrow-right-fill"></i> Blog Standard</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--======== Blog Standard Page Banner Ends ========-->

<!--======== Blog Standard Page Start ========-->
<section class="rs-blog-standard-page pt-80 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="rs-blog-standard-page__box mt-40">
                    <!-- Search Box -->
                    <!-- <div class="search-box mb-40">
                        <input type="text" id="blog-search-input" class="form-control" placeholder="Search blogs..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    </div> -->

                    <?php if (!empty($error_msg)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error_msg); ?></div>
                    <?php endif; ?>

                    <div id="blog-posts-container">
                        <?php include 'includes/blog_posts_loop.php'; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($total_pages > 1): ?>
                    <div class="rs-shop-page__breadcrumb">
                        <ul>
                            <?php if ($page > 1): ?>
                                <li><a href="?page=<?php echo $page - 1; ?>"><i class="ri-arrow-left-fill"></i></a></li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li><a class="<?php echo ($i == $page) ? 'active' : ''; ?>" href="?page=<?php echo $i; ?>"><span><?php echo $i; ?></span></a></li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $total_pages): ?>
                                <li><a href="?page=<?php echo $page + 1; ?>"><i class="ri-arrow-right-fill"></i></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <?php include 'includes/frontend_sidebar.php'; ?>
            </div>
        </div>
    </div>
</section>
<!--======== Blog Standard Page Ends ========-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    var timer;
    $('#blog-search-input').on('keyup', function() {
        var query = $(this).val();
        clearTimeout(timer);
        timer = setTimeout(function() {
            $.ajax({
                url: 'blog.php',
                type: 'GET',
                data: {
                    search: query,
                    ajax: 1
                },
                success: function(response) {
                    $('#blog-posts-container').html(response);
                    // Update URL without reload
                    var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=' + encodeURIComponent(query);
                    window.history.pushState({path: newUrl}, '', newUrl);
                }
            });
        }, 500); // 500ms delay for debounce
    });
});
</script>

<?php include 'includes/footer.php'; ?>