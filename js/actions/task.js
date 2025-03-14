$(document).ready(function () {
       
    $('#tasksTable').DataTable({
        processing: true,  // Show processing indicator
        serverSide: true,  // Enable server-side processing
        ajax: {
            url: "actions/task.php",
            type: "GET"
        },
        columns: [
            { data: "id" },
            { data: "title" },
            { data: "priority" }
        ],
        pageLength: 5,  // Default page size
        lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]]
    });

    // $.ajax({
    //     type: "GET",
    //     url: "actions/task.php",
    //     success: function (response) {
            
    //         if (response.status === 200) {
    //             let table = $('#tasksTable').DataTable({
    //                 destroy: true, // Ensures table resets on reload
    //                 data: response.data,
    //                 columns: [
    //                     { data: "id" },
    //                     { data: "title" },
    //                     { data: "priority" }
    //                 ],
    //                 pageLength: 5,
    //                 lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "All"]],
    //             });
    //         } else {
    //             console.error("No tasks found.");
    //         }
    //     },
    //     error: function () {
    //         console.error("Error loading tasks.");
    //     }
    // });

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
});