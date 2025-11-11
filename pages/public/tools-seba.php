<?php
$pageTitle = "টুলসেবা";
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="header-content">
            <div class="header-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <rect x="12" y="12" width="40" height="40" rx="8" fill="url(#toolGradient)" stroke="white" stroke-width="2"/>
                    <path d="M24 32L32 24L40 32L32 40L24 32Z" fill="white"/>
                    <circle cx="32" cy="32" r="4" fill="url(#toolGradient)"/>
                    <defs>
                        <linearGradient id="toolGradient" x1="0" y1="0" x2="64" y2="64">
                            <stop offset="0%" style="stop-color:#00BCD4"/>
                            <stop offset="100%" style="stop-color:#4CAF50"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="header-text">
                <h1>টুলসেবা</h1>
                <p>মৎস্য চাষে প্রয়োজনীয় সকল টুল ও সেবার তালিকা এবং অর্ডার করার সুবিধা</p>
            </div>
        </div>
    </div>
</section>

<!-- Service Categories Section -->
<section class="service-categories">
    <div class="container">
        <div class="categories-grid">
            
            <!-- ক্যাটাগরি ১: পানি পরীক্ষার যন্ত্র -->
            <div class="category-card glass-card">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#2196F3" opacity="0.2"/>
                        <circle cx="24" cy="24" r="16" fill="#2196F3"/>
                        <path d="M18 22L22 26L30 18" stroke="white" stroke-width="2"/>
                        <path d="M24 16V26" stroke="white" stroke-width="2"/>
                    </svg>
                </div>
                <h3>পানি পরীক্ষার যন্ত্র</h3>
                <p>পিএইচ, অক্সিজেন, তাপমাত্রা মাপার যন্ত্র</p>
                <span class="item-count">১৫টি টুল</span>
            </div>

            <!-- ক্যাটাগরি ২: খাবার সরবরাহ -->
            <div class="category-card glass-card">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#4CAF50" opacity="0.2"/>
                        <rect x="16" y="20" width="16" height="8" rx="2" fill="#4CAF50"/>
                        <path d="M16 20L12 16L36 16L32 20Z" fill="#4CAF50"/>
                        <circle cx="20" cy="24" r="2" fill="white"/>
                        <circle cx="28" cy="24" r="2" fill="white"/>
                    </svg>
                </div>
                <h3>খাবার সরবরাহ</h3>
                <p>মাছের খাবার, সাপ্লিমেন্ট, ভিটামিন</p>
                <span class="item-count">২৫টি পণ্য</span>
            </div>

            <!-- ক্যাটাগরি ৩: ওষুধ ও চিকিৎসা -->
            <div class="category-card glass-card">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#F44336" opacity="0.2"/>
                        <rect x="20" y="12" width="8" height="24" rx="4" fill="#F44336"/>
                        <rect x="12" y="20" width="24" height="8" rx="4" fill="#F44336"/>
                    </svg>
                </div>
                <h3>ওষুধ ও চিকিৎসা</h3>
                <p>মাছের রোগের ওষুধ, প্রতিরোধমূলক সেবা</p>
                <span class="item-count">২০টি ওষুধ</span>
            </div>

            <!-- ক্যাটাগরি ৪: পুকুর নির্মাণ -->
            <div class="category-card glass-card">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#FF9800" opacity="0.2"/>
                        <rect x="14" y="20" width="20" height="16" rx="2" fill="#FF9800"/>
                        <path d="M20 20V16H28V20" fill="#FF9800"/>
                        <circle cx="24" cy="18" r="2" fill="white"/>
                    </svg>
                </div>
                <h3>পুকুর নির্মাণ</h3>
                <p>পুকুর খনন, নির্মাণ, সম্প্রসারণ সেবা</p>
                <span class="item-count">৮টি সেবা</span>
            </div>

            <!-- ক্যাটাগরি ৫: বীজ সরবরাহ -->
            <div class="category-card glass-card">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#9C27B0" opacity="0.2"/>
                        <ellipse cx="24" cy="26" rx="12" ry="8" fill="#9C27B0"/>
                        <circle cx="18" cy="24" r="2" fill="white"/>
                        <circle cx="24" cy="22" r="2" fill="white"/>
                        <circle cx="30" cy="24" r="2" fill="white"/>
                    </svg>
                </div>
                <h3>বীজ সরবরাহ</h3>
                <p>বিভিন্ন প্রজাতির মাছের বীজ/পোনা</p>
                <span class="item-count">১২টি প্রজাতি</span>
            </div>

            <!-- ক্যাটাগরি ৬: পরিষেবা -->
            <div class="category-card glass-card">
                <div class="category-icon">
                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="20" fill="#607D8B" opacity="0.2"/>
                        <path d="M24 12C18.48 12 14 16.48 14 22C14 27.52 18.48 32 24 32C29.52 32 34 27.52 34 22C34 16.48 29.52 12 24 12Z" fill="#607D8B"/>
                        <path d="M24 20C22.34 20 21 21.34 21 23V27C21 28.66 22.34 30 24 30C25.66 30 27 28.66 27 27V23C27 21.34 25.66 20 24 20Z" fill="white"/>
                    </svg>
                </div>
                <h3>পরামর্শ সেবা</h3>
                <p>বিশেষজ্ঞ পরামর্শ, প্রশিক্ষণ, পরামর্শ</p>
                <span class="item-count">৬টি সেবা</span>
            </div>

        </div>
    </div>
</section>

<!-- Featured Tools Section -->
<section class="featured-tools">
    <div class="container">
        <div class="section-header">
            <h2>জনপ্রিয় টুল ও সেবা</h2>
            <p>সবচেয়ে বেশি ব্যবহৃত ও অনুরোধকৃত টুলসমূহ</p>
        </div>

        <div class="tools-grid">
            
            <!-- টুল ১: pH মিটার -->
            <div class="tool-card glass-card">
                <div class="tool-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="20" y="40" width="80" height="30" rx="15" fill="url(#phMeterGradient)"/>
                        <rect x="30" y="35" width="60" height="15" rx="8" fill="white"/>
                        <circle cx="40" cy="55" r="8" fill="#2196F3"/>
                        <rect x="75" y="30" width="15" height="40" rx="7" fill="#607D8B"/>
                        <circle cx="82.5" cy="50" r="6" fill="#E0F2F1"/>
                        <path d="M76 35H89" stroke="#607D8B" stroke-width="3"/>
                        <defs>
                            <linearGradient id="phMeterGradient" x1="0" y1="0" x2="120" y2="80">
                                <stop offset="0%" style="stop-color:#2196F3"/>
                                <stop offset="100%" style="stop-color:#03A9F4"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="tool-info">
                    <h4>pH মিটার ডিজিটাল</h4>
                    <p>সঠিকভাবে পানির পিএইচ মাপার জন্য</p>
                    <div class="tool-features">
                        <span class="feature">স্বয়ংক্রিয় ক্যালিব্রেশন</span>
                        <span class="feature">ডিজিটাল ডিসপ্লে</span>
                        <span class="feature">১ বছর গ্যারান্টি</span>
                    </div>
                    <div class="tool-pricing">
                        <div class="price-info">
                            <span class="price">২,৫০০</span>
                            <span class="unit">টাকা</span>
                        </div>
                        <div class="pricing-details">
                            <span class="daily-rate">দৈনিক: ১০০ টাকা</span>
                            <span class="monthly-rate">মাসিক: ১,৫০০ টাকা</span>
                        </div>
                    </div>
                    <div class="tool-actions">
                        <button class="btn-rent" onclick="rentTool(1)">ভাড়া নিন</button>
                        <button class="btn-buy" onclick="buyTool(1)">কিনুন</button>
                    </div>
                </div>
            </div>

            <!-- টুল ২: অক্সিজেন মিটার -->
            <div class="tool-card glass-card">
                <div class="tool-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="25" y="30" width="70" height="25" rx="12" fill="url(#oxygenMeterGradient)"/>
                        <circle cx="45" cy="42" r="8" fill="#2196F3"/>
                        <circle cx="75" cy="42" r="8" fill="#4CAF50"/>
                        <rect x="35" y="55" width="50" height="3" rx="2" fill="white"/>
                        <circle cx="60" cy="25" r="6" fill="#FF9800"/>
                        <path d="M60 19V31" stroke="#FF9800" stroke-width="3"/>
                        <defs>
                            <linearGradient id="oxygenMeterGradient" x1="0" y1="0" x2="120" y2="80">
                                <stop offset="0%" style="stop-color:#2196F3"/>
                                <stop offset="100%" style="stop-color:#4CAF50"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="tool-info">
                    <h4>অক্সিজেন মিটার</h4>
                    <p>পানিতে অক্সিজেনের পরিমাণ সঠিকভাবে মাপুন</p>
                    <div class="tool-features">
                        <span class="feature">রিয়েল টাইম মনিটরিং</span>
                        <span class="feature">অ্যালার্ম সিস্টেম</span>
                        <span class="feature">ওয়াটারপ্রুফ</span>
                    </div>
                    <div class="tool-pricing">
                        <div class="price-info">
                            <span class="price">৪,০০০</span>
                            <span class="unit">টাকা</span>
                        </div>
                        <div class="pricing-details">
                            <span class="daily-rate">দৈনিক: ১৫০ টাকা</span>
                            <span class="monthly-rate">মাসিক: ২,৫০০ টাকা</span>
                        </div>
                    </div>
                    <div class="tool-actions">
                        <button class="btn-rent" onclick="rentTool(2)">ভাড়া নিন</button>
                        <button class="btn-buy" onclick="buyTool(2)">কিনুন</button>
                    </div>
                </div>
            </div>

            <!-- টুল ৩: মাছের খাবার ডিসপেন্সার -->
            <div class="tool-card glass-card">
                <div class="tool-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="40" y="20" width="40" height="50" rx="5" fill="url(#feederGradient)"/>
                        <rect x="45" y="25" width="30" height="35" rx="3" fill="white"/>
                        <circle cx="60" cy="45" r="8" fill="#4CAF50"/>
                        <path d="M60 37V53" stroke="white" stroke-width="2"/>
                        <circle cx="60" cy="45" r="3" fill="white"/>
                        <rect x="50" y="15" width="20" height="10" rx="3" fill="#607D8B"/>
                        <defs>
                            <linearGradient id="feederGradient" x1="0" y1="0" x2="120" y2="80">
                                <stop offset="0%" style="stop-color:#4CAF50"/>
                                <stop offset="100%" style="stop-color:#8BC34A"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="tool-info">
                    <h4>অটোমেটিক ফিডার</h4>
                    <p>নির্দিষ্ট সময়ে সঠিক পরিমাণ খাবার দেওয়ার যন্ত্র</p>
                    <div class="tool-features">
                        <span class="feature">টাইমার সেটিং</span>
                        <span class="feature">পরিমাণ নিয়ন্ত্রণ</span>
                        <span class="feature">সোলার পাওয়ার</span>
                    </div>
                    <div class="tool-pricing">
                        <div class="price-info">
                            <span class="price">৮,০০০</span>
                            <span class="unit">টাকা</span>
                        </div>
                        <div class="pricing-details">
                            <span class="daily-rate">দৈনিক: ২০০ টাকা</span>
                            <span class="monthly-rate">মাসিক: ৪,০০০ টাকা</span>
                        </div>
                    </div>
                    <div class="tool-actions">
                        <button class="btn-rent" onclick="rentTool(3)">ভাড়া নিন</button>
                        <button class="btn-buy" onclick="buyTool(3)">কিনুন</button>
                    </div>
                </div>
            </div>

            <!-- টুল ৪: তাপমাত্রা মিটার -->
            <div class="tool-card glass-card">
                <div class="tool-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="50" y="15" width="20" height="50" rx="10" fill="url(#tempMeterGradient)"/>
                        <rect x="55" y="20" width="10" height="40" rx="5" fill="#E3F2FD"/>
                        <rect x="55" y="40" width="10" height="20" rx="2" fill="#F44336"/>
                        <circle cx="60" cy="70" r="12" fill="url(#tempMeterGradient)"/>
                        <circle cx="60" cy="70" r="8" fill="white"/>
                        <path d="M60 62V78" stroke="#F44336" stroke-width="3"/>
                        <defs>
                            <linearGradient id="tempMeterGradient" x1="0" y1="0" x2="120" y2="80">
                                <stop offset="0%" style="stop-color:#2196F3"/>
                                <stop offset="100%" style="stop-color:#F44336"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="tool-info">
                    <h4>ডিজিটাল থার্মোমিটার</h4>
                    <p>পানির তাপমাত্রা সঠিকভাবে মাপার জন্য</p>
                    <div class="tool-features">
                        <span class="feature">দ্রুত পাঠ</span>
                        <span class="feature">LCD ডিসপ্লে</span>
                        <span class="feature">ওয়াটারপ্রুফ প্রোব</span>
                    </div>
                    <div class="tool-pricing">
                        <div class="price-info">
                            <span class="price">১,৫০০</span>
                            <span class="unit">টাকা</span>
                        </div>
                        <div class="pricing-details">
                            <span class="daily-rate">দৈনিক: ৫০ টাকা</span>
                            <span class="monthly-rate">মাসিক: ৮০০ টাকা</span>
                        </div>
                    </div>
                    <div class="tool-actions">
                        <button class="btn-rent" onclick="rentTool(4)">ভাড়া নিন</button>
                        <button class="btn-buy" onclick="buyTool(4)">কিনুন</button>
                    </div>
                </div>
            </div>

            <!-- টুল ৫: নেট ও ট্র্যাপ -->
            <div class="tool-card glass-card">
                <div class="tool-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <circle cx="30" cy="40" r="20" fill="none" stroke="#8D6E63" stroke-width="3"/>
                        <circle cx="30" cy="40" r="15" fill="none" stroke="#8D6E63" stroke-width="2"/>
                        <circle cx="30" cy="40" r="10" fill="none" stroke="#8D6E63" stroke-width="2"/>
                        <circle cx="30" cy="40" r="5" fill="none" stroke="#8D6E63" stroke-width="2"/>
                        <rect x="70" y="30" width="30" height="20" rx="3" fill="#BCAAA4"/>
                        <path d="M75 35L85 35M75 40L85 40M75 45L85 45" stroke="white" stroke-width="2"/>
                        <rect x="75" y="25" width="20" height="8" rx="2" fill="#8D6E63"/>
                        <defs>
                            <linearGradient id="netGradient" x1="0" y1="0" x2="120" y2="80">
                                <stop offset="0%" style="stop-color:#8D6E63"/>
                                <stop offset="100%" style="stop-color:#BCAAA4"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="tool-info">
                    <h4>ফিশিং নেট ও ট্র্যাপ</h4>
                    <p>মাছ ধরার বিভিন্ন ধরনের নেট ও ফাঁদ</p>
                    <div class="tool-features">
                        <span class="feature">বিভিন্ন সাইজ</span>
                        <span class="feature">দৃঢ় নেট</span>
                        <span class="feature">সহজ ব্যবহার</span>
                    </div>
                    <div class="tool-pricing">
                        <div class="price-info">
                            <span class="price">৩,০০০</span>
                            <span class="unit">টাকা/সেট</span>
                        </div>
                        <div class="pricing-details">
                            <span class="daily-rate">দৈনিক: ১২০ টাকা</span>
                            <span class="monthly-rate">মাসিক: ২,০০০ টাকা</span>
                        </div>
                    </div>
                    <div class="tool-actions">
                        <button class="btn-rent" onclick="rentTool(5)">ভাড়া নিন</button>
                        <button class="btn-buy" onclick="buyTool(5)">কিনুন</button>
                    </div>
                </div>
            </div>

            <!-- টুল ৬: ওয়াটার পাম্প -->
            <div class="tool-card glass-card">
                <div class="tool-image">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <rect x="35" y="35" width="30" height="25" rx="5" fill="url(#pumpGradient)"/>
                        <rect x="40" y="40" width="20" height="10" rx="3" fill="white"/>
                        <circle cx="50" cy="25" r="8" fill="url(#pumpGradient)"/>
                        <circle cx="50" cy="25" r="5" fill="white"/>
                        <path d="M65 47L85 35L85 55L65 47Z" fill="#607D8B"/>
                        <circle cx="75" cy="47" r="3" fill="white"/>
                        <path d="M70 20L80 15L85 25L75 30Z" fill="#607D8B"/>
                        <defs>
                            <linearGradient id="pumpGradient" x1="0" y1="0" x2="120" y2="80">
                                <stop offset="0%" style="stop-color:#607D8B"/>
                                <stop offset="100%" style="stop-color:#78909C"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="tool-info">
                    <h4>ওয়াটার পাম্প</h4>
                    <p>পানি পরিবর্তন ও সঞ্চালনের জন্য শক্তিশালী পাম্প</p>
                    <div class="tool-features">
                        <span class="feature">উচ্চ ক্ষমতা</span>
                        <span class="feature">শক্তিসাশক মোটর</span>
                        <span class="feature">দীর্ঘ স্থায়িত্ব</span>
                    </div>
                    <div class="tool-pricing">
                        <div class="price-info">
                            <span class="price">১২,০০০</span>
                            <span class="unit">টাকা</span>
                        </div>
                        <div class="pricing-details">
                            <span class="daily-rate">দৈনিক: ৩০০ টাকা</span>
                            <span class="monthly-rate">মাসিক: ৮,০০০ টাকা</span>
                        </div>
                    </div>
                    <div class="tool-actions">
                        <button class="btn-rent" onclick="rentTool(6)">ভাড়া নিন</button>
                        <button class="btn-buy" onclick="buyTool(6)">কিনুন</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Service Request Section -->
<section class="service-request">
    <div class="container">
        <div class="glass-card service-form-card">
            <div class="form-header">
                <h3>সেবা অর্ডার করুন</h3>
                <p>আপনার প্রয়োজনীয় টুল বা সেবার জন্য অর্ডার করুন, আমরা সরবরাহ করব</p>
            </div>
            
            <form class="service-order-form" id="serviceOrderForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="customerName">আপনার নাম</label>
                        <input type="text" id="customerName" name="name" required placeholder="সম্পূর্ণ নাম">
                    </div>
                    <div class="form-group">
                        <label for="customerPhone">ফোন নম্বর</label>
                        <input type="tel" id="customerPhone" name="phone" required placeholder="০১XXXXXXXXX">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="serviceType">সেবার ধরন</label>
                        <select id="serviceType" name="serviceType" required>
                            <option value="">সেবার ধরন নির্বাচন করুন</option>
                            <option value="ভাড়া">টুল ভাড়া</option>
                            <option value="ক্রয়">টুল ক্রয়</option>
                            <option value="সেবা">পরিষেবা</option>
                            <option value="পরামর্শ">পরামর্শ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="serviceCategory">ক্যাটাগরি</label>
                        <select id="serviceCategory" name="category" required>
                            <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                            <option value="পানি-পরীক্ষা">পানি পরীক্ষার যন্ত্র</option>
                            <option value="খাবার">খাবার সরবরাহ</option>
                            <option value="ওষুধ">ওষুধ ও চিকিৎসা</option>
                            <option value="পুকুর-নির্মাণ">পুকুর নির্মাণ</option>
                            <option value="বীজ">বীজ সরবরাহ</option>
                            <option value="পরামর্শ">পরামর্শ সেবা</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="specificTool">নির্দিষ্ট টুল/সেবা</label>
                        <input type="text" id="specificTool" name="tool" placeholder="টুল বা সেবার নাম">
                    </div>
                    <div class="form-group">
                        <label for="duration">সময়কাল</label>
                        <select id="duration" name="duration">
                            <option value="একদিন">একদিন</option>
                            <option value="একসপ্তাহ">একসপ্তাহ</option>
                            <option value="একমাস">একমাস</option>
                            <option value="তিনমাস">তিনমাস</option>
                            <option value="ছয়মাস">ছয়মাস</option>
                            <option value="একবছর">একবছর</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="deliveryLocation">সরবরাহের স্থান</label>
                        <input type="text" id="deliveryLocation" name="location" required placeholder="সম্পূর্ণ ঠিকানা">
                    </div>
                    <div class="form-group">
                        <label for="quantity">পরিমাণ</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="additionalInfo">অতিরিক্ত তথ্য</label>
                    <textarea id="additionalInfo" name="info" rows="4" placeholder="আপনার প্রয়োজনীয়তার বিস্তারিত বিবরণ লিখুন..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="preferredTime">পছন্দের সময়</label>
                    <select id="preferredTime" name="preferredTime">
                        <option value="সকাল">সকাল (৯টা - ১২টা)</option>
                        <option value="দুপুর">দুপুর (১২টা - ৩টা)</option>
                        <option value="বিকেল">বিকেল (৩টা - ৬টা)</option>
                        <option value="সন্ধ্যা">সন্ধ্যা (৬টা - ৯টা)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="urgentDelivery" name="urgent">
                        <span class="checkmark"></span>
                        জরুরি ডেলিভারি প্রয়োজন (অতিরিক্ত চার্জ লাগবে)
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-glass" onclick="clearServiceForm()">সাফ করুন</button>
                    <button type="submit" class="btn-primary">অর্ডার করুন</button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.service-categories {
    padding: var(--space-8) 0;
    background: var(--bg-primary);
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-6);
}

.category-card {
    padding: var(--space-6);
    text-align: center;
    transition: all var(--duration-normal) var(--easing-smooth);
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
    font-size: var(--text-sm);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.category-card p {
    font-size: 14px;
    color: var(--color-neutral-600);
    margin-bottom: var(--space-3);
    line-height: var(--line-height-relaxed);
}

.item-count {
    display: inline-block;
    padding: 6px 12px;
    background: var(--color-primary-50);
    color: var(--color-primary-700);
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: var(--weight-medium);
}

.featured-tools {
    padding: var(--space-8) 0;
    background: var(--bg-dashboard);
}

.tools-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: var(--space-6);
}

.tool-card {
    padding: var(--space-6);
    transition: all var(--duration-normal) var(--easing-smooth);
}

.tool-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-glass-lg);
}

.tool-image {
    height: 100px;
    margin-bottom: var(--space-4);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-neutral-50);
    border-radius: var(--radius-md);
}

.tool-info h4 {
    font-size: 16px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.tool-info p {
    font-size: 14px;
    color: var(--color-neutral-600);
    margin-bottom: var(--space-3);
    line-height: var(--line-height-relaxed);
}

.tool-features {
    display: flex;
    flex-wrap: wrap;
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

.tool-pricing {
    background: rgba(255, 255, 255, 0.3);
    padding: var(--space-4);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-4);
}

.price-info {
    display: flex;
    align-items: baseline;
    gap: var(--space-1);
    margin-bottom: var(--space-2);
}

.price {
    font-size: 24px;
    font-weight: var(--weight-bold);
    color: var(--color-primary-700);
}

.unit {
    font-size: 14px;
    color: var(--color-neutral-600);
}

.pricing-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-2);
}

.daily-rate,
.monthly-rate {
    font-size: 12px;
    color: var(--color-neutral-600);
    padding: var(--space-1) var(--space-2);
    background: var(--color-neutral-50);
    border-radius: var(--radius-sm);
}

.tool-actions {
    display: flex;
    gap: var(--space-2);
}

.btn-rent,
.btn-buy {
    flex: 1;
    padding: var(--space-3);
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: var(--weight-medium);
    border: none;
    cursor: pointer;
    transition: all var(--duration-fast) var(--easing-default);
}

.btn-rent {
    background: var(--color-glass-white);
    color: var(--color-neutral-700);
    border: 1px solid var(--color-glass-border);
}

.btn-rent:hover {
    background: rgba(255, 255, 255, 0.6);
    border-color: var(--color-primary-300);
}

.btn-buy {
    background: var(--color-primary-500);
    color: white;
}

.btn-buy:hover {
    background: var(--color-primary-600);
    transform: translateY(-1px);
}

.service-request {
    padding: var(--space-8) 0;
}

.service-form-card {
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

.service-order-form {
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
    .categories-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .tools-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: var(--space-3);
    }
    
    .form-actions {
        flex-direction: column;
        gap: var(--space-2);
    }
    
    .pricing-details {
        grid-template-columns: 1fr;
        gap: var(--space-1);
    }
}
</style>

<script>
// Tool action functions
function rentTool(id) {
    alert('টুল ' + id + ' ভাড়ার জন্য অর্ডার করা হচ্ছে...');
}

function buyTool(id) {
    alert('টুল ' + id + ' ক্রয়ের জন্য অর্ডার করা হচ্ছে...');
}

// Service order form handling
document.getElementById('serviceOrderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simulate form submission
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Show success message (in real implementation, this would submit to server)
    alert('আপনার অর্ডারটি সফলভাবে পাঠানো হয়েছে। আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব!');
    
    // Reset form
    this.reset();
});

function clearServiceForm() {
    if (confirm('আপনি কি নিশ্চিত যে ফর্মটি সাফ করতে চান?')) {
        document.getElementById('serviceOrderForm').reset();
    }
}

// Category card interaction
document.addEventListener('DOMContentLoaded', function() {
    const categoryCards = document.querySelectorAll('.category-card');
    
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const categoryName = this.querySelector('h3').textContent;
            const categorySelect = document.getElementById('serviceCategory');
            
            // Update service category select based on clicked category
            const categoryMap = {
                'পানি পরীক্ষার যন্ত্র': 'পানি-পরীক্ষা',
                'খাবার সরবরাহ': 'খাবার',
                'ওষুধ ও চিকিৎসা': 'ওষুধ',
                'পুকুর নির্মাণ': 'পুকুর-নির্মাণ',
                'বীজ সরবরাহ': 'বীজ',
                'পরামর্শ সেবা': 'পরামর্শ'
            };
            
            if (categoryMap[categoryName]) {
                categorySelect.value = categoryMap[categoryName];
                
                // Scroll to service request form
                document.querySelector('.service-request').scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>