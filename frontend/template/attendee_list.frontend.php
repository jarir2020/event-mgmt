<!DOCTYPE html>
<html>
<head>
    <title>Event Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <center><h3>Download Attendee List</h3></center>
    <div class="mt-3" style="justify-content: center; align-items: center; display: flex; gap: 10px; margin-bottom: 5px;">
        <a href="logout.php" class="btn btn-danger">Logout</a>
        <a href="dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if any events exist
                if ($events->num_rows > 0) {
                    while ($event = $events->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($event['EventName']) . "</td>
                                <td><a href='?action=download&event_id=" . $event['EventID'] . "' class='btn btn-primary'>Download CSV</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No events found for this host.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="?page=1">First</a></li>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="?page=<?= $totalPages ?>">Last</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>