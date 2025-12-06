@extends('layouts.app')

@section('title', 'Privacy Policy - HARPALJOB TECH')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-8" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Privacy Policy
        </h1>

        <div class="bg-white dark:!bg-bg-card border border-gray-200 dark:!border-border-secondary rounded-lg p-6 md:p-8 space-y-6" style="font-family: 'Poppins', sans-serif;">
            <section>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    <strong>Last Updated:</strong> {{ date('F d, Y') }}
                </p>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    At HARPALJOB TECH, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Information We Collect</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    We may collect information that you provide directly to us, including:
                </p>
                <ul class="list-disc list-inside text-gray-700 dark:!text-text-secondary space-y-2 mb-4" style="font-weight: 400;">
                    <li>Name and email address when you subscribe to our newsletter</li>
                    <li>Comments and feedback you submit on articles</li>
                    <li>Information you provide when contacting us</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">How We Use Your Information</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    We use the information we collect to:
                </p>
                <ul class="list-disc list-inside text-gray-700 dark:!text-text-secondary space-y-2 mb-4" style="font-weight: 400;">
                    <li>Send you newsletters and updates (with your consent)</li>
                    <li>Respond to your inquiries and comments</li>
                    <li>Improve our website and user experience</li>
                    <li>Analyze website usage and trends</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Data Security</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    We implement appropriate security measures to protect your personal information. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Cookies</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    We use cookies to enhance your browsing experience, analyze site traffic, and personalize content. You can control cookies through your browser settings.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Contact Us</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    If you have any questions about this Privacy Policy, please <a href="{{ route('contact') }}" class="text-accent hover:text-accent-light underline" style="font-weight: 600;">contact us</a>.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection

