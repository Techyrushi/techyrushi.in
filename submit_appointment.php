<?php
require_once 'includes/db.php';
require_once 'includes/email_helper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $topic = htmlspecialchars(trim($_POST['topic']));
    $date = htmlspecialchars(trim($_POST['date']));
    $time = htmlspecialchars(trim($_POST['time']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Google Recaptcha Verification
    $recaptcha_secret = 'YOUR_RECAPTCHA_SECRET_KEY';
    
    // Check if key is NOT the placeholder (i.e. we are in Production or have a key)
    if ($recaptcha_secret !== 'YOUR_RECAPTCHA_SECRET_KEY') {
        if (empty($_POST['g-recaptcha-response'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Please complete the Recaptcha.']);
            exit;
        }
        
        $recaptcha_response = $_POST['g-recaptcha-response'];
        $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}";
        $verify_response = file_get_contents($verify_url);
        $response_data = json_decode($verify_response);
        
        if (!$response_data->success) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Recaptcha verification failed. Please try again.']);
            exit;
        }
    }

    // Insert into Database
    try {
        $stmt = $pdo->prepare("INSERT INTO appointments (name, email, phone, topic, appointment_date, appointment_time, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$name, $email, $phone, $topic, $date, $time, $message]);

        // Fetch Admin Email
        $admin_email = 'crushikesh74@gmail.com';

        // 1. Send Email to Admin
        $admin_subject = "New Appointment Request: " . $topic;
        $admin_body_content = "
            <h2>New Appointment Request</h2>
            <p>You have received a new appointment request via the website.</p>
            <table>
                <tr><th>Name</th><td>$name</td></tr>
                <tr><th>Email</th><td><a href='mailto:$email'>$email</a></td></tr>
                <tr><th>Phone</th><td>$phone</td></tr>
                <tr><th>Topic</th><td>$topic</td></tr>
                <tr><th>Date</th><td>$date</td></tr>
                <tr><th>Time</th><td>$time</td></tr>
                <tr><th>Message</th><td>" . nl2br($message) . "</td></tr>
            </table>
            <p><a href='mailto:$email' class='btn'>Reply to User</a></p>
        ";
        // Send to Admin with User's email as Reply-To
        send_email($admin_email, $admin_subject, $admin_body_content, $email, $name);

        // 2. Send Email to User
        $user_subject = "Appointment Request Received - Techyrushi";
        $user_body_content = "
            <h2>Appointment Received</h2>
            <p>Hi <strong>$name</strong>,</p>
            <p>We have received your appointment request for <strong>$topic</strong>.</p>
            <table>
                <tr><th>Requested Date</th><td>$date</td></tr>
                <tr><th>Requested Time</th><td>$time</td></tr>
            </table>
            <p>Our team will review your request and send a confirmation email shortly.</p>
            <br>
            <p>Best Regards,<br><strong>Techyrushi Team</strong></p>
        ";
        // Send to User with Admin's email as Reply-To
        send_email($email, $user_subject, $user_body_content, $admin_email, 'Techyrushi Admin');

        echo json_encode(['status' => 'success', 'message' => 'Appointment request sent successfully!']);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
    } catch (Exception $e) {
        // Catch PHPMailer or other general exceptions
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Email Error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
