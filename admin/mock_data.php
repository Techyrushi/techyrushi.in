<?php
require_once 'config.php';

try {
    // Mock Enquiries
    $enquiries = [
        ['John Doe', 'john@example.com', '1234567890', 'Pricing Question', 'Hello, how much for the premium plan?'],
        ['Jane Smith', 'jane@test.com', '0987654321', 'Support Needed', 'I cannot access my account.'],
        ['Mike Ross', 'mike@legal.com', '1122334455', 'Partnership', 'We would like to partner with you.'],
        ['Sarah Connor', 'sarah@skynet.com', '5551234567', 'Security', 'Is your system secure against terminators?'],
        ['Bruce Wayne', 'bruce@wayne.com', '9999999999', 'Investment', 'I want to invest in TechZen.']
    ];

    $stmt = $pdo->prepare("INSERT INTO contact_enquiries (name, email, phone, subject, message, is_read) VALUES (?, ?, ?, ?, ?, 0)");
    
    foreach ($enquiries as $enq) {
        // Check if exists to avoid duplicates on multiple runs (simple check by email/subject)
        $check = $pdo->prepare("SELECT id FROM contact_enquiries WHERE email = ? AND subject = ?");
        $check->execute([$enq[1], $enq[3]]);
        if ($check->rowCount() == 0) {
            $stmt->execute($enq);
        }
    }

    // Mock Appointments
    $appointments = [
        ['Alice Wonderland', 'alice@wonder.com', '1112223333', 'Consultation', date('Y-m-d', strtotime('+1 day')), '10:00', 'Need advice on rabbit holes.'],
        ['Bob Builder', 'bob@build.com', '4445556666', 'Project Planning', date('Y-m-d', strtotime('+2 days')), '14:00', 'Can we fix it?'],
        ['Charlie Brown', 'charlie@peanuts.com', '7778889999', 'Therapy Session', date('Y-m-d', strtotime('+3 days')), '11:00', 'Good grief.']
    ];

    $stmt = $pdo->prepare("INSERT INTO appointments (name, email, phone, topic, appointment_date, appointment_time, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");

    foreach ($appointments as $apt) {
        $check = $pdo->prepare("SELECT id FROM appointments WHERE email = ? AND topic = ?");
        $check->execute([$apt[1], $apt[3]]);
        if ($check->rowCount() == 0) {
            $stmt->execute($apt);
        }
    }

    echo "Mock data inserted successfully.";

} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
?>
