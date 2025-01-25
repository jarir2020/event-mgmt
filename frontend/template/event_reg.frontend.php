<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Event Registration</h2>
    <form id="registrationForm">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea id="address" name="address" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" id="phone" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="event_id" class="form-label">Select Event</label>
            <select id="event_id" name="event_id" class="form-select" required>
                <option value="" disabled selected>Choose an event</option>
                <?php
                // Fetch events for the dropdown
                $stmt = $conn->prepare("SELECT EventID, EventName FROM events WHERE MaxCapacity > 0");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($event = $result->fetch_assoc()) {
                    echo "<option value='{$event['EventID']}'>{$event['EventName']}</option>";
                }
                $stmt->close();
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <div style="display: flex; gap: 3px; justify-content: center; align-items: center; margin-top: -25px;">
    <button class="btn btn-primary w-10"><a href="events.php" style="color:white; text-decoration:none;">Back to Event List</button>
    <button class="btn btn-primary w-10"><a href="index.php" style="color:white; text-decoration:none;">Back to Login</button>
</div>
</div>
<script>
document.getElementById('registrationForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    const response = await fetch('', { // Same file handles POST
        method: 'POST',
        body: formData
    });
    const result = await response.json();

    if (result.status === 'success') {
        alert(result.message);
        e.target.reset();
    } else {
        alert(result.message);
    }
});
</script>
</body>
</html>