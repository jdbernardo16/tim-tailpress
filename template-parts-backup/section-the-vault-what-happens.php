<?php

/**
 * The Vault Page - What Happens Inside Section template part.
 *
 * @package TailPress
 */

$items = array(
    'Live conversation with Joanna',
    'Real-time reflection and guidance',
    'Message clarity and refinement',
    'Honest conversations around visibility, leadership, and truth',
    'A space to ask the question you haven&#8217;t fully said out loud yet',
);
?>
<section class="bg-canvas pb-24 lg:pb-28">
    <div class="max-w-[1230px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-start gap-12 lg:gap-16">
            <!-- Image -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/vault-what-happens.webp" alt="Joanna Horton McPherson" class="w-full h-[458px] object-cover rounded-[10px]">
            </div>

            <!-- Text Content -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-dark-text leading-[1.1]">
                    What <em class="text-gold italic">Happens</em> Inside
                </h2>

                <ul class="mt-8 space-y-4">
                    <?php foreach ($items as $item) : ?>
                        <li class="flex items-start gap-4">
                            <svg class="w-6 h-6 flex-shrink-0 mt-1" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="7" cy="7" r="3" fill="#d4b478" />
                                <circle cx="17" cy="7" r="3" fill="#d4b478" />
                                <circle cx="7" cy="17" r="3" fill="#d4b478" />
                                <circle cx="17" cy="17" r="3" fill="#d4b478" />
                            </svg>
                            <span class="font-garet text-lg text-dark-text leading-[1.5]"><?php echo wp_kses_post($item); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <p class="mt-8 font-garet text-lg text-dark-text leading-[1.5] italic">
                    The Vault exists for women who know there is something important inside them — but haven&#8217;t fully found the language for it yet.
                </p>
            </div>
        </div>
    </div>
</section>
