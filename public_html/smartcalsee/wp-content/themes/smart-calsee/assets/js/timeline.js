// Register GSAP ScrollTrigger plugin
if (typeof gsap !== 'undefined' && gsap.registerPlugin) {
  gsap.registerPlugin(ScrollTrigger);
}

// Timeline data - Get from WordPress metabox or use empty array
const timelineData = (typeof AboutTimelineData !== 'undefined' &&
                      AboutTimelineData !== null &&
                      Array.isArray(AboutTimelineData.items) &&
                      AboutTimelineData.items.length > 0)
  ? AboutTimelineData.items
  : [];

const DOTS_COUNT = 30;
const ANGLE_PER_DOT = 360 / DOTS_COUNT;
const ANGLE_DATE = 25;
const ANGLE_POST = 23;

class Timeline {
  constructor(container) {
    this.container = container;
    this.activeIndex = 0;
    this.circleRadius = 0;
    this.previousActiveIndex = 0;
    this.years = [...new Set(timelineData.map(item => item.year))];
    
    // Refs - container is the .timeline-section element
    this.rootSection = container;
    this.timeline = container.querySelector('.timeline-wrapper');
    this.section = container.querySelector('.section-inner');
    this.leftWrapper = container.querySelector('.left-wrapper');
    this.dotsContainer = container.querySelector('.dots-container');
    this.dotsInner = container.querySelector('.dots-inner');
    this.datesWrapper = container.querySelector('.date-content');
    this.postsWrapper = container.querySelector('.posts-wrapper');
    this.svgCircle = container.querySelector('.svg-circle');
    
    // Arrays for refs
    this.postRefs = [];
    this.dotRefs = [];
    this.overlayRefs = [];
    this.overlayBackRefs = [];
    
    this.init();
  }

  init() {
    if (!this.rootSection || !this.section || !this.timeline || !this.postsWrapper) {
      console.error('Timeline: Required elements not found');
      return;
    }

    if (!timelineData || timelineData.length === 0) {
      console.warn('Timeline: No data available. Please add timeline items in WordPress admin.');
      return;
    }
    
    // Set initial rotation to 0 for posts and dates wrappers
    if (typeof gsap !== 'undefined') {
      gsap.set(this.postsWrapper, { rotation: 0 });
      if (this.datesWrapper) {
        gsap.set(this.datesWrapper, { rotation: 0 });
      }
      if (this.dotsContainer) {
        gsap.set(this.dotsContainer, { rotation: 0 });
      }
    }
    
    this.createDots();
    this.createDates();
    this.createPosts();
    
    // Use requestAnimationFrame to ensure DOM is fully rendered
    requestAnimationFrame(() => {
      this.calculateRadius();
      this.setupAnimations();
    });
    
    this.setupResize();
  }

  createDots() {
    if (!this.dotsInner) return;
    
    for (let i = 0; i < DOTS_COUNT; i++) {
      const dot = document.createElement('div');
      dot.className = 'dot';
      const angle = (i / DOTS_COUNT) * 360;
      dot.style.opacity = this.getDotOpacity(angle);
      dot.style.transform = `translate3d(-50%, -50%, 0) rotate(${angle}deg) translate(${this.circleRadius}px)`;
      this.dotsInner.appendChild(dot);
      this.dotRefs.push(dot);
    }
  }

  createDates() {
    if (!this.datesWrapper) return;
    
    const activeItem = timelineData[this.activeIndex];
    this.years.forEach((year, index) => {
      const dateSpan = document.createElement('span');
      dateSpan.className = 'date';
      dateSpan.setAttribute('data-year', year);
      dateSpan.style.setProperty('--index-rotate', index);
      dateSpan.textContent = year;
      
      // Set initial classes based on active item
      if (year === activeItem.year) {
        dateSpan.classList.add('active');
      } else if (year < activeItem.year) {
        dateSpan.classList.add('past');
      } else {
        dateSpan.classList.add('future');
      }
      
      this.datesWrapper.appendChild(dateSpan);
    });
  }

  createPosts() {
    if (!this.postsWrapper) return;
    
    timelineData.forEach((item, index) => {
      const post = document.createElement('div');
      post.className = 'post';
      post.style.setProperty('--index-rotate', index);
      
      const postInner = document.createElement('div');
      postInner.className = 'post-inner';
      
      // Set initial opacity based on active index
      // Use CSS class for initial state, GSAP will handle animations
      if (index === this.activeIndex) {
        postInner.classList.add('active');
      }
      // Don't set inline opacity here - let CSS handle initial state
      // GSAP will override during animations
      
      const title = document.createElement('h3');
      title.className = 'post-title';
      title.textContent = item.title;
      
      const description = document.createElement('p');
      description.className = 'post-description';
      description.textContent = item.description;
      
      postInner.appendChild(title);
      postInner.appendChild(description);
      post.appendChild(postInner);
      this.postsWrapper.appendChild(post);
      
      this.postRefs.push(postInner);
    });
    
    // After all posts are created, set initial GSAP states
    // Use a small delay to ensure DOM is ready
    setTimeout(() => {
      if (typeof gsap !== 'undefined') {
        this.postRefs.forEach((post, i) => {
          if (!post) return;
          if (i === this.activeIndex) {
            post.classList.add('active');
            gsap.set(post, { 
              opacity: 1, 
              y: 0,
              visibility: 'visible'
            });
          } else {
            post.classList.remove('active');
            gsap.set(post, { 
              opacity: 0.04, 
              y: 0,
              visibility: 'visible'
            });
          }
        });
      }
    }, 10);
  }

  calculateRadius() {
    const svgElement = this.svgCircle?.querySelector('svg');
    const purpleSquare = svgElement?.querySelector('.purple-square');
    if (purpleSquare && this.leftWrapper) {
      this.circleRadius = this.leftWrapper.offsetWidth / 2.025;
      this.updateDotsPosition();
    }
  }

  updateDotsPosition() {
    this.dotRefs.forEach((dot, i) => {
      if (!dot) return;
      const angle = (i / DOTS_COUNT) * 360;
      dot.style.transform = 'translate3d(-50%, -50%, 0) rotate(${angle}deg) translate(${this.circleRadius}px)';
    });
  }

  getDotOpacity(angle) {
    if (typeof gsap === 'undefined' || !gsap.utils) {
      // Fallback if GSAP not loaded
      const normalizedAngle = ((angle % 360) + 360) % 360;
      const distanceFrom90 = Math.min(
        Math.abs(normalizedAngle - 90),
        360 - Math.abs(normalizedAngle - 90)
      );
      return Math.max(0, Math.min(1, 1 - (distanceFrom90 / 90)));
    }
    
    const normalizedAngle = ((angle % 360) + 360) % 360;
    const distanceFrom90 = Math.min(
      Math.abs(normalizedAngle - 90),
      360 - Math.abs(normalizedAngle - 90)
    );
    return gsap.utils.clamp(0, 1, gsap.utils.mapRange(90, 0, 0, 1, distanceFrom90));
  }

  updateActiveIndex(newIndex) {
    const prev = this.previousActiveIndex;
    const curr = newIndex;
    const direction = curr > prev ? 'next' : 'prev';

    if (typeof gsap === 'undefined') {
      console.error('GSAP is required for timeline animations');
      return;
    }

    this.postRefs.forEach((post, i) => {
      if (!post) return;
      const isActive = i === curr;
      const isPrev = i === prev;

      if (isActive) {
        gsap.fromTo(post,
          { y: direction === 'next' ? 30 : -30, opacity: 0, visibility: 'hidden' },
          { 
            y: 0, 
            opacity: 1, 
            visibility: 'visible',
            duration: 0.35, 
            ease: 'power2.out', 
            overwrite: 'auto' 
          }
        );
        post.classList.add('active');
      } else if (isPrev) {
        gsap.to(post, { 
          y: direction === 'next' ? -30 : 30, 
          opacity: 0.04, 
          visibility: 'visible',
          duration: 0.3, 
          ease: 'power2.in', 
          overwrite: 'auto' 
        });
        post.classList.remove('active');
      } else {
        gsap.to(post, { 
          y: 0, 
          opacity: 0.04, 
          visibility: 'visible',
          duration: 0.2, 
          overwrite: 'auto' 
        });
        post.classList.remove('active');
      }
    });

    // Update date classes
    const activeItem = timelineData[curr];
    if (this.datesWrapper) {
      this.datesWrapper.querySelectorAll('.date').forEach(dateEl => {
        const year = parseInt(dateEl.getAttribute('data-year'));
        dateEl.classList.remove('active', 'past', 'future');
        if (year === activeItem.year) {
          dateEl.classList.add('active');
        } else if (year < activeItem.year) {
          dateEl.classList.add('past');
        } else {
          dateEl.classList.add('future');
        }
      });
    }

    this.previousActiveIndex = curr;
    this.activeIndex = curr;
  }

  setupAnimations() {
    if (!this.rootSection || !this.section || !this.timeline || !this.postsWrapper) return;
    
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
      console.error('GSAP and ScrollTrigger are required for timeline animations');
      return;
    }

    // Detect mobile viewport for rotation direction adjustment
    const isMobile = window.innerWidth < 1024;

    const perItemScroll = window.innerHeight;
    const totalScroll = perItemScroll * (timelineData.length - 1);

    // Pin the timeline wrapper
    const mainTrigger = ScrollTrigger.create({
      trigger: this.rootSection,
      start: 'top top',
      end: `+=${totalScroll}`,
      pin: true,
      pinSpacing: true,
      anticipatePin: 1,
      invalidateOnRefresh: true,
      id: 'main'
    });

    const rotationTimeline = gsap.timeline({
      scrollTrigger: {
        trigger: this.rootSection,
        start: 'top top',
        end: `+=${totalScroll}`,
        scrub: 1,
        invalidateOnRefresh: true,
        onUpdate: () => {
          const current = isMobile ? 0 : Math.abs((gsap.getProperty(this.postsWrapper, 'rotation') || 0));
          const idx = isMobile 
            ? Math.min(Math.floor(ScrollTrigger.getById(mainTrigger.vars.id || 'main')?.progress * timelineData.length || 0), timelineData.length - 1)
            : Math.min(Math.round(current / ANGLE_POST), timelineData.length - 1);
          
          // Clamp index to valid range
          const activeIdx = Math.max(0, Math.min(idx, timelineData.length - 1));
          
          if (activeIdx !== this.activeIndex) {
            this.updateActiveIndex(activeIdx);
          }
          
          // Force visual state - ensure active post is always visible
          this.postRefs.forEach((post, i) => {
            if (!post) return;
            const isActive = i === activeIdx;
            if (isActive) {
              post.classList.add('active');
              gsap.set(post, { 
                opacity: 1,
                visibility: 'visible',
                overwrite: 'auto'
              });
            } else {
              post.classList.remove('active');
              gsap.set(post, { 
                opacity: 0.04,
                visibility: 'visible',
                overwrite: 'auto'
              });
            }
          });
        }
      }
    });

    // Start from 0 and rotate to negative angle (desktop only)
    if (!isMobile) {
      rotationTimeline.fromTo(this.postsWrapper, 
        { rotation: 0 },
        {
          rotation: -ANGLE_POST * (timelineData.length - 1),
          ease: 'none'
        }, 0
      );
    }

    // Rotate the years wheel to match descriptions so years move in sync
    if (this.datesWrapper) {
      const dateRotation = isMobile 
        ? ANGLE_DATE * (this.years.length - 1)   // Positive for mobile (left movement)
        : -ANGLE_DATE * (this.years.length - 1); // Negative for desktop (up movement)
      
      rotationTimeline.fromTo(this.datesWrapper,
        { rotation: 0 },
        {
          rotation: dateRotation,
          ease: 'none'
        }, 0
      );
    }

    // Rotate dots container
    rotationTimeline.fromTo(this.dotsContainer,
      { rotation: 0 },
      {
        rotation: -12 * (timelineData.length - 1),
        ease: 'none',
        onUpdate: () => {
          const currentRotation = gsap.getProperty(this.dotsContainer, 'rotation') || 0;
          this.dotRefs.forEach((dot, i) => {
            if (!dot) return;
            const angle = (i / DOTS_COUNT) * 360;
            const distanceFromActive = Math.abs(angle - Math.abs(currentRotation) % 360);
            const opacity = gsap.utils.mapRange(0, 90, 1, 0, Math.min(distanceFromActive, 360 - distanceFromActive));
            gsap.set(dot, { opacity: gsap.utils.clamp(0, 1, opacity) });
          });
        }
      }, 0
    );
  }

  setupResize() {
    const onResize = () => {
      this.calculateRadius();
      if (typeof ScrollTrigger !== 'undefined') {
        // On resize, we may need to recreate animations if viewport type changed
        // For now, just refresh ScrollTrigger which should handle most cases
        ScrollTrigger.refresh();
      }
    };
    window.addEventListener('resize', onResize);
    this.onResize = onResize;
  }

  destroy() {
    if (typeof ScrollTrigger !== 'undefined') {
      ScrollTrigger.getAll().forEach(trigger => trigger.kill());
    }
    if (this.onResize) {
      window.removeEventListener('resize', this.onResize);
    }
  }
}

// Initialize when DOM is ready and GSAP is loaded
function initTimeline() {
  // Check if we have timeline data
  if (!timelineData || timelineData.length === 0) {
    console.warn('Timeline: No data available. Please add timeline items in WordPress admin (About Us page > About Timeline meta box).');
    return;
  }

  const timelineContainer = document.querySelector('.timeline-section');
  if (timelineContainer) {
    // Wait for GSAP to be fully loaded
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      console.log('Timeline: Initializing with', timelineData.length, 'items from WordPress metabox');
      window.timelineInstance = new Timeline(timelineContainer);
    } else {
      // Retry after a short delay if GSAP isn't loaded yet
      setTimeout(initTimeline, 100);
    }
  } else {
    console.error('Timeline: .timeline-section element not found in the page');
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initTimeline);
} else {
  // DOM is already ready
  initTimeline();
}