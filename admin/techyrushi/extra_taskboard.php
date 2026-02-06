<?php
include 'includes/header.php';
include 'includes/sidebar.php';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="me-auto">
                    <h4 class="page-title">Project Taskboard</h4>
                    <div class="d-inline-block align-items-center">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php"><i class="mdi mdi-home-outline"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Taskboard</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="text-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-task-modal">
                        <i class="ti-plus"></i> Add New Task
                    </button>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xl-4 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title">To Do</h4>
                        </div>
                        <div class="box-body p-0">
                            <ul class="todo-list" id="todo-list" data-status="todo" style="min-height: 200px;">
                                <!-- To Do Tasks -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title text-primary">In Progress</h4>
                        </div>
                        <div class="box-body p-0">
                            <ul class="todo-list" id="inprogress-list" data-status="in_progress" style="min-height: 200px;">
                                <!-- In Progress Tasks -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h4 class="box-title text-success">Done</h4>
                        </div>
                        <div class="box-body p-0">
                            <ul class="todo-list" id="done-list" data-status="done" style="min-height: 200px;">
                                <!-- Done Tasks -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
</div>
<!-- /.content-wrapper -->

<!-- Add Task Modal -->
<div class="modal fade" id="add-task-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Task</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="add-task-form">
                    <div class="form-group">
                        <label class="form-label">Task Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Start Date & Time</label>
                        <input type="datetime-local" class="form-control" name="start_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Date & Time</label>
                        <input type="datetime-local" class="form-control" name="end_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Due Date & Time</label>
                        <input type="datetime-local" class="form-control" name="due_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="todo">To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-task-btn">Save Task</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="edit-task-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Task</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-task-form">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label class="form-label">Task Title</label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Start Date & Time</label>
                        <input type="datetime-local" class="form-control" name="start_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Date & Time</label>
                        <input type="datetime-local" class="form-control" name="end_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Due Date</label>
                        <input type="datetime-local" class="form-control" name="due_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="todo">To Do</option>
                            <option value="in_progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="update-task-btn">Update Task</button>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
<script src="../assets/vendor_components/jquery-ui/jquery-ui.min.js"></script>
<script src="js/pages/extra_taskboard.js"></script>
