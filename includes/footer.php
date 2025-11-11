    </main>
    
    <!-- Footer -->
    <footer class="glass-footer">
        <div class="container">
            <div class="footer-content">
                <!-- Footer Info -->
                <div class="footer-section">
                    <h3 class="footer-title">ফিশ কেয়ার সিস্টেম</h3>
                    <p class="footer-text">
                        বাংলাদেশের মৎস্য চাষ ব্যবসায়ের জন্য সম্পূর্ণ ডিজিটাল ব্যবস্থাপনা সিস্টেম।
                        আধুনিক প্রযুক্তি ব্যবহার করে আপনার ব্যবসা পরিচালনা করুন সহজেই।
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div class="footer-section">
                    <h4 class="footer-subtitle">দ্রুত লিংক</h4>
                    <ul class="footer-links">
                        <li><a href="/fishcare/index.php">হোম</a></li>
                        <li><a href="/fishcare/pages/public/tools-seba.php">টুলসেবা</a></li>
                        <li><a href="/fishcare/pages/public/poramorsho.php">পরামর্শ</a></li>
                        <li><a href="/fishcare/pages/public/bazar-dor.php">বাজার দর</a></li>
                        <li><a href="/fishcare/pages/public/calculator.php">ক্যালকুলেটর</a></li>
                    </ul>
                </div>
                
                <!-- Resources -->
                <div class="footer-section">
                    <h4 class="footer-subtitle">রিসোর্স</h4>
                    <ul class="footer-links">
                        <li><a href="/fishcare/pages/public/rogo-byabosthapona.php">রোগ ব্যবস্থাপনা</a></li>
                        <li><a href="/fishcare/pages/public/projatir-tinirbhandar.php">প্রজাতির তথ্য</a></li>
                        <li><a href="/fishcare/pages/public/expert-er-jiggasa.php">বিশেষজ্ঞের জিজ্ঞাসা</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div class="footer-section">
                    <h4 class="footer-subtitle">যোগাযোগ</h4>
                    <ul class="footer-contact">
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M3 2C2.4 2 2 2.4 2 3V13C2 13.6 2.4 14 3 14H13C13.6 14 14 13.6 14 13V3C14 2.4 13.6 2 13 2H3ZM3 4L8 7L13 4V13H3V4Z"/>
                            </svg>
                            <span><?php echo SITE_EMAIL; ?></span>
                        </li>
                        <li>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 0C5.2 0 3 2.2 3 5C3 8.5 8 14 8 14C8 14 13 8.5 13 5C13 2.2 10.8 0 8 0ZM8 7C6.9 7 6 6.1 6 5C6 3.9 6.9 3 8 3C9.1 3 10 3.9 10 5C10 6.1 9.1 7 8 7Z"/>
                            </svg>
                            <span>ঢাকা, বাংলাদেশ</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> ফিশ কেয়ার সিস্টেম। সর্বস্বত্ব সংরক্ষিত।</p>
                <p class="footer-credit">
                    Designed with 
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="#F44336" style="display: inline;">
                        <path d="M8 13L2.5 7.5C1.5 6.5 1 5.2 1 4C1 2.3 2.3 1 4 1C5.2 1 6.2 1.6 7 2.5L8 3.5L9 2.5C9.8 1.6 10.8 1 12 1C13.7 1 15 2.3 15 4C15 5.2 14.5 6.5 13.5 7.5L8 13Z"/>
                    </svg>
                    by MiniMax Agent
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Main JavaScript -->
    <script src="/fishcare/assets/js/script.js"></script>
    
    <!-- Custom Page JS -->
    <?php if (isset($customJS)): ?>
        <script src="<?php echo $customJS; ?>"></script>
    <?php endif; ?>
    
    <!-- Mobile Menu Script -->
    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            
            // Mobile menu toggle
            const mobileToggle = document.getElementById('mobileMenuToggle');
            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    const navMenu = document.getElementById('navMenu');
                    if (navMenu) {
                        navMenu.classList.toggle('active');
                        this.classList.toggle('active');
                    }
                });
            }
            
            // Flash message auto hide
            setTimeout(function() {
                const flashMessages = document.querySelectorAll('.flash-message');
                flashMessages.forEach(msg => {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 300);
                });
            }, 5000);
            
            // Enhanced User dropdown toggle
            initUserDropdown();
        });
        
        function initUserDropdown() {
            const dropdown = document.getElementById('navUserDropdown');
            const btn = document.getElementById('navUserBtn');
            
            if (!dropdown || !btn) {
                console.log('Dropdown elements not found, trying alternative selectors');
                // Fallback to original selectors
                const fallbackDropdown = document.querySelector('.nav-user-dropdown');
                const fallbackBtn = document.querySelector('.nav-user-btn');
                
                if (fallbackDropdown && fallbackBtn) {
                    setupDropdownEvents(fallbackDropdown, fallbackBtn);
                }
                return;
            }
            
            setupDropdownEvents(dropdown, btn);
        }
        
        function setupDropdownEvents(dropdown, btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('Dropdown button clicked');
                
                // Toggle active state
                const isActive = dropdown.classList.contains('active');
                if (isActive) {
                    dropdown.classList.remove('active');
                    console.log('Dropdown closed');
                } else {
                    dropdown.classList.add('active');
                    console.log('Dropdown opened');
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                    console.log('Dropdown closed (outside click)');
                }
            });
            
            // Handle dropdown menu links
            const menuItems = dropdown.querySelectorAll('.dropdown-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // For logout link, add confirmation
                    if (this.id === 'navLogoutLink' || this.textContent.trim() === 'লগআউট') {
                        console.log('Logout link clicked');
                        // Allow the default behavior for logout
                    } else {
                        // For other links, you can add custom handling here
                        console.log('Other menu item clicked:', this.textContent);
                    }
                });
            });
            
            console.log('User dropdown initialized successfully');
        }
    </script>
</body>
</html>
