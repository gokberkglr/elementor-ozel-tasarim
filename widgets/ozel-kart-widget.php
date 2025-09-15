<?php
/**
 * Özel Kart Widget
 */

if (!defined('ABSPATH')) {
    exit; // Doğrudan erişimi engelle
}

class ElementorOzelKartWidget extends \Elementor\Widget_Base {

    /**
     * Widget adı
     */
    public function get_name() {
        return 'ozel-kart-widget';
    }

    /**
     * Widget başlığı
     */
    public function get_title() {
        return __('Özel Kart', 'elementor-ozel-tasarim');
    }

    /**
     * Widget ikonu
     */
    public function get_icon() {
        return 'eicon-posts-grid';
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
        return ['kart', 'card', 'özel', 'tasarım'];
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
            'kart_baslik',
            [
                'label' => __('Kart Başlığı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Özel Kart Başlığı', 'elementor-ozel-tasarim'),
                'placeholder' => __('Kart başlığını girin', 'elementor-ozel-tasarim'),
            ]
        );

        $this->add_control(
            'kart_aciklama',
            [
                'label' => __('Kart Açıklaması', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Bu özel kart widget\'ının açıklamasıdır.', 'elementor-ozel-tasarim'),
                'placeholder' => __('Kart açıklamasını girin', 'elementor-ozel-tasarim'),
            ]
        );

        $this->add_control(
            'kart_resim',
            [
                'label' => __('Kart Resmi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'buton_metni',
            [
                'label' => __('Buton Metni', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Detayları Gör', 'elementor-ozel-tasarim'),
                'placeholder' => __('Buton metnini girin', 'elementor-ozel-tasarim'),
            ]
        );

        $this->add_control(
            'buton_linki',
            [
                'label' => __('Buton Linki', 'elementor-ozel-tasarim'),
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
                    '{{WRAPPER}} .ozel-kart' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'kart_kenar_yuvarlakligi',
            [
                'label' => __('Kenar Yuvarlaklığı', 'elementor-ozel-tasarim'),
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
                    '{{WRAPPER}} .ozel-kart' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kart_golge',
                'label' => __('Kart Gölgesi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-kart',
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
                'selector' => '{{WRAPPER}} .ozel-kart-baslik',
            ]
        );

        $this->add_control(
            'baslik_renk',
            [
                'label' => __('Başlık Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ozel-kart-baslik' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .ozel-kart-buton',
            ]
        );

        $this->add_control(
            'buton_arka_renk',
            [
                'label' => __('Buton Arka Plan Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .ozel-kart-buton' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .ozel-kart-buton' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .ozel-kart-buton' => 'border-radius: {{SIZE}}{{UNIT}};',
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

        $target = $settings['buton_linki']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['buton_linki']['nofollow'] ? ' rel="nofollow"' : '';

        ?>
        <div class="ozel-kart">
            <?php if (!empty($settings['kart_resim']['url'])): ?>
                <div class="ozel-kart-resim">
                    <img src="<?php echo esc_url($settings['kart_resim']['url']); ?>" alt="<?php echo esc_attr($settings['kart_baslik']); ?>">
                </div>
            <?php endif; ?>
            
            <div class="ozel-kart-icerik">
                <h3 class="ozel-kart-baslik"><?php echo esc_html($settings['kart_baslik']); ?></h3>
                <p class="ozel-kart-aciklama"><?php echo esc_html($settings['kart_aciklama']); ?></p>
                
                <?php if (!empty($settings['buton_metni']) && !empty($settings['buton_linki']['url'])): ?>
                    <a href="<?php echo esc_url($settings['buton_linki']['url']); ?>" class="ozel-kart-buton"<?php echo $target . $nofollow; ?>>
                        <?php echo esc_html($settings['buton_metni']); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    /**
     * Widget'ı içerik olarak render et
     */
    protected function _content_template() {
        ?>
        <div class="ozel-kart">
            <# if (settings.kart_resim.url) { #>
                <div class="ozel-kart-resim">
                    <img src="{{{ settings.kart_resim.url }}}" alt="{{{ settings.kart_baslik }}}">
                </div>
            <# } #>
            
            <div class="ozel-kart-icerik">
                <h3 class="ozel-kart-baslik">{{{ settings.kart_baslik }}}</h3>
                <p class="ozel-kart-aciklama">{{{ settings.kart_aciklama }}}</p>
                
                <# if (settings.buton_metni && settings.buton_linki.url) { #>
                    <a href="{{{ settings.buton_linki.url }}}" class="ozel-kart-buton">
                        {{{ settings.buton_metni }}}
                    </a>
                <# } #>
            </div>
        </div>
        <?php
    }
}
