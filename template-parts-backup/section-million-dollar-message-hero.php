<?php

/**
 * Million Dollar Message Page - Hero Section template part.
 *
 * @package TailPress
 */
?>
<section class="relative bg-navy overflow-hidden">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/general-bg.webp" alt="" aria-hidden="true">
    </div>

    <!-- Decorative blurred ellipses -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
        <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-deep-blue/20 rounded-full blur-3xl transform translate-y-1/2"></div>
        <!-- Gold glow at bottom center -->
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[600px] h-[400px] bg-gold/30 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col items-center text-center">
        <!-- Pill Label -->
        <span class="inline-flex items-center font-flatline rounded-full bg-white/15 backdrop-blur-sm px-6 py-2 text-xs font-bold uppercase tracking-[0.3em] text-white">
            Million Dollar Message
        </span>

        <!-- Heading -->
        <h1 class="mt-8 font-flatline font-semibold text-4xl md:text-5xl lg:text-[64px] text-white leading-[1.1]">
            Your Message<br>Already <em class="text-gold italic">Exists.</em>
        </h1>

        <!-- Subheadline -->
        <p class="mt-6 font-flatline font-semibold text-lg text-white">
            You are closer to your message than you think.
        </p>

        <!-- Description -->
        <div class="mt-4 font-garet text-lg text-white leading-[1.6] max-w-[600px] space-y-3">
            <p>The problem is not that you do not have one.</p>
            <p>It is that you are too close to your own wisdom to see it clearly.</p>
            <p>This short training helps you uncover the defining message behind your work, the one that creates clarity, connection, and opportunity.</p>
            <p>7 minutes that may change how you explain everything you do.</p>
        </div>

        <!-- CTA -->
        <div class="mt-10">
            <a href="#inside" class="btn-primary">
                GET THE TRAINING — $29
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>

        <!-- Microcopy -->
        <div class="mt-6 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 font-garet text-sm text-white">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                </svg>
                7-minute training + guided homework
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                </svg>
                One-time payment
            </span>
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                </svg>
                7-day guarantee
            </span>
        </div>
    </div>
</section>
