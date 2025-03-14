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

<!-- Edit Task -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editTaskModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="edit-form">
        <input type="hidden" id="edit-id" name="id">
        <div class="modal-body">
            <div class="form-group">
                <input type="text" class="form-control" name="title" id="edit-title" placeholder="Title" required>
            </div>

            <div class="form-group">
                <select class="form-control  mt-3" name="priority" id="edit-priority" required>
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

<div class="d-flex justify-content-between mb-3">
    <h1>Hello <?php echo $_SESSION['username'] ?></h1>
    
    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        Add Task
    </button>
</div>

<div class="card shadow-lg">
    <div class="card-header bg-primary text-white text-center fs-4">
        Your Tasks
    </div>
    <div class="card-body">
        <table id="tasksTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <form action="actions/logout.php" method="post">
            <button class="btn btn-outline-danger" type="submit">Logout</button>
        </form>
    </div>
</div>

<?php
include("app/footer.php");
?>