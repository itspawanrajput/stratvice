# Lead CRM - Master Guide

## 1. Local Installation (Immediate Testing)
Since your local MySQL is not working, we are using **SQLite** for instant testing.

1.  **Open Installation Page**:
    *   Go to: `http://localhost:8080/install.php`
    *   **Note**: The database host/user fields will be ignored because we are in SQLite mode.
    
2.  **Fill Admin Details**:
    *   Enter an **Admin Username** (e.g., `admin`)
    *   Enter an **Admin Password** (e.g., `password123`)
    *   Click **Install Lead CRM**

3.  **Login**:
    *   You will be redirected to `index.php`. Login with your new credentials.

---

## 2. How to Test the Webhook
Once logged in, follow these steps to verify leads are being captured:

1.  **Get Your Webhook URL**:
    *   In the CRM, go to **Clients** (Sidebar) or **Settings**.
    *   Copy the **Webhook URL** (matches the pattern: `http://localhost:8080/api/webhook.php?token=...`).

2.  **Open the Simulator**:
    *   Go to: `http://localhost:8080/simulator.html`

3.  **Send a Test Lead**:
    *   Paste your **Webhook URL** into the simulator.
    *   Click **Send Test Lead**.
    *   You should see a green `{ "status": "success", ... }` response.

4.  **Verify in Dashboard**:
    *   Go back to your CRM **Dashboard** or **Leads** page.
    *   You should see the new lead appear instantly!

---

## 3. Deployment to Hostinger (Production)
When you are ready to go live on `app.stratvice.in`:

### Step A: Prepare Database
1.  Log in to **Hostinger hPanel**.
2.  Go to **Databases** -> **Management**.
3.  Create a new MySQL Database.
    *   Note down: `Database Name`, `MySQL Username`, `Password`.

### Step B: Upload Files
1.  Use **File Manager** in Hostinger.
2.  Navigate to `public_html/app` (or wherever you want the CRM).
3.  Upload all files from the `crm` folder on your computer.
    *   **Exclude**: `database.sqlite` (not needed on server).

### Step C: Configure for Production
1.  Edit `config.php` on the server (Hostinger File Manager):
    *   Change `define('DB_TYPE', 'sqlite');` to `define('DB_TYPE', 'mysql');`.
    *   Update `DB_NAME`, `DB_USER`, `DB_PASS` with your Hostinger credentials.
    *   Update `APP_URL` to `https://app.stratvice.in`.

2.  **Run Installer**:
    *   Visit `https://app.stratvice.in/install.php`.
    *   Fill in the database details again to create the tables in MySQL.
    *   Create your Production Admin account.

3.  **Security**:
    *   **Delete** `install.php` and `simulator.html` from the server after setup.

---

## 4. Connecting WordPress (Lead Gravity)
1.  Log in to your **WordPress Admin**.
2.  Go to **Lead Gravity** -> **Settings** -> **Webhooks**.
3.  **Add New Webhook**:
    *   **URL**: Your production CRM URL (e.g., `https://app.stratvice.in/api/webhook.php?token=YOUR_TOKEN`).
    *   **Method**: POST.
    *   **Format**: JSON.
4.  **Save & Test**: Submit a form on your website and check if it appears in the CRM.
