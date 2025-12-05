<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php';
ps://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body class="font-sans">
    <!-- Navbar -->
    <header class="desktopHader bg-black fixed left-1/2 -translate-x-1/2 z-30 w-full" id="desktopHader">
        <nav class="w-full 2xl:w-[1500px] mx-auto flex justify-between items-center px-4 md:px-8 py-4 bg-opacity-80">
            <div class="text-2xl font-bold text-blue-[#2b7fff] overflow-hidden">
                <div class="logo btoTop hidden md:block">
                    <!-- <span class="text-brand-main">Strat</span><span class="text-white">vice</span> -->
                    <a href="/">
                        <img src="./img/icons/stratvice-logo.svg" alt="stratvice logo" width="300" height="100">
                    </a>
                </div>
                <div class="logo block md:hidden">
                    <!-- <span class="text-brand-main">Strat</span><span class="text-white">vice</span> -->
                    <a href="/">
                        <img src="./img/icons/stratvice-logo.svg" alt="stratvice logo" width="300" height="100">
                    </a>
                </div>
            </div>
            <ul class="hidden md:flex space-x-8 text-white btoTop border. border-green-400. overflow-hidden  ">
                <li><a href="#home" class="hover:text-blue-[#2b7fff]">Home</a></li>
                <li><a href="#about" class="hover:text-blue-[#2b7fff]">About</a></li>
                <li><a href="#service" class="hover:text-blue-[#2b7fff]">Services</a></li>
                <!-- <li><a href="#projects" class="hover:text-blue-[#2b7fff]">Projects</a></li> -->
                <li><a href="#contact" class="hover:text-blue-[#2b7fff]">Contact</a></li>
            </ul>
            <div class="overflow-hidden hidden md:block">
                <button class="btn bg-brand-main px-5 py-2 rounded text-white font-semibold hover:bg-blue-600">
                    Get Started
                </button>
            </div>
            <div class="block md:hidden">
                <button class="w-24 text-right">
                    <i class="fa-solid fa-bars text-2xl w-full  block" id="menuToggle"></i>
                </button>
            </div>
        </nav>
    </header>

    <header id="phoneHeader" class="phoneHeader p-4 flex flex-col justify-between">
        <i class="fa-solid fa-xmark text-white absolute right-5 top-4 z-30" id="menuToggle2"></i>
        <nav>
            <ul class="flex flex-col space-y-3 text-white btoTop. border. border-green-400. overflow-hidden  ">
                <li><a href="#home" class="hover:text-blue-[#2b7fff]">Home</a></li>
                <li><a href="#about" class="hover:text-blue-[#2b7fff]">About</a></li>
                <li><a href="#service" class="hover:text-blue-[#2b7fff]">Services</a></li>
                <!-- <li><a href="#projects" class="hover:text-blue-[#2b7fff]">Projects</a></li> -->
                <li><a href="#contact" class="hover:text-blue-[#2b7fff]">Contact</a></li>
            </ul>
        </nav>
        <div class="flex items-center gap-x-2">
            <button class="bg-brand-main flex-1 py-2 rounded text-white font-semibold hover:bg-blue-600">
                Get Started
            </button>
             <button class="bg-secondary flex-1 py-2 rounded text-white font-semibold hover:bg-blue-600">
                Get Started
            </button>
        </div>
       
    </header>


    <!-- Hidden Content -->
    <div id="menuContent" class="mt-4 hidden bg-gray-200 p-4 rounded">
        This is your toggleable menu or content.
    </div>


    <!-- Hero Section -->
    <section class="bg-black" id="home">
        <div
            class="w-full 2xl:w-[1500px] px-2 md:px-8 md:pt-16 mx-auto flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 justify-end text-right md:mt-0 flex md:hidden" data-aos="fade-left">
                <div id="business-goal" class="lottie-player !w-full lg:w-[60px] lg:h-[600px]"></div>
            </div>

            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="heading1 mb-4" data-aos="fade-right" data-aos-duration="1200">
                    Achieve Your Goals<br> with Our Expert<br>Marketing
                    <span class="text-brand-main">Strat</span>egies</span>
                </h1>
                <p class="mb-6 text-gray-300" data-aos="fade-right" data-aos-delay="400" data-aos-duration="1200">
                    Stratvice stands for A Strategic Advertising, Branding & Marketing Agency — India’s most affordable
                    solution for small and medium businesses. Our mission is to deliver agency-level creativity and
                    results through digital marketing, branding, and website development—tailored to help you grow,
                    whether you're just starting or scaling up.
                </p>
                <button class="bg-brand-main px-6 py-3 rounded text-white font-semibold hover:bg-blue-600"
                    data-aos="fade-right" data-aos-delay="500" data-aos-duration="1200">
                    Get Free Consultation
                </button>
                <div class="flex items-center mt-6 space-x-4 justify-center md:justify-start" data-aos="fade-right"
                    data-aos-delay="400" data-aos-duration="1200">
                    <img src="./img/digital-marketing-agency.png" class="w-5 h-5 hidden md:block"
                        title="digital-marketing-agency" alt="digital-marketing-agency" />
                    <span class="text-gray-400">4.9/5 Rating</span>
                    <span class="text-gray-400">|</span>
                    <span class="text-gray-400">Trusted by 100+ clients</span>
                </div>
            </div>
            <div class="md:w-1/2 justify-end text-right mt-10 md:mt-0 hidden md:flex" data-aos="fade-left"
                data-aos-delay="200" data-aos-duration="1400">
                <div id="business-goal" class="lottie-player !w-full lg:w-[60px] lg:h-[600px]"></div>
            </div>
        </div>
    </section>

    <!-- Brands -->
    <section class="hidden md:block">
        <div class="container-xl rounded-xl overflow-hidden bg-secondary mt-16 mb-16">
            <div id="client-marquee" class="flex items-center  animate-marquee gray"></div>
        </div>


    </section>
    <section class="block md:hidden">
        <div class="container-xl rounded-xl overflow-hidden bg-secondary mt-16 mb-16">
            <div id="client-carousel" class="owl-carousel owl-theme">
                <img src="./img/clients/client-1.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-2.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-3.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-4.jpg" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-5.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-6.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-7.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-8.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-9.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
                <img src="./img/clients/client-10.png" alt="client-1"
                    class="w-[150px] h-[120px] object-contain grayscale-100 hover:grayscale-0">
            </div>
        </div>


    </section>



    <!-- Expertise -->
    <section class="md:pt-16 px-4 text-center" id="service">
        <div class="overflow-hidden">
            <h2 class="heading1 mb-4 mt-10" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                Our Digital Marketing Expertise
            </h2>
        </div>

        <div class="overflow-hidden">
            <p class="text-gray-400 max-w-3xl mx-auto mb-10" data-aos="fade-up" data-aos-delay="400"
                data-aos-duration="1200">
                We combine smart digital marketing with modern web development to help your business thrive online. From
                increasing visibility through SEO and social media to building fast, responsive websites that
                convert—everything we do is geared toward growth. Our solutions are tailored, budget-friendly, and built
                to support small and medium businesses at every stage.
            </p>
        </div>


        <!-- Owl Carousel -->
        <div class="md:w-[calc(75%+13%)] ml-auto md:mr-[-0.5%]">
            <div class="owl-carousel owl-theme" id="expertise">
                <!-- Website Development -->
                <div class="bg-[#111] rounded-lg p-6 text-left card-shadow">
                    <img src="./img/icons/webiste-development.png" alt="Website Development" title="Website Development"
                        class="!w-16" />
                    <h3 class="text-lg font-semibold mb-2">Website Development</h3>
                    <p class="text-sm text-gray-400">
                        Fast, responsive websites built to grow your business.
                    </p>
                </div>

                <!-- Content Writing -->
                <div class="bg-[#111] rounded-lg p-6 text-left card-shadow">
                    <img src="./img/icons/content-writing.png" alt="Content Writing" title="Content Writing"
                        class="!w-16" />
                    <h3 class="text-lg font-semibold mb-2">Content Writing</h3>
                    <p class="text-sm text-gray-400">
                        SEO-friendly content that speaks to your audience.
                    </p>
                </div>

                <!-- Social Media -->
                <div class="bg-[#111] rounded-lg p-6 text-left card-shadow">
                    <img src="./img/icons/social-media-marketing.png" alt="Social Media" title="Social Media"
                        class="!w-16" />
                    <h3 class="text-lg font-semibold mb-2">Social Media</h3>
                    <p class="text-sm text-gray-400">
                        Grow engagement and reach with strategic social campaigns.
                    </p>
                </div>

                <!-- SEO -->
                <div class="bg-[#111] rounded-lg p-6 text-left card-shadow">
                    <img src="./img/icons/seo.png" alt="SEO" title="SEO" class="!w-16" />
                    <h3 class="text-lg font-semibold mb-2">SEO</h3>
                    <p class="text-sm text-gray-400">
                        Rank higher and get discovered by the right audience.
                    </p>
                </div>

                <!-- Website Development (Duplicate) -->
                <div class="bg-[#111] rounded-lg p-6 text-left card-shadow">
                    <img src="./img/icons/webiste-development.png" alt="Website Development" title="Website Development"
                        class="!w-16" />
                    <h3 class="text-lg font-semibold mb-2">Website Development</h3>
                    <p class="text-sm text-gray-400">
                        Clean design, fast loading, and mobile-friendly performance.
                    </p>
                </div>

                <!-- Content Writing (Duplicate) -->
                <div class="bg-[#111] rounded-lg p-6 text-left card-shadow">
                    <img src="./img/icons/content-writing.png" alt="Content Writing" title="Content Writing"
                        class="!w-16" />
                    <h3 class="text-lg font-semibold mb-2">Content Writing</h3>
                    <p class="text-sm text-gray-400">
                        Compelling copy that connects, converts, and ranks well.
                    </p>
                </div>
            </div>
        </div>

    </section>

    <!-- About & Goals -->
    <section class="" id="about">
        <div
            class="w-full 2xl:w-[1500px] mx-auto flex flex-col md:flex-row items-center justify-between px-4 md:px-8 pt-16  md:py-16 bg-black">
            <div class="md:w-1/2 flex justify-right mb-10 md:mb-0" data-aos="fade-right" data-aos-delay="400"
                data-aos-duration="1200">
                <div class="gradient relative w-full md:w-[400px] h-[300px] md:h-[450px] z-10 flex items-end justify-center rounded-tl-full rounded-tr-full rounded-b-[0.7rem]"
                    style="
              border-bottom-left-radius: 0.7rem;
              border-bottom-right-radius: 0.7rem;
            ">
                    <img src="./img/computer.webp" alt="Team"
                        class="rounded-2xl w-[40rem] object-contain md:absolute bottom-0 z-30 -right-[3rem]" />
                </div>
            </div>
            <div class="md:w-1/2" data-aos="fade-left">
                <div class="overflow-hidden">
                    <h2 class="heading1 mb-4" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                        Turn Your Ideas Into Online Success
                    </h2>
                </div>
                <p class="text-gray-300 mb-4" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                    Every business starts with an idea — we help bring it to life. At Stratvice, we build modern
                    websites, create strong branding, and run digital marketing that gets real results. Whether you're
                    starting or growing, we make it easy and affordable to succeed online.
                </p>
                <button class="bg-brand-main px-6 py-3 rounded text-white font-semibold hover:bg-blue-600"
                    data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                    Learn More
                </button>
            </div>
        </div>
    </section>

    <!-- Collaboration -->
    <section class="">
        <div
            class="w-full 2xl:w-[1500px] mx-auto flex flex-col-reverse md:grid md:grid-cols-2 gap-x-20 bg-black mt-10 px-4 md:px-8 items-center">
            <div class="" data-aos="fade-right">
                <div class="overflow-hidden">
                    <h2 class="heading1 mb-4" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                        Working together, to create something unique.
                    </h2>
                </div>

                <p class="text-gray-300" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                    At Stratvice, we believe that the best results come from true collaboration. That’s why we work
                    closely with you to understand your business, your goals, and your audience. Together, we craft
                    digital solutions that reflect your brand's personality and purpose—from custom website design and
                    development to tailored marketing strategies that drive engagement and conversions.
                </p>
                <p class="text-gray-300 mt-4 hidden lg:block" data-aos="fade-up" data-aos-delay="400"
                    data-aos-duration="1200">
                    Our team blends creative thinking with technical expertise to ensure every project stands out.
                    Whether it’s launching a new brand, building a user-friendly website, or running a data-driven ad
                    campaign, we partner with you at every step to create something truly unique and effective. With
                    Stratvice, your ideas are not just heard—they’re brought to life with strategy, skill, and impact.
                </p>
                <button class="bg-brand-main px-6 py-3 rounded text-white font-semibold hover:bg-blue-600 mt-5"
                    data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                    Learn More
                </button>
            </div>
            <div class="flex justify-center mt-10 md:mt-0" data-aos="fade-left" data-aos-delay="400"
                data-aos-duration="1200">
                <!-- businessman -->
                <img src="./img/working-together.jpg" alt="Collaboration" class="rounded-2xl" />
            </div>
        </div>
    </section>

    <!-- Achievements -->
    <section class="py-12 px-8 md:px-8 bg-secondary mt-[4rem]">
        <div
            class="container mx-auto grid grid-cols-2 md:flex items-center justify-evenly text-center flex-wrap gap-y-5">
            <div>
                <h4 class="text-2xl md:text-4xl font-bold text-brand-main">6,324+</h4>
                <p class="text-white">Projects</p>
            </div>
            <div>
                <h4 class="text-2xl md:text-4xl font-bold text-brand-main">9,708K+</h4>
                <p class="text-white">Clients</p>
            </div>
            <div>
                <h4 class="text-2xl md:text-4xl font-bold text-brand-main">8,003K+</h4>
                <p class="text-white">Success</p>
            </div>
            <div>
                <h4 class="text-2xl md:text-4xl font-bold text-brand-main">6,537K+</h4>
                <p class="text-white">Pay Per Click</p>
            </div>
        </div>
    </section>



    <!-- Testimonials Slider -->
    <section class="py-16 px-4 md:px-8">
        <div class="overflow-hidden">
            <h2 class="heading1 text-center mb-10" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">What
                Our Clients Say</h2>
        </div>
        <div class="owl-carousel owl-theme mb-8 text-left" id="testimonal1">
            <div class="item bg-secondary rounded-xl p-6 mx-2 flex gap-1">
                <div>
                    <h4 class="font-semibold mb-1 text-[1rem] leading-[1.1rem]">Amit Sharma</h4>
                    <div class="flex text-yellow-400 mb-2 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i> <!-- 4 stars -->
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    "Stratvice gave my local business a strong digital presence. Their team is responsive, affordable,
                    and highly skilled."
                </p>
            </div>

            <div class="item bg-secondary rounded-xl p-6 mx-2 flex gap-1">
                <div>
                    <h4 class="font-semibold mb-1 text-[1rem] leading-[1.1rem]">Priya Verma</h4>
                    <div class="flex text-yellow-400 mb-2 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i> <!-- 5 stars -->
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    "From branding to website, they handled everything smoothly. The results were beyond my
                    expectations!"
                </p>
            </div>

            <div class="item bg-secondary rounded-xl p-6 mx-2 flex gap-1">
                <div>
                    <h4 class="font-semibold mb-1 text-[1rem] leading-[1.1rem]">Rahul Mehta</h4>
                    <div class="flex text-yellow-400 mb-2 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i> <!-- 4 stars -->
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    "Great value for money! Their SEO and social media work helped us attract more leads than ever
                    before."
                </p>
            </div>
        </div>

        <div class="owl-carousel owl-theme" id="testimonal2">
            <div class="item bg-secondary rounded-xl p-6 mx-2 flex gap-1">
                <div>
                    <h4 class="font-semibold mb-1 text-[1rem] leading-[1.1rem]">Neha Kapoor</h4>
                    <div class="flex text-yellow-400 mb-2 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i> <!-- 5 stars -->
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    "Very professional team. They understood my vision and built a clean, fast-loading website for my
                    boutique."
                </p>
            </div>

            <div class="item bg-secondary rounded-xl p-6 mx-2 flex gap-1">
                <div>
                    <h4 class="font-semibold mb-1 text-[1rem] leading-[1.1rem]">Vikram Desai</h4>
                    <div class="flex text-yellow-400 mb-2 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i> <!-- 4 stars -->
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    "Loved their branding work. Now my business looks much more premium, and customers are noticing!"
                </p>
            </div>

            <div class="item bg-secondary rounded-xl p-6 mx-2 flex gap-1">
                <div>
                    <h4 class="font-semibold mb-1 text-[1rem] leading-[1.1rem]">Sneha Reddy</h4>
                    <div class="flex text-yellow-400 mb-2 text-sm">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i> <!-- 5 stars -->
                    </div>
                </div>
                <p class="text-gray-400 text-sm">
                    "They made digital marketing easy to understand. Got great results with Google Ads and social media
                    campaigns."
                </p>
            </div>
        </div>


    </section>

    <!-- Contact section -->
    <section class="text-white py-12 px-4 flex. items-center justify-center form-section" id="contact">
        <div class="md:py-20">
            <div class="overflow-hidden">
                <h2 class="heading1 text-center mb-10" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1200">
                    What Contact Us</h2>
            </div>

            <div class="md:flex items-center w-full 2xl:w-[1500px] mx-auto pt-4">
                <div class="customer-care md:w-[50rem] block md:hidden"></div>
                <div class="w-full max-w-3xl border. border-white. rounded-xl. md:py-8 md:px-12">

                    <form id="contactForm" class="space-y-6">
                        <!-- Name -->
                        <div class="mb-14">
                            <!-- <label for="name" class="block mb-1">Name</label> -->
                            <input type="text" name="name" id="name" class="input" placeholder="Enter Your Name" />
                        </div>

                        <!-- Phone -->
                        <div class="mb-14">
                            <!-- <label for="phone" class="block mb-1">Phone</label> -->
                            <input type="text" name="phone" id="phone" class="input" placeholder="Enter Your Number" />
                        </div>

                        <!-- Email -->
                        <div class="mb-14">
                            <!-- <label for="email" class="block mb-1">Email</label> -->
                            <input type="email" name="email" id="email" class="input" placeholder="Enter Your Email" />
                        </div>

                        <!-- Location -->
                        <div class="mb-14">
                            <!-- <label for="message" class="block mb-1">Message</label> -->
                            <input name="location" id="location" rows="4" class="input"
                                placeholder="Enter Your Message"></input>
                        </div>

                        <!-- location -->
                        <div class="mb-14">
                            <!-- <label for="location" class="block mb-1">location</label> -->
                            <input name="location" id="location" rows="4" class="input"
                                placeholder="Enter Your Location"></input>
                        </div>

                        <!-- Message -->
                        <div class="mb-14">
                            <!-- <label for="message" class="block mb-1">Message</label> -->
                            <input name="message" id="message" rows="4" class="input"
                                placeholder="Enter Your Message"></input>
                        </div>


                        <!-- Submit -->
                        <div class="text-center.">
                            <button type="submit"
                                class="bg-white text-black px-6 py-2 rounded font-semibold hover:bg-gray-200 transition cursor-pointer">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
                <div class="customer-care md:w-[50rem] hidden md:block opacity-90"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-secondary text-white px-4 md:px-8 py-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Logo & Description -->
            <div class="">
                <!-- <h2 class="text-xl font-bold text-blue-400">D<span class="text-white">igital</span></h2> -->
                <div class="">
                    <a href="/">
                        <img src="./img/icons/stratvice-logo.svg" alt="stratvice logo" width="300" height="100">
                    </a>
                </div>
                <p class="text-sm mt-2 text-gray-300">
                    Empowering startups and SMEs with creative branding, digital marketing, and web solutions—affordably
                    and effectively.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-pink-400 hover:scale-110 transition-transform">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-sky-400 hover:scale-110 transition-transform">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-blue-600 hover:scale-110 transition-transform">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-gray-300 text-sm">
                    <li><a href="#home" class="hover:text-white">Home</a></li>
                    <li><a href="#about" class="hover:text-white">About Us</a></li>
                    <li><a href="#service" class="hover:text-white">Services</a></li>
                    <li><a href="#contact" class="hover:text-white">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold mb-3">Services</h3>
                <ul class="space-y-2 text-gray-300 text-sm">
                    <li><a href="#service" class="hover:text-white">Digital Marketing</a></li>
                    <li><a href="#service" class="hover:text-white">Web Development</a></li>
                    <li><a href="#service" class="hover:text-white">Content Writing</a></li>
                    <li><a href="#service" class="hover:text-white">Seo</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-3">Contact</h3>
                <ul class="space-y-3 text-gray-300 text-sm">
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-phone-alt text-white"></i>
                        <a href="tel:8368666105">8368666105</a>
                    </li>
                    <li class="flex flex-col space-x-2">

                        <a href="mailto:vikash.stratvice@gmail.com"><i
                                class="fas fa-envelope text-white"></i>&nbsp;&nbsp;vikash.stratvice@gmail.com,</a>

                    </li>
                    <li class="flex flex-col space-x-2">

                        <a href="mailto:stratvice@gmail.com"><i
                                class="fas fa-envelope text-white"></i>&nbsp;&nbsp;stratvice@gmail.com</a>
                    </li>
                    <!-- <li class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt text-white"></i>
                        <span>6391 Elgin St. Celina, Delaware 10299</span>
                    </li> -->
                </ul>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-700 mt-10 pt-4 text-center text-sm text-gray-400">
            2024 © All rights reserved by <span class="text-blue-500">Stratvice</span> .
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <!-- GSAP & ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollTrigger/1.0.6/ScrollTrigger.min.js"></script>
    <script src="./js/mix.js"></script>
    <script src="./js/validate.js"></script>
</body>

</html>