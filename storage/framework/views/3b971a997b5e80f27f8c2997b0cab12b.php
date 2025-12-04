<?php
    $consent = json_decode(request()->cookie('cookie_consent'), true);
    $showBanner = !isset($consent) || !$consent;
?>

<?php if($showBanner): ?>
<div id="cookie-consent-banner" class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:!bg-bg-card border-t border-gray-200 dark:!border-border-primary shadow-lg p-4 md:p-6" style="display: none;">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 dark:!text-white mb-2" style="font-family: 'Poppins', sans-serif; font-weight: 700;">
                    Cookie Consent
                </h3>
                <p class="text-sm text-gray-700 dark:!text-text-secondary leading-relaxed" style="font-family: 'Poppins', sans-serif; font-weight: 400;">
                    We use cookies to enhance your browsing experience, analyze site traffic, and personalize content. By clicking "Accept All", you consent to our use of cookies. 
                    <a href="<?php echo e(route('privacy')); ?>" class="text-accent hover:text-accent-light underline" style="font-weight: 600;">Learn more</a>
                </p>
                <div class="mt-3 space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="cookie-analytics" class="cookie-preference" data-cookie="analytics" checked>
                        <span class="text-sm text-gray-700 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif;">Analytics Cookies</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="cookie-marketing" class="cookie-preference" data-cookie="marketing" checked>
                        <span class="text-sm text-gray-700 dark:!text-text-secondary" style="font-family: 'Poppins', sans-serif;">Marketing Cookies</span>
                    </label>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button id="cookie-reject-all" class="px-4 py-2 border border-gray-300 dark:!border-border-primary text-gray-900 dark:!text-white font-semibold rounded-lg hover:bg-gray-100 dark:!hover:bg-bg-card-hover transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Reject All
                </button>
                <button id="cookie-accept-necessary" class="px-4 py-2 border border-gray-300 dark:!border-border-primary text-gray-900 dark:!text-white font-semibold rounded-lg hover:bg-gray-100 dark:!hover:bg-bg-card-hover transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Necessary Only
                </button>
                <button id="cookie-accept-all" class="px-6 py-2 bg-accent hover:bg-accent-light text-white font-semibold rounded-lg transition-colors" style="font-family: 'Poppins', sans-serif; font-weight: 600;">
                    Accept All
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const banner = document.getElementById('cookie-consent-banner');
    if (!banner) return;
    
    // Check if consent already given
    const consent = getCookie('cookie_consent');
    if (consent) {
        banner.style.display = 'none';
        return;
    }
    
    // Show banner after a short delay
    setTimeout(() => {
        banner.style.display = 'block';
    }, 1000);
    
    // Set cookie helper
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + JSON.stringify(value) + ";" + expires + ";path=/;SameSite=Lax";
    }
    
    // Get cookie helper
    function getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) {
                try {
                    return JSON.parse(c.substring(nameEQ.length, c.length));
                } catch (e) {
                    return c.substring(nameEQ.length, c.length);
                }
            }
        }
        return null;
    }
    
    // Save consent
    function saveConsent(preferences) {
        const consentData = {
            accepted: true,
            timestamp: new Date().toISOString(),
            preferences: preferences,
        };
        setCookie('cookie_consent', consentData, 365);
        banner.style.display = 'none';
        
        // Reload page to apply cookie preferences
        window.location.reload();
    }
    
    // Accept all
    document.getElementById('cookie-accept-all').addEventListener('click', function() {
        const preferences = {
            necessary: true,
            analytics: document.getElementById('cookie-analytics').checked,
            marketing: document.getElementById('cookie-marketing').checked,
        };
        saveConsent(preferences);
    });
    
    // Accept necessary only
    document.getElementById('cookie-accept-necessary').addEventListener('click', function() {
        const preferences = {
            necessary: true,
            analytics: false,
            marketing: false,
        };
        saveConsent(preferences);
    });
    
    // Reject all
    document.getElementById('cookie-reject-all').addEventListener('click', function() {
        const preferences = {
            necessary: true,
            analytics: false,
            marketing: false,
        };
        saveConsent(preferences);
    });
});
</script>
<?php endif; ?>
<?php /**PATH C:\Users\k\Desktop\Nazaarabox - Copy\resources\views/components/cookie-consent.blade.php ENDPATH**/ ?>