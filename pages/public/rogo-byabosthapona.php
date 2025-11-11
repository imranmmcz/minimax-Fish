<?php
$pageTitle = "রোগ ব্যবস্থাপনা";
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="header-content">
            <div class="header-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <circle cx="32" cy="32" r="30" fill="url(#medicineGradient)" stroke="white" stroke-width="2"/>
                    <rect x="28" y="16" width="8" height="32" rx="4" fill="white"/>
                    <rect x="16" y="28" width="32" height="8" rx="4" fill="white"/>
                    <defs>
                        <linearGradient id="medicineGradient" x1="0" y1="0" x2="64" y2="64">
                            <stop offset="0%" style="stop-color:#00BCD4"/>
                            <stop offset="100%" style="stop-color:#4CAF50"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="header-text">
                <h1>রোগ ব্যবস্থাপনা</h1>
                <p>মাছের রোগের লক্ষণ, চিকিৎসা ও প্রতিরোধের জন্য বিস্তারিত তথ্য</p>
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
                        <input type="text" id="diseaseSearch" placeholder="রোগের নাম বা লক্ষণ খুঁজুন...">
                    </div>
                </div>
                <div class="filter-box">
                    <select id="severityFilter" class="filter-select">
                        <option value="">সব ধরনের রোগ</option>
                        <option value="সাধারণ">সাধারণ</option>
                        <option value="মধ্যম">মধ্যম</option>
                        <option value="গুরুতর">গুরুতর</option>
                    </select>
                </div>
                <div class="filter-box">
                    <select id="categoryFilter" class="filter-select">
                        <option value="">সব ক্যাটাগরি</option>
                        <option value="ব্যাকটেরিয়াল">ব্যাকটেরিয়াল</option>
                        <option value="ভাইরাল">ভাইরাল</option>
                        <option value="ফাঙ্গাল">ফাঙ্গাল</option>
                        <option value="পরজীবী">পরজীবী</option>
                        <option value="পুষ্টিজনিত">পুষ্টিজনিত</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Disease List Section -->
<section class="disease-list-section">
    <div class="container">
        <div class="diseases-grid" id="diseasesContainer">
            <!-- রোগ কার্ড ১: শ্বাসতন্ত্রের সংক্রমণ -->
            <div class="disease-card glass-card" data-name="শ্বাসতন্ত্র সংক্রমণ respiratory infection" data-severity="মধ্যম" data-category="ব্যাকটেরিয়াল">
                <div class="disease-header">
                    <div class="disease-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="8" r="6" fill="#00BCD4"/>
                            <path d="M12 14L10 18C9.5 19 10.5 20 11.5 20L20.5 20C21.5 20 22.5 19 22 18L20 14" stroke="#00BCD4" stroke-width="2" fill="none"/>
                            <path d="M16 12V18" stroke="#00BCD4" stroke-width="2"/>
                        </svg>
                    </div>
                    <div class="disease-info">
                        <h3>শ্বাসতন্ত্রের সংক্রমণ</h3>
                        <div class="disease-tags">
                            <span class="tag severity-medium">মধ্যম</span>
                            <span class="tag category-bacterial">ব্যাকটেরিয়াল</span>
                        </div>
                    </div>
                </div>
                <div class="disease-content">
                    <div class="symptoms">
                        <h4>লক্ষণসমূহ:</h4>
                        <ul>
                            <li>মাছ পানির পৃষ্ঠে বেশি সময় কাটায়</li>
                            <li>গিল ফুলে যায় ও লাল হয়ে থাকে</li>
                            <li>শ্বাস-প্রশ্বাসে সমস্যা</li>
                            <li>খাওয়া কমে যায়</li>
                        </ul>
                    </div>
                    <div class="treatment">
                        <h4>চিকিৎসা:</h4>
                        <ul>
                            <li>পানির গুণমান পরীক্ষা করুন</li>
                            <li>অ্যান্টিবায়োটিক চিকিৎসা প্রয়োগ করুন</li>
                            <li>পানি পরিবর্তন করুন (২৫-৩০%)</li>
                            <li>প্রাকৃতিক উপায়: লবণ পানি দিন (২-৩ গ্রাম/লিটার)</li>
                        </ul>
                    </div>
                    <div class="prevention">
                        <h4>প্রতিরোধ:</h4>
                        <ul>
                            <li>উপযুক্ত পানির ঘনত্ব বজায় রাখুন</li>
                            <li>নিয়মিত পানি পরিবর্তন করুন</li>
                            <li>খাবারের পরিমাণ নিয়ন্ত্রণ করুন</li>
                            <li>মাছের ঘনত্ব কমান</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- রোগ কার্ড ২: পেট ফাঁপা -->
            <div class="disease-card glass-card" data-name="পেট ফাঁপা abdominal swelling dropsy" data-severity="গুরুতর" data-category="ব্যাকটেরিয়াল">
                <div class="disease-header">
                    <div class="disease-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <ellipse cx="16" cy="16" rx="10" ry="8" fill="#FF9800"/>
                            <path d="M16 10C14.5 10 13.5 11 13.5 12.5C13.5 14 14.5 15 16 15C17.5 15 18.5 14 18.5 12.5C18.5 11 17.5 10 16 10Z" fill="white"/>
                            <path d="M20 12C20 10 18 8 16 8" stroke="#FF9800" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <div class="disease-info">
                        <h3>পেট ফাঁপা (ড্রপসি)</h3>
                        <div class="disease-tags">
                            <span class="tag severity-high">গুরুতর</span>
                            <span class="tag category-bacterial">ব্যাকটেরিয়াল</span>
                        </div>
                    </div>
                </div>
                <div class="disease-content">
                    <div class="symptoms">
                        <h4>লক্ষণসমূহ:</h4>
                        <ul>
                            <li>পেট অস্বাভাবিকভাবে ফুলে থাকে</li>
                            <li>স্কেল খাড়া হয়ে থাকে</li>
                            <li>চোখ বের হয়ে থাকে</li>
                            <li>পানিতে সাঁতারে সমস্যা</li>
                        </ul>
                    </div>
                    <div class="treatment">
                        <h4>চিকিৎসা:</h4>
                        <ul>
                            <li>আক্রান্ত মাছ আলাদা করুন</li>
                            <li>সঠিক অ্যান্টিবায়োটিক দিন</li>
                            <li>পানির তাপমাত্রা কমান</li>
                            <li>অনেক ক্ষেত্রে চিকিৎসা সম্ভব নয়</li>
                        </ul>
                    </div>
                    <div class="prevention">
                        <h4>প্রতিরোধ:</h4>
                        <ul>
                            <li>অতিরিক্ত খাবার দেওয়া থেকে বিরত থাকুন</li>
                            <li>পানির গুণমান বজায় রাখুন</li>
                            <li>সংক্রমিত মাছ দ্রুত সরান</li>
                            <li>প্রাকৃতিক পরিবেশ রক্ষা করুন</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- রোগ কার্ড ৩: আইক (ইচ) -->
            <div class="disease-card glass-card" data-name="আইক ich white spot disease" data-severity="মধ্যম" data-category="পরজীবী">
                <div class="disease-header">
                    <div class="disease-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="12" r="4" fill="#F44336"/>
                            <path d="M20 14L24 18L28 14" stroke="#F44336" stroke-width="2" fill="none"/>
                            <path d="M12 16C12 14 14 12 16 12C18 12 20 14 20 16" stroke="#F44336" stroke-width="2" fill="none"/>
                            <path d="M8 18C8 20 10 22 12 22C14 22 16 20 16 18" stroke="#F44336" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <div class="disease-info">
                        <h3>আইক (সাদা দাগ)</h3>
                        <div class="disease-tags">
                            <span class="tag severity-medium">মধ্যম</span>
                            <span class="tag category-parasite">পরজীবী</span>
                        </div>
                    </div>
                </div>
                <div class="disease-content">
                    <div class="symptoms">
                        <h4>লক্ষণসমূহ:</h4>
                        <ul>
                            <li>দেহে সাদা বিন্দু দেখা যায়</li>
                            <li>মাছ আচারণে অস্বাভাবিক</li>
                            <li>পার্শ্ব দিয়ে ঘষার চেষ্টা করে</li>
                            <li>খাবার খেতে আগ্রহ হারায়</li>
                        </ul>
                    </div>
                    <div class="treatment">
                        <h4>চিকিৎসা:</h4>
                        <ul>
                            <li>ম্যালাশাইট গ্রিন ব্যবহার করুন</li>
                            <li>পানির তাপমাত্রা ধীরে ধীরে বাড়ান</li>
                            <li>নিয়মিত পানি পরিবর্তন করুন</li>
                            <li>অনেক ক্ষেত্রে সফল চিকিৎসা সম্ভব</li>
                        </ul>
                    </div>
                    <div class="prevention">
                        <h4>প্রতিরোধ:</h4>
                        <ul>
                            <li>নতুন মাছ সংযোজনের আগে কোয়ারেন্টিন করুন</li>
                            <li>পানির তাপমাত্রা স্থিতিশীল রাখুন</li>
                            <li>এক্সপ্রেস করা খাবার দিন</li>
                            <li>মাছের ঘনত্ব নিয়ন্ত্রণ করুন</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- রোগ কার্ড ৪: ফুল ড্রপ -->
            <div class="disease-card glass-card" data-name="ফুল ড্রপ fin rot tail rot" data-severity="সাধারণ" data-category="ব্যাকটেরিয়াল">
                <div class="disease-header">
                    <div class="disease-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path d="M16 8L12 16L16 24L20 16Z" fill="#4CAF50"/>
                            <circle cx="24" cy="12" r="6" fill="#E8F5E9"/>
                            <path d="M20 12L24 8L28 12L24 16Z" fill="#4CAF50"/>
                        </svg>
                    </div>
                    <div class="disease-info">
                        <h3>ফুল ড্রপ (ফিন রট)</h3>
                        <div class="disease-tags">
                            <span class="tag severity-low">সাধারণ</span>
                            <span class="tag category-bacterial">ব্যাকটেরিয়াল</span>
                        </div>
                    </div>
                </div>
                <div class="disease-content">
                    <div class="symptoms">
                        <h4>লক্ষণসমূহ:</h4>
                        <ul>
                            <li>ফুল বা লেজ ক্ষয় হয়ে যায়</li>
                            <li>ক্ষত অংশ খোসা খায়</li>
                            <li>রঙ হ্রাস পায়</li>
                            <li>সাঁতারে সমস্যা</li>
                        </ul>
                    </div>
                    <div class="treatment">
                        <h4>চিকিৎসা:</h4>
                        <ul>
                            <li>অ্যান্টিবায়োটিক পেস্ট ব্যবহার করুন</li>
                            <li>পানির পরিবর্তন করুন</li>
                            <li>আক্রান্ত অংশ কেটে ফেলুন</li>
                            <li>প্রতিরোধমূলক চিকিৎসা প্রয়োগ করুন</li>
                        </ul>
                    </div>
                    <div class="prevention">
                        <h4>প্রতিরোধ:</h4>
                        <ul>
                            <li>পানির গুণমান বজায় রাখুন</li>
                            <li>এক্সপ্রেস খাবার দিন</li>
                            <li>মাছের ঘনত্ব কম রাখুন</li>
                            <li>নিয়মিত পানি পরিবর্তন করুন</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- রোগ কার্ড ৫: ভাইরাল হেমরেজ -->
            <div class="disease-card glass-card" data-name="ভাইরাল হেমরেজ viral hemorrhagic" data-severity="গুরুতর" data-category="ভাইরাল">
                <div class="disease-header">
                    <div class="disease-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="12" fill="#F44336"/>
                            <circle cx="16" cy="16" r="8" fill="none" stroke="white" stroke-width="2"/>
                            <circle cx="12" cy="14" r="2" fill="white"/>
                            <circle cx="20" cy="14" r="2" fill="white"/>
                            <path d="M14 18C14 16 18 16 18 18" stroke="white" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <div class="disease-info">
                        <h3>ভাইরাল হেমরেজ</h3>
                        <div class="disease-tags">
                            <span class="tag severity-high">গুরুতর</span>
                            <span class="tag category-viral">ভাইরাল</span>
                        </div>
                    </div>
                </div>
                <div class="disease-content">
                    <div class="symptoms">
                        <h4>লক্ষণসমূহ:</h4>
                        <ul>
                            <li>দেহে লাল দাগ বা রক্তক্ষরণ</li>
                            <li>চোখের চারপাশে লালভাব</li>
                            <li>অস্বাভাবিক আচরণ</li>
                            <li>দ্রুত মৃত্যুর সম্ভাবনা</li>
                        </ul>
                    </div>
                    <div class="treatment">
                        <h4>চিকিৎসা:</h4>
                        <ul>
                            <li>ভাইরাসের জন্য কোনো নির্দিষ্ট চিকিৎসা নেই</li>
                            <li>আক্রান্ত মাছ সাথে সাথে সরান</li>
                            <li>পানির গুণমান বজায় রাখুন</li>
                            <li>সম্পূর্ণ পুকুর শুনিয়ে নিন</li>
                        </ul>
                    </div>
                    <div class="prevention">
                        <h4>প্রতিরোধ:</h4>
                        <ul>
                            <li>স্বাস্থ্যবান মাছ নিয়ে আসুন</li>
                            <li>ভ্যাকসিন প্রয়োগ করুন</li>
                            <li>পানির গুণমান নিয়মিত পরীক্ষা করুন</li>
                            <li>নিয়মিত স্যানিটাইজেশন করুন</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- রোগ কার্ড ৬: ফাঙ্গাল সংক্রমণ -->
            <div class="disease-card glass-card" data-name="ফাঙ্গাল সংক্রমণ fungal infection" data-severity="মধ্যম" data-category="ফাঙ্গাল">
                <div class="disease-header">
                    <div class="disease-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <ellipse cx="16" cy="18" rx="6" ry="4" fill="#8BC34A"/>
                            <path d="M16 10C14 10 12 12 12 14V18C12 20 14 22 16 22C18 22 20 20 20 18V14C20 12 18 10 16 10Z" fill="#8BC34A"/>
                            <circle cx="12" cy="20" r="2" fill="white"/>
                            <circle cx="20" cy="20" r="2" fill="white"/>
                            <path d="M16 16L18 14L16 12L14 14L16 16Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="disease-info">
                        <h3>ফাঙ্গাল সংক্রমণ</h3>
                        <div class="disease-tags">
                            <span class="tag severity-medium">মধ্যম</span>
                            <span class="tag category-fungal">ফাঙ্গাল</span>
                        </div>
                    </div>
                </div>
                <div class="disease-content">
                    <div class="symptoms">
                        <h4>লক্ষণসমূহ:</h4>
                        <ul>
                            <li>দেহে সাদা বা ধূসর ছত্রাকের খোল</li>
                            <li>দেহে সাদা তুলা আকৃতির ভাব</li>
                            <li>অস্বাভাবিক খোসা খাওয়া</li>
                            <li>ক্ষতিগ্রস্ত অংশ দেখা যায়</li>
                        </ul>
                    </div>
                    <div class="treatment">
                        <h4>চিকিৎসা:</h4>
                        <ul>
                            <li>ম্যালাশাইট গ্রিন দিয়ে চিকিৎসা</li>
                            <li>লবণ পানির চিকিৎসা</li>
                            <li>প্রতিদিন পানি পরিবর্তন</li>
                            <li>অ্যান্টি-ফাঙ্গাল ওষুধ ব্যবহার</li>
                        </ul>
                    </div>
                    <div class="prevention">
                        <h4>প্রতিরোধ:</h4>
                        <ul>
                            <li>আহত মাছ সাথে সাথে চিকিৎসা করুন</li>
                            <li>পানির গুণমান বজায় রাখুন</li>
                            <li>কোনো আঘাত থাকলে সাথে সাথে চিকিৎসা</li>
                            <li>প্রাকৃতিক চিকিৎসার ব্যবস্থা রাখুন</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- রোগ কার্ড ৭: পুষ্টিজনিত সমস্যা -->
            <div class="disease-card glass-card" data-name="পুষ্টিজনিত সমস্যা nutritional deficiency" data-severity="সাধারণ" data-category="পুষ্টিজনিত">
                <div class="disease-header">
                    <div class="disease-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="10" fill="#FF9800"/>
                            <path d="M12 14L14 16L16 14L18 16L20 14" stroke="white" stroke-width="2" fill="none"/>
                            <path d="M14 18C14 16 18 16 18 18" stroke="white" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="2" fill="white"/>
                            <circle cx="20" cy="12" r="2" fill="white"/>
                        </svg>
                    </div>
                    <div class="disease-info">
                        <h3>পুষ্টিজনিত সমস্যা</h3>
                        <div class="disease-tags">
                            <span class="tag severity-low">সাধারণ</span>
                            <span class="tag category-nutritional">পুষ্টিজনিত</span>
                        </div>
                    </div>
                </div>
                <div class="disease-content">
                    <div class="symptoms">
                        <h4>লক্ষণসমূহ:</h4>
                        <ul>
                            <li>মাছের রঙ ফ্যাকাশে হয়ে যায়</li>
                            <li>হজম সমস্যা</li>
                            <li>অস্বাভাবিক আচরণ</li>
                            <li>রোগ প্রতিরোধ ক্ষমতা কমে যায়</li>
                        </ul>
                    </div>
                    <div class="treatment">
                        <h4>চিকিৎসা:</h4>
                        <ul>
                            <li>সুষম খাবার দিন</li>
                            <li>ভিটামিন সাপ্লিমেন্ট যোগ করুন</li>
                            <li>খাবারের পরিমাণ সমন্বয় করুন</li>
                            <li>আরও বৈচিত্র্যময় খাবার দিন</li>
                        </ul>
                    </div>
                    <div class="prevention">
                        <h4>প্রতিরোধ:</h4>
                        <ul>
                            <li>মানসম্পন্ন খাবার ব্যবহার করুন</li>
                            <li>বৈচিত্র্যময় খাবার দিন</li>
                            <li>নিয়মিত সময়ে খাবার দিন</li>
                            <li>খাবারের পরিমাণ নিয়ন্ত্রণ করুন</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- No Results Message -->
<div class="no-results" id="noResults" style="display: none;">
    <div class="container">
        <div class="glass-card no-results-card">
            <div class="no-results-content">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <circle cx="32" cy="32" r="30" fill="#E8EAF0"/>
                    <path d="M32 16L24 32L32 48L40 32L32 16Z" stroke="#6B7280" stroke-width="2"/>
                    <circle cx="32" cy="32" r="8" fill="none" stroke="#6B7280" stroke-width="2"/>
                </svg>
                <h3>কোনো ফলাফল পাওয়া যায়নি</h3>
                <p>আপনার সার্চের সাথে মিলে এমন কোনো রোগের তথ্য নেই। অনুগ্রহ করে সার্চ শব্দ পরিবর্তন করে আবার চেষ্টা করুন।</p>
            </div>
        </div>
    </div>
</div>

<style>
.diseases-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: var(--space-6);
    margin-top: var(--space-8);
}

.disease-card {
    padding: var(--space-6);
    transition: all var(--duration-normal) var(--easing-smooth);
    border: 1px solid var(--color-glass-border);
}

.disease-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-glass-lg);
}

.disease-header {
    display: flex;
    align-items: flex-start;
    gap: var(--space-4);
    margin-bottom: var(--space-4);
}

.disease-icon {
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-lg);
    background: var(--color-glass-white);
}

.disease-info h3 {
    font-size: var(--text-sm);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.disease-tags {
    display: flex;
    gap: var(--space-2);
    flex-wrap: wrap;
}

.tag {
    padding: 2px 8px;
    border-radius: var(--radius-full);
    font-size: 11px;
    font-weight: var(--weight-medium);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.severity-low {
    background: rgba(76, 175, 80, 0.1);
    color: var(--color-secondary-600);
}

.severity-medium {
    background: rgba(255, 152, 0, 0.1);
    color: var(--color-warning);
}

.severity-high {
    background: rgba(244, 67, 54, 0.1);
    color: var(--color-error);
}

.category-bacterial {
    background: rgba(0, 188, 212, 0.1);
    color: var(--color-primary-700);
}

.category-viral {
    background: rgba(244, 67, 54, 0.1);
    color: var(--color-error);
}

.category-fungal {
    background: rgba(139, 195, 74, 0.1);
    color: #8BC34A;
}

.category-parasite {
    background: rgba(156, 39, 176, 0.1);
    color: #9C27B0;
}

.category-nutritional {
    background: rgba(255, 152, 0, 0.1);
    color: var(--color-warning);
}

.disease-content {
    display: grid;
    gap: var(--space-4);
}

.symptoms h4,
.treatment h4,
.prevention h4 {
    font-size: 14px;
    font-weight: var(--weight-semibold);
    color: var(--color-primary-700);
    margin-bottom: var(--space-2);
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.symptoms h4::before {
    content: "🔍";
    font-size: 14px;
}

.treatment h4::before {
    content: "💊";
    font-size: 14px;
}

.prevention h4::before {
    content: "🛡️";
    font-size: 14px;
}

.disease-content ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.disease-content li {
    padding: var(--space-2) 0;
    padding-left: var(--space-4);
    position: relative;
    color: var(--color-neutral-600);
    font-size: 14px;
    line-height: var(--line-height-relaxed);
}

.disease-content li::before {
    content: "•";
    position: absolute;
    left: 0;
    color: var(--color-primary-500);
    font-weight: var(--weight-bold);
}

@media (max-width: 768px) {
    .diseases-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .search-filter-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .disease-header {
        gap: var(--space-3);
    }
    
    .disease-icon {
        width: 40px;
        height: 40px;
    }
}
</style>

<script>
// Disease Search and Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('diseaseSearch');
    const severityFilter = document.getElementById('severityFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const diseaseCards = document.querySelectorAll('.disease-card');
    const noResults = document.getElementById('noResults');
    
    function filterDiseases() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedSeverity = severityFilter.value;
        const selectedCategory = categoryFilter.value;
        
        let visibleCount = 0;
        
        diseaseCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const severity = card.getAttribute('data-severity');
            const category = card.getAttribute('data-category');
            
            const matchesSearch = searchTerm === '' || name.includes(searchTerm);
            const matchesSeverity = selectedSeverity === '' || severity === selectedSeverity;
            const matchesCategory = selectedCategory === '' || category === selectedCategory;
            
            if (matchesSearch && matchesSeverity && matchesCategory) {
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
    searchInput.addEventListener('input', filterDiseases);
    severityFilter.addEventListener('change', filterDiseases);
    categoryFilter.addEventListener('change', filterDiseases);
    
    // Add card click for expansion (optional enhancement)
    diseaseCards.forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('expanded');
        });
    });
});
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>