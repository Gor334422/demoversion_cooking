<?php
// Admin configuration - NOT tracked in Git (added to .gitignore).
// Set the admin username and password here. For safety this file is gitignored.
// We generate a password hash at runtime for convenience.

$ADMIN_USERNAME = 'Gor334422';
$ADMIN_PASSWORD_HASH = password_hash('gorarg04', PASSWORD_DEFAULT);

// Note: In production store a stable hash and never keep plaintext passwords.
?>