$(function () {
    "use strict";

    // Load tasks on page load
    loadTasks();

    // Initialize Sortable for Drag and Drop
    $(".todo-list").sortable({
        connectWith: ".todo-list",
        placeholder: "sort-highlight",
        handle: ".handle",
        forcePlaceholderSize: true,
        zIndex: 999999,
        update: function (event, ui) {
            // Only trigger on the receiver to avoid double events
            if (this === ui.item.parent()[0]) {
                var taskId = ui.item.data('id');
                var newStatus = $(this).data('status');
                
                updateTaskStatus(taskId, newStatus);
            }
        }
    }).disableSelection();

    // Handle Save Task
    $('#save-task-btn').on('click', function() {
        var formData = getFormData('#add-task-form');
        
        if (!formData.title) {
            alert('Please enter a task title');
            return;
        }

        // Format dates for MySQL
        if (formData.due_date) formData.due_date = formData.due_date.replace('T', ' ') + ':00';
        if (formData.start_date) formData.start_date = formData.start_date.replace('T', ' ') + ':00';
        if (formData.end_date) formData.end_date = formData.end_date.replace('T', ' ') + ':00';

        $.ajax({
            url: 'api/tasks.php',
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                $('#add-task-modal').modal('hide');
                $('#add-task-form')[0].reset();
                loadTasks();
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error saving task');
            }
        });
    });

    // Handle Update Task
    $('#update-task-btn').on('click', function() {
        var formData = getFormData('#edit-task-form');
        
        if (!formData.title) {
            alert('Please enter a task title');
            return;
        }

        // Format dates for MySQL
        if (formData.due_date) formData.due_date = formData.due_date.replace('T', ' ') + ':00';
        if (formData.start_date) formData.start_date = formData.start_date.replace('T', ' ') + ':00';
        if (formData.end_date) formData.end_date = formData.end_date.replace('T', ' ') + ':00';

        $.ajax({
            url: 'api/tasks.php',
            type: 'PUT',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                $('#edit-task-modal').modal('hide');
                loadTasks();
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Error updating task');
            }
        });
    });
});

// Helper to get form data as object
function getFormData(formSelector) {
    var data = {};
    $(formSelector).serializeArray().map(function(x) { data[x.name] = x.value; });
    return data;
}

var currentTasks = [];

function loadTasks() {
    $.ajax({
        url: 'api/tasks.php',
        type: 'GET',
        dataType: 'json',
        success: function(tasks) {
            currentTasks = tasks; // Store for edit access
            
            // Clear lists
            $('#todo-list').empty();
            $('#inprogress-list').empty();
            $('#done-list').empty();

            if (tasks.length === 0) {
                // Optional: show empty state
                return;
            }

            tasks.forEach(function(task) {
                var badgeClass = 'bg-warning';
                if (task.status === 'in_progress') badgeClass = 'bg-primary';
                if (task.status === 'done') badgeClass = 'bg-success';
                
                // Map DB status to list ID
                var listId = '#todo-list';
                if (task.status === 'in_progress') listId = '#inprogress-list';
                if (task.status === 'done') listId = '#done-list';
                
                var html = `
                    <li data-id="${task.id}" class="${task.status === 'done' ? 'done' : ''}">
                        <span class="handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                        </span>
                        <span class="text">${task.title}</span>
                        ${task.due_date ? `<small class="badge bg-secondary"><i class="fa fa-calendar"></i> ${task.due_date}</small>` : ''}
                        <div class="tools">
                            <i class="fa fa-edit edit-task-btn"></i>
                            <i class="fa fa-trash-o delete-task-btn"></i>
                        </div>
                    </li>
                `;
                $(listId).append(html);
            });

            bindTaskEvents();
        },
        error: function(xhr, status, error) {
            console.error(error);
            alert('Error loading tasks');
        }
    });
}

function updateTaskStatus(taskId, newStatus) {
    var task = currentTasks.find(t => t.id == taskId);
    if(task) {
         $.ajax({
            url: 'api/tasks.php',
            type: 'PUT',
            data: JSON.stringify({
                id: task.id,
                title: task.title,
                description: task.description,
                due_date: task.due_date,
                status: newStatus
            }),
            contentType: 'application/json',
            success: function() {
                task.status = newStatus;
                // No need to reloadTasks() here as drag-and-drop handles UI
            },
            error: function() {
                alert('Error updating task status');
                loadTasks(); // Revert UI
            }
        });
    }
}

function bindTaskEvents() {
    // Delete Task
    $('.delete-task-btn').off('click').on('click', function() {
        if (!confirm('Are you sure you want to delete this task?')) return;
        
        var taskId = $(this).closest('li').data('id');
        
        $.ajax({
            url: 'api/tasks.php',
            type: 'DELETE',
            data: JSON.stringify({ id: taskId }),
            contentType: 'application/json',
            success: function() {
                loadTasks();
            },
            error: function() {
                alert('Error deleting task');
            }
        });
    });

    // Edit Task - Open Modal
    $('.edit-task-btn').off('click').on('click', function() {
        var taskId = $(this).closest('li').data('id');
        var task = currentTasks.find(t => t.id == taskId);
        
        if (task) {
            var form = $('#edit-task-form');
            form.find('[name="id"]').val(task.id);
            form.find('[name="title"]').val(task.title);
            form.find('[name="description"]').val(task.description);
            // Format date for input type=datetime-local
            if(task.due_date) {
                var dt = task.due_date.replace(' ', 'T').substring(0, 16);
                form.find('[name="due_date"]').val(dt);
            } else {
                 form.find('[name="due_date"]').val('');
            }
            
            if(task.start_date) {
                var dt = task.start_date.replace(' ', 'T').substring(0, 16);
                form.find('[name="start_date"]').val(dt);
            } else {
                 form.find('[name="start_date"]').val('');
            }

            if(task.end_date) {
                var dt = task.end_date.replace(' ', 'T').substring(0, 16);
                form.find('[name="end_date"]').val(dt);
            } else {
                 form.find('[name="end_date"]').val('');
            }

            form.find('[name="status"]').val(task.status);
            
            $('#edit-task-modal').modal('show');
        }
    });
}
