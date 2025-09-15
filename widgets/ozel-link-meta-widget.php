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
            'otomatik_cek',
            [
                'label' => __('Otomatik Meta Veri Çek', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Evet', 'elementor-ozel-tasarim'),
                'label_off' => __('Hayır', 'elementor-ozel-tasarim'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'veri_cek_buton',
            [
                'label' => __('Veri Çek', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::BUTTON,
                'text' => __('Meta Verileri Çek', 'elementor-ozel-tasarim'),
                'event' => 'ozel_link_meta_cek',
                'condition' => [
                    'otomatik_cek' => 'yes',
                ],
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
                'condition' => [
                    'otomatik_cek' => 'yes',
                ],
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
            'cekilen_baslik',
            [
                'label' => __('Çekilen Başlık', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Başlık burada görünecek', 'elementor-ozel-tasarim'),
                'condition' => [
                    'otomatik_cek' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cekilen_aciklama',
            [
                'label' => __('Çekilen Açıklama', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Açıklama burada görünecek', 'elementor-ozel-tasarim'),
                'condition' => [
                    'otomatik_cek' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cekilen_resim',
            [
                'label' => __('Çekilen Resim', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'otomatik_cek' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'manuel_baslik',
            [
                'label' => __('Manuel Başlık', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Manuel başlık girin', 'elementor-ozel-tasarim'),
                'condition' => [
                    'otomatik_cek' => 'no',
                ],
            ]
        );

        $this->add_control(
            'manuel_aciklama',
            [
                'label' => __('Manuel Açıklama', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Manuel açıklama girin', 'elementor-ozel-tasarim'),
                'condition' => [
                    'otomatik_cek' => 'no',
                ],
            ]
        );

        $this->add_control(
            'manuel_resim',
            [
                'label' => __('Manuel Resim', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'otomatik_cek' => 'no',
                ],
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

        // Resim Optimizasyonu sekmesi
        $this->start_controls_section(
            'resim_optimizasyon_section',
            [
                'label' => __('Resim Optimizasyonu', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'resim_kalitesi',
            [
                'label' => __('Resim Kalitesi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 85,
                ],
            ]
        );

        $this->add_control(
            'webp_destegi',
            [
                'label' => __('WebP Desteği', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Evet', 'elementor-ozel-tasarim'),
                'label_off' => __('Hayır', 'elementor-ozel-tasarim'),
                'return_value' => 'yes',
                'default' => 'yes',
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
            'resim_optimizasyonu',
            [
                'label' => __('Otomatik Optimizasyon', 'elementor-ozel-tasarim'),
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
     * Resim optimizasyonu yap
     */
    public function optimize_image($image_url, $settings) {
        if (empty($image_url) || $settings['resim_optimizasyonu'] !== 'yes') {
            return $image_url;
        }

        // WebP desteği kontrolü
        $webp_support = $settings['webp_destegi'] === 'yes' && function_exists('imagewebp');
        
        // Resim kalitesi
        $quality = isset($settings['resim_kalitesi']['size']) ? $settings['resim_kalitesi']['size'] : 85;
        
        // WordPress resim boyutları
        $sizes = [
            'thumbnail' => [150, 150],
            'medium' => [300, 300],
            'large' => [1024, 1024],
            'full' => [0, 0]
        ];
        
        // En uygun boyutu seç
        $selected_size = 'medium';
        if (isset($settings['resim_boyut_ayari']['width']) && $settings['resim_boyut_ayari']['width']) {
            $width = intval($settings['resim_boyut_ayari']['width']);
            if ($width <= 150) $selected_size = 'thumbnail';
            elseif ($width <= 300) $selected_size = 'medium';
            elseif ($width <= 1024) $selected_size = 'large';
            else $selected_size = 'full';
        }
        
        // WordPress resim URL'si oluştur
        $attachment_id = attachment_url_to_postid($image_url);
        if ($attachment_id) {
            $optimized_url = wp_get_attachment_image_url($attachment_id, $selected_size);
            if ($optimized_url) {
                // WebP formatına çevir
                if ($webp_support) {
                    $webp_url = $this->convert_to_webp($optimized_url, $quality);
                    if ($webp_url) {
                        return $webp_url;
                    }
                }
                return $optimized_url;
            }
        }
        
        // Eğer WordPress resmi değilse, external resim optimizasyonu
        return $this->optimize_external_image($image_url, $quality, $webp_support);
    }

    /**
     * WebP formatına çevir
     */
    private function convert_to_webp($image_url, $quality) {
        $upload_dir = wp_upload_dir();
        $image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_url);
        
        if (!file_exists($image_path)) {
            return false;
        }
        
        $webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image_path);
        $webp_url = str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $webp_path);
        
        // Eğer WebP dosyası zaten varsa
        if (file_exists($webp_path)) {
            return $webp_url;
        }
        
        // Resim türünü belirle
        $image_type = exif_imagetype($image_path);
        $source_image = null;
        
        switch ($image_type) {
            case IMAGETYPE_JPEG:
                $source_image = imagecreatefromjpeg($image_path);
                break;
            case IMAGETYPE_PNG:
                $source_image = imagecreatefrompng($image_path);
                break;
            default:
                return false;
        }
        
        if (!$source_image) {
            return false;
        }
        
        // WebP'ye çevir
        $result = imagewebp($source_image, $webp_path, $quality);
        imagedestroy($source_image);
        
        return $result ? $webp_url : false;
    }

    /**
     * External resim optimizasyonu
     */
    private function optimize_external_image($image_url, $quality, $webp_support) {
        if (empty($image_url)) {
            return '';
        }
        
        // Döngüyü engellemek için cache kontrolü
        $cache_key = 'image_optimize_' . md5($image_url . $quality . $webp_support);
        $cached_result = get_transient($cache_key);
        
        if ($cached_result !== false) {
            error_log('Link Meta Widget: Using cached optimized image: ' . $cached_result);
            return $cached_result;
        }
        
        // Resim boyutunu küçült
        $width = 300;
        $height = 200;
        
        // CORS sorununu çözmek için çalışan proxy servisleri
        $proxy_services = [
            // Ana proxy servisleri (güvenilir)
            'https://images.weserv.nl/?url=' . urlencode($image_url) . '&w=' . $width . '&h=' . $height . '&q=' . $quality . '&f=' . ($webp_support ? 'webp' : 'auto'),
            
            // Çalışan alternatif proxy servisleri
            'https://api.codetabs.com/v1/proxy?quest=' . urlencode($image_url),
            'https://cors.bridged.cc/' . $image_url,
            
            // Son çare: Orijinal URL (CORS hatası olabilir ama denenecek)
            $image_url
        ];
        
        $result = $image_url; // Varsayılan olarak orijinal URL
        
        // İlk çalışan proxy servisini kullan (maksimum 3 deneme)
        $max_attempts = min(3, count($proxy_services));
        for ($i = 0; $i < $max_attempts; $i++) {
            $proxy_url = $proxy_services[$i];
            
            if ($this->test_image_url($proxy_url)) {
                error_log('Link Meta Widget: Using proxy: ' . $proxy_url);
                $result = $proxy_url;
                break;
            }
            
            // Her deneme arasında kısa bekleme
            if ($i < $max_attempts - 1) {
                usleep(100000); // 0.1 saniye bekle
            }
        }
        
        // Sonucu cache'le (1 saat)
        set_transient($cache_key, $result, HOUR_IN_SECONDS);
        
        if ($result === $image_url) {
            error_log('Link Meta Widget: All proxies failed, using original URL: ' . $image_url);
        }
        
        return $result;
    }

    /**
     * Resim URL'sinin çalışıp çalışmadığını test et
     */
    private function test_image_url($url) {
        // URL'yi temizle
        $url = esc_url_raw($url);
        
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        
        // Döngüyü engellemek için cache kontrolü
        $cache_key = 'image_test_' . md5($url);
        $cached_result = get_transient($cache_key);
        
        if ($cached_result !== false) {
            error_log('Link Meta Widget: Using cached test result for ' . $url . ' - ' . ($cached_result ? 'SUCCESS' : 'FAILED'));
            return $cached_result;
        }
        
        // Önce HEAD isteği dene
        $response = wp_remote_head($url, [
            'timeout' => 5, // Timeout'u kısalt
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'headers' => [
                'Accept' => 'image/*,*/*;q=0.8',
                'Accept-Language' => 'tr-TR,tr;q=0.9,en;q=0.8',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive'
            ],
            'sslverify' => false,
            'redirection' => 1 // Yönlendirme sayısını azalt
        ]);
        
        if (is_wp_error($response)) {
            // HEAD başarısız olursa GET isteği dene (sadece ilk 512 byte)
            $response = wp_remote_get($url, [
                'timeout' => 5,
                'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'headers' => [
                    'Range' => 'bytes=0-511', // Sadece ilk 512 byte
                    'Accept' => 'image/*,*/*;q=0.8'
                ],
                'sslverify' => false,
                'redirection' => 1
            ]);
        }
        
        if (is_wp_error($response)) {
            error_log('Link Meta Widget: Proxy test failed for ' . $url . ' - ' . $response->get_error_message());
            // Başarısız sonucu 5 dakika cache'le
            set_transient($cache_key, false, 5 * MINUTE_IN_SECONDS);
            return false;
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        $content_type = wp_remote_retrieve_header($response, 'content-type');
        
        // 200-299 arası kodlar kabul edilir
        $is_success = ($response_code >= 200 && $response_code < 300);
        
        // İçerik türü kontrolü (daha esnek)
        $is_image = false;
        if ($content_type) {
            $is_image = (
                strpos($content_type, 'image/') === 0 || 
                strpos($content_type, 'application/octet-stream') === 0 ||
                strpos($content_type, 'binary') !== false
            );
        } else {
            // Content-Type yoksa, URL uzantısına bak
            $extension = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
            $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'ico'];
            $is_image = in_array($extension, $image_extensions);
        }
        
        $result = false;
        
        if ($is_success && $is_image) {
            error_log('Link Meta Widget: Proxy test successful for ' . $url . ' (Code: ' . $response_code . ', Type: ' . $content_type . ')');
            $result = true;
        } elseif ($url === $this->get_original_image_url($url)) {
            // Eğer proxy değilse ve orijinal URL ise, CORS hatası olsa bile kabul et
            error_log('Link Meta Widget: Accepting original URL despite potential CORS issues: ' . $url);
            $result = true;
        } else {
            error_log('Link Meta Widget: Proxy test failed for ' . $url . ' (Code: ' . $response_code . ', Type: ' . $content_type . ')');
        }
        
        // Sonucu cache'le (başarılı ise 1 saat, başarısız ise 5 dakika)
        $cache_duration = $result ? HOUR_IN_SECONDS : (5 * MINUTE_IN_SECONDS);
        set_transient($cache_key, $result, $cache_duration);
        
        return $result;
    }
    
    /**
     * Orijinal resim URL'sini al
     */
    private function get_original_image_url($url) {
        // Proxy URL'lerini temizle ve orijinal URL'yi bul
        $original_url = $url;
        
        // Weserv proxy'sini temizle
        if (strpos($url, 'images.weserv.nl/?url=') === 0) {
            $original_url = urldecode(substr($url, strpos($url, 'url=') + 4));
        }
        // Codetabs proxy'sini temizle
        elseif (strpos($url, 'api.codetabs.com/v1/proxy?quest=') === 0) {
            $original_url = urldecode(substr($url, strpos($url, 'quest=') + 6));
        }
        // Bridged proxy'sini temizle
        elseif (strpos($url, 'cors.bridged.cc/') === 0) {
            $original_url = substr($url, strlen('https://cors.bridged.cc/'));
        }
        // AllOrigins proxy'sini temizle
        elseif (strpos($url, 'api.allorigins.win/raw?url=') === 0) {
            $original_url = urldecode(substr($url, strpos($url, 'url=') + 4));
        }
        
        return $original_url;
    }
    
    /**
     * CORS hatası olan resimler için özel işlem
     */
    private function handle_cors_image($original_image, $optimized_image) {
        if (empty($original_image)) {
            return false;
        }
        
        // Döngüyü engellemek için cache kontrolü
        $cache_key = 'cors_handle_' . md5($original_image . $optimized_image);
        $cached_result = get_transient($cache_key);
        
        if ($cached_result !== false) {
            error_log('Link Meta Widget: Using cached CORS result: ' . $cached_result);
            return $cached_result;
        }
        
        $result = $optimized_image; // Varsayılan olarak optimize edilmiş resim
        
        // Eğer optimize edilmiş resim orijinal ile aynıysa, CORS hatası olabilir
        if ($original_image === $optimized_image) {
            // Yerel proxy'yi dene (sadece bir kez)
            $local_proxy_url = 'https://' . $_SERVER['HTTP_HOST'] . '/wp-content/plugins/elementor-ozel-tasarim/proxy.php?url=' . urlencode($original_image);
            
            // Yerel proxy'yi test et (timeout ile)
            if ($this->test_image_url($local_proxy_url)) {
                $result = $local_proxy_url;
                error_log('Link Meta Widget: Using local proxy for CORS: ' . $local_proxy_url);
            } else {
                // Yerel proxy de çalışmazsa, orijinal URL'yi döndür (CORS hatası olabilir)
                $result = $original_image;
                error_log('Link Meta Widget: CORS fallback to original URL: ' . $original_image);
            }
        }
        
        // Sonucu cache'le (30 dakika)
        set_transient($cache_key, $result, 30 * MINUTE_IN_SECONDS);
        
        return $result;
    }

    /**
     * Resim lazy loading özelliklerini ekle
     */
    private function get_image_attributes($image_url, $alt_text, $settings) {
        $attributes = [
            'src' => $image_url,
            'alt' => $alt_text,
            'class' => 'ozel-link-meta-resim-img'
        ];
        
        // Lazy loading
        if ($settings['lazy_loading'] === 'yes') {
            $attributes['loading'] = 'lazy';
            $attributes['decoding'] = 'async';
        }
        
        // WebP desteği için picture etiketi
        if ($settings['webp_destegi'] === 'yes') {
            $webp_url = $this->convert_to_webp($image_url, $settings['resim_kalitesi']['size'] ?? 85);
            if ($webp_url) {
                $attributes['data-webp'] = $webp_url;
            }
        }
        
        // Responsive resimler için srcset
        $attributes['srcset'] = $this->generate_srcset($image_url, $settings);
        
        return $attributes;
    }

    /**
     * Responsive resim srcset oluştur
     */
    private function generate_srcset($image_url, $settings) {
        $sizes = [
            '300w' => 300,
            '600w' => 600,
            '900w' => 900
        ];
        
        $srcset = [];
        foreach ($sizes as $descriptor => $width) {
            $optimized_url = $this->optimize_external_image($image_url, $settings['resim_kalitesi']['size'] ?? 85, false);
            $srcset[] = $optimized_url . ' ' . $descriptor;
        }
        
        return implode(', ', $srcset);
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

        $url = $settings['link_url']['url'];
        $target = $settings['link_url']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['link_url']['nofollow'] ? ' rel="nofollow"' : '';

        $meta_data = null;

        // Otomatik meta veri çekme
        if ($settings['otomatik_cek'] === 'yes') {
            // Önce çekilen veriyi kontrol et
            if (!empty($settings['cekilen_baslik'])) {
                $meta_data = [
                    'title' => $settings['cekilen_baslik'],
                    'description' => $settings['cekilen_aciklama'] ?: '',
                    'image' => !empty($settings['cekilen_resim']['url']) ? $settings['cekilen_resim']['url'] : '',
                    'url' => $url,
                    'domain' => parse_url($url, PHP_URL_HOST)
                ];
            } else {
                // Eğer çekilen veri yoksa, otomatik çek
                $meta_data = $this->get_meta_data($url);
                if ($meta_data && !empty($meta_data['title'])) {
                    // Çekilen veriyi ayarlara kaydet (bu sadece önizleme için)
                    $this->set_settings('cekilen_baslik', $meta_data['title']);
                    $this->set_settings('cekilen_aciklama', $meta_data['description']);
                    if (!empty($meta_data['image'])) {
                        $this->set_settings('cekilen_resim', ['url' => $meta_data['image']]);
                    }
                }
            }
        }

        // Manuel veriler veya otomatik çekme başarısız olduysa
        if (!$meta_data || empty($meta_data['title'])) {
            $meta_data = [
                'title' => $settings['manuel_baslik'] ?: __('Başlık Bulunamadı', 'elementor-ozel-tasarim'),
                'description' => $settings['manuel_aciklama'] ?: __('Açıklama bulunamadı.', 'elementor-ozel-tasarim'),
                'image' => !empty($settings['manuel_resim']['url']) ? $settings['manuel_resim']['url'] : '',
                'url' => $url,
                'domain' => parse_url($url, PHP_URL_HOST)
            ];
        }

        // Resim optimizasyonu
        $optimized_image = $this->optimize_image($meta_data['image'], $settings);
        
        // CORS hatası için özel işlem
        $final_image = $this->handle_cors_image($meta_data['image'], $optimized_image);
        $image_attributes = $this->get_image_attributes($final_image, $meta_data['title'], $settings);
        
        // Düzen sınıfları
        $layout_class = 'ozel-link-meta-' . $settings['resim_konumu'];
        $content_alignment = $settings['icerik_hizalama'] ?? 'sol';

        ?>
        <div class="ozel-link-meta <?php echo esc_attr($layout_class); ?>">
            <?php if (!empty($final_image)): ?>
                <div class="ozel-link-meta-resim">
                    <?php if ($settings['webp_destegi'] === 'yes' && !empty($image_attributes['data-webp'])): ?>
                        <picture>
                            <source srcset="<?php echo esc_url($image_attributes['data-webp']); ?>" type="image/webp">
                            <img <?php 
                                foreach ($image_attributes as $attr => $value) {
                                    if ($attr !== 'data-webp') {
                                        echo esc_attr($attr) . '="' . esc_attr($value) . '" ';
                                    }
                                }
                            ?>>
                        </picture>
                    <?php else: ?>
                        <img <?php 
                            foreach ($image_attributes as $attr => $value) {
                                echo esc_attr($attr) . '="' . esc_attr($value) . '" ';
                            }
                        ?>>
                    <?php endif; ?>
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
            
            if (settings.otomatik_cek === 'yes') {
                if (settings.cekilen_resim && settings.cekilen_resim.url) {
                    imageUrl = settings.cekilen_resim.url;
                }
                title = settings.cekilen_baslik || 'Başlık Bulunamadı';
                description = settings.cekilen_aciklama || '';
            } else {
                if (settings.manuel_resim && settings.manuel_resim.url) {
                    imageUrl = settings.manuel_resim.url;
                }
                title = settings.manuel_baslik || 'Başlık Bulunamadı';
                description = settings.manuel_aciklama || '';
            }
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
