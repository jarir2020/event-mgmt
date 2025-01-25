<?php
// Include your database connection
require 'includes/connection.php';

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    // Fetch all events from the database
    $stmt = $conn->prepare("SELECT * FROM events");
    $stmt->execute();
    $result = $stmt->get_result();

    $events = [];
    while ($event = $result->fetch_assoc()) {
        $events[] = [
            'EventID' => $event['EventID'],
            'EventName' => $event['EventName'],
            'EventDescription' => $event['EventDescription'],
            'EventTime' => $event['EventTime'],
            'Host' => $event['HOST']
        ];
    }

    if (!empty($events)) {
        // Events found, set HTTP response code 200 OK
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $events
        ], JSON_PRETTY_PRINT);
    } else {
        // No events found, set HTTP response code 204 No Content
        http_response_code(204);
        echo json_encode([
            'status' => 'no content',
            'message' => 'No events found.'
        ], JSON_PRETTY_PRINT);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    // Handle exceptions with HTTP response code 500 Internal Server Error
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()], JSON_PRETTY_PRINT);
}
?>
