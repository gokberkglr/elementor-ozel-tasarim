<?php
/**
 * Özel Portfolio Widget
 */

if (!defined('ABSPATH')) {
    exit; // Doğrudan erişimi engelle
}

class ElementorOzelPortfolioWidget extends \Elementor\Widget_Base {

    /**
     * Widget adı
     */
    public function get_name() {
        return 'ozel-portfolio-widget';
    }

    /**
     * Widget başlığı
     */
    public function get_title() {
        return __('Özel Portfolio', 'elementor-ozel-tasarim');
    }

    /**
     * Widget ikonu
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
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
        return ['portfolio', 'galeri', 'proje', 'özel', 'tasarım'];
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
            'portfolio_baslik',
            [
                'label' => __('Portfolio Başlığı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Portfolio', 'elementor-ozel-tasarim'),
                'placeholder' => __('Portfolio başlığını girin', 'elementor-ozel-tasarim'),
            ]
        );

        $this->add_control(
            'galeri_resimleri',
            [
                'label' => __('Galeri Resimleri', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'default' => [],
            ]
        );

        $this->add_control(
            'sutun_sayisi',
            [
                'label' => __('Sütun Sayısı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => __('1 Sütun', 'elementor-ozel-tasarim'),
                    '2' => __('2 Sütun', 'elementor-ozel-tasarim'),
                    '3' => __('3 Sütun', 'elementor-ozel-tasarim'),
                    '4' => __('4 Sütun', 'elementor-ozel-tasarim'),
                ],
            ]
        );

        $this->add_control(
            'resim_boyutu',
            [
                'label' => __('Resim Boyutu', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'thumbnail' => __('Küçük', 'elementor-ozel-tasarim'),
                    'medium' => __('Orta', 'elementor-ozel-tasarim'),
                    'large' => __('Büyük', 'elementor-ozel-tasarim'),
                    'full' => __('Tam Boyut', 'elementor-ozel-tasarim'),
                ],
            ]
        );

        $this->add_control(
            'hover_efekti',
            [
                'label' => __('Hover Efekti', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'zoom',
                'options' => [
                    'none' => __('Yok', 'elementor-ozel-tasarim'),
                    'zoom' => __('Yakınlaştır', 'elementor-ozel-tasarim'),
                    'fade' => __('Soluklaştır', 'elementor-ozel-tasarim'),
                    'slide' => __('Kaydır', 'elementor-ozel-tasarim'),
                ],
            ]
        );

        $this->add_control(
            'lightbox_aktif',
            [
                'label' => __('Lightbox Aktif', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Evet', 'elementor-ozel-tasarim'),
                'label_off' => __('Hayır', 'elementor-ozel-tasarim'),
                'return_value' => 'yes',
                'default' => 'yes',
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
            'portfolio_arka_renk',
            [
                'label' => __('Portfolio Arka Plan Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f8f9fa',
                'selectors' => [
                    '{{WRAPPER}} .ozel-portfolio' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'kart_arka_renk',
            [
                'label' => __('Kart Arka Plan Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ozel-portfolio-item' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .ozel-portfolio-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'resim_kenar_yuvarlakligi',
            [
                'label' => __('Resim Kenar Yuvarlaklığı', 'elementor-ozel-tasarim'),
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
                    '{{WRAPPER}} .ozel-portfolio-resim img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kart_golge',
                'label' => __('Kart Gölgesi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-portfolio-item',
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
                'selector' => '{{WRAPPER}} .ozel-portfolio-baslik',
            ]
        );

        $this->add_control(
            'baslik_renk',
            [
                'label' => __('Başlık Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ozel-portfolio-baslik' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Hover stili
        $this->start_controls_section(
            'hover_style_section',
            [
                'label' => __('Hover Stili', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hover_overlay_renk',
            [
                'label' => __('Hover Overlay Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.7)',
                'selectors' => [
                    '{{WRAPPER}} .ozel-portfolio-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_icon_renk',
            [
                'label' => __('Hover İkon Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ozel-portfolio-overlay i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Widget'ı render et
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['galeri_resimleri'])) {
            return;
        }

        $sutun_class = 'ozel-portfolio-' . $settings['sutun_sayisi'] . '-sutun';
        $hover_class = 'ozel-portfolio-hover-' . $settings['hover_efekti'];

        ?>
        <div class="ozel-portfolio">
            <?php if (!empty($settings['portfolio_baslik'])): ?>
                <h2 class="ozel-portfolio-baslik"><?php echo esc_html($settings['portfolio_baslik']); ?></h2>
            <?php endif; ?>
            
            <div class="ozel-portfolio-grid <?php echo esc_attr($sutun_class); ?>">
                <?php foreach ($settings['galeri_resimleri'] as $image): ?>
                    <div class="ozel-portfolio-item <?php echo esc_attr($hover_class); ?>">
                        <div class="ozel-portfolio-resim">
                            <?php if ($settings['lightbox_aktif'] === 'yes'): ?>
                                <a href="<?php echo esc_url($image['url']); ?>" data-lightbox="portfolio-gallery">
                                    <img src="<?php echo esc_url($image['sizes'][$settings['resim_boyutu']] ?? $image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    <div class="ozel-portfolio-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </a>
                            <?php else: ?>
                                <img src="<?php echo esc_url($image['sizes'][$settings['resim_boyutu']] ?? $image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Widget'ı içerik olarak render et
     */
    protected function _content_template() {
        ?>
        <div class="ozel-portfolio">
            <# if (settings.portfolio_baslik) { #>
                <h2 class="ozel-portfolio-baslik">{{{ settings.portfolio_baslik }}}</h2>
            <# } #>
            
            <div class="ozel-portfolio-grid ozel-portfolio-{{{ settings.sutun_sayisi }}}-sutun ozel-portfolio-hover-{{{ settings.hover_efekti }}}">
                <# if (settings.galeri_resimleri.length) { #>
                    <# _.each(settings.galeri_resimleri, function(image) { #>
                        <div class="ozel-portfolio-item">
                            <div class="ozel-portfolio-resim">
                                <# if (settings.lightbox_aktif === 'yes') { #>
                                    <a href="{{{ image.url }}}" data-lightbox="portfolio-gallery">
                                        <img src="{{{ image.sizes[settings.resim_boyutu] || image.url }}}" alt="{{{ image.alt }}}">
                                        <div class="ozel-portfolio-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </a>
                                <# } else { #>
                                    <img src="{{{ image.sizes[settings.resim_boyutu] || image.url }}}" alt="{{{ image.alt }}}">
                                <# } #>
                            </div>
                        </div>
                    <# }); #>
                <# } else { #>
                    <p><?php _e('Lütfen galeri resimleri ekleyin', 'elementor-ozel-tasarim'); ?></p>
                <# } #>
            </div>
        </div>
        <?php
    }
}
