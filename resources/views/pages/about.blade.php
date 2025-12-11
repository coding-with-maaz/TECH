@extends('layouts.app')

@section('title', 'About Us - Nazaaracircle')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-8" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            About Us
        </h1>

        <div class="bg-white dark:!bg-bg-card border border-gray-200 dark:!border-border-secondary rounded-lg p-6 md:p-8 space-y-8" style="font-family: 'Poppins', sans-serif;">
            <section>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4 text-lg" style="font-weight: 400;">
                    Welcome to <strong class="text-accent">Nazaaracircle</strong>! We are passionate about technology, programming, and sharing knowledge with the developer community. Our mission is to provide high-quality articles, tutorials, and insights about the latest trends in technology, web development, programming languages, and software engineering.
                </p>
            </section>

            <!-- About Nazaaracircle Section -->
            <section class="border-t border-gray-200 dark:!border-border-secondary pt-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:!text-white mb-4" style="font-weight: 700;">About Nazaaracircle</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    <strong>Nazaaracircle</strong> is a comprehensive technology blog platform dedicated to providing exceptional content and an outstanding user experience. Our website is thoughtfully designed to make it easy for developers, programmers, and tech enthusiasts to discover, read, and engage with valuable technology content. We focus on delivering well-structured articles, practical tutorials, and insightful analysis that helps our community stay informed and grow professionally.
                </p>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    At Nazaaracircle, we believe in the power of knowledge sharing and continuous learning. Our platform serves as a bridge between complex technical concepts and practical implementation, making technology accessible to everyone from beginners to seasoned professionals. We curate content that covers a wide spectrum of topics including software development, emerging technologies, programming best practices, and industry trends.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">What We Do</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    We publish in-depth articles, step-by-step tutorials, and practical guides covering a wide range of technology topics. From beginner-friendly introductions to advanced programming concepts, we aim to help developers at all levels improve their skills and stay updated with the latest industry trends.
                </p>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    Our content covers various domains including web development, mobile app development, cloud computing, artificial intelligence, cybersecurity, DevOps, and much more. Each article is carefully crafted to provide value and actionable insights.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Our Mission</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    Our goal is to create a comprehensive resource for developers, tech enthusiasts, and anyone interested in learning about technology. We believe in making technical knowledge accessible and understandable for everyone, regardless of their experience level.
                </p>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    We are committed to:
                </p>
                <ul class="list-disc list-inside text-gray-700 dark:!text-text-secondary space-y-2 ml-4" style="font-weight: 400;">
                    <li>Providing accurate, up-to-date information</li>
                    <li>Creating content that is easy to understand</li>
                    <li>Supporting the developer community</li>
                    <li>Promoting best practices in software development</li>
                    <li>Fostering a learning-friendly environment</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Why Choose Nazaaracircle?</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    Nazaaracircle stands out as a premier technology resource platform, offering a seamless experience for readers and contributors alike. Our commitment to quality, accessibility, and community engagement makes us the go-to destination for technology enthusiasts seeking reliable, up-to-date information and practical guidance.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-accent mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:!text-white mb-1" style="font-weight: 600;">Comprehensive Content</h3>
                            <p class="text-gray-600 dark:!text-text-secondary text-sm" style="font-weight: 400;">In-depth articles covering a wide range of technology topics with practical examples and real-world applications</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-accent mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:!text-white mb-1" style="font-weight: 600;">Easy Navigation</h3>
                            <p class="text-gray-600 dark:!text-text-secondary text-sm" style="font-weight: 400;">Intuitive search and categorization system that helps you quickly find the content you need</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-accent mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:!text-white mb-1" style="font-weight: 600;">Regular Updates</h3>
                            <p class="text-gray-600 dark:!text-text-secondary text-sm" style="font-weight: 400;">Fresh content published regularly to keep you informed about the latest technology trends and developments</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-accent mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:!text-white mb-1" style="font-weight: 600;">Mobile Friendly</h3>
                            <p class="text-gray-600 dark:!text-text-secondary text-sm" style="font-weight: 400;">Optimized for all devices, ensuring a great reading experience whether you're on desktop, tablet, or mobile</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-accent mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:!text-white mb-1" style="font-weight: 600;">Community Engagement</h3>
                            <p class="text-gray-600 dark:!text-text-secondary text-sm" style="font-weight: 400;">Interactive features that allow you to connect with authors and fellow readers through comments and discussions</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-accent mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:!text-white mb-1" style="font-weight: 600;">Free Access</h3>
                            <p class="text-gray-600 dark:!text-text-secondary text-sm" style="font-weight: 400;">All our content is freely accessible, providing valuable technology knowledge to everyone in the community</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="border-t border-gray-200 dark:!border-border-secondary pt-6">
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    Have questions or suggestions? We'd love to hear from you! Feel free to <a href="{{ route('contact') }}" class="text-accent hover:text-accent-light underline font-semibold" style="font-weight: 600;">contact us</a> with your feedback, article ideas, or any inquiries.
                </p>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed" style="font-weight: 400;">
                    Thank you for being part of the <strong class="text-accent">Nazaaracircle</strong> community! Together, we're building a knowledge-sharing platform that empowers developers and technology enthusiasts worldwide.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection

