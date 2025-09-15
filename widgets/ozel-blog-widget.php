<?php
/**
 * Özel Blog Widget
 */

if (!defined('ABSPATH')) {
    exit; // Doğrudan erişimi engelle
}

class ElementorOzelBlogWidget extends \Elementor\Widget_Base {

    /**
     * Widget adı
     */
    public function get_name() {
        return 'ozel-blog-widget';
    }

    /**
     * Widget başlığı
     */
    public function get_title() {
        return __('Özel Blog', 'elementor-ozel-tasarim');
    }

    /**
     * Widget ikonu
     */
    public function get_icon() {
        return 'eicon-posts-ticker';
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
        return ['blog', 'yazı', 'özel', 'tasarım'];
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
            'blog_baslik',
            [
                'label' => __('Blog Başlığı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Son Yazılar', 'elementor-ozel-tasarim'),
                'placeholder' => __('Blog başlığını girin', 'elementor-ozel-tasarim'),
            ]
        );

        $this->add_control(
            'yazi_sayisi',
            [
                'label' => __('Gösterilecek Yazı Sayısı', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' => 12,
            ]
        );

        $this->add_control(
            'kategori_filtresi',
            [
                'label' => __('Kategori Filtresi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_blog_categories(),
                'multiple' => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'siralama',
            [
                'label' => __('Sıralama', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => __('Tarihe Göre', 'elementor-ozel-tasarim'),
                    'title' => __('Başlığa Göre', 'elementor-ozel-tasarim'),
                    'comment_count' => __('Yorum Sayısına Göre', 'elementor-ozel-tasarim'),
                    'rand' => __('Rastgele', 'elementor-ozel-tasarim'),
                ],
            ]
        );

        $this->add_control(
            'aciklama_uzunlugu',
            [
                'label' => __('Açıklama Uzunluğu', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 150,
                'min' => 50,
                'max' => 500,
            ]
        );

        $this->add_control(
            'devamini_oku_metni',
            [
                'label' => __('Devamını Oku Metni', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Devamını Oku', 'elementor-ozel-tasarim'),
                'placeholder' => __('Devamını oku metnini girin', 'elementor-ozel-tasarim'),
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
            'blog_arka_renk',
            [
                'label' => __('Blog Arka Plan Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f8f9fa',
                'selectors' => [
                    '{{WRAPPER}} .ozel-blog' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .ozel-blog-item' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .ozel-blog-item' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'kart_golge',
                'label' => __('Kart Gölgesi', 'elementor-ozel-tasarim'),
                'selector' => '{{WRAPPER}} .ozel-blog-item',
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
                'selector' => '{{WRAPPER}} .ozel-blog-baslik',
            ]
        );

        $this->add_control(
            'baslik_renk',
            [
                'label' => __('Başlık Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ozel-blog-baslik' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .ozel-blog-buton',
            ]
        );

        $this->add_control(
            'buton_arka_renk',
            [
                'label' => __('Buton Arka Plan Rengi', 'elementor-ozel-tasarim'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#007cba',
                'selectors' => [
                    '{{WRAPPER}} .ozel-blog-buton' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .ozel-blog-buton' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Blog kategorilerini getir
     */
    private function get_blog_categories() {
        $categories = get_categories();
        $options = [];
        
        foreach ($categories as $category) {
            $options[$category->term_id] = $category->name;
        }
        
        return $options;
    }

    /**
     * Widget'ı render et
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $args = [
            'post_type' => 'post',
            'posts_per_page' => $settings['yazi_sayisi'],
            'orderby' => $settings['siralama'],
            'order' => 'DESC',
            'post_status' => 'publish',
        ];

        if (!empty($settings['kategori_filtresi'])) {
            $args['cat'] = implode(',', $settings['kategori_filtresi']);
        }

        $query = new WP_Query($args);

        ?>
        <div class="ozel-blog">
            <?php if (!empty($settings['blog_baslik'])): ?>
                <h2 class="ozel-blog-baslik"><?php echo esc_html($settings['blog_baslik']); ?></h2>
            <?php endif; ?>
            
            <div class="ozel-blog-grid">
                <?php if ($query->have_posts()): ?>
                    <?php while ($query->have_posts()): $query->the_post(); ?>
                        <div class="ozel-blog-item">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="ozel-blog-resim">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="ozel-blog-icerik">
                                <h3 class="ozel-blog-item-baslik">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="ozel-blog-meta">
                                    <span class="ozel-blog-tarih"><?php echo get_the_date(); ?></span>
                                    <span class="ozel-blog-kategori"><?php the_category(', '); ?></span>
                                </div>
                                
                                <div class="ozel-blog-aciklama">
                                    <?php echo wp_trim_words(get_the_excerpt(), $settings['aciklama_uzunlugu'], '...'); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="ozel-blog-buton">
                                    <?php echo esc_html($settings['devamini_oku_metni']); ?>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p><?php _e('Henüz yazı bulunmuyor.', 'elementor-ozel-tasarim'); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php

        wp_reset_postdata();
    }

    /**
     * Widget'ı içerik olarak render et
     */
    protected function _content_template() {
        ?>
        <div class="ozel-blog">
            <# if (settings.blog_baslik) { #>
                <h2 class="ozel-blog-baslik">{{{ settings.blog_baslik }}}</h2>
            <# } #>
            
            <div class="ozel-blog-grid">
                <p><?php _e('Blog yazıları burada görünecek', 'elementor-ozel-tasarim'); ?></p>
            </div>
        </div>
        <?php
    }
}
