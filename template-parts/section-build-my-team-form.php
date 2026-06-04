<?php

/**
 * Build My Team Page - Registration Form Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_form_heading') ?: '<em class="text-gold italic">Begin</em> the Conversation.';
$text = get_field('section_form_text') ?: '<p>A private conversation to explore your leadership, organization, and the next stage of growth for your team and business.</p>';
$form_bg_image_id = get_field('section_form_bg_image');
?>
<section class="relative px-4 sm:px-6 lg:px-8 pb-24" id="register">
    <div class="relative max-w-[1360px] mx-auto bg-navy rounded-[20px] overflow-hidden">
        <!-- Background texture -->
        <div class="absolute inset-0">
            <?php if ($form_bg_image_id): ?>
                <?= wp_get_attachment_image($form_bg_image_id, 'full', false, ['class' => 'w-full h-full object-cover', 'aria-hidden' => 'true']) ?>
            <?php else: ?>
                <img class="w-full h-full object-cover" src="<?= esc_url(get_template_directory_uri()) ?>/assets/images/vault-registration-bg.webp" alt="" aria-hidden="true">
            <?php endif; ?>
        </div>

        <!-- Decorative blurred ellipses -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -right-32 -top-32 w-[600px] h-[600px] bg-deep-blue rounded-full" style="filter: blur(120px);"></div>
            <div class="absolute -left-24 -bottom-24 w-[500px] h-[500px] rounded-full" style="background: radial-gradient(circle, #d4b478 0%, transparent 70%); filter: blur(80px); opacity: 0.7;"></div>
        </div>

        <!-- BUILD MY TEAM watermark tag at top -->
        <div class="absolute -top-3 left-1/2 -translate-x-1/2 pointer-events-none select-none w-full text-center">
            <h2 class="font-flatline font-bold text-[100px] md:text-[140px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-white to-white/0 opacity-20">
                BUILD MY TEAM
            </h2>
        </div>

        <div class="relative pt-32 lg:pt-40 pb-16 lg:pb-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-[760px] mx-auto text-center">
                <!-- Heading -->
                <h3 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-white leading-[1.1]">
                    <?= $heading ?>
                </h3>

                <!-- Subtext -->
                <div class="mt-6 font-garet text-lg text-white leading-[1.6] max-w-[600px] mx-auto">
                    <?= $text ?>
                </div>

                <!-- Form -->
                <form class="mt-10 text-left" action="https://services.leadconnectorhq.com/hooks/txFvEqJbQlKriCxJl8w3/webhook-trigger/a3e3e65a-e7d2-4aa4-b34d-bd02d0265e35" method="POST">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-garet text-sm text-white mb-2" for="firstName">First Name<span class="text-gold">*</span></label>
                                <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="text" id="firstName" name="firstName" placeholder="First Name" required>
                            </div>
                            <div>
                                <label class="block font-garet text-sm text-white mb-2" for="lastName">Last Name<span class="text-gold">*</span></label>
                                <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="text" id="lastName" name="lastName" placeholder="Last Name" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-garet text-sm text-white mb-2" for="email">Email<span class="text-gold">*</span></label>
                                <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="email" id="email" name="email" placeholder="your@email.com" required>
                            </div>
                            <div>
                                <label class="block font-garet text-sm text-white mb-2" for="phone">Phone Number (Optional)</label>
                                <input class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold" type="tel" id="phone" name="phone" placeholder="+1555 0100">
                            </div>
                        </div>

                        <div>
                            <label class="block font-garet text-sm text-white mb-2" for="challenges">What challenges are you currently experiencing across leadership, communication, or culture?<span class="text-gold">*</span></label>
                            <textarea class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold resize-none" rows="5" id="challenges" name="challenges" placeholder="Share your challenges..." required></textarea>
                        </div>

                        <div>
                            <label class="block font-garet text-sm text-white mb-2" for="transformation">What kind of transformation are you hoping to create inside your organization?</label>
                            <textarea class="w-full px-4 py-3 rounded-[10px] bg-white border border-warm-beige font-garet text-base text-dark-text placeholder:text-dark-text/50 outline-none focus:border-gold resize-none" rows="5" id="transformation" name="transformation" placeholder="Share what you expect..."></textarea>
                        </div>

                        <div class="flex items-start gap-3 pt-2">
                            <input class="w-6 h-6 flex-shrink-0 mt-0.5 cursor-pointer" type="checkbox" id="consent" name="consent" style="accent-color: #d4b478;" required>
                            <label class="font-garet text-sm text-white leading-[1.5]" for="consent">I agree to receive updates and leadership content from Joanna Horton McPherson.<span class="text-gold">*</span></label>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="btn-primary w-full">
                                REQUEST DISCOVERY CALL
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
