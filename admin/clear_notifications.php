<?php
/**
 * Zenvora Global Solutions - Clear/Mark All Notifications Read Endpoint
 */
session_start();
require_once __DIR__ . '/../components/db_connect.php';

header('Content-Type: application/json');

// Session verification
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo !== null) {
    try {
        // Mark all Pending leads as "In Progress" to clear them from active notification flow
        $stmt = $pdo->prepare("UPDATE enquiries SET status = 'In Progress' WHERE status = 'Pending'");
        $stmt->execute();
        
        echo json_encode([
            'success' => true,
            'message' => 'All pending enquiries marked as active/in-progress'
        ]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Database update failed']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
