<?php

/**
 * Offers Page - Other Ways Section template part.
 *
 * @package TailPress
 */

$other_offers = array(
    array(
        'title'       => 'The Vault',
        'description' => 'Live conversations with Joanna around story, visibility, leadership, and emotional truth.',
        'price_label' => '',
        'price'       => 'FREE',
        'cta'         => 'RESERVE MY SEAT',
        'url'         => home_url('/the-vault/'),
    ),
    array(
        'title'       => 'Million Dollar Message',
        'description' => 'A 7-minute training to uncover the defining message behind your work.',
        'price_label' => '',
        'price'       => '$29',
        'cta'         => 'GET THE TRAINING',
        'url'         => home_url('/million-dollar-message/'),
    ),
    array(
        'title'       => '4-Session Training Package',
        'description' => 'Private message refinement and leadership clarity across four sessions.',
        'price_label' => '',
        'price'       => '$8,000',
        'cta'         => 'BOOK PRIVATE TRAINING',
        'url'         => home_url('/inquiry/'),
    ),
    array(
        'title'       => 'Breakthrough Session',
        'description' => 'One focused session designed to create immediate clarity and direction.',
        'price_label' => '',
        'price'       => '$2,000',
        'cta'         => 'BOOK A BREAKTHROUGH SESSION',
        'url'         => home_url('/inquiry/'),
    ),
);
?>
<section class="bg-canvas pb-24 lg:pb-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-navy leading-[1.1] max-w-[556px]">
                Other Ways to<br>Work <em class="text-gold italic">Together</em>
            </h2>
            <p class="mt-6 font-garet text-lg text-dark-text leading-[150%] max-w-[556px]">
                Private guidance, live conversations, and focused experiences designed to support deeper clarity, refinement, and continued transformation.
            </p>
        </div>

        <div class="mt-12 max-w-3xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-2">
            <?php foreach ($other_offers as $offer) : ?>
                <div class="bg-warm-beige rounded-[10px] border border-gold-section p-6 sm:p-8 flex flex-col">
                    <h3 class="font-flatline font-medium text-3xl text-navy leading-[1.1]">
                        <?php echo esc_html($offer['title']); ?>
                    </h3>

                    <p class="mt-6 font-garet text-base text-dark-text leading-[150%] flex-1">
                        <?php echo esc_html($offer['description']); ?>
                    </p>

                    <p class="mt-8 font-flatline font-medium text-4xl text-gold leading-[1.1]">
                        <?php echo esc_html($offer['price']); ?>
                    </p>

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
