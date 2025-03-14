$(document).ready(function () {
        
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