<footer class="bg-dark text-light pt-5">
    <!-- Main Footer Content -->
    <div class="container">
        <div class="row g-4">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6">
                <h4 class="text-white mb-3">Kaly</h4>
                <p class="text-muted">
                    We deliver exceptional digital solutions tailored to your business. Our team is committed to quality, innovation, and results.
                </p>
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-light fs-5" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-light fs-5" title="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light fs-5" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-light fs-5" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="text-uppercase fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('base') }}" class="footer-link">Home</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">About Us</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Services</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-2 col-md-6">
                <h6 class="text-uppercase fw-bold mb-3">Services</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#" class="footer-link">Web Development</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Mobile Apps</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">UI/UX Design</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Marketing</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Consulting</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4 col-md-6">
                <h6 class="text-uppercase fw-bold mb-3">Contact Info</h6>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>123 Business Street, City</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i>+1 (555) 123-4567</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i>info@yourbrand.com</li>
                    <li><i class="fas fa-clock me-2"></i>Mon - Fri: 9:00 AM - 6:00 PM</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Newsletter -->
    <div class="bg-secondary text-light mt-5 py-4">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-lg-6">
                    <h6 class="mb-1">Subscribe to our Newsletter</h6>
                    <p class="mb-0 text-light opacity-75">Stay up to date with the latest news and offers from Kaly.</p>
                </div>
                <div class="col-lg-6">
                    <form method="POST" action="#" class="d-flex flex-wrap gap-2">
                        @csrf
                        <input type="email" class="form-control w-100 w-md-auto" placeholder="Your email" required>
                        <button type="submit" class="btn btn-outline-light">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Footer -->
    <div class="bg-black py-3 mt-4">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} Kaly. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="{{ route('privacy.policy') }}" class="footer-link">Privacy Policy</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('terms.service') }}" class="footer-link">Terms of Service</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Additional Footer Styles -->
<style>
    .footer-link {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .footer-link:hover {
        color: #ffffff;
        text-decoration: underline;
    }
</style>
