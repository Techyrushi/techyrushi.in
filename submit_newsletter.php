<?php
header('Content-Type: application/json');

require_once 'includes/db.php';
require_once 'includes/email_helper.php';

$response = ['status' => 'error', 'message' => 'Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $response['status'] = 'error';
                $response['message'] = 'You are already subscribed to our newsletter.';
            } else {
                // Insert into database
                $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
                $stmt->execute([$email]);

                // Send Confirmation Email to User
                $user_subject = "Welcome to Techyrushi Newsletter!";
                $user_body = "
                    <h2>Thank you for subscribing!</h2>
                    <p>You have successfully subscribed to the Techyrushi newsletter.</p>
                    <p>We will keep you updated with the latest technology trends, company news, and exclusive offers.</p>
                    <br>
                    <p>Stay tuned!</p>
                ";
                try {
                    send_email($email, $user_subject, $user_body);
                } catch (Exception $e) {
                    // Log error but don't fail the response
                }

                // Send Notification Email to Admin
                $admin_email = 'crushikesh74@gmail.com';
                $admin_subject = "New Newsletter Subscriber";
                $admin_body = "
                    <h2>New Subscriber Alert</h2>
                    <p><strong>Email:</strong> $email</p>
                    <p>Has subscribed to the newsletter.</p>
                ";
                try {
                    send_email($admin_email, $admin_subject, $admin_body, $email, 'Subscriber');
                } catch (Exception $e) {
                    // Log error
                }

                $response['status'] = 'success';
                $response['message'] = 'Thank you for subscribing!';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Please enter a valid email address.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>