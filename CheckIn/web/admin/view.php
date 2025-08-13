<?php
if (file_exists('/var/www/html/submissions.txt')) {
    $lines = file('/var/www/html/submissions.txt', FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        list($name, $desc) = explode('|', $line, 2);
        echo "<p><b>$name,</b><b>$email,</b><b>$phone,</b><b>$inquiry,</b>$msg</p>"; // No sanitization => stored XSS
    }
} else {
    echo "<p>No submissions yet.</p>";
}
