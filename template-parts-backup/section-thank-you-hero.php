<?php
/**
 * Thank You Page - Hero Section template part.
 *
 * @package TailPress
 */
?>

<section class="relative bg-navy overflow-hidden min-h-[600px] md:min-h-[700px]">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/generic-bg.webp" alt="">
    </div>


    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 md:pt-32 pb-20 md:pb-24 text-center">
        <h1 class="font-flatline font-semibold text-6xl md:text-8xl lg:text-[112px] leading-[1.1] mb-0" style="background: linear-gradient(135deg, #e7d4c5, #d4b478); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            Thank You
        </h1>
        <h2 class="font-flatline font-semibold text-3xl md:text-4xl lg:text-5xl text-white leading-[1.1] mb-6">
            Your message work begins now.
        </h2>
        <p class="font-garet font-light text-lg text-white leading-[1.5] mb-10">
            A welcome email is on its way with access to your training and guided homework.
        </p>
        <a href="https://go.trueinfluencemethod.com/the-vault" class="inline-flex items-center justify-center gap-3 rounded-full px-6 py-4 font-flatline font-bold text-base text-navy no-underline transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg" style="background: radial-gradient(circle at center, #e7d4c5, #d4b478); border: 1px solid #e7d4c5;">
            BACK TO HOMEPAGE
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
</section>
