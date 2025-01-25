<?php
// Database connection
require 'includes/connection.php';

// Handle registration submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $eventId = intval($_POST['event_id'] ?? 0);

    // Validate fields
    if (empty($name) || empty($email) || empty($address) || empty($phone) || $eventId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    try {
        // Check event capacity
        $stmt = $conn->prepare("
            SELECT COUNT(r.RegistrationID) AS TotalRegistrations, e.MaxCapacity 
            FROM registrations r 
            RIGHT JOIN events e ON r.EventID = e.EventID 
            WHERE e.EventID = ?
        ");
        $stmt->bind_param('i', $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $eventData = $result->fetch_assoc();
        $stmt->close();

        if ($eventData['TotalRegistrations'] >= $eventData['MaxCapacity']) {
            echo json_encode(['status' => 'error', 'message' => 'Registration limit reached for this event.']);
            exit;
        }

        // Insert registration data
        $stmt = $conn->prepare("INSERT INTO registrations (Name, Email, Address, Phone, EventID) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssi', $name, $email, $address, $phone, $eventId);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to register: ' . $stmt->error]);
        }
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
    exit;
}

require 'frontend/template/event_reg.frontend.php';
?>


