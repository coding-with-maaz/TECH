# Quick SSL Certificate Fix

## 🔴 The Problem

Windows cURL can't verify SSL certificates because it doesn't have the CA certificate bundle.

## ✅ Easiest Fix (2 minutes)

### Option 1: Edit php.ini (Recommended)

1. **Find your php.ini:**
   ```
   C:\php\php.ini
   ```

2. **Open it in a text editor** (as Administrator)

3. **Find the line:**
   ```ini
   ;curl.cainfo =
   ```

4. **Change it to (for local dev only):**
   ```ini
   curl.cainfo = ""
   ```

5. **Save and restart your web server**

6. **Test Google Sign-In** - should work now!

---

### Option 2: Download CA Bundle (Better for Production)

1. **Download:** https://curl.se/ca/cacert.pem
2. **Save to:** `C:\Users\k\Desktop\Nazaarabox - Copy\storage\cacert.pem`
3. **Edit php.ini:**
   ```ini
   curl.cainfo = "C:\Users\k\Desktop\Nazaarabox - Copy\storage\cacert.pem"
   ```
4. **Restart server**

---

## ⚠️ Important

- **Option 1** disables SSL verification (local dev only!)
- **Option 2** uses proper CA bundle (works everywhere)

**For production, always use Option 2!**

---

## 🧪 After Fix

1. Restart your server: `php artisan serve`
2. Clear cache: `php artisan config:clear`
3. Try Google Sign-In again

---

**Status:** Code fix implemented, but you need to configure `php.ini` for it to work properly.

