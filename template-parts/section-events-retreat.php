<?php

/**
 * Events Page - Retreat Section template part.
 *
 * @package TailPress
 */
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-4">
            <!-- Text Content -->
            <div class="w-7/12 max-w-xl">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] leading-[1.1]">
                    <span class="text-navy">Tell Your Story</span><br>
                    <em class="text-gold italic">Course &amp; Retreat</em>
                </h2>
                <div class="mt-8 font-garet text-lg text-dark-text leading-normal space-y-6">
                    <p>A transformational storytelling and leadership experience designed to help people reconnect with the moments that shaped their voice, influence, and emotional authority.</p>
                    <p>Through retreat immersion, live story work, emotional refinement, and transformational conversations, participants are guided deeper into the work behind authentic leadership.</p>
                </div>
                <!-- Bottom-left image (laptop/books) -->
                <div class="aspect-[636/281] w-full rounded-xl overflow-hidden shadow-lg mt-6">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/events-frame2-img2.webp" alt="Laptop and books on a table" class="w-full h-full object-cover">
                </div>

            </div>
            <!-- Images -->
            <div class="w-5/12 relative  max-w-lg lg:max-w-xl">
                <div class="relative">
                    <!-- Top-right image (woman on couch) -->
                    <div class="rounded-xl overflow-hidden shadow-lg aspect-[448/566] w-full">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/event-frame2-img1.webp" alt="Joanna on a couch in red pants" class="w-full h-full object-cover">
                    </div>

                </div>
                <div class="mt-4">
                    <a href="<?php echo esc_url(home_url('/events/')); ?>" class="btn-primary w-full">
                        EXPLORE THE EXPERIENCE
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                            <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
