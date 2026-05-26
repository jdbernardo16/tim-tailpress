<?php

/**
 * Events Page - Upcoming Experiences Section template part.
 *
 * @package TailPress
 */
?>

<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] leading-[110%] text-center">
            <em class="text-gold italic">Upcoming</em> <span class="text-navy">Experiences</span>
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mt-12">
            <!-- Card 1 -->
            <div class="overflow-hidden">
                <div class="aspect-[16/9] overflow-hidden rounded-xl">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/events-frame3-img1.png" alt="Speak & Rise + Retreat" class="w-full h-full object-cover">
                </div>
                <div class="pt-8">
                    <h3 class="font-flatline text-[32px] text-navy font-semibold leading-[110%]">Speak & Rise + Retreat</h3>
                    <p class="font-garet text-lg text-dark-text mt-4 leading-[150%]">
                        A live speaking and storytelling experience centered around transformational voices, truth-telling, and leadership presence.
                    </p>

                    <div class="mt-4 flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-gold flex-shrink-0">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" fill="currentColor" />
                                <circle cx="12" cy="10" r="3" fill="#0f203d" />
                            </svg>
                            <span class="font-garet text-lg text-navy font-bold">Phoenix</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-gold flex-shrink-0">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" fill="currentColor" />
                                <line x1="16" x2="16" y1="2" y2="6" stroke="#0f203d" stroke-width="1.5" />
                                <line x1="8" x2="8" y1="2" y2="6" stroke="#0f203d" stroke-width="1.5" />
                                <line x1="3" x2="21" y1="10" y2="10" stroke="#0f203d" stroke-width="1.5" />
                            </svg>
                            <span class="font-garet text-lg text-navy font-bold">September 16-20, 2026</span>
                        </div>
                    </div>

                    <p class="font-garet text-base text-dark-text mt-4 leading-[150%]">
                        This is a part of Tell Your Story and Move the Room
                    </p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="overflow-hidden">
                <div class="aspect-[16/9] overflow-hidden rounded-xl">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/events-frame3-img2.png" alt="Speaking On Stage Top Talent Hollywood" class="w-full h-full object-cover">
                </div>
                <div class="pt-8">
                    <h3 class="font-flatline text-[32px] text-navy font-semibold leading-[110%]">Speaking On Stage<br>Top Talent Hollywood</h3>
                    <p class="font-garet text-lg text-dark-text mt-4 leading-[150%]">
                        An immersive speaking experience designed to strengthen presence, authority, and audience connection.
                    </p>

                    <div class="mt-4 flex items-center gap-6">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-gold flex-shrink-0">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" fill="currentColor" />
                                <circle cx="12" cy="10" r="3" fill="#0f203d" />
                            </svg>
                            <span class="font-garet text-lg text-navy font-bold">Phoenix</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-gold flex-shrink-0">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" fill="currentColor" />
                                <line x1="16" x2="16" y1="2" y2="6" stroke="#0f203d" stroke-width="1.5" />
                                <line x1="8" x2="8" y1="2" y2="6" stroke="#0f203d" stroke-width="1.5" />
                                <line x1="3" x2="21" y1="10" y2="10" stroke="#0f203d" stroke-width="1.5" />
                            </svg>
                            <span class="font-garet text-lg text-navy font-bold">December 1, 2026</span>
                        </div>
                    </div>

                    <p class="font-garet text-base text-dark-text mt-4 leading-[150%]">
                        Want to book Joanna On Stage? Click <a href="#" class="text-gold underline">here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>