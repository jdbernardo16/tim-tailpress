<?php

/**
 * Tell Your Story Section template part.
 *
 * @package TailPress
 */
?>

<section class="relative mx-10 rounded-3xl">
    <!-- Background layer with overflow hidden for effects -->
    <div class="absolute inset-0 bg-navy rounded-3xl overflow-hidden pointer-events-none">
        <!-- Decorative ellipses -->
        <!-- Deep blue ellipse -->
        <div class="absolute top-0 right-0 w-[1535px] h-[1535px] bg-deep-blue rounded-full blur-[620px] transform translate-x-1/3 -translate-y-1/3"></div>
        <!-- Gold ellipse -->
        <div class="absolute -top-[100%] right-[80%] w-[1525px] h-[1525px] bg-gold/70 rounded-full blur-[560px] transform "></div>
    </div>

    <!-- Watermark -->
    <div class="absolute top-0 left-0 right-0 flex justify-center pointer-events-none overflow-hidden pt-0">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-story-watermark.svg" alt="" class="w-full max-w-[1360px] h-auto opacity-20 select-none" aria-hidden="true">
    </div>

    <div class="relative flex flex-col items-center gap-16 py-24 lg:py-32 px-4 sm:px-6 lg:px-8">
        <!-- Text Content -->
        <div class="flex flex-col items-center gap-6 max-w-[750px] text-center">
            <h2 class="font-flatline font-semibold text-5xl lg:text-[56px] leading-[110%] text-white">
                Your Story <em class="text-gold italic">Changes</em> Rooms.
            </h2>
            <div class="text-body text-white max-w-[678px]">
                <p>
                    Tell Your Story is a <strong class="font-bold">transformational course and retreat experience</strong> where becoming a better speaker starts becoming a better leader.
                </p>
                <p class="mt-4">
                    It's about reconnecting with the moments that shaped your voice, your leadership, and the way people experience you.
                </p>
            </div>
            <div class="mt-2">
                <a href="<?php echo esc_url(home_url('/events/')); ?>" class="btn-primary">
                    START YOUR STORY
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/btn-arrow.svg" alt="" class="w-5 h-2" aria-hidden="true">
                </a>
            </div>
        </div>

        <!-- Image Carousel -->
        <div class="w-full max-w-[1854px]">
            <div class="swiper tell-story-swiper">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="relative w-full aspect-square rounded-[10px] overflow-hidden bg-black">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-story-1.webp" alt="Tell Your Story 1" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="relative w-full aspect-square rounded-[10px] overflow-hidden bg-black">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-story-2.webp" alt="Tell Your Story 2" class="w-full h-full object-cover">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 flex items-center justify-center bg-warm-beige/90 backdrop-blur-sm rotate-45 rounded-[5px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-navy -rotate-45 ml-0.5">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="relative w-full aspect-square rounded-[10px] overflow-hidden bg-black">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-story-3.webp" alt="Tell Your Story 3" class="w-full h-full object-cover">
                            <div class="absolute bottom-6 left-6 right-6">
                                <span class="font-flatline text-lg text-white italic">to be vulnerable</span>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <div class="relative w-full aspect-square rounded-[10px] overflow-hidden bg-black">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-story-4.webp" alt="Tell Your Story 4" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <!-- Slide 5 -->
                    <div class="swiper-slide">
                        <div class="relative w-full aspect-square rounded-[10px] overflow-hidden bg-black">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-story-5.webp" alt="Tell Your Story 5" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <!-- Slide 6 -->
                    <div class="swiper-slide">
                        <div class="relative w-full aspect-square rounded-[10px] overflow-hidden bg-black">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-story-1.webp" alt="Tell Your Story 6" class="w-full h-full object-cover">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 flex items-center justify-center bg-warm-beige/90 backdrop-blur-sm rotate-45 rounded-[5px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-navy -rotate-45 ml-0.5">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 7 -->
                    <div class="swiper-slide">
                        <div class="relative w-full aspect-square rounded-[10px] overflow-hidden bg-black">
                            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-story-2.webp" alt="Tell Your Story 7" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <div class="tell-story-nav">
                <button class="tell-story-swiper-button-prev tell-story-nav__btn" aria-label="Previous slide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </button>
                <button class="tell-story-swiper-button-next tell-story-nav__btn" aria-label="Next slide">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>