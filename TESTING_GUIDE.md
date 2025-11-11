# ফিশ কেয়ার সিস্টেম - টেস্টিং গাইড

## টেস্টিং ওভারভিউ

এই ডকুমেন্টে সিস্টেমের সব ফিচার এবং ফাংশনালিটি টেস্ট করার জন্য বিস্তারিত নির্দেশনা রয়েছে।

## প্রি-ডেপ্লয়মেন্ট চেকলিস্ট

### ১. প্রোডাকশন রেডিনেস চেক রান করুন

```bash
cd /path/to/fishcare
php database/production-check.php
```

এটি নিম্নলিখিত বিষয় চেক করবে:
- [x] PHP version এবং extensions
- [x] File permissions
- [x] Database connection
- [x] Required tables
- [x] Configuration files
- [x] Security settings

### ২. ডেটাবেস ব্যাকআপ নিন

ডেপ্লয়মেন্টের আগে অবশ্যই ব্যাকআপ নিন:
```bash
mysqldump -u fishcare_user -p fishcare > backup_$(date +%Y%m%d).sql
```

## টেস্ট কেস সমূহ

### অথেন্টিকেশন টেস্টিং

#### TC-001: লগিন টেস্ট
**উদ্দেশ্য**: বৈধ credentials দিয়ে লগিন কাজ করছে কিনা

**Steps**:
1. `/login.php` পেজে যান
2. Email: `admin@fishcare.com`
3. Password: `admin123`
4. "লগিন করুন" বাটন ক্লিক করুন

**Expected Result**:
- ✓ Admin dashboard এ redirect হবে
- ✓ সাইডবারে user info দেখাবে
- ✓ Session তৈরি হবে

**Status**: [ ] Pass [ ] Fail

---

#### TC-002: ভুল পাসওয়ার্ড টেস্ট
**উদ্দেশ্য**: ভুল credentials দিয়ে লগিন ব্লক হচ্ছে কিনা

**Steps**:
1. `/login.php` পেজে যান
2. Email: `admin@fishcare.com`
3. Password: `wrongpassword`
4. "লগিন করুন" বাটন ক্লিক করুন

**Expected Result**:
- ✓ Error message দেখাবে: "ভুল ইমেইল অথবা পাসওয়ার্ড"
- ✓ Dashboard এ redirect হবে না
- ✓ Session তৈরি হবে না

**Status**: [ ] Pass [ ] Fail

---

#### TC-003: রেজিস্ট্রেশন টেস্ট
**উদ্দেশ্য**: নতুন user registration কাজ করছে কিনা

**Steps**:
1. `/register.php` পেজে যান
2. সব ফিল্ড পূরণ করুন (নাম, ইমেইল, পাসওয়ার্ড, ফোন, রোল)
3. "নিবন্ধন করুন" বাটন ক্লিক করুন

**Expected Result**:
- ✓ নতুন user database এ insert হবে
- ✓ Password hash হয়ে সেভ হবে
- ✓ Login page এ redirect হবে success message সহ

**Status**: [ ] Pass [ ] Fail

---

#### TC-004: লগআউট টেস্ট
**উদ্দেশ্য**: লগআউট সঠিকভাবে কাজ করছে কিনা

**Steps**:
1. লগিন করুন
2. "লগআউট" বাটন ক্লিক করুন

**Expected Result**:
- ✓ Session destroy হবে
- ✓ Login page এ redirect হবে
- ✓ Dashboard access করা যাবে না

**Status**: [ ] Pass [ ] Fail

---

### Admin Dashboard টেস্টিং

#### TC-101: User Management
**উদ্দেশ্য**: Admin user add/edit/delete করতে পারছে কিনা

**Steps**:
1. Admin হিসেবে লগিন করুন
2. `dashboard/admin/users.php` যান
3. "নতুন ব্যবহারকারী যোগ করুন" ক্লিক করুন
4. ফর্ম পূরণ করে submit করুন
5. User list এ নতুন user দেখা যাচ্ছে কিনা চেক করুন
6. একটি user এর role change করুন
7. একটি user delete করুন

**Expected Result**:
- ✓ নতুন user তৈরি হচ্ছে
- ✓ Role update হচ্ছে
- ✓ User delete হচ্ছে
- ✓ সব অপারেশনে success message দেখাচ্ছে

**Status**: [ ] Pass [ ] Fail

---

#### TC-102: System Reports
**উদ্দেশ্য**: Reports generate এবং export করা যাচ্ছে কিনা

**Steps**:
1. `dashboard/admin/reports.php` যান
2. Report type সিলেক্ট করুন
3. Date range দিন
4. "রিপোর্ট তৈরি করুন" ক্লিক করুন
5. "CSV Export" এবং "PDF Export" টেস্ট করুন

**Expected Result**:
- ✓ Report data সঠিকভাবে দেখাচ্ছে
- ✓ CSV file ডাউনলোড হচ্ছে
- ✓ PDF file ডাউনলোড হচ্ছে

**Status**: [ ] Pass [ ] Fail

---

#### TC-103: System Monitoring
**উদ্দেশ্য**: System stats এবং activity logs দেখা যাচ্ছে কিনা

**Steps**:
1. `dashboard/admin/monitoring.php` যান
2. Server stats চেক করুন
3. Activity timeline চেক করুন
4. Database size info চেক করুন

**Expected Result**:
- ✓ Real-time stats দেখাচ্ছে
- ✓ Activity logs সঠিক
- ✓ Database info accurate

**Status**: [ ] Pass [ ] Fail

---

### Wholesaler Dashboard টেস্টিং

#### TC-201: Invoice Management
**উদ্দেশ্য**: Wholesaler invoice তৈরি এবং manage করতে পারছে কিনা

**Steps**:
1. Wholesaler হিসেবে লগিন করুন
2. `dashboard/wholesaler/invoices.php` যান
3. "নতুন ইনভয়েস তৈরি করুন" ক্লিক করুন
4. Customer, products, payment info দিন
5. Invoice submit করুন
6. PDF download টেস্ট করুন

**Expected Result**:
- ✓ Invoice তৈরি হচ্ছে
- ✓ Unique invoice number generate হচ্ছে
- ✓ PDF download কাজ করছে
- ✓ Invoice list এ দেখা যাচ্ছে

**Status**: [ ] Pass [ ] Fail

---

#### TC-202: Shipment Tracking
**উদ্দেশ্য**: Shipment তৈরি এবং status update কাজ করছে কিনা

**Steps**:
1. `dashboard/wholesaler/shipments.php` যান
2. "নতুন শিপমেন্ট যোগ করুন" ক্লিক করুন
3. Destination, items count, notes দিন
4. Submit করুন
5. Status update করুন: Pending → In Transit → Delivered

**Expected Result**:
- ✓ Shipment তৈরি হচ্ছে
- ✓ Tracking number generate হচ্ছে
- ✓ Status update হচ্ছে
- ✓ Statistics সঠিক

**Status**: [ ] Pass [ ] Fail

---

#### TC-203: Inventory Management
**উদ্দেশ্য**: Stock management এবং alerts কাজ করছে কিনা

**Steps**:
1. `dashboard/wholesaler/inventory.php` যান
2. Product list চেক করুন
3. Low stock items identify করুন
4. Stock quantity update করুন
5. Statistics verify করুন

**Expected Result**:
- ✓ Product list সঠিকভাবে দেখাচ্ছে
- ✓ Stock level indicators কাজ করছে
- ✓ Low stock alerts দেখাচ্ছে
- ✓ Update functionality কাজ করছে

**Status**: [ ] Pass [ ] Fail

---

#### TC-204: Customer Management
**উদ্দেশ্য**: Customer data manage করা যাচ্ছে কিনা

**Steps**:
1. `dashboard/wholesaler/customers.php` যান
2. Customer list view করুন
3. Search/filter functionality টেস্ট করুন
4. নতুন customer add করুন

**Expected Result**:
- ✓ Customer list load হচ্ছে
- ✓ Search কাজ করছে
- ✓ Filter apply হচ্ছে
- ✓ New customer add হচ্ছে

**Status**: [ ] Pass [ ] Fail

---

#### TC-205: Finance Tracking
**উদ্দেশ্য**: Income-expense tracking এবং analytics কাজ করছে কিনা

**Steps**:
1. `dashboard/wholesaler/finance.php` যান
2. Chart/graph rendering চেক করুন
3. Transaction list verify করুন
4. Date filter apply করুন
5. CSV export টেস্ট করুন

**Expected Result**:
- ✓ Charts সঠিকভাবে render হচ্ছে
- ✓ Transaction data accurate
- ✓ Filters কাজ করছে
- ✓ Export functionality working

**Status**: [ ] Pass [ ] Fail

---

### Seller Dashboard টেস্টিং

#### TC-301: Order Management
**উদ্দেশ্য**: Seller তার orders দেখতে এবং manage করতে পারছে কিনা

**Steps**:
1. Seller হিসেবে লগিন করুন
2. `dashboard/seller/orders.php` যান
3. Order list চেক করুন
4. Status filter apply করুন
5. Date filter টেস্ট করুন

**Expected Result**:
- ✓ Order list load হচ্ছে
- ✓ Filters কাজ করছে
- ✓ Pagination working (যদি থাকে)
- ✓ Order details সঠিক

**Status**: [ ] Pass [ ] Fail

---

#### TC-302: Payment History
**উদ্দেশ্য**: Payment tracking কাজ করছে কিনা

**Steps**:
1. `dashboard/seller/payments.php` যান
2. Payment history view করুন
3. Status-wise filtering করুন
4. Total calculations verify করুন

**Expected Result**:
- ✓ Payment list accurate
- ✓ Filters working
- ✓ Total amounts correct
- ✓ Status badges showing properly

**Status**: [ ] Pass [ ] Fail

---

#### TC-303: Wishlist Management
**উদ্দেশ্য**: Wishlist add/remove কাজ করছে কিনা

**Steps**:
1. `dashboard/seller/wishlist.php` যান
2. Wishlist items view করুন
3. একটি item remove করুন
4. Marketplace থেকে নতুন item add করুন

**Expected Result**:
- ✓ Wishlist items showing
- ✓ Remove functionality working
- ✓ Add to wishlist working
- ✓ Database properly updated

**Status**: [ ] Pass [ ] Fail

---

#### TC-304: Stock Management
**উদ্দেশ্য**: Seller তার stock manage করতে পারছে কিনা

**Steps**:
1. `dashboard/seller/stocks.php` যান
2. Stock items view করুন
3. Stock quantity update করুন
4. Low stock alerts চেক করুন

**Expected Result**:
- ✓ Stock data showing correctly
- ✓ Update working
- ✓ Alerts functioning
- ✓ Statistics accurate

**Status**: [ ] Pass [ ] Fail

---

### Farmer Dashboard টেস্টিং

#### TC-401: Pond Management
**উদ্দেশ্য**: Pond records CRUD operations কাজ করছে কিনা

**Steps**:
1. Farmer হিসেবে লগিন করুন
2. `dashboard/farmer/ponds.php` যান
3. নতুন pond record add করুন
4. Existing record update করুন
5. Record delete করুন

**Expected Result**:
- ✓ Create working
- ✓ Read/View working
- ✓ Update working
- ✓ Delete working

**Status**: [ ] Pass [ ] Fail

---

#### TC-402: Transaction Management
**উদ্দেশ্য**: Income-expense tracking কাজ করছে কিনা

**Steps**:
1. `dashboard/farmer/transactions.php` যান
2. নতুন income entry add করুন
3. নতুন expense entry add করুন
4. Charts এবং summary verify করুন

**Expected Result**:
- ✓ Transactions adding correctly
- ✓ Charts rendering properly
- ✓ Summary calculations accurate
- ✓ Filters working

**Status**: [ ] Pass [ ] Fail

---

### Public Pages টেস্টিং

#### TC-501: Homepage
**উদ্দেশ্য**: Homepage সঠিকভাবে load হচ্ছে কিনা

**Steps**:
1. `/` বা `/index.php` visit করুন
2. সব sections scroll করুন
3. Navigation links টেস্ট করুন
4. Responsive design চেক করুন (mobile/tablet)

**Expected Result**:
- ✓ Page loads without errors
- ✓ All images showing
- ✓ Links working
- ✓ Responsive on all devices

**Status**: [ ] Pass [ ] Fail

---

#### TC-502: Products/Marketplace
**উদ্দেশ্য**: Product browsing এবং filtering কাজ করছে কিনা

**Steps**:
1. `/products.php` যান
2. Product list view করুন
3. Category filter apply করুন
4. Search functionality টেস্ট করুন
5. Product details page যান

**Expected Result**:
- ✓ Products showing correctly
- ✓ Filters working
- ✓ Search working
- ✓ Details page accessible

**Status**: [ ] Pass [ ] Fail

---

#### TC-503: Contact Form
**উদ্দেশ্য**: Contact form submission কাজ করছে কিনা

**Steps**:
1. `/contact.php` যান
2. Form পূরণ করুন
3. Submit করুন
4. Database এ entry verify করুন

**Expected Result**:
- ✓ Form validation working
- ✓ Submission successful
- ✓ Data saved in database
- ✓ Success message showing

**Status**: [ ] Pass [ ] Fail

---

### API Testing

#### TC-601: Pond API
**Endpoint**: `/api/pond.php`

**Test Cases**:
1. GET all ponds: `?action=list&user_id=1`
2. GET single pond: `?action=get&id=1`
3. CREATE pond: POST with data
4. UPDATE pond: PUT with data
5. DELETE pond: DELETE request

**Expected Result**:
- ✓ All CRUD operations working
- ✓ Proper JSON responses
- ✓ Error handling working
- ✓ Authentication checked

**Status**: [ ] Pass [ ] Fail

---

#### TC-602: Invoice API
**Endpoint**: `/api/invoice.php`

**Test Cases**:
1. List invoices
2. Get invoice details
3. Create invoice
4. Update invoice status
5. Generate PDF

**Expected Result**:
- ✓ All operations working
- ✓ PDF generation working
- ✓ Data validation working
- ✓ Proper error responses

**Status**: [ ] Pass [ ] Fail

---

### Performance Testing

#### TC-701: Page Load Time
**উদ্দেশ্য**: Page load performance চেক করা

**Tools**: Browser DevTools, GTmetrix, PageSpeed Insights

**Metrics to Check**:
- Homepage load time: < 3 seconds
- Dashboard load time: < 2 seconds
- Database queries: Optimized with indexes
- Image optimization: Compressed and cached

**Status**: [ ] Pass [ ] Fail

---

#### TC-702: Database Performance
**উদ্দেশ্য**: Query performance চেক করা

**Steps**:
1. Enable MySQL slow query log
2. Perform common operations
3. Check for slow queries (> 1 second)
4. Verify indexes are being used

**Expected Result**:
- ✓ No slow queries
- ✓ Indexes properly utilized
- ✓ Connection pooling working

**Status**: [ ] Pass [ ] Fail

---

### Security Testing

#### TC-801: SQL Injection
**উদ্দেশ্য**: SQL injection সুরক্ষা আছে কিনা

**Test Inputs**:
- `' OR '1'='1`
- `"; DROP TABLE users; --`
- `1' UNION SELECT * FROM users--`

**Expected Result**:
- ✓ Prepared statements ব্যবহার করা হচ্ছে
- ✓ Injection attempts blocked
- ✓ Proper error handling

**Status**: [ ] Pass [ ] Fail

---

#### TC-802: XSS (Cross-Site Scripting)
**উদ্দেশ্য**: XSS সুরক্ষা আছে কিনা

**Test Inputs**:
- `<script>alert('XSS')</script>`
- `<img src=x onerror=alert('XSS')>`

**Expected Result**:
- ✓ htmlspecialchars() ব্যবহার করা হচ্ছে
- ✓ Scripts execute হচ্ছে না
- ✓ Output properly escaped

**Status**: [ ] Pass [ ] Fail

---

#### TC-803: CSRF Protection
**উদ্দেশ্য**: CSRF সুরক্ষা আছে কিনা

**Steps**:
1. Check for CSRF tokens in forms
2. Try submitting without token
3. Try with invalid token

**Expected Result**:
- ✓ CSRF tokens generated
- ✓ Validation working
- ✓ Invalid requests blocked

**Status**: [ ] Pass [ ] Fail

---

#### TC-804: Authentication Bypass
**উদ্দেশ্য**: Unauthorized access blocked করা হচ্ছে কিনা

**Steps**:
1. Try accessing dashboard without login
2. Try accessing admin pages as regular user
3. Try role escalation

**Expected Result**:
- ✓ Redirect to login
- ✓ Role-based access working
- ✓ Session validation proper

**Status**: [ ] Pass [ ] Fail

---

### Browser Compatibility Testing

#### TC-901: Cross-Browser Testing
**Browsers to Test**:
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile browsers (iOS Safari, Chrome Android)

**Test Points**:
- Layout rendering
- CSS styling
- JavaScript functionality
- Form submissions

---

### Responsive Design Testing

#### TC-1001: Mobile Devices
**Devices to Test**:
- [ ] iPhone (various sizes)
- [ ] Android phones
- [ ] Tablets

**Check Points**:
- Navigation menu (hamburger)
- Tables (horizontal scroll/cards)
- Forms (input sizes)
- Charts (responsive)

---

## Bug Reporting Template

```
Bug ID: BUG-XXX
Title: [Short description]
Severity: [Critical/High/Medium/Low]
Priority: [P0/P1/P2/P3]

Steps to Reproduce:
1. 
2. 
3. 

Expected Result:


Actual Result:


Environment:
- Browser:
- OS:
- User Role:

Screenshots:
[Attach if applicable]

Additional Notes:

```

---

## Test Execution Summary

### Overall Statistics
- **Total Test Cases**: 35+
- **Passed**: ___
- **Failed**: ___
- **Skipped**: ___
- **Blocked**: ___

### Defect Summary
- **Critical**: ___
- **High**: ___
- **Medium**: ___
- **Low**: ___

### Sign-off
- **Tested By**: _______________
- **Date**: _______________
- **Status**: [ ] Approved [ ] Needs Fixes
- **Notes**: _______________

---

**এই টেস্টিং সম্পন্ন হলে, সিস্টেম প্রোডাকশনের জন্য প্রস্তুত হবে।**
