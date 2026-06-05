<?php

/**
 * Tell Your Story Page - Pricing Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_tys_pricing_heading') ?: 'Join the Course &amp; Retreat<br><em class="text-gold-section italic">Experience</em>';
$subhead = get_field('section_tys_pricing_subhead') ?: 'This inaugural course &amp; retreat experience is intentionally intimate to preserve depth, connection, and transformation.';
$strike_price = get_field('section_tys_pricing_strike') ?: '$12,000';
$price = get_field('section_tys_pricing_price') ?: '$3,200';
$footnote = get_field('section_tys_pricing_footnote') ?: 'Includes the transformational course and retreat experience.<br>Travel &amp; accommodations <strong>not</strong> included.';
$cta_text = get_field('section_tys_pricing_cta_text') ?: 'JOIN THE COURSE &amp; RETREAT';
$cta_url = get_field('section_tys_pricing_cta_url') ?: 'https://true-influence-method.mykajabi.com/offers/zvLu7zev/checkout';
?>

<section class="px-5">
    <section class="relative bg-warm-beige rounded-[20px] overflow-hidden py-24 lg:py-32 px-5">
        <!-- Background Image Overlay -->
        <div class="absolute inset-0 z-0"
             style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-your-story-pricing-bg.webp'); background-size: cover; background-position: center;">
        </div>

        <!-- Decorative Ellipses -->
        <div class="absolute pointer-events-none inset-0 overflow-hidden z-0">
            <div class="absolute w-[1454px] h-[1454px] -right-[400px] -top-[400px] rounded-full opacity-50"
                 style="background: radial-gradient(circle, #d4b478 0%, transparent 70%); filter: blur(100px);"></div>
            <div class="absolute w-[837px] h-[837px] -left-[300px] -bottom-[300px] rounded-full opacity-40"
                 style="background: radial-gradient(circle, #d4b478 0%, transparent 70%); filter: blur(100px);"></div>
        </div>

        <div class="relative z-10 max-w-[830px] mx-auto text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[64px] text-navy leading-[1.1] mb-6">
                <?= $heading ?>
            </h2>
            <p class="font-garet text-lg font-light text-navy leading-[1.6] mb-12 max-w-[600px] mx-auto">
                <?= esc_html($subhead) ?>
            </p>

            <div class="w-full max-w-[677px] h-px bg-navy/20 mx-auto mb-8"></div>

            <p class="font-flatline font-semibold text-2xl md:text-[32px] text-navy mb-6">Investment</p>

            <div class="flex items-baseline justify-center gap-6 mb-4">
                <span class="font-flatline font-semibold text-2xl md:text-[32px] text-navy/40 line-through"><?= esc_html($strike_price) ?></span>
                <span class="font-flatline font-semibold text-4xl md:text-[56px] text-gold-section leading-[1]"><?= esc_html($price) ?></span>
            </div>

            <p class="font-garet text-base font-light text-navy leading-[1.6] mb-8">
                <?= $footnote ?>
            </p>

            <a href="<?php echo esc_url($cta_url); ?>" class="inline-flex items-center justify-center gap-3 rounded-[40px] px-9 py-4 font-flatline font-bold text-base text-navy transition-transform hover:-translate-y-0.5 hover:shadow-lg"
               style="background: radial-gradient(circle at center, #e7d4c5, #d4b478); border: 1px solid #d4b478;">
                <?= esc_html($cta_text) ?>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#0f203d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </section>
</section>
