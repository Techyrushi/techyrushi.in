<?php
require_once 'includes/db.php';
require_once 'includes/email_helper.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
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
    // Else: Key is placeholder -> Dev mode -> Allow bypass

    // Insert into Database
    try {
        $stmt = $pdo->prepare("INSERT INTO contact_enquiries (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $subject, $message]);
        
        // Fetch Admin Email
        $admin_email = 'crushikesh74@gmail.com';
        
        // 1. Send Email to Admin
        $admin_email_subject = "New Enquiry: " . $subject;
        $admin_body_content = "
            <h2>New Enquiry Received</h2>
            <p>You have received a new enquiry from the website contact form.</p>
            <table>
                <tr><th>Name</th><td>$name</td></tr>
                <tr><th>Email</th><td><a href='mailto:$email'>$email</a></td></tr>
                <tr><th>Phone</th><td>$phone</td></tr>
                <tr><th>Subject</th><td>$subject</td></tr>
                <tr><th>Message</th><td>" . nl2br($message) . "</td></tr>
            </table>
            <p><a href='mailto:$email' class='btn'>Reply to User</a></p>
        ";
        // Send to Admin with User's email as Reply-To
        send_email($admin_email, $admin_email_subject, $admin_body_content, $email, $name);

        // 2. Send Email to User (Acknowledgement)
        $user_email_subject = "Thank you for contacting Techyrushi";
        $user_body_content = "
            <h2>Thank you for reaching out!</h2>
            <p>Hi <strong>$name</strong>,</p>
            <p>We have received your enquiry regarding '<strong>$subject</strong>'. Our team will review your message and get back to you as soon as possible.</p>
            <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
            <p><strong>Your Message:</strong></p>
            <p style='font-style: italic; color: #666;'>" . nl2br($message) . "</p>
            <br>
            <p>Best Regards,<br><strong>Techyrushi Team</strong></p>
        ";
        // Send to User with Admin's email as Reply-To
        send_email($email, $user_email_subject, $user_body_content, $admin_email, 'Techyrushi Admin');
        
        // Success Response
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);

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
