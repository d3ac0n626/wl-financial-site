# Wealth & Legacy Financial - Website

A clean, professional landing page for W&L Financial, optimized for GitHub Pages hosting.

## 📁 Folder Structure

```
wl-financial-site/
├── index.html          # Main website file
├── css/
│   └── style.css       # All styling
├── assets/
│   └── logo.png        # Company logo
├── README.md           # This file
└── .gitignore          # Git ignore file (optional)
```

## 🚀 Quick Start

### Option 1: Deploy to GitHub Pages (Recommended)

#### Step 1: Create a GitHub Repository
1. Go to [github.com](https://github.com)
2. Click "New" to create a new repository
3. Name it: `wl-financial-site` (or any name you prefer)
4. Set it to **Public** (required for GitHub Pages)
5. Click "Create repository"

#### Step 2: Clone the Repository Locally
```bash
git clone https://github.com/YOUR_USERNAME/wl-financial-site.git
cd wl-financial-site
```

#### Step 3: Copy Files to Your Repository
- Copy `index.html` to the root of the cloned folder
- Copy the `css/` folder to the repository
- Copy the `assets/` folder to the repository

Your folder structure should look like:
```
wl-financial-site/
├── index.html
├── css/style.css
├── assets/logo.png
└── README.md
```

#### Step 4: Push to GitHub
```bash
git add .
git commit -m "Initial commit: Add W&L Financial landing page"
git push origin main
```

#### Step 5: Enable GitHub Pages
1. Go to your repository on GitHub
2. Click on **Settings**
3. Scroll down to **Pages** section (left sidebar)
4. Under "Source", select **Main** branch
5. Click **Save**
6. GitHub will provide a URL like: `https://YOUR_USERNAME.github.io/wl-financial-site/`
7. Your site is now live! 🎉

---

### Step 6: Connect Your Custom Domain (awealthandlegacyfinancial.com)

#### On Name.com (Your Domain Registrar):

1. Log in to your Name.com account
2. Go to **My Domains** → Select `awealthandlegacyfinancial.com`
3. Click **Manage DNS**
4. You'll see the DNS records. Delete any existing A records
5. Add **4 A records** pointing to GitHub Pages:

   | Type | Name | Value |
   |------|------|-------|
   | A | @ | 185.199.108.153 |
   | A | @ | 185.199.109.153 |
   | A | @ | 185.199.110.153 |
   | A | @ | 185.199.111.153 |

6. (Optional) Add a CNAME record for `www`:
   - Type: **CNAME**
   - Name: **www**
   - Value: **YOUR_USERNAME.github.io**

7. Click **Save Changes**
8. DNS propagation can take 24-48 hours

#### In Your GitHub Repository:

1. Go to repository **Settings** → **Pages**
2. Under "Custom domain", enter: `awealthandlegacyfinancial.com`
3. Click **Save**
4. GitHub will create a `CNAME` file automatically
5. Check the **"Enforce HTTPS"** box for security
6. Wait for GitHub to verify the DNS (usually 1-2 minutes)

#### Verify It's Working:
- Visit `https://awealthandlegacyfinancial.com` in your browser
- You should see your W&L Financial landing page
- It may take 24-48 hours for full propagation

---

## 🔧 Making Changes

To update your website:

1. Edit `index.html` or `css/style.css` locally
2. Push changes to GitHub:
   ```bash
   git add .
   git commit -m "Update: [describe your changes]"
   git push origin main
   ```
3. Changes will be live in a few seconds

---

## 📱 Features

✅ Clean, professional design  
✅ Fully responsive (mobile, tablet, desktop)  
✅ Fast loading (no frameworks, pure HTML/CSS)  
✅ Instagram CTAs throughout  
✅ Hero section with compelling messaging  
✅ Stats and benefits showcase  
✅ FAQ section  
✅ Social proof  
✅ Professional footer with "Powered by Unity Financial Group LLC"  

---

## 🎨 Customization

### Change Colors:
Edit the CSS variables at the top of `css/style.css`:
```css
:root {
    --primary-dark: #001F3F;   /* Dark blue */
    --primary-gold: #D4AF37;   /* Gold */
    /* ... other colors ... */
}
```

### Change Content:
Edit `index.html` directly. All text is clearly labeled.

### Change Logo:
Replace `assets/logo.png` with your new logo (keep the same filename)

---

## ❓ Troubleshooting

**Site not showing up?**
- DNS changes can take 24-48 hours to propagate
- Clear your browser cache: `Ctrl+Shift+Delete` (Windows) or `Cmd+Shift+Delete` (Mac)
- Check GitHub Pages settings are enabled

**HTTPS not working?**
- Make sure "Enforce HTTPS" is checked in GitHub Pages settings
- Wait a few minutes for GitHub to issue the SSL certificate

**Logo not showing?**
- Make sure `assets/logo.png` exists in your repository
- Refresh the page with `Ctrl+F5` or `Cmd+Shift+R`

---

## 📞 Support

For GitHub Pages help: [GitHub Docs](https://docs.github.com/en/pages)  
For Name.com DNS help: Contact Name.com support

---

**Made with ❤️ for Wealth & Legacy Financial**
