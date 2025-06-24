// Table of Contents Block JavaScript
document.addEventListener('DOMContentLoaded', function() {
  initTocBlocks();
});

function initTocBlocks() {
  const tocBlocks = document.querySelectorAll('.toc-block');
  
  tocBlocks.forEach(function(block) {
    initTocToggle(block);
    initActiveTracking(block);
  });
}

/**
 * Initialize collapse/expand functionality
 */
function initTocToggle(block) {
  const toggle = block.querySelector('.toc-toggle');
  const content = block.querySelector('.toc-content');
  
  if (!toggle || !content) return;
  
  toggle.addEventListener('click', function() {
    const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
    
    toggle.setAttribute('aria-expanded', !isExpanded);
    
    if (isExpanded) {
      content.style.display = 'none';
      block.classList.add('toc-collapsed');
    } else {
      content.style.display = 'block';
      block.classList.remove('toc-collapsed');
    }
  });
}

/**
 * Track active section and highlight corresponding ToC link
 */
function initActiveTracking(block) {
  const tocLinks = block.querySelectorAll('.toc-link');
  const headings = [];
  
  // Collect all headings that have corresponding ToC links
  tocLinks.forEach(function(link) {
    const href = link.getAttribute('href');
    if (href && href.startsWith('#')) {
      const heading = document.querySelector(href);
      if (heading) {
        headings.push({
          element: heading,
          link: link,
          id: href.substring(1)
        });
      }
    }
  });
  
  if (headings.length === 0) return;
  
  // Function to update active link
  function updateActiveLink() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const windowHeight = window.innerHeight;
    let activeHeading = null;
    
    // Find the heading that's currently in view
    for (let i = headings.length - 1; i >= 0; i--) {
      const heading = headings[i];
      const rect = heading.element.getBoundingClientRect();
      const absoluteTop = rect.top + scrollTop;
      
      if (absoluteTop <= scrollTop + 100) { // 100px offset for better UX
        activeHeading = heading;
        break;
      }
    }
    
    // Update active states
    headings.forEach(function(heading) {
      heading.link.classList.remove('active');
    });
    
    if (activeHeading) {
      activeHeading.link.classList.add('active');
    }
  }
  
  // Throttled scroll listener
  let ticking = false;
  
  function onScroll() {
    if (!ticking) {
      requestAnimationFrame(function() {
        updateActiveLink();
        ticking = false;
      });
      ticking = true;
    }
  }
  
  window.addEventListener('scroll', onScroll);
  
  // Initial check
  updateActiveLink();
  
  // Handle clicks on ToC links for smooth scrolling
  tocLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      const href = link.getAttribute('href');
      if (href && href.startsWith('#')) {
        e.preventDefault();
        
        const target = document.querySelector(href);
        if (target) {
          const targetTop = target.getBoundingClientRect().top + window.pageYOffset - 80; // 80px offset
          
          window.scrollTo({
            top: targetTop,
            behavior: 'smooth'
          });
          
          // Update URL hash after smooth scroll
          setTimeout(function() {
            history.pushState(null, null, href);
          }, 500);
        }
      }
    });
  });
}
