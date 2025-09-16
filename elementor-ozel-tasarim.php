<?php
/**
 * Plugin Name: Elementor Özel Tasarım Widget'ları
 * Plugin URI: https://veyselgokberkguler.com.tr/elementor-ozel-tasarim-widgetlari
 * Description: Elementor için özel tasarım widget'ları oluşturan plugin
 * Version: 1.0.6
 * GitHub Plugin URI: gokberkglr/elementor-ozel-tasarim
 * Author: gokberkglr
 * Author URI: https://veyselgokberkguler.com.tr
 * Text Domain: elementor-ozel-tasarim
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Güvenlik kontrolü
if (!defined('ABSPATH')) {
    exit; // Doğrudan erişimi engelle
}

// Plugin sabitleri
define('ELEMENTOR_OZEL_TASARIM_VERSION', '1.0.6');
define('ELEMENTOR_OZEL_TASARIM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Ana plugin sınıfı
 */
class ElementorOzelTasarim {

    /**
     * Singleton instance
     */
    private static $instance = null;

    /**
     * Singleton pattern
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        add_action('plugins_loaded', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }

    /**
     * Plugin başlatma
     */
    public function init() {
        // Elementor'un yüklü olup olmadığını kontrol et
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', array($this, 'elementor_missing_notice'));
            return;
        }

        // Widget'ları yükle
        add_action('elementor/widgets/widgets_registered', array($this, 'register_widgets'));
        
        // Stil ve script dosyalarını yükle
        add_action('elementor/frontend/after_enqueue_styles', array($this, 'enqueue_styles'));
        add_action('elementor/frontend/after_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        // Admin stil ve script dosyalarını yükle
        add_action('elementor/editor/before_enqueue_scripts', array($this, 'enqueue_editor_scripts'));
        
        // AJAX handler'ları
        add_action('wp_ajax_ozel_link_meta_cek', array($this, 'ajax_link_meta_cek'));
        add_action('wp_ajax_nopriv_ozel_link_meta_cek', array($this, 'ajax_link_meta_cek'));
        
        // Admin panelinde version bilgilerini göster
        add_action('admin_notices', array($this, 'show_version_info'));
    }

    /**
     * Elementor eksik uyarısı
     */
    public function elementor_missing_notice() {
        echo '<div class="notice notice-error"><p>';
        echo __('Elementor Özel Tasarım Widget\'ları çalışması için Elementor eklentisinin yüklü olması gerekiyor.', 'elementor-ozel-tasarim');
        echo '</p></div>';
    }

    /**
     * Widget'ları kaydet
     */
    public function register_widgets() {
        // Widget dosyalarını dahil et
        require_once ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'widgets/ozel-kart-widget.php';
        require_once ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'widgets/ozel-blog-widget.php';
        require_once ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'widgets/ozel-portfolio-widget.php';
        require_once ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'widgets/ozel-testimonial-widget.php';
        require_once ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'widgets/ozel-link-meta-widget.php';

        // Widget'ları Elementor'a kaydet
        \Elementor\Plugin::instance()->widgets_manager->register(new \ElementorOzelKartWidget());
        \Elementor\Plugin::instance()->widgets_manager->register(new \ElementorOzelBlogWidget());
        \Elementor\Plugin::instance()->widgets_manager->register(new \ElementorOzelPortfolioWidget());
        \Elementor\Plugin::instance()->widgets_manager->register(new \ElementorOzelTestimonialWidget());
        \Elementor\Plugin::instance()->widgets_manager->register(new \ElementorOzelLinkMetaWidget());
    }

    /**
     * Cache busting version oluştur
     */
    private function get_file_version($file_path) {
        $version = ELEMENTOR_OZEL_TASARIM_VERSION;
        
        if (file_exists($file_path)) {
            $file_time = filemtime($file_path);
            $file_size = filesize($file_path);
            // Dosya zamanı ve boyutunu birleştirerek unique version oluştur
            $version = ELEMENTOR_OZEL_TASARIM_VERSION . '.' . $file_time . '.' . substr(md5($file_size), 0, 8);
        }
        
        return $version;
    }

    /**
     * Frontend stil dosyalarını yükle
     */
    public function enqueue_styles() {
        $css_file = ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'assets/css/style.css';
        $version = $this->get_file_version($css_file);
        
        wp_enqueue_style(
            'elementor-ozel-tasarim-style',
            ELEMENTOR_OZEL_TASARIM_PLUGIN_URL . 'assets/css/style.css',
            array(),
            $version
        );
    }

    /**
     * Frontend script dosyalarını yükle
     */
    public function enqueue_scripts() {
        $js_file = ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'assets/js/script.js';
        $version = $this->get_file_version($js_file);
        
        wp_enqueue_script(
            'elementor-ozel-tasarim-script',
            ELEMENTOR_OZEL_TASARIM_PLUGIN_URL . 'assets/js/script.js',
            array('jquery'),
            $version,
            true
        );
    }

    /**
     * Editor script dosyalarını yükle
     */
    public function enqueue_editor_scripts() {
        $js_file = ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'assets/js/editor.js';
        $version = $this->get_file_version($js_file);
        
        wp_enqueue_script(
            'elementor-ozel-tasarim-editor',
            ELEMENTOR_OZEL_TASARIM_PLUGIN_URL . 'assets/js/editor.js',
            array('jquery'),
            $version,
            true
        );
    }

    /**
     * Plugin aktivasyon
     */
    public function activate() {
        // Aktivasyon işlemleri
        flush_rewrite_rules();
    }

    /**
     * AJAX ile link meta veri çekme
     */
    public function ajax_link_meta_cek() {
        // Nonce kontrolü
        if (!wp_verify_nonce($_POST['nonce'], 'elementor_ajax')) {
            wp_send_json_error('Güvenlik kontrolü başarısız');
        }

        $url = sanitize_url($_POST['url']);
        
        if (empty($url)) {
            wp_send_json_error('URL boş olamaz');
        }

        // URL validasyonu
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            wp_send_json_error('Geçersiz URL formatı');
        }

        // Meta veri çekme fonksiyonunu çağır
        require_once ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'widgets/ozel-link-meta-widget.php';
        $widget = new ElementorOzelLinkMetaWidget();
        
        // Debug bilgileri
        $debug_info = [
            'url' => $url,
            'timestamp' => current_time('mysql'),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'server_time' => current_time('H:i:s'),
            'memory_usage' => memory_get_usage(true)
        ];
        
        $meta_data = $widget->get_meta_data($url);
        
        if ($meta_data && !empty($meta_data['title'])) {
            // Başarılı çekme bilgileri
            $response_data = [
                'title' => $meta_data['title'],
                'description' => $meta_data['description'],
                'image' => $meta_data['image'],
                'url' => $meta_data['url'],
                'domain' => $meta_data['domain'],
                'debug' => $debug_info,
                'success' => true,
                'message' => 'Meta veriler başarıyla çekildi'
            ];
            wp_send_json_success($response_data);
        } else {
            // Hata bilgileri
            $error_data = [
                'debug' => $debug_info,
                'error' => 'Meta veri çekilemedi',
                'possible_causes' => [
                    'Site erişilebilir değil',
                    'Meta etiketleri bulunamadı',
                    'CORS hatası',
                    'Sunucu yanıt vermiyor',
                    'SSL sertifika hatası'
                ],
                'suggestions' => [
                    'URL\'nin doğru olduğundan emin olun',
                    'Site erişilebilir durumda mı kontrol edin',
                    'Farklı bir URL deneyin'
                ]
            ];
            wp_send_json_error($error_data);
        }
    }

    /**
     * Admin panelinde version bilgilerini göster
     */
    public function show_version_info() {
        // Sadece admin sayfalarında ve belirli koşullarda göster
        if (!current_user_can('manage_options') || !isset($_GET['page']) || strpos($_GET['page'], 'elementor') === false) {
            return;
        }
        
        // Cache busting bilgilerini al
        $css_file = ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'assets/css/style.css';
        $js_file = ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'assets/js/script.js';
        $editor_js_file = ELEMENTOR_OZEL_TASARIM_PLUGIN_PATH . 'assets/js/editor.js';
        
        $css_version = $this->get_file_version($css_file);
        $js_version = $this->get_file_version($js_file);
        $editor_js_version = $this->get_file_version($editor_js_file);
        
        echo '<div class="notice notice-info is-dismissible">';
        echo '<p><strong>🚀 Elementor Özel Tasarım Widget\'ları v' . ELEMENTOR_OZEL_TASARIM_VERSION . '</strong></p>';
        echo '<p><strong>📁 Cache Busting Bilgileri:</strong></p>';
        echo '<div style="background: #f0f0f1; padding: 10px; border-radius: 4px; margin: 10px 0;">';
        echo '<p style="margin: 0;"><strong>CSS:</strong> <code>' . $css_version . '</code></p>';
        echo '<p style="margin: 5px 0 0 0;"><strong>JS:</strong> <code>' . $js_version . '</code></p>';
        echo '<p style="margin: 5px 0 0 0;"><strong>Editor JS:</strong> <code>' . $editor_js_version . '</code></p>';
        echo '</div>';
        echo '<p style="margin: 10px 0 0 0;"><em>💡 Bu version numaraları dosya değişiklik zamanı + boyut hash\'i içerir. Dosyalar güncellendiğinde otomatik olarak değişir.</em></p>';
        echo '</div>';
    }

    /**
     * Plugin deaktivasyon
     */
    public function deactivate() {
        // Deaktivasyon işlemleri
        flush_rewrite_rules();
    }
}

// Plugin'i başlat
ElementorOzelTasarim::get_instance();
