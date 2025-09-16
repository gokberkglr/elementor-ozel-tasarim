<?php
/**
 * Özel Link Meta Widget
 */

if (!defined('ABSPATH')) {
    exit; // Doğrudan erişimi engelle
}

class ElementorOzelLinkMetaWidget extends \Elementor\Widget_Base {

    /**
     * Widget adı
     */
    public function get_name() {
        return 'ozel-link-meta-widget';
    }

    /**
     * Widget başlığı
     */
    public function get_title() {
        return __('Özel Link Meta Veri', 'elementor-ozel-tasarim');
    }

    /**
     * Widget ikonu
     */
    public function get_icon() {
        return 'eicon-link';
    }

    /**
     * Widget kategorisi
     */
    public function get_categories() {
        return ['ozel-tasarim'];
    }

    /**
     * Widget anahtarları
     */
    public function get_keywords() {
        return ['link', 'meta', 'veri', 'özel', 'tasarım', 'url'];
    }

    /**
     * Widget kontrollerini tanımla
     */
    protected function _register_controls() {

        // İçerik sekmesi
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('İçerik', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'link_url',
            [
                'label' => __('Link URL', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://example.com', 'elementor-ozel-tasarim'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'veri_cek_buton',
            [
                'label' => __('Veri Çek', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'text' => __('Meta Verileri Çek', 'elementor-ozel-tasarim'),
                'event' => 'ozel_link_meta_cek',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'veri_cek_durumu',
            [
                'label' => __('Veri Çekme Durumu', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => '<div id="veri-cek-durumu" style="padding: 10px; background: #f0f0f0; border-radius: 4px; margin: 10px 0; display: none;">
                    <div id="veri-cek-mesaj">Veri çekiliyor...</div>
                    <div id="veri-cek-detay" style="font-size: 12px; color: #666; margin-top: 5px;"></div>
                </div>',
            ]
        );

        $this->add_control(
            'cekilen_veri',
            [
                'label' => __('Çekilen Veri', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'default' => '',
            ]
        );

        $this->add_control(
            'baslik',
            [
                'label' => __('Başlık', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Başlık burada görünecek', 'elementor-ozel-tasarim'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'aciklama',
            [
                'label' => __('Açıklama', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Açıklama burada görünecek', 'elementor-ozel-tasarim'),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'resim_url',
            [
                'label' => __('Resim URL', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://example.com/resim.jpg', 'elementor-ozel-tasarim'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'description' => __('Resim linkini buraya girin', 'elementor-ozel-tasarim'),
            ]
        );

        $this->add_control(
            'varsayilan_resim_url',
            [
                'label' => __('Varsayılan Resim URL (Resim yoksa gösterilir)', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://example.com/varsayilan-resim.jpg', 'elementor-ozel-tasarim'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'description' => __('Resim çekilemezse veya yoksa bu resim gösterilir', 'elementor-ozel-tasarim'),
            ]
        );

        $this->add_control(
            'buton_metni',
            [
                'label' => __('Buton Metni', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Siteyi Ziyaret Et', 'elementor-ozel-tasarim'),
                'placeholder' => __('Buton metnini girin', 'elementor-ozel-tasarim'),
            ]
        );

        $this->add_control(
            'yeni_sekmede_ac',
            [
                'label' => __('Yeni Sekmede Aç', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Evet', 'elementor-ozel-tasarim'),
                'label_off' => __('Hayır', 'elementor-ozel-tasarim'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Resim Ayarları sekmesi
        $this->start_controls_section(
            'resim_ayarlari_section',
            [
                'label' => __('Resim Ayarları', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'lazy_loading',
            [
                'label' => __('Lazy Loading', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Evet', 'elementor-ozel-tasarim'),
                'label_off' => __('Hayır', 'elementor-ozel-tasarim'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'resim_boyut_ayari',
            [
                'label' => __('Resim Boyut Ayarları', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'width' => '300',
                    'height' => '200',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-resim' => 'width: {{width}}{{unit}}; height: {{height}}{{unit}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Düzen sekmesi
        $this->start_controls_section(
            'duzen_section',
            [
                'label' => __('Düzen', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'resim_konumu',
            [
                'label' => __('Resim Konumu', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'sol',
                'options' => [
                    'ust' => __('Üstte', 'elementor-ozel-tasarim'),
                    'sol' => __('Solda', 'elementor-ozel-tasarim'),
                ],
            ]
        );

        $this->add_control(
            'resim_genislik',
            [
                'label' => __('Resim Genişliği', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 20,
                        'max' => 80,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-resim' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'resim_konumu' => 'sol',
                ],
            ]
        );

        $this->add_control(
            'resim_yukseklik',
            [
                'label' => __('Resim Yüksekliği', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 400,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-resim' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icerik_hizalama',
            [
                'label' => __('İçerik Hizalama', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'sol',
                'options' => [
                    'sol' => __('Sol', 'elementor-ozel-tasarim'),
                    'orta' => __('Orta', 'elementor-ozel-tasarim'),
                    'sag' => __('Sağ', 'elementor-ozel-tasarim'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-icerik' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Stil sekmesi
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Stil', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'kart_arka_renk',
            [
                'label' => __('Kart Arka Plan Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'kart_kenar_yuvarlakligi',
            [
                'label' => __('Kart Kenar Yuvarlaklığı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kart_golge',
                'label' => __('Kart Gölgesi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-link-meta',
            ]
        );

        $this->end_controls_section();

        // Başlık stili
        $this->start_controls_section(
            'baslik_style_section',
            [
                'label' => __('Başlık Stili', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'baslik_typography',
                'label' => __('Başlık Tipografi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-link-meta-baslik',
            ]
        );

        $this->add_control(
            'baslik_renk',
            [
                'label' => __('Başlık Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-baslik' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Açıklama stili
        $this->start_controls_section(
            'aciklama_style_section',
            [
                'label' => __('Açıklama Stili', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'aciklama_typography',
                'label' => __('Açıklama Tipografi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-link-meta-aciklama',
            ]
        );

        $this->add_control(
            'aciklama_renk',
            [
                'label' => __('Açıklama Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-aciklama' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Buton stili
        $this->start_controls_section(
            'buton_style_section',
            [
                'label' => __('Buton Stili', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'buton_typography',
                'label' => __('Buton Tipografi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-link-meta-buton',
            ]
        );

        $this->add_control(
            'buton_arka_renk',
            [
                'label' => __('Buton Arka Plan Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-buton' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'buton_metin_renk',
            [
                'label' => __('Buton Metin Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-buton' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'buton_kenar_yuvarlakligi',
            [
                'label' => __('Buton Kenar Yuvarlaklığı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ozel-link-meta-buton' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Resim özelliklerini al
     */
    private function get_image_attributes($image_url, $alt_text, $settings) {
        $attributes = [
            'src' => $image_url,
            'alt' => $alt_text,
            'class' => 'ozel-link-meta-resim-img'
        ];
        
        // Lazy loading - varsayılan olarak aktif
        if (isset($settings['lazy_loading']) && $settings['lazy_loading'] === 'yes') {
            $attributes['loading'] = 'lazy';
            $attributes['decoding'] = 'async';
        } else {
            // Varsayılan olarak lazy loading aktif
            $attributes['loading'] = 'lazy';
            $attributes['decoding'] = 'async';
        }
        
        return $attributes;
    }

    /**
     * URL'den meta verilerini çek
     */
    public function get_meta_data($url) {
        if (empty($url)) {
            return false;
        }

        // URL'yi temizle
        $url = esc_url_raw($url);
        
        // Cache kontrolü
        $cache_key = 'link_meta_' . md5($url);
        $cached_data = get_transient($cache_key);
        
        if ($cached_data !== false) {
            return $cached_data;
        }

        // URL'yi kontrol et
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        // HTTP isteği yap - birden fazla yöntem dene
        $request_methods = [
            // Yöntem 1: Doğrudan istek
            [
                'timeout' => 30,
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'headers' => [
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                    'Accept-Language' => 'tr-TR,tr;q=0.9,en;q=0.8',
                    'Accept-Encoding' => 'gzip, deflate, br',
                    'Cache-Control' => 'no-cache',
                    'Pragma' => 'no-cache',
                    'Connection' => 'keep-alive',
                    'Upgrade-Insecure-Requests' => '1',
                ],
                'sslverify' => false,
                'redirection' => 5,
            ],
            // Yöntem 2: Basit istek
            [
                'timeout' => 20,
                'user-agent' => 'Mozilla/5.0 (compatible; LinkMetaBot/1.0)',
                'sslverify' => false,
                'redirection' => 3,
            ],
            // Yöntem 3: CURL benzeri istek
            [
                'timeout' => 25,
                'user-agent' => 'curl/7.68.0',
                'headers' => [
                    'Accept' => '*/*',
                ],
                'sslverify' => false,
                'redirection' => 2,
            ]
        ];
        
        $response = null;
        $last_error = '';
        
        foreach ($request_methods as $index => $args) {
            $response = wp_remote_get($url, $args);
            
            if (!is_wp_error($response)) {
                $response_code = wp_remote_retrieve_response_code($response);
                if ($response_code >= 200 && $response_code < 300) {
                    error_log('Link Meta Widget: Request successful with method ' . ($index + 1) . ' for URL: ' . $url);
                    break;
                }
            } else {
                $last_error = $response->get_error_message();
                error_log('Link Meta Widget: Request method ' . ($index + 1) . ' failed: ' . $last_error);
            }
            
            $response = null;
        }

        if (is_wp_error($response)) {
            error_log('Link Meta Widget Error: ' . $response->get_error_message());
            return false;
        }

        if (!$response) {
            error_log('Link Meta Widget: All request methods failed. Last error: ' . $last_error);
            return false;
        }

        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code < 200 || $response_code >= 300) {
            error_log('Link Meta Widget HTTP Error: ' . $response_code . ' for URL: ' . $url);
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        if (empty($body)) {
            error_log('Link Meta Widget: Empty response body');
            return false;
        }

        // Meta verilerini çıkar
        $meta_data = [
            'title' => '',
            'description' => '',
            'image' => '',
            'url' => $url,
            'domain' => parse_url($url, PHP_URL_HOST)
        ];

        // Başlık çek
        if (preg_match('/<title[^>]*>([^<]+)<\/title>/i', $body, $matches)) {
            $meta_data['title'] = trim($matches[1]);
        }

        // Meta description çek
        if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $body, $matches)) {
            $meta_data['description'] = trim($matches[1]);
        }

        // Open Graph title çek
        if (empty($meta_data['title']) && preg_match('/<meta[^>]*property=["\']og:title["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $body, $matches)) {
            $meta_data['title'] = trim($matches[1]);
        }

        // Open Graph description çek
        if (empty($meta_data['description']) && preg_match('/<meta[^>]*property=["\']og:description["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $body, $matches)) {
            $meta_data['description'] = trim($matches[1]);
        }

        // Resim çek - önce Open Graph image
        if (preg_match('/<meta[^>]*property=["\']og:image["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $body, $matches)) {
            $meta_data['image'] = trim($matches[1]);
        }

        // Twitter image
        if (empty($meta_data['image']) && preg_match('/<meta[^>]*name=["\']twitter:image["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $body, $matches)) {
            $meta_data['image'] = trim($matches[1]);
        }

        // Meta image
        if (empty($meta_data['image']) && preg_match('/<meta[^>]*name=["\']image["\'][^>]*content=["\']([^"\']*)["\'][^>]*>/i', $body, $matches)) {
            $meta_data['image'] = trim($matches[1]);
        }

        // İlk resmi bul
        if (empty($meta_data['image']) && preg_match('/<img[^>]*src=["\']([^"\']*)["\'][^>]*>/i', $body, $matches)) {
            $meta_data['image'] = trim($matches[1]);
        }

        // Göreceli URL'leri mutlak URL'ye çevir
        if (!empty($meta_data['image']) && !filter_var($meta_data['image'], FILTER_VALIDATE_URL)) {
            $parsed_url = parse_url($url);
            $base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
            if (strpos($meta_data['image'], '/') === 0) {
                $meta_data['image'] = $base_url . $meta_data['image'];
            } else {
                $meta_data['image'] = $base_url . '/' . $meta_data['image'];
            }
        }

        // Verileri temizle
        $meta_data['title'] = wp_strip_all_tags($meta_data['title']);
        $meta_data['description'] = wp_strip_all_tags($meta_data['description']);
        $meta_data['description'] = wp_trim_words($meta_data['description'], 30, '...');

        // En az bir veri var mı kontrol et
        if (empty($meta_data['title']) && empty($meta_data['description']) && empty($meta_data['image'])) {
            error_log('Link Meta Widget: No meta data found for URL: ' . $url);
            return false;
        }

        // Cache'e kaydet (1 saat)
        set_transient($cache_key, $meta_data, HOUR_IN_SECONDS);

        return $meta_data;
    }

    /**
     * Widget'ı render et
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['link_url']['url'])) {
            echo '<p>' . __('Lütfen geçerli bir URL girin.', 'elementor-ozel-tasarim') . '</p>';
            return;
        }

        $url = esc_url_raw($settings['link_url']['url']);
        
        // URL validasyonu
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            echo '<p>' . __('Geçersiz URL formatı.', 'elementor-ozel-tasarim') . '</p>';
            return;
        }
        $target = $settings['link_url']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['link_url']['nofollow'] ? ' rel="nofollow"' : '';

        // Meta verileri hazırla
        $meta_data = [
            'title' => !empty($settings['baslik']) ? $settings['baslik'] : __('Başlık Bulunamadı', 'elementor-ozel-tasarim'),
            'description' => !empty($settings['aciklama']) ? $settings['aciklama'] : __('Açıklama bulunamadı.', 'elementor-ozel-tasarim'),
            'image' => !empty($settings['resim_url']['url']) ? $settings['resim_url']['url'] : '',
            'url' => $url,
            'domain' => parse_url($url, PHP_URL_HOST)
        ];

        // Eğer resim yoksa varsayılan resmi kullan
        if (empty($meta_data['image']) && !empty($settings['varsayilan_resim_url']['url'])) {
            $meta_data['image'] = $settings['varsayilan_resim_url']['url'];
        }

        // Resim URL'sini direkt kullan
        $final_image = $meta_data['image'];
        $image_attributes = $this->get_image_attributes($final_image, $meta_data['title'], $settings);
        
        // Düzen sınıfları
        $layout_class = 'ozel-link-meta-' . $settings['resim_konumu'];
        $content_alignment = $settings['icerik_hizalama'] ?? 'sol';

        ?>
        <div class="ozel-link-meta <?php echo esc_attr($layout_class); ?>">
            <?php if (!empty($final_image)): ?>
                <div class="ozel-link-meta-resim">
                    <img <?php 
                        foreach ($image_attributes as $attr => $value) {
                            echo esc_attr($attr) . '="' . esc_attr($value) . '" ';
                        }
                    ?>>
                </div>
            <?php endif; ?>
            
            <div class="ozel-link-meta-icerik">
                <div class="ozel-link-meta-text">
                    <h3 class="ozel-link-meta-baslik"><?php echo esc_html($meta_data['title']); ?></h3>
                    
                    <?php if (!empty($meta_data['description'])): ?>
                        <p class="ozel-link-meta-aciklama"><?php echo esc_html($meta_data['description']); ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="ozel-link-meta-footer">
                    <div class="ozel-link-meta-footer-ust">
                        <?php if (!empty($meta_data['domain'])): ?>
                            <span class="ozel-link-meta-domain"><?php echo esc_html($meta_data['domain']); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="ozel-link-meta-footer-alt">
                        <a href="<?php echo esc_url($url); ?>" class="ozel-link-meta-buton"<?php echo $target . $nofollow; ?>>
                            <?php echo esc_html($settings['buton_metni']); ?>
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Widget'ı içerik olarak render et
     */
    protected function _content_template() {
        ?>
        <div class="ozel-link-meta ozel-link-meta-{{{ settings.resim_konumu || 'sol' }}}">
            <# 
            var imageUrl = '';
            var title = '';
            var description = '';
            
            // Resim URL'sini belirle
            if (settings.resim_url && settings.resim_url.url) {
                imageUrl = settings.resim_url.url;
            } else if (settings.varsayilan_resim_url && settings.varsayilan_resim_url.url) {
                imageUrl = settings.varsayilan_resim_url.url;
            }
            
            title = settings.baslik || 'Başlık Bulunamadı';
            description = settings.aciklama || '';
            #>
            
            <# if (imageUrl) { #>
                <div class="ozel-link-meta-resim">
                    <img src="{{{ imageUrl }}}" alt="{{{ title }}}" loading="lazy">
                </div>
            <# } #>
            
            <div class="ozel-link-meta-icerik">
                <div class="ozel-link-meta-text">
                    <h3 class="ozel-link-meta-baslik">{{{ title }}}</h3>
                    
                    <# if (description) { #>
                        <p class="ozel-link-meta-aciklama">{{{ description }}}</p>
                    <# } #>
                </div>
                
                <div class="ozel-link-meta-footer">
                    <div class="ozel-link-meta-footer-ust">
                        <# if (settings.link_url && settings.link_url.url) { #>
                            <span class="ozel-link-meta-domain">{{{ settings.link_url.url }}}</span>
                        <# } #>
                    </div>
                    
                    <div class="ozel-link-meta-footer-alt">
                        <# if (settings.link_url && settings.link_url.url) { #>
                            <a href="{{{ settings.link_url.url }}}" class="ozel-link-meta-buton">
                                {{{ settings.buton_metni }}}
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        <# } #>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
