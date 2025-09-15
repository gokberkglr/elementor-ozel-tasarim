<?php
/**
 * Özel Testimonial Widget
 */

if (!defined('ABSPATH')) {
    exit; // Doğrudan erişimi engelle
}

class ElementorOzelTestimonialWidget extends \Elementor\Widget_Base {

    /**
     * Widget adı
     */
    public function get_name() {
        return 'ozel-testimonial-widget';
    }

    /**
     * Widget başlığı
     */
    public function get_title() {
        return __('Özel Testimonial', 'elementor-ozel-tasarim');
    }

    /**
     * Widget ikonu
     */
    public function get_icon() {
        return 'eicon-testimonial';
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
        return ['testimonial', 'müşteri', 'yorum', 'özel', 'tasarım'];
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
            'testimonial_baslik',
            [
                'label' => __('Testimonial Başlığı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Müşteri Yorumları', 'elementor-ozel-tasarim'),
                'placeholder' => __('Testimonial başlığını girin', 'elementor-ozel-tasarim'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'musteri_adi',
            [
                'label' => __('Müşteri Adı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Müşteri Adı', 'elementor-ozel-tasarim'),
                'placeholder' => __('Müşteri adını girin', 'elementor-ozel-tasarim'),
            ]
        );

        $repeater->add_control(
            'musteri_unvan',
            [
                'label' => __('Müşteri Ünvanı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('CEO', 'elementor-ozel-tasarim'),
                'placeholder' => __('Müşteri ünvanını girin', 'elementor-ozel-tasarim'),
            ]
        );

        $repeater->add_control(
            'musteri_resmi',
            [
                'label' => __('Müşteri Resmi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'yorum_metni',
            [
                'label' => __('Yorum Metni', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __('Müşteri yorumu burada yer alacak.', 'elementor-ozel-tasarim'),
                'placeholder' => __('Yorum metnini girin', 'elementor-ozel-tasarim'),
            ]
        );

        $repeater->add_control(
            'yildiz_sayisi',
            [
                'label' => __('Yıldız Sayısı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '1' => '1 Yıldız',
                    '2' => '2 Yıldız',
                    '3' => '3 Yıldız',
                    '4' => '4 Yıldız',
                    '5' => '5 Yıldız',
                ],
            ]
        );

        $this->add_control(
            'testimonial_listesi',
            [
                'label' => __('Testimonial Listesi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'musteri_adi' => __('Ahmet Yılmaz', 'elementor-ozel-tasarim'),
                        'musteri_unvan' => __('CEO', 'elementor-ozel-tasarim'),
                        'yorum_metni' => __('Harika bir hizmet aldık. Kesinlikle tavsiye ederim.', 'elementor-ozel-tasarim'),
                        'yildiz_sayisi' => '5',
                    ],
                    [
                        'musteri_adi' => __('Ayşe Demir', 'elementor-ozel-tasarim'),
                        'musteri_unvan' => __('Pazarlama Müdürü', 'elementor-ozel-tasarim'),
                        'yorum_metni' => __('Profesyonel yaklaşım ve kaliteli çalışma.', 'elementor-ozel-tasarim'),
                        'yildiz_sayisi' => '5',
                    ],
                ],
                'title_field' => '{{{ musteri_adi }}}',
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
            'testimonial_arka_renk',
            [
                'label' => __('Testimonial Arka Plan Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f8f9fa',
                'selectors' => [
                    '{{WRAPPER}} .ozel-testimonial' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .ozel-testimonial-item' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .ozel-testimonial-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kart_golge',
                'label' => __('Kart Gölgesi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-testimonial-item',
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
                'selector' => '{{WRAPPER}} .ozel-testimonial-baslik',
            ]
        );

        $this->add_control(
            'baslik_renk',
            [
                'label' => __('Başlık Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ozel-testimonial-baslik' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Yorum stili
        $this->start_controls_section(
            'yorum_style_section',
            [
                'label' => __('Yorum Stili', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'yorum_typography',
                'label' => __('Yorum Tipografi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-testimonial-yorum',
            ]
        );

        $this->add_control(
            'yorum_renk',
            [
                'label' => __('Yorum Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .ozel-testimonial-yorum' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Müşteri stili
        $this->start_controls_section(
            'musteri_style_section',
            [
                'label' => __('Müşteri Stili', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'musteri_adi_typography',
                'label' => __('Müşteri Adı Tipografi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-testimonial-musteri-adi',
            ]
        );

        $this->add_control(
            'musteri_adi_renk',
            [
                'label' => __('Müşteri Adı Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ozel-testimonial-musteri-adi' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'musteri_unvan_typography',
                'label' => __('Müşteri Ünvanı Tipografi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-testimonial-musteri-unvan',
            ]
        );

        $this->add_control(
            'musteri_unvan_renk',
            [
                'label' => __('Müşteri Ünvanı Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#999999',
                'selectors' => [
                    '{{WRAPPER}} .ozel-testimonial-musteri-unvan' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Yıldız stili
        $this->start_controls_section(
            'yildiz_style_section',
            [
                'label' => __('Yıldız Stili', 'elementor-ozel-tasarim'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'yildiz_renk',
            [
                'label' => __('Yıldız Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffc107',
                'selectors' => [
                    '{{WRAPPER}} .ozel-testimonial-yildizlar' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'yildiz_boyutu',
            [
                'label' => __('Yıldız Boyutu', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ozel-testimonial-yildizlar' => 'font-size: {{SIZE}}{{UNIT}};',
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

        if (empty($settings['testimonial_listesi'])) {
            return;
        }

        $sutun_class = 'ozel-testimonial-' . $settings['sutun_sayisi'] . '-sutun';

        ?>
        <div class="ozel-testimonial">
            <?php if (!empty($settings['testimonial_baslik'])): ?>
                <h2 class="ozel-testimonial-baslik"><?php echo esc_html($settings['testimonial_baslik']); ?></h2>
            <?php endif; ?>
            
            <div class="ozel-testimonial-grid <?php echo esc_attr($sutun_class); ?>">
                <?php foreach ($settings['testimonial_listesi'] as $testimonial): ?>
                    <div class="ozel-testimonial-item">
                        <div class="ozel-testimonial-icerik">
                            <div class="ozel-testimonial-yildizlar">
                                <?php
                                $yildiz_sayisi = intval($testimonial['yildiz_sayisi']);
                                for ($i = 0; $i < 5; $i++) {
                                    if ($i < $yildiz_sayisi) {
                                        echo '<i class="fas fa-star"></i>';
                                    } else {
                                        echo '<i class="far fa-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                            
                            <p class="ozel-testimonial-yorum"><?php echo esc_html($testimonial['yorum_metni']); ?></p>
                            
                            <div class="ozel-testimonial-musteri">
                                <?php if (!empty($testimonial['musteri_resmi']['url'])): ?>
                                    <div class="ozel-testimonial-musteri-resim">
                                        <img src="<?php echo esc_url($testimonial['musteri_resmi']['url']); ?>" alt="<?php echo esc_attr($testimonial['musteri_adi']); ?>">
                                    </div>
                                <?php endif; ?>
                                
                                <div class="ozel-testimonial-musteri-bilgi">
                                    <h4 class="ozel-testimonial-musteri-adi"><?php echo esc_html($testimonial['musteri_adi']); ?></h4>
                                    <p class="ozel-testimonial-musteri-unvan"><?php echo esc_html($testimonial['musteri_unvan']); ?></p>
                                </div>
                            </div>
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
        <div class="ozel-testimonial">
            <# if (settings.testimonial_baslik) { #>
                <h2 class="ozel-testimonial-baslik">{{{ settings.testimonial_baslik }}}</h2>
            <# } #>
            
            <div class="ozel-testimonial-grid ozel-testimonial-{{{ settings.sutun_sayisi }}}-sutun">
                <# if (settings.testimonial_listesi.length) { #>
                    <# _.each(settings.testimonial_listesi, function(testimonial) { #>
                        <div class="ozel-testimonial-item">
                            <div class="ozel-testimonial-icerik">
                                <div class="ozel-testimonial-yildizlar">
                                    <# for (var i = 0; i < 5; i++) { #>
                                        <# if (i < parseInt(testimonial.yildiz_sayisi)) { #>
                                            <i class="fas fa-star"></i>
                                        <# } else { #>
                                            <i class="far fa-star"></i>
                                        <# } #>
                                    <# } #>
                                </div>
                                
                                <p class="ozel-testimonial-yorum">{{{ testimonial.yorum_metni }}}</p>
                                
                                <div class="ozel-testimonial-musteri">
                                    <# if (testimonial.musteri_resmi.url) { #>
                                        <div class="ozel-testimonial-musteri-resim">
                                            <img src="{{{ testimonial.musteri_resmi.url }}}" alt="{{{ testimonial.musteri_adi }}}">
                                        </div>
                                    <# } #>
                                    
                                    <div class="ozel-testimonial-musteri-bilgi">
                                        <h4 class="ozel-testimonial-musteri-adi">{{{ testimonial.musteri_adi }}}</h4>
                                        <p class="ozel-testimonial-musteri-unvan">{{{ testimonial.musteri_unvan }}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <# }); #>
                <# } else { #>
                    <p><?php _e('Lütfen testimonial ekleyin', 'elementor-ozel-tasarim'); ?></p>
                <# } #>
            </div>
        </div>
        <?php
    }
}
