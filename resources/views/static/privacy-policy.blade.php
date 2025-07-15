@extends('layout.base')

@section('title', 'Privacy Policy - Kaly')
@section('description', 'Read how Kaly handles your data and protects your privacy.')

@section('content')
<link href="{{ asset('css/login.css') }}" rel="stylesheet"> {{-- Reuse same CSS for consistent styling --}}
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-user-shield me-2"></i>
                        Privacy Policy
                    </h3>
                    <p class="mb-0 opacity-75">Last Updated: July 2025</p>
                </div>

                <div class="card-body p-5">
                    <p>At <strong>Kaly</strong>, we are committed to protecting your privacy and ensuring that your personal information is handled in a safe and responsible manner.</p>

                    <h5 class="mt-4 fw-bold">1. Information We Collect</h5>
                    <ul>
                        <li>Name, email, and password when registering.</li>
                        <li>Usage data and interactions with our platform.</li>
                        <li>Technical data like IP address and browser info.</li>
                    </ul>

                    <h5 class="mt-4 fw-bold">2. How We Use Your Data</h5>
                    <p>Your information is used for account creation, communication, personalization, and analytics to improve our service.</p>

                    <h5 class="mt-4 fw-bold">3. Data Sharing</h5>
                    <p>We do <strong>not</strong> sell or rent your data. We may share data with trusted service providers who help us run our platform, under strict confidentiality agreements.</p>

                    <h5 class="mt-4 fw-bold">4. Your Rights</h5>
                    <ul>
                        <li>Access, correct, or delete your data at any time.</li>
                        <li>Opt out of marketing emails.</li>
                    </ul>

                    <h5 class="mt-4 fw-bold">5. Data Security</h5>
                    <p>We implement modern security measures to protect your personal data from unauthorized access.</p>

                    <h5 class="mt-4 fw-bold">6. Contact Us</h5>
                    <p>If you have questions about this policy, contact us at <a href="mailto:support@kaly.com">support@kaly.com</a>.</p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
