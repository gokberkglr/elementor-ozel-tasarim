<?php
/**
 * Yerel Proxy Servisi
 * CORS sorunlarını çözmek için kullanılır
 */

// Güvenlik kontrolü
if (!defined('ABSPATH')) {
    // WordPress ortamında değilse, basit güvenlik kontrolü
    $allowed_hosts = [
        'localhost',
        '127.0.0.1',
        $_SERVER['HTTP_HOST'] ?? ''
    ];
    
    $current_host = $_SERVER['HTTP_HOST'] ?? '';
    if (!in_array($current_host, $allowed_hosts)) {
        http_response_code(403);
        die('Access denied');
    }
}

// URL parametresini al
$url = $_GET['url'] ?? '';

if (empty($url)) {
    http_response_code(400);
    die('URL parameter is required');
}

// URL'yi temizle ve doğrula
$url = filter_var($url, FILTER_SANITIZE_URL);
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    die('Invalid URL');
}

// Güvenlik: Sadece HTTP ve HTTPS URL'lerine izin ver
$parsed_url = parse_url($url);
if (!in_array($parsed_url['scheme'] ?? '', ['http', 'https'])) {
    http_response_code(400);
    die('Only HTTP and HTTPS URLs are allowed');
}

// Güvenlik: Localhost ve private IP'leri engelle
$host = $parsed_url['host'] ?? '';
if (in_array($host, ['localhost', '127.0.0.1', '0.0.0.0']) || 
    filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
    http_response_code(403);
    die('Private IP addresses are not allowed');
}

// Resim isteği yap
$response = wp_remote_get($url, [
    'timeout' => 30,
    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    'headers' => [
        'Accept' => 'image/*,*/*;q=0.8',
        'Accept-Language' => 'tr-TR,tr;q=0.9,en;q=0.8',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
        'Upgrade-Insecure-Requests' => '1'
    ],
    'sslverify' => false,
    'redirection' => 5
]);

if (is_wp_error($response)) {
    http_response_code(500);
    die('Failed to fetch image: ' . $response->get_error_message());
}

$response_code = wp_remote_retrieve_response_code($response);
if ($response_code !== 200) {
    http_response_code($response_code);
    die('HTTP Error: ' . $response_code);
}

$body = wp_remote_retrieve_body($response);
$content_type = wp_remote_retrieve_header($response, 'content-type');

if (empty($body)) {
    http_response_code(404);
    die('No content received');
}

// İçerik türünü kontrol et
if ($content_type && strpos($content_type, 'image/') !== 0) {
    http_response_code(415);
    die('Content is not an image');
}

// Cache başlıkları ayarla
$cache_time = 3600; // 1 saat
header('Cache-Control: public, max-age=' . $cache_time);
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $cache_time) . ' GMT');

// CORS başlıkları
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// İçerik türünü ayarla
if ($content_type) {
    header('Content-Type: ' . $content_type);
} else {
    header('Content-Type: application/octet-stream');
}

// İçerik uzunluğunu ayarla
header('Content-Length: ' . strlen($body));

// Resmi gönder
echo $body;
