<?php

/**
 * On Stage Page - Book Section template part.
 *
 * @package TailPress
 */
?>

<section class="bg-canvas px-10 ">
    <div class="relative overflow-hidden rounded-[20px] bg-navy relative z-[1]">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bg-texture.webp" alt="">
        </div>

        <!--<div class="absolute top-0 right-0 h-full pointer-events-none hidden xl:block">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/book-joanna-png.webp" alt="Joanna" class="w-full h-full object-cover ">
        </div>-->
        <div class="absolute top-0 right-0 h-full pointer-events-none hidden xl:block">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/onstage-book-bg.webp" alt="Joanna" class="w-full h-full object-cover ">
        </div>

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 right-0 w-[1535px] h-[1535px] bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3"></div>
            <div class="absolute top-0 left-0 w-[1525px] h-[1525px] bg-gold/10 rounded-full blur-3xl transform -translate-x-2/3 -translate-y-2/3"></div>
        </div>

        <div class="absolute -top-3 left-1/2 -translate-x-1/2 pointer-events-none select-none w-full text-center">
            <h2 class="font-flatline font-bold text-[117px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-white to-white/0 opacity-20 w-full">
                BOOK JOANNA
            </h2>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="max-w-[658px]">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-white leading-tight">
                    Tell us About Your <em class="text-gold italic">Event.</em>
                </h2>
                <p class="mt-6 font-garet text-lg text-white leading-relaxed">
                    Share a few details about your audience, event format, and what you want the room to experience. Joanna's team will review and follow up with the next best step.
                </p>

                <form class="mt-10 space-y-4" action="#" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-garet text-sm text-white mb-1">Full Name</label>
                            <input type="text" placeholder="Jane Doe" class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none">
                        </div>
                        <div>
                            <label class="block font-garet text-sm text-white mb-1">Role</label>
                            <input type="text" placeholder="CEO" class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-garet text-sm text-white mb-1">Email</label>
                            <input type="email" placeholder="your@email.com" class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none">
                        </div>
                        <div>
                            <label class="block font-garet text-sm text-white mb-1">Organization</label>
                            <input type="text" placeholder="Your company/event" class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-garet text-sm text-white mb-1">Event type</label>
                        <select class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text outline-none appearance-none">
                            <option>Select answer</option>
                            <option>Keynote</option>
                            <option>Workshop</option>
                            <option>Retreat</option>
                            <option>Panel</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-garet text-sm text-white mb-1">Event date(s)</label>
                            <input type="text" placeholder="Select date(s)" class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none">
                        </div>
                        <div>
                            <label class="block font-garet text-sm text-white mb-1">City / location</label>
                            <input type="text" placeholder="Austin, TX" class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-garet text-sm text-white mb-1">Audience size</label>
                            <input type="text" placeholder="500" class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none">
                        </div>
                        <div>
                            <label class="block font-garet text-sm text-white mb-1">Budget range</label>
                            <select class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text outline-none appearance-none">
                                <option>Select answer</option>
                                <option>Under $5,000</option>
                                <option>$5,000 - $10,000</option>
                                <option>$10,000 - $25,000</option>
                                <option>$25,000+</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-garet text-sm text-white mb-1">Anything else? (audience, theme, dream talk)</label>
                        <textarea rows="4" placeholder="Theme is 'Conviction'. The audience are late 20s - early 30s female..." class="w-full px-4 py-2.5 rounded-lg bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none resize-none"></textarea>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="inline-flex items-center gap-2.5 px-6 py-4 rounded-full bg-gradient-to-r from-warm-beige to-gold border border-warm-beige font-flatline font-bold text-sm text-navy">
                            SEND INQUIRY
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
