<?php

/**
 * Offers Page - Signature Offers Section template part.
 *
 * @package TailPress
 */

$heading = get_field('section_signature_heading') ?: 'Signature <em class="text-gold italic">Offers</em>';
$subtitle = get_field('section_signature_subtitle') ?: 'The primary transformational experiences inside the True Influence Method&trade; — designed for different stages of leadership, visibility, authority, and long-term impact.';
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                <?= $heading ?>
            </h2>
            <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] max-w-[600px]">
                <?= esc_html($subtitle) ?>
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
            <?php if (have_rows('section_signature_items')): ?>
                <?php while (have_rows('section_signature_items')): the_row(); ?>
                    <div class="bg-warm-beige rounded-[10px] border border-gold-section p-6 sm:p-8 flex flex-col">
                        <h3 class="font-flatline font-medium text-3xl text-navy leading-[1.1]">
                            <?= esc_html(get_sub_field('item_title')) ?>
                        </h3>

                        <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] flex-1">
                            <?= esc_html(get_sub_field('item_description')) ?>
                        </p>

                        <div class="mt-8 flex items-baseline gap-2">
                            <?php $price_label = get_sub_field('item_price_label'); ?>
                            <?php if ($price_label) : ?>
                                <span class="font-flatline text-base text-dark-text"><?= esc_html($price_label) ?></span>
                            <?php endif; ?>
                            <span class="font-flatline font-medium text-4xl text-gold leading-[1.1]"><?= esc_html(get_sub_field('item_price')) ?></span>
                        </div>

                        <a href="<?= esc_url(get_sub_field('item_url')) ?>" class="mt-6 btn-primary">
                            <?= esc_html(get_sub_field('item_cta')) ?>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <?php
                $signature_offers = array(
                    array(
                        'title'       => 'Tell Your Story',
                        'description' => 'Reconnect with the defining moments behind your leadership, voice, and influence.',
                        'price_label' => '',
                        'price'       => '$3,200',
                        'cta'         => 'FIND MY MESSAGE',
                        'url'         => home_url('/tell-your-story/'),
                    ),
                    array(
                        'title'       => 'Move the Room',
                        'description' => 'Build a signature talk and message people trust, remember, and follow.',
                        'price_label' => '',
                        'price'       => '$3,200',
                        'cta'         => 'TAKE THE STAGE',
                        'url'         => 'https://go.trueinfluencemethod.com/move-the-room',
                    ),
                    array(
                        'title'       => 'Master My Message',
                        'description' => 'Refine your positioning, authority, and keynote-level message.',
                        'price_label' => 'Starts at',
                        'price'       => '$25,000',
                        'cta'         => 'CREATE MY KEYNOTE',
                        'url'         => home_url('/master-my-message/'),
                    ),
                    array(
                        'title'       => 'Build My Team',
                        'description' => 'Scale communication, trust, and leadership across your organization.',
                        'price_label' => 'Starts at',
                        'price'       => '$250,000',
                        'cta'         => 'SCALE MY BUSINESS',
                        'url'         => home_url('/build-my-team/'),
                    ),
                    array(
                        'title'       => 'Be Remembered',
                        'description' => 'Create work, leadership, and influence designed to outlast you.',
                        'price_label' => 'Starts at',
                        'price'       => '$1M',
                        'cta'         => 'SCALE MY BUSINESS',
                        'url'         => home_url('/be-remembered/'),
                    ),
                );
                ?>
                <?php foreach ($signature_offers as $offer) : ?>
                    <div class="bg-warm-beige rounded-[10px] border border-gold-section p-6 sm:p-8 flex flex-col">
                        <h3 class="font-flatline font-medium text-3xl text-navy leading-[1.1]">
                            <?php echo esc_html($offer['title']); ?>
                        </h3>

                        <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] flex-1">
                            <?php echo esc_html($offer['description']); ?>
                        </p>

                        <div class="mt-8 flex items-baseline gap-2">
                            <?php if (!empty($offer['price_label'])) : ?>
                                <span class="font-flatline text-base text-dark-text"><?php echo esc_html($offer['price_label']); ?></span>
                            <?php endif; ?>
                            <span class="font-flatline font-medium text-4xl text-gold leading-[1.1]"><?php echo esc_html($offer['price']); ?></span>
                        </div>

                        <a href="<?php echo esc_url($offer['url']); ?>" class="mt-6 btn-primary">
                            <?php echo esc_html($offer['cta']); ?>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
