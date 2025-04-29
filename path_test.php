<?php
echo "Current working directory: " . getcwd() . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";

// List files in current directory
echo "<br>Files in current directory:<br>";
$files = scandir('.');
foreach ($files as $file) {
    echo $file . "<br>";
}
?> 