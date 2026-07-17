// mobile menu toogle icon
document.addEventListener("DOMContentLoaded", function () {
  const toggler = document.querySelector(".navbar-toggler");
  const openIcon = toggler.querySelector(".open-icon");
  const closeIcon = toggler.querySelector(".close-icon");

  toggler.addEventListener("click", function () {
    const expanded = this.getAttribute("aria-expanded") === "true";
    openIcon.classList.toggle("d-none", expanded);
    closeIcon.classList.toggle("d-none", !expanded);
  });
});
// Country dropdown with AJAX switching and page reload
document.addEventListener("DOMContentLoaded", function(){
  const toggle = document.getElementById("country-toggle");
  const dropdown = document.getElementById("country-dropdown");
  const label = document.getElementById("selected-label");
  const flag = document.getElementById("selected-flag");
  
  window.defaultCountrySlug = 'usa';
  window.defaultCountryName = 'USA';
  
  if (!toggle || !dropdown) return;
  
  // Sync dropdown with URL parameter
  const urlParams = new URLSearchParams(window.location.search);
  const urlCountry = urlParams.get('country');
  if (urlCountry && label && flag) {
    const matchingItem = dropdown.querySelector('[data-country="' + urlCountry + '"]');
    if (matchingItem) {
      const countryName = matchingItem.getAttribute('data-name');
      const flagUrl = matchingItem.getAttribute('data-flag');
      if (countryName) label.textContent = countryName;
      if (flagUrl) flag.src = flagUrl;
    }
  }

  // Toggle dropdown
  toggle.addEventListener("click", (e) => {
    e.stopPropagation();
    dropdown.classList.toggle("show-dropdown");
  });

  // Handle country selection
  dropdown.querySelectorAll(".dropdown-item").forEach(item => {
    item.addEventListener("click", (e) => {
      e.stopPropagation();
      const country = item.getAttribute("data-country");
      const name = item.getAttribute("data-name");
      const flagUrl = item.getAttribute("data-flag");

      // Save to cookie with SameSite attribute
      const expires = new Date();
      expires.setTime(expires.getTime() + (30 * 24 * 60 * 60 * 1000));
      document.cookie = 'smart_selected_country=' + country + '; expires=' + expires.toUTCString() + '; path=/; SameSite=Lax';
      
      // Update UI immediately
      if (label) label.textContent = name;
      if (flag && flagUrl) flag.src = flagUrl;
      dropdown.classList.remove("show-dropdown");
      
      // Redirect with country parameter (cookie will be read from URL param)
      const url = new URL(window.location.href);
      url.searchParams.set('country', country);
      window.location.href = url.toString();
    });
  });

  // Close when clicking outside
  document.addEventListener("click", e => {
    if (toggle && dropdown && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.remove("show-dropdown");
    }
  });
  
  // Append country parameter to all internal links
  function getCountryFromCookie() {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
      const [name, value] = cookie.trim().split('=');
      if (name === 'smart_selected_country') return value;
    }
    return null;
  }
  
  const country = getCountryFromCookie();
  if (country) {
    document.querySelectorAll('a').forEach(link => {
      const href = link.getAttribute('href');
      if (href && !href.startsWith('#') && !href.startsWith('mailto:') && !href.startsWith('tel:')) {
        try {
          const url = new URL(href, window.location.origin);
          if (url.origin === window.location.origin && !url.searchParams.has('country')) {
            url.searchParams.set('country', country);
            link.setAttribute('href', url.toString());
          }
        } catch (e) {}
      }
    });
  }
});

// Filter services by country - defined in global scope for accessibility
window.filterServicesByCountry = function(countryCode) {
    if (!countryCode) {
      return;
    }
    
    const countryLower = countryCode.toLowerCase().trim();
    
    // Filter service cards on service page
    const serviceItems = document.querySelectorAll('.service-item');
    serviceItems.forEach(item => {
      const itemCountry = item.getAttribute('data-country');
      if (itemCountry) {
        const itemCountryLower = itemCountry.toLowerCase().trim();
        if (itemCountryLower === countryLower) {
          item.style.display = '';
          item.classList.add('service-visible');
          item.classList.remove('service-hidden');
        } else {
          item.style.display = 'none';
          item.classList.add('service-hidden');
          item.classList.remove('service-visible');
        }
      } else {
        item.style.display = '';
      }
    });

    // Filter service menu items on home page
    const menuItems = document.querySelectorAll('.js-services-menu .menu-item-card');
    let firstVisibleMenu = true;
    let visibleMenuCount = 0;
    
    menuItems.forEach(item => {
      const itemCountry = item.getAttribute('data-country');
      if (itemCountry) {
        const itemCountryLower = itemCountry.toLowerCase().trim();
        if (itemCountryLower === countryLower) {
          item.style.display = '';
          item.style.visibility = 'visible';
          item.style.opacity = '1';
          if (firstVisibleMenu) {
            item.classList.add('active');
            firstVisibleMenu = false;
          } else {
            item.classList.remove('active');
          }
          visibleMenuCount++;
        } else {
          item.style.display = 'none';
          item.style.visibility = 'hidden';
          item.style.opacity = '0';
          item.classList.remove('active');
        }
      } else {
        item.style.display = '';
        if (firstVisibleMenu) {
          item.classList.add('active');
          firstVisibleMenu = false;
        }
        visibleMenuCount++;
      }
    });
    
    // Filter stack cards on home page
    const stackItems = document.querySelectorAll('.js-stack-cards__item');
    let firstVisibleStack = true;
    let visibleStackCount = 0;
    
    stackItems.forEach(item => {
      const itemCountry = item.getAttribute('data-country');
      if (itemCountry) {
        const itemCountryLower = itemCountry.toLowerCase().trim();
        if (itemCountryLower === countryLower) {
          item.style.display = '';
          if (firstVisibleStack) {
            item.classList.add('is-active');
            firstVisibleStack = false;
          } else {
            item.classList.remove('is-active');
          }
          visibleStackCount++;
        } else {
          item.style.display = 'none';
          item.classList.remove('is-active');
        }
      } else {
        item.style.display = '';
        if (firstVisibleStack) {
          item.classList.add('is-active');
          firstVisibleStack = false;
        }
        visibleStackCount++;
      }
    });
        
    // Trigger any custom events if needed
    const event = new CustomEvent('countryFiltered', { detail: { country: countryCode } });
    document.dispatchEvent(event);
};

// Filter services on page load based on current country
document.addEventListener("DOMContentLoaded", function() {
  function applyCountryFilter() {
    let countryCode = 'usa'; // Default to Australia
    
    // Try to get from URL parameter first (highest priority after page reload)
    const urlParams = new URLSearchParams(window.location.search);
    const urlCountry = urlParams.get('country');
    if (urlCountry) {
      countryCode = urlCountry;
    } else if (typeof SmartCountry !== 'undefined' && SmartCountry.currentCountry) {
      // Try SmartCountry object
      countryCode = SmartCountry.currentCountry;
    } else {
      // Fallback: get from cookie
      const cookies = document.cookie.split(';');
      for (let cookie of cookies) {
        const [name, value] = cookie.trim().split('=');
        if (name === 'smart_selected_country' && value) {
          countryCode = value;
          break;
        }
      }
    }
    
    if (countryCode && typeof window.filterServicesByCountry === 'function') {
      window.filterServicesByCountry(countryCode);
    }
  }
  
  // Apply filter after DOM is ready
  setTimeout(applyCountryFilter, 100);
  
  // Also apply after a longer delay to catch dynamically loaded content
  setTimeout(applyCountryFilter, 500);
  
  // Apply when stack cards are initialized (if there's a custom event)
  document.addEventListener('stackCardsReady', function() {
    setTimeout(applyCountryFilter, 100);
  });
  
  // Listen for country changes
  document.addEventListener('countryFiltered', function(e) {
  });
});

 /*------------------------------
Register plugins
------------------------------*/

const contentRainbow = document.querySelector('#smart-content-rainbow')

/*------------------------------
Making some circles noise (disabled on mobile)
------------------------------*/
// Check if device is mobile/tablet (defined once for entire script)
const isMobile = window.innerWidth <= 768 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

// Only create rainbow circles on desktop
if (!isMobile && contentRainbow) {
  const simplex = new SimplexNoise()
  for (let i = 0; i < 5000; i++) {
    const div = document.createElement('div')
    div.classList.add('smart-circle-rainbow')
    const n1 = simplex.noise2D(i * 0.003, i * 0.0033)
    const n2 = simplex.noise2D(i * 0.002, i * 0.001)
    
    const style = {
      transform: `translate(${n2 * 200}px) rotate(${n2 * 270}deg) scale(${3 + n1 * 2}, ${3 + n2 * 2})`,
      boxShadow: `0 0 0 .2px hsla(105, ${50 + (i % 20)}%, ${65 + (i % 20)}%, .6)`
      }
    Object.assign(div.style, style)
    contentRainbow.appendChild(div)
  }
  const circlesRainbow = document.querySelectorAll('.smart-circle-rainbow')

  /*------------------------------
  Init ScrollSmoother
  ------------------------------*/
  const scrollerSmootherRainbow = ScrollSmoother.create({
    content: contentRainbow,
    wrapper: '#smart-wrapper-rainbow',
    smooth: 1,
    effects: false
  });
  gsap.registerPlugin(ScrollTrigger, scrollerSmootherRainbow)
  /*------------------------------
  Scroll Trigger
  ------------------------------*/
  const mainRainbow = gsap.timeline({
    scrollTrigger: {
      scrub: .7,
      start: "top 25%",
      end: "bottom bottom"
    }
  })
  circlesRainbow.forEach((circle) => {
    mainRainbow.to(circle, {
      opacity: 1,
    })
  })
} else {
  // On mobile: just register ScrollTrigger without rainbow
  gsap.registerPlugin(ScrollTrigger)
}

  // ------------------------------
  // Calculator setup (only if host elements exist)
  // ------------------------------

  const buttonsData = [
    'AC', 'CE', '%', '÷',
    '7', '8', '9', '×',
    '4', '5', '6', '-',
    '1', '2', '3', '+',
    '0', '00', '.', '='
  ];

  const buttonsContainer = document.getElementById('buttons');
  const display = document.getElementById('display');
  const calculator = document.getElementById('calculator');
  const siteHeader = document.getElementById('siteHeader');
  const nav = document.getElementById('menu');


  // Toggle navbar 'stuck' class when it hits the very top
  const headerEl = siteHeader;
  const updateNavbarStuck = () => {
    if (!headerEl) return;
    const isAtTop = window.scrollY > 0;
    headerEl.classList.toggle('stuck', isAtTop);
  };
  updateNavbarStuck();
  window.addEventListener('scroll', updateNavbarStuck, { passive: true });

  // Measure sticky elements and expose heights as CSS variables
  const setStickyHeights = () => {
    const root = document.documentElement;
    const headerH = siteHeader ? siteHeader.offsetHeight : 0;
    const menuH = nav ? nav.offsetHeight : 0;
    root.style.setProperty('--site-header-h', headerH + 'px');
    root.style.setProperty('--services-menu-h', menuH + 'px'); // existing var used elsewhere
    root.style.setProperty('--menu-card-h', menuH + 'px');     // ensure CSS in home.css gets correct value
  };
  setStickyHeights();
  window.addEventListener('resize', setStickyHeights);

  // If calculator DOM is not present (e.g. About page), skip all calculator logic
  if (buttonsContainer && display && calculator) {

  const getButtonDimensions = () => {
    const screenWidth = window.innerWidth;
    
    if (screenWidth <= 480) {
      // Mobile phones
      return {
        btnWidth: 46,
        btnHeight: 46,
        gap: 14,
        displayOffsetY: 130
      };
    } else if (screenWidth <= 768) {
      // Tablets
      return {
        btnWidth: 52,
        btnHeight: 52,
        gap: 16,
        displayOffsetY: 80
      };
    } else {
      // Desktop
      return {
        btnWidth: 56,
        btnHeight: 56,
        gap: 18,
        displayOffsetY: 130
      };
    }
  };

  let { btnWidth, btnHeight, gap, displayOffsetY } = getButtonDimensions();
  const positions = [];
  const base = (typeof ThemeData !== 'undefined' && ThemeData.assetsUrl) ? ThemeData.assetsUrl : '/wp-content/themes/smart-calsee/assets/image/';

  const imageMap = {
  'AC': base + 'group-ac.png',
  'CE': base + 'group-ce.png',
  '%': base + 'percentage.png',
  '÷': base + 'group-divide.png',
  '×': base + 'group-x.png',
  '+': base + 'group-plus.png',
  '-': base + 'group-minus.png',
  '=': base + 'group-equal.png',
  '.': base + 'group-dot.png',
  '1': base + 'group-1.png',
  '2': base + 'group-2.png',
  '3': base + 'group-3.png',
  '4': base + 'group-4.png',
  '5': base + 'group-5.png',
  '6': base + 'group-6.png',
  '7': base + 'group-7.png',
  '8': base + 'group-8.png',
  '9': base + 'group-9.png',
  '0': base + 'group-0.png',
  '00': base + 'group-00.png'
};

  buttonsData.forEach((label, index) => {
  const btn = document.createElement('button');
  btn.classList.add('btn');

  const imgSrc = imageMap[label];
  if (imgSrc) {
    const img = document.createElement('img');
    img.src = imgSrc;
    img.alt = label;
    btn.appendChild(img);
  } else {
    btn.textContent = label; // fallback if image missing
  }

  // Assign classes
  const isOperator = ['+', '-', '×', '÷', '%'].includes(label);
  const isCtrl = ['AC', 'CE'].includes(label);
  if (!isOperator && !isCtrl && label !== '=') btn.classList.add('number');
  if (isOperator) btn.classList.add('operator');
  if (label === '=') btn.classList.add('equal');
  if (label === 'AC') btn.classList.add('clear');
  if (isCtrl) btn.classList.add('ctrl');

  const row = Math.floor(index / 4);
  const col = index % 4;
  const x = col * (btnWidth + gap);
  const y = displayOffsetY + row * (btnHeight + gap);
  positions.push({ x, y });

  // Random initial scatter position
  btn.style.left = `${Math.random() * window.innerWidth}px`;
  btn.style.top = `${Math.random() * window.innerHeight}px`;

    // Click behavior
    btn.addEventListener('click', () => {
      if (label === 'AC') {
          display.value = '';
      } else if (label === 'CE') {
          display.value = display.value.slice(0, -1);
      } else if (label === '=') {
          try {
          let expr = display.value
              .replace(/×/g, '*')
              .replace(/÷/g, '/')
              .replace(/%/g, '/100');  // ✅ convert percent to division
          display.value = eval(expr);
          } catch {
          display.value = 'Error';
          }
      } else if (label === '00') {
          display.value += '00';
      } else {
          display.value += label;
      }
  });

    buttonsContainer.appendChild(btn);
  });

  // Animate into calculator grid (with mobile optimization)
  // Note: ScrollTrigger already registered above

  const buttons = gsap.utils.toArray('.btn');
  if (buttons.length > 0 && typeof gsap !== 'undefined') {
    
    // Calculate proper offset based on calculator padding
    const getCalculatorOffset = () => {
      const calcRect = calculator.getBoundingClientRect();
      const calcPadding = parseInt(getComputedStyle(calculator).paddingLeft) || 20;
      return calcPadding;
    };
    
    buttons.forEach((btn, i) => {
      const { x, y } = positions[i];
      
      // Different animation approach for mobile
       if (isMobile) {
        // Mobile: Smooth scroll-linked animation
        const leftOffset = getCalculatorOffset();
        
        gsap.fromTo(btn, 
          {
            // Start from random position with opacity 0
            opacity: 0,
            top: Math.random() * window.innerHeight,
            left: Math.random() * window.innerWidth
          },
          {
            // Animate to proper position with full opacity
            opacity: 1,
            top: calculator.offsetTop + y,
            left: calculator.offsetLeft + x + leftOffset,
            ease: "power2.out",
            scrollTrigger: {
              trigger: calculator,
              start: "top bottom",
              end: "top 30%",
              scrub: 2, // Smooth scroll-linked (lower = faster)
              toggleActions: "play none none reverse"
            }
          }
        );
      }else {
        // Desktop: Scrub animation from scatter
        gsap.fromTo(btn,
          {
            // Start from random position
            top: Math.random() * window.innerHeight,
            left: Math.random() * window.innerWidth
          },
          {
            // Animate to proper position
            top: () => calculator.offsetTop + y,
            left: () => {
              const leftOffset = getCalculatorOffset();
              return calculator.offsetLeft + x + leftOffset;
            },
            ease: "power2.out",
            scrollTrigger: {
              trigger: calculator,
              start: "top bottom",
              end: "top 30%",
              scrub: 4
            }
          }
        );
      }
    });
    
    // Refresh ScrollTrigger after setup
    if (typeof ScrollTrigger !== 'undefined') {
      setTimeout(() => ScrollTrigger.refresh(), 100);
    }
  }

  }


  /* rotating globe theme (only if container exists) */
  (function() {
    const container = document.querySelector('.globe-container');
    if (!container) return; 

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(
      45,
      (container.clientWidth || 600) / (container.clientHeight || 420),
      0.1,
      1000
    );
    camera.position.z = 3;

    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
    renderer.setPixelRatio(window.devicePixelRatio || 1);
    renderer.setSize(container.clientWidth || 600, container.clientHeight || 420);
    container.appendChild(renderer.domElement);

    // Lighting
    const light = new THREE.AmbientLight(0xffffff, 1.2);
    scene.add(light);

    // Load local image texture
    const textureLoader = new THREE.TextureLoader();
    const globeBase = (typeof ThemeData !== 'undefined' && ThemeData.assetsUrl)
      ? ThemeData.assetsUrl
      : '/wp-content/themes/smart-calsee/assets/image/';
    const texture = textureLoader.load(globeBase + 'mask_group.png');

    // Material
    const material = new THREE.MeshPhongMaterial({
      map: texture,
      transparent: true,
      opacity: 0.9,
      side: THREE.DoubleSide
    });

    // Half-sphere geometry
    const geometry = new THREE.SphereGeometry(
      1, 64, 64, 0, Math.PI * 2, 0, Math.PI / 2
    );

    const globe = new THREE.Mesh(geometry, material);
    scene.add(globe);

    // Animation loop
    function animate() {
      requestAnimationFrame(animate);
      globe.rotation.y += 0.005;
      renderer.render(scene, camera);
    }
    animate();

    // Responsive
    window.addEventListener("resize", () => {
      const width = container.clientWidth || 600;
      const height = container.clientHeight || 420;
      renderer.setSize(width, height);
      camera.aspect = width / height;
      camera.updateProjectionMatrix();
    });
  })();

  // Menu -> Card swipe + smooth scroll
 (function() {
  var menu = document.getElementById('menu-card');
  if (!menu) return;

  var menuItems = Array.prototype.slice.call(menu.querySelectorAll('.menu-item-card'));
  var cards = Array.prototype.slice.call(document.querySelectorAll('.js-stack-cards__item'));

  // Build key maps
  var keyToCard = {};
  cards.forEach(function(card){
    var key = card.getAttribute('data-key');
    if (key) keyToCard[key] = card;
  });

  var headerEl = document.getElementById('siteHeader');
  var menuEl = document.getElementById('menu-card');
  function getStickyOffset() {
    var h = headerEl ? headerEl.offsetHeight : 0;
    var m = menuEl ? menuEl.offsetHeight : 0;
    return h + m + 12; // small gap
  }

  function cardIndexByKey(key){
    var visibleIndex = 0;
    for (var i=0;i<cards.length;i++){
      if (cards[i].style.display === 'none') continue;
      if (cards[i].getAttribute('data-key') === key) return visibleIndex;
      visibleIndex++;
    }
    return -1;
  }

  function currentActiveKey(){
    var active = menu.querySelector('.menu-item-card.active');
    return active ? active.getAttribute('data-target') : null;
  }

  function setActiveMenu(key){
    menuItems.forEach(function(mi){ mi.classList.toggle('active', mi.getAttribute('data-target') === key); });
  }

  function smoothScrollTo(y){
    try {
      window.scrollTo({ top: y, behavior: 'smooth' });
    } catch(e) {
      window.scrollTo(0, y);
    }
  }

  function swipeIn(card, direction){
    if (!window.gsap || !card) return;
    var textBlock = card.querySelector('.card-content');
    var imageEl = card.querySelector('img');
    var imageBlock = imageEl ? imageEl.closest('.col-12') || imageEl.parentElement : null;
    
    if (textBlock && imageBlock) {
      gsap.killTweensOf([textBlock, imageBlock]);
      gsap.fromTo(textBlock, 
        { x: direction * 100, opacity: 0 }, 
        { x: 0, opacity: 1, duration: 0.5, ease: 'power2.out' }
      );
      gsap.fromTo(imageBlock, 
        { x: -direction * 100, opacity: 0 }, 
        { x: 0, opacity: 1, duration: 0.5, ease: 'power2.out' }
      );
    }
  }

  var scrollLock = false;
  var lockTimeout = null;

  function scrollToCardByKey(key){
    var card = keyToCard[key];
    if (!card) return;
    
    var index = cardIndexByKey(key);
    if (index < 0) return;
    
    if (lockTimeout) clearTimeout(lockTimeout);
    scrollLock = true;
    
    setActiveMenu(key);
    cards.forEach(function(c){ c.classList.remove('is-active'); });
    card.classList.add('is-active');
    
    var stackContainer = document.querySelector('.js-stack-cards');
    var containerTop = stackContainer ? stackContainer.offsetTop : 0;
    var marginYValue = stackContainer ? getComputedStyle(stackContainer).getPropertyValue('--stack-cards-gap') : '12px';
    var marginY = 12;
    if (marginYValue) {
      var temp = document.createElement('div');
      temp.style.cssText = 'position:absolute;visibility:hidden;height:' + marginYValue;
      document.body.appendChild(temp);
      marginY = parseInt(getComputedStyle(temp).height) || 12;
      document.body.removeChild(temp);
    }
    
    var cardHeight = card.offsetHeight;
    var cardOffset = index * (cardHeight + marginY);
    var targetY = containerTop + cardOffset - getStickyOffset();
    
    smoothScrollTo(targetY);
    
    lockTimeout = setTimeout(function(){
      scrollLock = false;
      lockTimeout = null;
    }, 800);
  }

  // Click handling
  menuItems.forEach(function(item){
    item.addEventListener('click', function(){
      var key = item.getAttribute('data-target');
      if (key) scrollToCardByKey(key);
    });
  });

  // Keep menu active in sync while scrolling by measuring visibility
  var ticking = false;
  function updateActiveOnScroll(){
    ticking = false;
    if (scrollLock) return;
    var offsetTop = getStickyOffset();
    var viewTop = offsetTop;
    var viewBottom = window.innerHeight;

    var bestKey = null;
    var bestVisible = -1;

    for (var i=0;i<cards.length;i++){
      var c = cards[i];
      var rect = c.getBoundingClientRect();
      var top = rect.top;
      var bottom = rect.bottom;

      var visible = Math.max(0, Math.min(bottom, viewBottom) - Math.max(top, viewTop));
      if (visible > bestVisible){
        bestVisible = visible;
        bestKey = c.getAttribute('data-key');
      }
    }
    if (bestKey && bestKey !== currentActiveKey()) {
      setActiveMenu(bestKey);
      cards.forEach(function(c){ 
        c.classList.toggle('is-active', c.getAttribute('data-key') === bestKey);
      });
    }
  }

  function onScroll(){
    if (!ticking){
      ticking = true;
      window.requestAnimationFrame(updateActiveOnScroll);
    }
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll);
  // initial sync
  updateActiveOnScroll();
})();

(function() {
  // Utility function for reduced motion detection
  function hasReducedMotion() {
    if(!window.matchMedia) return false;
    var matchMediaObj = window.matchMedia('(prefers-reduced-motion: reduce)');
    if(matchMediaObj) return matchMediaObj.matches;
    return false;
  }

  // Stacking Cards functionality
  var StackCards = function(element) {
    this.element = element;
    this.items = this.element.getElementsByClassName('js-stack-cards__item');
    this.scrollingFn = false;
    this.scrolling = false;
    initStackCardsEffect(this); 
    initStackCardsResize(this); 
  };

  function initStackCardsEffect(element) {
    setStackCards(element);
    var observer = new IntersectionObserver(stackCardsCallback.bind(element), { threshold: [0, 1] });
    observer.observe(element.element);
  }

  function initStackCardsResize(element) {
    element.element.addEventListener('resize-stack-cards', function(){
      setStackCards(element);
    });
  }
  
  function stackCardsCallback(entries) {
    if(entries[0].isIntersecting) {
      if(this.scrollingFn) return;
      stackCardsInitEvent(this);
    } else {
      if(!this.scrollingFn) return;
      window.removeEventListener('scroll', this.scrollingFn);
      this.scrollingFn = false;
    }
  }
  
  function stackCardsInitEvent(element) {
    element.scrollingFn = stackCardsScrolling.bind(element);
    window.addEventListener('scroll', element.scrollingFn);
  }

  function stackCardsScrolling() {
    if(this.scrolling) return;
    this.scrolling = true;
    window.requestAnimationFrame(animateStackCards.bind(this));
  }

  function setStackCards(element) {
    // Get CSS custom property for gap
    element.marginY = getComputedStyle(element.element).getPropertyValue('--stack-cards-gap');
    getIntegerFromProperty(element);
    element.elementHeight = element.element.offsetHeight;

    // Store card properties
    var cardStyle = getComputedStyle(element.items[0]);
    element.cardTop = Math.floor(parseFloat(cardStyle.getPropertyValue('top')));
    element.cardHeight = Math.floor(parseFloat(cardStyle.getPropertyValue('height')));
    element.windowHeight = window.innerHeight;

    // Count visible cards
    var visibleCount = 0;
    for(var i = 0; i < element.items.length; i++) {
      if(element.items[i].style.display !== 'none') visibleCount++;
    }

    // Set initial positioning
    if(isNaN(element.marginY)) {
      element.element.style.paddingBottom = '0px';
    } else {
      element.element.style.paddingBottom = (element.marginY*(visibleCount - 1))+'px';
    }

    var visibleIndex = 0;
    for(var i = 0; i < element.items.length; i++) {
      if(element.items[i].style.display === 'none') continue;
      if(isNaN(element.marginY)) {
        element.items[i].style.transform = 'none';
      } else {
        element.items[i].style.transform = 'translateY('+element.marginY*visibleIndex+'px)';
      }
      visibleIndex++;
    }
  }

  function getIntegerFromProperty(element) {
    var node = document.createElement('div');
    node.setAttribute('style', 'opacity:0; visibility: hidden; position: absolute; height:'+element.marginY);
    element.element.appendChild(node);
    element.marginY = parseInt(getComputedStyle(node).getPropertyValue('height'));
    element.element.removeChild(node);
  }

  function animateStackCards() {
    if(isNaN(this.marginY)) {
      this.scrolling = false;
      return; 
    }

    var top = this.element.getBoundingClientRect().top;
    var visibleCount = 0;
    for(var i = 0; i < this.items.length; i++) {
      if(this.items[i].style.display !== 'none') visibleCount++;
    }

    if( this.cardTop - top + this.element.windowHeight - this.elementHeight - this.cardHeight + this.marginY + this.marginY*visibleCount > 0) { 
      this.scrolling = false;
      return;
    }

    var visibleIndex = 0;
    for(var i = 0; i < this.items.length; i++) {
      if(this.items[i].style.display === 'none') continue;
      
      var scrolling = this.cardTop - top - visibleIndex*(this.cardHeight+this.marginY);
      if(scrolling > 0) {  
        var scaling = visibleIndex == visibleCount - 1 ? 1 : (this.cardHeight - scrolling*0.05)/this.cardHeight;
        this.items[i].style.transform = 'translateY('+this.marginY*visibleIndex+'px) scale('+scaling+')';
      } else {
        this.items[i].style.transform = 'translateY('+this.marginY*visibleIndex+'px)';
      }
      visibleIndex++;
    }

    this.scrolling = false;
  }

  // Initialize StackCards
  var stackCards = document.getElementsByClassName('js-stack-cards');
  var intersectionObserverSupported = ('IntersectionObserver' in window && 'IntersectionObserverEntry' in window && 'intersectionRatio' in window.IntersectionObserverEntry.prototype);
  var reducedMotion = hasReducedMotion();
    
  if(stackCards.length > 0 && intersectionObserverSupported && !reducedMotion) { 
    var stackCardsArray = [];
    for(var i = 0; i < stackCards.length; i++) {
      (function(i){
        stackCardsArray.push(new StackCards(stackCards[i]));
      })(i);
    }
    
    // Handle window resize
    var resizingId = false;
    var customEvent = new CustomEvent('resize-stack-cards');
    
    window.addEventListener('resize', function() {
      clearTimeout(resizingId);
      resizingId = setTimeout(doneResizing, 500);
    });

    function doneResizing() {
      for( var i = 0; i < stackCardsArray.length; i++) {
        (function(i){stackCardsArray[i].element.dispatchEvent(customEvent)})(i);
      }
    }
  }


 
})();