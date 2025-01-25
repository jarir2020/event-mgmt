<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'includes/connection.php'; // Database connection

$host = $_SESSION['username'];

// Handle Create Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $eventName = trim($_POST['event_name'] ?? '');
    $eventDescription = trim($_POST['event_description'] ?? '');
    $eventTime = trim($_POST['event_time'] ?? '');
    $maxCapacity = intval($_POST['max_capacity'] ?? 0);

    if (empty($eventName) || empty($eventDescription) || empty($eventTime)) {
        $message = "All fields are required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO events (HOST, EventName, EventDescription, EventTime, MaxCapacity) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $host, $eventName, $eventDescription, $eventTime, $maxCapacity);

        if ($stmt->execute()) {
            $message = "Event created successfully.";
        } else {
            $message = "Failed to create event: " . $stmt->error;
        }
        $stmt->close();
    }
}



// Handle Update Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $eventId = $_POST['event_id'];
    $eventName = trim($_POST['event_name'] ?? '');
    $eventDescription = trim($_POST['event_description'] ?? '');
    $eventTime = trim($_POST['event_time'] ?? '');
    $maxCapacity = intval($_POST['max_capacity'] ?? 0);

    $stmt = $conn->prepare("SELECT EventName, EventDescription, EventTime, MaxCapacity FROM events WHERE EventID = ? AND HOST = ?");
    $stmt->bind_param("is", $eventId, $host);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $existingEvent = $result->fetch_assoc();
        $eventName = !empty($eventName) ? $eventName : $existingEvent['EventName'];
        $eventDescription = !empty($eventDescription) ? $eventDescription : $existingEvent['EventDescription'];
        $eventTime = !empty($eventTime) ? $eventTime : $existingEvent['EventTime'];
        $maxCapacity = $maxCapacity > 0 ? $maxCapacity : $existingEvent['MaxCapacity'];

        $stmt->close();

        $stmt = $conn->prepare("UPDATE events SET EventName = ?, EventDescription = ?, EventTime = ?, MaxCapacity = ? WHERE EventID = ? AND HOST = ?");
        $stmt->bind_param("sssisi", $eventName, $eventDescription, $eventTime, $maxCapacity, $eventId, $host);

        if ($stmt->execute()) {
            $message = "Event updated successfully.";
        } else {
            $message = "Failed to update event: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Event not found.";
        $stmt->close();
    }
}



// Handle Delete Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $eventId = $_POST['event_id'];

    $stmt = $conn->prepare("DELETE FROM events WHERE EventID = ? AND HOST = ?");
    $stmt->bind_param("is", $eventId, $host);

    if ($stmt->execute()) {
        $message = "Event deleted successfully.";
    } else {
        $message = "Failed to delete event: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch Events
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$itemsPerPage = 5;
$offset = ($currentPage - 1) * $itemsPerPage;

// Whitelist allowed columns for sorting to prevent SQL injection
$allowedSortColumns = ['EventName', 'EventDescription', 'EventTime'];
$sortBy = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $allowedSortColumns) ? $_GET['sort_by'] : 'EventName';

// Validate sort order
$sortOrder = (isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc') ? 'DESC' : 'ASC';

// Sanitize filter input
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';

// Query to fetch events with filtering, sorting, and pagination
$stmt = $conn->prepare("
    SELECT * FROM events
    WHERE HOST = ? AND EventName LIKE ?
    ORDER BY $sortBy $sortOrder
    LIMIT ? OFFSET ?
");
$searchTerm = '%' . $filter . '%';
$stmt->bind_param("ssii", $host, $searchTerm, $itemsPerPage, $offset);
$stmt->execute();
$events = $stmt->get_result();
$stmt->close();

// Query to get the total number of events (for pagination)
$countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM events WHERE HOST = ? AND EventName LIKE ?");
$countStmt->bind_param("ss", $host, $searchTerm);
$countStmt->execute();
$totalEvents = $countStmt->get_result()->fetch_assoc()['total'];
$countStmt->close();

$totalPages = ceil($totalEvents / $itemsPerPage);

$conn->close();


require 'frontend/template/dashboard.frontend.php';

?>