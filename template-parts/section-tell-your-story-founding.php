<?php

/**
 * Tell Your Story Page - Founding Experience Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_tys_founding_heading') ?: 'Be Part of the<br><em class="text-gold">Founding Experience.</em>';
$subhead = get_field('section_tys_founding_subhead') ?: 'This retreat marks the <strong>beginning of a new chapter</strong> inside the True Influence Method — bringing together a small group of leaders ready to uncover the story behind their influence.';
$card_title = get_field('section_tys_founding_card_title') ?: 'Inside the Experience';
$card_sub = get_field('section_tys_founding_card_sub') ?: 'A guided experience designed to help you uncover the story behind your leadership.';
$card_text = get_field('section_tys_founding_card_text') ?: 'Inside Tell Your Story, you\'ll move through a structured self-guided course experience with Joanna designed to help you identify the defining moments, emotional truths, and deeper why behind your message.';
$card_date = get_field('section_tys_founding_date') ?: 'September 17-20, 2027';

$features = array(
    'Four guided self-paced modules',
    'Community connection with like-minded leaders',
    'Reflective prompts and story exercises',
    'Story sharing, refinement, and feedback',
    'Defining moment and "why" discovery',
    'Immersive retreat experience with Joanna',
);
if (have_rows('section_tys_founding_features')) {
    $features = array();
    while (have_rows('section_tys_founding_features')) {
        the_row();
        $features[] = get_sub_field('feature_text');
    }
}
?>

<section class="px-5">
    <section class="relative bg-navy overflow-hidden rounded-[20px]"
             style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-your-story-founding-bg.webp'); background-position: center; background-repeat: no-repeat; background-size: cover;">
        <!-- Decorative ellipses -->
        <div class="absolute pointer-events-none inset-0 overflow-hidden">
            <div class="absolute w-[1535px] h-[1535px] -right-[400px] -top-[200px] bg-deep-blue/60 blur-[120px] rounded-full"></div>
            <div class="absolute w-[1525px] h-[1525px] -left-[500px] -top-[300px] rounded-full opacity-35"
                 style="background: radial-gradient(circle, #d4b478 0%, transparent 70%); filter: blur(80px);"></div>
        </div>

        <!-- Come Logo -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 z-10">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/tell-your-story-come-logo.webp"
                 alt="Logo" class="max-w-[180px] lg:max-w-none">
        </div>

        <div class="relative z-10 max-w-[903px] mx-auto text-center px-5 py-24 lg:py-32">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-white leading-[1.1] mb-6">
                <?= $heading ?>
            </h2>
            <p class="font-garet text-lg font-light text-white leading-[1.6] mb-12 max-w-[700px] mx-auto">
                <?= $subhead ?>
            </p>

            <!-- Card -->
            <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-[16px] p-6 sm:p-10 lg:p-12 text-left">
                <div class="text-center">
                    <h3 class="font-flatline font-semibold text-2xl md:text-3xl lg:text-[32px] text-gold leading-[1.1] mb-3">
                        <?= esc_html($card_title) ?>
                    </h3>
                    <p class="font-garet text-lg font-bold text-white leading-[1.4] mb-4">
                        <?= esc_html($card_sub) ?>
                    </p>
                    <p class="font-garet text-base font-light text-white leading-[1.6] mb-8 max-w-[650px] mx-auto">
                        <?= esc_html($card_text) ?>
                    </p>

                    <!-- Date badge -->
                    <div class="inline-flex items-center gap-2.5 font-garet text-base font-bold text-white border border-white/30 rounded-[40px] px-5 py-2.5 mb-8">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                            <rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M3 9h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        <?= esc_html($card_date) ?>
                    </div>
                </div>

                <!-- Feature list -->
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 gap-x-12">
                    <?php foreach ($features as $feature) : ?>
                        <li class="flex items-start gap-3 font-garet text-base font-light text-white leading-[1.5]">
                            <span class="text-gold flex-shrink-0 mt-0.5">✦</span>
                            <?= esc_html($feature) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
</section>
