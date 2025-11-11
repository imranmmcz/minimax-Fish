<?php
$pageTitle = "প্রজাতির তথ্য";
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="header-content">
            <div class="header-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <path d="M32 12C24 12 18 18 18 26C18 34 24 42 32 42C40 42 46 34 46 26C46 18 40 12 32 12Z" fill="url(#fishGradient)"/>
                    <path d="M46 22L58 16L58 36L46 30Z" fill="url(#fishGradient)"/>
                    <path d="M32 22L28 26L32 30L36 26Z" fill="white"/>
                    <path d="M20 26L24 22L24 30L20 26Z" fill="white" opacity="0.7"/>
                    <defs>
                        <linearGradient id="fishGradient" x1="0" y1="0" x2="64" y2="64">
                            <stop offset="0%" style="stop-color:#00BCD4"/>
                            <stop offset="100%" style="stop-color:#4CAF50"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="header-text">
                <h1>প্রজাতির তথ্য</h1>
                <p>বিভিন্ন মাছের প্রজাতির বিস্তারিত তথ্য, চাষ পদ্ধতি ও খাবারের অভ্যাস</p>
            </div>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="search-filter-section">
    <div class="container">
        <div class="glass-card search-card">
            <div class="search-filter-grid">
                <div class="search-box">
                    <div class="search-input-wrapper">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.5 12H12.71L12.43 11.73C13.41 10.59 14 9.11 14 7.5C14 4.46 11.54 2 8.5 2C5.46 2 3 4.46 3 7.5C3 10.54 5.46 13 8.5 13C10.11 13 11.59 12.41 12.73 11.43L13 11.71V12.5L16 15.5L17.5 14L13.5 10V12ZM8.5 11C6.57 11 5 9.43 5 7.5C5 5.57 6.57 4 8.5 4C10.43 4 12 5.57 12 7.5C12 9.43 10.43 11 8.5 11Z"/>
                        </svg>
                        <input type="text" id="speciesSearch" placeholder="মাছের প্রজাতি খুঁজুন...">
                    </div>
                </div>
                <div class="filter-box">
                    <select id="environmentFilter" class="filter-select">
                        <option value="">সব পরিবেশ</option>
                        <option value="মিঠা পানি">মিঠা পানি</option>
                        <option value="সামুদ্রিক">সামুদ্রিক</option>
                        <option value="ম্যানগ্রোভ">ম্যানগ্রোভ</option>
                    </select>
                </div>
                <div class="filter-box">
                    <select id="dietFilter" class="filter-select">
                        <option value="">সব ধরনের খাবার</option>
                        <option value="শাকাদি">শাকাদি</option>
                        <option value="মাংসাশী">মাংসাশী</option>
                        <option value="সর্বভোজী">সর্বভোজী</option>
                        <option value="তৃণভোজী">তৃণভোজী</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Species List Section -->
<section class="species-list-section">
    <div class="container">
        <div class="species-grid" id="speciesContainer">
            
            <!-- প্রজাতি ১: রুই -->
            <div class="species-card glass-card" data-name="রুই rohu catla carp" data-environment="মিঠা পানি" data-diet="শাকাদি">
                <div class="species-image">
                    <svg width="200" height="120" viewBox="0 0 200 120" fill="none">
                        <!-- রুই মাছের ছবি -->
                        <ellipse cx="100" cy="60" rx="60" ry="25" fill="url(#rohuGradient)" opacity="0.8"/>
                        <path d="M160 50L190 40L190 80L160 70Z" fill="url(#rohuGradient)" opacity="0.6"/>
                        <circle cx="130" cy="55" r="3" fill="white"/>
                        <ellipse cx="100" cy="60" rx="40" ry="15" fill="rgba(255,255,255,0.3)"/>
                        <defs>
                            <linearGradient id="rohuGradient" x1="0" y1="0" x2="200" y2="120">
                                <stop offset="0%" style="stop-color:#B2EBF2"/>
                                <stop offset="100%" style="stop-color:#00BCD4"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="species-header">
                    <h3>রুই (Rohu)</h3>
                    <div class="species-tags">
                        <span class="tag environment-freshwater">মিঠা পানি</span>
                        <span class="tag diet-herbivore">শাকাদি</span>
                    </div>
                </div>
                <div class="species-content">
                    <div class="basic-info">
                        <h4>মৌলিক তথ্য:</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">বৈজ্ঞানিক নাম:</span>
                                <span class="value">Labeo rohita</span>
                            </div>
                            <div class="info-item">
                                <span class="label">সর্বোচ্চ ওজন:</span>
                                <span class="value">৪৫ কেজি</span>
                            </div>
                            <div class="info-item">
                                <span class="label">আয়ু:</span>
                                <span class="value">৮-১২ বছর</span>
                            </div>
                            <div class="info-item">
                                <span class="label">স্বাদ:</span>
                                <span class="value">খুবই সুস্বাদু</span>
                            </div>
                        </div>
                    </div>
                    <div class="farming-method">
                        <h4>চাষ পদ্ধতি:</h4>
                        <ul>
                            <li>পুকুরের আয়তন: ০.৫-২ হেক্টর</li>
                            <li>পানির গভীরতা: ১.৫-২.৫ মিটার</li>
                            <li>বীজের পরিমাণ: ৮,০০০-১০,০০০/হেক্টর</li>
                            <li>প্রজনন মৌসুম: জুন-আগস্ট</li>
                            <li>পরিচর্যা: নিয়মিত খাবার দেওয়া ও পানি পরিবর্তন</li>
                        </ul>
                    </div>
                    <div class="feeding-habits">
                        <h4>খাবারের অভ্যাস:</h4>
                        <ul>
                            <li>প্রাকৃতিক খাবার: প্ল্যাঙ্কটন, শ্যাওলা</li>
                            <li>কৃত্রিম খাবার: চালের ভুসি, গমের ভুসি</li>
                            <li>খাবারের পরিমাণ: শরীরের ওজনের ২-৩%</li>
                            <li>খাওয়ার সময়: সকাল ও সন্ধ্যা</li>
                        </ul>
                    </div>
                    <div class="market-value">
                        <h4>বাজার দর:</h4>
                        <div class="price-grid">
                            <div class="price-item">
                                <span class="price-label">ছোট (২-৩ কেজি):</span>
                                <span class="price-value">৩৫০-৪০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">মধ্যম (৩-৫ কেজি):</span>
                                <span class="price-value">৪০০-৪৫০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">বড় (৫+ কেজি):</span>
                                <span class="price-value">৪৫০-৫০০ টাকা/কেজি</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- প্রজাতি ২: কাতলা -->
            <div class="species-card glass-card" data-name="কাতলা catla carp" data-environment="মিঠা পানি" data-diet="সর্বভোজী">
                <div class="species-image">
                    <svg width="200" height="120" viewBox="0 0 200 120" fill="none">
                        <!-- কাতলা মাছের ছবি -->
                        <ellipse cx="90" cy="60" rx="70" ry="30" fill="url(#catlaGradient)" opacity="0.8"/>
                        <path d="M160 50L190 45L190 75L160 70Z" fill="url(#catlaGradient)" opacity="0.6"/>
                        <circle cx="120" cy="55" r="3" fill="white"/>
                        <ellipse cx="90" cy="60" rx="50" ry="18" fill="rgba(255,255,255,0.2)"/>
                        <path d="M70 45L60 35L60 75L70 85L80 75L80 45Z" fill="url(#catlaGradient)"/>
                        <defs>
                            <linearGradient id="catlaGradient" x1="0" y1="0" x2="200" y2="120">
                                <stop offset="0%" style="stop-color:#E8F5E9"/>
                                <stop offset="100%" style="stop-color:#4CAF50"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="species-header">
                    <h3>কাতলা (Catla)</h3>
                    <div class="species-tags">
                        <span class="tag environment-freshwater">মিঠা পানি</span>
                        <span class="tag diet-omnivore">সর্বভোজী</span>
                    </div>
                </div>
                <div class="species-content">
                    <div class="basic-info">
                        <h4>মৌলিক তথ্য:</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">বৈজ্ঞানিক নাম:</span>
                                <span class="value">Catla catla</span>
                            </div>
                            <div class="info-item">
                                <span class="label">সর্বোচ্চ ওজন:</span>
                                <span class="value">৫০ কেজি</span>
                            </div>
                            <div class="info-item">
                                <span class="label">আয়ু:</span>
                                <span class="value">১০-১৫ বছর</span>
                            </div>
                            <div class="info-item">
                                <span class="label">স্বাদ:</span>
                                <span class="value">অত্যন্ত সুস্বাদু</span>
                            </div>
                        </div>
                    </div>
                    <div class="farming-method">
                        <h4>চাষ পদ্ধতি:</h4>
                        <ul>
                            <li>পুকুরের আয়তন: ১-৫ হেক্টর</li>
                            <li>পানির গভীরতা: ২-৩ মিটার</li>
                            <li>বীজের পরিমাণ: ১,০০০-১,৫০০/হেক্টর</li>
                            <li>প্রজনন মৌসুম: মে-জুলাই</li>
                            <li>বিশেষত্ব: পানির উপরের স্তরে থাকে</li>
                        </ul>
                    </div>
                    <div class="feeding-habits">
                        <h4>খাবারের অভ্যাস:</h4>
                        <ul>
                            <li>প্রাকৃতিক খাবার: পানির উপরের প্ল্যাঙ্কটন</li>
                            <li>কৃত্রিম খাবার: মাছের খাবার, চালের ভুসি</li>
                            <li>খাবারের পরিমাণ: শরীরের ওজনের ১.৫-২%</li>
                            <li>খাওয়ার সময়: দিনের বেলা</li>
                        </ul>
                    </div>
                    <div class="market-value">
                        <h4>বাজার দর:</h4>
                        <div class="price-grid">
                            <div class="price-item">
                                <span class="price-label">ছোট (২-৩ কেজি):</span>
                                <span class="price-value">৪০০-৪৫০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">মধ্যম (৩-৬ কেজি):</span>
                                <span class="price-value">৪৫০-৫০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">বড় (৬+ কেজি):</span>
                                <span class="price-value">৫০০-৫৫০ টাকা/কেজি</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- প্রজাতি ৩: পাঙ্গাশ -->
            <div class="species-card glass-card" data-name="পাঙ্গাশ pangasius catfish" data-environment="মিঠা পানি" data-diet="মাংসাশী">
                <div class="species-image">
                    <svg width="200" height="120" viewBox="0 0 200 120" fill="none">
                        <!-- পাঙ্গাশ মাছের ছবি -->
                        <ellipse cx="95" cy="60" rx="65" ry="25" fill="url(#pangasiusGradient)" opacity="0.8"/>
                        <path d="M160 55L185 50L185 70L160 65Z" fill="url(#pangasiusGradient)" opacity="0.6"/>
                        <path d="M80 50L70 55L70 65L80 70L90 65L90 50Z" fill="url(#pangasiusGradient)"/>
                        <circle cx="125" cy="58" r="3" fill="white"/>
                        <ellipse cx="95" cy="60" rx="45" ry="15" fill="rgba(255,255,255,0.3)"/>
                        <path d="M40 60L30 50L30 70L40 60Z" fill="url(#pangasiusGradient)" opacity="0.4"/>
                        <defs>
                            <linearGradient id="pangasiusGradient" x1="0" y1="0" x2="200" y2="120">
                                <stop offset="0%" style="stop-color:#B3E5FC"/>
                                <stop offset="100%" style="stop-color:#0288D1"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="species-header">
                    <h3>পাঙ্গাশ (Pangasius)</h3>
                    <div class="species-tags">
                        <span class="tag environment-freshwater">মিঠা পানি</span>
                        <span class="tag diet-carnivore">মাংসাশী</span>
                    </div>
                </div>
                <div class="species-content">
                    <div class="basic-info">
                        <h4>মৌলিক তথ্য:</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">বৈজ্ঞানিক নাম:</span>
                                <span class="value">Pangasianodon hypophthalmus</span>
                            </div>
                            <div class="info-item">
                                <span class="label">সর্বোচ্চ ওজন:</span>
                                <span class="value">৩০ কেজি</span>
                            </div>
                            <div class="info-item">
                                <span class="label">আয়ু:</span>
                                <span class="value">৬-৮ বছর</span>
                            </div>
                            <div class="info-item">
                                <span class="label">স্বাদ:</span>
                                <span class="value">মধ্যম</span>
                            </div>
                        </div>
                    </div>
                    <div class="farming-method">
                        <h4>চাষ পদ্ধতি:</h4>
                        <ul>
                            <li>পুকুরের আয়তন: ০.২-১ হেক্টর</li>
                            <li>পানির গভীরতা: ১-১.৫ মিটার</li>
                            <li>বীজের পরিমাণ: ২০,০০০-৩০,০০০/হেক্টর</li>
                            <li>প্রজনন মৌসুম: বছরজুড়ে</li>
                            <li>বিশেষত্ব: উচ্চ ঘনত্বে চাষ সম্ভব</li>
                        </ul>
                    </div>
                    <div class="feeding-habits">
                        <h4>খাবারের অভ্যাস:</h4>
                        <ul>
                            <li>প্রাকৃতিক খাবার: ছোট মাছ, পোকামাকড়</li>
                            <li>কৃত্রিম খাবার: মাছের খাবার, চিকেন ফিড</li>
                            <li>খাবারের পরিমাণ: শরীরের ওজনের ৩-৫%</li>
                            <li>খাওয়ার সময়: সকাল ও সন্ধ্যা</li>
                        </ul>
                    </div>
                    <div class="market-value">
                        <h4>বাজার দর:</h4>
                        <div class="price-grid">
                            <div class="price-item">
                                <span class="price-label">ছোট (১-২ কেজি):</span>
                                <span class="price-value">২৫০-৩০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">মধ্যম (২-৪ কেজি):</span>
                                <span class="price-value">৩০০-৩৫০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">বড় (৪+ কেজি):</span>
                                <span class="price-value">৩৫০-৪০০ টাকা/কেজি</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- প্রজাতি ৪: তেলাপিয়া -->
            <div class="species-card glass-card" data-name="তেলাপিয়া tilapia aquaculture" data-environment="মিঠা পানি" data-diet="তৃণভোজী">
                <div class="species-image">
                    <svg width="200" height="120" viewBox="0 0 200 120" fill="none">
                        <!-- তেলাপিয়া মাছের ছবি -->
                        <ellipse cx="100" cy="60" rx="55" ry="22" fill="url(#tilapiaGradient)" opacity="0.8"/>
                        <path d="M155 52L185 47L185 73L155 68Z" fill="url(#tilapiaGradient)" opacity="0.6"/>
                        <circle cx="125" cy="58" r="3" fill="white"/>
                        <ellipse cx="100" cy="60" rx="35" ry="12" fill="rgba(255,255,255,0.4)"/>
                        <path d="M45 50L35 55L35 65L45 70L55 65L55 50Z" fill="url(#tilapiaGradient)" opacity="0.5"/>
                        <defs>
                            <linearGradient id="tilapiaGradient" x1="0" y1="0" x2="200" y2="120">
                                <stop offset="0%" style="stop-color:#FFF3E0"/>
                                <stop offset="100%" style="stop-color:#FF9800"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="species-header">
                    <h3>তেলাপিয়া (Tilapia)</h3>
                    <div class="species-tags">
                        <span class="tag environment-freshwater">মিঠা পানি</span>
                        <span class="tag diet-herbivore">তৃণভোজী</span>
                    </div>
                </div>
                <div class="species-content">
                    <div class="basic-info">
                        <h4>মৌলিক তথ্য:</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">বৈজ্ঞানিক নাম:</span>
                                <span class="value">Oreochromis niloticus</span>
                            </div>
                            <div class="info-item">
                                <span class="label">সর্বোচ্চ ওজন:</span>
                                <span class="value">২ কেজি</span>
                            </div>
                            <div class="info-item">
                                <span class="label">আয়ু:</span>
                                <span class="value">৪-৬ বছর</span>
                            </div>
                            <div class="info-item">
                                <span class="label">স্বাদ:</span>
                                <span class="value">মিষ্টি</span>
                            </div>
                        </div>
                    </div>
                    <div class="farming-method">
                        <h4>চাষ পদ্ধতি:</h4>
                        <ul>
                            <li>পুকুরের আয়তন: ০.১-০.৫ হেক্টর</li>
                            <li>পানির গভীরতা: ১-২ মিটার</li>
                            <li>বীজের পরিমাণ: ৩,০০০-৫,০০০/হেক্টর</li>
                            <li>প্রজনন মৌসুম: বছরজুড়ে</li>
                            <li>বিশেষত্ব: দ্রুত বৃদ্ধি ও উচ্চ প্রজনন</li>
                        </ul>
                    </div>
                    <div class="feeding-habits">
                        <h4>খাবারের অভ্যাস:</h4>
                        <ul>
                            <li>প্রাকৃতিক খাবার: শ্যাওলা, প্ল্যাঙ্কটন</li>
                            <li>কৃত্রিম খাবার: ভুসি, তেলাপিয়া ফিড</li>
                            <li>খাবারের পরিমাণ: শরীরের ওজনের ২-৪%</li>
                            <li>খাওয়ার সময়: সারাদিন</li>
                        </ul>
                    </div>
                    <div class="market-value">
                        <h4>বাজার দর:</h4>
                        <div class="price-grid">
                            <div class="price-item">
                                <span class="price-label">ছোট (০.৫-১ কেজি):</span>
                                <span class="price-value">৩০০-৩৫০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">মধ্যম (১-১.৫ কেজি):</span>
                                <span class="price-value">৩৫০-৪০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">বড় (১.৫+ কেজি):</span>
                                <span class="price-value">৪০০-৪৫০ টাকা/কেজি</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- প্রজাতি ৫: ইলিশ -->
            <div class="species-card glass-card" data-name="ইলিশ hilsa river fish" data-environment="সামুদ্রিক" data-diet="মাংসাশী">
                <div class="species-image">
                    <svg width="200" height="120" viewBox="0 0 200 120" fill="none">
                        <!-- ইলিশ মাছের ছবি -->
                        <ellipse cx="90" cy="60" rx="70" ry="18" fill="url(#hilsaGradient)" opacity="0.8"/>
                        <path d="M160 50L195 45L195 75L160 70Z" fill="url(#hilsaGradient)" opacity="0.6"/>
                        <circle cx="120" cy="58" r="2" fill="white"/>
                        <ellipse cx="90" cy="60" rx="50" ry="10" fill="rgba(255,255,255,0.5)"/>
                        <path d="M35 55L25 50L25 70L35 75L45 70L45 55Z" fill="url(#hilsaGradient)"/>
                        <defs>
                            <linearGradient id="hilsaGradient" x1="0" y1="0" x2="200" y2="120">
                                <stop offset="0%" style="stop-color:#F3E5F5"/>
                                <stop offset="100%" style="stop-color:#9C27B0"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="species-header">
                    <h3>ইলিশ (Hilsa)</h3>
                    <div class="species-tags">
                        <span class="tag environment-marine">সামুদ্রিক</span>
                        <span class="tag diet-carnivore">মাংসাশী</span>
                    </div>
                </div>
                <div class="species-content">
                    <div class="basic-info">
                        <h4>মৌলিক তথ্য:</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">বৈজ্ঞানিক নাম:</span>
                                <span class="value">Tenualosa ilisha</span>
                            </div>
                            <div class="info-item">
                                <span class="label">সর্বোচ্চ ওজন:</span>
                                <span class="value">২.৫ কেজি</span>
                            </div>
                            <div class="info-item">
                                <span class="label">আয়ু:</span>
                                <span class="value">৫-৭ বছর</span>
                            </div>
                            <div class="info-item">
                                <span class="label">স্বাদ:</span>
                                <span class="value">অতুলনীয়</span>
                            </div>
                        </div>
                    </div>
                    <div class="farming-method">
                        <h4>চাষ পদ্ধতি:</h4>
                        <ul>
                            <li>বায়ো-ফ্লক প্রযুক্তি প্রয়োজন</li>
                            <li>পানির লবণাক্ততা: ৫-২০ ppt</li>
                            <li>বীজের পরিমাণ: ২-৩ টন/হেক্টর</li>
                            <li>প্রজনন মৌসুম: জুন-অক্টোবর</li>
                            <li>বিশেষত্ব: অত্যন্ত দুষ্প্রজ</li>
                        </ul>
                    </div>
                    <div class="feeding-habits">
                        <h4>খাবারের অভ্যাস:</h4>
                        <ul>
                            <li>প্রাকৃতিক খাবার: ছোট মাছ, শেলফিশ</li>
                            <li>কৃত্রিম খাবার: উচ্চ প্রোটিন ফিড</li>
                            <li>খাবারের পরিমাণ: শরীরের ওজনের ৪-৬%</li>
                            <li>খাওয়ার সময়: সকাল ও সন্ধ্যা</li>
                        </ul>
                    </div>
                    <div class="market-value">
                        <h4>বাজার দর:</h4>
                        <div class="price-grid">
                            <div class="price-item">
                                <span class="price-label">ছোট (০.৫-১ কেজি):</span>
                                <span class="price-value">৮০০-১০০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">মধ্যম (১-২ কেজি):</span>
                                <span class="price-value">১০০০-১২০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">বড় (২+ কেজি):</span>
                                <span class="price-value">১২০০-১৫০০ টাকা/কেজি</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- প্রজাতি ৬: বাগদাশাক -->
            <div class="species-card glass-card" data-name="বাগদাশাক bagda prawn shrimp" data-environment="সামুদ্রিক" data-diet="মাংসাশী">
                <div class="species-image">
                    <svg width="200" height="120" viewBox="0 0 200 120" fill="none">
                        <!-- বাগদাশাক চিংড়ির ছবি -->
                        <ellipse cx="100" cy="60" rx="60" ry="20" fill="url(#prawnGradient)" opacity="0.8"/>
                        <circle cx="125" cy="58" r="3" fill="white"/>
                        <ellipse cx="100" cy="60" rx="40" ry="12" fill="rgba(255,255,255,0.3)"/>
                        <path d="M50 55L40 60L40 65L50 70L60 65L60 55Z" fill="url(#prawnGradient)"/>
                        <path d="M150 55L160 50L160 70L150 75L140 70L140 55Z" fill="url(#prawnGradient)"/>
                        <circle cx="75" cy="62" r="1" fill="white"/>
                        <circle cx="85" cy="65" r="1" fill="white"/>
                        <circle cx="115" cy="65" r="1" fill="white"/>
                        <circle cx="125" cy="62" r="1" fill="white"/>
                        <defs>
                            <linearGradient id="prawnGradient" x1="0" y1="0" x2="200" y2="120">
                                <stop offset="0%" style="stop-color:#E0F2F1"/>
                                <stop offset="100%" style="stop-color:#4DB6AC"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="species-header">
                    <h3>বাগদাশাক (Prawn)</h3>
                    <div class="species-tags">
                        <span class="tag environment-marine">সামুদ্রিক</span>
                        <span class="tag diet-carnivore">মাংসাশী</span>
                    </div>
                </div>
                <div class="species-content">
                    <div class="basic-info">
                        <h4>মৌলিক তথ্য:</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">বৈজ্ঞানিক নাম:</span>
                                <span class="value">Penaeus monodon</span>
                            </div>
                            <div class="info-item">
                                <span class="label">সর্বোচ্চ ওজন:</span>
                                <span class="value">১০০ গ্রাম</span>
                            </div>
                            <div class="info-item">
                                <span class="label">আয়ু:</span>
                                <span class="value">১.৫-২ বছর</span>
                            </div>
                            <div class="info-item">
                                <span class="label">স্বাদ:</span>
                                <span class="value">অতিসুস্বাদু</span>
                            </div>
                        </div>
                    </div>
                    <div class="farming-method">
                        <h4>চাষ পদ্ধতি:</h4>
                        <ul>
                            <li>পুকুরের আয়তন: ০.৫-২ হেক্টর</li>
                            <li>পানির গভীরতা: ১.৫-২ মিটার</li>
                            <li>বীজের পরিমাণ: ৩-৫ টন/হেক্টর</li>
                            <li>প্রজনন মৌসুম: মে-নভেম্বর</li>
                            <li>বিশেষত্ব: সেকেন্ড ক্রপ সম্ভব</li>
                        </ul>
                    </div>
                    <div class="feeding-habits">
                        <h4>খাবারের অভ্যাস:</h4>
                        <ul>
                            <li>প্রাকৃতিক খাবার: ছোট মাছ, শেলফিশ</li>
                            <li>কৃত্রিম খাবার: প্রোটিন সমৃদ্ধ ফিড</li>
                            <li>খাবারের পরিমাণ: শরীরের ওজনের ৪-৭%</li>
                            <li>খাওয়ার সমান: দিনে ২-৩ বার</li>
                        </ul>
                    </div>
                    <div class="market-value">
                        <h4>বাজার দর:</h4>
                        <div class="price-grid">
                            <div class="price-item">
                                <span class="price-label">ছোট (৩০-৫০ গ্রাম):</span>
                                <span class="price-value">৫০০-৬০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">মধ্যম (৫০-৮০ গ্রাম):</span>
                                <span class="price-value">৬০০-৮০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">বড় (৮০+ গ্রাম):</span>
                                <span class="price-value">৮০০-১২০০ টাকা/কেজি</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- প্রজাতি ৭: কাঁচা -->
            <div class="species-card glass-card" data-name="কাঁচা kachha shrimp brackish" data-environment="সামুদ্রিক" data-diet="মাংসাশী">
                <div class="species-image">
                    <svg width="200" height="120" viewBox="0 0 200 120" fill="none">
                        <!-- কাঁচা চিংড়ির ছবি -->
                        <ellipse cx="100" cy="60" rx="50" ry="18" fill="url(#kachaGradient)" opacity="0.8"/>
                        <circle cx="120" cy="58" r="2" fill="white"/>
                        <ellipse cx="100" cy="60" rx="35" ry="10" fill="rgba(255,255,255,0.4)"/>
                        <path d="M55 57L45 60L45 62L55 65L65 62L65 57Z" fill="url(#kachaGradient)"/>
                        <path d="M145 57L155 54L155 66L145 69L135 66L135 57Z" fill="url(#kachaGradient)"/>
                        <circle cx="80" cy="62" r="1" fill="white"/>
                        <circle cx="120" cy="62" r="1" fill="white"/>
                        <defs>
                            <linearGradient id="kachaGradient" x1="0" y1="0" x2="200" y2="120">
                                <stop offset="0%" style="stop-color:#FFF8E1"/>
                                <stop offset="100%" style="stop-color:#FFB74D"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="species-header">
                    <h3>কাঁচা (Kachcha)</h3>
                    <div class="species-tags">
                        <span class="tag environment-marine">সামুদ্রিক</span>
                        <span class="tag diet-carnivore">মাংসাশী</span>
                    </div>
                </div>
                <div class="species-content">
                    <div class="basic-info">
                        <h4>মৌলিক তথ্য:</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="label">বৈজ্ঞানিক নাম:</span>
                                <span class="value">Metapenaeus monoceros</span>
                            </div>
                            <div class="info-item">
                                <span class="label">সর্বোচ্চ ওজন:</span>
                                <span class="value">৫০ গ্রাম</span>
                            </div>
                            <div class="info-item">
                                <span class="label">আয়ু:</span>
                                <span class="value">১ বছর</span>
                            </div>
                            <div class="info-item">
                                <span class="label">স্বাদ:</span>
                                <span class="value">ভাল</span>
                            </div>
                        </div>
                    </div>
                    <div class="farming-method">
                        <h4>চাষ পদ্ধতি:</h4>
                        <ul>
                            <li>পুকুরের আয়তন: ০.৫-১ হেক্টর</li>
                            <li>পানির গভীরতা: ১-১.৫ মিটার</li>
                            <li>বীজের পরিমাণ: ৫-১০ টন/হেক্টর</li>
                            <li>প্রজনন মৌসুম: মার্চ-নভেম্বর</li>
                            <li>বিশেষত্ব: কম লবণাক্ততায় চাষ সম্ভব</li>
                        </ul>
                    </div>
                    <div class="feeding-habits">
                        <h4>খাবারের অভ্যাস:</h4>
                        <ul>
                            <li>প্রাকৃতিক খাবার: ছোট পোকামাকড়, শেলফিশ</li>
                            <li>কৃত্রিম খাবার: মাছের খাবার</li>
                            <li>খাবারের পরিমাণ: শরীরের ওজনের ৬-৮%</li>
                            <li>খাওয়ার সমান: দিনে বার বার</li>
                        </ul>
                    </div>
                    <div class="market-value">
                        <h4>বাজার দর:</h4>
                        <div class="price-grid">
                            <div class="price-item">
                                <span class="price-label">ছোট (২০-৩০ গ্রাম):</span>
                                <span class="price-value">৪০০-৫০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">মধ্যম (৩০-৪০ গ্রাম):</span>
                                <span class="price-value">৫০০-৬০০ টাকা/কেজি</span>
                            </div>
                            <div class="price-item">
                                <span class="price-label">বড় (৪০+ গ্রাম):</span>
                                <span class="price-value">৬০০-৮০০ টাকা/কেজি</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- No Results Message -->
<div class="no-results" id="noSpeciesResults" style="display: none;">
    <div class="container">
        <div class="glass-card no-results-card">
            <div class="no-results-content">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <circle cx="32" cy="32" r="30" fill="#E8EAF0"/>
                    <path d="M32 16L24 32L32 48L40 32L32 16Z" stroke="#6B7280" stroke-width="2"/>
                    <circle cx="32" cy="32" r="8" fill="none" stroke="#6B7280" stroke-width="2"/>
                </svg>
                <h3>কোনো ফলাফল পাওয়া যায়নি</h3>
                <p>আপনার সার্চের সাথে মিলে এমন কোনো প্রজাতির তথ্য নেই। অনুগ্রহ করে সার্চ শব্দ পরিবর্তন করে আবার চেষ্টা করুন।</p>
            </div>
        </div>
    </div>
</div>

<style>
.species-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
    gap: var(--space-6);
    margin-top: var(--space-8);
}

.species-card {
    padding: var(--space-6);
    transition: all var(--duration-normal) var(--easing-smooth);
    border: 1px solid var(--color-glass-border);
}

.species-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-glass-lg);
}

.species-image {
    height: 120px;
    border-radius: var(--radius-md);
    overflow: hidden;
    margin-bottom: var(--space-4);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-neutral-50);
}

.species-image svg {
    width: 100%;
    height: 100%;
}

.species-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--space-4);
}

.species-header h3 {
    font-size: var(--text-sm);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin: 0;
}

.species-tags {
    display: flex;
    gap: var(--space-2);
    flex-direction: column;
}

.species-content {
    display: grid;
    gap: var(--space-4);
}

.basic-info,
.farming-method,
.feeding-habits,
.market-value {
    background: rgba(255, 255, 255, 0.3);
    padding: var(--space-4);
    border-radius: var(--radius-md);
    border: 1px solid var(--color-glass-border);
}

.basic-info h4,
.farming-method h4,
.feeding-habits h4,
.market-value h4 {
    font-size: 14px;
    font-weight: var(--weight-semibold);
    color: var(--color-primary-700);
    margin-bottom: var(--space-3);
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.basic-info h4::before {
    content: "🐟";
    font-size: 14px;
}

.farming-method h4::before {
    content: "🌊";
    font-size: 14px;
}

.feeding-habits h4::before {
    content: "🍽️";
    font-size: 14px;
}

.market-value h4::before {
    content: "💰";
    font-size: 14px;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-2);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-1) 0;
}

.label {
    font-size: 12px;
    color: var(--color-neutral-600);
    font-weight: var(--weight-medium);
}

.value {
    font-size: 12px;
    color: var(--color-neutral-900);
    font-weight: var(--weight-semibold);
    text-align: right;
}

.farming-method ul,
.feeding-habits ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.farming-method li,
.feeding-habits li {
    padding: var(--space-1) 0;
    padding-left: var(--space-3);
    position: relative;
    color: var(--color-neutral-600);
    font-size: 13px;
    line-height: var(--line-height-relaxed);
}

.farming-method li::before,
.feeding-habits li::before {
    content: "▸";
    position: absolute;
    left: 0;
    color: var(--color-primary-500);
    font-weight: var(--weight-bold);
}

.price-grid {
    display: grid;
    gap: var(--space-2);
}

.price-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-2);
    background: rgba(0, 188, 212, 0.05);
    border-radius: var(--radius-sm);
    border: 1px solid rgba(0, 188, 212, 0.1);
}

.price-label {
    font-size: 12px;
    color: var(--color-neutral-600);
}

.price-value {
    font-size: 12px;
    color: var(--color-primary-700);
    font-weight: var(--weight-semibold);
}

.environment-freshwater {
    background: rgba(76, 175, 80, 0.1);
    color: var(--color-secondary-600);
}

.environment-marine {
    background: rgba(0, 188, 212, 0.1);
    color: var(--color-primary-700);
}

.diet-herbivore {
    background: rgba(139, 195, 74, 0.1);
    color: #8BC34A;
}

.diet-carnivore {
    background: rgba(244, 67, 54, 0.1);
    color: var(--color-error);
}

.diet-omnivore {
    background: rgba(255, 152, 0, 0.1);
    color: var(--color-warning);
}

@media (max-width: 768px) {
    .species-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .species-header {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .species-tags {
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: var(--space-1);
    }
    
    .species-image {
        height: 100px;
    }
}
</style>

<script>
// Species Search and Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('speciesSearch');
    const environmentFilter = document.getElementById('environmentFilter');
    const dietFilter = document.getElementById('dietFilter');
    const speciesCards = document.querySelectorAll('.species-card');
    const noResults = document.getElementById('noSpeciesResults');
    
    function filterSpecies() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedEnvironment = environmentFilter.value;
        const selectedDiet = dietFilter.value;
        
        let visibleCount = 0;
        
        speciesCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const environment = card.getAttribute('data-environment');
            const diet = card.getAttribute('data-diet');
            
            const matchesSearch = searchTerm === '' || name.includes(searchTerm);
            const matchesEnvironment = selectedEnvironment === '' || environment === selectedEnvironment;
            const matchesDiet = selectedDiet === '' || diet === selectedDiet;
            
            if (matchesSearch && matchesEnvironment && matchesDiet) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    }
    
    // Add event listeners
    searchInput.addEventListener('input', filterSpecies);
    environmentFilter.addEventListener('change', filterSpecies);
    dietFilter.addEventListener('change', filterSpecies);
});
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>