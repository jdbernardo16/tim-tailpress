<?php

/**
 * Build My Team Page - Hero Section template part.
 *
 * @package TailPress
 */
?>
<section class="relative bg-navy overflow-hidden">
    <!-- Background texture -->
    <div class="absolute inset-0">
        <img class="w-full h-full object-cover" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/service-bg.webp" alt="" aria-hidden="true">
    </div>



    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 flex flex-col items-center text-center">
        <!-- Pill Label -->
        <span class="inline-flex items-center font-flatline rounded-full bg-white/15 backdrop-blur-sm px-6 py-2 text-xs font-bold uppercase tracking-[0.3em] text-warm-beige">
            Build My Team
        </span>

        <!-- Heading -->
        <h1 class="mt-8 font-flatline font-semibold text-5xl md:text-6xl lg:text-[64px] text-white leading-[1.1]">
            Build Leaders.<br><em class="text-gold italic">Not Just Results.</em>
        </h1>

        <!-- Description -->
        <div class="mt-6 font-garet text-lg text-white leading-[1.6] max-w-[600px] space-y-3">
            <p>Build My Team is Joanna&rsquo;s private leadership experience for founders and executives ready to scale trust, communication, and leadership across an entire organization.</p>
            <p>This is where your message becomes a system others can lead through.</p>
        </div>

        <!-- Sub-pill -->
        <span class="mt-8 inline-flex items-center font-garet font-bold rounded-full bg-white/10 backdrop-blur-sm px-5 py-2 text-xs uppercase tracking-[0.2em] text-warm-beige">
            Discovery call required before engagement
        </span>
    </div>
</section>
