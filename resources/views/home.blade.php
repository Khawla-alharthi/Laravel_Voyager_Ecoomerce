@extends('layouts.app')

@section('title', 'Home - Kaly')
@section('description', 'Discover our latest collection for modern fashion.')

@section('content')
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-circle circle-1"></div>
        <div class="floating-circle circle-2"></div>
    </div>

    <!-- Main Hero Section -->
    <main class="main-content">
        <div class="content-left">
            <div class="collection-label">URBAN EDGE</div>
            <h1 class="main-heading">Jackets for the Modern Man</h1>
            <a class="cta-button" href="{{ route('products.index') }}">Discover Now</a>
        </div>
        <div class="content-right">
            <div class="models-container">
                <div class="model model-1">
                    <div class="model-image">
                        <img src="{{ asset('images/blue.jpg') }}" alt="Modern Blue Jacket">
                    </div>
                </div>
                <div class="model model-2">
                    <div class="model-image">
                        <img src="{{ asset('images/blue1.jpg') }}" alt="Modern Blue Jacket">
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Slider Dots -->
    <div class="navigation-dots">
        <div class="dot active" onclick="changeSlide(0)"></div>
        <div class="dot" onclick="changeSlide(1)"></div>
        <div class="dot" onclick="changeSlide(2)"></div>
    </div>
@endsection

@push('styles')
    {{-- Add CSS inline or move to public/css/home.css --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
        }

        .main-content {
            display: flex;
            align-items: center;
            padding: 60px 40px;
            min-height: 100vh;
            position: relative;
        }

        .content-left {
            flex: 1;
            max-width: 500px;
            z-index: 10;
        }

        .collection-label {
            font-size: 14px;
            font-weight: 300;
            letter-spacing: 1px;
            opacity: 0.8;
            margin-bottom: 20px;
            transition: opacity 0.3s ease;
        }

        .main-heading {
            font-size: 64px;
            font-weight: bold;
            line-height: 1.2;
            margin-bottom: 40px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            transition: opacity 0.3s ease;
        }

        .cta-button {
            background: white;
            color: #357abd;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-decoration: none;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: #f8f9fa;
        }

        .content-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .models-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 40px;
            width: 100%;
            max-width: 700px;
            height: auto;
            position: relative;
        }

        .model {
            width: 300px;
            height: 460px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
            overflow: hidden;
            cursor: pointer;
            position: static;
        }

        .model-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .model:hover {
            transform: scale(1.05);
        }

        .model-1 {
            left: 0;
            top: 0;
            z-index: 2;
        }

        .model-2 {
            right: 0;
            top: 50px;
            z-index: 1;
        }

        .model-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #6bb6ff, #4a90e2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            color: white;
            text-align: center;
            transition: background 0.3s ease;
        }

        .model:hover .model-image {
            background: linear-gradient(45deg, #5ca8ff, #3a7bc8);
        }

        .navigation-dots {
            position: absolute;
            bottom: 40px;
            left: 40px;
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: scale(1.2);
        }

        .dot.active {
            background: white;
            transform: scale(1.3);
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-circle {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .circle-1 {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .circle-2 {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg); 
            }
            50% { 
                transform: translateY(-20px) rotate(180deg); 
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
            }

            .main-heading {
                font-size: 42px;
            }

            .content-left {
                max-width: 100%;
                margin-bottom: 40px;
            }

            .models-container {
                height: 300px;
                margin-top: 20px;
            }

            .model {
                width: 180px;
                height: 280px;
            }

            .model-1 {
                left: 20px;
            }

            .model-2 {
                right: 20px;
                top: 30px;
            }

            .navigation-dots {
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
            }
        }

        @media (max-width: 480px) {
            .main-heading {
                font-size: 32px;
            }

            .models-container {
                height: 250px;
            }

            .model {
                width: 140px;
                height: 220px;
            }

            .model-image {
                font-size: 14px;
            }

            .cta-button {
                padding: 12px 25px;
                font-size: 14px;
            }
        }

        /* Additional animations and effects */
        .content-left {
            animation: slideInLeft 1s ease-out;
        }

        .models-container {
            animation: slideInRight 1s ease-out 0.3s both;
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Smooth transitions for dynamic content */
        .fade-transition {
            transition: opacity 0.3s ease;
        }

        .fade-out {
            opacity: 0;
        }

        .fade-in {
            opacity: 1;
        }
    </style>
@endpush

@push('scripts')
    <script>
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
    </script>
@endpush


   