<?php

/**
 * Offers Page - Signature Offers Section template part.
 *
 * @package TailPress
 */

$signature_offers = array(
    array(
        'title'       => 'Tell Your Story',
        'description' => 'Reconnect with the defining moments behind your leadership, voice, and influence.',
        'price_label' => '',
        'price'       => '$3,200',
        'cta'         => 'FIND MY MESSAGE',
        'url'         => home_url('/the-speaker/'),
    ),
    array(
        'title'       => 'Move the Room',
        'description' => 'Build a signature talk and message people trust, remember, and follow.',
        'price_label' => '',
        'price'       => '$12,000',
        'cta'         => 'TAKE THE STAGE',
        'url'         => home_url('/the-speaker/'),
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
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                Signature <em class="text-gold italic">Offers</em>
            </h2>
            <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] max-w-[600px]">
                The primary transformational experiences inside the True Influence Method&trade; — designed for different stages of leadership, visibility, authority, and long-term impact.
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
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
        </div>
    </div>
</section>
