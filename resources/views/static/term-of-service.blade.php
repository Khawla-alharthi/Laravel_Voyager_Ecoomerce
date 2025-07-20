@extends('layouts.app')

@section('title', 'Terms of Service - Kaly')
@section('description', 'Understand the terms and conditions for using Kaly.')

@section('content')
<link href="{{ asset('css/login.css') }}" rel="stylesheet"> {{-- Reuse same CSS --}}
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-file-contract me-2"></i>
                        Terms of Service
                    </h3>
                    <p class="mb-0 opacity-75">Effective Date: July 2025</p>
                </div>

                <div class="card-body p-5">
                    <p>Welcome to <strong>Kaly</strong>. By using our website or services, you agree to comply with and be bound by the following terms and conditions.</p>

                    <h5 class="mt-4 fw-bold">1. Acceptance of Terms</h5>
                    <p>By creating an account or using Kaly, you agree to these Terms of Service and our Privacy Policy.</p>

                    <h5 class="mt-4 fw-bold">2. User Responsibilities</h5>
                    <ul>
                        <li>Provide accurate and complete information during registration.</li>
                        <li>Keep your account credentials secure.</li>
                        <li>Use the service in a lawful and respectful manner.</li>
                    </ul>

                    <h5 class="mt-4 fw-bold">3. Prohibited Activities</h5>
                    <p>Users may not:</p>
                    <ul>
                        <li>Use Kaly for illegal purposes.</li>
                        <li>Attempt to hack or compromise the platform.</li>
                        <li>Post offensive, misleading, or harmful content.</li>
                    </ul>

                    <h5 class="mt-4 fw-bold">4. Termination</h5>
                    <p>We reserve the right to suspend or terminate accounts that violate these terms without prior notice.</p>

                    <h5 class="mt-4 fw-bold">5. Modifications</h5>
                    <p>Kaly may update these terms from time to time. Continued use of the service implies acceptance of the updated terms.</p>

                    <h5 class="mt-4 fw-bold">6. Contact Information</h5>
                    <p>If you have any questions about these terms, please contact us at <a href="mailto:support@kaly.com">support@kaly.com</a>.</p>
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
