(() => {
    if (typeof Swiper === 'undefined') return false;
    if (!document.querySelectorAll('.news-carousel-list').length) return false;

    const getTotalWidth = function (swiper) {
        let width = 0;
        swiper.$el[0]
            .querySelectorAll('.swiper-slide')
            .forEach(function (element) {
                width += element.offsetWidth;
            });
        return width;
    };

    document.querySelectorAll('.news-carousel-list').forEach((carousel) => {
        const default_carousel_settings = {
            slidesPerView: 'auto',
            simulateTouch: false,
            navigation: {
                nextEl: carousel.closest('.latest-news').querySelector('.latest-news-navigation-next'),
                prevEl: carousel.closest('.latest-news').querySelector('.latest-news-navigation-prev')
            },  
            pagination: {
                el: carousel.closest('.latest-news').querySelector('.latest-news-pagination'),
                type: 'bullets',
            },
            on: {
                beforeInit: (swiper) => {
                    if (
                        swiper.$el[0].querySelectorAll('.swiper-slide')
                            .length === 0
                    ) {
                        return;
                    }

                    while (getTotalWidth(swiper) < window.innerWidth && default_carousel_settings.loop == true) {
                        swiper.$el[0]
                            .querySelectorAll('.swiper-slide')
                            .forEach(function (element) {
                                const clone = element.cloneNode(true);
                                swiper.$el[0]
                                    .querySelectorAll('.swiper-wrapper')[0]
                                    .appendChild(clone);
                            });
                    }
                },
            },
        }

        if(parseInt(carousel.dataset.autoplay)){
            default_carousel_settings.autoplay = {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            };
        }

        if (parseInt(carousel.dataset.loop)) {
            default_carousel_settings.loop = true;
        } else {
            default_carousel_settings.loop = false;
        }

        const custom_carousel_settings = carousel.dataset.settings ? JSON.parse(carousel.dataset.settings) : {};
        const carousel_settings = Object.assign(default_carousel_settings, custom_carousel_settings);

        new Swiper(carousel, carousel_settings);
    });
})();