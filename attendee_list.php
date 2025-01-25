<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'includes/connection.php'; // Database connection

// Pagination variables
$eventsPerPage = 5; // Number of events per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $eventsPerPage;

// Download Attendee List in CSV
if (isset($_GET['action']) && $_GET['action'] === 'download' && isset($_GET['event_id'])) {
    $eventId = intval($_GET['event_id']);

    // Fetch Event and Attendee Data
    $stmt = $conn->prepare("SELECT r.Name, r.Email, r.Phone, r.Address FROM registrations r WHERE r.EventID = ?");
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="attendee_list.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Name', 'Email', 'Phone', 'Address']); // CSV Header
        
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    } else {
        echo "No attendees found for this event.";
    }
    $stmt->close();
}

// Fetch All Events for Host with pagination
$host = $_SESSION['username']; // Dynamically fetch the host's email from the session
$stmt = $conn->prepare("SELECT EventID, EventName FROM events WHERE HOST = ? LIMIT ?, ?");
$stmt->bind_param("sii", $host, $offset, $eventsPerPage);
$stmt->execute();
$events = $stmt->get_result();

// Get total number of events for pagination
$totalEventsStmt = $conn->prepare("SELECT COUNT(EventID) AS total FROM events WHERE HOST = ?");
$totalEventsStmt->bind_param("s", $host);
$totalEventsStmt->execute();
$totalResult = $totalEventsStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalEvents = $totalRow['total'];
$totalPages = ceil($totalEvents / $eventsPerPage);

// Frontend Display
require 'frontend/template/attendee_list.frontend.php';

?>