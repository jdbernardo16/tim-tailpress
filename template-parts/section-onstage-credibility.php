<?php

/**
 * On Stage Page - Credibility Section template part.
 *
 * @package TailPress
 */

$engagements = array(
    array(
        array(
            'badge' => 'PODCAST',
            'title' => 'Makers Bar Interview with Joanna Horton McPherson, Social Entrepreneur Thought Leader',
            'date'  => '2025',
        ),
        array(
            'badge' => 'KEYNOTE',
            'title' => 'Speak &amp; Rise: Women Speakers Leading From The Stage',
            'date'  => 'Jan 2026',
        ),
        array(
            'badge' => 'PANEL',
            'title' => 'Speak &amp; Rise: Executive Leading from the Stage',
            'date'  => 'Feb 2026',
        ),
        array(
            'badge' => 'KEYNOTE',
            'title' => 'Annual Harvard Alumni for Global Women&#8217;s Empowerment',
            'date'  => 'Apr 2026',
        ),
    ),
    array(
        array(
            'badge' => 'PODCAST',
            'title' => 'Women in Global Leadership',
            'date'  => 'Nov 2025',
        ),
        array(
            'badge' => 'KEYNOTE',
            'title' => 'GCU Investment Club',
            'date'  => 'Jan 2026',
        ),
        array(
            'badge' => 'KEYNOTE',
            'title' => 'Top Talent Hollywood',
            'date'  => 'May 2026',
        ),
        array(
            'badge' => 'KEYNOTE',
            'title' => 'The WILDx Experience: A stage for truth and transformation',
            'date'  => 'Dec 2025',
        ),
    ),
    array(
        array(
            'badge' => 'KEYNOTE',
            'title' => 'President of NAWBO Phoenix',
            'date'  => '2025',
        ),
        array(
            'badge' => 'KEYNOTE',
            'title' => 'She Means Business Magazine &#8212; The Premier National Magazine for America&#8217;s Best Women Entrepreneurs',
            'date'  => 'Jan 2026',
        ),
        array(
            'badge' => 'KEYNOTE',
            'title' => 'Phoenix Business Journal&#8217;s Mentoring Monday',
            'date'  => 'Feb 2026',
        ),
        array(
            'badge' => 'KEYNOTE',
            'title' => '2nd Annual Scale Up Symposium',
            'date'  => 'Apr 2026',
        ),
    ),
);
?>

<section class="bg-canvas px-4 sm:px-10">
    <div class="relative overflow-hidden rounded-[20px] bg-navy">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-10" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bg-texture.png" alt="">
        </div>

        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 right-0 w-[1535px] h-[1535px] bg-deep-blue/30 rounded-full blur-3xl transform translate-x-1/3"></div>
            <div class="absolute top-0 left-0 w-[1525px] h-[1525px] bg-gold/10 rounded-full blur-3xl transform -translate-x-2/3 -translate-y-2/3"></div>
        </div>

        <div class="absolute -top-3 left-1/2 -translate-x-1/2 pointer-events-none select-none">
            <h2 class="font-flatline font-bold text-[117px] leading-none text-transparent bg-clip-text bg-gradient-to-b from-white to-white/0 opacity-20">
                CREDIBILITY
            </h2>
        </div>

        <div class="relative max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center mb-20">
                <h2 class="font-flatline font-medium text-4xl md:text-5xl lg:text-[56px] text-white leading-tight">
                    Where She's <em class="text-gold italic">Been.</em>
                </h2>
            </div>

            <div class="relative mb-20">
                <div class="swiper onstage-credibility-featured-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="flex flex-col lg:flex-row items-center gap-[64px]">
                                <div class="w-full lg:w-[708px] rounded-[10px] bg-white overflow-hidden flex-shrink-0">
                                    <div class="w-full h-[400px] bg-zinc-200">
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-cohort.png" alt="Forbes article" class="w-full h-full object-cover">
                                    </div>
                                </div>

                                <div class="w-full lg:w-[328px] flex flex-col gap-6">
                                    <div class="inline-flex self-start items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-[3px]">
                                        <span class="font-flatline font-black text-xs text-warm-beige tracking-[0.15em]">KEYNOTE</span>
                                    </div>

                                    <h3 class="font-flatline font-semibold text-gold text-[22px] leading-[110%]">
                                        Forbes -<br>
                                        Why Fostering Belonging Is Key For Supporting Women Investors
                                    </h3>

                                    <p class="font-garet text-white text-lg">
                                        March 2026
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="flex flex-col lg:flex-row items-center gap-[64px]">
                                <div class="w-full lg:w-[708px] rounded-[10px] bg-white overflow-hidden flex-shrink-0">
                                    <div class="w-full h-[400px] bg-zinc-200">
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-cohort.png" alt="Speaker feature" class="w-full h-full object-cover">
                                    </div>
                                </div>

                                <div class="w-full lg:w-[328px] flex flex-col gap-6">
                                    <div class="inline-flex self-start items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-[3px]">
                                        <span class="font-flatline font-black text-xs text-warm-beige tracking-[0.15em]">KEYNOTE</span>
                                    </div>

                                    <h3 class="font-flatline font-semibold text-gold text-[22px] leading-[110%]">
                                        Harvard Alumni -<br>
                                        Annual Harvard Alumni for Global Women&#8217;s Empowerment
                                    </h3>

                                    <p class="font-garet text-white text-lg">
                                        Apr 2026
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="flex flex-col lg:flex-row items-center gap-[64px]">
                                <div class="w-full lg:w-[708px] rounded-[10px] bg-white overflow-hidden flex-shrink-0">
                                    <div class="w-full h-[400px] bg-zinc-200">
                                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/speaker-cohort.png" alt="Speaker feature" class="w-full h-full object-cover">
                                    </div>
                                </div>

                                <div class="w-full lg:w-[328px] flex flex-col gap-6">
                                    <div class="inline-flex self-start items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-[3px]">
                                        <span class="font-flatline font-black text-xs text-warm-beige tracking-[0.15em]">PANEL</span>
                                    </div>

                                    <h3 class="font-flatline font-semibold text-gold text-[22px] leading-[110%]">
                                        WILDx -<br>
                                        The WILDx Experience: A stage for truth and transformation
                                    </h3>

                                    <p class="font-garet text-white text-lg">
                                        Dec 2025
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="onstage-credibility-featured-nav">
                    <button class="onstage-credibility-featured-swiper-button-prev onstage-credibility-featured-nav__btn" aria-label="Previous slide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </button>
                    <button class="onstage-credibility-featured-swiper-button-next onstage-credibility-featured-nav__btn" aria-label="Next slide">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <?php foreach ($engagements as $row) : ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                        <?php foreach ($row as $card) : ?>
                            <div class="rounded-[10px] bg-white/15 backdrop-blur-[9px] border border-gold p-5 min-h-[201px] flex flex-col">
                                <div class="inline-flex self-start items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-[3px]">
                                    <span class="font-flatline font-black text-xs text-warm-beige tracking-[0.15em]"><?php echo esc_html($card['badge']); ?></span>
                                </div>
                                <h4 class="font-flatline font-semibold text-gold text-lg leading-[110%] mt-2 flex-1">
                                    <?php echo wp_kses_post($card['title']); ?>
                                </h4>
                                <p class="font-garet text-white text-sm mt-6">
                                    <?php echo esc_html($card['date']); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>