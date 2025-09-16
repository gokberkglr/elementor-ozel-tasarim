/**
 * Elementor Özel Tasarım Widget'ları - Editor JavaScript Dosyası
 */

(function($) {
    'use strict';

    // Elementor editor yüklendiğinde çalışacak fonksiyonlar
    $(document).ready(function() {
        if (typeof elementor !== 'undefined') {
            initElementorEditor();
        }
    });

    /**
     * Elementor editor işlevselliği
     */
    function initElementorEditor() {
        // Widget kategorisi ekle
        addWidgetCategory();
        
        // Widget önizleme işlevselliği
        initWidgetPreview();
        
        // Widget ayarları işlevselliği
        initWidgetSettings();
        
        // Widget yardım işlevselliği
        initWidgetHelp();
    }

    /**
     * Widget kategorisi ekle
     */
    function addWidgetCategory() {
        if (typeof elementor.hooks !== 'undefined') {
            elementor.hooks.addFilter('elementor/elements/categories', function(categories) {
                categories.push({
                    name: 'ozel-tasarim',
                    title: 'Özel Tasarım',
                    icon: 'eicon-apps'
                });
                return categories;
            });
        }
    }

    /**
     * Widget önizleme işlevselliği
     */
    function initWidgetPreview() {
        // Widget önizleme güncelleme
        $(document).on('elementor/popup/show', function() {
            updateWidgetPreviews();
        });

        // Widget ayarları değiştiğinde önizlemeyi güncelle
        $(document).on('change', '.elementor-control input, .elementor-control select, .elementor-control textarea', function() {
            const $widget = $(this).closest('.elementor-element');
            if ($widget.hasClass('elementor-widget-ozel-kart-widget') ||
                $widget.hasClass('elementor-widget-ozel-blog-widget') ||
                $widget.hasClass('elementor-widget-ozel-portfolio-widget') ||
                $widget.hasClass('elementor-widget-ozel-testimonial-widget')) {
                updateWidgetPreview($widget);
            }
        });
    }

    /**
     * Widget önizlemesini güncelle
     */
    function updateWidgetPreview($widget) {
        // Widget türüne göre önizleme güncelleme
        if ($widget.hasClass('elementor-widget-ozel-kart-widget')) {
            updateKartPreview($widget);
        } else if ($widget.hasClass('elementor-widget-ozel-blog-widget')) {
            updateBlogPreview($widget);
        } else if ($widget.hasClass('elementor-widget-ozel-portfolio-widget')) {
            updatePortfolioPreview($widget);
        } else if ($widget.hasClass('elementor-widget-ozel-testimonial-widget')) {
            updateTestimonialPreview($widget);
        }
    }

    /**
     * Kart widget önizlemesini güncelle
     */
    function updateKartPreview($widget) {
        const $preview = $widget.find('.elementor-widget-container');
        
        // Başlık güncelleme
        const baslik = $widget.find('input[data-setting="kart_baslik"]').val();
        $preview.find('.ozel-kart-baslik').text(baslik || 'Özel Kart Başlığı');
        
        // Açıklama güncelleme
        const aciklama = $widget.find('textarea[data-setting="kart_aciklama"]').val();
        $preview.find('.ozel-kart-aciklama').text(aciklama || 'Bu özel kart widget\'ının açıklamasıdır.');
        
        // Resim güncelleme
        const resim = $widget.find('input[data-setting="kart_resim"]').val();
        if (resim) {
            $preview.find('.ozel-kart-resim img').attr('src', resim);
        }
        
        // Buton güncelleme
        const butonMetni = $widget.find('input[data-setting="buton_metni"]').val();
        $preview.find('.ozel-kart-buton').text(butonMetni || 'Detayları Gör');
    }

    /**
     * Blog widget önizlemesini güncelle
     */
    function updateBlogPreview($widget) {
        const $preview = $widget.find('.elementor-widget-container');
        
        // Başlık güncelleme
        const baslik = $widget.find('input[data-setting="blog_baslik"]').val();
        $preview.find('.ozel-blog-baslik').text(baslik || 'Son Yazılar');
        
        // Yazı sayısı güncelleme
        const yaziSayisi = $widget.find('input[data-setting="yazi_sayisi"]').val();
        $preview.find('.ozel-blog-grid').attr('data-count', yaziSayisi);
    }

    /**
     * Portfolio widget önizlemesini güncelle
     */
    function updatePortfolioPreview($widget) {
        const $preview = $widget.find('.elementor-widget-container');
        
        // Başlık güncelleme
        const baslik = $widget.find('input[data-setting="portfolio_baslik"]').val();
        $preview.find('.ozel-portfolio-baslik').text(baslik || 'Portfolio');
        
        // Sütun sayısı güncelleme
        const sutunSayisi = $widget.find('select[data-setting="sutun_sayisi"]').val();
        $preview.find('.ozel-portfolio-grid').removeClass('ozel-portfolio-1-sutun ozel-portfolio-2-sutun ozel-portfolio-3-sutun ozel-portfolio-4-sutun');
        $preview.find('.ozel-portfolio-grid').addClass('ozel-portfolio-' + sutunSayisi + '-sutun');
    }

    /**
     * Testimonial widget önizlemesini güncelle
     */
    function updateTestimonialPreview($widget) {
        const $preview = $widget.find('.elementor-widget-container');
        
        // Başlık güncelleme
        const baslik = $widget.find('input[data-setting="testimonial_baslik"]').val();
        $preview.find('.ozel-testimonial-baslik').text(baslik || 'Müşteri Yorumları');
        
        // Sütun sayısı güncelleme
        const sutunSayisi = $widget.find('select[data-setting="sutun_sayisi"]').val();
        $preview.find('.ozel-testimonial-grid').removeClass('ozel-testimonial-1-sutun ozel-testimonial-2-sutun ozel-testimonial-3-sutun');
        $preview.find('.ozel-testimonial-grid').addClass('ozel-testimonial-' + sutunSayisi + '-sutun');
    }

    /**
     * Widget ayarları işlevselliği
     */
    function initWidgetSettings() {
        // Widget ayarları değiştiğinde
        $(document).on('change', '.elementor-control', function() {
            const $control = $(this);
            const setting = $control.data('setting');
            const value = $control.val();
            
            // Ayarları localStorage'da sakla
            if (setting) {
                localStorage.setItem('elementor_ozel_tasarim_' + setting, value);
            }
        });

        // Widget ayarlarını yükle
        loadWidgetSettings();
    }

    /**
     * Widget ayarlarını yükle
     */
    function loadWidgetSettings() {
        $('.elementor-control').each(function() {
            const $control = $(this);
            const setting = $control.data('setting');
            
            if (setting) {
                const savedValue = localStorage.getItem('elementor_ozel_tasarim_' + setting);
                if (savedValue) {
                    $control.val(savedValue).trigger('change');
                }
            }
        });
    }

    /**
     * Widget yardım işlevselliği
     */
    function initWidgetHelp() {
        // Yardım butonları ekle
        $('.elementor-control').each(function() {
            const $control = $(this);
            const setting = $control.data('setting');
            
            if (setting && getHelpText(setting)) {
                addHelpButton($control, setting);
            }
        });
    }

    /**
     * Yardım butonu ekle
     */
    function addHelpButton($control, setting) {
        const helpText = getHelpText(setting);
        if (helpText) {
            const $helpButton = $('<span class="elementor-control-help" title="' + helpText + '">?</span>');
            $control.after($helpButton);
        }
    }

    /**
     * Yardım metni al
     */
    function getHelpText(setting) {
        const helpTexts = {
            'kart_baslik': 'Kartın başlığını buraya yazın',
            'kart_aciklama': 'Kartın açıklamasını buraya yazın',
            'kart_resim': 'Kart için resim seçin',
            'buton_metni': 'Buton üzerinde görünecek metni yazın',
            'buton_linki': 'Butonun yönlendireceği linki girin',
            'blog_baslik': 'Blog bölümünün başlığını yazın',
            'yazi_sayisi': 'Gösterilecek yazı sayısını belirleyin',
            'portfolio_baslik': 'Portfolio bölümünün başlığını yazın',
            'galeri_resimleri': 'Portfolio için resimleri seçin',
            'testimonial_baslik': 'Testimonial bölümünün başlığını yazın'
        };
        
        return helpTexts[setting] || '';
    }

    /**
     * Widget önizleme güncelleme
     */
    function updateWidgetPreviews() {
        $('.elementor-widget-ozel-kart-widget, .elementor-widget-ozel-blog-widget, .elementor-widget-ozel-portfolio-widget, .elementor-widget-ozel-testimonial-widget').each(function() {
            updateWidgetPreview($(this));
        });
    }

    /**
     * Widget kategorisi stil ayarları
     */
    function addWidgetCategoryStyles() {
        const style = `
            <style>
                .elementor-element[data-widget_type*="ozel-"] .elementor-widget-container {
                    border: 2px dashed #ddd;
                    padding: 20px;
                    text-align: center;
                    background: #f9f9f9;
                }
                
                .elementor-element[data-widget_type*="ozel-"]:hover .elementor-widget-container {
                    border-color: #007cba;
                    background: #f0f8ff;
                }
                
                .elementor-control-help {
                    display: inline-block;
                    width: 20px;
                    height: 20px;
                    background: #007cba;
                    color: white;
                    border-radius: 50%;
                    text-align: center;
                    line-height: 20px;
                    font-size: 12px;
                    cursor: help;
                    margin-left: 5px;
                }
            </style>
        `;
        
        $('head').append(style);
    }

    // Stil ayarlarını ekle
    addWidgetCategoryStyles();

    /**
     * Link Meta Veri Çekme Fonksiyonu
     */
    function initLinkMetaCekme() {
        // Döngüyü engellemek için işlem durumu takibi
        let isProcessing = false;
        let lastProcessedUrl = '';
        
        // Veri çek butonuna tıklandığında
        $(document).on('click', '[data-event="ozel_link_meta_cek"]', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const $widget = $button.closest('.elementor-element');
            const urlInput = $widget.find('input[data-setting="link_url"]').val();
            
            if (!urlInput) {
                showStatusMessage('Lütfen önce bir URL girin', 'error');
                return;
            }
            
            // Döngü kontrolü
            if (isProcessing) {
                showStatusMessage('İşlem devam ediyor, lütfen bekleyin...', 'loading');
                return;
            }
            
            // Aynı URL tekrar işleniyorsa engelle
            if (lastProcessedUrl === urlInput) {
                showStatusMessage('Bu URL zaten işlendi, farklı bir URL deneyin', 'error');
                return;
            }
            
            // İşlem durumunu işaretle
            isProcessing = true;
            lastProcessedUrl = urlInput;
            
            // Loading durumu
            $button.text('Veri Çekiliyor...').prop('disabled', true);
            showStatusMessage('Veri çekiliyor...', 'loading', 'URL: ' + urlInput);
            
            // AJAX ile veri çek
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'ozel_link_meta_cek',
                    url: urlInput,
                    nonce: elementorCommon.config.ajax.nonce
                },
                timeout: 15000, // 15 saniye timeout (döngüyü engellemek için kısaltıldı)
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        
                        // Çekilen veriyi form alanlarına doldur
                        const $baslikInput = $widget.find('input[data-setting="baslik"]');
                        const $aciklamaInput = $widget.find('textarea[data-setting="aciklama"]');
                        
                        if ($baslikInput.length) {
                            $baslikInput.val(data.title).trigger('input');
                        }
                        
                        if ($aciklamaInput.length) {
                            $aciklamaInput.val(data.description).trigger('input');
                        }
                        
                        if (data.image) {
                            // Resim URL input alanını güncelle
                            const $resimUrlInput = $widget.find('input[data-setting="resim_url"]');
                            if ($resimUrlInput.length) {
                                $resimUrlInput.val(data.image).trigger('input');
                            }
                        }
                        
                        // Widget önizlemesini güncelle
                        updateWidgetPreview($widget);
                        
                        // Başarı mesajı
                        let successMessage = 'Meta veriler başarıyla çekildi!';
                        let successDetails = 'Başlık: ' + data.title;
                        
                        if (data.image) {
                            successDetails += ' | Resim: Var';
                            if (data.image_optimized) {
                                successDetails += ' (Optimize edildi)';
                            }
                        } else {
                            successDetails += ' | Resim: Yok';
                        }
                        
                        if (data.domain) {
                            successDetails += ' | Domain: ' + data.domain;
                        }
                        
                        showStatusMessage(successMessage, 'success', successDetails);
                    } else {
                        const errorData = response.data || {};
                        let errorMessage = 'Veri çekilemedi';
                        let errorDetails = '';
                        
                        if (errorData.error) {
                            errorMessage = errorData.error;
                        }
                        
                        if (errorData.possible_causes) {
                            errorDetails = 'Olası nedenler: ' + errorData.possible_causes.join(', ');
                        }
                        
                        if (errorData.suggestions) {
                            errorDetails += '\nÖneriler: ' + errorData.suggestions.join(', ');
                        }
                        
                        if (errorData.debug) {
                            errorDetails += '\nDebug: ' + JSON.stringify(errorData.debug, null, 2);
                        }
                        
                        showStatusMessage(errorMessage, 'error', errorDetails);
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Veri çekilirken bir hata oluştu';
                    let errorDetails = '';
                    
                    if (status === 'timeout') {
                        errorMessage = 'İstek zaman aşımına uğradı';
                        errorDetails = 'Site yanıt vermiyor olabilir. Lütfen farklı bir URL deneyin.';
                    } else if (xhr.status === 0) {
                        errorMessage = 'Bağlantı hatası';
                        errorDetails = 'İnternet bağlantınızı kontrol edin veya proxy servisleri çalışmıyor olabilir. CORS hatası da olabilir.';
                    } else if (xhr.status === 403) {
                        errorMessage = 'Erişim engellendi';
                        errorDetails = 'Site bu tür isteklere izin vermiyor. Manuel veri girişi yapabilirsiniz.';
                    } else if (xhr.status === 404) {
                        errorMessage = 'Sayfa bulunamadı';
                        errorDetails = 'URL doğru değil veya sayfa mevcut değil.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Sunucu hatası';
                        errorDetails = 'Hedef sitede bir sorun var. Daha sonra tekrar deneyin.';
                    } else {
                        errorDetails = 'HTTP ' + xhr.status + ': ' + error;
                    }
                    
                    // Debug bilgileri ekle
                    errorDetails += '\n\nDebug Bilgileri:';
                    errorDetails += '\nStatus: ' + status;
                    errorDetails += '\nError: ' + error;
                    errorDetails += '\nResponse: ' + (xhr.responseText ? xhr.responseText.substring(0, 200) + '...' : 'Boş yanıt');
                    
                    showStatusMessage(errorMessage, 'error', errorDetails);
                },
                complete: function() {
                    $button.text('Meta Verileri Çek').prop('disabled', false);
                    // İşlem durumunu sıfırla
                    isProcessing = false;
                }
            });
        });
    }


    /**
     * Durum mesajı göster
     */
    function showStatusMessage(message, type, details) {
        const $statusDiv = $('#veri-cek-durumu');
        const $messageDiv = $('#veri-cek-mesaj');
        const $detailsDiv = $('#veri-cek-detay');
        
        if ($statusDiv.length) {
            $statusDiv.show();
            $messageDiv.text(message);
            
            if (details) {
                // Uzun detayları daha okunabilir hale getir
                const formattedDetails = details.replace(/\n/g, '<br>');
                $detailsDiv.html(formattedDetails);
            } else {
                $detailsDiv.text('');
            }
            
            // Tip'e göre stil
            $statusDiv.removeClass('success error loading');
            $statusDiv.addClass(type);
            
            // CSS stilleri ekle
            $statusDiv.css({
                'padding': '15px',
                'border-radius': '5px',
                'margin': '10px 0',
                'font-size': '14px',
                'line-height': '1.4'
            });
            
            if (type === 'success') {
                $statusDiv.css({
                    'background-color': '#d4edda',
                    'border': '1px solid #c3e6cb',
                    'color': '#155724'
                });
                // Başarılı ise 5 saniye sonra gizle
                setTimeout(() => {
                    $statusDiv.fadeOut();
                }, 5000);
            } else if (type === 'error') {
                $statusDiv.css({
                    'background-color': '#f8d7da',
                    'border': '1px solid #f5c6cb',
                    'color': '#721c24'
                });
                // Hata mesajı 10 saniye sonra gizle
                setTimeout(() => {
                    $statusDiv.fadeOut();
                }, 10000);
            } else if (type === 'loading') {
                $statusDiv.css({
                    'background-color': '#d1ecf1',
                    'border': '1px solid #bee5eb',
                    'color': '#0c5460'
                });
            }
        } else {
            // Fallback alert
            alert(message + (details ? '\n' + details : ''));
        }
    }

    /**
     * Widget önizleme güncelleme olayları
     */
    $(document).on('elementor/frontend/init', function() {
        // Frontend yüklendiğinde çalışacak kodlar
        console.log('Elementor Özel Tasarım Widget\'ları frontend\'de yüklendi');
    });

    /**
     * Widget editör olayları
     */
    $(document).on('elementor/editor/init', function() {
        // Editör yüklendiğinde çalışacak kodlar
        console.log('Elementor Özel Tasarım Widget\'ları editörde yüklendi');
        initLinkMetaCekme();
    });

})(jQuery);
