<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .message {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: green;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 9999;
        }
    </style>
</head>
<body>
<div class="container my-5">
    
    <div style="display:flex; gap: 500px">
    <h1>Welcome, <?php echo htmlspecialchars($host); ?>!</h1>
    <a href="logout.php" class="btn btn-danger mb-4" style="margin-top:15px;">Logout</a>
    </div>

    <!-- Flash Message -->
    <?php if (isset($message)): ?>
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.message').remove();
            }, 3000);
        </script>
    <?php endif; ?>

    <!-- Create Event Form -->
<!-- Button to Trigger Modal -->
<div style="display: flex; gap: 3px; justify-content: center; align-items: center; margin-top: -25px;">
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
    Create Event
</button>
<!-- Button to Download Attendee List -->
<button type="button" class="btn btn-primary"><a href="attendee_list.php" style="color:white; text-decoration:none;">Download Attendee List</a></button>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Create Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="create">
                    <div class="mb-3">
                        <label for="event_name" class="form-label">Event Name</label>
                        <input type="text" id="event_name" name="event_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="event_description" class="form-label">Event Description</label>
                        <textarea id="event_description" name="event_description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="event_time" class="form-label">Event Time</label>
                        <input type="datetime-local" id="event_time" name="event_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="max_capacity" class="form-label">Max Capacity</label>
                        <input type="number" id="max_capacity" name="max_capacity" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </div>
                
            </form>
        </div>
    </div>
</div>

<!-- Spacing Between Two Features-->
<div style="margin-bottom:10px"></div>

<!-- Filter and Sort Form -->
<form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="filter" value="<?php echo htmlspecialchars($filter); ?>" class="form-control" placeholder="Search by Event Name">
        </div>
        <div class="col-md-4">
            <select name="sort_by" class="form-select">
                <option value="EventName" <?php echo $sortBy === 'EventName' ? 'selected' : ''; ?>>Sort by Name</option>
                <option value="EventTime" <?php echo $sortBy === 'EventTime' ? 'selected' : ''; ?>>Sort by Time</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="sort_order" class="form-select">
                <option value="asc" <?php echo $sortOrder === 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                <option value="desc" <?php echo $sortOrder === 'DESC' ? 'selected' : ''; ?>>Descending</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Apply</button>
        </div>
    </div>
</form>
    <!-- Display Events -->
    <h2>Your Events</h2>
  
    <!-- Event Table -->
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Event Name</th>
            <th>Description</th>
            <th>Time</th>
            <th>Max Capacity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($events->num_rows > 0): ?>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['EventName']); ?></td>
                    <td><?php echo htmlspecialchars($event['EventDescription']); ?></td>
                    <td><?php echo htmlspecialchars(date('d-m-Y H:i', strtotime($event['EventTime']))); ?></td>
                    <td><?php echo htmlspecialchars($event['MaxCapacity']); ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $event['EventID']; ?>">Edit</button>
                        
<!-- Delete Button with Confirmation Modal -->
<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal_<?php echo $event['EventID']; ?>">Delete</button>

<!-- Modal for Deleting -->
    <div class="modal fade" id="deleteModal_<?php echo $event['EventID']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel_<?php echo $event['EventID']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel_<?php echo $event['EventID']; ?>">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the event "<strong><?php echo htmlspecialchars($event['EventName']); ?></strong>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="event_id" value="<?php echo $event['EventID']; ?>">
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

                    </td>
                </tr>

                <!-- Modal for Editing -->
                <div class="modal fade" id="editModal_<?php echo $event['EventID']; ?>" tabindex="-1" aria-labelledby="editModalLabel_<?php echo $event['EventID']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel_<?php echo $event['EventID']; ?>">Edit Event</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="event_id" value="<?php echo $event['EventID']; ?>">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="event_name_<?php echo $event['EventID']; ?>" class="form-label">Event Name</label>
                                        <input type="text" id="event_name_<?php echo $event['EventID']; ?>" name="event_name" value="<?php echo htmlspecialchars($event['EventName']); ?>" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="event_description_<?php echo $event['EventID']; ?>" class="form-label">Event Description</label>
                                        <textarea id="event_description_<?php echo $event['EventID']; ?>" name="event_description" class="form-control" required><?php echo htmlspecialchars($event['EventDescription']); ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="event_time_<?php echo $event['EventID']; ?>" class="form-label">Event Time</label>
                                        <input type="datetime-local" id="event_time_<?php echo $event['EventID']; ?>" name="event_time" value="<?php echo date('Y-m-d\TH:i', strtotime($event['EventTime'])); ?>" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="max_capacity_<?php echo $event['EventID']; ?>" class="form-label">Max Capacity</label>
                                        <input type="number" id="max_capacity_<?php echo $event['EventID']; ?>" name="max_capacity" value="<?php echo htmlspecialchars($event['MaxCapacity']); ?>" class="form-control" required>
                                   </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">No events found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Pagination Links -->
<nav>
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>&sort_by=<?php echo $sortBy; ?>&sort_order=<?php echo $sortOrder; ?>&filter=<?php echo urlencode($filter); ?>">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
