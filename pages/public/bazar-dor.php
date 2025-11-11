<?php
$pageTitle = "বাজার দর";
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="header-content">
            <div class="header-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <rect x="8" y="16" width="48" height="32" rx="4" fill="url(#marketGradient)" stroke="white" stroke-width="2"/>
                    <path d="M12 24H52M12 30H52M12 36H52M16 24L20 28L24 24L28 28L32 24L36 28L40 24L44 28L48 24" stroke="white" stroke-width="2"/>
                    <rect x="28" y="8" width="8" height="8" rx="2" fill="white"/>
                    <rect x="30" y="4" width="4" height="4" rx="1" fill="white"/>
                    <defs>
                        <linearGradient id="marketGradient" x1="0" y1="0" x2="64" y2="64">
                            <stop offset="0%" style="stop-color:#00BCD4"/>
                            <stop offset="100%" style="stop-color:#4CAF50"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="header-text">
                <h1>বাজার দর</h1>
                <p>মৎস্য বাজারের সর্বশেষ দাম, ট্রেন্ড ও ভবিষ্যতের পূর্বাভাস</p>
            </div>
        </div>
    </div>
</section>

<!-- Current Prices Section -->
<section class="current-prices">
    <div class="container">
        <div class="prices-summary">
            <div class="summary-card glass-card">
                <div class="summary-icon">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path d="M16 4L20 12H28L22 18L24 26L16 22L8 26L10 18L4 12H12L16 4Z" fill="#4CAF50"/>
                    </svg>
                </div>
                <div class="summary-info">
                    <h3>বর্তমান বাজার দর</h3>
                    <p>আজকের সবচেয়ে সাম্প্রতিক দাম</p>
                </div>
                <div class="summary-time">
                    <span>৪ নভেম্বর ২০২৫</span>
                    <span>সকাল ৯:০০</span>
                </div>
            </div>
        </div>

        <div class="price-categories">
            <div class="category-tabs">
                <button class="tab-btn active" data-category="all">সব মাছ</button>
                <button class="tab-btn" data-category="freshwater">মিঠা পানির মাছ</button>
                <button class="tab-btn" data-category="marine">সামুদ্রিক মাছ</button>
                <button class="tab-btn" data-category="prawn">চিংড়ি</button>
                <button class="tab-btn" data-category="small-fish">ছোট মাছ</button>
            </div>
        </div>

        <div class="prices-grid">
            
            <!-- মাছের দাম ১: রুই -->
            <div class="price-card glass-card" data-category="freshwater">
                <div class="price-header">
                    <div class="fish-info">
                        <h3>রুই</h3>
                        <span class="fish-size">৩-৫ কেজি</span>
                    </div>
                    <div class="trend-indicator">
                        <span class="trend up">↗ +৫%</span>
                    </div>
                </div>
                <div class="price-main">
                    <div class="current-price">
                        <span class="price">৪২৫</span>
                        <span class="currency">টাকা/কেজি</span>
                    </div>
                    <div class="price-change">
                        <span class="change today">আজ: +১৫ টাকা</span>
                        <span class="change week">সপ্তাহ: +২৫ টাকা</span>
                    </div>
                </div>
                <div class="price-chart">
                    <div class="chart-placeholder">
                        <svg width="100%" height="40" viewBox="0 0 200 40">
                            <polyline points="0,30 20,25 40,28 60,22 80,18 100,20 120,15 140,12 160,10 180,8 200,5" 
                                      fill="none" stroke="#4CAF50" stroke-width="2"/>
                            <circle cx="200" cy="5" r="3" fill="#4CAF50"/>
                        </svg>
                    </div>
                </div>
                <div class="price-details">
                    <div class="detail-row">
                        <span>গত মাস:</span>
                        <span>৪০০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>গত বছর:</span>
                        <span>৩৫০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>সর্বোচ্চ এই মাস:</span>
                        <span>৪৩০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- মাছের দাম ২: কাতলা -->
            <div class="price-card glass-card" data-category="freshwater">
                <div class="price-header">
                    <div class="fish-info">
                        <h3>কাতলা</h3>
                        <span class="fish-size">৪-৬ কেজি</span>
                    </div>
                    <div class="trend-indicator">
                        <span class="trend down">↘ -৩%</span>
                    </div>
                </div>
                <div class="price-main">
                    <div class="current-price">
                        <span class="price">৪৭৫</span>
                        <span class="currency">টাকা/কেজি</span>
                    </div>
                    <div class="price-change">
                        <span class="change today">আজ: -১০ টাকা</span>
                        <span class="change week">সপ্তাহ: +৫ টাকা</span>
                    </div>
                </div>
                <div class="price-chart">
                    <div class="chart-placeholder">
                        <svg width="100%" height="40" viewBox="0 0 200 40">
                            <polyline points="0,8 20,10 40,12 60,15 80,18 100,20 120,25 140,28 160,30 180,32 200,35" 
                                      fill="none" stroke="#F44336" stroke-width="2"/>
                            <circle cx="200" cy="35" r="3" fill="#F44336"/>
                        </svg>
                    </div>
                </div>
                <div class="price-details">
                    <div class="detail-row">
                        <span>গত মাস:</span>
                        <span>৪৮৫ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>গত বছর:</span>
                        <span>৪২০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>সর্বোচ্চ এই মাস:</span>
                        <span>৪৯০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- মাছের দাম ৩: ইলিশ -->
            <div class="price-card glass-card" data-category="marine">
                <div class="price-header">
                    <div class="fish-info">
                        <h3>ইলিশ</h3>
                        <span class="fish-size">১-২ কেজি</span>
                    </div>
                    <div class="trend-indicator">
                        <span class="trend up">↗ +৮%</span>
                    </div>
                </div>
                <div class="price-main">
                    <div class="current-price">
                        <span class="price">১,২৫০</span>
                        <span class="currency">টাকা/কেজি</span>
                    </div>
                    <div class="price-change">
                        <span class="change today">আজ: +৫০ টাকা</span>
                        <span class="change week">সপ্তাহ: +১০০ টাকা</span>
                    </div>
                </div>
                <div class="price-chart">
                    <div class="chart-placeholder">
                        <svg width="100%" height="40" viewBox="0 0 200 40">
                            <polyline points="0,35 20,32 40,28 60,25 80,22 100,18 120,15 140,12 160,8 180,5 200,3" 
                                      fill="none" stroke="#4CAF50" stroke-width="2"/>
                            <circle cx="200" cy="3" r="3" fill="#4CAF50"/>
                        </svg>
                    </div>
                </div>
                <div class="price-details">
                    <div class="detail-row">
                        <span>গত মাস:</span>
                        <span>১,২০০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>গত বছর:</span>
                        <span>১,০০০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>সর্বোচ্চ এই মাস:</span>
                        <span>১,৩০০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- মাছের দাম ৪: পাঙ্গাশ -->
            <div class="price-card glass-card" data-category="freshwater">
                <div class="price-header">
                    <div class="fish-info">
                        <h3>পাঙ্গাশ</h3>
                        <span class="fish-size">২-৩ কেজি</span>
                    </div>
                    <div class="trend-indicator">
                        <span class="trend stable">→ স্থিতিশীল</span>
                    </div>
                </div>
                <div class="price-main">
                    <div class="current-price">
                        <span class="price">৩২৫</span>
                        <span class="currency">টাকা/কেজি</span>
                    </div>
                    <div class="price-change">
                        <span class="change today">আজ: সমান</span>
                        <span class="change week">সপ্তাহ: +৫ টাকা</span>
                    </div>
                </div>
                <div class="price-chart">
                    <div class="chart-placeholder">
                        <svg width="100%" height="40" viewBox="0 0 200 40">
                            <polyline points="0,20 20,22 40,18 60,21 80,19 100,20 120,19 140,21 160,18 180,20 200,19" 
                                      fill="none" stroke="#2196F3" stroke-width="2"/>
                            <circle cx="200" cy="19" r="3" fill="#2196F3"/>
                        </svg>
                    </div>
                </div>
                <div class="price-details">
                    <div class="detail-row">
                        <span>গত মাস:</span>
                        <span>৩২০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>গত বছর:</span>
                        <span>২৮০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>সর্বোচ্চ এই মাস:</span>
                        <span>৩৩০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- মাছের দাম ৫: বাগদাশাক -->
            <div class="price-card glass-card" data-category="prawn">
                <div class="price-header">
                    <div class="fish-info">
                        <h3>বাগদাশাক</h3>
                        <span class="fish-size">৫০-৮০ গ্রাম</span>
                    </div>
                    <div class="trend-indicator">
                        <span class="trend up">↗ +১২%</span>
                    </div>
                </div>
                <div class="price-main">
                    <div class="current-price">
                        <span class="price">৭২৫</span>
                        <span class="currency">টাকা/কেজি</span>
                    </div>
                    <div class="price-change">
                        <span class="change today">আজ: +৫০ টাকা</span>
                        <span class="change week">সপ্তাহ: +৭৫ টাকা</span>
                    </div>
                </div>
                <div class="price-chart">
                    <div class="chart-placeholder">
                        <svg width="100%" height="40" viewBox="0 0 200 40">
                            <polyline points="0,32 20,28 40,30 60,25 80,22 100,18 120,15 140,12 160,8 180,5 200,3" 
                                      fill="none" stroke="#4CAF50" stroke-width="2"/>
                            <circle cx="200" cy="3" r="3" fill="#4CAF50"/>
                        </svg>
                    </div>
                </div>
                <div class="price-details">
                    <div class="detail-row">
                        <span>গত মাস:</span>
                        <span>৭০০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>গত বছর:</span>
                        <span>৬০০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>সর্বোচ্চ এই মাস:</span>
                        <span>৭৫০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- মাছের দাম ৬: পুটি -->
            <div class="price-card glass-card" data-category="small-fish">
                <div class="price-header">
                    <div class="fish-info">
                        <h3>পুটি</h3>
                        <span class="fish-size">২০-৩০ গ্রাম</span>
                    </div>
                    <div class="trend-indicator">
                        <span class="trend down">↘ -৫%</span>
                    </div>
                </div>
                <div class="price-main">
                    <div class="current-price">
                        <span class="price">২৮০</span>
                        <span class="currency">টাকা/কেজি</span>
                    </div>
                    <div class="price-change">
                        <span class="change today">আজ: -১০ টাকা</span>
                        <span class="change week">সপ্তাহ: -৫ টাকা</span>
                    </div>
                </div>
                <div class="price-chart">
                    <div class="chart-placeholder">
                        <svg width="100%" height="40" viewBox="0 0 200 40">
                            <polyline points="0,12 20,15 40,18 60,22 80,25 100,28 120,30 140,32 160,35 180,37 200,38" 
                                      fill="none" stroke="#F44336" stroke-width="2"/>
                            <circle cx="200" cy="38" r="3" fill="#F44336"/>
                        </svg>
                    </div>
                </div>
                <div class="price-details">
                    <div class="detail-row">
                        <span>গত মাস:</span>
                        <span>২৯০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>গত বছর:</span>
                        <span>২৪০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>সর্বোচ্চ এই মাস:</span>
                        <span>৩০০ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- মাছের দাম ৭: তেলাপিয়া -->
            <div class="price-card glass-card" data-category="freshwater">
                <div class="price-header">
                    <div class="fish-info">
                        <h3>তেলাপিয়া</h3>
                        <span class="fish-size">১-১.৫ কেজি</span>
                    </div>
                    <div class="trend-indicator">
                        <span class="trend up">↗ +৭%</span>
                    </div>
                </div>
                <div class="price-main">
                    <div class="current-price">
                        <span class="price">৩৮০</span>
                        <span class="currency">টাকা/কেজি</span>
                    </div>
                    <div class="price-change">
                        <span class="change today">আজ: +২০ টাকা</span>
                        <span class="change week">সপ্তাহ: +৩০ টাকা</span>
                    </div>
                </div>
                <div class="price-chart">
                    <div class="chart-placeholder">
                        <svg width="100%" height="40" viewBox="0 0 200 40">
                            <polyline points="0,28 20,25 40,22 60,20 80,18 100,15 120,12 140,10 160,7 180,5 200,3" 
                                      fill="none" stroke="#4CAF50" stroke-width="2"/>
                            <circle cx="200" cy="3" r="3" fill="#4CAF50"/>
                        </svg>
                    </div>
                </div>
                <div class="price-details">
                    <div class="detail-row">
                        <span>গত মাস:</span>
                        <span>৩৭০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>গত বছর:</span>
                        <span>৩২০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>সর্বোচ্চ এই মাস:</span>
                        <span>৩৮৫ টাকা</span>
                    </div>
                </div>
            </div>

            <!-- মাছের দাম ৮: ভেজিল মাছ -->
            <div class="price-card glass-card" data-category="marine">
                <div class="price-header">
                    <div class="fish-info">
                        <h3>ভেজিল মাছ</h3>
                        <span class="fish-size">২-৪ কেজি</span>
                    </div>
                    <div class="trend-indicator">
                        <span class="trend stable">→ স্থিতিশীল</span>
                    </div>
                </div>
                <div class="price-main">
                    <div class="current-price">
                        <span class="price">৫৫০</span>
                        <span class="currency">টাকা/কেজি</span>
                    </div>
                    <div class="price-change">
                        <span class="change today">আজ: সমান</span>
                        <span class="change week">সপ্তাহ: +১০ টাকা</span>
                    </div>
                </div>
                <div class="price-chart">
                    <div class="chart-placeholder">
                        <svg width="100%" height="40" viewBox="0 0 200 40">
                            <polyline points="0,22 20,24 40,21 60,23 80,22 100,21 120,22 140,24 160,20 180,21 200,22" 
                                      fill="none" stroke="#2196F3" stroke-width="2"/>
                            <circle cx="200" cy="22" r="3" fill="#2196F3"/>
                        </svg>
                    </div>
                </div>
                <div class="price-details">
                    <div class="detail-row">
                        <span>গত মাস:</span>
                        <span>৫৪৫ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>গত বছর:</span>
                        <span>৪৮০ টাকা</span>
                    </div>
                    <div class="detail-row">
                        <span>সর্বোচ্চ এই মাস:</span>
                        <span>৫৬০ টাকা</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Market Analysis Section -->
<section class="market-analysis">
    <div class="container">
        <div class="section-header">
            <h2>বাজার বিশ্লেষণ</h2>
            <p>বাজারের ট্রেন্ড ও পূর্বাভাস</p>
        </div>

        <div class="analysis-grid">
            
            <!-- বাজার সারসংক্ষেপ -->
            <div class="analysis-card glass-card">
                <h3>বাজার সারসংক্ষেপ</h3>
                <div class="summary-stats">
                    <div class="stat-item">
                        <span class="stat-label">আজকের গড় দাম:</span>
                        <span class="stat-value">৫৪৫ টাকা</span>
                        <span class="stat-change positive">+২.৫%</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">আজকের ট্রেড ভলিউম:</span>
                        <span class="stat-value">১,২৪৫ টন</span>
                        <span class="stat-change positive">+৫.৮%</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">আজকের সবচেয়ে বেশি দাম:</span>
                        <span class="stat-value">১,২৫০ টাকা</span>
                        <span class="stat-change neutral">(ইলিশ)</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">আজকের সবচেয়ে কম দাম:</span>
                        <span class="stat-value">২৮০ টাকা</span>
                        <span class="stat-change neutral">(পুটি)</span>
                    </div>
                </div>
            </div>

            <!-- ট্রেন্ড বিশ্লেষণ -->
            <div class="analysis-card glass-card">
                <h3>ট্রেন্ড বিশ্লেষণ</h3>
                <div class="trend-analysis">
                    <div class="trend-item">
                        <h4>সাপ্তাহিক ট্রেন্ড</h4>
                        <div class="trend-chart">
                            <div class="bar" style="height: 60%; background: #4CAF50;">
                                <span>৫ মাছ বেড়েছে</span>
                            </div>
                            <div class="bar" style="height: 30%; background: #F44336;">
                                <span>২ মাছ কমেছে</span>
                            </div>
                            <div class="bar" style="height: 20%; background: #2196F3;">
                                <span>১ মাছ স্থিতিশীল</span>
                            </div>
                        </div>
                    </div>
                    <div class="trend-item">
                        <h4>মাসিক ট্রেন্ড</h4>
                        <div class="trend-insights">
                            <ul>
                                <li>ইলিশ মাছে উল্লেখযোগ্য বৃদ্ধি</li>
                                <li>চিংড়ির দাম ক্রমাগত বেড়ে যাচ্ছে</li>
                                <li>রুই ও কাতলার দাম স্থিতিশীল</li>
                                <li>ছোট মাছের দাম সামান্য কমেছে</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- পূর্বাভাস -->
            <div class="analysis-card glass-card">
                <h3>ভবিষ্যতের পূর্বাভাস</h3>
                <div class="forecast-content">
                    <div class="forecast-item">
                        <h4>আগামী সপ্তাহ (৫-১১ নভেম্বর)</h4>
                        <ul>
                            <li>ইলিশ: ১,৩০০ টাকা পর্যন্ত যেতে পারে</li>
                            <li>চিংড়ি: ৮০০ টাকা ছুঁতে পারে</li>
                            <li>রুই: ৪২০-৪৫০ টাকার মধ্যে থাকবে</li>
                        </ul>
                    </div>
                    <div class="forecast-item">
                        <h4>আগামী মাস (ডিসেম্বর)</h4>
                        <ul>
                            <li>সামগ্রিকভাবে ৫-১০% বৃদ্ধির সম্ভাবনা</li>
                            <li>পরবর্তী মৌসুমের জন্য দাম বাড়তে পারে</li>
                            <li>আমদানি-রপ্তানির প্রভাব থাকতে পারে</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- বাজার প্রভাব -->
            <div class="analysis-card glass-card">
                <h3>বাজার প্রভাবিত কারণ</h3>
                <div class="impact-factors">
                    <div class="factor positive">
                        <div class="factor-icon">📈</div>
                        <div class="factor-info">
                            <h4>বৃদ্ধির কারণ</h4>
                            <ul>
                                <li>উৎসবের মরসুম</li>
                                <li>রপ্তানি বৃদ্ধি</li>
                                <li>আবহাওয়া অনুকূল</li>
                            </ul>
                        </div>
                    </div>
                    <div class="factor negative">
                        <div class="factor-icon">📉</div>
                        <div class="factor-info">
                            <h4>হ্রাসের কারণ</h4>
                            <ul>
                                <li>প্রাকৃতিক দুর্যোগ</li>
                                <li>করোনার প্রভাব</li>
                                <li>বাজার সরবরাহ বেশি</li>
                            </ul>
                        </div>
                    </div>
                    <div class="factor neutral">
                        <div class="factor-icon">⚖️</div>
                        <div class="factor-info">
                            <h4>নিরপেক্ষ প্রভাব</h4>
                            <ul>
                                <li>সরকারি নীতি</li>
                                <li>জ্বালানি তেলের দাম</li>
                                <li>পরিবহন খরচ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Regional Prices Section -->
<section class="regional-prices">
    <div class="container">
        <div class="section-header">
            <h2>আঞ্চলিক দাম</h2>
            <p>বিভিন্ন অঞ্চলের দামের তুলনা</p>
        </div>

        <div class="regions-grid">
            
            <!-- ঢাকা বাজার -->
            <div class="region-card glass-card">
                <div class="region-header">
                    <h3>ঢাকা বাজার</h3>
                    <span class="region-status">সক্রিয়</span>
                </div>
                <div class="region-stats">
                    <div class="region-stat">
                        <span>গড় দাম:</span>
                        <span class="value">৫৫০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে বেশি:</span>
                        <span class="value">১,৩০০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে কম:</span>
                        <span class="value">২৮০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>পণ্যের সংখ্যা:</span>
                        <span class="value">১৫টি</span>
                    </div>
                </div>
            </div>

            <!-- চট্টগ্রাম বাজার -->
            <div class="region-card glass-card">
                <div class="region-header">
                    <h3>চট্টগ্রাম বাজার</h3>
                    <span class="region-status">সক্রিয়</span>
                </div>
                <div class="region-stats">
                    <div class="region-stat">
                        <span>গড় দাম:</span>
                        <span class="value">৫২০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে বেশি:</span>
                        <span class="value">১,২৮০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে কম:</span>
                        <span class="value">২৭০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>পণ্যের সংখ্যা:</span>
                        <span class="value">১২টি</span>
                    </div>
                </div>
            </div>

            <!-- সিলেট বাজার -->
            <div class="region-card glass-card">
                <div class="region-header">
                    <h3>সিলেট বাজার</h3>
                    <span class="region-status">সক্রিয়</span>
                </div>
                <div class="region-stats">
                    <div class="region-stat">
                        <span>গড় দাম:</span>
                        <span class="value">৫৪০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে বেশি:</span>
                        <span class="value">১,২৫০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে কম:</span>
                        <span class="value">২৮৫ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>পণ্যের সংখ্যা:</span>
                        <span class="value">১১টি</span>
                    </div>
                </div>
            </div>

            <!-- রাজশাহী বাজার -->
            <div class="region-card glass-card">
                <div class="region-header">
                    <h3>রাজশাহী বাজার</h3>
                    <span class="region-status">সক্রিয়</span>
                </div>
                <div class="region-stats">
                    <div class="region-stat">
                        <span>গড় দাম:</span>
                        <span class="value">৫১০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে বেশি:</span>
                        <span class="value">১,২০০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে কম:</span>
                        <span class="value">২৬০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>পণ্যের সংখ্যা:</span>
                        <span class="value">১০টি</span>
                    </div>
                </div>
            </div>

            <!-- খুলনা বাজার -->
            <div class="region-card glass-card">
                <div class="region-header">
                    <h3>খুলনা বাজার</h3>
                    <span class="region-status">সক্রিয়</span>
                </div>
                <div class="region-stats">
                    <div class="region-stat">
                        <span>গড় দাম:</span>
                        <span class="value">৫৩০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে বেশি:</span>
                        <span class="value">১,২৭০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে কম:</span>
                        <span class="value">২৭৫ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>পণ্যের সংখ্যা:</span>
                        <span class="value">১৩টি</span>
                    </div>
                </div>
            </div>

            <!-- বরিশাল বাজার -->
            <div class="region-card glass-card">
                <div class="region-header">
                    <h3>বরিশাল বাজার</h3>
                    <span class="region-status">সক্রিয়</span>
                </div>
                <div class="region-stats">
                    <div class="region-stat">
                        <span>গড় দাম:</span>
                        <span class="value">৫২৫ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে বেশি:</span>
                        <span class="value">১,২৪০ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>সবচেয়ে কম:</span>
                        <span class="value">২৬৮ টাকা</span>
                    </div>
                    <div class="region-stat">
                        <span>পণ্যের সংখ্যা:</span>
                        <span class="value">১৪টি</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
.current-prices {
    padding: var(--space-8) 0;
    background: var(--bg-primary);
}

.prices-summary {
    margin-bottom: var(--space-6);
}

.summary-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: var(--space-6);
    background: var(--color-glass-white);
}

.summary-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--radius-full);
    background: var(--color-secondary-50);
    display: flex;
    align-items: center;
    justify-content: center;
}

.summary-info h3 {
    font-size: var(--text-sm);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-1);
}

.summary-info p {
    font-size: 14px;
    color: var(--color-neutral-600);
    margin: 0;
}

.summary-time {
    text-align: right;
}

.summary-time span {
    display: block;
    font-size: 14px;
    color: var(--color-neutral-700);
    font-weight: var(--weight-medium);
}

.price-categories {
    margin-bottom: var(--space-6);
}

.category-tabs {
    display: flex;
    gap: var(--space-2);
    flex-wrap: wrap;
    justify-content: center;
}

.tab-btn {
    padding: var(--space-3) var(--space-4);
    border: 1px solid var(--color-glass-border);
    border-radius: var(--radius-full);
    background: var(--color-glass-white);
    color: var(--color-neutral-700);
    font-size: 14px;
    font-weight: var(--weight-medium);
    cursor: pointer;
    transition: all var(--duration-fast) var(--easing-default);
}

.tab-btn.active,
.tab-btn:hover {
    background: var(--color-primary-500);
    color: white;
    border-color: var(--color-primary-500);
}

.prices-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: var(--space-6);
}

.price-card {
    padding: var(--space-6);
    transition: all var(--duration-normal) var(--easing-smooth);
}

.price-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-glass);
}

.price-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--space-4);
}

.fish-info h3 {
    font-size: 18px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-1);
}

.fish-size {
    font-size: 12px;
    color: var(--color-neutral-600);
    background: var(--color-neutral-50);
    padding: 2px 6px;
    border-radius: var(--radius-sm);
}

.trend {
    padding: 4px 8px;
    border-radius: var(--radius-full);
    font-size: 11px;
    font-weight: var(--weight-medium);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.trend.up {
    background: rgba(76, 175, 80, 0.1);
    color: var(--color-secondary-600);
}

.trend.down {
    background: rgba(244, 67, 54, 0.1);
    color: var(--color-error);
}

.trend.stable {
    background: rgba(33, 150, 243, 0.1);
    color: var(--color-info);
}

.price-main {
    margin-bottom: var(--space-4);
}

.current-price {
    display: flex;
    align-items: baseline;
    gap: var(--space-1);
    margin-bottom: var(--space-2);
}

.price {
    font-size: 28px;
    font-weight: var(--weight-bold);
    color: var(--color-primary-700);
}

.currency {
    font-size: 14px;
    color: var(--color-neutral-600);
    font-weight: var(--weight-medium);
}

.price-change {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-2);
}

.change {
    font-size: 12px;
    padding: var(--space-1) var(--space-2);
    border-radius: var(--radius-sm);
    text-align: center;
}

.change.today {
    background: var(--color-neutral-50);
    color: var(--color-neutral-700);
}

.change.week {
    background: var(--color-primary-50);
    color: var(--color-primary-700);
}

.price-chart {
    margin-bottom: var(--space-4);
}

.chart-placeholder {
    width: 100%;
    height: 40px;
    background: var(--color-neutral-50);
    border-radius: var(--radius-md);
    overflow: hidden;
}

.price-details {
    background: rgba(255, 255, 255, 0.3);
    padding: var(--space-3);
    border-radius: var(--radius-md);
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-1) 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    font-size: 12px;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row span:first-child {
    color: var(--color-neutral-600);
}

.detail-row span:last-child {
    color: var(--color-neutral-900);
    font-weight: var(--weight-semibold);
}

.market-analysis {
    padding: var(--space-8) 0;
    background: var(--bg-dashboard);
}

.analysis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: var(--space-6);
}

.analysis-card {
    padding: var(--space-6);
}

.analysis-card h3 {
    font-size: 18px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-4);
    text-align: center;
}

.summary-stats {
    display: grid;
    gap: var(--space-3);
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-3);
    background: rgba(255, 255, 255, 0.3);
    border-radius: var(--radius-md);
    border: 1px solid var(--color-glass-border);
}

.stat-label {
    font-size: 14px;
    color: var(--color-neutral-600);
}

.stat-value {
    font-size: 16px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
}

.stat-change {
    font-size: 12px;
    font-weight: var(--weight-medium);
    padding: 2px 6px;
    border-radius: var(--radius-sm);
}

.stat-change.positive {
    background: rgba(76, 175, 80, 0.1);
    color: var(--color-secondary-600);
}

.stat-change.negative {
    background: rgba(244, 67, 54, 0.1);
    color: var(--color-error);
}

.stat-change.neutral {
    background: rgba(158, 158, 158, 0.1);
    color: var(--color-neutral-600);
}

.trend-analysis {
    display: grid;
    gap: var(--space-4);
}

.trend-item h4 {
    font-size: 14px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.trend-chart {
    display: flex;
    gap: var(--space-2);
    align-items: end;
    height: 80px;
    margin-bottom: var(--space-3);
}

.bar {
    flex: 1;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: end;
    justify-content: center;
    padding-bottom: var(--space-1);
}

.bar span {
    font-size: 10px;
    color: white;
    font-weight: var(--weight-medium);
    text-align: center;
    writing-mode: vertical-rl;
    text-orientation: mixed;
}

.trend-insights ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.trend-insights li {
    padding: var(--space-2) 0;
    font-size: 13px;
    color: var(--color-neutral-600);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.trend-insights li:last-child {
    border-bottom: none;
}

.forecast-content {
    display: grid;
    gap: var(--space-4);
}

.forecast-item h4 {
    font-size: 14px;
    font-weight: var(--weight-semibold);
    color: var(--color-primary-700);
    margin-bottom: var(--space-2);
}

.forecast-item ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.forecast-item li {
    padding: var(--space-1) 0;
    padding-left: var(--space-3);
    position: relative;
    font-size: 13px;
    color: var(--color-neutral-600);
}

.forecast-item li::before {
    content: "▸";
    position: absolute;
    left: 0;
    color: var(--color-primary-500);
    font-weight: var(--weight-bold);
}

.impact-factors {
    display: grid;
    gap: var(--space-3);
}

.factor {
    display: flex;
    gap: var(--space-3);
    padding: var(--space-3);
    border-radius: var(--radius-md);
    border: 1px solid var(--color-glass-border);
}

.factor.positive {
    background: rgba(76, 175, 80, 0.05);
    border-color: rgba(76, 175, 80, 0.2);
}

.factor.negative {
    background: rgba(244, 67, 54, 0.05);
    border-color: rgba(244, 67, 54, 0.2);
}

.factor.neutral {
    background: rgba(33, 150, 243, 0.05);
    border-color: rgba(33, 150, 243, 0.2);
}

.factor-icon {
    font-size: 20px;
    flex-shrink: 0;
}

.factor-info h4 {
    font-size: 14px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.factor-info ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.factor-info li {
    padding: 2px 0;
    font-size: 12px;
    color: var(--color-neutral-600);
}

.regional-prices {
    padding: var(--space-8) 0;
    background: var(--bg-primary);
}

.regions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-6);
}

.region-card {
    padding: var(--space-6);
    text-align: center;
    transition: all var(--duration-normal) var(--easing-smooth);
}

.region-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-glass);
}

.region-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-4);
}

.region-header h3 {
    font-size: 16px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin: 0;
}

.region-status {
    padding: 4px 8px;
    background: rgba(76, 175, 80, 0.1);
    color: var(--color-secondary-600);
    border-radius: var(--radius-full);
    font-size: 10px;
    font-weight: var(--weight-medium);
    text-transform: uppercase;
}

.region-stats {
    display: grid;
    gap: var(--space-2);
}

.region-stat {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-2);
    background: rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-sm);
}

.region-stat span:first-child {
    font-size: 12px;
    color: var(--color-neutral-600);
}

.region-stat .value {
    font-size: 14px;
    font-weight: var(--weight-semibold);
    color: var(--color-primary-700);
}

@media (max-width: 768px) {
    .prices-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .analysis-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .regions-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .summary-card {
        flex-direction: column;
        gap: var(--space-4);
        text-align: center;
    }
    
    .category-tabs {
        justify-content: flex-start;
        overflow-x: auto;
        padding-bottom: var(--space-2);
    }
    
    .price-change {
        grid-template-columns: 1fr;
        gap: var(--space-1);
    }
}
</style>

<script>
// Category filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const priceCards = document.querySelectorAll('.price-card');
    
    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            tabButtons.forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const category = this.getAttribute('data-category');
            
            // Show/hide price cards based on category
            priceCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                
                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block';
                    // Add animation
                    card.style.opacity = '0';
                    setTimeout(() => {
                        card.style.opacity = '1';
                    }, 100);
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});

// Auto-refresh prices (simulation)
function refreshPrices() {
    // In real implementation, this would fetch updated prices
    const prices = document.querySelectorAll('.price');
    prices.forEach(price => {
        const currentPrice = parseInt(price.textContent.replace(/,/g, ''));
        const variation = Math.floor(Math.random() * 20) - 10; // -10 to +10
        const newPrice = Math.max(100, currentPrice + variation);
        price.textContent = newPrice.toLocaleString('bn-BD');
    });
    
    // Update timestamp
    const now = new Date();
    const timeElement = document.querySelector('.summary-time span:last-child');
    if (timeElement) {
        timeElement.textContent = now.toLocaleTimeString('bn-BD', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }
}

// Refresh prices every 5 minutes (300000 ms)
setInterval(refreshPrices, 300000);

// Update prices every 30 seconds for demo
setInterval(refreshPrices, 30000);
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>