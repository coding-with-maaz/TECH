# Firebase Unauthorized Domain Error - Fix Guide

## 🔴 Error: `auth/unauthorized-domain`

This error occurs because your current domain is not authorized in Firebase Console.

---

## ✅ Solution: Add Domain to Firebase Console

### Step 1: Go to Firebase Console

1. Visit [Firebase Console](https://console.firebase.google.com/)
2. Select your project: **harpaltech-f183d**

### Step 2: Navigate to Authentication Settings

1. Click on **Authentication** in the left sidebar
2. Click on **Settings** tab (gear icon)
3. Scroll down to **Authorized domains**

### Step 3: Add Your Domain

Click **Add domain** and add the following domains:

#### For Local Development:
```
localhost
127.0.0.1
```

#### For Production (when you deploy):
```
yourdomain.com
www.yourdomain.com
```

**Note:** Firebase automatically includes:
- `localhost` (but you may need to verify it's there)
- Your Firebase project domain: `harpaltech-f183d.firebaseapp.com`

### Step 4: Save Changes

Click **Done** or **Save** to apply the changes.

---

## 🔍 Quick Fix for Local Development

If you're testing on `localhost:8000`, make sure:

1. **localhost** is in the authorized domains list
2. If using a custom port like `localhost:8000`, Firebase should still work (localhost covers all ports)
3. If you're using `127.0.0.1:8000`, add `127.0.0.1` as well

---

## 📝 Step-by-Step Instructions

### Option 1: Using Firebase Console Web Interface

1. Go to: https://console.firebase.google.com/project/harpaltech-f183d/authentication/settings
2. Scroll to **Authorized domains** section
3. Click **Add domain**
4. Enter: `localhost`
5. Click **Add**
6. Repeat for `127.0.0.1` if needed
7. Changes take effect immediately (no need to wait)

### Option 2: Using Firebase CLI (Alternative)

If you have Firebase CLI installed:

```bash
firebase auth:export users.json
# Then manually edit authorized domains in console
```

---

## 🧪 Verify It's Working

After adding the domain:

1. **Clear browser cache** (or use incognito mode)
2. **Refresh the page**
3. Try clicking "Sign in with Google" again
4. The error should be gone!

---

## ⚠️ Other Errors Explained

### Error 1: `A listener indicated an asynchronous response...`
This is usually a **browser extension** issue (like an ad blocker or privacy extension). It's not critical and won't affect Firebase authentication.

**Solution:** You can ignore this, or disable browser extensions temporarily for testing.

### Error 2: `Failed to load resource: net::ERR_BLOCKED_BY_CLIENT`
This is also a **browser extension** blocking a resource (likely an ad blocker).

**Solution:** 
- Disable ad blockers temporarily
- Or add your site to the ad blocker's whitelist
- This won't affect Firebase authentication functionality

---

## 🎯 Common Domains to Add

### Development:
- `localhost`
- `127.0.0.1`
- `localhost:8000` (if needed)

### Production:
- `yourdomain.com`
- `www.yourdomain.com`
- `app.yourdomain.com` (if using subdomain)

---

## 🔒 Security Note

Only add domains you own or control. Don't add random domains as this could be a security risk.

---

## ✅ Checklist

- [ ] Go to Firebase Console
- [ ] Navigate to Authentication > Settings
- [ ] Find "Authorized domains" section
- [ ] Add `localhost`
- [ ] Add `127.0.0.1` (if using IP address)
- [ ] Save changes
- [ ] Clear browser cache
- [ ] Test Google Sign-In again

---

## 🐛 Still Not Working?

If you've added the domain but it's still not working:

1. **Wait a few seconds** - Changes can take a moment to propagate
2. **Clear browser cache completely**
3. **Try incognito/private mode**
4. **Check browser console** for other errors
5. **Verify the domain exactly matches** what you're using (case-sensitive for some domains)

---

## 📚 Additional Resources

- [Firebase Auth Documentation](https://firebase.google.com/docs/auth/web/start)
- [Authorized Domains Guide](https://firebase.google.com/docs/auth/web/redirect-best-practices)

---

**Status:** After adding the domain, the error should be resolved! ✅

