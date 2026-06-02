<?php

/**
 * Events Page - Features Section template part.
 *
 * @package TailPress
 */

$features_fallback = array(
    array(
        'heading' => 'Connection',
        'text'    => 'Conversations that stay with you.',
    ),
    array(
        'heading' => 'Reflection',
        'text'    => 'Moments that reconnect you with what\'s true.',
    ),
    array(
        'heading' => 'Momentum',
        'text'    => 'Clarity that moves beyond the retreat.',
    ),
    array(
        'heading' => 'Community',
        'text'    => 'A room full of leaders growing together.',
    ),
);
$heading = get_field('section_features_heading') ?: '<em class="text-gold italic">More</em> <span class="text-navy">Than Events.</span>';
?>
<section class="relative z-10 px-8">
    <div class="py-24 lg:py-32 relative">
        <img class="absolute top-0 left-0 w-full h-full object-cover rounded-2xl" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/events-bg.webp" alt="">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] leading-[1.1]">
                <?= $heading ?>
            </h2>

            <?php if (have_rows('section_features_items')): ?>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mt-16 relative">
                    <?php while (have_rows('section_features_items')): the_row(); ?>
                        <div class="text-center">
                            <h3 class="mt-4 uppercase text-sm tracking-wide text-navy font-medium"><?php echo esc_html(get_sub_field('item_heading')); ?></h3>
                            <p class="mt-2 font-garet text-sm text-dark-text leading-[150%]"><?php echo esc_html(get_sub_field('item_text')); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="mt-6 font-garet text-lg text-dark-text max-w-2xl mx-auto leading-[150%]">
                    These experiences are designed to help people reconnect with their story, communicate with emotional clarity, and lead from a place others can truly feel.
                </p>

                <p class="mt-4 font-garet text-base text-dark-text/80 max-w-2xl mx-auto leading-[150%]">
                    Through storytelling, retreats, speaking, and transformational conversations, the work moves beyond strategy alone.
                </p>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mt-16 relative">
                    <!-- Connection -->
                    <div class="text-center">
                        <svg class="mx-auto h-10 w-10 text-gold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                        </svg>
                        <h3 class="mt-4 uppercase text-sm tracking-wide text-navy font-medium">Connection</h3>
                        <p class="mt-2 font-garet text-sm text-dark-text leading-[150%]">Conversations that<br>stay with you.</p>
                    </div>

                    <!-- Divider -->
                    <div class="hidden lg:block absolute left-[25%] top-1/2 -translate-y-1/2 w-px h-16 bg-navy/20"></div>

                    <!-- Reflection -->
                    <div class="text-center">
                        <svg class="mx-auto h-10 w-10 text-gold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M11.25 4.533A9.707 9.707 0 006 3a9.735 9.735 0 00-3.25.555.75.75 0 00-.5.707v14.25a.75.75 0 001 .707A8.237 8.237 0 016 18.75c1.995 0 3.823.707 5.25 1.886V4.533zM12.75 20.636A8.214 8.214 0 0118 18.75c.855 0 1.68.162 2.444.476a.75.75 0 00.556-.707V3.232a.75.75 0 00-.5-.707A9.735 9.735 0 0018 3c-1.995 0-3.823.707-5.25 1.886v15.75z" />
                        </svg>
                        <h3 class="mt-4 uppercase text-sm tracking-wide text-navy font-medium">Reflection</h3>
                        <p class="mt-2 font-garet text-sm text-dark-text leading-[150%]">Moments that reconnect<br>you with what's true.</p>
                    </div>

                    <!-- Divider -->
                    <div class="hidden lg:block absolute left-[50%] top-1/2 -translate-y-1/2 w-px h-16 bg-navy/20"></div>

                    <!-- Momentum -->
                    <div class="text-center">
                        <svg class="mx-auto h-10 w-10 text-gold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M14.615 1.595a.75.75 0 01.359.852L12.982 7.5h3.468a.75.75 0 01.548 1.262l-6.5 7a.75.75 0 01-1.272-.71l1.772-5.246H8.5a.75.75 0 01-.578-1.262l6.5-7a.75.75 0 011.093-.149z" clip-rule="evenodd" />
                            <path d="M5.385 3.352a.75.75 0 00-1.06 0l-2.5 2.5a.75.75 0 001.06 1.06L5.385 5.414V17.25a.75.75 0 001.5 0V4.06l1.56 1.56a.75.75 0 101.06-1.06l-2.5-2.5a.75.75 0 00-1.06 0z" />
                        </svg>
                        <h3 class="mt-4 uppercase text-sm tracking-wide text-navy font-medium">Momentum</h3>
                        <p class="mt-2 font-garet text-sm text-dark-text leading-[150%]">Clarity that moves<br>beyond the retreat.</p>
                    </div>

                    <!-- Divider -->
                    <div class="hidden lg:block absolute left-[75%] top-1/2 -translate-y-1/2 w-px h-16 bg-navy/20"></div>

                    <!-- Community -->
                    <div class="text-center">
                        <svg class="mx-auto h-10 w-10 text-gold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M4.5 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM14.25 8.625a3.375 3.375 0 116.75 0 3.375 3.375 0 01-6.75 0zM1.5 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM17.25 19.128l-.001.144a.75.75 0 01-.364.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122c0-.975.278-1.89.76-2.666a4.125 4.125 0 015.083-1.59 9.187 9.187 0 012.25 1.5 9.187 9.187 0 012.25-1.5 4.125 4.125 0 015.083 1.59c.482.776.76 1.691.76 2.666z" />
                        </svg>
                        <h3 class="mt-4 uppercase text-sm tracking-wide text-navy font-medium">Community</h3>
                        <p class="mt-2 font-garet text-sm text-dark-text leading-[150%]">A room full of leaders<br>growing together.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>
