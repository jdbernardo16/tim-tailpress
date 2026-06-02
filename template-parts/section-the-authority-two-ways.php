<?php

/**
 * The Authority Page - Two Ways Forward Section template part.
 *
 * @package TailPress
 */

$offers = array(
    array(
        'title'       => 'Move the Room<br>— My Signature Talk',
        'description' => 'Your story becomes a structured talk that moves people.',
        'includes'    => array(
            'A 7-minute signature talk',
            'A clear problem → solution message',
            'Emotional connection points + defined CTA',
            'Live coaching with Joanna',
        ),
        'price_label' => '',
        'price'       => '$12,000',
        'cta'         => 'TAKE THE STAGE',
        'url'         => home_url('/the-speaker/'),
    ),
    array(
        'title'       => 'Master My Message<br>— Keynote or TEDx',
        'description' => 'This is where you become known.',
        'includes'    => array(
            'A refined, repeatable signature message',
            'Your thought-leader perspective',
            'Your "special sauce" (what you do differently)',
            'A one-liner people can repeat',
        ),
        'price_label' => 'Starts at',
        'price'       => '$25,000',
        'cta'         => 'CREATE MY KEYNOTE',
        'url'         => home_url('/master-my-message/'),
    ),
);
?>
<section class="bg-canvas py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1]">
                Two Ways <em class="text-gold italic">Forward</em>
            </h2>
            <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] max-w-[556px]">
                Build the structured talk that lands, or go all the way to keynote / TEDx.
            </p>
            <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] font-semibold">
                Become a Speaker with Joanna
            </p>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-2">
            <?php foreach ($offers as $offer) : ?>
                <div class="bg-warm-beige rounded-[10px] border border-gold-section p-6 sm:p-8 flex flex-col">
                    <h3 class="font-flatline font-medium text-3xl text-navy leading-[1.1]">
                        <?php echo wp_kses_post($offer['title']); ?>
                    </h3>

                    <p class="mt-6 font-garet text-lg text-dark-text leading-[150%]">
                        <?php echo esc_html($offer['description']); ?>
                    </p>

                    <ul class="mt-4 space-y-2">
                        <?php foreach ($offer['includes'] as $item) : ?>
                            <li class="flex items-center gap-3 font-garet text-lg text-dark-text">
                                <svg class="w-5 h-5 flex-shrink-0 text-gold" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L13.5 8.5L20 10L13.5 11.5L12 18L10.5 11.5L4 10L10.5 8.5L12 2Z"/>
                                    <path d="M18 14L18.75 16.25L21 17L18.75 17.75L18 20L17.25 17.75L15 17L17.25 16.25L18 14Z" opacity="0.6"/>
                                    <path d="M6 14L6.75 16.25L9 17L6.75 17.75L6 20L5.25 17.75L3 17L5.25 16.25L6 14Z" opacity="0.6"/>
                                </svg>
                                <span><?php echo esc_html($item); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <div class="mt-10 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-baseline gap-2">
                            <?php if (!empty($offer['price_label'])) : ?>
                                <span class="font-flatline text-base text-dark-text"><?php echo esc_html($offer['price_label']); ?></span>
                            <?php endif; ?>
                            <span class="font-flatline font-medium text-4xl text-gold leading-[1.1]"><?php echo esc_html($offer['price']); ?></span>
                        </div>
                        <a href="<?php echo esc_url($offer['url']); ?>" class="btn-primary">
                            <?php echo esc_html($offer['cta']); ?>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.167 10h11.666m0 0L10 4.167M15.833 10L10 15.833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
