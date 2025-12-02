# ⚠️ URGENT: SSL Certificate Fix Required

## 🔴 Current Error

**"Maximum execution time of 30 seconds exceeded"**

This happens because:
1. Firebase tries to verify the JWT token
2. It makes an HTTP request to Google's servers
3. SSL certificate verification fails
4. The request hangs/times out
5. PHP execution time limit (30 seconds) is exceeded

---

## ✅ IMMEDIATE FIX (Required)

You **MUST** edit your `php.ini` file to fix this.

### Step-by-Step Instructions

1. **Open File Explorer**
   - Navigate to: `C:\php\`
   - Find: `php.ini`

2. **Open php.ini as Administrator**
   - Right-click `php.ini`
   - Select "Open with" → Notepad (or any text editor)
   - **Important:** If you can't edit it, right-click → "Run as Administrator"

3. **Find the curl.cainfo line**
   - Press `Ctrl+F` to search
   - Search for: `curl.cainfo`
   - You'll find a line like: `;curl.cainfo =`

4. **Edit the line**
   
   **Option A: Disable SSL verification (Quick fix for local dev):**
   ```ini
   curl.cainfo = ""
   ```
   Remove the semicolon `;` at the beginning and set it to empty string.

   **Option B: Use CA bundle (Better solution):**
   ```ini
   curl.cainfo = "C:\Users\k\Desktop\Nazaarabox - Copy\storage\cacert.pem"
   ```
   (First download cacert.pem from https://curl.se/ca/cacert.pem and save to `storage/cacert.pem`)

5. **Save the file** (Ctrl+S)

6. **Restart your server:**
   - Stop current server (Ctrl+C in terminal)
   - Start again: `php artisan serve`

7. **Clear cache:**
   ```bash
   php artisan config:clear
   ```

8. **Test Google Sign-In** - Should work now!

---

## 📥 Download CA Bundle (Recommended)

If you want to use Option B (better for production):

1. **Download:** https://curl.se/ca/cacert.pem
2. **Save to:** `C:\Users\k\Desktop\Nazaarabox - Copy\storage\cacert.pem`
3. **Edit php.ini** as shown in Option B above
4. **Restart server**

---

## ⚡ Quick Test

After editing php.ini, you can test if it worked:

```bash
php -r "echo ini_get('curl.cainfo');"
```

If it shows empty string `""` (or your CA bundle path), it's configured correctly!

---

## 🔍 Why This Is Required

- Firebase SDK makes **internal HTTP requests** to verify tokens
- These requests use **cURL directly** (not our HTTP client)
- cURL needs to be configured at the **PHP level** (php.ini)
- Code-level fixes can't override cURL's SSL verification

---

## ✅ What I've Already Done

- ✅ Increased execution time limit to 60 seconds
- ✅ Reduced HTTP client timeout to fail faster
- ✅ Added better error messages
- ✅ Configured HTTP client with SSL disabled (for when it works)

**But you still need to configure php.ini for it to work!**

---

## 🎯 Summary

**Edit `C:\php\php.ini`:**
```ini
curl.cainfo = ""
```

**Then restart your server and test!**

---

**Status:** Code improvements made, but `php.ini` configuration is **REQUIRED**!

