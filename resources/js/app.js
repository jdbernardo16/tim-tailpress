import Swiper from "swiper";
import { Navigation, Autoplay } from "swiper/modules";

// Mobile menu controller — runs on DOMContentLoaded equivalent
(function () {
    var toggle = document.getElementById('header-mobile-toggle');
    var menu = document.getElementById('header-mobile-menu');
    var iconOpen = document.getElementById('header-mobile-toggle-open');
    var iconClose = document.getElementById('header-mobile-toggle-close');
    var siteHeader = document.getElementById('site-header');

    if (!toggle || !menu) return;

    function setMenuOpen(open) {
        menu.classList.toggle('hidden', !open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('overflow-hidden', open);
        if (iconOpen) iconOpen.classList.toggle('hidden', open);
        if (iconClose) iconClose.classList.toggle('hidden', !open);
    }

    toggle.addEventListener('click', function () {
        var open = toggle.getAttribute('aria-expanded') !== 'true';
        setMenuOpen(open);
        if (open) {
            var firstLink = menu.querySelector('a');
            if (firstLink) firstLink.focus();
        }
    });

    menu.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () {
            setMenuOpen(false);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setMenuOpen(false);
            toggle.focus();
        }
    });

    // Scroll header background
    if (siteHeader) {
        function updateHeader() {
            if (window.scrollY > 10) {
                siteHeader.classList.add('bg-navy/95', 'backdrop-blur-sm');
            } else {
                siteHeader.classList.remove('bg-navy/95', 'backdrop-blur-sm');
            }
        }
        window.addEventListener('scroll', updateHeader, { passive: true });
        updateHeader();
    }
})();

window.addEventListener("load", function () {
    let mainNavigation = document.getElementById("primary-navigation");
    let mainNavigationToggle = document.getElementById("primary-menu-toggle");

    if (mainNavigation && mainNavigationToggle) {
        mainNavigationToggle.addEventListener("click", function (e) {
            e.preventDefault();
            mainNavigation.classList.toggle("hidden");
        });
    }

    // About Meaning Carousel
    const aboutMeaningSwiper = document.querySelector(".about-meaning-swiper");
    if (aboutMeaningSwiper) {
        new Swiper(aboutMeaningSwiper, {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: 16,
            loop: true,
            grabCursor: true,
            navigation: {
                nextEl: ".about-meaning-swiper-button-next",
                prevEl: ".about-meaning-swiper-button-prev",
            },
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 16,
                },
            },
        });
    }

    // On Stage Credibility Featured Carousel
    const onstageCredibilityFeaturedSwiper = document.querySelector(".onstage-credibility-featured-swiper");
    if (onstageCredibilityFeaturedSwiper) {
        new Swiper(onstageCredibilityFeaturedSwiper, {
            modules: [Navigation],
            slidesPerView: 1,
            spaceBetween: 0,
            loop: true,
            grabCursor: true,
            navigation: {
                nextEl: ".onstage-credibility-featured-swiper-button-next",
                prevEl: ".onstage-credibility-featured-swiper-button-prev",
            },
        });
    }

    // Tell Your Story Carousel
    const tellStorySwiper = document.querySelector(".tell-story-swiper");
    if (tellStorySwiper) {
        new Swiper(tellStorySwiper, {
            modules: [Navigation, Autoplay],
            slidesPerView: 1,
            spaceBetween: 16,
            loop: true,
            grabCursor: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            navigation: {
                nextEl: ".tell-story-swiper-button-next",
                prevEl: ".tell-story-swiper-button-prev",
            },
            breakpoints: {
                480: {
                    slidesPerView: 2,
                    spaceBetween: 16,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 16,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 16,
                },
                1280: {
                    slidesPerView: 5,
                    spaceBetween: 16,
                },
            },
        });
    }
});
