<?php

// Require scripts
require '../vendor/autoload.php';
require 'phpQuery.php';
require 'helpers.php';
require 'db.php';

// Use libraries
use Carbon\Carbon;
use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;

// Modify PHP configurations
error_reporting(E_ALL);
set_time_limit(0);

// Initialize timer
$time = -microtime(true);

// Fetch file to parse
$filename = $_POST['parse_source'];

// Check for emptiness
if (!isset($filename) || empty($filename)) die('Filename is empty ;(');

// Process
$inputFileName = __DIR__ . "/../uploads/{$filename}";

$columnLabels = [
    0 => "ID",
    1 => "Firmenname",
    2 => "Inhaber",
    3 => "Postleitzahl",
    4 => "Ort",
    5 => "Stra?e",
    6 => "Telefon",
    7 => "Fax",
    8 => "Internet",
    9 => "email",
    10 => "Branche 1",
    11 => "Branche 2",
    12 => "Branche 3",
    13 => "Branche 4",
    14 => "Bundesland",
    15 => "L?nge",
    16 => "Breite",
];

$restrictedEmailDomains = [
    "web.de",
    "gmail.com",
    "t-online.de",
    "foni.net",
    "yahoo.de",
    "yahoo.com",
    "Hotmail.com",
    "Hotmail.de",
    "outlook.com",
];

$workbook = SpreadsheetParser::open($inputFileName);

$myWorksheetIndex = $workbook->getWorksheetIndex('adressen1');

foreach ($workbook->createRowIterator($myWorksheetIndex) as $rowIndex => $values) {
    //die(dump($rowIndex, $values));

    if ($rowIndex > 1) {
        // Filter and write emails
        $email = $values[9];

        if (!empty($email)) {
            $emailDomain = explode("@", $email);
            $emailDomain = end($emailDomain);

            if (!in_array($emailDomain, $restrictedEmailDomains)) {
                // Write to DB
                $query = $pdo->prepare('INSERT INTO `xlsx_#1_emails` (`data`) VALUES (?)');
                $query->execute([$email]);
            }
        }

        // Filter and write websites
        $website = $values[8];

        if (empty($email) && !empty($website)) {
            // Write to DB
            $query = $pdo->prepare('INSERT INTO `xlsx_#1_websites` (`data`) VALUES (?)');
            $query->execute([$website]);
        }

        // Filter and write companies
        $company = $values[1];

        if (empty($email) && empty($website) && !empty($company)) {
            // Write to DB
            $query = $pdo->prepare('INSERT INTO `xlsx_#1_companies` (`data`) VALUES (?)');
            $query->execute([$company]);
        }
    }
}

$time += microtime(true);

echo "<br /> <b>Runtime total: </b>{$time} seconds.";
