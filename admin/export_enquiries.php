<?php
/**
 * Zenvora Global Solutions - Admin Panel Enquiries Export Script
 * Generates a clean Excel-compatible CSV file with UTF-8 BOM encoding.
 */
session_start();
require_once __DIR__ . '/../components/db_connect.php';

// Auth Guard
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("HTTP/1.1 403 Forbidden");
    echo "Unauthorized access.";
    exit;
}

if ($pdo === null) {
    die("Database connection failed.");
}

// Read Filter parameters
$status = trim($_GET['status'] ?? '');
$service = trim($_GET['service'] ?? '');
$search = trim($_GET['search'] ?? '');
$startDate = trim($_GET['start_date'] ?? '');
$endDate = trim($_GET['end_date'] ?? '');

// Build query
$query = "SELECT * FROM enquiries WHERE 1=1";
$params = [];

if ($status !== '') {
    $query .= " AND status = :status";
    $params[':status'] = $status;
}

if ($service !== '') {
    $query .= " AND service LIKE :service";
    $params[':service'] = '%' . $service . '%';
}

if ($startDate !== '') {
    $query .= " AND DATE(created_at) >= :start_date";
    $params[':start_date'] = $startDate;
}

if ($endDate !== '') {
    $query .= " AND DATE(created_at) <= :end_date";
    $params[':end_date'] = $endDate;
}

if ($search !== '') {
    $query .= " AND (name LIKE :search1 OR email LIKE :search2 OR phone LIKE :search3 OR message LIKE :search4)";
    $params[':search1'] = '%' . $search . '%';
    $params[':search2'] = '%' . $search . '%';
    $params[':search3'] = '%' . $search . '%';
    $params[':search4'] = '%' . $search . '%';
}

$query .= " ORDER BY created_at DESC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error exporting data: " . $e->getMessage());
}

// Generate CSV File Name with timestamp
$filename = "Zenvora_Enquiries_Export_" . date("Y-m-d_H-i") . ".csv";

// Output headers for file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '";');
header('Pragma: no-cache');
header('Expires: 0');

// Create stream resource
$output = fopen('php://output', 'w');

// Write UTF-8 BOM to force Excel to open in UTF-8 mode
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Write CSV header columns
fputcsv($output, [
    'Enquiry ID',
    'Customer Name',
    'Customer Email',
    'Phone Number',
    'Service Category / Origin',
    'Organization Size',
    'Target Launch Timeline',
    'Filing Status',
    'Requirements Description',
    'Submission Timestamp'
]);

// Write CSV rows data
foreach ($rows as $row) {
    fputcsv($output, [
        $row['id'],
        $row['name'],
        $row['email'],
        $row['phone'],
        $row['service'],
        $row['org_size'],
        $row['timeline'],
        $row['status'],
        $row['message'] ?: 'N/A',
        $row['created_at']
    ]);
}

// Close output stream
fclose($output);
exit;
