<?php
include 'includes/db.php';

try {
    // 1. Setup FAQs Table
    $pdo->exec("CREATE TABLE IF NOT EXISTS faqs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL,
        answer TEXT NOT NULL,
        display_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. Clear existing FAQs and Testimonials (to ensure clean slate with user requests)
    $pdo->exec("TRUNCATE TABLE faqs");
    $pdo->exec("TRUNCATE TABLE testimonials");

    // 3. Insert FAQs
    $faqs = [
        [
            'question' => "How do you ensure the security of my software project?",
            'answer' => "We adhere to industry-standard security protocols, including regular code audits, secure data encryption, and compliance with GDPR and other relevant regulations to protect your intellectual property."
        ],
        [
            'question' => "What is your typical project development lifecycle?",
            'answer' => "We follow an Agile methodology, starting with requirement analysis, followed by design, development, rigorous testing, deployment, and ongoing maintenance to ensure timely and quality delivery."
        ],
        [
            'question' => "Do you provide post-launch support and maintenance?",
            'answer' => "Yes, we offer comprehensive post-launch support packages that include bug fixes, performance monitoring, and feature updates to keep your application running smoothly."
        ],
        [
            'question' => "Can you help upgrade or modernize our legacy systems?",
            'answer' => "Absolutely. We specialize in legacy system modernization, helping businesses migrate to cloud architectures, refactor codebases, and improve scalability without disrupting operations."
        ],
        [
            'question' => "What technologies do you specialize in?",
            'answer' => "Our team is proficient in a wide range of technologies including PHP (Laravel, CodeIgniter), JavaScript (React, Vue, Node.js), Python, Java, and cloud platforms like AWS and Azure."
        ]
    ];

    $stmt_faq = $pdo->prepare("INSERT INTO faqs (question, answer, display_order) VALUES (?, ?, ?)");
    foreach ($faqs as $index => $faq) {
        $stmt_faq->execute([$faq['question'], $faq['answer'], $index + 1]);
    }
    echo "FAQs inserted successfully.\n";

    // 4. Insert Testimonials (Indian Names)
    $testimonials = [
        [
            'name' => "Aarav Sharma",
            'designation' => "CTO, FinTech Solutions",
            'content' => "Techyrushi transformed our outdated platform into a modern, high-performance fintech app. Their team's technical expertise and dedication to deadlines were impressive.",
            'image' => "testi1.jpg"
        ],
        [
            'name' => "Priya Venkatesh",
            'designation' => "Founder, E-Com Ventures",
            'content' => "Working with Techyrushi was a game-changer for our e-commerce business. They delivered a scalable solution that handled our festival traffic spikes effortlessly.",
            'image' => "testi2.jpg"
        ],
        [
            'name' => "Rajesh Gupta",
            'designation' => "Director, Logistics Hub",
            'content' => "The custom logistics management system they built has optimized our fleet operations by 40%. Highly recommend their services for complex enterprise solutions.",
            'image' => "testi3.jpg"
        ],
        [
            'name' => "Sneha Reddy",
            'designation' => "Marketing Head, Digital Growth",
            'content' => "Their digital marketing tools and dashboard integration gave us real-time insights that boosted our campaign ROI significantly. A truly value-driven partnership.",
            'image' => "testi4.jpg"
        ],
        [
            'name' => "Vikram Malhotra",
            'designation' => "CEO, Startup Inc.",
            'content' => "From concept to MVP, Techyrushi guided us through every step. Their startup-friendly approach and technical guidance were invaluable for our launch.",
            'image' => "testi5.jpg"
        ]
    ];

    $stmt_testi = $pdo->prepare("INSERT INTO testimonials (name, designation, content, image) VALUES (?, ?, ?, ?)");
    foreach ($testimonials as $testimonial) {
        $stmt_testi->execute([$testimonial['name'], $testimonial['designation'], $testimonial['content'], $testimonial['image']]);
    }
    echo "Testimonials inserted successfully.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
