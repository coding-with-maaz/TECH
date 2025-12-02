@extends('layouts.app')

@section('title', 'Contact Us - Tech Blog')

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
                    <li>Email us at: <a href="mailto:contact@techblog.com" class="text-accent hover:text-accent-light underline" style="font-weight: 600;">contact@techblog.com</a></li>
                    <li>Follow us on social media for updates and announcements</li>
                    <li>Submit article ideas or guest post proposals</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Contact Form</h2>
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-weight: 600;">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="Your name">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-weight: 600;">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="your.email@example.com">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-weight: 600;">
                            Subject
                        </label>
                        <input type="text" id="subject" name="subject"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                               placeholder="What is this regarding?">
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 dark:!text-white mb-2" style="font-weight: 600;">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="6" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-transparent dark:!bg-bg-card-hover dark:!border-border-primary dark:!text-white"
                                  placeholder="Your message..."></textarea>
                    </div>
                    <div>
                        <button type="submit" class="px-6 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-colors" style="font-weight: 600;">
                            Send Message
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection

