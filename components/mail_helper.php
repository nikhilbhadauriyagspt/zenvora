<?php
/**
 * Zenvora Global Solutions - SMTP Email Helper
 * Socket-based mail client for zero dependency SMTP email dispatch.
 */

require_once __DIR__ . '/db_connect.php';

/**
 * Socket-based SMTP mail client
 */
function send_smtp_email($to, $subject, $body_html) {
    global $pdo;
    
    // Fetch SMTP settings from DB
    $settings = [];
    if ($pdo !== null) {
        try {
            $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'smtp_%'");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // Check if SMTP is enabled
    if (($settings['smtp_enabled'] ?? '0') !== '1') {
        return false;
    }
    
    $host = $settings['smtp_host'] ?? '';
    $port = (int)($settings['smtp_port'] ?? 465);
    $secure = $settings['smtp_secure'] ?? 'ssl';
    $username = $settings['smtp_username'] ?? '';
    $password = $settings['smtp_password'] ?? '';
    $from = $username;
    
    if (empty($host) || empty($username) || empty($password)) {
        return false;
    }
    
    // Establish connection based on security type
    $socketHost = ($secure === 'ssl') ? "ssl://$host" : $host;
    
    // Open connection
    $socket = @fsockopen($socketHost, $port, $errno, $errstr, 15);
    if (!$socket) {
        return false;
    }
    
    // Stream response helper
    function smtp_read($socket) {
        $data = '';
        while ($str = fgets($socket, 515)) {
            $data .= $str;
            if (substr($str, 3, 1) === ' ') {
                break;
            }
        }
        return $data;
    }
    
    smtp_read($socket); // Read server greeting
    
    fwrite($socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
    smtp_read($socket);
    
    // Handle TLS upgrade
    if ($secure === 'tls') {
        fwrite($socket, "STARTTLS\r\n");
        $res = smtp_read($socket);
        if (strpos($res, '220') === false) {
            fclose($socket);
            return false;
        }
        if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            fclose($socket);
            return false;
        }
        fwrite($socket, "EHLO " . $_SERVER['SERVER_NAME'] . "\r\n");
        smtp_read($socket);
    }
    
    // Authenticate
    fwrite($socket, "AUTH LOGIN\r\n");
    smtp_read($socket);
    
    fwrite($socket, base64_encode($username) . "\r\n");
    smtp_read($socket);
    
    fwrite($socket, base64_encode($password) . "\r\n");
    $authRes = smtp_read($socket);
    if (strpos($authRes, '235') === false) {
        fclose($socket);
        return false;
    }
    
    // MAIL FROM
    fwrite($socket, "MAIL FROM: <$from>\r\n");
    smtp_read($socket);
    
    // RCPT TO
    fwrite($socket, "RCPT TO: <$to>\r\n");
    smtp_read($socket);
    
    // DATA
    fwrite($socket, "DATA\r\n");
    smtp_read($socket);
    
    // Headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "To: <$to>\r\n";
    $headers .= "From: Zenvora Mail Panel <$from>\r\n";
    $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
    $headers .= "Date: " . date('r') . "\r\n";
    
    fwrite($socket, $headers . "\r\n" . $body_html . "\r\n.\r\n");
    smtp_read($socket);
    
    // Quit
    fwrite($socket, "QUIT\r\n");
    fclose($socket);
    
    return true;
}

/**
 * Send lead notification to administrator
 */
function send_lead_notification($name, $phone, $email, $service, $org_size, $timeline, $message) {
    global $pdo;
    
    // Fetch receiver email setting
    $receiver = '';
    if ($pdo !== null) {
        try {
            $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'smtp_receiver_email' LIMIT 1");
            $stmt->execute();
            $receiver = $stmt->fetchColumn() ?: '';
        } catch (PDOException $e) {
            return false;
        }
    }
    
    if (empty($receiver)) {
        return false;
    }
    
    $subject = "New Lead Enquiry - " . $name;
    
    // Build beautiful HTML email template in Gold and Charcoal theme
    $body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>New Lead Notification</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #020617; color: #f1f5f9; margin: 0; padding: 20px; }
            .card { max-width: 600px; margin: 0 auto; background-color: #0f172a; border: 1px solid #1e293b; border-radius: 16px; overflow: hidden; }
            .header { background-color: #020617; padding: 24px; border-bottom: 2px solid #bc8731; text-align: center; }
            .logo { color: #ffffff; font-size: 20px; font-weight: bold; letter-spacing: 2px; }
            .logo-span { color: #bc8731; }
            .content { padding: 30px; }
            .lead-title { font-size: 18px; color: #ffffff; margin-bottom: 20px; border-bottom: 1px solid #1e293b; padding-bottom: 10px; }
            .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            .details-table td { padding: 10px 0; border-bottom: 1px solid #1e293b; font-size: 13px; }
            .label { color: #94a3b8; font-weight: bold; width: 35%; }
            .val { color: #f1f5f9; }
            .message-box { background-color: #020617; border-left: 3px solid #bc8731; padding: 15px; border-radius: 8px; font-style: italic; font-size: 13px; color: #cbd5e1; }
            .footer { background-color: #020617; padding: 20px; text-align: center; font-size: 10px; color: #475569; border-t: 1px solid #1e293b; }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="header">
                <div class="logo">ZENVORA <span class="logo-span">GLOBAL</span></div>
            </div>
            <div class="content">
                <div class="lead-title">New Customer Lead Capture</div>
                <table class="details-table">
                    <tr>
                        <td class="label">Customer Name</td>
                        <td class="val"><strong>' . htmlspecialchars($name) . '</strong></td>
                    </tr>
                    <tr>
                        <td class="label">Email Address</td>
                        <td class="val">' . htmlspecialchars($email) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Phone Number</td>
                        <td class="val">' . htmlspecialchars($phone) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Required Service</td>
                        <td class="val">' . htmlspecialchars($service) . '</td>
                    </tr>
                    <tr>
                        <td class="label">Organization Size</td>
                        <td class="val">' . htmlspecialchars($org_size) . ' employee(s)</td>
                    </tr>
                    <tr>
                        <td class="label font-bold">Filing Timeline</td>
                        <td class="val">' . htmlspecialchars($timeline) . '</td>
                    </tr>
                </table>
                <div class="label" style="margin-bottom: 8px;">Enquiry Message:</div>
                <div class="message-box">
                    "' . nl2br(htmlspecialchars($message)) . '"
                </div>
            </div>
            <div class="footer">
                This is an automated advisory desk notification triggered by Zenvora Web Portal.
            </div>
        </div>
    </body>
    </html>
    ';
    
    return send_smtp_email($receiver, $subject, $body);
}
?>
