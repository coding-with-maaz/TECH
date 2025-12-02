# Firebase SSL Certificate Fix for Windows

## 🔴 Error: SSL Certificate Problem

```
cURL error 60: SSL certificate problem: unable to get local issuer certificate
```

This is a common issue on Windows when cURL can't verify SSL certificates.

---

## ✅ Solution 1: Download CA Certificate Bundle (Recommended)

### Step 1: Download CA Bundle

1. Download `cacert.pem` from: https://curl.se/ca/cacert.pem
2. Save it to your project: `storage/cacert.pem`

### Step 2: Configure PHP

Edit your `php.ini` file (find it with `php --ini`):

```ini
curl.cainfo = "C:\Users\k\Desktop\Nazaarabox - Copy\storage\cacert.pem"
```

### Step 3: Restart Web Server

Restart your PHP development server or web server.

---

## ✅ Solution 2: Disable SSL Verification (Local Dev Only)

I've already implemented this in the code, but if it's not working, you can also:

### Option A: Edit php.ini

Add to `php.ini`:

```ini
curl.cainfo = ""
```

**WARNING:** This disables SSL verification globally. Only use for local development!

### Option B: Use Environment Variable

Add to your `.env`:

```env
CURL_CAINFO=
```

---

## ✅ Solution 3: Use the Code Fix (Already Implemented)

The code already tries to disable SSL verification for local development. If it's still not working, the Firebase SDK might not support the `withHttpClient` method.

### Manual Fix

If the automatic fix doesn't work, you can manually modify `php.ini`:

1. Find your `php.ini` file:
   ```bash
   php --ini
   ```

2. Edit `php.ini` and add/update:
   ```ini
   curl.cainfo = ""
   ```

3. Restart your web server

---

## 🧪 Test the Fix

After applying any solution:

1. **Clear cache:**
   ```bash
   php artisan config:clear
   ```

2. **Restart your server** (if using `php artisan serve`)

3. **Try Google Sign-In again**

---

## 📝 Current Implementation

The code in `FirebaseAuthService.php` tries to:
- Detect local development mode
- Create HTTP client with `verify => false`
- Configure Firebase Factory with custom HTTP client

If this doesn't work, use Solution 1 (download CA bundle) or Solution 2 (php.ini).

---

## 🔒 Security Note

**Never disable SSL verification in production!**

- ✅ Safe for: Local development only
- ❌ Never use in: Production environments

---

## ✅ Quick Fix (Temporary)

For immediate testing, you can temporarily edit `php.ini`:

```ini
curl.cainfo = ""
```

Then restart your server and test. Remember to revert this for production!

---

**Status:** Code fix implemented, but you may need to configure `php.ini` for it to work properly.

