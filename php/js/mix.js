//   document.querySelectorAll('.heading-animate .heading1').forEach((el, i) => {
//     el.setAttribute('data-aos', 'fade-up');
//     el.setAttribute('data-aos-delay', i * 100); // optional: staggered delay
//     el.setAttribute('data-aos-duration', '1000');
//   });

// Now initialize AOS
AOS.init({
  once: true,
  easing: "ease-out-cubic",
});

$(window).on("scroll", function () {
  if ($(this).scrollTop() > 50) {
    $("header").addClass("!bg-[#060606]/80 backdrop-blur-md shadow-md");
  } else {
    $("header").removeClass("!bg-[#060606]/80 backdrop-blur-md shadow-md");
  }
});

$(document).ready(function () {
  const testimonal1 = $("#testimonal1");
  const testimonal2 = $("#testimonal2");
  testimonal1.owlCarousel({
    loop: true,
    margin: 24,
    nav: false,
    dots: false,
    autoplay: true,
    autoplaySpeed: 3000,
    autoplayTimeout: 3000,
    smartSpeed: 3000,
    rtl: true,
    responsive: {
      0: { items: 1 },
      768: { items: 2 },
      1024: { items: 5, dots: false },
    },
  });
  testimonal2.owlCarousel({
    loop: true,
    margin: 24,
    nav: false,
    dots: false,
    autoplay: true,
    autoplaySpeed: 3000,
    autoplayTimeout: 3000,
    smartSpeed: 3000,
    rtl: false,
    responsive: {
      0: { items: 1 },
      768: { items: 2 },
      1024: { items: 5, dots: false },
    },
  });
  $("#expertise").owlCarousel({
    loop: true,
    margin: 24,
    nav: true,
    dots: false,
    autoplay: false,
    autoplaySpeed: 3000,
    autoplayTimeout: 3000,
    smartSpeed: 3000,
    rtl: false,
    responsive: {
      0: { items: 1 },
      768: { items: 2 },
      1024: { items: 8, dots: false },
    },
  });


  const logos = [
    "client-1.png",
    "client-6.png",
    "client-9.png",
    "client-10.jpg",
    "client-12.png",
    "client-13.png",
    "client-14.png",
    "client-15.png",
    "client-17.png",
    "client-18.png",
  ];

  const container = document.getElementById("client-marquee");

  // Repeat the logos twice for infinite scroll illusion
  const repeatedLogos = [...logos, ...logos, ...logos, ...logos, ...logos];

  repeatedLogos.forEach((logo) => {
    const wrapper = document.createElement("div");
    wrapper.className = "w-[150px] h-[120px] md:px-4";
    const img = document.createElement("img");
    img.src = `./img/clients/${logo}`;
    img.alt = logo;
    img.title = logo;
    img.className = "w-full h-full object-contain grayscale-100 hover:grayscale-0";
    wrapper.appendChild(img);
    container.appendChild(wrapper);
  });



  // Stop autoplay when any slide is hovered or focused
  //   testimonal1.on("mouseenter focusin", ".item", function () {
  //     testimonal1.trigger("stop.owl.autoplay");
  //   });

  // Optional: Resume autoplay on mouseleave or blur
  //   testimonal1.on("mouseleave focusout", ".item", function () {
  //     testimonal1.trigger("play.owl.autoplay", [3000]);
  //   });

  // Stop autoplay when any slide is hovered or focused
  //   testimonal2.on("mouseenter focusin", ".item", function () {
  //     testimonal2.trigger("stop.owl.autoplay");
  //   });

  // Optional: Resume autoplay on mouseleave or blur
  //   testimonal2.on("mouseleave focusout", ".item", function () {
  //     testimonal2.trigger("play.owl.autoplay", [3000]);
  //   });
});

document.querySelectorAll(".lottie-player").forEach((el) => {
  lottie.loadAnimation({
    container: el,
    renderer: "svg",
    loop: true,
    autoplay: true,
    path: "business-goal.json",
  });
});
document.querySelectorAll(".customer-care").forEach((el) => {
  lottie.loadAnimation({
    container: el,
    renderer: "svg",
    loop: true,
    autoplay: true,
    path: "customer-care.json",
  });
});

// Register ScrollTrigger
gsap.registerPlugin(ScrollTrigger);

gsap.from(".btoTop li, .btoTop", {
  y: "40px",
  opacity: 0,
  stagger: 0.2, // animate in sequence
  duration: 0.8,
  ease: "power3.out",
});
gsap.from(".btn", {
  y: "40px",
  opacity: 0,
  stagger: 0.2, // animate in sequence
  duration: 0.8,
  delay: 1,
  ease: "power3.out",
});

// projects

const cardData = {
  branding: [
    {
      title: "Logo Design",
      image: "https://via.placeholder.com/300x180?text=Logo",
      description: "Unique, memorable logo tailored to your brand.",
    },
    {
      title: "Business Cards",
      image: "https://via.placeholder.com/300x180?text=Business+Card",
      description: "Elegant designs for professional networking.",
    },
    {
      title: "Brand Guide",
      image: "https://via.placeholder.com/300x180?text=Brand+Guide",
      description: "A complete brand manual for consistency.",
    },
  ],
  marketing: [
    {
      title: "SEO Campaign",
      image: "https://via.placeholder.com/300x180?text=SEO",
      description: "Rank your business higher on Google.",
    },
    {
      title: "Email Marketing",
      image: "https://via.placeholder.com/300x180?text=Email",
      description: "Engage your customers with smart emails.",
    },
    {
      title: "Lead Funnel",
      image: "https://via.placeholder.com/300x180?text=Funnel",
      description: "Convert traffic into loyal customers.",
    },
  ],
  website: [
    {
      title: "Landing Page",
      image: "https://via.placeholder.com/300x180?text=Landing",
      description: "Attractive and high-converting landing pages.",
    },
    {
      title: "E-commerce",
      image: "https://via.placeholder.com/300x180?text=Ecommerce",
      description: "Modern web shops built to sell.",
    },
    {
      title: "Portfolio",
      image: "https://via.placeholder.com/300x180?text=Portfolio",
      description: "Clean designs to showcase your work.",
    },
  ],
};

const tabs = document.querySelectorAll(".tab-btn");
const container = document.getElementById("card-container");
let currentTab = "branding";
let autoplayInterval;

function renderCards(tab) {
  const items = cardData[tab];
  container.innerHTML = "";

  items.forEach((item) => {
    const card = document.createElement("a");
    card.href = "#";
    card.className =
      "card project-card border border-white rounded-xl overflow-hidden p-5 group rounded-xl overflow-hidden p-5 group opacity-0 translate-y-10";

    card.innerHTML = `
        <img
    src="./img/working-together.jpg"
    alt="Project 1"
    class="project-img rounded-xl"
  />
  <div class="p-5">
    <div class="flex items-center justify-between">
      <h3 class="text-xl font-semibold mb-2">Project Title 1</h3>
      <i
        class="fa-solid fa-arrow-pointer rotate-[60deg] text-[1.5rem] group-hover:-translate-y-1.5 group-hover:translate-x-1.5 ease-in duration-300"
      ></i>
    </div>
    <p class="text-gray-600 text-sm">
      Brief description of the project with clean, readable lines. Built with
      HTML, CSS, JS.
    </p>
  </div>
    `;

    // card.innerHTML = `
    //   <img src="${item.image}" alt="${item.title}" class="w-full h-48 object-cover rounded-xl mb-4" />
    //   <div class="p-2">
    //     <div class="flex items-center justify-between mb-2">
    //       <h3 class="text-xl font-semibold text-black">${item.title}</h3>
    //       <i class="fa-solid fa-arrow-pointer rotate-[60deg] text-[1.5rem] text-blue-500 group-hover:-translate-y-1.5 group-hover:translate-x-1.5 transition duration-300"></i>
    //     </div>
    //     <p class="text-gray-600 text-sm">${item.description}</p>
    //   </div>
    // `;

    container.appendChild(card);
  });

  // Wait until cards are fully added to the DOM
  requestAnimationFrame(() => {
    gsap.fromTo(
      ".card",
      { opacity: 0, y: 20 },
      {
        opacity: 1,
        y: 0,
        duration: 0.6,
        stagger: 0.1,
        ease: "power2.out",
      }
    );
  });
}

function switchTab(tabName) {
  currentTab = tabName;
  tabs.forEach((tab) => {
    const isActive = tab.dataset.tab === tabName;
    tab.classList.toggle("border-brand-main", isActive);
    tab.classList.toggle("text-brand-main", isActive);
    tab.classList.toggle("border-white", !isActive);
  });

  renderCards(tabName);
}

function autoplayTabs() {
  const keys = Object.keys(cardData);
  let index = keys.indexOf(currentTab);
  index = (index + 1) % keys.length;
  switchTab(keys[index]);
}

function resetAutoplay() {
  clearInterval(autoplayInterval);
  autoplayInterval = setInterval(autoplayTabs, 4000);
}

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    switchTab(tab.dataset.tab);
    resetAutoplay();
  });
});

// Init
switchTab(currentTab);
resetAutoplay();
