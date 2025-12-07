@extends('layouts.app')

@section('title', 'About Us - TECHNAZAARA')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 xl:px-12 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:!text-white mb-8" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
            About Us
        </h1>

        <div class="bg-white dark:!bg-bg-card border border-gray-200 dark:!border-border-secondary rounded-lg p-6 md:p-8 space-y-6" style="font-family: 'Poppins', sans-serif;">
            <section>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    Welcome to TECHNAZAARA! We are passionate about technology, programming, and sharing knowledge with the developer community. Our mission is to provide high-quality articles, tutorials, and insights about the latest trends in technology, web development, programming languages, and software engineering.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">What We Do</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    We publish in-depth articles, step-by-step tutorials, and practical guides covering a wide range of technology topics. From beginner-friendly introductions to advanced programming concepts, we aim to help developers at all levels improve their skills and stay updated with the latest industry trends.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 dark:!text-white mb-3" style="font-weight: 700;">Our Mission</h2>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    Our goal is to create a comprehensive resource for developers, tech enthusiasts, and anyone interested in learning about technology. We believe in making technical knowledge accessible and understandable for everyone.
                </p>
            </section>

            <section>
                <p class="text-gray-700 dark:!text-text-secondary leading-relaxed mb-4" style="font-weight: 400;">
                    Have questions or suggestions? We'd love to hear from you! Feel free to <a href="{{ route('contact') }}" class="text-accent hover:text-accent-light underline" style="font-weight: 600;">contact us</a> with your feedback, article ideas, or any inquiries.
                </p>
            </section>
        </div>
    </div>
</div>
@endsection

