<?php
/**
 * Zenvora Global Solutions - Fetch Pending Leads AJAX Endpoint
 */
session_start();
require_once __DIR__ . '/../components/db_connect.php';

header('Content-Type: application/json');

// Session verification
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if ($pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT id, name, service, created_at FROM enquiries WHERE status = 'Pending' ORDER BY created_at DESC LIMIT 5");
        $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format dates
        foreach ($leads as &$lead) {
            $lead['time_ago'] = date('d M H:i', strtotime($lead['created_at']));
        }
        
        echo json_encode([
            'success' => true,
            'leads' => $leads,
            'count' => count($leads)
        ]);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Query failed']);
    }
} else {
    echo json_encode(['error' => 'Database offline']);
}
?>
