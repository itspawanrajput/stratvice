<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Careers & Internships | Stratvice - Join Our Team</title>
    <meta name="description" content="Join Stratvice's dynamic team! Explore internship opportunities in digital marketing, web development, and design. Use our free tools: page speed test and service quotation calculator." />
    
    <!-- Open Graph -->
    <meta property="og:title" content="Careers & Internships | Stratvice" />
    <meta property="og:description" content="Join our team and grow your career in digital marketing. Internship opportunities available!" />
    
    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    
    <link href="./css/output.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="icon" type="image/x-icon" href="./img/icons/fabicon.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body class="font-sans">
    <!-- Navbar -->
    <header class="desktopHader bg-black fixed left-1/2 -translate-x-1/2 z-30 w-full" id="desktopHader">
        <nav class="w-full 2xl:w-[1500px] mx-auto flex justify-between items-center px-4 md:px-8 py-4 bg-opacity-80">
            <div class="text-2xl font-bold overflow-hidden">
                <div class="logo btoTop hidden md:block">
                    <a href="index.php">
                        <img src="./img/icons/stratvice-logo.svg" alt="stratvice logo" width="300" height="100">
                    </a>
                </div>
                <div class="logo block md:hidden">
                    <a href="index.php">
                        <img src="./img/icons/stratvice-logo.svg" alt="stratvice logo" width="300" height="100">
                    </a>
                </div>
            </div>
            <ul class="hidden lg:flex space-x-8 text-white btoTop overflow-hidden">
                <li><a href="index.php#home" class="hover:text-brand-main">Home</a></li>
                <li><a href="index.php#about" class="hover:text-brand-main">About</a></li>
                <li><a href="index.php#service" class="hover:text-brand-main">Services</a></li>
                <li><a href="careers.php" class="text-brand-main">Careers</a></li>
                <li><a href="index.php#contact" class="hover:text-brand-main">Contact</a></li>
            </ul>
            <div class="overflow-hidden hidden lg:block">
                <a href="index.php#contact" class="btn bg-brand-main px-5 py-2 block rounded text-white font-semibold hover:bg-blue-600">
                    Let's Connect
                </a>
            </div>
            <div class="block lg:hidden">
                <button class="w-24 text-right">
                    <i class="fa-solid fa-bars text-2xl w-full block" id="menuToggle"></i>
                </button>
            </div>
        </nav>
    </header>

    <!-- Mobile Menu -->
    <header id="phoneHeader" class="phoneHeader p-4 flex flex-col justify-between">
        <i class="fa-solid fa-xmark text-white absolute right-5 top-4 z-30" id="menuToggle2"></i>
        <nav class="h-full">
            <ul class="flex flex-col text-center space-y-4 text-white mt-5">
                <li><a href="index.php#home">Home</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#service">Services</a></li>
                <li><a href="careers.php" class="text-brand-main">Careers</a></li>
                <li><a href="index.php#contact">Contact</a></li>
            </ul>
        </nav>
        <div class="flex items-center gap-x-2">
            <a href="index.php#contact" class="bg-brand-main block text-center flex-1 py-2 rounded text-white font-semibold">
                Contact
            </a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-black relative overflow-hidden pt-24" id="home">
        <div class="gradient-hero absolute inset-0 z-0"></div>
        
        <div class="relative z-10 container-xl py-16 md:py-24 text-center">
            <h1 class="heading1 mb-6" data-aos="fade-up">
                Join Our <span class="gradient-text">Team</span>
            </h1>
            <p class="text-gray-300 text-lg md:text-xl max-w-3xl mx-auto mb-8" data-aos="fade-up" data-aos-delay="200">
                Be part of India's most innovative digital marketing agency. We're looking for passionate individuals ready to make an impact.
            </p>
            <a href="#positions" class="inline-block bg-gradient-to-r from-brand-main to-brand-accent px-8 py-4 rounded-lg text-white font-semibold hover-lift glow-blue transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                View Open Positions
            </a>
        </div>
    </section>

    <!-- Why Work With Us -->
    <section class="py-16 md:py-24">
        <div class="container-xl">
            <h2 class="heading2 text-center mb-12" data-aos="fade-up">Why Work With <span class="gradient-text">Stratvice</span>?</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="glass-card p-8 rounded-xl hover-lift" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-brand-main text-4xl mb-4">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Fast-Paced Growth</h3>
                    <p class="text-gray-400">Work on real projects from day one. Learn from industry experts and accelerate your career.</p>
                </div>

                <div class="glass-card p-8 rounded-xl hover-lift" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-brand-accent text-4xl mb-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Collaborative Culture</h3>
                    <p class="text-gray-400">Join a supportive team that values creativity, innovation, and continuous learning.</p>
                </div>

                <div class="glass-card p-8 rounded-xl hover-lift" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-brand-cyan text-4xl mb-4">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Skill Development</h3>
                    <p class="text-gray-400">Access to premium tools, training programs, and mentorship to enhance your skills.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Internship Positions -->
    <section class="py-16 md:py-24 bg-secondary" id="positions">
        <div class="container-xl">
            <h2 class="heading2 text-center mb-4" data-aos="fade-up">Internship <span class="gradient-text">Opportunities</span></h2>
            <p class="text-gray-400 text-center max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="100">
                Join us for a 3-6 month internship program. Gain hands-on experience and potentially convert to full-time.
            </p>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Digital Marketing Intern -->
                <div class="glass-card-strong p-6 rounded-xl hover-lift hover-glow" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold">Digital Marketing Intern</h3>
                        <span class="bg-brand-main px-3 py-1 rounded-full text-sm">Remote</span>
                    </div>
                    <p class="text-gray-400 mb-4">Learn SEO, PPC, social media marketing, and content strategy from industry experts.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-6">
                        <li><i class="fas fa-check text-brand-main mr-2"></i>Duration: 3-6 months</li>
                        <li><i class="fas fa-check text-brand-main mr-2"></i>Stipend: ₹5,000-10,000/month</li>
                        <li><i class="fas fa-check text-brand-main mr-2"></i>Certificate provided</li>
                    </ul>
                    <a href="#apply" class="block text-center bg-gradient-to-r from-brand-main to-brand-accent px-6 py-3 rounded-lg text-white font-semibold hover-lift transition-all duration-300">
                        Apply Now
                    </a>
                </div>

                <!-- Web Development Intern -->
                <div class="glass-card-strong p-6 rounded-xl hover-lift hover-glow" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold">Web Development Intern</h3>
                        <span class="bg-brand-accent px-3 py-1 rounded-full text-sm">Hybrid</span>
                    </div>
                    <p class="text-gray-400 mb-4">Build modern websites using React, PHP, and cutting-edge web technologies.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-6">
                        <li><i class="fas fa-check text-brand-accent mr-2"></i>Duration: 6 months</li>
                        <li><i class="fas fa-check text-brand-accent mr-2"></i>Stipend: ₹8,000-15,000/month</li>
                        <li><i class="fas fa-check text-brand-accent mr-2"></i>PPO opportunity</li>
                    </ul>
                    <a href="#apply" class="block text-center bg-gradient-to-r from-brand-accent to-brand-purple px-6 py-3 rounded-lg text-white font-semibold hover-lift transition-all duration-300">
                        Apply Now
                    </a>
                </div>

                <!-- Graphic Design Intern -->
                <div class="glass-card-strong p-6 rounded-xl hover-lift hover-glow" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold">Graphic Design Intern</h3>
                        <span class="bg-brand-cyan px-3 py-1 rounded-full text-sm">Remote</span>
                    </div>
                    <p class="text-gray-400 mb-4">Create stunning visuals, branding materials, and social media graphics.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-6">
                        <li><i class="fas fa-check text-brand-cyan mr-2"></i>Duration: 3-6 months</li>
                        <li><i class="fas fa-check text-brand-cyan mr-2"></i>Stipend: ₹5,000-10,000/month</li>
                        <li><i class="fas fa-check text-brand-cyan mr-2"></i>Portfolio building</li>
                    </ul>
                    <a href="#apply" class="block text-center bg-gradient-to-r from-brand-cyan to-brand-main px-6 py-3 rounded-lg text-white font-semibold hover-lift transition-all duration-300">
                        Apply Now
                    </a>
                </div>

                <!-- Content Writing Intern -->
                <div class="glass-card-strong p-6 rounded-xl hover-lift hover-glow" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold">Content Writing Intern</h3>
                        <span class="bg-brand-purple px-3 py-1 rounded-full text-sm">Remote</span>
                    </div>
                    <p class="text-gray-400 mb-4">Write SEO-optimized content, blogs, and marketing copy for diverse clients.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-6">
                        <li><i class="fas fa-check text-brand-purple mr-2"></i>Duration: 3-6 months</li>
                        <li><i class="fas fa-check text-brand-purple mr-2"></i>Stipend: ₹4,000-8,000/month</li>
                        <li><i class="fas fa-check text-brand-purple mr-2"></i>Byline credits</li>
                    </ul>
                    <a href="#apply" class="block text-center bg-gradient-to-r from-brand-purple to-brand-pink px-6 py-3 rounded-lg text-white font-semibold hover-lift transition-all duration-300">
                        Apply Now
                    </a>
                </div>

                <!-- Social Media Intern -->
                <div class="glass-card-strong p-6 rounded-xl hover-lift hover-glow" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold">Social Media Intern</h3>
                        <span class="bg-brand-pink px-3 py-1 rounded-full text-sm">Remote</span>
                    </div>
                    <p class="text-gray-400 mb-4">Manage social media accounts, create content calendars, and engage audiences.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-6">
                        <li><i class="fas fa-check text-brand-pink mr-2"></i>Duration: 3-6 months</li>
                        <li><i class="fas fa-check text-brand-pink mr-2"></i>Stipend: ₹5,000-10,000/month</li>
                        <li><i class="fas fa-check text-brand-pink mr-2"></i>Flexible hours</li>
                    </ul>
                    <a href="#apply" class="block text-center bg-gradient-to-r from-brand-pink to-brand-main px-6 py-3 rounded-lg text-white font-semibold hover-lift transition-all duration-300">
                        Apply Now
                    </a>
                </div>

                <!-- Video Editing Intern -->
                <div class="glass-card-strong p-6 rounded-xl hover-lift hover-glow" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold">Video Editing Intern</h3>
                        <span class="bg-brand-main px-3 py-1 rounded-full text-sm">Remote</span>
                    </div>
                    <p class="text-gray-400 mb-4">Edit promotional videos, reels, and video content for social media campaigns.</p>
                    <ul class="text-sm text-gray-400 space-y-2 mb-6">
                        <li><i class="fas fa-check text-brand-main mr-2"></i>Duration: 3-6 months</li>
                        <li><i class="fas fa-check text-brand-main mr-2"></i>Stipend: ₹6,000-12,000/month</li>
                        <li><i class="fas fa-check text-brand-main mr-2"></i>Creative freedom</li>
                    </ul>
                    <a href="#apply" class="block text-center bg-gradient-to-r from-brand-main to-brand-cyan px-6 py-3 rounded-lg text-white font-semibold hover-lift transition-all duration-300">
                        Apply Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Tools Section -->
    <section class="py-16 md:py-24" id="tools">
        <div class="container-xl">
            <h2 class="heading2 text-center mb-4" data-aos="fade-up">Free Marketing <span class="gradient-text">Tools</span></h2>
            <p class="text-gray-400 text-center max-w-2xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="100">
                Try our professional-grade tools to analyze your website and estimate project costs.
            </p>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Page Speed Test Tool -->
                <div class="glass-card-strong p-8 rounded-xl" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <div class="text-brand-main text-3xl mr-4">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold">Page Speed Test</h3>
                            <p class="text-gray-400 text-sm">Analyze your website's performance</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-2">Enter Website URL</label>
                            <input type="url" id="speedTestUrl" placeholder="https://example.com" 
                                class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-main transition-all duration-300">
                        </div>
                        <button onclick="analyzeSpeed()" 
                            class="w-full bg-gradient-to-r from-brand-main to-brand-accent px-6 py-3 rounded-lg text-white font-semibold hover-lift glow-blue transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>Analyze Speed
                        </button>
                    </div>

                    <div id="speedResults" class="mt-6 hidden">
                        <div class="bg-black/30 rounded-lg p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Performance Score</span>
                                <span id="perfScore" class="text-2xl font-bold gradient-text">--</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-3">
                                <div id="perfBar" class="bg-gradient-to-r from-brand-main to-brand-accent h-3 rounded-full transition-all duration-1000" style="width: 0%"></div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <p class="text-gray-400 text-sm">Load Time</p>
                                    <p id="loadTime" class="text-xl font-semibold">-- s</p>
                                </div>
                                <div>
                                    <p class="text-gray-400 text-sm">Page Size</p>
                                    <p id="pageSize" class="text-xl font-semibold">-- MB</p>
                                </div>
                            </div>
                            <div id="recommendations" class="mt-4">
                                <p class="text-sm font-semibold mb-2">Recommendations:</p>
                                <ul id="recList" class="text-sm text-gray-400 space-y-1"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Quotation Calculator -->
                <div class="glass-card-strong p-8 rounded-xl" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-6">
                        <div class="text-brand-accent text-3xl mr-4">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold">Service Quotation</h3>
                            <p class="text-gray-400 text-sm">Estimate your project cost</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-3">Select Services</label>
                            <div class="space-y-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="service-checkbox mr-3" data-price="15000" onchange="calculateQuote()">
                                    <span>SEO Optimization (₹15,000/month)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="service-checkbox mr-3" data-price="20000" onchange="calculateQuote()">
                                    <span>PPC Advertising (₹20,000/month)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="service-checkbox mr-3" data-price="25000" onchange="calculateQuote()">
                                    <span>Website Development (₹25,000)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="service-checkbox mr-3" data-price="12000" onchange="calculateQuote()">
                                    <span>Social Media Marketing (₹12,000/month)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="service-checkbox mr-3" data-price="8000" onchange="calculateQuote()">
                                    <span>Content Writing (₹8,000/month)</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="service-checkbox mr-3" data-price="10000" onchange="calculateQuote()">
                                    <span>Graphic Design (₹10,000/month)</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm text-gray-400 mb-2">Project Duration (months)</label>
                            <input type="range" id="duration" min="1" max="12" value="3" 
                                class="w-full" oninput="updateDuration(); calculateQuote()">
                            <div class="flex justify-between text-sm text-gray-400 mt-1">
                                <span>1</span>
                                <span id="durationValue" class="text-brand-main font-semibold">3 months</span>
                                <span>12</span>
                            </div>
                        </div>

                        <div class="bg-black/30 rounded-lg p-6 mt-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-400">Estimated Total</span>
                                <span id="totalCost" class="text-3xl font-bold gradient-text">₹0</span>
                            </div>
                            <p class="text-xs text-gray-500">*Prices are indicative. Final quote may vary based on requirements.</p>
                        </div>

                        <a href="index.php#contact" 
                            class="block text-center bg-gradient-to-r from-brand-accent to-brand-purple px-6 py-3 rounded-lg text-white font-semibold hover-lift transition-all duration-300">
                            Get Detailed Quote
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form -->
    <section class="py-16 md:py-24 bg-secondary" id="apply">
        <div class="container-xl max-w-3xl">
            <h2 class="heading2 text-center mb-4" data-aos="fade-up">Apply for <span class="gradient-text">Internship</span></h2>
            <p class="text-gray-400 text-center mb-12" data-aos="fade-up" data-aos-delay="100">
                Fill out the form below and we'll get back to you within 48 hours.
            </p>

            <form id="internshipForm" class="glass-card-strong p-8 rounded-xl space-y-6" data-aos="fade-up" data-aos-delay="200">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Full Name *</label>
                        <input type="text" required 
                            class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-main transition-all duration-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Email *</label>
                        <input type="email" required 
                            class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-main transition-all duration-300">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Phone *</label>
                        <input type="tel" required 
                            class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-main transition-all duration-300">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-2">Position *</label>
                        <select required 
                            class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-main transition-all duration-300">
                            <option value="">Select Position</option>
                            <option>Digital Marketing Intern</option>
                            <option>Web Development Intern</option>
                            <option>Graphic Design Intern</option>
                            <option>Content Writing Intern</option>
                            <option>Social Media Intern</option>
                            <option>Video Editing Intern</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">Portfolio/LinkedIn URL</label>
                    <input type="url" 
                        class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-main transition-all duration-300">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-2">Why do you want to join Stratvice? *</label>
                    <textarea required rows="4" 
                        class="w-full bg-black/50 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand-main transition-all duration-300"></textarea>
                </div>

                <button type="submit" 
                    class="w-full bg-gradient-to-r from-brand-main to-brand-accent px-8 py-4 rounded-lg text-white font-semibold hover-lift glow-blue transition-all duration-300">
                    Submit Application
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-secondary text-white px-4 md:px-8 py-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <div>
                    <a href="index.php">
                        <img src="./img/icons/stratvice-logo.svg" alt="stratvice logo" width="300" height="100">
                    </a>
                </div>
                <p class="text-sm mt-2 text-gray-300">
                    Empowering startups and SMEs with creative branding, digital marketing, and web solutions.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="https://www.instagram.com/stratvice" class="text-pink-400 hover:scale-110 transition-transform">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/Stratvice" class="text-blue-600 hover:scale-110 transition-transform">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3">Quick Links</h3>
                <ul class="space-y-2 text-gray-300 text-sm">
                    <li><a href="index.php#home" class="hover:text-white">Home</a></li>
                    <li><a href="index.php#about" class="hover:text-white">About Us</a></li>
                    <li><a href="index.php#service" class="hover:text-white">Services</a></li>
                    <li><a href="careers.php" class="hover:text-white">Careers</a></li>
                    <li><a href="index.php#contact" class="hover:text-white">Contact</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3">Services</h3>
                <ul class="space-y-2 text-gray-300 text-sm">
                    <li><a href="index.php#service" class="hover:text-white">Digital Marketing</a></li>
                    <li><a href="index.php#service" class="hover:text-white">Web Development</a></li>
                    <li><a href="index.php#service" class="hover:text-white">Content Writing</a></li>
                    <li><a href="index.php#service" class="hover:text-white">SEO</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3">Contact</h3>
                <ul class="space-y-3 text-gray-300 text-sm">
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-phone-alt text-white"></i>
                        <a href="tel:8368666105">8368666105</a>
                    </li>
                    <li class="flex flex-col space-x-2">
                        <a href="mailto:stratvice@gmail.com"><i class="fas fa-envelope text-white"></i>&nbsp;&nbsp;stratvice@gmail.com</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-10 pt-4 text-center text-sm text-gray-400">
            2024 © All rights reserved by <span class="text-blue-500">Stratvice</span>.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="./js/mix.js"></script>

    <script>
        AOS.init({ once: true, easing: "ease-out-cubic" });

        // Page Speed Test
        function analyzeSpeed() {
            const url = document.getElementById('speedTestUrl').value;
            if (!url) {
                alert('Please enter a valid URL');
                return;
            }

            const resultsDiv = document.getElementById('speedResults');
            resultsDiv.classList.remove('hidden');

            // Simulate analysis (in production, use Google PageSpeed Insights API)
            const score = Math.floor(Math.random() * 30) + 70; // 70-100
            const loadTime = (Math.random() * 2 + 1).toFixed(2); // 1-3s
            const pageSize = (Math.random() * 3 + 1).toFixed(2); // 1-4MB

            setTimeout(() => {
                document.getElementById('perfScore').textContent = score;
                document.getElementById('perfBar').style.width = score + '%';
                document.getElementById('loadTime').textContent = loadTime + ' s';
                document.getElementById('pageSize').textContent = pageSize + ' MB';

                const recommendations = [
                    'Optimize images for web',
                    'Enable browser caching',
                    'Minify CSS and JavaScript',
                    'Use a Content Delivery Network (CDN)'
                ];

                const recList = document.getElementById('recList');
                recList.innerHTML = '';
                recommendations.forEach(rec => {
                    const li = document.createElement('li');
                    li.innerHTML = `<i class="fas fa-lightbulb text-brand-main mr-2"></i>${rec}`;
                    recList.appendChild(li);
                });
            }, 1500);
        }

        // Quotation Calculator
        function updateDuration() {
            const duration = document.getElementById('duration').value;
            document.getElementById('durationValue').textContent = duration + ' month' + (duration > 1 ? 's' : '');
        }

        function calculateQuote() {
            const checkboxes = document.querySelectorAll('.service-checkbox:checked');
            const duration = parseInt(document.getElementById('duration').value);
            let total = 0;

            checkboxes.forEach(checkbox => {
                const price = parseInt(checkbox.dataset.price);
                total += price;
            });

            // Multiply by duration for monthly services
            total = total * duration;

            document.getElementById('totalCost').textContent = '₹' + total.toLocaleString('en-IN');
        }

        // Form submission
        document.getElementById('internshipForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Thank you for your application! We will review it and get back to you within 48 hours.');
            this.reset();
        });
    </script>
</body>

</html>
