import Swiper from "swiper";
import { Navigation, Autoplay } from "swiper/modules";

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
