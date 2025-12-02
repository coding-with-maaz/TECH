// Firebase Configuration
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-analytics.js";
import { getAuth, signInWithPopup, GoogleAuthProvider, signInWithCredential } from "https://www.gstatic.com/firebasejs/12.6.0/firebase-auth.js";

const firebaseConfig = {
    apiKey: "AIzaSyA5lTVNe3_-_pURTo5AaNF57jW7Ve0o4d0",
    authDomain: "harpaltech-f183d.firebaseapp.com",
    projectId: "harpaltech-f183d",
    storageBucket: "harpaltech-f183d.firebasestorage.app",
    messagingSenderId: "644904840702",
    appId: "1:644904840702:web:4baaf8cf58588fc2eb24af",
    measurementId: "G-HCVYF6TM81"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const analytics = getAnalytics(app);
const provider = new GoogleAuthProvider();

// Configure Google provider
provider.setCustomParameters({
    prompt: 'select_account'
});

/**
 * Handle Google Sign In
 */
export async function signInWithGoogle() {
    try {
        const result = await signInWithPopup(auth, provider);
        const user = result.user;
        
        // Get the ID token
        const idToken = await user.getIdToken();
        
        // Send token to Laravel backend
        return await authenticateWithBackend(idToken);
    } catch (error) {
        console.error('Firebase authentication error:', error);
        showError('Failed to sign in with Google. Please try again.');
        return { success: false, message: error.message };
    }
}

/**
 * Send Firebase ID token to Laravel backend
 */
async function authenticateWithBackend(idToken) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        
        const response = await fetch('/auth/firebase', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                id_token: idToken,
                remember: document.getElementById('remember')?.checked || false,
            }),
        });

        const data = await response.json();

        if (data.success) {
            // Show success message
            if (data.message) {
                showSuccess(data.message);
            }
            
            // Redirect after short delay
            setTimeout(() => {
                window.location.href = data.redirect || '/';
            }, 500);
            
            return data;
        } else {
            showError(data.message || 'Authentication failed. Please try again.');
            return data;
        }
    } catch (error) {
        console.error('Backend authentication error:', error);
        showError('Failed to authenticate with server. Please try again.');
        return { success: false, message: error.message };
    }
}

/**
 * Show success message
 */
function showSuccess(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'bg-green-500/20 border border-green-500 text-green-200 px-4 py-3 rounded-lg mb-4';
    alertDiv.textContent = message;
    
    const container = document.querySelector('.space-y-8, .space-y-6') || document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

/**
 * Show error message
 */
function showError(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg mb-4';
    alertDiv.textContent = message;
    
    const container = document.querySelector('.space-y-8, .space-y-6') || document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Make function globally available
window.signInWithGoogle = signInWithGoogle;

