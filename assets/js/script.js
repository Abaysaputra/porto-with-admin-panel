
// Initialize AOS
AOS.init({
  duration: 800,
  easing: 'ease-in-out',
  once: true
});

// Mobile Menu Toggle
const mobileToggle = document.getElementById('mobileToggle');
const navbarMenu = document.getElementById('navbarMenu');
const navLinks = document.querySelectorAll('.nav-link');

mobileToggle.addEventListener('click', () => {
  navbarMenu.classList.toggle('active');
  const icon = mobileToggle.querySelector('i');
  icon.classList.toggle('bx-menu');
  icon.classList.toggle('bx-x');
});

// Active Nav Link on Scroll
window.addEventListener('scroll', () => {
  let current = '';
  const sections = document.querySelectorAll('section');
  
  sections.forEach(section => {
    const sectionTop = section.offsetTop;
    const sectionHeight = section.clientHeight;
    if (scrollY >= (sectionTop - 200)) {
      current = section.getAttribute('id');
    }
  });

  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href').includes(current)) {
      link.classList.add('active');
    }
  });
});

// Close mobile menu on link click
navLinks.forEach(link => {
  link.addEventListener('click', () => {
    navbarMenu.classList.remove('active');
    mobileToggle.querySelector('i').classList.remove('bx-x');
    mobileToggle.querySelector('i').classList.add('bx-menu');
  });
});

// Smooth Scroll
navLinks.forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault();
    const target = document.querySelector(link.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});
// About Dropdown Toggle
const dropdownBtn = document.getElementById('aboutDropdownBtn');
const dropdownMenu = document.getElementById('aboutDropdownMenu');

if(dropdownBtn && dropdownMenu) {
  dropdownBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    dropdownMenu.classList.toggle('show');
    
    // Rotate arrow icon
    const icon = this.querySelector('i');
    if(dropdownMenu.classList.contains('show')) {
      icon.classList.remove('bx-chevron-down');
      icon.classList.add('bx-chevron-up');
    } else {
      icon.classList.remove('bx-chevron-up');
      icon.classList.add('bx-chevron-down');
    }
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function(e) {
    if(!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
      dropdownMenu.classList.remove('show');
      const icon = dropdownBtn.querySelector('i');
      icon.classList.remove('bx-chevron-up');
      icon.classList.add('bx-chevron-down');
    }
  });

  // Close dropdown when clicking menu item
  const dropdownItems = dropdownMenu.querySelectorAll('.dropdown-item-custom');
  dropdownItems.forEach(item => {
    item.addEventListener('click', function() {
      dropdownMenu.classList.remove('show');
      const icon = dropdownBtn.querySelector('i');
      icon.classList.remove('bx-chevron-up');
      icon.classList.add('bx-chevron-down');
    });
  });
}

// Portfolio Filter System
const portfolioItems = document.querySelectorAll('.portfolio-item');
const tabBtns = document.querySelectorAll('.tab-btn');
let visibleCount = 6;

tabBtns.forEach(btn => {
  btn.addEventListener('click', function() {
    const filter = this.getAttribute('data-filter');
    
    tabBtns.forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    
    const existingEmpty = document.querySelector('.portfolio-empty-state');
    if(existingEmpty) existingEmpty.remove();
    
    let visibleItems = 0;
    portfolioItems.forEach(item => {
      const category = item.getAttribute('data-category');
      
      if (filter === 'all' || category === filter) {
        item.style.display = 'block';
        visibleItems++;
      } else {
        item.style.display = 'none';
      }
    });
    
    if(visibleItems === 0) {
      const portfolioGrid = document.querySelector('.portfolio-grid');
      const emptyDiv = document.createElement('div');
      emptyDiv.className = 'col-12 portfolio-empty-state';
      emptyDiv.innerHTML = `
        <div class="empty-state-card">
          <i class='bx bx-folder-open'></i>
          <h4>No Items Found</h4>
          <p class="empty-message">There are no items in this category yet.</p>
        </div>
      `;
      portfolioGrid.appendChild(emptyDiv);
    }
  });
});


// Sharing Carousel
const sharingCarousel = document.getElementById('sharingCarousel');
const sharingCards = document.querySelectorAll('.sharing-card');
const sharingPrev = document.getElementById('sharingPrev');
const sharingNext = document.getElementById('sharingNext');
const sharingDotsContainer = document.getElementById('sharingDots');

let currentSharingIndex = 0;
const cardWidth = 340 + 24; // card width + gap
const visibleCards = Math.floor(window.innerWidth / cardWidth);
const totalPages = Math.ceil(sharingCards.length / visibleCards);

// Create dots
for (let i = 0; i < totalPages; i++) {
  const dot = document.createElement('div');
  dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
  dot.addEventListener('click', () => goToSharingPage(i));
  sharingDotsContainer.appendChild(dot);
}

const sharingDots = document.querySelectorAll('.carousel-dot');

function updateSharingCarousel() {
  const scrollAmount = currentSharingIndex * cardWidth * visibleCards;
  sharingCarousel.scrollTo({
    left: scrollAmount,
    behavior: 'smooth'
  });
  
  // Update dots
  sharingDots.forEach((dot, index) => {
    dot.classList.toggle('active', index === currentSharingIndex);
  });
  
  // Update buttons
  sharingPrev.disabled = currentSharingIndex === 0;
  sharingNext.disabled = currentSharingIndex === totalPages - 1;
}

function goToSharingPage(index) {
  currentSharingIndex = index;
  updateSharingCarousel();
}

sharingPrev.addEventListener('click', () => {
  if (currentSharingIndex > 0) {
    currentSharingIndex--;
    updateSharingCarousel();
  }
});

sharingNext.addEventListener('click', () => {
  if (currentSharingIndex < totalPages - 1) {
    currentSharingIndex++;
    updateSharingCarousel();
  }
});


// Back to top button
const backToTop = document.querySelector('.back-to-top');
window.addEventListener('scroll', () => {
  if (window.scrollY > 100) {
    backToTop.classList.add('active');
  } else {
    backToTop.classList.remove('active');
  }
});