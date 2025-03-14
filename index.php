<?php
include("app/header.php");
?>

<!-- Add Task -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h1 class="modal-title fs-5" id="addTaskModalLabel">Add Task</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="task-form">
        <div class="modal-body">
            <div class="form-group">
                <input type="text" class="form-control" name="title" id="title" placeholder="Title" required>
            </div>

            <div class="form-group">
                <select class="form-control  mt-3" name="priority" id="priority" required>
                    <option value="" disabled selected>--select priority--</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>
            

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="d-flex justify-content-between">
    <h1>Hello <?php echo $_SESSION['username'] ?></h1>
    
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        Add Task
    </button>

</div>


<?php
include("app/footer.php");
?>