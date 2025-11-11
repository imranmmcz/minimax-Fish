<?php
$pageTitle = "বিশেষজ্ঞের জিজ্ঞাসা";
include_once __DIR__ . '/../../includes/header.php';
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="header-content">
            <div class="header-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
                    <circle cx="32" cy="32" r="30" fill="url(#expertGradient)" stroke="white" stroke-width="2"/>
                    <circle cx="24" cy="26" r="4" fill="white"/>
                    <circle cx="40" cy="26" r="4" fill="white"/>
                    <path d="M24 38C24 34 28 30 32 30C36 30 40 34 40 38" stroke="white" stroke-width="2" fill="none"/>
                    <path d="M20 16L18 20L22 20L20 24L24 20L28 24L26 20L30 20L28 16L24 20L20 16Z" fill="white"/>
                    <defs>
                        <linearGradient id="expertGradient" x1="0" y1="0" x2="64" y2="64">
                            <stop offset="0%" style="stop-color:#00BCD4"/>
                            <stop offset="100%" style="stop-color:#4CAF50"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="header-text">
                <h1>বিশেষজ্ঞের জিজ্ঞাসা</h1>
                <p>মৎস্য চাষ সংক্রান্ত যেকোনো প্রশ্নের জবাব পান অভিজ্ঞ বিশেষজ্ঞদের কাছ থেকে</p>
            </div>
        </div>
    </div>
</section>

<!-- Expert Categories Section -->
<section class="expert-categories">
    <div class="container">
        <div class="glass-card">
            <h3>বিষয়ভিত্তিক ক্যাটাগরি</h3>
            <div class="categories-grid">
                <div class="category-card" data-category="চাষ-পদ্ধতি">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="12" fill="#00BCD4"/>
                            <path d="M12 10L16 14L24 6" stroke="white" stroke-width="2"/>
                            <path d="M8 20L12 24L20 16" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                    <h4>চাষ পদ্ধতি</h4>
                    <p>পুকুর তৈরি, বীজ সংগ্রহ, চাষের পদ্ধতি</p>
                    <span class="question-count">২৫টি প্রশ্ন</span>
                </div>

                <div class="category-card" data-category="রোগ-ব্যবস্থাপনা">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="12" fill="#F44336"/>
                            <path d="M16 8C14.895 8 14 8.895 14 10V14H10C8.895 14 8 14.895 8 16V18C8 19.105 8.895 20 10 20H14V24C14 25.105 14.895 26 16 26H18C19.105 26 20 25.105 20 24V20H24C25.105 20 26 19.105 26 18V16C26 14.895 25.105 14 24 14H20V10C20 8.895 19.105 8 18 8H16Z" fill="white"/>
                        </svg>
                    </div>
                    <h4>রোগ ব্যবস্থাপনা</h4>
                    <p>রোগ নির্ণয়, চিকিৎসা, প্রতিরোধ</p>
                    <span class="question-count">১৮টি প্রশ্ন</span>
                </div>

                <div class="category-card" data-category="খাবার-ব্যবস্থাপনা">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="12" fill="#4CAF50"/>
                            <path d="M8 12C8 10 10 8 12 8H20C22 8 24 10 24 12C24 14 22 16 20 16H12C10 16 8 14 8 12Z" fill="white"/>
                            <path d="M10 18L12 16L14 18L16 16L18 18L20 16L22 18" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                    <h4>খাবার ব্যবস্থাপনা</h4>
                    <p>খাবারের ধরন, পরিমাণ, খাওয়ানোর সময়</p>
                    <span class="question-count">১২টি প্রশ্ন</span>
                </div>

                <div class="category-card" data-category="পানি-ব্যবস্থাপনা">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="12" fill="#2196F3"/>
                            <path d="M16 8C12 12 10 16 10 20C10 23.314 12.686 26 16 26C19.314 26 22 23.314 22 20C22 16 20 12 16 8Z" fill="white"/>
                            <path d="M14 16L16 18L20 14" stroke="#2196F3" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h4>পানি ব্যবস্থাপনা</h4>
                    <p>পানির গুণমান, পানি পরিবর্তন, তাপমাত্রা</p>
                    <span class="question-count">১৫টি প্রশ্ন</span>
                </div>

                <div class="category-card" data-category="বাজার-ব্যবস্থাপনা">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="12" fill="#FF9800"/>
                            <path d="M12 10H20V12H12V10Z" fill="white"/>
                            <path d="M10 14H22V22H10V14Z" fill="white"/>
                            <path d="M12 16H16V18H12V16Z" fill="#FF9800"/>
                            <path d="M18 16H20V18H18V16Z" fill="#FF9800"/>
                        </svg>
                    </div>
                    <h4>বাজার ব্যবস্থাপনা</h4>
                    <p>মূল্য নির্ধারণ, বিক্রয়, বিপণন</p>
                    <span class="question-count">২০টি প্রশ্ন</span>
                </div>

                <div class="category-card" data-category="অর্থনীতি">
                    <div class="category-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="12" fill="#9C27B0"/>
                            <path d="M8 16C8 12 12 8 16 8C20 8 24 12 24 16C24 20 20 24 16 24C12 24 8 20 8 16Z" fill="white"/>
                            <path d="M12 12L16 16L20 12L24 16" stroke="#9C27B0" stroke-width="2" fill="none"/>
                        </svg>
                    </div>
                    <h4>অর্থনীতি</h4>
                    <p>বিনিয়োগ, লাভ-ক্ষতি, খরচ ব্যবস্থাপনা</p>
                    <span class="question-count">১০টি প্রশ্ন</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Questions Section -->
<section class="featured-questions">
    <div class="container">
        <div class="section-header">
            <h2>জনপ্রিয় প্রশ্ন ও উত্তর</h2>
            <p>সবচেয়ে বেশি জিজ্ঞাসা করা প্রশ্নসমূহ</p>
        </div>

        <div class="questions-grid" id="featuredQuestions">
            <!-- ফিচার্ড প্রশ্ন ১ -->
            <div class="question-card glass-card" data-category="চাষ-পদ্ধতি">
                <div class="question-header">
                    <div class="question-meta">
                        <span class="category">চাষ পদ্ধতি</span>
                        <span class="date">৩ দিন আগে</span>
                    </div>
                    <h3>রুই মাছের চাষে কোন পদ্ধতি সবচেয়ে লাভজনক?</h3>
                </div>
                <div class="question-content">
                    <p>আমি নতুন চাষী এবং রুই মাছ চাষ করতে চাই। কোন পদ্ধতি অনুসরণ করলে সবচেয়ে বেশি লাভ পাব এবং কম ঝুঁকিতে থাকব?</p>
                </div>
                <div class="question-stats">
                    <span class="answer-count">৪টি উত্তর</span>
                    <span class="views">১২৫ ভিউ</span>
                    <div class="rating">
                        <span>মূল্যায়ন:</span>
                        <div class="stars">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700" opacity="0.3">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="question-actions">
                    <button class="btn-glass-sm" onclick="viewQuestion(1)">প্রশ্ন দেখুন</button>
                    <button class="btn-primary-sm" onclick="answerQuestion(1)">উত্তর দিন</button>
                </div>
            </div>

            <!-- ফিচার্ড প্রশ্ন ২ -->
            <div class="question-card glass-card" data-category="রোগ-ব্যবস্থাপনা">
                <div class="question-header">
                    <div class="question-meta">
                        <span class="category">রোগ ব্যবস্থাপনা</span>
                        <span class="date">১ সপ্তাহ আগে</span>
                    </div>
                    <h3>পুকুরে মাছের মৃত্যুর কারণ ও সমাধান</h3>
                </div>
                <div class="question-content">
                    <p>আমার পুকুরে গত সপ্তাহ থেকে প্রতিদিন ৫-১০টি মাছ মারা যাচ্ছে। পানির রঙ একটু নেসে রঙ হয়ে গেছে। কি করতে পারি?</p>
                </div>
                <div class="question-stats">
                    <span class="answer-count">৬টি উত্তর</span>
                    <span class="views">২৮৯ ভিউ</span>
                    <div class="rating">
                        <span>মূল্যায়ন:</span>
                        <div class="stars">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="question-actions">
                    <button class="btn-glass-sm" onclick="viewQuestion(2)">প্রশ্ন দেখুন</button>
                    <button class="btn-primary-sm" onclick="answerQuestion(2)">উত্তর দিন</button>
                </div>
            </div>

            <!-- ফিচার্ড প্রশ্ন ৩ -->
            <div class="question-card glass-card" data-category="খাবার-ব্যবস্থাপনা">
                <div class="question-header">
                    <div class="question-meta">
                        <span class="category">খাবার ব্যবস্থাপনা</span>
                        <span class="date">২ সপ্তাহ আগে</span>
                    </div>
                    <h3>কাতলা মাছের জন্য সঠিক খাবার কি?</h3>
                </div>
                <div class="question-content">
                    <p>কাতলা মাছের জন্য কি ধরনের খাবার দিতে হবে এবং কতটুকু পরিমাণে দিতে হবে? প্রাকৃতিক খাবার ছাড়াও কৃত্রিম খাবার কি দরকার?</p>
                </div>
                <div class="question-stats">
                    <span class="answer-count">৩টি উত্তর</span>
                    <span class="views">১৫৬ ভিউ</span>
                    <div class="rating">
                        <span>মূল্যায়ন:</span>
                        <div class="stars">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700" opacity="0.3">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700" opacity="0.3">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="question-actions">
                    <button class="btn-glass-sm" onclick="viewQuestion(3)">প্রশ্ন দেখুন</button>
                    <button class="btn-primary-sm" onclick="answerQuestion(3)">উত্তর দিন</button>
                </div>
            </div>

            <!-- ফিচার্ড প্রশ্ন ৪ -->
            <div class="question-card glass-card" data-category="পানি-ব্যবস্থাপনা">
                <div class="question-header">
                    <div class="question-meta">
                        <span class="category">পানি ব্যবস্থাপনা</span>
                        <span class="date">১ মাস আগে</span>
                    </div>
                    <h3>পানির পিএইচ ও অক্সিজেনের মাত্রা কত হওয়া উচিত?</h3>
                </div>
                <div class="question-content">
                    <p>আমার পুকুরে পানির পিএইচ ৮.৫ এবং অক্সিজেনের মাত্রা কম দেখাচ্ছে। এটা কি স্বাভাবিক? কি করতে হবে?</p>
                </div>
                <div class="question-stats">
                    <span class="answer-count">৮টি উত্তর</span>
                    <span class="views">৪২৫ ভিউ</span>
                    <div class="rating">
                        <span>মূল্যায়ন:</span>
                        <div class="stars">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="question-actions">
                    <button class="btn-glass-sm" onclick="viewQuestion(4)">প্রশ্ন দেখুন</button>
                    <button class="btn-primary-sm" onclick="answerQuestion(4)">উত্তর দিন</button>
                </div>
            </div>

            <!-- ফিচার্ড প্রশ্ন ৫ -->
            <div class="question-card glass-card" data-category="বাজার-ব্যবস্থাপনা">
                <div class="question-header">
                    <div class="question-meta">
                        <span class="category">বাজার ব্যবস্থাপনা</span>
                        <span class="date">১৫ দিন আগে</span>
                    </div>
                    <h3>মাছের বাজার দর কিভাবে নির্ধারণ করব?</h3>
                </div>
                <div class="question-content">
                    <p>আমি নতুন চাষী এবং জানতে চাই মাছের বাজার দর কিভাবে নির্ধারণ করা হয়? কোন কোন বিষয় বিবেচনা করতে হবে?</p>
                </div>
                <div class="question-stats">
                    <span class="answer-count">৫টি উত্তর</span>
                    <span class="views">২১৭ ভিউ</span>
                    <div class="rating">
                        <span>মূল্যায়ন:</span>
                        <div class="stars">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700" opacity="0.3">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700" opacity="0.3">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="question-actions">
                    <button class="btn-glass-sm" onclick="viewQuestion(5)">প্রশ্ন দেখুন</button>
                    <button class="btn-primary-sm" onclick="answerQuestion(5)">উত্তর দিন</button>
                </div>
            </div>

            <!-- ফিচার্ড প্রশ্ন ৬ -->
            <div class="question-card glass-card" data-category="অর্থনীতি">
                <div class="question-header">
                    <div class="question-meta">
                        <span class="category">অর্থনীতি</span>
                        <span class="date">১ সপ্তাহ আগে</span>
                    </div>
                    <h3>মৎস্য চাষে কত টাকা বিনিয়োগ করলে কত লাভ হবে?</h3>
                </div>
                <div class="question-content">
                    <p>আমার ১ একর পুকুর রয়েছে। এতে মৎস্য চাষ শুরু করতে কত টাকা বিনিয়োগ করতে হবে এবং প্রতি বছর কত লাভ আশা করতে পারি?</p>
                </div>
                <div class="question-stats">
                    <span class="answer-count">৭টি উত্তর</span>
                    <span class="views">৩৬৮ ভিউ</span>
                    <div class="rating">
                        <span>মূল্যায়ন:</span>
                        <div class="stars">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#FFD700" opacity="0.3">
                                <path d="M8 1L9.5 6H15L11 9L12.5 14L8 11L3.5 14L5 9L1 6H6.5L8 1Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="question-actions">
                    <button class="btn-glass-sm" onclick="viewQuestion(6)">প্রশ্ন দেখুন</button>
                    <button class="btn-primary-sm" onclick="answerQuestion(6)">উত্তর দিন</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ask Question Section -->
<section class="ask-question-section">
    <div class="container">
        <div class="glass-card ask-question-card">
            <div class="ask-question-header">
                <h3>নতুন প্রশ্ন করুন</h3>
                <p>আপনার সমস্যা বা জিজ্ঞাসা আমাদের সাথে শেয়ার করুন, বিশেষজ্ঞরা উত্তর দেবেন</p>
            </div>
            
            <form class="ask-question-form" id="askQuestionForm">
                <div class="form-group">
                    <label for="questionTitle">প্রশ্নের শিরোনাম</label>
                    <input type="text" id="questionTitle" name="title" required placeholder="আপনার প্রশ্নের সংক্ষিপ্ত বিবরণ লিখুন">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="questionCategory">ক্যাটাগরি</label>
                        <select id="questionCategory" name="category" required>
                            <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                            <option value="চাষ-পদ্ধতি">চাষ পদ্ধতি</option>
                            <option value="রোগ-ব্যবস্থাপনা">রোগ ব্যবস্থাপনা</option>
                            <option value="খাবার-ব্যবস্থাপনা">খাবার ব্যবস্থাপনা</option>
                            <option value="পানি-ব্যবস্থাপনা">পানি ব্যবস্থাপনা</option>
                            <option value="বাজার-ব্যবস্থাপনা">বাজার ব্যবস্থাপনা</option>
                            <option value="অর্থনীতি">অর্থনীতি</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="questionUrgency">জরুরিতা</label>
                        <select id="questionUrgency" name="urgency">
                            <option value="সাধারণ">সাধারণ</option>
                            <option value="গুরুত্বপূর্ণ">গুরুত্বপূর্ণ</option>
                            <option value="জরুরি">জরুরি</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="questionDetails">বিস্তারিত বিবরণ</label>
                    <textarea id="questionDetails" name="details" rows="6" required placeholder="আপনার প্রশ্নের বিস্তারিত বিবরণ লিখুন. সমস্যার প্রেক্ষাপট, চেষ্টা করা সমাধান ইত্যাদি উল্লেখ করুন..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="questionExperience">চাষের অভিজ্ঞতা</label>
                    <select id="questionExperience" name="experience">
                        <option value="নতুন">নতুন চাষী</option>
                        <option value="১-২ বছর">১-২ বছর অভিজ্ঞতা</option>
                        <option value="৩-৫ বছর">৩-৫ বছর অভিজ্ঞতা</option>
                        <option value="৫+ বছর">৫+ বছর অভিজ্ঞতা</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="agreeTerms" name="agree" required>
                        <span class="checkmark"></span>
                        আমি স্বীকার করছি যে এই প্রশ্নটি সত্য এবং আমি সাইটের ব্যবহারের শর্তাবলী মেনে নিচ্ছি।
                    </label>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-glass" onclick="clearForm()">সাফ করুন</button>
                    <button type="submit" class="btn-primary">প্রশ্ন পাঠান</button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
.expert-categories {
    padding: var(--space-8) 0;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-6);
    margin-top: var(--space-6);
}

.category-card {
    padding: var(--space-6);
    border-radius: var(--radius-lg);
    background: var(--color-glass-white);
    border: 1px solid var(--color-glass-border);
    text-align: center;
    transition: all var(--duration-normal) var(--easing-smooth);
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-glass);
    border-color: var(--color-primary-500);
}

.category-card:active {
    transform: translateY(-2px);
}

.category-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto var(--space-4);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-full);
    background: var(--color-neutral-50);
}

.category-card h4 {
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

.question-count {
    display: inline-block;
    padding: 4px 8px;
    background: var(--color-primary-50);
    color: var(--color-primary-700);
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: var(--weight-medium);
}

.featured-questions {
    padding: var(--space-8) 0;
    background: var(--bg-dashboard);
}

.section-header {
    text-align: center;
    margin-bottom: var(--space-8);
}

.section-header h2 {
    font-size: var(--text-md);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.section-header p {
    font-size: 16px;
    color: var(--color-neutral-600);
}

.questions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: var(--space-6);
}

.question-card {
    padding: var(--space-6);
    transition: all var(--duration-normal) var(--easing-smooth);
}

.question-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-glass);
}

.question-header {
    margin-bottom: var(--space-4);
}

.question-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-2);
}

.category {
    padding: 4px 8px;
    background: var(--color-primary-50);
    color: var(--color-primary-700);
    border-radius: var(--radius-full);
    font-size: 11px;
    font-weight: var(--weight-medium);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.date {
    font-size: 12px;
    color: var(--color-neutral-500);
}

.question-card h3 {
    font-size: 16px;
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    line-height: var(--line-height-tight);
    margin: 0;
}

.question-content {
    margin-bottom: var(--space-4);
}

.question-content p {
    font-size: 14px;
    color: var(--color-neutral-600);
    line-height: var(--line-height-relaxed);
    margin: 0;
}

.question-stats {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-4);
    padding-top: var(--space-3);
    border-top: 1px solid var(--color-glass-border);
}

.answer-count,
.views {
    font-size: 12px;
    color: var(--color-neutral-600);
    display: flex;
    align-items: center;
    gap: var(--space-1);
}

.rating {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.rating span {
    font-size: 12px;
    color: var(--color-neutral-600);
}

.stars {
    display: flex;
    gap: 2px;
}

.question-actions {
    display: flex;
    gap: var(--space-2);
}

.btn-glass-sm,
.btn-primary-sm {
    padding: var(--space-2) var(--space-4);
    border-radius: var(--radius-md);
    font-size: 12px;
    font-weight: var(--weight-medium);
    border: none;
    cursor: pointer;
    transition: all var(--duration-fast) var(--easing-default);
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-glass-sm {
    background: var(--color-glass-white);
    color: var(--color-neutral-700);
    border: 1px solid var(--color-glass-border);
}

.btn-glass-sm:hover {
    background: rgba(255, 255, 255, 0.6);
    border-color: var(--color-primary-300);
}

.btn-primary-sm {
    background: var(--color-primary-500);
    color: white;
}

.btn-primary-sm:hover {
    background: var(--color-primary-600);
    transform: translateY(-1px);
}

.ask-question-section {
    padding: var(--space-8) 0;
}

.ask-question-card {
    max-width: 800px;
    margin: 0 auto;
}

.ask-question-header {
    text-align: center;
    margin-bottom: var(--space-6);
}

.ask-question-header h3 {
    font-size: var(--text-sm);
    font-weight: var(--weight-semibold);
    color: var(--color-neutral-900);
    margin-bottom: var(--space-2);
}

.ask-question-header p {
    font-size: 14px;
    color: var(--color-neutral-600);
    margin: 0;
}

.ask-question-form {
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
    min-height: 120px;
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

.btn-glass,
.btn-primary {
    padding: var(--space-3) var(--space-6);
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: var(--weight-medium);
    border: none;
    cursor: pointer;
    transition: all var(--duration-normal) var(--easing-default);
    text-decoration: none;
    display: inline-block;
    text-align: center;
    min-width: 120px;
}

.btn-glass {
    background: var(--color-glass-white);
    color: var(--color-neutral-700);
    border: 1px solid var(--color-glass-border);
}

.btn-glass:hover {
    background: rgba(255, 255, 255, 0.6);
    border-color: var(--color-primary-300);
}

.btn-primary {
    background: var(--color-primary-500);
    color: white;
}

.btn-primary:hover {
    background: var(--color-primary-600);
    transform: translateY(-1px);
    box-shadow: var(--shadow-glass-sm);
}

@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .questions-grid {
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
    
    .question-actions {
        flex-direction: column;
        gap: var(--space-2);
    }
}
</style>

<script>
// Category filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const categoryCards = document.querySelectorAll('.category-card');
    const questionCards = document.querySelectorAll('.question-card');
    
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            filterQuestionsByCategory(category);
        });
    });
    
    function filterQuestionsByCategory(category) {
        questionCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            if (category === cardCategory || category === null) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
});

// Question form handling
document.getElementById('askQuestionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simulate form submission
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Show success message (in real implementation, this would submit to server)
    alert('আপনার প্রশ্নটি সফলভাবে পাঠানো হয়েছে। একজন বিশেষজ্ঞ আপনার উত্তর দেবেন!');
    
    // Reset form
    this.reset();
});

// Question action functions
function viewQuestion(id) {
    // In real implementation, this would navigate to the full question page
    alert('প্রশ্ন ' + id + ' এর বিস্তারিত দেখা হচ্ছে...');
}

function answerQuestion(id) {
    // In real implementation, this would open the answer form
    alert('প্রশ্ন ' + id + ' এর জন্য উত্তর ফর্ম খোলা হচ্ছে...');
}

function clearForm() {
    if (confirm('আপনি কি নিশ্চিত যে ফর্মটি সাফ করতে চান?')) {
        document.getElementById('askQuestionForm').reset();
    }
}
</script>

<?php include_once __DIR__ . '/../../includes/footer.php'; ?>