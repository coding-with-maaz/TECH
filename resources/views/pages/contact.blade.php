@extends('layouts.app')

@section('title', 'Contact Us - Nazaaracircle')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-8" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            Contact Us
        </h1>

        <div class="bg-white dark:!bg-bg-card border border-gray-200 dark:!border-border-secondary rounded-lg p-6 md:p-8 space-y-6" style="font-family: 'Poppins', sans-serif;">
            <section>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    We'd love to hear from you! Whether you have questions, suggestions, feedback, or just want to say hello, feel free to reach out to us.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Get in Touch</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    You can contact us through the following methods:
                </p>
                <ul class="list-disc list-inside text-gray-700 dark:!text-text-secondary space-y-2 mb-4" style="font-weight: 400;">
                    <li>Email us at: <a href="mailto:drtoolofficial@gmail.com" class="text-accent hover:text-accent-light underline" style="font-weight: 600;">drtoolofficial@gmail.com</a></li>
                    <li>Follow us on social media for updates and announcements</li>
                    <li>Submit article ideas or guest post proposals</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Contact Form</h2>
                
                <!-- Form Out of Service Notice -->
                <div class="mb-6 p-6 bg-yellow-50 dark:!bg-yellow-900/20 border-2 border-yellow-400 dark:!border-yellow-600 rounded-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-yellow-600 dark:!text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-yellow-800 dark:!text-yellow-200 mb-2" style="font-weight: 700;">
                                Contact Form Currently Out of Service
                            </h3>
                            <p class="text-yellow-700 dark:!text-yellow-300 leading-relaxed mb-3" style="font-weight: 400;">
                                We apologize for the inconvenience, but our contact form is currently unavailable. Please reach out to us directly via email at <a href="mailto:drtoolofficial@gmail.com" class="text-yellow-900 dark:!text-yellow-100 underline font-semibold" style="font-weight: 600;">drtoolofficial@gmail.com</a> and we'll get back to you as soon as possible.
                            </p>
                            <p class="text-yellow-700 dark:!text-yellow-300 text-sm" style="font-weight: 400;">
                                We're working to restore the contact form functionality. Thank you for your patience!
                            </p>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg dark:!bg-green-900/20 dark:!border-green-600 dark:!text-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg dark:!bg-red-900/20 dark:!border-red-600 dark:!text-red-200">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Disabled Form (Visual Only) -->
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4 opacity-60 pointer-events-none" style="position: relative;">
                    @csrf
                    <div class="absolute inset-0 z-10 bg-gray-100/50 dark:!bg-gray-800/50 rounded-lg flex items-center justify-center">
                        <p class="text-gray-600 dark:!text-gray-400 font-semibold text-lg" style="font-weight: 600;">Form Currently Unavailable</p>
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-weight: 600;">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required disabled
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white cursor-not-allowed"
                               placeholder="Your name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-weight: 600;">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required disabled
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white cursor-not-allowed"
                               placeholder="your.email@example.com">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-weight: 600;">
                            Subject
                        </label>
                        <input type="text" id="subject" name="subject" disabled
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white cursor-not-allowed"
                               placeholder="What is this regarding?">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-weight: 600;">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="6" required disabled
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white cursor-not-allowed"
                                  placeholder="Your message..."></textarea>
                    </div>
                    <div>
                        <button type="submit" disabled class="px-6 py-2 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed opacity-50" style="font-weight: 600;">
                            Send Message
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

