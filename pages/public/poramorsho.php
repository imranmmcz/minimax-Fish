<?php
$pageTitle = "পরামর্শ";
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="header-content">
            <div class="header-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <rect x="12" y="16" width="40" height="32" rx="8" fill="url(#adviceGradient)" stroke="white" stroke-width="2"/>
                    <path d="M20 24H44M20 30H36M20 36H32" stroke="white" stroke-width="2"/>
                    <circle cx="32" cy="10" r="6" fill="white"/>
                    <path d="M32 7V13" stroke="#00BCD4" stroke-width="2"/>
                    <defs>
                        <linearGradient id="adviceGradient" x1="0" y1="0" x2="64" y2="64">
                            <stop offset="0%" style="stop-color:#00BCD4"/>
                            <stop offset="100%" style="stop-color:#4CAF50"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="header-text">
                <h1>পরামর্শ</h1>
                <p>অভিজ্ঞ বিশেষজ্ঞদের কাছ থেকে পেয়ে নিন পেশাদার পরামর্শ</p>
            </div>
        </div>
    </div>
</section>

<!-- Consultation Types Section -->
<section class="consultation-types">
    <div class="container">
        <div class="section-header">
            <h2>পরামর্শের ধরন</h2>
            <p>বিভিন্ন ধরনের পরামর্শ সেবা উপলব্ধ</p>
        </div>

        <div class="consultation-grid">
            
            <!-- পরামর্শ ধরন ১: অনলাইন পরামর্শ -->
            <div class="consultation-card glass-card">
                <div class="consultation-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#2196F3"/>
                        <rect x="18" y="16" width="12" height="16" rx="2" fill="white"/>
                        <rect x="14" y="22" width="20" height="2" rx="1" fill="#2196F3"/>
                        <rect x="14" y="26" width="16" height="2" rx="1" fill="#2196F3"/>
                        <circle cx="24" cy="12" r="3" fill="white"/>
                    </svg>
                </div>
                <h3>অনলাইন পরামর্শ</h3>
                <p>ভিডিও কল বা চ্যাটের মাধ্যমে বিশেষজ্ঞের সাথে কথা বলুন</p>
                <div class="consultation-details">
                    <div class="detail-item">
                        <span class="label">সময়কাল:</span>
                        <span class="value">৩০-৬০ মিনিট</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">মূল্য:</span>
                        <span class="value">৫০০-২,০০০ টাকা</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">ব্যবহারযোগ্য:</span>
                        <span class="value">সারাদিন</span>
                    </div>
                </div>
                <button class="btn-consult" onclick="bookConsultation('online')">বুক করুন</button>
            </div>

            <!-- পরামর্শ ধরন ২: ফোন পরামর্শ -->
            <div class="consultation-card glass-card">
                <div class="consultation-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#4CAF50"/>
                        <path d="M18 20C18 14 22 10 28 10L32 14L30 16L26 14L24 16L22 14L18 18L20 20C18 20 18 20 18 20Z" fill="white"/>
                        <circle cx="24" cy="28" r="6" fill="white"/>
                    </svg>
                </div>
                <h3>ফোন পরামর্শ</h3>
                <p>ফোন কলের মাধ্যমে সরাসরি কথা বলুন বিশেষজ্ঞদের সাথে</p>
                <div class="consultation-details">
                    <div class="detail-item">
                        <span class="label">সময়কাল:</span>
                        <span class="value">১৫-৩০ মিনিট</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">মূল্য:</span>
                        <span class="value">২০০-৮০০ টাকা</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">ব্যবহারযোগ্য:</span>
                        <span class="value">সকাল-সন্ধ্যা</span>
                    </div>
                </div>
                <button class="btn-consult" onclick="bookConsultation('phone')">বুক করুন</button>
            </div>

            <!-- পরামর্শ ধরন ৩: সরাসরি সাক্ষাত -->
            <div class="consultation-card glass-card">
                <div class="consultation-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#FF9800"/>
                        <circle cx="18" cy="22" r="6" fill="white"/>
                        <circle cx="30" cy="22" r="6" fill="white"/>
                        <path d="M16 32C16 30 20 28 24 28C28 28 32 30 32 32" stroke="white" stroke-width="2" fill="none"/>
                        <rect x="20" y="8" width="8" height="4" rx="2" fill="white"/>
                    </svg>
                </div>
                <h3>সরাসরি সাক্ষাত</h3>
                <p>প্রদত্ত ঠিকানায় গিয়ে সরাসরি বিশেষজ্ঞের সাথে দেখা করুন</p>
                <div class="consultation-details">
                    <div class="detail-item">
                        <span class="label">সময়কাল:</span>
                        <span class="value">১-২ ঘন্টা</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">মূল্য:</span>
                        <span class="value">১,০০০-৫,০০০ টাকা</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">ব্যবহারযোগ্য:</span>
                        <span class="value">অ্যাপয়েন্টমেন্ট</span>
                    </div>
                </div>
                <button class="btn-consult" onclick="bookConsultation('in-person')">বুক করুন</button>
            </div>

            <!-- পরামর্শ ধরন ৪: লিখিত পরামর্শ -->
            <div class="consultation-card glass-card">
                <div class="consultation-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#9C27B0"/>
                        <rect x="16" y="18" width="16" height="12" rx="1" fill="white"/>
                        <path d="M20 20H28M20 24H24" stroke="#9C27B0" stroke-width="2"/>
                        <circle cx="34" cy="16" r="6" fill="#9C27B0"/>
                        <path d="M31 16L34 13L37 16L34 19L31 16Z" fill="white"/>
                    </svg>
                </div>
                <h3>লিখিত পরামর্শ</h3>
                <p>আপনার সমস্যার বিস্তারিত বিবরণ পাঠালে বিশেষজ্ঞ লিখিত উত্তর দেবেন</p>
                <div class="consultation-details">
                    <div class="detail-item">
                        <span class="label">সময়কাল:</span>
                        <span class="value">২৪-৪৮ ঘন্টা</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">মূল্য:</span>
                        <span class="value">৩০০-১,৫০০ টাকা</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">ব্যবহারযোগ্য:</span>
                        <span class="value">সারাদিন</span>
                    </div>
                </div>
                <button class="btn-consult" onclick="bookConsultation('written')">বুক করুন</button>
            </div>

        </div>
    </div>
</section>

<!-- Experts Section -->
<section class="experts-section">
    <div class="container">
        <div class="section-header">
            <h2>আমাদের বিশেষজ্ঞ দল</h2>
            <p>অভিজ্ঞ ও যোগ্যতাবান বিশেষজ্ঞদের তালিকা</p>
        </div>

        <div class="experts-grid">
            
            <!-- বিশেষজ্ঞ ১ -->
            <div class="expert-card glass-card">
                <div class="expert-image">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none">
                        <circle cx="50" cy="50" r="48" fill="url(#expert1Gradient)"/>
                        <circle cx="50" cy="40" r="20" fill="white"/>
                        <path d="M30 70C30 60 35 55 45 55H55C65 55 70 60 70 70" stroke="white" stroke-width="4" fill="none"/>
                        <path d="M42 35C44 32 48 30 50 30C52 30 56 32 58 35" stroke="url(#expert1Gradient)" stroke-width="2" fill="none"/>
                        <defs>
                            <linearGradient id="expert1Gradient" x1="0" y1="0" x2="100" y2="100">
                                <stop offset="0%" style="stop-color:#00BCD4"/>
                                <stop offset="100%" style="stop-color:#4CAF50"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="expert-info">
                    <h3>ড. মোহাম্মদ আলী</h3>
                    <p class="expertise">মৎস্য চাষ বিশেষজ্ঞ</p>
                    <p class="experience">১৫ বছর অভিজ্ঞতা</p>
                    <div class="specializations">
                        <span class="spec">রুই চাষ</span>
                        <span class="spec">পুকুর ব্যবস্থাপনা</span>
                        <span class="spec">রোগ চিকিৎসা</span>
                    </div>
                    <div class="expert-stats">
                        <div class="stat">
                            <span class="stat-value">৯৮%</span>
                            <span class="stat-label">সন্তুষ্টি</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">১২০০+</span>
                            <span class="stat-label">পরামর্শ</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৪.৯</span>
                            <span class="stat-label">রেটিং</span>
                        </div>
                    </div>
                    <div class="consultation-fees">
                        <span>পরামর্শ ফি:</span>
                        <span class="fee">১,০০০ - ৩,০০০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- বিশেষজ্ঞ ২ -->
            <div class="expert-card glass-card">
                <div class="expert-image">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none">
                        <circle cx="50" cy="50" r="48" fill="url(#expert2Gradient)"/>
                        <circle cx="50" cy="40" r="18" fill="white"/>
                        <path d="M32 72C32 60 38 54 50 54H52C64 54 70 60 70 72" stroke="white" stroke-width="4" fill="none"/>
                        <circle cx="40" cy="38" r="2" fill="url(#expert2Gradient)"/>
                        <circle cx="60" cy="38" r="2" fill="url(#expert2Gradient)"/>
                        <path d="M42 46C46 48 54 48 58 46" stroke="url(#expert2Gradient)" stroke-width="2" fill="none"/>
                        <defs>
                            <linearGradient id="expert2Gradient" x1="0" y1="0" x2="100" y2="100">
                                <stop offset="0%" style="stop-color:#4CAF50"/>
                                <stop offset="100%" style="stop-color:#8BC34A"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="expert-info">
                    <h3>প্রফেসর ফাতিমা খাতুন</h3>
                    <p class="expertise">মৎস্য পুষ্টিবিদ</p>
                    <p class="experience">১২ বছর অভিজ্ঞতা</p>
                    <div class="specializations">
                        <span class="spec">খাবার ব্যবস্থাপনা</span>
                        <span class="spec">পুষ্টিজনিত সমস্যা</span>
                        <span class="spec">উৎপাদন বৃদ্ধি</span>
                    </div>
                    <div class="expert-stats">
                        <div class="stat">
                            <span class="stat-value">৯৫%</span>
                            <span class="stat-label">সন্তুষ্টি</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৮৫০+</span>
                            <span class="stat-label">পরামর্শ</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৪.৮</span>
                            <span class="stat-label">রেটিং</span>
                        </div>
                    </div>
                    <div class="consultation-fees">
                        <span>পরামর্শ ফি:</span>
                        <span class="fee">৮০০ - ২,৫০০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- বিশেষজ্ঞ ৩ -->
            <div class="expert-card glass-card">
                <div class="expert-image">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none">
                        <circle cx="50" cy="50" r="48" fill="url(#expert3Gradient)"/>
                        <circle cx="50" cy="42" r="22" fill="white"/>
                        <path d="M28 74C28 60 36 54 50 54H52C66 54 74 60 74 74" stroke="white" stroke-width="4" fill="none"/>
                        <path d="M44 38L48 42L56 34" stroke="url(#expert3Gradient)" stroke-width="3" fill="none"/>
                        <circle cx="44" cy="30" r="3" fill="url(#expert3Gradient)"/>
                        <circle cx="56" cy="30" r="3" fill="url(#expert3Gradient)"/>
                        <defs>
                            <linearGradient id="expert3Gradient" x1="0" y1="0" x2="100" y2="100">
                                <stop offset="0%" style="stop-color:#F44336"/>
                                <stop offset="100%" style="stop-color:#FF9800"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="expert-info">
                    <h3>ড. রহিম উদ্দিন</h3>
                    <p class="expertise">মৎস্য রোগ বিশেষজ্ঞ</p>
                    <p class="experience">১৮ বছর অভিজ্ঞতা</p>
                    <div class="specializations">
                        <span class="spec">রোগ নির্ণয়</span>
                        <span class="spec">ওষুধ প্রয়োগ</span>
                        <span class="spec">প্রতিরোধ ব্যবস্থা</span>
                    </div>
                    <div class="expert-stats">
                        <div class="stat">
                            <span class="stat-value">৯৯%</span>
                            <span class="stat-label">সন্তুষ্টি</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">১৮০০+</span>
                            <span class="stat-label">পরামর্শ</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৫.০</span>
                            <span class="stat-label">রেটিং</span>
                        </div>
                    </div>
                    <div class="consultation-fees">
                        <span>পরামর্শ ফি:</span>
                        <span class="fee">১,৫০০ - ৪,০০০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- বিশেষজ্ঞ ৪ -->
            <div class="expert-card glass-card">
                <div class="expert-image">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none">
                        <circle cx="50" cy="50" r="48" fill="url(#expert4Gradient)"/>
                        <circle cx="50" cy="38" r="16" fill="white"/>
                        <path d="M34 76C34 62 40 58 50 58H52C62 58 68 62 68 76" stroke="white" stroke-width="4" fill="none"/>
                        <path d="M42 36L46 32L50 36L54 32L58 36" stroke="url(#expert4Gradient)" stroke-width="2" fill="none"/>
                        <circle cx="36" cy="44" r="3" fill="url(#expert4Gradient)"/>
                        <circle cx="64" cy="44" r="3" fill="url(#expert4Gradient)"/>
                        <defs>
                            <linearGradient id="expert4Gradient" x1="0" y1="0" x2="100" y2="100">
                                <stop offset="0%" style="stop-color:#2196F3"/>
                                <stop offset="100%" style="stop-color:#03A9F4"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="expert-info">
                    <h3>ইঞ্জিনিয়ার করিম আহমেদ</h3>
                    <p class="expertise">পুকুর প্রকৌশলী</p>
                    <p class="experience">১০ বছর অভিজ্ঞতা</p>
                    <div class="specializations">
                        <span class="spec">পুকুর নির্মাণ</span>
                        <span class="spec">পানি ব্যবস্থাপনা</span>
                        <span class="spec">সিস্টেম ডিজাইন</span>
                    </div>
                    <div class="expert-stats">
                        <div class="stat">
                            <span class="stat-value">৯৬%</span>
                            <span class="stat-label">সন্তুষ্টি</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৬৫০+</span>
                            <span class="stat-label">পরামর্শ</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৪.৭</span>
                            <span class="stat-label">রেটিং</span>
                        </div>
                    </div>
                    <div class="consultation-fees">
                        <span>পরামর্শ ফি:</span>
                        <span class="fee">১,২০০ - ৩,৫০০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- বিশেষজ্ঞ ৫ -->
            <div class="expert-card glass-card">
                <div class="expert-image">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none">
                        <circle cx="50" cy="50" r="48" fill="url(#expert5Gradient)"/>
                        <circle cx="50" cy="44" r="20" fill="white"/>
                        <path d="M30 78C30 62 38 56 50 56H52C64 56 72 62 72 78" stroke="white" stroke-width="4" fill="none"/>
                        <path d="M40 44C42 42 46 42 50 44C54 42 58 42 60 44" stroke="url(#expert5Gradient)" stroke-width="2" fill="none"/>
                        <circle cx="40" cy="40" r="2" fill="url(#expert5Gradient)"/>
                        <circle cx="60" cy="40" r="2" fill="url(#expert5Gradient)"/>
                        <path d="M44 52L50 58L56 52" stroke="url(#expert5Gradient)" stroke-width="2" fill="none"/>
                        <defs>
                            <linearGradient id="expert5Gradient" x1="0" y1="0" x2="100" y2="100">
                                <stop offset="0%" style="stop-color:#9C27B0"/>
                                <stop offset="100%" style="stop-color:#E91E63"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="expert-info">
                    <h3>ড. নাসির উদ্দিন</h3>
                    <p class="expertise">মৎস্য অর্থনীতিবিদ</p>
                    <p class="experience">১৪ বছর অভিজ্ঞতা</p>
                    <div class="specializations">
                        <span class="spec">বিনিয়োগ পরিকল্পনা</span>
                        <span class="spec">বাজার বিশ্লেষণ</span>
                        <span class="spec">ঝুঁকি ব্যবস্থাপনা</span>
                    </div>
                    <div class="expert-stats">
                        <div class="stat">
                            <span class="stat-value">৯৭%</span>
                            <span class="stat-label">সন্তুষ্টি</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৯২০+</span>
                            <span class="stat-label">পরামর্শ</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৪.৮</span>
                            <span class="stat-label">রেটিং</span>
                        </div>
                    </div>
                    <div class="consultation-fees">
                        <span>পরামর্শ ফি:</span>
                        <span class="fee">৯০০ - ২,৮০০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- বিশেষজ্ঞ ৬ -->
            <div class="expert-card glass-card">
                <div class="expert-image">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none">
                        <circle cx="50" cy="50" r="48" fill="url(#expert6Gradient)"/>
                        <circle cx="50" cy="36" r="18" fill="white"/>
                        <path d="M32 80C32 64 40 58 50 58H52C62 58 70 64 70 80" stroke="white" stroke-width="4" fill="none"/>
                        <path d="M42 34L46 38L50 34L54 38L58 34" stroke="url(#expert6Gradient)" stroke-width="2" fill="none"/>
                        <circle cx="38" cy="46" r="3" fill="url(#expert6Gradient)"/>
                        <circle cx="62" cy="46" r="3" fill="url(#expert6Gradient)"/>
                        <path d="M46 52L50 56L54 52" stroke="url(#expert6Gradient)" stroke-width="2" fill="none"/>
                        <defs>
                            <linearGradient id="expert6Gradient" x1="0" y1="0" x2="100" y2="100">
                                <stop offset="0%" style="stop-color:#607D8B"/>
                                <stop offset="100%" style="stop-color:#78909C"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="expert-info">
                    <h3>মেহেরুন নেসা</h3>
                    <p class="expertise">মৎস্য প্রযুক্তিবিদ</p>
                    <p class="experience">৯ বছর অভিজ্ঞতা</p>
                    <div class="specializations">
                        <span class="spec">আধুনিক প্রযুক্তি</span>
                        <span class="spec">অটোমেশন</span>
                        <span class="spec">সিস্টেম অপটিমাইজেশন</span>
                    </div>
                    <div class="expert-stats">
                        <div class="stat">
                            <span class="stat-value">৯৪%</span>
                            <span class="stat-label">সন্তুষ্টি</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৪৫০+</span>
                            <span class="stat-label">পরামর্শ</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">৪.৬</span>
                            <span class="stat-label">রেটিং</span>
                        </div>
                    </div>
                    <div class="consultation-fees">
                        <span>পরামর্শ ফি:</span>
                        <span class="fee">৭০০ - ২,২০০ টাকা</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Consultation Request Form -->
<section class="consultation-request">
    <div class="container">
        <div class="glass-card consultation-form-card">
            <div class="form-header">
                <h3>পরামর্শ অনুরোধ করুন</h3>
                <p>আপনার সমস্যা ও প্রয়োজনের বিস্তারিত তথ্য দিন</p>
            </div>
            
            <form class="consultation-form" id="consultationForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="clientName">আপনার নাম</label>
                        <input type="text" id="clientName" name="name" required placeholder="সম্পূর্ণ নাম">
                    </div>
                    <div class="form-group">
                        <label for="clientPhone">ফোন নম্বর</label>
                        <input type="tel" id="clientPhone" name="phone" required placeholder="০১XXXXXXXXX">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="clientEmail">ইমেইল (ঐচ্ছিক)</label>
                        <input type="email" id="clientEmail" name="email" placeholder="example@email.com">
                    </div>
                    <div class="form-group">
                        <label for="consultationType">পরামর্শের ধরন</label>
                        <select id="consultationType" name="type" required>
                            <option value="">ধরন নির্বাচন করুন</option>
                            <option value="online">অনলাইন পরামর্শ</option>
                            <option value="phone">ফোন পরামর্শ</option>
                            <option value="in-person">সরাসরি সাক্ষাত</option>
                            <option value="written">লিখিত পরামর্শ</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="problemCategory">সমস্যার ক্যাটাগরি</label>
                        <select id="problemCategory" name="category" required>
                            <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                            <option value="চাষ-পদ্ধতি">চাষ পদ্ধতি</option>
                            <option value="রোগ-ব্যবস্থাপনা">রোগ ব্যবস্থাপনা</option>
                            <option value="খাবার-ব্যবস্থাপনা">খাবার ব্যবস্থাপনা</option>
                            <option value="পানি-ব্যবস্থাপনা">পানি ব্যবস্থাপনা</option>
                            <option value="অর্থনীতি">অর্থনীতি</option>
                            <option value="প্রযুক্তি">প্রযুক্তি</option>
                            <option value="অন্যান্য">অন্যান্য</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="preferredExpert">পছন্দের বিশেষজ্ঞ (ঐচ্ছিক)</label>
                        <select id="preferredExpert" name="expert">
                            <option value="">যেকোনো বিশেষজ্ঞ</option>
                            <option value="dr-mohammad-ali">ড. মোহাম্মদ আলী</option>
                            <option value="prof-fatima">প্রফেসর ফাতিমা খাতুন</option>
                            <option value="dr-rahim">ড. রহিম উদ্দিন</option>
                            <option value="eng-karim">ইঞ্জিনিয়ার করিম আহমেদ</option>
                            <option value="dr-nasir">ড. নাসির উদ্দিন</option>
                            <option value="meherun">মেহেরুন নেসা</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="problemUrgency">জরুরিতা</label>
                        <select id="problemUrgency" name="urgency">
                            <option value="normal">সাধারণ</option>
                            <option value="urgent">জরুরি</option>
                            <option value="emergency">অত্যন্ত জরুরি</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="preferredDate">পছন্দের তারিখ</label>
                        <input type="date" id="preferredDate" name="date" min="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="problemDescription">সমস্যার বিস্তারিত বিবরণ</label>
                    <textarea id="problemDescription" name="description" rows="6" required placeholder="আপনার সমস্যার বিস্তারিত বিবরণ লিখুন। কতদিন ধরে সমস্যা হচ্ছে, কি কি চেষ্টা করেছেন, বর্তমান পরিস্থিতি ইত্যাদি উল্লেখ করুন..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="previousAttempts">আগে কি কি করেছেন</label>
                    <textarea id="previousAttempts" name="attempts" rows="3" placeholder="আপনি এই সমস্যা সমাধানের জন্য আগে কি কি করেছেন?"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="farmDetails">পুকুর/খামার সংক্রান্ত তথ্য (ঐচ্ছিক)</label>
                    <textarea id="farmDetails" name="farmInfo" rows="3" placeholder="পুকুরের আয়তন, মাছের প্রজাতি, বয়স, আপনার অভিজ্ঞতা ইত্যাদি..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="additionalInfo">অতিরিক্ত তথ্য (ঐচ্ছিক)</label>
                    <textarea id="additionalInfo" name="additional" rows="2" placeholder="যেকোনো অতিরিক্ত তথ্য বা বিশেষ নির্দেশনা..."></textarea>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="acceptTerms" name="accept" required>
                        <span class="checkmark"></span>
                        আমি স্বীকার করছি যে সকল তথ্য সত্য এবং আমি পরামর্শ সেবার শর্তাবলী মেনে নিচ্ছি।
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-glass" onclick="clearConsultationForm()">সাফ করুন</button>
                    <button type="submit" class="btn-primary">অনুরোধ পাঠান</button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.consultation-types {
    padding: var(--space-8) 0;
    background: var(--bg-primary);
}

.consultation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-6);
}

.consultation-card {
    padding: var(--space-6);
    text-align: center;
    transition: all var(--duration-normal) var(--easing-smooth);
    border: 1px solid var(--color-glass-border);
}

.consultation-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-glass);
    border-color: var(--color-primary-500);
}

.consultation-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto var(--space-4);
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-neutral-50);
}

.consultation-card h3 {
    font-size: 18px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.consultation-card p {
    font-size: 14px;
    color: var(--color-neutral-600);
    margin-bottom: var(--space-4);
    line-height: var(--line-height-relaxed);
}

.consultation-details {
    background: rgba(255, 255, 255, 0.3);
    padding: var(--space-4);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-4);
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-1) 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item .label {
    font-size: 12px;
    color: var(--color-neutral-600);
    font-weight: var(--weight-medium);
}

.detail-item .value {
    font-size: 12px;
    color: var(--color-neutral-900);
    font-weight: var(--weight-semibold);
}

.btn-consult {
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

.btn-consult:hover {
    background: var(--color-primary-600);
    transform: translateY(-1px);
}

.experts-section {
    padding: var(--space-8) 0;
    background: var(--bg-dashboard);
}

.experts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: var(--space-6);
}

.expert-card {
    padding: var(--space-6);
    transition: all var(--duration-normal) var(--easing-smooth);
    border: 1px solid var(--color-glass-border);
}

.expert-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-glass-lg);
}

.expert-image {
    width: 100px;
    height: 100px;
    margin: 0 auto var(--space-4);
    border-radius: var(--radius-full);
    overflow: hidden;
}

.expert-info {
    text-align: center;
}

.expert-info h3 {
    font-size: 18px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-1);
}

.expertise {
    font-size: 14px;
    color: var(--color-primary-700);
    font-weight: var(--weight-medium);
    margin-bottom: var(--space-1);
}

.experience {
    font-size: 12px;
    color: var(--color-neutral-600);
    margin-bottom: var(--space-3);
}

.specializations {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: var(--space-2);
    margin-bottom: var(--space-4);
}

.spec {
    padding: 4px 8px;
    background: rgba(0, 188, 212, 0.1);
    color: var(--color-primary-700);
    border-radius: var(--radius-full);
    font-size: 11px;
    font-weight: var(--weight-medium);
}

.expert-stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: var(--space-4);
    padding: var(--space-3);
    background: var(--color-glass-white);
    border-radius: var(--radius-md);
}

.stat {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 16px;
    font-weight: var(--weight-bold);
    color: var(--color-primary-700);
}

.stat-label {
    font-size: 11px;
    color: var(--color-neutral-600);
    font-weight: var(--weight-medium);
}

.consultation-fees {
    background: rgba(76, 175, 80, 0.1);
    padding: var(--space-2);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-4);
}

.consultation-fees span:first-child {
    font-size: 12px;
    color: var(--color-neutral-600);
}

.fee {
    font-size: 14px;
    font-weight: var(--weight-semibold);
    color: var(--color-secondary-700);
}

.consultation-request {
    padding: var(--space-8) 0;
}

.consultation-form-card {
    max-width: 800px;
    margin: 0 auto;
}

.form-header {
    text-align: center;
    margin-bottom: var(--space-6);
}

.form-header h3 {
    font-size: var(--text-sm);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.form-header p {
    font-size: 14px;
    color: var(--color-neutral-600);
    margin: 0;
}

.consultation-form {
    display: grid;
    gap: var(--space-4);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-4);
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
.form-group select,
.form-group textarea {
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
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--color-primary-500);
    box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    font-size: 14px;
    color: var(--color-neutral-600);
    cursor: pointer;
    line-height: var(--line-height-relaxed);
}

.checkbox-label input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid var(--color-glass-border);
    border-radius: 4px;
    background: var(--color-glass-white);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all var(--duration-fast) var(--easing-default);
}

.checkbox-label input[type="checkbox"]:checked + .checkmark {
    background: var(--color-primary-500);
    border-color: var(--color-primary-500);
}

.checkbox-label input[type="checkbox"]:checked + .checkmark::after {
    content: "✓";
    color: white;
    font-size: 12px;
    font-weight: var(--weight-bold);
}

.form-actions {
    display: flex;
    gap: var(--space-4);
    justify-content: flex-end;
    margin-top: var(--space-6);
}

@media (max-width: 768px) {
    .consultation-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .experts-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .expert-stats {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: var(--space-3);
    }
    
    .form-actions {
        flex-direction: column;
        gap: var(--space-2);
    }
}
</style>

<script>
// Consultation booking functions
function bookConsultation(type) {
    // Set the consultation type in the form
    const typeSelect = document.getElementById('consultationType');
    typeSelect.value = type;
    
    // Scroll to the consultation request form
    document.querySelector('.consultation-request').scrollIntoView({
        behavior: 'smooth'
    });
    
    // Show success message
    alert(type + ' পরামর্শের জন্য ফর্ম পূরণ করুন।');
}

// Form submission handling
document.getElementById('consultationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simulate form submission
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Show success message (in real implementation, this would submit to server)
    alert('আপনার পরামর্শ অনুরোধটি সফলভাবে পাঠানো হয়েছে। আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব!');
    
    // Reset form
    this.reset();
});

function clearConsultationForm() {
    if (confirm('আপনি কি নিশ্চিত যে ফর্মটি সাফ করতে চান?')) {
        document.getElementById('consultationForm').reset();
    }
}

// Auto-fill preferred date with tomorrow if not set
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('preferredDate');
    if (!dateInput.value) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        dateInput.value = tomorrow.toISOString().split('T')[0];
    }
});
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>