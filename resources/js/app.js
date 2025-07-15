import './bootstrap';

// Global variables
let currentSlide = 0;
const slides = ['Urban Edge', 'Classic Collection', 'Premium Line'];
const headings = [
    'Jackets for the Modern Man',
    'Timeless Style Redefined',
    'Luxury Meets Comfort'
];

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    initializeSlideshow();
    setupEventListeners();
});

// Main functions
function exploreCollection() {
    // Add some visual feedback
    const button = document.querySelector('.cta-button');
    button.style.transform = 'scale(0.95)';
    
    setTimeout(() => {
        button.style.transform = 'translateY(-2px)';
        // This would typically navigate to the shop page
        console.log('Navigating to collection...');
        // window.location.href = '/shop';
    }, 150);
    
    // For demo purposes, show an alert
    setTimeout(() => {
        alert('Exploring the collection! This would typically navigate to the shop page.');
    }, 200);
}

function changeSlide(index) {
    if (index === currentSlide) return;
    
    currentSlide = index;
    
    // Update active dot with smooth transition
    updateActiveDot(index);
    
    // Update content with fade effect
    updateSlideContent(index);
    
    // Add subtle animation to models
    animateModels();
}

function updateActiveDot(index) {
    const dots = document.querySelectorAll('.dot');
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
}

function updateSlideContent(index) {
    const collectionLabel = document.querySelector('.collection-label');
    const mainHeading = document.querySelector('.main-heading');
    
    // Add fade-out effect
    collectionLabel.classList.add('fade-out');
    mainHeading.classList.add('fade-out');
    
    setTimeout(() => {
        // Update content
        collectionLabel.textContent = slides[index].toUpperCase();
        mainHeading.textContent = headings[index];
        
        // Add fade-in effect
        collectionLabel.classList.remove('fade-out');
        mainHeading.classList.remove('fade-out');
        collectionLabel.classList.add('fade-in');
        mainHeading.classList.add('fade-in');
        
        // Remove fade-in class after animation
        setTimeout(() => {
            collectionLabel.classList.remove('fade-in');
            mainHeading.classList.remove('fade-in');
        }, 300);
    }, 150);
}

function animateModels() {
    const models = document.querySelectorAll('.model');
    models.forEach((model, index) => {
        model.style.transform = 'scale(1.05)';
        setTimeout(() => {
            model.style.transform = '';
        }, 300);
    });
}

function initializeSlideshow() {
    // Set up auto-advance slideshow
    setInterval(autoAdvanceSlide, 5000);
}

function autoAdvanceSlide() {
    const nextSlide = (currentSlide + 1) % slides.length;
    changeSlide(nextSlide);
}

function setupEventListeners() {
    // Add click listeners to dots
    const dots = document.querySelectorAll('.dot');
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => changeSlide(index));
    });
    
    // Add click listeners to models for interaction
    const models = document.querySelectorAll('.model');
    models.forEach((model, index) => {
        model.addEventListener('click', () => {
            console.log(`Model ${index + 1} clicked`);
            // Add ripple effect
            createRippleEffect(model);
        });
    });
    
    // Add keyboard navigation
    document.addEventListener('keydown', handleKeyNavigation);
    
    // Add intersection observer for animations
    setupIntersectionObserver();
}

function createRippleEffect(element) {
    const ripple = document.createElement('div');
    ripple.style.position = 'absolute';
    ripple.style.borderRadius = '50%';
    ripple.style.background = 'rgba(255, 255, 255, 0.3)';
    ripple.style.transform = 'scale(0)';
    ripple.style.animation = 'ripple 0.6s linear';
    ripple.style.left = '50%';
    ripple.style.top = '50%';
    ripple.style.width = '20px';
    ripple.style.height = '20px';
    ripple.style.marginLeft = '-10px';
    ripple.style.marginTop = '-10px';
    ripple.style.pointerEvents = 'none';
    
    element.appendChild(ripple);
    
    setTimeout(() => {
        ripple.remove();
    }, 600);
}

function handleKeyNavigation(event) {
    switch(event.key) {
        case 'ArrowLeft':
            event.preventDefault();
            const prevSlide = currentSlide === 0 ? slides.length - 1 : currentSlide - 1;
            changeSlide(prevSlide);
            break;
        case 'ArrowRight':
            event.preventDefault();
            const nextSlide = (currentSlide + 1) % slides.length;
            changeSlide(nextSlide);
            break;
        case 'Enter':
            if (event.target.classList.contains('cta-button')) {
                exploreCollection();
            }
            break;
    }
}

function setupIntersectionObserver() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);
    
    // Observe animated elements
    const animatedElements = document.querySelectorAll('.content-left, .models-container');
    animatedElements.forEach(el => observer.observe(el));
}

// Utility functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add CSS animations dynamically
function addDynamicStyles() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// Initialize dynamic styles
addDynamicStyles();

// Export functions for global access (if needed)
window.exploreCollection = exploreCollection;
window.changeSlide = changeSlide;
