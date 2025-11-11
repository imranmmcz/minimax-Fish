<?php
/**
 * Logout এবং সেশন ধ্বংস
 */
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/auth.php';

logoutUser();
setSuccess('সফলভাবে লগআউট হয়েছে');
redirect('/fishcare/index.php');
