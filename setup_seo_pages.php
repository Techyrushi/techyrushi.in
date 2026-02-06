<?php
require_once 'includes/db.php';

$pages = [
    'index' => [
        'title' => 'Home - Techyrushi',
        'desc' => 'Techyrushi provides top-notch IT solutions and technology services.',
        'keywords' => 'IT solutions, technology, software development, techyrushi'
    ],
    'about' => [
        'title' => 'About Us - Techyrushi',
        'desc' => 'Learn more about Techyrushi and our mission to provide excellent IT services.',
        'keywords' => 'about us, techyrushi, mission, vision'
    ],
    'services' => [
        'title' => 'Services - Techyrushi',
        'desc' => 'Explore our wide range of IT services including web development, app development, and more.',
        'keywords' => 'services, web development, app development, IT services'
    ],
    'project' => [
        'title' => 'Projects - Techyrushi',
        'desc' => 'Check out our latest projects and case studies.',
        'keywords' => 'projects, case studies, portfolio, techyrushi work'
    ],
    'blog' => [
        'title' => 'Blog - Techyrushi',
        'desc' => 'Read our latest blog posts on technology trends and insights.',
        'keywords' => 'blog, technology news, tech trends, insights'
    ],
    'contact' => [
        'title' => 'Contact Us - Techyrushi',
        'desc' => 'Get in touch with us for your IT needs.',
        'keywords' => 'contact us, get in touch, support, inquiry'
    ],
    'privacy' => [
        'title' => 'Privacy Policy - Techyrushi',
        'desc' => 'Our privacy policy regarding your data.',
        'keywords' => 'privacy policy, data protection, privacy'
    ],
    'disclaimer' => [
        'title' => 'Disclaimer - Techyrushi',
        'desc' => 'Our website disclaimer.',
        'keywords' => 'disclaimer, legal, terms'
    ],
    'terms' => [
        'title' => 'Terms & Conditions - Techyrushi',
        'desc' => 'Our terms and conditions of use.',
        'keywords' => 'terms and conditions, terms of use, legal'
    ],
    'sitemap' => [
        'title' => 'Sitemap - Techyrushi',
        'desc' => 'Site map of Techyrushi website.',
        'keywords' => 'sitemap, site structure, links'
    ]
];

foreach ($pages as $route => $meta) {
    // Check if exists
    $stmt = $pdo->prepare("SELECT id FROM seo_meta WHERE page_route = ?");
    $stmt->execute([$route]);
    if ($stmt->rowCount() == 0) {
        $stmt_insert = $pdo->prepare("INSERT INTO seo_meta (page_route, meta_title, meta_keywords, meta_description) VALUES (?, ?, ?, ?)");
        $stmt_insert->execute([$route, $meta['title'], $meta['keywords'], $meta['desc']]);
        echo "Inserted SEO for $route<br>";
    } else {
        echo "SEO for $route already exists<br>";
    }
}
echo "SEO Setup Complete.";
?>
