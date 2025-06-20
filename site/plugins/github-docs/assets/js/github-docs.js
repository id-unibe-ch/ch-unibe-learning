/**
 * GitHub Documentation Plugin JavaScript
 * Enhances the documentation experience with interactive features
 */

document.addEventListener('DOMContentLoaded', function() {
  // Initialize the documentation features
  initializeNavigation();
  initializeScrollSpy();
  initializeResponsiveFeatures();
});

/**
 * Initialize navigation features
 */
function initializeNavigation() {
  const sidebar = document.querySelector('.github-docs-sidebar');
  const navLinks = document.querySelectorAll('.github-docs-nav-link');
  
  if (!sidebar || !navLinks.length) return;
  
  // Add click handlers to navigation links
  navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      // Remove active state from all links
      navLinks.forEach(l => l.parentElement.classList.remove('is-active'));
      
      // Add active state to clicked link
      this.parentElement.classList.add('is-active');
      
      // Store active state in localStorage for persistence
      localStorage.setItem('github-docs-active-link', this.href);
    });
  });
  
  // Restore active state from localStorage
  const activeLink = localStorage.getItem('github-docs-active-link');
  if (activeLink) {
    const currentLink = document.querySelector(`a[href="${activeLink}"]`);
    if (currentLink && currentLink.classList.contains('github-docs-nav-link')) {
      navLinks.forEach(l => l.parentElement.classList.remove('is-active'));
      currentLink.parentElement.classList.add('is-active');
    }
  }
}

/**
 * Initialize scroll spy for current page highlighting
 */
function initializeScrollSpy() {
  const currentUrl = window.location.pathname + window.location.search;
  const navLinks = document.querySelectorAll('.github-docs-nav-link');
  
  navLinks.forEach(link => {
    const linkUrl = new URL(link.href, window.location.origin).pathname + new URL(link.href, window.location.origin).search;
    
    if (linkUrl === currentUrl) {
      link.parentElement.classList.add('is-active');
      
      // Scroll the active item into view
      setTimeout(() => {
        link.scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });
      }, 100);
    }
  });
}

/**
 * Initialize responsive features
 */
function initializeResponsiveFeatures() {
  const sidebar = document.querySelector('.github-docs-sidebar');
  if (!sidebar) return;
  
  // Add mobile toggle for sidebar
  if (window.innerWidth <= 1024) {
    createMobileToggle();
  }
  
  // Handle window resize
  window.addEventListener('resize', function() {
    if (window.innerWidth <= 1024 && !document.querySelector('.github-docs-mobile-toggle')) {
      createMobileToggle();
    } else if (window.innerWidth > 1024) {
      const toggle = document.querySelector('.github-docs-mobile-toggle');
      if (toggle) {
        toggle.remove();
        sidebar.classList.remove('is-hidden');
      }
    }
  });
}

/**
 * Create mobile toggle for sidebar
 */
function createMobileToggle() {
  const sidebar = document.querySelector('.github-docs-sidebar');
  const main = document.querySelector('.github-docs-main');
  
  if (!sidebar || !main) return;
  
  // Create toggle button
  const toggle = document.createElement('button');
  toggle.className = 'github-docs-mobile-toggle';
  toggle.innerHTML = `
    <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
      <path d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
    </svg>
    <span>Navigation</span>
  `;
  
  toggle.style.cssText = `
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #0969da;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  `;
  
  // Insert toggle button
  document.body.appendChild(toggle);
  
  // Initially hide sidebar on mobile
  sidebar.classList.add('is-hidden');
  sidebar.style.cssText += `
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  `;
  
  // Toggle functionality
  toggle.addEventListener('click', function() {
    const isHidden = sidebar.classList.contains('is-hidden');
    
    if (isHidden) {
      sidebar.classList.remove('is-hidden');
      sidebar.style.transform = 'translateX(0)';
      toggle.innerHTML = `
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
        </svg>
        <span>Close</span>
      `;
    } else {
      sidebar.classList.add('is-hidden');
      sidebar.style.transform = 'translateX(-100%)';
      toggle.innerHTML = `
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
        <span>Navigation</span>
      `;
    }
  });
  
  // Close sidebar when clicking outside
  document.addEventListener('click', function(e) {
    if (!sidebar.contains(e.target) && !toggle.contains(e.target) && !sidebar.classList.contains('is-hidden')) {
      sidebar.classList.add('is-hidden');
      sidebar.style.transform = 'translateX(-100%)';
      toggle.innerHTML = `
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
          <path d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
        <span>Navigation</span>
      `;
    }
  });
}

/**
 * Smooth scrolling for anchor links
 */
document.addEventListener('click', function(e) {
  const target = e.target.closest('a[href^="#"]');
  if (!target) return;
  
  e.preventDefault();
  const id = target.getAttribute('href').substring(1);
  const element = document.getElementById(id);
  
  if (element) {
    element.scrollIntoView({
      behavior: 'smooth',
      block: 'start'
    });
    
    // Update URL without triggering navigation
    history.pushState(null, null, '#' + id);
  }
});

/**
 * Copy code blocks to clipboard
 */
document.addEventListener('click', function(e) {
  if (e.target.closest('.github-docs-copy-code')) {
    const button = e.target.closest('.github-docs-copy-code');
    const codeBlock = button.parentElement.querySelector('code');
    
    if (codeBlock) {
      navigator.clipboard.writeText(codeBlock.textContent).then(() => {
        button.textContent = 'Copied!';
        setTimeout(() => {
          button.textContent = 'Copy';
        }, 2000);
      });
    }
  }
});

/**
 * Add copy buttons to code blocks
 */
function addCopyButtons() {
  const codeBlocks = document.querySelectorAll('.github-docs-article pre');
  
  codeBlocks.forEach(block => {
    if (block.querySelector('.github-docs-copy-code')) return;
    
    const button = document.createElement('button');
    button.className = 'github-docs-copy-code';
    button.textContent = 'Copy';
    button.style.cssText = `
      position: absolute;
      top: 0.5rem;
      right: 0.5rem;
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem;
      background: rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 3px;
      cursor: pointer;
      opacity: 0;
      transition: opacity 0.2s ease;
    `;
    
    block.style.position = 'relative';
    block.appendChild(button);
    
    block.addEventListener('mouseenter', () => {
      button.style.opacity = '1';
    });
    
    block.addEventListener('mouseleave', () => {
      button.style.opacity = '0';
    });
  });
}

// Initialize copy buttons after DOM is loaded
document.addEventListener('DOMContentLoaded', addCopyButtons);
