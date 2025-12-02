# Firebase SSL Certificate Fix

## 🔴 Error: SSL Certificate Problem

```
cURL error 60: SSL certificate problem: unable to get local issuer certificate
```

This error occurs on Windows when cURL can't verify SSL certificates because it doesn't have the CA certificate bundle.

---

## ✅ Solution Applied

I've updated the `FirebaseAuthService` to handle SSL certificate issues for **local development only**.

### What Was Changed

The service now:
- Detects if you're in local development mode
- Disables SSL verification **only in local development**
- Keeps SSL verification enabled in production (for security)

### Code Changes

```php
// For local development, disable SSL verification
if (config('app.env') === 'local' || config('app.debug')) {
    $httpClientOptions['verify'] = false;
}
```

---

## ⚠️ Important Security Note

**SSL verification is disabled ONLY in local development mode.**

This is safe because:
- ✅ Only applies when `APP_ENV=local` or `APP_DEBUG=true`
- ✅ Production environments will still verify SSL certificates
- ✅ This is a common workaround for local development on Windows

**Never disable SSL verification in production!**

---

## 🧪 Test It Now

1. **Clear cache** (already done):
   ```bash
   php artisan config:clear
   ```

2. **Refresh your browser**

3. **Try Google Sign-In again**

The SSL error should be resolved!

---

## 🔧 Alternative Solutions (If Needed)

If you prefer to keep SSL verification enabled, you can:

### Option 1: Download CA Bundle

1. Download `cacert.pem` from: https://curl.se/ca/cacert.pem
2. Save it to your project (e.g., `storage/cacert.pem`)
3. Update `php.ini`:
   ```ini
   curl.cainfo = "C:\path\to\your\project\storage\cacert.pem"
   ```
4. Restart your web server

### Option 2: Use System CA Bundle

If you have a system CA bundle, point to it in `php.ini`:
```ini
curl.cainfo = "C:\path\to\cacert.pem"
```

---

## ✅ Current Status

- ✅ SSL verification disabled for local development
- ✅ SSL verification enabled for production
- ✅ Ready to test!

**Try signing in with Google now - it should work!** 🎉

---

## 📝 For Production

When deploying to production:
1. Make sure `APP_ENV=production` in `.env`
2. Make sure `APP_DEBUG=false` in `.env`
3. SSL verification will be automatically enabled
4. Ensure your server has proper CA certificates installed

---

**Status:** ✅ Fixed for local development

