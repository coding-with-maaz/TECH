@extends('layouts.app')

@section('title', 'Register - Nazaaracircle')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to bottom right, #1a1a1a, #0d0d0d, #000000);">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white" style="font-family: 'Poppins', sans-serif;">
                Create your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-accent hover:text-accent-light transition-colors">
                    Sign in
                </a>
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500 text-green-200 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form class="mt-8 space-y-6 bg-bg-card p-8 rounded-lg shadow-xl" action="{{ route('register') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        autocomplete="name" 
                        required 
                        value="{{ old('name') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-600 bg-bg-secondary text-white placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                        placeholder="Enter your full name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                    <input 
                        id="username" 
                        name="username" 
                        type="text" 
                        autocomplete="username" 
                        required 
                        value="{{ old('username') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-600 bg-bg-secondary text-white placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                        placeholder="Choose a username">
                    @error('username')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email address</label>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        autocomplete="email" 
                        required 
                        value="{{ old('email') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-600 bg-bg-secondary text-white placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                        placeholder="Enter your email">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        autocomplete="new-password" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-600 bg-bg-secondary text-white placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                        placeholder="Create a password">
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        autocomplete="new-password" 
                        required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-600 bg-bg-secondary text-white placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all"
                        placeholder="Confirm your password">
                </div>
            </div>

            <div>
                <button 
                    type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-accent hover:bg-accent-light focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-all duration-300 shadow-lg">
                    Create account
                </button>
            </div>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-600"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-bg-card text-gray-400">Or continue with</span>
                    </div>
                </div>

                <div class="mt-6">
                    <button 
                        type="button"
                        id="google-signin-btn"
                        class="w-full inline-flex justify-center items-center gap-3 py-3 px-4 border border-gray-600 rounded-lg shadow-sm bg-bg-secondary text-sm font-medium text-gray-300 hover:bg-bg-card transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span>Sign up with Google</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<!-- Firebase SDK -->
<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-analytics.js";
import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-auth.js";

const firebaseConfig = {
    apiKey: "AIzaSyA5lTVNe3_-_pURTo5AaNF57jW7Ve0o4d0",
    authDomain: "harpaltech-f183d.firebaseapp.com",
    projectId: "harpaltech-f183d",
    storageBucket: "harpaltech-f183d.firebasestorage.app",
    messagingSenderId: "644904840702",
    appId: "1:644904840702:web:4baaf8cf58588fc2eb24af",
    measurementId: "G-HCVYF6TM81"
};

const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);
const auth = getAuth(app);
const provider = new GoogleAuthProvider();

provider.setCustomParameters({
    prompt: 'select_account'
});

window.signInWithGoogle = async function() {
    try {
        const btn = document.getElementById('google-signin-btn');
        btn.disabled = true;
        btn.innerHTML = '<span class="inline-block animate-spin">⏳</span> Signing up...';
        
        const result = await signInWithPopup(auth, provider);
        const user = result.user;
        const idToken = await user.getIdToken();
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        const response = await fetch('/auth/firebase', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                id_token: idToken,
                remember: false,
            }),
        });

        const data = await response.json();

        if (data.success) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'bg-green-500/20 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-4';
            alertDiv.textContent = data.message || 'Account created successfully!';
            document.querySelector('.space-y-8').insertBefore(alertDiv, document.querySelector('.space-y-8').firstChild);
            
            setTimeout(() => {
                window.location.href = data.redirect || '/';
            }, 500);
        } else {
            throw new Error(data.message || 'Registration failed');
        }
    } catch (error) {
        console.error('Firebase authentication error:', error);
        const alertDiv = document.createElement('div');
        alertDiv.className = 'bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-4';
        alertDiv.textContent = error.message || 'Failed to sign up with Google. Please try again.';
        document.querySelector('.space-y-8').insertBefore(alertDiv, document.querySelector('.space-y-8').firstChild);
        
        const btn = document.getElementById('google-signin-btn');
        btn.disabled = false;
        btn.innerHTML = `
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            <span>Sign up with Google</span>
        `;
    }
};

// Add event listener to button when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const googleBtn = document.getElementById('google-signin-btn');
    if (googleBtn) {
        googleBtn.addEventListener('click', window.signInWithGoogle);
    }
});
</script>
@endpush
@endsection

