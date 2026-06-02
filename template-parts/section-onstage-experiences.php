<?php

/**
 * On Stage Page - Experiences Section template part.
 *
 * @package TailPress
 */

$experiences_fallback = array(
    array(
        'title'       => 'Speak Your Story. Create Influence.',
        'length'      => '45–60 min',
        'ideal'       => 'Founders, executives, and leadership events',
        'description' => 'Helping leaders reconnect with the lived experiences that shape trust, influence, and emotional authority.',
        'url'         => home_url('/inquiry/'),
    ),
    array(
        'title'       => 'The Moment That Made You.',
        'length'      => '30–45 min',
        'ideal'       => 'Women&#8217;s leadership and transformational conversations',
        'description' => 'A reflective conversation around identity, truth, visibility, and the defining moments behind leadership.',
        'url'         => home_url('/inquiry/'),
    ),
    array(
        'title'       => 'Influence Is a Human Experience.',
        'length'      => '20–30 min',
        'ideal'       => 'TED-style events and keynote openings',
        'description' => 'Why people trust emotional truth before strategy, information, or performance.',
        'url'         => home_url('/inquiry/'),
    ),
);
$heading = get_field('section_experiences_heading') ?: '<em class="text-gold italic">Conversations</em> That Stay With People.';
$subtitle = get_field('section_experiences_subtitle') ?: 'Three experiences, three formats — each designed to move a room differently.';
?>

<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-tight max-w-[556px]">
                <?= $heading ?>
            </h2>
            <p class="mt-6 font-garet text-lg text-dark-text leading-relaxed max-w-[556px]">
                <?= esc_html($subtitle) ?>
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-2">
            <?php if (have_rows('section_experiences_items')): ?>
                <?php while (have_rows('section_experiences_items')): the_row(); ?>
                    <?php $img = get_sub_field('item_image'); ?>
                    <div class="bg-warm-beige rounded-lg pt-10 px-6 pb-10 flex flex-col gap-6">
                        <?php if ($img): ?>
                            <?= wp_get_attachment_image($img, 'medium', false, array('class' => 'w-full rounded-lg')) ?>
                        <?php endif; ?>
                        <h3 class="font-flatline font-medium text-3xl text-navy leading-tight">
                            <?php echo esc_html(get_sub_field('item_title')); ?>
                        </h3>
                        <p class="font-garet text-base text-dark-text leading-relaxed">
                            <?php echo esc_html(get_sub_field('item_description')); ?>
                        </p>
                        <div class="mt-auto w-full">
                            <a href="<?php echo esc_url(home_url('/inquiry/')); ?>" class="inline-flex items-center gap-2.5 px-6 py-4 rounded-full w-full justify-center bg-gradient-to-r from-warm-beige to-gold border border-warm-beige font-flatline font-bold text-base text-navy">
                                BOOKING INQUIRY
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <?php foreach ($experiences_fallback as $experience) : ?>
                    <div class="bg-warm-beige rounded-lg pt-10 px-6 pb-10 flex flex-col gap-6">
                        <h3 class="font-flatline font-medium text-3xl text-navy leading-tight">
                            <?php echo esc_html($experience['title']); ?>
                        </h3>

                        <div class="flex flex-col gap-2">
                            <div class="flex items-start gap-4">
                                <div class="flex items-center gap-2 shrink-0">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="9" cy="9" r="7.5" stroke="#ad8b3a" stroke-width="1.5"/>
                                        <path d="M9 5V9L11.5 10.5" stroke="#ad8b3a" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    <span class="font-flatline font-bold text-lg text-navy">Length:</span>
                                </div>
                                <span class="font-garet text-base text-dark-text"><?php echo esc_html($experience['length']); ?></span>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="flex items-center gap-2 shrink-0">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 1.5L2.25 4.5V8.25C2.25 12.8025 5.2875 17.0325 9 18C12.7125 17.0325 15.75 12.8025 15.75 8.25V4.5L9 1.5Z" stroke="#ad8b3a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M6.75 9L8.25 10.5L11.25 7.5" stroke="#ad8b3a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="font-flatline font-bold text-lg text-navy">Ideal for:</span>
                                </div>
                                <span class="font-garet text-base text-dark-text"><?php echo wp_kses_post($experience['ideal']); ?></span>
                            </div>
                        </div>

                        <div class="border-t border-gold-section"></div>

                        <p class="font-garet text-base text-dark-text leading-relaxed">
                            <?php echo esc_html($experience['description']); ?>
                        </p>

                        <div class="mt-auto w-full">
                            <a href="<?php echo esc_url($experience['url']); ?>" class="inline-flex items-center gap-2.5 px-6 py-4 rounded-full w-full justify-center bg-gradient-to-r from-warm-beige to-gold border border-warm-beige font-flatline font-bold text-base text-navy">
                                BOOKING INQUIRY
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
