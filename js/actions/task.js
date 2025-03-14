$(document).ready(function () {

    var table = $('#tasksTable').DataTable({
        processing: true,
        serverSide: true,
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
            { 
                data: null,
                render: function (data, type, row) {
                    let statusClass = row.status === "completed" ? "btn-success" : "btn-warning";
                    let statusText = row.status === "completed" ? "Completed" : "Pending";
                
                    return `
                        <button class="btn btn-sm ${statusClass} status-btn" value="${row.status}" data-id="${row.id}" data-status="${row.status}" title="Update Status">${statusText}</button>
                    `;
                }
            },
            { 
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info edit-btn"  data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="${row.id}" data-title="${row.title}" data-priority="${row.priority}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${row.id}">Delete</button>
                    `;
                }
            }
        ],
        pageLength: 5,
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]]
    });

    $(document).on('submit', '#task-form', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "actions/task.php?action=add",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.status === 200){
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK",
                    }).then(() => {
                        table.ajax.reload();
                        $('#addTaskModal').modal('hide');
                    });
                } 
            }
        });

    });

    $('#addTaskModal').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset();
    });

    $(document).on("click", ".edit-btn", function () {
        let taskId = $(this).data("id");
        let title = $(this).data("title");
        let priority = $(this).data("priority");

        $("#edit-id").val(taskId);
        $("#edit-title").val(title);
        $("#edit-priority").val(priority);
    });

    $(document).on('submit', '#edit-form', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "actions/task.php?action=edit",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if(response.status === 200){
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK",
                    }).then(() => {
                        table.draw();
                        $('#editTaskModal').modal('hide');
                    });
                }else if(response.status === 403){
                    Swal.fire({
                        title: "Warning!",
                        text: response.message,
                        icon: "warning",
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.reload();
                    });
                }else{
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                        confirmButtonText: "OK",
                    }).then(() => {
                        window.location.reload();
                    });
                }
            }
        });

    });

    $(document).on("click", ".delete-btn", function () {
        let taskId = $(this).data("id");
        // console.log(taskId);
        
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', taskId);

                $.ajax({
                    type: "POST",
                    url: "actions/task.php?action=delete",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        
                        Swal.fire("Deleted!", "Your task has been deleted.", "success");

                        // table.ajax.reload();
                        table.draw();
                    },
                    error: function () {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    }
                });
            }
        });
    });

    $(document).on("click", ".status-btn", function () {
        let taskId = $(this).data("id");
        let currentStatus = $(this).data("status");
        
        let newStatus = currentStatus === "completed" ? "pending" : "completed";
        // console.log(newStatus);
        
        Swal.fire({
            title: "Update Status?",
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, update it!"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();
                formData.append('id', taskId);
                formData.append('status', newStatus);

                $.ajax({
                    type: "POST",
                    url: "actions/task.php?action=status",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        
                        Swal.fire("Updated!", "Your status has been updated.", "success");

                        // table.ajax.reload();
                        table.draw();
                    },
                    error: function () {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    }
                });
            }
        });
    });

});
