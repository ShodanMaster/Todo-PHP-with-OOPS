$(document).ready(function () {
       
    $('#tasksTable').DataTable({
        processing: true,  // Show processing indicator
        serverSide: true,  // Enable server-side processing
        ajax: {
            url: "actions/task.php",
            type: "GET"
        },
        columns: [
            { 
                data: null, 
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "title" },
            { data: "priority" },
            { data: "status"},
            { 
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-btn"  data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="${row.id}" data-title="${row.title}" data-priority="${row.priority}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ],
        pageLength: 5,  // Default page size
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]]
    });

    $(document).on('submit', '#task-form',function (e) {
        e.preventDefault();

        console.log('Inside');

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "actions/task.php?action=add",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if(response.status === 200){
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        button: "OK",
                    }).then(() => {
                        window.location.reload();
                    });
                } 
            }
        });
        
    });

    $('#addTaskModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset(); // Reset the form fields
    });

    $(document).on("click", ".edit-btn", function () {
        let taskId = $(this).data("id");
        let title = $(this).data("title");
        let priority = $(this).data("priority");
    
        console.log(taskId, title, priority);
        
        // Populate modal fields
        $("#edit-id").val(taskId);
        $("#edit-title").val(title);
        $("#edit-priority").val(priority);
    });

    $(document).on('submit', '#edit-form',function (e) {
        e.preventDefault();

        console.log('Inside');

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "actions/task.php?action=edit",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if(response.status === 200){
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        button: "OK",
                    }).then(() => {
                        window.location.reload();
                    });
                } 
            }
        });
        
    });
});