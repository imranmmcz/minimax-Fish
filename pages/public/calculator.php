<?php
$pageTitle = "ফিস ক্যালকুলেটর";
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="header-content">
            <div class="header-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <rect x="12" y="20" width="40" height="24" rx="8" fill="url(#calculatorGradient)" stroke="white" stroke-width="2"/>
                    <rect x="16" y="24" width="32" height="8" rx="4" fill="white"/>
                    <circle cx="20" cy="38" r="3" fill="white"/>
                    <circle cx="28" cy="38" r="3" fill="white"/>
                    <circle cx="36" cy="38" r="3" fill="white"/>
                    <circle cx="44" cy="38" r="3" fill="white"/>
                    <circle cx="20" cy="44" r="3" fill="white"/>
                    <circle cx="28" cy="44" r="3" fill="white"/>
                    <circle cx="36" cy="44" r="3" fill="white"/>
                    <circle cx="44" cy="44" r="3" fill="white"/>
                    <rect x="36" y="44" width="8" height="8" rx="2" fill="white"/>
                    <defs>
                        <linearGradient id="calculatorGradient" x1="0" y1="0" x2="64" y2="64">
                            <stop offset="0%" style="stop-color:#00BCD4"/>
                            <stop offset="100%" style="stop-color:#4CAF50"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="header-text">
                <h1>ফিস ক্যালকুলেটর</h1>
                <p>পুকুর পরিমাপ, খাবার ও ওষুধের পরিমাণ নির্ধারণের জন্য সহজ ক্যালকুলেটর</p>
            </div>
        </div>
    </div>
</section>

<!-- Calculator Categories -->
<section class="calculator-categories">
    <div class="container">
        <div class="categories-grid">
            
            <!-- ক্যালকুলেটর ধরন ১: পুকুর পরিমাপ -->
            <div class="category-card glass-card" data-calculator="pond">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <rect x="8" y="12" width="32" height="24" rx="4" fill="#2196F3"/>
                        <ellipse cx="24" cy="24" rx="12" ry="6" fill="#E3F2FD"/>
                        <circle cx="18" cy="20" r="2" fill="#2196F3"/>
                        <circle cx="30" cy="20" r="2" fill="#2196F3"/>
                        <path d="M16 26C18 28 30 28 32 26" stroke="#2196F3" stroke-width="2" fill="none"/>
                    </svg>
                </div>
                <h3>পুকুর পরিমাপ</h3>
                <p>পুকুরের দৈর্ঘ্য, প্রস্থ ও গভীরতা দিয়ে আয়তন বের করুন</p>
                <div class="category-features">
                    <span class="feature">আয়তন গণনা</span>
                    <span class="feature">সমানুপাতিকতা</span>
                </div>
                <button class="btn-select" onclick="selectCalculator('pond')">নির্বাচন করুন</button>
            </div>

            <!-- ক্যালকুলেটর ধরন ২: পানির পরিমাপ -->
            <div class="category-card glass-card" data-calculator="water">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <ellipse cx="24" cy="20" rx="16" ry="8" fill="#03A9F4"/>
                        <ellipse cx="24" cy="20" rx="12" ry="6" fill="#E1F5FE"/>
                        <path d="M12 28C12 32 18 34 24 34C30 34 36 32 36 28" stroke="#03A9F4" stroke-width="2" fill="none"/>
                        <circle cx="20" cy="16" r="1" fill="#03A9F4"/>
                        <circle cx="28" cy="16" r="1" fill="#03A9F4"/>
                    </svg>
                </div>
                <h3>পানির পরিমাপ</h3>
                <p>পুকুরের আয়তন ও পানির পরিমাণ নির্ধারণ করুন</p>
                <div class="category-features">
                    <span class="feature">পানির পরিমাণ</span>
                    <span class="feature">ঘনত্ব বিশ্লেষণ</span>
                </div>
                <button class="btn-select" onclick="selectCalculator('water')">নির্বাচন করুন</button>
            </div>

            <!-- ক্যালকুলেটর ধরন ৩: খাবার পরিমাপ -->
            <div class="category-card glass-card" data-calculator="food">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="18" fill="#4CAF50"/>
                        <circle cx="18" cy="20" r="3" fill="#E8F5E9"/>
                        <circle cx="30" cy="20" r="3" fill="#E8F5E9"/>
                        <path d="M18 28C20 30 28 30 30 28" stroke="#E8F5E9" stroke-width="2" fill="none"/>
                        <rect x="20" y="12" width="8" height="4" rx="2" fill="#2E7D32"/>
                    </svg>
                </div>
                <h3>খাবারের পরিমাপ</h3>
                <p>মাছের সংখ্যা ও ওজন অনুযায়ী দৈনিক খাবারের পরিমাণ বের করুন</p>
                <div class="category-features">
                    <span class="feature">খাবারের পরিমাণ</span>
                    <span class="feature">খাওয়ানোর সময়</span>
                </div>
                <button class="btn-select" onclick="selectCalculator('food')">নির্বাচন করুন</button>
            </div>

            <!-- ক্যালকুলেটর ধরন ৪: ওষুধ পরিমাপ -->
            <div class="category-card glass-card" data-calculator="medicine">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <rect x="20" y="8" width="8" height="32" rx="4" fill="#F44336"/>
                        <rect x="8" y="20" width="32" height="8" rx="4" fill="#F44336"/>
                        <circle cx="24" cy="24" r="6" fill="white"/>
                    </svg>
                </div>
                <h3>ওষুধের পরিমাপ</h3>
                <p>পানির আয়তন ও ওষুধের ঘনত্ব অনুযায়ী প্রয়োজনীয় ওষুধের পরিমাণ বের করুন</p>
                <div class="category-features">
                    <span class="feature">ওষুধের পরিমাণ</span>
                    <span class="feature">প্রয়োগের নির্দেশনা</span>
                </div>
                <button class="btn-select" onclick="selectCalculator('medicine')">নির্বাচন করুন</button>
            </div>

        </div>
    </div>
</section>

<!-- Calculator Interface -->
<section class="calculator-interface" id="calculatorInterface" style="display: none;">
    <div class="container">
        <div class="calculator-card glass-card">
            <div class="calculator-header">
                <h3 id="calculatorTitle">ক্যালকুলেটর</h3>
                <p id="calculatorDescription">আপনার প্রয়োজনীয় তথ্য দিন</p>
            </div>

            <!-- Pond Calculator -->
            <div class="calculator-form" id="pondCalculator">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="pondLength">পুকুরের দৈর্ঘ্য (মিটার)</label>
                        <input type="number" id="pondLength" placeholder="দৈর্ঘ্য লিখুন" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="pondWidth">পুকুরের প্রস্থ (মিটার)</label>
                        <input type="number" id="pondWidth" placeholder="প্রস্থ লিখুন" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="pondDepth">পুকুরের গভীরতা (মিটার)</label>
                        <input type="number" id="pondDepth" placeholder="গভীরতা লিখুন" step="0.1" min="0">
                    </div>
                </div>
                <div class="calculator-actions">
                    <button type="button" class="btn-calculate" onclick="calculatePondVolume()">গণনা করুন</button>
                    <button type="button" class="btn-reset" onclick="resetPondCalculator()">সাফ করুন</button>
                </div>
                <div class="result-area" id="pondResult">
                    <!-- Results will be displayed here -->
                </div>
            </div>

            <!-- Water Calculator -->
            <div class="calculator-form" id="waterCalculator">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="pondVolume">পুকুরের আয়তন (কিউবিক মিটার)</label>
                        <input type="number" id="pondVolume" placeholder="আয়তন লিখুন" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="waterFillPercentage">পানি পূর্ণতার শতাংশ (%)</label>
                        <input type="number" id="waterFillPercentage" placeholder="০-১০০" min="0" max="100" value="80">
                    </div>
                    <div class="form-group">
                        <label for="waterConversion">ইউনিট রূপান্তর</label>
                        <select id="waterConversion">
                            <option value="cubic_meter_to_liter">কিউবিক মিটার → লিটার</option>
                            <option value="cubic_meter_to_gallon">কিউবিক মিটার → গ্যালন</option>
                            <option value="liter_to_cubic_meter">লিটার → কিউবিক মিটার</option>
                            <option value="gallon_to_cubic_meter">গ্যালন → কিউবিক মিটার</option>
                        </select>
                    </div>
                </div>
                <div class="calculator-actions">
                    <button type="button" class="btn-calculate" onclick="calculateWaterAmount()">গণনা করুন</button>
                    <button type="button" class="btn-reset" onclick="resetWaterCalculator()">সাফ করুন</button>
                </div>
                <div class="result-area" id="waterResult">
                    <!-- Results will be displayed here -->
                </div>
            </div>

            <!-- Food Calculator -->
            <div class="calculator-form" id="foodCalculator">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="fishCount">মাছের সংখ্যা</label>
                        <input type="number" id="fishCount" placeholder="মাছের সংখ্যা" min="1">
                    </div>
                    <div class="form-group">
                        <label for="averageWeight">গড় ওজন (কেজি)</label>
                        <input type="number" id="averageWeight" placeholder="প্রতিটি মাছের ওজন" step="0.01" min="0">
                    </div>
                    <div class="form-group">
                        <label for="feedPercentage">খাবারের হার (%)</label>
                        <select id="feedPercentage">
                            <option value="1">১% (প্রাপ্তবয়স্ক)</option>
                            <option value="2">২% (বৃদ্ধিপ্রাপ্ত)</option>
                            <option value="3">৩% (তরুণ)</option>
                            <option value="4">৪% (ছোট পোনা)</option>
                            <option value="5">৫% (অল্পবয়স্ক)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="feedTimes">দৈনিক খাওয়ানোর সংখ্যা</label>
                        <select id="feedTimes">
                            <option value="2">২ বার</option>
                            <option value="3">৩ বার</option>
                            <option value="4">৪ বার</option>
                        </select>
                    </div>
                </div>
                <div class="calculator-actions">
                    <button type="button" class="btn-calculate" onclick="calculateFoodAmount()">গণনা করুন</button>
                    <button type="button" class="btn-reset" onclick="resetFoodCalculator()">সাফ করুন</button>
                </div>
                <div class="result-area" id="foodResult">
                    <!-- Results will be displayed here -->
                </div>
            </div>

            <!-- Medicine Calculator -->
            <div class="calculator-form" id="medicineCalculator">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="medicineWaterVolume">পানির আয়তন (লিটার)</label>
                        <input type="number" id="medicineWaterVolume" placeholder="পানির আয়তন" step="0.1" min="0">
                    </div>
                    <div class="form-group">
                        <label for="medicineConcentration">ওষুধের ঘনত্ব (mg/litre)</label>
                        <select id="medicineConcentration">
                            <option value="1">১ mg/লিটার (হালকা)</option>
                            <option value="2">২ mg/লিটার (মধ্যম)</option>
                            <option value="3">৩ mg/লিটার (গুরুতর)</option>
                            <option value="5">৫ mg/লিটার (অত্যন্ত গুরুতর)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="treatmentDays">চিকিৎসার দিনসংখ্যা</label>
                        <input type="number" id="treatmentDays" placeholder="দিনের সংখ্যা" min="1" value="3">
                    </div>
                    <div class="form-group">
                        <label for="medicineType">ওষুধের ধরন</label>
                        <select id="medicineType">
                            <option value="antibiotic">অ্যান্টিবায়োটিক</option>
                            <option value="antiparasitic">অ্যান্টিপারাসিটিক</option>
                            <option value="antifungal">অ্যান্টিফাঙ্গাল</option>
                            <option value="vitamin">ভিটামিন</option>
                        </select>
                    </div>
                </div>
                <div class="calculator-actions">
                    <button type="button" class="btn-calculate" onclick="calculateMedicineAmount()">গণনা করুন</button>
                    <button type="button" class="btn-reset" onclick="resetMedicineCalculator()">সাফ করুন</button>
                </div>
                <div class="result-area" id="medicineResult">
                    <!-- Results will be displayed here -->
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Unit Conversion Tool -->
<section class="conversion-tools">
    <div class="container">
        <div class="glass-card conversion-card">
            <h3>ইউনিট রূপান্তরকারী</h3>
            <p>বিভিন্ন ইউনিটের মধ্যে রূপান্তর করুন</p>
            
            <div class="conversion-grid">
                <div class="conversion-item">
                    <h4>দৈর্ঘ্য রূপান্তর</h4>
                    <div class="conversion-form">
                        <input type="number" id="lengthValue" placeholder="মান" step="0.01">
                        <select id="lengthFrom">
                            <option value="meter">মিটার</option>
                            <option value="feet">ফুট</option>
                            <option value="yard">গজ</option>
                        </select>
                        <select id="lengthTo">
                            <option value="meter">মিটার</option>
                            <option value="feet">ফুট</option>
                            <option value="yard">গজ</option>
                        </select>
                        <button onclick="convertLength()">রূপান্তর</button>
                    </div>
                    <div class="conversion-result" id="lengthResult"></div>
                </div>

                <div class="conversion-item">
                    <h4>ওজন রূপান্তর</h4>
                    <div class="conversion-form">
                        <input type="number" id="weightValue" placeholder="মান" step="0.01">
                        <select id="weightFrom">
                            <option value="kg">কেজি</option>
                            <option value="gram">গ্রাম</option>
                            <option value="pound">পাউন্ড</option>
                        </select>
                        <select id="weightTo">
                            <option value="kg">কেজি</option>
                            <option value="gram">গ্রাম</option>
                            <option value="pound">পাউন্ড</option>
                        </select>
                        <button onclick="convertWeight()">রূপান্তর</button>
                    </div>
                    <div class="conversion-result" id="weightResult"></div>
                </div>

                <div class="conversion-item">
                    <h4>আয়তন রূপান্তর</h4>
                    <div class="conversion-form">
                        <input type="number" id="volumeValue" placeholder="মান" step="0.01">
                        <select id="volumeFrom">
                            <option value="liter">লিটার</option>
                            <option value="cubic_meter">কিউবিক মিটার</option>
                            <option value="gallon">গ্যালন</option>
                        </select>
                        <select id="volumeTo">
                            <option value="liter">লিটার</option>
                            <option value="cubic_meter">কিউবিক মিটার</option>
                            <option value="gallon">গ্যালন</option>
                        </select>
                        <button onclick="convertVolume()">রূপান্তর</button>
                    </div>
                    <div class="conversion-result" id="volumeResult"></div>
                </div>

                <div class="conversion-item">
                    <h4>ক্ষেত্রফল রূপান্তর</h4>
                    <div class="conversion-form">
                        <input type="number" id="areaValue" placeholder="মান" step="0.01">
                        <select id="areaFrom">
                            <option value="sq_meter">বর্গ মিটার</option>
                            <option value="sq_feet">বর্গ ফুট</option>
                            <option value="acre">একর</option>
                        </select>
                        <select id="areaTo">
                            <option value="sq_meter">বর্গ মিটার</option>
                            <option value="sq_feet">বর্গ ফুট</option>
                            <option value="acre">একর</option>
                        </select>
                        <button onclick="convertArea()">রূপান্তর</button>
                    </div>
                    <div class="conversion-result" id="areaResult"></div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
.calculator-categories {
    padding: var(--space-8) 0;
    background: var(--bg-primary);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-6);
}

.category-card {
    padding: var(--space-6);
    text-align: center;
    transition: all var(--duration-normal) var(--easing-smooth);
    border: 1px solid var(--color-glass-border);
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-glass);
    border-color: var(--color-primary-500);
}

.category-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto var(--space-4);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-neutral-50);
}

.category-card h3 {
    font-size: 18px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.category-card p {
    font-size: 14px;
    color: var(--color-neutral-600);
    margin-bottom: var(--space-4);
    line-height: var(--line-height-relaxed);
}

.category-features {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: var(--space-2);
    margin-bottom: var(--space-4);
}

.feature {
    padding: 4px 8px;
    background: rgba(0, 188, 212, 0.1);
    color: var(--color-primary-700);
    border-radius: var(--radius-full);
    font-size: 11px;
    font-weight: var(--weight-medium);
}

.btn-select {
    width: 100%;
    padding: var(--space-3);
    background: var(--color-primary-500);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: var(--weight-medium);
    cursor: pointer;
    transition: all var(--duration-fast) var(--easing-default);
}

.btn-select:hover {
    background: var(--color-primary-600);
    transform: translateY(-1px);
}

.calculator-interface {
    padding: var(--space-8) 0;
    background: var(--bg-dashboard);
}

.calculator-card {
    max-width: 900px;
    margin: 0 auto;
}

.calculator-header {
    text-align: center;
    margin-bottom: var(--space-6);
}

.calculator-header h3 {
    font-size: var(--text-sm);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.calculator-header p {
    font-size: 14px;
    color: var(--color-neutral-600);
    margin: 0;
}

.calculator-form {
    display: none;
}

.calculator-form.active {
    display: block;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-4);
    margin-bottom: var(--space-6);
}

.form-group {
    display: grid;
    gap: var(--space-2);
}

.form-group label {
    font-size: 14px;
    font-weight: var(--weight-medium);
    color: var(--color-neutral-700);
}

.form-group input,
.form-group select {
    padding: var(--space-3);
    border: 1px solid var(--color-glass-border);
    border-radius: var(--radius-md);
    background: var(--color-glass-white);
    font-size: 14px;
    color: var(--color-neutral-900);
    font-family: var(--font-primary);
    transition: all var(--duration-fast) var(--easing-default);
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: var(--color-primary-500);
    box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.1);
}

.calculator-actions {
    display: flex;
    gap: var(--space-4);
    justify-content: center;
    margin-bottom: var(--space-6);
}

.btn-calculate,
.btn-reset {
    padding: var(--space-3) var(--space-6);
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: var(--weight-medium);
    border: none;
    cursor: pointer;
    transition: all var(--duration-fast) var(--easing-default);
    min-width: 120px;
}

.btn-calculate {
    background: var(--color-primary-500);
    color: white;
}

.btn-calculate:hover {
    background: var(--color-primary-600);
    transform: translateY(-1px);
}

.btn-reset {
    background: var(--color-glass-white);
    color: var(--color-neutral-700);
    border: 1px solid var(--color-glass-border);
}

.btn-reset:hover {
    background: rgba(255, 255, 255, 0.6);
    border-color: var(--color-primary-300);
}

.result-area {
    background: rgba(255, 255, 255, 0.3);
    border-radius: var(--radius-md);
    padding: var(--space-6);
    border: 1px solid var(--color-glass-border);
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.result-placeholder {
    text-align: center;
    color: var(--color-neutral-500);
    font-style: italic;
}

.result-content {
    width: 100%;
}

.result-header {
    text-align: center;
    margin-bottom: var(--space-4);
}

.result-header h4 {
    font-size: 16px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.result-values {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-4);
    margin-bottom: var(--space-4);
}

.result-item {
    background: rgba(255, 255, 255, 0.3);
    padding: var(--space-3);
    border-radius: var(--radius-md);
    text-align: center;
}

.result-label {
    font-size: 12px;
    color: var(--color-neutral-600);
    margin-bottom: var(--space-1);
}

.result-value {
    font-size: 18px;
    font-weight: var(--weight-bold);
    color: var(--color-primary-700);
}

.result-unit {
    font-size: 12px;
    color: var(--color-neutral-600);
    font-weight: var(--weight-medium);
}

.result-formula {
    background: var(--color-neutral-50);
    padding: var(--space-3);
    border-radius: var(--radius-md);
    border-left: 4px solid var(--color-primary-500);
    margin-top: var(--space-4);
}

.result-formula h5 {
    font-size: 14px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.result-formula p {
    font-size: 13px;
    color: var(--color-neutral-600);
    margin: 0;
    font-family: var(--font-mono);
}

.conversion-tools {
    padding: var(--space-8) 0;
    background: var(--bg-primary);
}

.conversion-card {
    max-width: 1000px;
    margin: 0 auto;
}

.conversion-card h3 {
    font-size: var(--text-sm);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    text-align: center;
    margin-bottom: var(--space-2);
}

.conversion-card p {
    font-size: 14px;
    color: var(--color-neutral-600);
    text-align: center;
    margin-bottom: var(--space-6);
}

.conversion-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-6);
}

.conversion-item {
    background: rgba(255, 255, 255, 0.3);
    padding: var(--space-6);
    border-radius: var(--radius-md);
    border: 1px solid var(--color-glass-border);
}

.conversion-item h4 {
    font-size: 16px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-4);
    text-align: center;
}

.conversion-form {
    display: grid;
    grid-template-columns: 1fr auto auto auto;
    gap: var(--space-2);
    margin-bottom: var(--space-4);
    align-items: center;
}

.conversion-form input {
    padding: var(--space-2);
    border: 1px solid var(--color-glass-border);
    border-radius: var(--radius-sm);
    background: var(--color-glass-white);
    font-size: 14px;
    color: var(--color-neutral-900);
}

.conversion-form select {
    padding: var(--space-2);
    border: 1px solid var(--color-glass-border);
    border-radius: var(--radius-sm);
    background: var(--color-glass-white);
    font-size: 12px;
    color: var(--color-neutral-900);
    min-width: 100px;
}

.conversion-form button {
    padding: var(--space-2) var(--space-3);
    background: var(--color-primary-500);
    color: white;
    border: none;
    border-radius: var(--radius-sm);
    font-size: 12px;
    font-weight: var(--weight-medium);
    cursor: pointer;
    transition: all var(--duration-fast) var(--easing-default);
}

.conversion-form button:hover {
    background: var(--color-primary-600);
}

.conversion-result {
    background: var(--color-neutral-50);
    padding: var(--space-3);
    border-radius: var(--radius-md);
    text-align: center;
    min-height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.conversion-result:empty::before {
    content: "রূপান্তরিত ফলাফল এখানে দেখানো হবে";
    color: var(--color-neutral-500);
    font-style: italic;
}

@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: var(--space-3);
    }
    
    .calculator-actions {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .conversion-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .conversion-form {
        grid-template-columns: 1fr 1fr;
        gap: var(--space-2);
    }
    
    .conversion-form select,
    .conversion-form button {
        grid-column: span 1;
    }
}
</style>

<script>
let currentCalculator = null;

// Calculator selection function
function selectCalculator(type) {
    // Hide all calculator forms
    const calculators = document.querySelectorAll('.calculator-form');
    calculators.forEach(calc => calc.classList.remove('active'));
    
    // Show selected calculator
    const selectedCalculator = document.getElementById(type + 'Calculator');
    if (selectedCalculator) {
        selectedCalculator.classList.add('active');
    }
    
    // Update header
    const titles = {
        pond: 'পুকুর পরিমাপ ক্যালকুলেটর',
        water: 'পানির পরিমাপ ক্যালকুলেটর',
        food: 'খাবারের পরিমাপ ক্যালকুলেটর',
        medicine: 'ওষুধের পরিমাপ ক্যালকুলেটর'
    };
    
    const descriptions = {
        pond: 'পুকুরের দৈর্ঘ্য, প্রস্থ ও গভীরতা দিয়ে আয়তন বের করুন',
        water: 'পুকুরের আয়তন ও পানির পরিমাণ নির্ধারণ করুন',
        food: 'মাছের সংখ্যা ও ওজন অনুযায়ী দৈনিক খাবারের পরিমাণ বের করুন',
        medicine: 'পানির আয়তন ও ওষুধের ঘনত্ব অনুযায়ী প্রয়োজনীয় ওষুধের পরিমাণ বের করুন'
    };
    
    document.getElementById('calculatorTitle').textContent = titles[type];
    document.getElementById('calculatorDescription').textContent = descriptions[type];
    
    // Show calculator interface
    document.getElementById('calculatorInterface').style.display = 'block';
    
    // Scroll to calculator
    document.getElementById('calculatorInterface').scrollIntoView({
        behavior: 'smooth'
    });
    
    currentCalculator = type;
}

// Pond volume calculation
function calculatePondVolume() {
    const length = parseFloat(document.getElementById('pondLength').value);
    const width = parseFloat(document.getElementById('pondWidth').value);
    const depth = parseFloat(document.getElementById('pondDepth').value);
    
    if (length > 0 && width > 0 && depth > 0) {
        const volume = length * width * depth; // cubic meters
        const surfaceArea = length * width; // square meters
        
        const resultHTML = `
            <div class="result-content">
                <div class="result-header">
                    <h4>পুকুর পরিমাপের ফলাফল</h4>
                </div>
                <div class="result-values">
                    <div class="result-item">
                        <div class="result-label">পুকুরের আয়তন</div>
                        <div class="result-value">${volume.toFixed(2)}</div>
                        <div class="result-unit">কিউবিক মিটার</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">পুকুরের ক্ষেত্রফল</div>
                        <div class="result-value">${surfaceArea.toFixed(2)}</div>
                        <div class="result-unit">বর্গ মিটার</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">পানির আয়তন (৮০% ভর্তি)</div>
                        <div class="result-value">${(volume * 0.8).toFixed(2)}</div>
                        <div class="result-unit">কিউবিক মিটার</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">পানির আয়তন (লিটার)</div>
                        <div class="result-value">${(volume * 0.8 * 1000).toFixed(0)}</div>
                        <div class="result-unit">লিটার</div>
                    </div>
                </div>
                <div class="result-formula">
                    <h5>গণনার সূত্র:</h5>
                    <p>আয়তন = দৈর্ঘ্য × প্রস্থ × গভীরতা</p>
                    <p>আয়তন = ${length} × ${width} × ${depth} = ${volume.toFixed(2)} কিউবিক মিটার</p>
                </div>
            </div>
        `;
        
        document.getElementById('pondResult').innerHTML = resultHTML;
    } else {
        alert('অনুগ্রহ করে সকল মান সঠিকভাবে লিখুন।');
    }
}

// Water amount calculation
function calculateWaterAmount() {
    const volume = parseFloat(document.getElementById('pondVolume').value);
    const fillPercentage = parseFloat(document.getElementById('waterFillPercentage').value);
    const conversion = document.getElementById('waterConversion').value;
    
    if (volume > 0 && fillPercentage > 0) {
        const actualVolume = volume * (fillPercentage / 100);
        let result, unit;
        
        switch (conversion) {
            case 'cubic_meter_to_liter':
                result = actualVolume * 1000;
                unit = 'লিটার';
                break;
            case 'cubic_meter_to_gallon':
                result = actualVolume * 264.172;
                unit = 'গ্যালন (US)';
                break;
            case 'liter_to_cubic_meter':
                result = actualVolume / 1000;
                unit = 'কিউবিক মিটার';
                break;
            case 'gallon_to_cubic_meter':
                result = actualVolume / 264.172;
                unit = 'কিউবিক মিটার';
                break;
        }
        
        const resultHTML = `
            <div class="result-content">
                <div class="result-header">
                    <h4>পানির পরিমাপের ফলাফল</h4>
                </div>
                <div class="result-values">
                    <div class="result-item">
                        <div class="result-label">মূল আয়তন</div>
                        <div class="result-value">${volume.toFixed(2)}</div>
                        <div class="result-unit">কিউবিক মিটার</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">পূর্ণতার শতাংশ</div>
                        <div class="result-value">${fillPercentage}</div>
                        <div class="result-unit">%</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">প্রকৃত পানির পরিমাণ</div>
                        <div class="result-value">${actualVolume.toFixed(2)}</div>
                        <div class="result-unit">কিউবিক মিটার</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">রূপান্তরিত পরিমাণ</div>
                        <div class="result-value">${result.toFixed(2)}</div>
                        <div class="result-unit">${unit}</div>
                    </div>
                </div>
                <div class="result-formula">
                    <h5>গণনার সূত্র:</h5>
                    <p>প্রকৃত পরিমাণ = মূল আয়তন × (পূর্ণতার শতাংশ ÷ ১০০)</p>
                    <p>প্রকৃত পরিমাণ = ${volume} × (${fillPercentage} ÷ ১০০) = ${actualVolume.toFixed(2)} কিউবিক মিটার</p>
                </div>
            </div>
        `;
        
        document.getElementById('waterResult').innerHTML = resultHTML;
    } else {
        alert('অনুগ্রহ করে সকল মান সঠিকভাবে লিখুন।');
    }
}

// Food amount calculation
function calculateFoodAmount() {
    const fishCount = parseInt(document.getElementById('fishCount').value);
    const averageWeight = parseFloat(document.getElementById('averageWeight').value);
    const feedPercentage = parseFloat(document.getElementById('feedPercentage').value);
    const feedTimes = parseInt(document.getElementById('feedTimes').value);
    
    if (fishCount > 0 && averageWeight > 0) {
        const totalWeight = fishCount * averageWeight;
        const dailyFeed = totalWeight * (feedPercentage / 100);
        const perFeedingAmount = dailyFeed / feedTimes;
        const weeklyFeed = dailyFeed * 7;
        const monthlyFeed = dailyFeed * 30;
        
        const resultHTML = `
            <div class="result-content">
                <div class="result-header">
                    <h4>খাবারের পরিমাপের ফলাফল</h4>
                </div>
                <div class="result-values">
                    <div class="result-item">
                        <div class="result-label">মাছের মোট ওজন</div>
                        <div class="result-value">${totalWeight.toFixed(2)}</div>
                        <div class="result-unit">কেজি</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">দৈনিক খাবার</div>
                        <div class="result-value">${dailyFeed.toFixed(2)}</div>
                        <div class="result-unit">কেজি</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">প্রতি বার খাবার</div>
                        <div class="result-value">${perFeedingAmount.toFixed(2)}</div>
                        <div class="result-unit">কেজি</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">সাপ্তাহিক খাবার</div>
                        <div class="result-value">${weeklyFeed.toFixed(2)}</div>
                        <div class="result-unit">কেজি</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">মাসিক খাবার</div>
                        <div class="result-value">${monthlyFeed.toFixed(1)}</div>
                        <div class="result-unit">কেজি</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">খাওয়ানোর সংখ্যা</div>
                        <div class="result-value">${feedTimes}</div>
                        <div class="result-unit">বার/দিন</div>
                    </div>
                </div>
                <div class="result-formula">
                    <h5>গণনার সূত্র:</h5>
                    <p>দৈনিক খাবার = মাছের মোট ওজন × (খাবারের হার ÷ ১০০)</p>
                    <p>দৈনিক খাবার = ${totalWeight.toFixed(2)} × (${feedPercentage} ÷ ১০০) = ${dailyFeed.toFixed(2)} কেজি</p>
                    <p>প্রতি বার খাবার = ${dailyFeed.toFixed(2)} ÷ ${feedTimes} = ${perFeedingAmount.toFixed(2)} কেজি</p>
                </div>
            </div>
        `;
        
        document.getElementById('foodResult').innerHTML = resultHTML;
    } else {
        alert('অনুগ্রহ করে সকল মান সঠিকভাবে লিখুন।');
    }
}

// Medicine amount calculation
function calculateMedicineAmount() {
    const waterVolume = parseFloat(document.getElementById('medicineWaterVolume').value);
    const concentration = parseFloat(document.getElementById('medicineConcentration').value);
    const treatmentDays = parseInt(document.getElementById('treatmentDays').value);
    const medicineType = document.getElementById('medicineType').value;
    
    if (waterVolume > 0 && concentration > 0 && treatmentDays > 0) {
        const totalMedicine = waterVolume * concentration / 1000; // Convert mg to grams
        const totalForTreatment = totalMedicine * treatmentDays;
        const medicineNames = {
            antibiotic: 'অ্যান্টিবায়োটিক',
            antiparasitic: 'অ্যান্টিপারাসিটিক',
            antifungal: 'অ্যান্টিফাঙ্গাল',
            vitamin: 'ভিটামিন'
        };
        
        const resultHTML = `
            <div class="result-content">
                <div class="result-header">
                    <h4>ওষুধের পরিমাপের ফলাফল</h4>
                </div>
                <div class="result-values">
                    <div class="result-item">
                        <div class="result-label">পানির আয়তন</div>
                        <div class="result-value">${waterVolume.toFixed(0)}</div>
                        <div class="result-unit">লিটার</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">ওষুধের ঘনত্ব</div>
                        <div class="result-value">${concentration}</div>
                        <div class="result-unit">mg/লিটার</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">দৈনিক ওষুধ</div>
                        <div class="result-value">${totalMedicine.toFixed(2)}</div>
                        <div class="result-unit">গ্রাম</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">মোট চিকিৎসার ওষুধ</div>
                        <div class="result-value">${totalForTreatment.toFixed(2)}</div>
                        <div class="result-unit">গ্রাম</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">চিকিৎসার দিন</div>
                        <div class="result-value">${treatmentDays}</div>
                        <div class="result-unit">দিন</div>
                    </div>
                    <div class="result-item">
                        <div class="result-label">ওষুধের ধরন</div>
                        <div class="result-value">${medicineNames[medicineType]}</div>
                        <div class="result-unit"></div>
                    </div>
                </div>
                <div class="result-formula">
                    <h5>গণনার সূত্র:</h5>
                    <p>দৈনিক ওষুধ = (পানির আয়তন × ঘনত্ব) ÷ ১০০০</p>
                    <p>দৈনিক ওষুধ = (${waterVolume} × ${concentration}) ÷ ১০০০ = ${totalMedicine.toFixed(2)} গ্রাম</p>
                    <p>মোট চিকিৎসার ওষুধ = ${totalMedicine.toFixed(2)} × ${treatmentDays} = ${totalForTreatment.toFixed(2)} গ্রাম</p>
                </div>
            </div>
        `;
        
        document.getElementById('medicineResult').innerHTML = resultHTML;
    } else {
        alert('অনুগ্রহ করে সকল মান সঠিকভাবে লিখুন।');
    }
}

// Reset functions
function resetPondCalculator() {
    document.getElementById('pondLength').value = '';
    document.getElementById('pondWidth').value = '';
    document.getElementById('pondDepth').value = '';
    document.getElementById('pondResult').innerHTML = '<div class="result-placeholder">গণনার ফলাফল এখানে দেখানো হবে</div>';
}

function resetWaterCalculator() {
    document.getElementById('pondVolume').value = '';
    document.getElementById('waterFillPercentage').value = '80';
    document.getElementById('waterResult').innerHTML = '<div class="result-placeholder">গণনার ফলাফল এখানে দেখানো হবে</div>';
}

function resetFoodCalculator() {
    document.getElementById('fishCount').value = '';
    document.getElementById('averageWeight').value = '';
    document.getElementById('feedPercentage').value = '2';
    document.getElementById('feedTimes').value = '2';
    document.getElementById('foodResult').innerHTML = '<div class="result-placeholder">গণনার ফলাফল এখানে দেখানো হবে</div>';
}

function resetMedicineCalculator() {
    document.getElementById('medicineWaterVolume').value = '';
    document.getElementById('medicineConcentration').value = '2';
    document.getElementById('treatmentDays').value = '3';
    document.getElementById('medicineType').value = 'antibiotic';
    document.getElementById('medicineResult').innerHTML = '<div class="result-placeholder">গণনার ফলাফল এখানে দেখানো হবে</div>';
}

// Conversion functions
function convertLength() {
    const value = parseFloat(document.getElementById('lengthValue').value);
    const from = document.getElementById('lengthFrom').value;
    const to = document.getElementById('lengthTo').value;
    
    if (!value) {
        alert('অনুগ্রহ করে একটি মান লিখুন।');
        return;
    }
    
    let result;
    const conversions = {
        'meter_to_feet': 3.28084,
        'meter_to_yard': 1.09361,
        'feet_to_meter': 0.3048,
        'feet_to_yard': 0.333333,
        'yard_to_meter': 0.9144,
        'yard_to_feet': 3
    };
    
    const key = `${from}_to_${to}`;
    if (key === 'meter_to_meter' || key === 'feet_to_feet' || key === 'yard_to_yard') {
        result = value;
    } else if (conversions[key]) {
        result = value * conversions[key];
    } else {
        // Convert to meter first, then to target
        let meterValue;
        if (from === 'meter') meterValue = value;
        else if (from === 'feet') meterValue = value * 0.3048;
        else if (from === 'yard') meterValue = value * 0.9144;
        
        if (to === 'meter') result = meterValue;
        else if (to === 'feet') result = meterValue * 3.28084;
        else if (to === 'yard') result = meterValue * 1.09361;
    }
    
    document.getElementById('lengthResult').innerHTML = `
        <strong>${value} ${getUnitName(from)} = ${result.toFixed(4)} ${getUnitName(to)}</strong>
    `;
}

function convertWeight() {
    const value = parseFloat(document.getElementById('weightValue').value);
    const from = document.getElementById('weightFrom').value;
    const to = document.getElementById('weightTo').value;
    
    if (!value) {
        alert('অনুগ্রহ করে একটি মান লিখুন।');
        return;
    }
    
    let result;
    const conversions = {
        'kg_to_gram': 1000,
        'kg_to_pound': 2.20462,
        'gram_to_kg': 0.001,
        'gram_to_pound': 0.00220462,
        'pound_to_kg': 0.453592,
        'pound_to_gram': 453.592
    };
    
    const key = `${from}_to_${to}`;
    if (key === 'kg_to_kg' || key === 'gram_to_gram' || key === 'pound_to_pound') {
        result = value;
    } else if (conversions[key]) {
        result = value * conversions[key];
    }
    
    document.getElementById('weightResult').innerHTML = `
        <strong>${value} ${getUnitName(from)} = ${result.toFixed(4)} ${getUnitName(to)}</strong>
    `;
}

function convertVolume() {
    const value = parseFloat(document.getElementById('volumeValue').value);
    const from = document.getElementById('volumeFrom').value;
    const to = document.getElementById('volumeTo').value;
    
    if (!value) {
        alert('অনুগ্রহ করে একটি মান লিখুন।');
        return;
    }
    
    let result;
    const conversions = {
        'liter_to_cubic_meter': 0.001,
        'liter_to_gallon': 0.264172,
        'cubic_meter_to_liter': 1000,
        'cubic_meter_to_gallon': 264.172,
        'gallon_to_liter': 3.78541,
        'gallon_to_cubic_meter': 0.00378541
    };
    
    const key = `${from}_to_${to}`;
    if (key === 'liter_to_liter' || key === 'cubic_meter_to_cubic_meter' || key === 'gallon_to_gallon') {
        result = value;
    } else if (conversions[key]) {
        result = value * conversions[key];
    }
    
    document.getElementById('volumeResult').innerHTML = `
        <strong>${value} ${getUnitName(from)} = ${result.toFixed(4)} ${getUnitName(to)}</strong>
    `;
}

function convertArea() {
    const value = parseFloat(document.getElementById('areaValue').value);
    const from = document.getElementById('areaFrom').value;
    const to = document.getElementById('areaTo').value;
    
    if (!value) {
        alert('অনুগ্রহ করে একটি মান লিখুন।');
        return;
    }
    
    let result;
    const conversions = {
        'sq_meter_to_sq_feet': 10.7639,
        'sq_meter_to_acre': 0.000247105,
        'sq_feet_to_sq_meter': 0.092903,
        'sq_feet_to_acre': 0.0000229568,
        'acre_to_sq_meter': 4046.86,
        'acre_to_sq_feet': 43560
    };
    
    const key = `${from}_to_${to}`;
    if (key === 'sq_meter_to_sq_meter' || key === 'sq_feet_to_sq_feet' || key === 'acre_to_acre') {
        result = value;
    } else if (conversions[key]) {
        result = value * conversions[key];
    }
    
    document.getElementById('areaResult').innerHTML = `
        <strong>${value} ${getUnitName(from)} = ${result.toFixed(4)} ${getUnitName(to)}</strong>
    `;
}

function getUnitName(unit) {
    const names = {
        'meter': 'মিটার',
        'feet': 'ফুট',
        'yard': 'গজ',
        'kg': 'কেজি',
        'gram': 'গ্রাম',
        'pound': 'পাউন্ড',
        'liter': 'লিটার',
        'cubic_meter': 'কিউবিক মিটার',
        'gallon': 'গ্যালন',
        'sq_meter': 'বর্গ মিটার',
        'sq_feet': 'বর্গ ফুট',
        'acre': 'একর'
    };
    return names[unit] || unit;
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Show default calculator (pond)
    selectCalculator('pond');
});
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>