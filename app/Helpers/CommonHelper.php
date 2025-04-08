<?php

use App\Models\Settings;
use App\Models\User;
use App\Models\Language;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\File as UFile;

use function JmesPath\search;

function getTicketStatus()
{
    return array('open', 'pending', 'resolved', 'closed');
}
// function uploadFile($file, $path = null)
// {

//     if (isset($file)) {
//         $file_name = time() . rand(1000, 9999) . "_" . $file->getClientOriginalName();
//         $explode = explode('.', $file_name);
//         $ext = "." . last($explode);
//         array_pop($explode);
//         $file_name = implode('_', $explode);
//         $file_name = $path . "/" . strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $file_name)) . $ext;
//         Storage::put($file_name, File::get(path: $file), ['visibility' => 'public', 'directory_visibility' => 'public']);
//         return $file_name;
//     }
//     return null;
// }

function uploadFile($file, $path = null)
{
    if (isset($file)) {
        $file_name = time() . rand(1000, 9999) . "_" . $file->getClientOriginalName();
        $explode = explode('.', $file_name);
        $ext = "." . last($explode);
        array_pop($explode);
        $file_name = implode('_', $explode);
        $file_name = $path . "/" . strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $file_name)) . $ext;

        Storage::disk('public_uploads')->put($file_name, File::get($file), [
            'visibility' => 'public',
            'directory_visibility' => 'public'
        ]);

        return $file_name;
    }
    return null;
}

function getFileUrl($file)
{

    if ($file != null) {
        return asset('uploads/' . $file);
    }
    return null;
}

function getNumberOfMonths()
{
    return array(
        1 => 1,
        3 => 3,
        6 => 6,
        9 => 9,
        12 => 12,
        24 => 24
    );
}

function getNumberOfTrialDays()
{
    return array(
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        11 => 11,
        12 => 12,
        13 => 13,
        14 => 14,
    );
}

function getAllLanguages($en = false, $field = 'store_location_name')
{

    $languages = new Language();
    if (!$en)
        $languages = $languages->where('store_location_name', '!=', 'en');
    $languages = $languages->pluck('name', $field)->toArray();
    return $languages;
}

function getAllCurrentLanguages()
{
    return getAllLanguages();
}

function getAllThemes()
{
    $themes = [["name" => "Theme1", "id" => "1", "image" => '/assets/theme/theme1.png'], ["name" => "Theme2", "id" => "2", "image" => '/assets/theme/theme2.png'], ["name" => "Theme3", "id" => "3", "image" => '/assets/theme/theme3.png'], ["name" => "Theme4", "id" => "4", "image" => '/assets/theme/theme4.png'],];
    return $themes;
}

function arrayToFileString($languageDate = [])
{
    $data = '<?php
    return
    ';
    $data .= var_export($languageDate, true) . ";";
    return $data;
}


function generateLanguageStoreDirName($languageName, $length = 2)
{
    $languageName = preg_replace('/[^a-zA-Z0-9]/i', '', $languageName);

    $genatedName = substr(strtolower($languageName), 0, $length);
    if (File::exists(lang_path($genatedName))) {
        if (strlen($languageName) >= $length) {
            return $languageName .= "_" . time();
        }
        return generateLanguageStoreDirName($languageName, $length + 1);
    }
    return $genatedName;
}

function getAllLanguagesFiles()
{
    $path = lang_path('en');
    $fileNames = [];
    $files = (File::allFiles($path));
    foreach ($files as $file) {
        $fileNames[pathinfo($file)['filename']] = ucfirst(pathinfo($file)['filename']);
    }

    return $fileNames;
}

function getDynamicDataTables()
{
    $fileNames['categories'] = "Categories";
    $fileNames['items'] = "Items";
    return $fileNames;
}

function getFileAllLanguagesData($file, $language = 'en', $isDot = true)
{
    $datas = Lang::get($file, [], $language);
    if ($isDot)
        return Arr::dot($datas);
    return $datas;
}

function multiArrayToDot($array)
{
    return Arr::dot($array);
}

function trimDotAndSpaces($string)
{
    return rtrim(rtrim($string, '.'), ' ');
}

function getDotStringToInputString($string, $prefix = '')
{

    if ($prefix != '') {
        $string = $prefix . "." . $string;
    }
    $array = explode('.', $string);
    if (count($array) == 1) {
        return $string;
    }
    $new = implode("][", array_slice($array, 1));
    return "{$array[0]}[$new]";
}

function readableString($str)
{
    return ucwords(str_replace("_", " ", $str));
}

function isAdmin()
{
    return auth()->user()->user_type == User::USER_TYPE_ADMIN;
}

function getAllCurrencies()
{
    return array("USD" => '$ - USD', "CAD" => 'CA$ - CAD', "EUR" => '€ - EUR', "AED" => 'AED - AED', "AFN" => 'Af - AFN', "ALL" => 'ALL - ALL', "AMD" => 'AMD - AMD', "ARS" => 'AR$ - ARS', "AUD" => 'AU$ - AUD', "AZN" => 'man. - AZN', "BAM" => 'KM - BAM', "BDT" => 'Tk - BDT', "BGN" => 'BGN - BGN', "BHD" => 'BD - BHD', "BIF" => 'FBu - BIF', "BND" => 'BN$ - BND', "BOB" => 'Bs - BOB', "BRL" => 'R$ - BRL', "BWP" => 'BWP - BWP', "BYN" => 'Br - BYN', "BZD" => 'BZ$ - BZD', "CDF" => 'CDF - CDF', "CHF" => 'CHF - CHF', "CLP" => 'CL$ - CLP', "CNY" => 'CN¥ - CNY', "COP" => 'CO$ - COP', "CRC" => '₡ - CRC', "CVE" => 'CV$ - CVE', "CZK" => 'Kč - CZK', "DJF" => 'Fdj - DJF', "DKK" => 'Dkr - DKK', "DOP" => 'RD$ - DOP', "DZD" => 'DA - DZD', "EEK" => 'Ekr - EEK', "EGP" => 'EGP - EGP', "ERN" => 'Nfk - ERN', "ETB" => 'Br - ETB', "GBP" => '£ - GBP', "GEL" => 'GEL - GEL', "GHS" => 'GH₵ - GHS', "GNF" => 'FG - GNF', "GTQ" => 'GTQ - GTQ', "HKD" => 'HK$ - HKD', "HNL" => 'HNL - HNL', "HRK" => 'kn - HRK', "HUF" => 'Ft - HUF', "IDR" => 'Rp - IDR', "ILS" => '₪ - ILS', "INR" => '₹ - INR', "IQD" => 'IQD - IQD', "IRR" => 'IRR - IRR', "ISK" => 'Ikr - ISK', "JMD" => 'J$ - JMD', "JOD" => 'JD - JOD', "JPY" => '¥ - JPY', "KES" => 'Ksh - KES', "KHR" => 'KHR - KHR', "KMF" => 'CF - KMF', "KRW" => '₩ - KRW', "KWD" => 'KD - KWD', "KZT" => 'KZT - KZT', "LBP" => 'L.L. - LBP', "LKR" => 'SLRs - LKR', "LTL" => 'Lt - LTL', "LVL" => 'Ls - LVL', "LYD" => 'LD - LYD', "MAD" => 'MAD - MAD', "MDL" => 'MDL - MDL', "MGA" => 'MGA - MGA', "MKD" => 'MKD - MKD', "MMK" => 'MMK - MMK', "MOP" => 'MOP$ - MOP', "MUR" => 'MURs - MUR', "MXN" => 'MX$ - MXN', "MYR" => 'RM - MYR', "MZN" => 'MTn - MZN', "NAD" => 'N$ - NAD', "NGN" => '₦ - NGN', "NIO" => 'C$ - NIO', "NOK" => 'Nkr - NOK', "NPR" => 'NPRs - NPR', "NZD" => 'NZ$ - NZD', "OMR" => 'OMR - OMR', "PAB" => 'B/. - PAB', "PEN" => 'S/. - PEN', "PHP" => '₱ - PHP', "PKR" => 'PKRs - PKR', "PLN" => 'zł - PLN', "PYG" => '₲ - PYG', "QAR" => 'QR - QAR', "RON" => 'RON - RON', "RSD" => 'din. - RSD', "RUB" => 'RUB - RUB', "RWF" => 'RWF - RWF', "SAR" => 'SR - SAR', "SDG" => 'SDG - SDG', "SEK" => 'Skr - SEK', "SGD" => 'S$ - SGD', "SOS" => 'Ssh - SOS', "SYP" => 'SY£ - SYP', "THB" => '฿ - THB', "TND" => 'DT - TND', "TOP" => 'T$ - TOP', "TRY" => 'TL - TRY', "TTD" => 'TT$ - TTD', "TWD" => 'NT$ - TWD', "TZS" => 'TSh - TZS', "UAH" => '₴ - UAH', "UGX" => 'USh - UGX', "UYU" => '$U - UYU', "UZS" => 'UZS - UZS', "VEF" => 'Bs.F. - VEF', "VND" => '₫ - VND', "XAF" => 'FCFA - XAF', "XOF" => 'CFA - XOF', "YER" => 'YR - YER', "ZAR" => 'R - ZAR', "ZMK" => 'ZK - ZMK', "ZWL" => 'ZW - ZWLL');
}

function imageDataToCollection($fileData)
{

    $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
    file_put_contents($tmpFilePath, $fileData);
    $tmpFile = new UFile($tmpFilePath);

    $file = new UploadedFile(
        $tmpFile->getPathname(),
        $tmpFile->getFilename(),
        $tmpFile->getMimeType(),
        0,
        true // Mark it as test, since the file isn't from real HTTP POST.
    );
    return $file;
}


function createQniqueSessionAndDestoryOld($key, $delete = 0)
{
    $time = time();
    if (Session::has($key)) {
        $olduniq = Session::get($key);
        Storage::deleteDirectory($olduniq);
    }
    if ($delete) {
        return;
    }

    Session::put($key, $time);
    return $time;
}

function moveFile($paths, $folder)
{
    $newPaths = [];
    foreach ($paths as $path) {
        $name = basename($path);
        $newPaths[] = $newPath = $folder . "/" . $name;
        Storage::move($path, $newPath);
    }
    return $newPaths;
}

function displayCurrency($val, $symbol = null, $position = null)
{
    if (isset($val) && $val >= 0) {
        $currency_symbol = $symbol ?? config('custom.currency_symbol');
        $currency_position = $position ?? config('custom.currency_position');

        if ($currency_position == 'right') {
            return number_format($val, 2) . $currency_symbol;
        } else {
            return $currency_symbol . number_format($val, 2);
        }
    }
}

function getUsdDiscountPrice($val, $type, $symbol = null, $position = null)
{
    if ($type == 'fixed') {
        if (isset($val) && $val >= 0) {
            $currency_symbol = $symbol ?? config('custom.currency_symbol');
            $currency_position = $position ?? config('custom.currency_position');

            if ($currency_position == 'right') {
                return number_format($val, 2) . $currency_symbol;
            } else {
                return $currency_symbol . number_format($val, 2);
            }
        }
    } else {
        return $val . '%';
    }
}

function formatDate($date)
{
    return date(config('custom.date_time_format'), strtotime($date));
}
function formatDateOnly($date)
{
    return date(config('custom.date_format'), strtotime($date));
}
function getSiteSetting()
{
    return Settings::pluck('value', 'title')->toArray();
}

function getAllCategories($branch_id)
{
    return \App\Models\Category::where('status', 'active')->where('branch_id', $branch_id)->orderBy('category_name', 'asc')->get();
}

function displayStatus($status)
{
    if ($status == 'active') {
        return '<span class="badge bg-success font-size-12">' . trans('system.crud.active') . '</span>';
    } elseif ($status == 'inactive') {
        return '<span class="badge bg-danger font-size-12">' . trans('system.crud.inactive') . '</span>';
    } elseif ($status == 'deleted') {
        return '<span class="badge bg-danger font-size-12">' . trans('system.crud.delete') . '</span>';
    }
}
function displayTicketStatus($status)
{
    if ($status == 'open') {
        return '<span class="badge text-uppercase bg-warning">' . trans('system.tickets.open') . '</span>';
    } elseif ($status == 'pending') {
        return '<span class="badge text-uppercase bg-info">' . trans('system.tickets.pending') . '</span>';
    } elseif ($status == 'resolved') {
        return '<span class="badge text-uppercase bg-success">' . trans('system.tickets.resolved') . '</span>';
    } elseif ($status == 'closed') {
        return '<span class="badge text-uppercase bg-success">' . trans('system.tickets.closed') . '</span>';
    }
}

function displayProductFeature($status)
{
    if ($status) {
        return '<span class="badge text-uppercase bg-success">' . trans('system.crud.yes') . '</span>';
    } else {
        return '<span class="badge text-uppercase bg-danger">' . trans('system.crud.no') . '</span>';
    }
}

function displayQuestionStatus($status)
{
    if ($status == 'published') {
        return '<span class="badge bg-success font-size-12">' . trans('system.questions.published') . '</span>';
    } elseif ($status == 'unpublished') {
        return '<span class="badge bg-danger font-size-12">' . trans('system.questions.unpublished') . '</span>';
    }
}

function displayFeedbackStatus($status)
{
    if ($status == 'approved') {
        return 'btn-success';
    } elseif ($status == 'rejected') {
        return 'btn-danger';
    } elseif ($status == 'pending') {
        return 'btn-info';
    }
}

function getAllFaList()
{
    return [
        "fas fa-address-book",
        "fas fa-address-card",
        "fas fa-adjust",
        "fas fa-anchor",
        "fas fa-archive",
        "fas fa-asterisk",
        "fas fa-at",
        "fas fa-balance-scale",
        "fas fa-ban",
        "fas fa-barcode",
        "fas fa-bars",
        "fas fa-bell",
        "fas fa-bicycle",
        "fas fa-binoculars",
        "fas fa-birthday-cake",
        "fas fa-bolt",
        "fas fa-bomb",
        "fas fa-book",
        "fas fa-bookmark",
        "fas fa-briefcase",
        "fas fa-bug",
        "fas fa-building",
        "fas fa-bullhorn",
        "fas fa-bullseye",
        "fas fa-bus",
        "fas fa-calculator",
        "fas fa-calendar",
        "fas fa-camera",
        "fas fa-car",
        "fas fa-caret-down",
        "fas fa-caret-left",
        "fas fa-caret-right",
        "fas fa-caret-up",
        "fas fa-chart-bar",
        "fas fa-check",
        "fas fa-check-circle",
        "fas fa-check-square",
        "fas fa-circle",
        "fas fa-clipboard",
        "fas fa-clock",
        "fas fa-clone",
        "fas fa-cloud",
        "fas fa-coffee",
        "fas fa-cog",
        "fas fa-cogs",
        "fas fa-comment",
        "fas fa-comments",
        "fas fa-compass",
        "fas fa-copy",
        "fas fa-credit-card",
        "fas fa-crop",
        "fas fa-crosshairs",
        "fas fa-cube",
        "fas fa-cubes",
        "fas fa-cut",
        "fas fa-database",
        "fas fa-desktop",
        "fas fa-dollar-sign",
        "fas fa-dot-circle",
        "fas fa-download",
        "fas fa-edit",
        "fas fa-eject",
        "fas fa-envelope",
        "fas fa-eraser",
        "fas fa-exclamation",
        "fas fa-exclamation-circle",
        "fas fa-exclamation-triangle",
        "fas fa-expand",
        "fas fa-eye",
        "fas fa-eye-dropper",
        "fas fa-eye-slash",
        "fas fa-fast-backward",
        "fas fa-fast-forward",
        "fas fa-fax",
        "fas fa-female",
        "fas fa-fighter-jet",
        "fas fa-file",
        "fas fa-file-alt",
        "fas fa-film",
        "fas fa-filter",
        "fas fa-fire",
        "fas fa-fire-extinguisher",
        "fas fa-flag",
        "fas fa-flag-checkered",
        "fas fa-flask",
        "fas fa-folder",
        "fas fa-folder-open",
        "fas fa-frown",
        "fas fa-futbol",
        "fas fa-gamepad",
        "fas fa-gavel",
        "fas fa-gem",
        "fas fa-gift",
        "fas fa-glass-martini",
        "fas fa-globe",
        "fas fa-graduation-cap",
        "fas fa-h-square",
        "fas fa-hand-paper",
        "fas fa-hand-peace",
        "fas fa-hand-point-down",
        "fas fa-hand-point-left",
        "fas fa-hand-point-right",
        "fas fa-hand-point-up",
        "fas fa-hand-rock",
        "fas fa-hand-scissors",
        "fas fa-hand-spock",
        "fas fa-handshake",
        "fas fa-hashtag",
        "fas fa-hdd",
        "fas fa-headphones",
        "fas fa-heart",
        "fas fa-heartbeat",
        "fas fa-history",
        "fas fa-home",
        "fas fa-hospital",
        "fas fa-hourglass",
        "fas fa-id-badge",
        "fas fa-id-card",
        "fas fa-image",
        "fas fa-images",
        "fas fa-inbox",
        "fas fa-indent",
        "fas fa-industry",
        "fas fa-info",
        "fas fa-info-circle",
        "fas fa-key",
        "fas fa-keyboard",
        "fas fa-language",
        "fas fa-laptop",
        "fas fa-leaf",
        "fas fa-lemon",
        "fas fa-life-ring",
        "fas fa-lightbulb",
        "fas fa-link",
        "fas fa-lira-sign",
        "fas fa-list",
        "fas fa-list-alt",
        "fas fa-location-arrow",
        "fas fa-lock",
        "fas fa-lock-open",
        "fas fa-magic",
        "fas fa-magnet",
        "fas fa-male",
        "fas fa-map",
        "fas fa-map-marker",
        "fas fa-map-marker-alt",
        "fas fa-map-pin",
        "fas fa-map-signs",
        "fas fa-medal",
        "fas fa-medkit",
        "fas fa-meh",
        "fas fa-memory",
        "fas fa-microphone",
        "fas fa-microphone-alt",
        "fas fa-microphone-slash",
        "fas fa-minus",
        "fas fa-minus-circle",
        "fas fa-minus-square",
        "fas fa-mobile",
        "fas fa-mobile-alt",
        "fas fa-money-bill",
        "fas fa-money-bill-alt",
        "fas fa-moon",
        "fas fa-motorcycle",
        "fas fa-mouse-pointer",
        "fas fa-music",
        "fas fa-newspaper",
        "fas fa-notes-medical",
        "fas fa-object-group",
        "fas fa-object-ungroup",
        "fas fa-paint-brush",
        "fas fa-paper-plane",
        "fas fa-paperclip",
        "fas fa-parachute-box",
        "fas fa-paragraph",
        "fas fa-paste",
        "fas fa-pause",
        "fas fa-pause-circle",
        "fas fa-paw",
        "fas fa-pen",
        "fas fa-pen-alt",
        "fas fa-pen-fancy",
        "fas fa-pen-nib",
        "fas fa-pen-square",
        "fas fa-pencil-alt",
        "fas fa-percent",
        "fas fa-percentage",
        "fas fa-phone",
        "fas fa-phone-alt",
        "fas fa-phone-slash",
        "fas fa-phone-square",
        "fas fa-phone-square-alt",
        "fas fa-photo-video",
        "fas fa-piggy-bank",
        "fas fa-pills",
        "fas fa-plane",
        "fas fa-play",
        "fas fa-play-circle",
        "fas fa-plug",
        "fas fa-plus",
        "fas fa-plus-circle",
        "fas fa-plus-square",
        "fas fa-podcast",
        "fas fa-poll",
        "fas fa-poll-h",
        "fas fa-poo",
        "fas fa-poo-storm",
        "fas fa-poop",
        "fas fa-portrait",
        "fas fa-pound-sign",
        "fas fa-power-off",
        "fas fa-print",
        "fas fa-procedures",
        "fas fa-project-diagram",
        "fas fa-puzzle-piece",
        "fas fa-qrcode",
        "fas fa-question",
        "fas fa-question-circle",
        "fas fa-quidditch",
        "fas fa-quote-left",
        "fas fa-quote-right",
        "fas fa-random",
        "fas fa-recycle",
        "fas fa-redo",
        "fas fa-redo-alt",
        "fas fa-registered",
        "fas fa-reply",
        "fas fa-reply-all",
        "fas fa-retweet",
        "fas fa-ribbon",
        "fas fa-road",
        "fas fa-rocket",
        "fas fa-rss",
        "fas fa-rss-square",
        "fas fa-ruble-sign",
        "fas fa-ruler",
        "fas fa-ruler-combined",
        "fas fa-ruler-horizontal",
        "fas fa-ruler-vertical",
        "fas fa-rupee-sign",
        "fas fa-sad-cry",
        "fas fa-sad-tear",
        "fas fa-save",
        "fas fa-school",
        "fas fa-screwdriver",
        "fas fa-search",
        "fas fa-search-minus",
        "fas fa-search-plus",
        "fas fa-seedling",
        "fas fa-server",
        "fas fa-shapes",
        "fas fa-share",
        "fas fa-share-alt",
        "fas fa-share-alt-square",
        "fas fa-share-square",
        "fas fa-shekel-sign",
        "fas fa-shield-alt",
        "fas fa-ship",
        "fas fa-shipping-fast",
        "fas fa-shoe-prints",
        "fas fa-shopping-bag",
        "fas fa-shopping-basket",
        "fas fa-shopping-cart",
        "fas fa-shower",
        "fas fa-shuttle-van",
        "fas fa-sign",
        "fas fa-sign-in-alt",
        "fas fa-sign-language",
        "fas fa-sign-out-alt",
        "fas fa-signal",
        "fas fa-signature",
        "fas fa-sitemap",
        "fas fa-skull",
        "fas fa-skull-crossbones",
        "fas fa-slash",
        "fas fa-sleigh",
        "fas fa-sliders-h",
        "fas fa-smile",
        "fas fa-smile-beam",
        "fas fa-smile-wink",
        "fas fa-smoking",
        "fas fa-smoking-ban",
        "fas fa-sms",
        "fas fa-snowflake",
        "fas fa-socks",
        "fas fa-solar-panel",
        "fas fa-sort",
        "fas fa-sort-alpha-down",
        "fas fa-sort-alpha-down-alt",
        "fas fa-sort-alpha-up",
        "fas fa-sort-alpha-up-alt",
        "fas fa-sort-amount-down",
        "fas fa-sort-amount-down-alt",
        "fas fa-sort-amount-up",
        "fas fa-sort-amount-up-alt",
        "fas fa-sort-down",
        "fas fa-sort-numeric-down",
        "fas fa-sort-numeric-down-alt",
        "fas fa-sort-numeric-up",
        "fas fa-sort-numeric-up-alt",
        "fas fa-sort-up",
        "fas fa-spa",
        "fas fa-space-shuttle",
        "fas fa-spider",
        "fas fa-spinner",
        "fas fa-splotch",
        "fas fa-spray-can",
        "fas fa-square",
        "fas fa-square-full",
        "fas fa-stamp",
        "fas fa-star",
        "fas fa-star-and-crescent",
        "fas fa-star-half",
        "fas fa-star-half-alt",
        "fas fa-star-of-david",
        "fas fa-star-of-life",
        "fas fa-step-backward",
        "fas fa-step-forward",
        "fas fa-stethoscope",
        "fas fa-sticky-note",
        "fas fa-stop",
        "fas fa-stop-circle",
        "fas fa-stopwatch",
        "fas fa-store",
        "fas fa-store-alt",
        "fas fa-stream",
        "fas fa-street-view",
        "fas fa-strikethrough",
        "fas fa-stroopwafel",
        "fas fa-subscript",
        "fas fa-subway",
        "fas fa-suitcase",
        "fas fa-suitcase-rolling",
        "fas fa-sun",
        "fas fa-superscript",
        "fas fa-surprise",
        "fas fa-swatchbook",
        "fas fa-swimmer",
        "fas fa-swimming-pool",
        "fas fa-synagogue",
        "fas fa-sync",
        "fas fa-sync-alt",
        "fas fa-syringe",
        "fas fa-table",
        "fas fa-table-tennis",
        "fas fa-tablet",
        "fas fa-tablet-alt",
        "fas fa-tablets",
        "fas fa-tachometer-alt",
        "fas fa-tag",
        "fas fa-tags",
        "fas fa-tape",
        "fas fa-tasks",
        "fas fa-taxi",
        "fas fa-teeth",
        "fas fa-teeth-open",
        "fas fa-temperature-high",
        "fas fa-temperature-low",
        "fas fa-tenge",
        "fas fa-terminal",
        "fas fa-text-height",
        "fas fa-text-width",
        "fas fa-th",
        "fas fa-th-large",
        "fas fa-th-list",
        "fas fa-theater-masks",
        "fas fa-thermometer",
        "fas fa-thermometer-empty",
        "fas fa-thermometer-full",
        "fas fa-thermometer-half",
        "fas fa-thermometer-quarter",
        "fas fa-thermometer-three-quarters",
        "fas fa-thumbs-down",
        "fas fa-thumbs-up",
        "fas fa-thumbtack",
        "fas fa-ticket-alt",
        "fas fa-times",
        "fas fa-times-circle",
        "fas fa-tint",
        "fas fa-tint-slash",
        "fas fa-tired",
        "fas fa-toggle-off",
        "fas fa-toggle-on",
        "fas fa-toolbox",
        "fas fa-tools",
        "fas fa-tooth",
        "fas fa-torah",
        "fas fa-torii-gate",
        "fas fa-tractor",
        "fas fa-trademark",
        "fas fa-traffic-light",
        "fas fa-train",
        "fas fa-tram",
        "fas fa-transgender",
        "fas fa-transgender-alt",
        "fas fa-trash",
        "fas fa-trash-alt",
        "fas fa-trash-restore",
        "fas fa-trash-restore-alt",
        "fas fa-tree",
        "fas fa-trophy",
        "fas fa-truck",
        "fas fa-truck-loading",
        "fas fa-truck-monster",
        "fas fa-truck-moving",
        "fas fa-truck-pickup",
        "fas fa-tshirt",
        "fas fa-tty",
        "fas fa-tv",
        "fas fa-umbrella",
        "fas fa-umbrella-beach",
        "fas fa-underline",
        "fas fa-undo",
        "fas fa-undo-alt",
        "fas fa-universal-access",
        "fas fa-university",
        "fas fa-unlink",
        "fas fa-unlock",
        "fas fa-unlock-alt",
        "fas fa-upload",
        "fas fa-user",
        "fas fa-user-alt",
        "fas fa-user-alt-slash",
        "fas fa-user-astronaut",
        "fas fa-user-check",
        "fas fa-user-circle",
        "fas fa-user-clock",
        "fas fa-user-cog",
        "fas fa-user-edit",
        "fas fa-user-friends",
        "fas fa-user-graduate",
        "fas fa-user-injured",
        "fas fa-user-lock",
        "fas fa-user-md",
        "fas fa-user-minus",
        "fas fa-user-ninja",
        "fas fa-user-nurse",
        "fas fa-user-plus",
        "fas fa-user-secret",
        "fas fa-user-shield",
        "fas fa-user-slash",
        "fas fa-user-tag",
        "fas fa-user-tie",
        "fas fa-user-times",
        "fas fa-users",
        "fas fa-users-cog",
        "fas fa-utensil-spoon",
        "fas fa-utensils",
        "fas fa-vector-square",
        "fas fa-venus",
        "fas fa-venus-double",
        "fas fa-venus-mars",
        "fas fa-vial",
        "fas fa-vials",
        "fas fa-video",
        "fas fa-video-slash",
        "fas fa-vihara",
        "fas fa-volleyball-ball",
        "fas fa-volume-down",
        "fas fa-volume-mute",
        "fas fa-volume-off",
        "fas fa-volume-up",
        "fas fa-vote-yea",
        "fas fa-vr-cardboard",
        "fas fa-walking",
        "fas fa-wallet",
        "fas fa-warehouse",
        "fas fa-water",
        "fas fa-wave-square",
        "fas fa-weight",
        "fas fa-weight-hanging",
        "fas fa-wheelchair",
        "fas fa-wifi",
        "fas fa-wind",
        "fas fa-window-close",
        "fas fa-window-maximize",
        "fas fa-window-minimize",
        "fas fa-window-restore",
        "fas fa-wine-bottle",
        "fas fa-wine-glass",
        "fas fa-wine-glass-alt",
        "fas fa-won-sign",
        "fas fa-wrench",
        "fas fa-x-ray",
        "fas fa-yen-sign",
        "fas fa-yin-yang"
    ];
}

function createdAgo($created_date)
{
    $datetime1 = new DateTime(date("Y-m-d H:i:s"));
    $datetime2 = new DateTime($created_date);
    $interval = $datetime1->diff($datetime2);

    $year = $interval->format('%y');
    $month = $interval->format('%m');
    $day = $interval->format('%d');
    $hour = $interval->format('%h');
    $minutes = ($interval->format('%i') != null) ? $interval->format('%i') : 0;

    if ($year != 0) {
        return $year . trans('system.support_portal.year_ago');
    } else if ($month != 0) {
        return $month . " " . trans('system.support_portal.month_ago');
    } else if ($day != 0) {
        return $day . " " . trans('system.support_portal.days_ago');
    } else if ($hour != 0) {
        return $hour . " " . trans('system.support_portal.hour_ago');
    } else if ($minutes != 0) {
        return $minutes . " " . trans('system.support_portal.minutes_ago');
    } else {
        return $minutes . " " . trans('system.support_portal.second_ago');
    }
}

function getTimezoneList()
{
    return ['Africa/Abidjan' => 'UTC/GMT +00:00 - Africa/Abidjan', 'Africa/Accra' => 'UTC/GMT +00:00 - Africa/Accra', 'Africa/Addis_Ababa' => 'UTC/GMT +03:00 - Africa/Addis_Ababa', 'Africa/Algiers' => 'UTC/GMT +01:00 - Africa/Algiers', 'Africa/Asmara' => 'UTC/GMT +03:00 - Africa/Asmara', 'Africa/Bamako' => 'UTC/GMT +00:00 - Africa/Bamako', 'Africa/Bangui' => 'UTC/GMT +01:00 - Africa/Bangui', 'Africa/Banjul' => 'UTC/GMT +00:00 - Africa/Banjul', 'Africa/Bissau' => 'UTC/GMT +00:00 - Africa/Bissau', 'Africa/Blantyre' => 'UTC/GMT +02:00 - Africa/Blantyre', 'Africa/Brazzaville' => 'UTC/GMT +01:00 - Africa/Brazzaville', 'Africa/Bujumbura' => 'UTC/GMT +02:00 - Africa/Bujumbura', 'Africa/Cairo' => 'UTC/GMT +02:00 - Africa/Cairo', 'Africa/Casablanca' => 'UTC/GMT +01:00 - Africa/Casablanca', 'Africa/Ceuta' => 'UTC/GMT +02:00 - Africa/Ceuta', 'Africa/Conakry' => 'UTC/GMT +00:00 - Africa/Conakry', 'Africa/Dakar' => 'UTC/GMT +00:00 - Africa/Dakar', 'Africa/Dar_es_Salaam' => 'UTC/GMT +03:00 - Africa/Dar_es_Salaam', 'Africa/Djibouti' => 'UTC/GMT +03:00 - Africa/Djibouti', 'Africa/Douala' => 'UTC/GMT +01:00 - Africa/Douala', 'Africa/El_Aaiun' => 'UTC/GMT +01:00 - Africa/El_Aaiun', 'Africa/Freetown' => 'UTC/GMT +00:00 - Africa/Freetown', 'Africa/Gaborone' => 'UTC/GMT +02:00 - Africa/Gaborone', 'Africa/Harare' => 'UTC/GMT +02:00 - Africa/Harare', 'Africa/Johannesburg' => 'UTC/GMT +02:00 - Africa/Johannesburg', 'Africa/Juba' => 'UTC/GMT +02:00 - Africa/Juba', 'Africa/Kampala' => 'UTC/GMT +03:00 - Africa/Kampala', 'Africa/Khartoum' => 'UTC/GMT +02:00 - Africa/Khartoum', 'Africa/Kigali' => 'UTC/GMT +02:00 - Africa/Kigali', 'Africa/Kinshasa' => 'UTC/GMT +01:00 - Africa/Kinshasa', 'Africa/Lagos' => 'UTC/GMT +01:00 - Africa/Lagos', 'Africa/Libreville' => 'UTC/GMT +01:00 - Africa/Libreville', 'Africa/Lome' => 'UTC/GMT +00:00 - Africa/Lome', 'Africa/Luanda' => 'UTC/GMT +01:00 - Africa/Luanda', 'Africa/Lubumbashi' => 'UTC/GMT +02:00 - Africa/Lubumbashi', 'Africa/Lusaka' => 'UTC/GMT +02:00 - Africa/Lusaka', 'Africa/Malabo' => 'UTC/GMT +01:00 - Africa/Malabo', 'Africa/Maputo' => 'UTC/GMT +02:00 - Africa/Maputo', 'Africa/Maseru' => 'UTC/GMT +02:00 - Africa/Maseru', 'Africa/Mbabane' => 'UTC/GMT +02:00 - Africa/Mbabane', 'Africa/Mogadishu' => 'UTC/GMT +03:00 - Africa/Mogadishu', 'Africa/Monrovia' => 'UTC/GMT +00:00 - Africa/Monrovia', 'Africa/Nairobi' => 'UTC/GMT +03:00 - Africa/Nairobi', 'Africa/Ndjamena' => 'UTC/GMT +01:00 - Africa/Ndjamena', 'Africa/Niamey' => 'UTC/GMT +01:00 - Africa/Niamey', 'Africa/Nouakchott' => 'UTC/GMT +00:00 - Africa/Nouakchott', 'Africa/Ouagadougou' => 'UTC/GMT +00:00 - Africa/Ouagadougou', 'Africa/Porto-Novo' => 'UTC/GMT +01:00 - Africa/Porto-Novo', 'Africa/Sao_Tome' => 'UTC/GMT +00:00 - Africa/Sao_Tome', 'Africa/Tripoli' => 'UTC/GMT +02:00 - Africa/Tripoli', 'Africa/Tunis' => 'UTC/GMT +01:00 - Africa/Tunis', 'Africa/Windhoek' => 'UTC/GMT +02:00 - Africa/Windhoek', 'America/Adak' => 'UTC/GMT -09:00 - America/Adak', 'America/Anchorage' => 'UTC/GMT -08:00 - America/Anchorage', 'America/Anguilla' => 'UTC/GMT -04:00 - America/Anguilla', 'America/Antigua' => 'UTC/GMT -04:00 - America/Antigua', 'America/Araguaina' => 'UTC/GMT -03:00 - America/Araguaina', 'America/Argentina/Buenos_Aires' => 'UTC/GMT -03:00 - America/Argentina/Buenos_Aires', 'America/Argentina/Catamarca' => 'UTC/GMT -03:00 - America/Argentina/Catamarca', 'America/Argentina/Cordoba' => 'UTC/GMT -03:00 - America/Argentina/Cordoba', 'America/Argentina/Jujuy' => 'UTC/GMT -03:00 - America/Argentina/Jujuy', 'America/Argentina/La_Rioja' => 'UTC/GMT -03:00 - America/Argentina/La_Rioja', 'America/Argentina/Mendoza' => 'UTC/GMT -03:00 - America/Argentina/Mendoza', 'America/Argentina/Rio_Gallegos' => 'UTC/GMT -03:00 - America/Argentina/Rio_Gallegos', 'America/Argentina/Salta' => 'UTC/GMT -03:00 - America/Argentina/Salta', 'America/Argentina/San_Juan' => 'UTC/GMT -03:00 - America/Argentina/San_Juan', 'America/Argentina/San_Luis' => 'UTC/GMT -03:00 - America/Argentina/San_Luis', 'America/Argentina/Tucuman' => 'UTC/GMT -03:00 - America/Argentina/Tucuman', 'America/Argentina/Ushuaia' => 'UTC/GMT -03:00 - America/Argentina/Ushuaia', 'America/Aruba' => 'UTC/GMT -04:00 - America/Aruba', 'America/Asuncion' => 'UTC/GMT -04:00 - America/Asuncion', 'America/Atikokan' => 'UTC/GMT -05:00 - America/Atikokan', 'America/Bahia' => 'UTC/GMT -03:00 - America/Bahia', 'America/Bahia_Banderas' => 'UTC/GMT -05:00 - America/Bahia_Banderas', 'America/Barbados' => 'UTC/GMT -04:00 - America/Barbados', 'America/Belem' => 'UTC/GMT -03:00 - America/Belem', 'America/Belize' => 'UTC/GMT -06:00 - America/Belize', 'America/Blanc-Sablon' => 'UTC/GMT -04:00 - America/Blanc-Sablon', 'America/Boa_Vista' => 'UTC/GMT -04:00 - America/Boa_Vista', 'America/Bogota' => 'UTC/GMT -05:00 - America/Bogota', 'America/Boise' => 'UTC/GMT -06:00 - America/Boise', 'America/Cambridge_Bay' => 'UTC/GMT -06:00 - America/Cambridge_Bay', 'America/Campo_Grande' => 'UTC/GMT -04:00 - America/Campo_Grande', 'America/Cancun' => 'UTC/GMT -05:00 - America/Cancun', 'America/Caracas' => 'UTC/GMT -04:00 - America/Caracas', 'America/Cayenne' => 'UTC/GMT -03:00 - America/Cayenne', 'America/Cayman' => 'UTC/GMT -05:00 - America/Cayman', 'America/Chicago' => 'UTC/GMT -05:00 - America/Chicago', 'America/Chihuahua' => 'UTC/GMT -06:00 - America/Chihuahua', 'America/Costa_Rica' => 'UTC/GMT -06:00 - America/Costa_Rica', 'America/Creston' => 'UTC/GMT -07:00 - America/Creston', 'America/Cuiaba' => 'UTC/GMT -04:00 - America/Cuiaba', 'America/Curacao' => 'UTC/GMT -04:00 - America/Curacao', 'America/Danmarkshavn' => 'UTC/GMT +00:00 - America/Danmarkshavn', 'America/Dawson' => 'UTC/GMT -07:00 - America/Dawson', 'America/Dawson_Creek' => 'UTC/GMT -07:00 - America/Dawson_Creek', 'America/Denver' => 'UTC/GMT -06:00 - America/Denver', 'America/Detroit' => 'UTC/GMT -04:00 - America/Detroit', 'America/Dominica' => 'UTC/GMT -04:00 - America/Dominica', 'America/Edmonton' => 'UTC/GMT -06:00 - America/Edmonton', 'America/Eirunepe' => 'UTC/GMT -05:00 - America/Eirunepe', 'America/El_Salvador' => 'UTC/GMT -06:00 - America/El_Salvador', 'America/Fort_Nelson' => 'UTC/GMT -07:00 - America/Fort_Nelson', 'America/Fortaleza' => 'UTC/GMT -03:00 - America/Fortaleza', 'America/Glace_Bay' => 'UTC/GMT -03:00 - America/Glace_Bay', 'America/Goose_Bay' => 'UTC/GMT -03:00 - America/Goose_Bay', 'America/Grand_Turk' => 'UTC/GMT -04:00 - America/Grand_Turk', 'America/Grenada' => 'UTC/GMT -04:00 - America/Grenada', 'America/Guadeloupe' => 'UTC/GMT -04:00 - America/Guadeloupe', 'America/Guatemala' => 'UTC/GMT -06:00 - America/Guatemala', 'America/Guayaquil' => 'UTC/GMT -05:00 - America/Guayaquil', 'America/Guyana' => 'UTC/GMT -04:00 - America/Guyana', 'America/Halifax' => 'UTC/GMT -03:00 - America/Halifax', 'America/Havana' => 'UTC/GMT -04:00 - America/Havana', 'America/Hermosillo' => 'UTC/GMT -07:00 - America/Hermosillo', 'America/Indiana/Indianapolis' => 'UTC/GMT -04:00 - America/Indiana/Indianapolis', 'America/Indiana/Knox' => 'UTC/GMT -05:00 - America/Indiana/Knox', 'America/Indiana/Marengo' => 'UTC/GMT -04:00 - America/Indiana/Marengo', 'America/Indiana/Petersburg' => 'UTC/GMT -04:00 - America/Indiana/Petersburg', 'America/Indiana/Tell_City' => 'UTC/GMT -05:00 - America/Indiana/Tell_City', 'America/Indiana/Vevay' => 'UTC/GMT -04:00 - America/Indiana/Vevay', 'America/Indiana/Vincennes' => 'UTC/GMT -04:00 - America/Indiana/Vincennes', 'America/Indiana/Winamac' => 'UTC/GMT -04:00 - America/Indiana/Winamac', 'America/Inuvik' => 'UTC/GMT -06:00 - America/Inuvik', 'America/Iqaluit' => 'UTC/GMT -04:00 - America/Iqaluit', 'America/Jamaica' => 'UTC/GMT -05:00 - America/Jamaica', 'America/Juneau' => 'UTC/GMT -08:00 - America/Juneau', 'America/Kentucky/Louisville' => 'UTC/GMT -04:00 - America/Kentucky/Louisville', 'America/Kentucky/Monticello' => 'UTC/GMT -04:00 - America/Kentucky/Monticello', 'America/Kralendijk' => 'UTC/GMT -04:00 - America/Kralendijk', 'America/La_Paz' => 'UTC/GMT -04:00 - America/La_Paz', 'America/Lima' => 'UTC/GMT -05:00 - America/Lima', 'America/Los_Angeles' => 'UTC/GMT -07:00 - America/Los_Angeles', 'America/Lower_Princes' => 'UTC/GMT -04:00 - America/Lower_Princes', 'America/Maceio' => 'UTC/GMT -03:00 - America/Maceio', 'America/Managua' => 'UTC/GMT -06:00 - America/Managua', 'America/Manaus' => 'UTC/GMT -04:00 - America/Manaus', 'America/Marigot' => 'UTC/GMT -04:00 - America/Marigot', 'America/Martinique' => 'UTC/GMT -04:00 - America/Martinique', 'America/Matamoros' => 'UTC/GMT -05:00 - America/Matamoros', 'America/Mazatlan' => 'UTC/GMT -06:00 - America/Mazatlan', 'America/Menominee' => 'UTC/GMT -05:00 - America/Menominee', 'America/Merida' => 'UTC/GMT -05:00 - America/Merida', 'America/Metlakatla' => 'UTC/GMT -08:00 - America/Metlakatla', 'America/Mexico_City' => 'UTC/GMT -05:00 - America/Mexico_City', 'America/Miquelon' => 'UTC/GMT -02:00 - America/Miquelon', 'America/Moncton' => 'UTC/GMT -03:00 - America/Moncton', 'America/Monterrey' => 'UTC/GMT -05:00 - America/Monterrey', 'America/Montevideo' => 'UTC/GMT -03:00 - America/Montevideo', 'America/Montserrat' => 'UTC/GMT -04:00 - America/Montserrat', 'America/Nassau' => 'UTC/GMT -04:00 - America/Nassau', 'America/New_York' => 'UTC/GMT -04:00 - America/New_York', 'America/Nipigon' => 'UTC/GMT -04:00 - America/Nipigon', 'America/Nome' => 'UTC/GMT -08:00 - America/Nome', 'America/Noronha' => 'UTC/GMT -02:00 - America/Noronha', 'America/North_Dakota/Beulah' => 'UTC/GMT -05:00 - America/North_Dakota/Beulah', 'America/North_Dakota/Center' => 'UTC/GMT -05:00 - America/North_Dakota/Center', 'America/North_Dakota/New_Salem' => 'UTC/GMT -05:00 - America/North_Dakota/New_Salem', 'America/Nuuk' => 'UTC/GMT -02:00 - America/Nuuk', 'America/Ojinaga' => 'UTC/GMT -06:00 - America/Ojinaga', 'America/Panama' => 'UTC/GMT -05:00 - America/Panama', 'America/Pangnirtung' => 'UTC/GMT -04:00 - America/Pangnirtung', 'America/Paramaribo' => 'UTC/GMT -03:00 - America/Paramaribo', 'America/Phoenix' => 'UTC/GMT -07:00 - America/Phoenix', 'America/Port-au-Prince' => 'UTC/GMT -04:00 - America/Port-au-Prince', 'America/Port_of_Spain' => 'UTC/GMT -04:00 - America/Port_of_Spain', 'America/Porto_Velho' => 'UTC/GMT -04:00 - America/Porto_Velho', 'America/Puerto_Rico' => 'UTC/GMT -04:00 - America/Puerto_Rico', 'America/Punta_Arenas' => 'UTC/GMT -03:00 - America/Punta_Arenas', 'America/Rainy_River' => 'UTC/GMT -05:00 - America/Rainy_River', 'America/Rankin_Inlet' => 'UTC/GMT -05:00 - America/Rankin_Inlet', 'America/Recife' => 'UTC/GMT -03:00 - America/Recife', 'America/Regina' => 'UTC/GMT -06:00 - America/Regina', 'America/Resolute' => 'UTC/GMT -05:00 - America/Resolute', 'America/Rio_Branco' => 'UTC/GMT -05:00 - America/Rio_Branco', 'America/Santarem' => 'UTC/GMT -03:00 - America/Santarem', 'America/Santiago' => 'UTC/GMT -04:00 - America/Santiago', 'America/Santo_Domingo' => 'UTC/GMT -04:00 - America/Santo_Domingo', 'America/Sao_Paulo' => 'UTC/GMT -03:00 - America/Sao_Paulo', 'America/Scoresbysund' => 'UTC/GMT +00:00 - America/Scoresbysund', 'America/Sitka' => 'UTC/GMT -08:00 - America/Sitka', 'America/St_Barthelemy' => 'UTC/GMT -04:00 - America/St_Barthelemy', 'America/St_Johns' => 'UTC/GMT -02:30 - America/St_Johns', 'America/St_Kitts' => 'UTC/GMT -04:00 - America/St_Kitts', 'America/St_Lucia' => 'UTC/GMT -04:00 - America/St_Lucia', 'America/St_Thomas' => 'UTC/GMT -04:00 - America/St_Thomas', 'America/St_Vincent' => 'UTC/GMT -04:00 - America/St_Vincent', 'America/Swift_Current' => 'UTC/GMT -06:00 - America/Swift_Current', 'America/Tegucigalpa' => 'UTC/GMT -06:00 - America/Tegucigalpa', 'America/Thule' => 'UTC/GMT -03:00 - America/Thule', 'America/Thunder_Bay' => 'UTC/GMT -04:00 - America/Thunder_Bay', 'America/Tijuana' => 'UTC/GMT -07:00 - America/Tijuana', 'America/Toronto' => 'UTC/GMT -04:00 - America/Toronto', 'America/Tortola' => 'UTC/GMT -04:00 - America/Tortola', 'America/Vancouver' => 'UTC/GMT -07:00 - America/Vancouver', 'America/Whitehorse' => 'UTC/GMT -07:00 - America/Whitehorse', 'America/Winnipeg' => 'UTC/GMT -05:00 - America/Winnipeg', 'America/Yakutat' => 'UTC/GMT -08:00 - America/Yakutat', 'America/Yellowknife' => 'UTC/GMT -06:00 - America/Yellowknife', 'Antarctica/Casey' => 'UTC/GMT +11:00 - Antarctica/Casey', 'Antarctica/Davis' => 'UTC/GMT +07:00 - Antarctica/Davis', 'Antarctica/DumontDUrville' => 'UTC/GMT +10:00 - Antarctica/DumontDUrville', 'Antarctica/Macquarie' => 'UTC/GMT +10:00 - Antarctica/Macquarie', 'Antarctica/Mawson' => 'UTC/GMT +05:00 - Antarctica/Mawson', 'Antarctica/McMurdo' => 'UTC/GMT +12:00 - Antarctica/McMurdo', 'Antarctica/Palmer' => 'UTC/GMT -03:00 - Antarctica/Palmer', 'Antarctica/Rothera' => 'UTC/GMT -03:00 - Antarctica/Rothera', 'Antarctica/Syowa' => 'UTC/GMT +03:00 - Antarctica/Syowa', 'Antarctica/Troll' => 'UTC/GMT +02:00 - Antarctica/Troll', 'Antarctica/Vostok' => 'UTC/GMT +06:00 - Antarctica/Vostok', 'Arctic/Longyearbyen' => 'UTC/GMT +02:00 - Arctic/Longyearbyen', 'Asia/Aden' => 'UTC/GMT +03:00 - Asia/Aden', 'Asia/Almaty' => 'UTC/GMT +06:00 - Asia/Almaty', 'Asia/Amman' => 'UTC/GMT +03:00 - Asia/Amman', 'Asia/Anadyr' => 'UTC/GMT +12:00 - Asia/Anadyr', 'Asia/Aqtau' => 'UTC/GMT +05:00 - Asia/Aqtau', 'Asia/Aqtobe' => 'UTC/GMT +05:00 - Asia/Aqtobe', 'Asia/Ashgabat' => 'UTC/GMT +05:00 - Asia/Ashgabat', 'Asia/Atyrau' => 'UTC/GMT +05:00 - Asia/Atyrau', 'Asia/Baghdad' => 'UTC/GMT +03:00 - Asia/Baghdad', 'Asia/Bahrain' => 'UTC/GMT +03:00 - Asia/Bahrain', 'Asia/Baku' => 'UTC/GMT +04:00 - Asia/Baku', 'Asia/Bangkok' => 'UTC/GMT +07:00 - Asia/Bangkok', 'Asia/Barnaul' => 'UTC/GMT +07:00 - Asia/Barnaul', 'Asia/Beirut' => 'UTC/GMT +03:00 - Asia/Beirut', 'Asia/Bishkek' => 'UTC/GMT +06:00 - Asia/Bishkek', 'Asia/Brunei' => 'UTC/GMT +08:00 - Asia/Brunei', 'Asia/Chita' => 'UTC/GMT +09:00 - Asia/Chita', 'Asia/Choibalsan' => 'UTC/GMT +08:00 - Asia/Choibalsan', 'Asia/Colombo' => 'UTC/GMT +05:30 - Asia/Colombo', 'Asia/Damascus' => 'UTC/GMT +03:00 - Asia/Damascus', 'Asia/Dhaka' => 'UTC/GMT +06:00 - Asia/Dhaka', 'Asia/Dili' => 'UTC/GMT +09:00 - Asia/Dili', 'Asia/Dubai' => 'UTC/GMT +04:00 - Asia/Dubai', 'Asia/Dushanbe' => 'UTC/GMT +05:00 - Asia/Dushanbe', 'Asia/Famagusta' => 'UTC/GMT +03:00 - Asia/Famagusta', 'Asia/Gaza' => 'UTC/GMT +03:00 - Asia/Gaza', 'Asia/Hebron' => 'UTC/GMT +03:00 - Asia/Hebron', 'Asia/Ho_Chi_Minh' => 'UTC/GMT +07:00 - Asia/Ho_Chi_Minh', 'Asia/Hong_Kong' => 'UTC/GMT +08:00 - Asia/Hong_Kong', 'Asia/Hovd' => 'UTC/GMT +07:00 - Asia/Hovd', 'Asia/Irkutsk' => 'UTC/GMT +08:00 - Asia/Irkutsk', 'Asia/Jakarta' => 'UTC/GMT +07:00 - Asia/Jakarta', 'Asia/Jayapura' => 'UTC/GMT +09:00 - Asia/Jayapura', 'Asia/Jerusalem' => 'UTC/GMT +03:00 - Asia/Jerusalem', 'Asia/Kabul' => 'UTC/GMT +04:30 - Asia/Kabul', 'Asia/Kamchatka' => 'UTC/GMT +12:00 - Asia/Kamchatka', 'Asia/Karachi' => 'UTC/GMT +05:00 - Asia/Karachi', 'Asia/Kathmandu' => 'UTC/GMT +05:45 - Asia/Kathmandu', 'Asia/Khandyga' => 'UTC/GMT +09:00 - Asia/Khandyga', 'Asia/Kolkata' => 'UTC/GMT +05:30 - Asia/Kolkata', 'Asia/Krasnoyarsk' => 'UTC/GMT +07:00 - Asia/Krasnoyarsk', 'Asia/Kuala_Lumpur' => 'UTC/GMT +08:00 - Asia/Kuala_Lumpur', 'Asia/Kuching' => 'UTC/GMT +08:00 - Asia/Kuching', 'Asia/Kuwait' => 'UTC/GMT +03:00 - Asia/Kuwait', 'Asia/Macau' => 'UTC/GMT +08:00 - Asia/Macau', 'Asia/Magadan' => 'UTC/GMT +11:00 - Asia/Magadan', 'Asia/Makassar' => 'UTC/GMT +08:00 - Asia/Makassar', 'Asia/Manila' => 'UTC/GMT +08:00 - Asia/Manila', 'Asia/Muscat' => 'UTC/GMT +04:00 - Asia/Muscat', 'Asia/Nicosia' => 'UTC/GMT +03:00 - Asia/Nicosia', 'Asia/Novokuznetsk' => 'UTC/GMT +07:00 - Asia/Novokuznetsk', 'Asia/Novosibirsk' => 'UTC/GMT +07:00 - Asia/Novosibirsk', 'Asia/Omsk' => 'UTC/GMT +06:00 - Asia/Omsk', 'Asia/Oral' => 'UTC/GMT +05:00 - Asia/Oral', 'Asia/Phnom_Penh' => 'UTC/GMT +07:00 - Asia/Phnom_Penh', 'Asia/Pontianak' => 'UTC/GMT +07:00 - Asia/Pontianak', 'Asia/Pyongyang' => 'UTC/GMT +09:00 - Asia/Pyongyang', 'Asia/Qatar' => 'UTC/GMT +03:00 - Asia/Qatar', 'Asia/Qostanay' => 'UTC/GMT +06:00 - Asia/Qostanay', 'Asia/Qyzylorda' => 'UTC/GMT +05:00 - Asia/Qyzylorda', 'Asia/Riyadh' => 'UTC/GMT +03:00 - Asia/Riyadh', 'Asia/Sakhalin' => 'UTC/GMT +11:00 - Asia/Sakhalin', 'Asia/Samarkand' => 'UTC/GMT +05:00 - Asia/Samarkand', 'Asia/Seoul' => 'UTC/GMT +09:00 - Asia/Seoul', 'Asia/Shanghai' => 'UTC/GMT +08:00 - Asia/Shanghai', 'Asia/Singapore' => 'UTC/GMT +08:00 - Asia/Singapore', 'Asia/Srednekolymsk' => 'UTC/GMT +11:00 - Asia/Srednekolymsk', 'Asia/Taipei' => 'UTC/GMT +08:00 - Asia/Taipei', 'Asia/Tashkent' => 'UTC/GMT +05:00 - Asia/Tashkent', 'Asia/Tbilisi' => 'UTC/GMT +04:00 - Asia/Tbilisi', 'Asia/Tehran' => 'UTC/GMT +04:30 - Asia/Tehran', 'Asia/Thimphu' => 'UTC/GMT +06:00 - Asia/Thimphu', 'Asia/Tokyo' => 'UTC/GMT +09:00 - Asia/Tokyo', 'Asia/Tomsk' => 'UTC/GMT +07:00 - Asia/Tomsk', 'Asia/Ulaanbaatar' => 'UTC/GMT +08:00 - Asia/Ulaanbaatar', 'Asia/Urumqi' => 'UTC/GMT +06:00 - Asia/Urumqi', 'Asia/Ust-Nera' => 'UTC/GMT +10:00 - Asia/Ust-Nera', 'Asia/Vientiane' => 'UTC/GMT +07:00 - Asia/Vientiane', 'Asia/Vladivostok' => 'UTC/GMT +10:00 - Asia/Vladivostok', 'Asia/Yakutsk' => 'UTC/GMT +09:00 - Asia/Yakutsk', 'Asia/Yangon' => 'UTC/GMT +06:30 - Asia/Yangon', 'Asia/Yekaterinburg' => 'UTC/GMT +05:00 - Asia/Yekaterinburg', 'Asia/Yerevan' => 'UTC/GMT +04:00 - Asia/Yerevan', 'Atlantic/Azores' => 'UTC/GMT +00:00 - Atlantic/Azores', 'Atlantic/Bermuda' => 'UTC/GMT -03:00 - Atlantic/Bermuda', 'Atlantic/Canary' => 'UTC/GMT +01:00 - Atlantic/Canary', 'Atlantic/Cape_Verde' => 'UTC/GMT -01:00 - Atlantic/Cape_Verde', 'Atlantic/Faroe' => 'UTC/GMT +01:00 - Atlantic/Faroe', 'Atlantic/Madeira' => 'UTC/GMT +01:00 - Atlantic/Madeira', 'Atlantic/Reykjavik' => 'UTC/GMT +00:00 - Atlantic/Reykjavik', 'Atlantic/South_Georgia' => 'UTC/GMT -02:00 - Atlantic/South_Georgia', 'Atlantic/St_Helena' => 'UTC/GMT +00:00 - Atlantic/St_Helena', 'Atlantic/Stanley' => 'UTC/GMT -03:00 - Atlantic/Stanley', 'Australia/Adelaide' => 'UTC/GMT +09:30 - Australia/Adelaide', 'Australia/Brisbane' => 'UTC/GMT +10:00 - Australia/Brisbane', 'Australia/Broken_Hill' => 'UTC/GMT +09:30 - Australia/Broken_Hill', 'Australia/Darwin' => 'UTC/GMT +09:30 - Australia/Darwin', 'Australia/Eucla' => 'UTC/GMT +08:45 - Australia/Eucla', 'Australia/Hobart' => 'UTC/GMT +10:00 - Australia/Hobart', 'Australia/Lindeman' => 'UTC/GMT +10:00 - Australia/Lindeman', 'Australia/Lord_Howe' => 'UTC/GMT +10:30 - Australia/Lord_Howe', 'Australia/Melbourne' => 'UTC/GMT +10:00 - Australia/Melbourne', 'Australia/Perth' => 'UTC/GMT +08:00 - Australia/Perth', 'Australia/Sydney' => 'UTC/GMT +10:00 - Australia/Sydney', 'Europe/Amsterdam' => 'UTC/GMT +02:00 - Europe/Amsterdam', 'Europe/Andorra' => 'UTC/GMT +02:00 - Europe/Andorra', 'Europe/Astrakhan' => 'UTC/GMT +04:00 - Europe/Astrakhan', 'Europe/Athens' => 'UTC/GMT +03:00 - Europe/Athens', 'Europe/Belgrade' => 'UTC/GMT +02:00 - Europe/Belgrade', 'Europe/Berlin' => 'UTC/GMT +02:00 - Europe/Berlin', 'Europe/Bratislava' => 'UTC/GMT +02:00 - Europe/Bratislava', 'Europe/Brussels' => 'UTC/GMT +02:00 - Europe/Brussels', 'Europe/Bucharest' => 'UTC/GMT +03:00 - Europe/Bucharest', 'Europe/Budapest' => 'UTC/GMT +02:00 - Europe/Budapest', 'Europe/Busingen' => 'UTC/GMT +02:00 - Europe/Busingen', 'Europe/Chisinau' => 'UTC/GMT +03:00 - Europe/Chisinau', 'Europe/Copenhagen' => 'UTC/GMT +02:00 - Europe/Copenhagen', 'Europe/Dublin' => 'UTC/GMT +01:00 - Europe/Dublin', 'Europe/Gibraltar' => 'UTC/GMT +02:00 - Europe/Gibraltar', 'Europe/Guernsey' => 'UTC/GMT +01:00 - Europe/Guernsey', 'Europe/Helsinki' => 'UTC/GMT +03:00 - Europe/Helsinki', 'Europe/Isle_of_Man' => 'UTC/GMT +01:00 - Europe/Isle_of_Man', 'Europe/Istanbul' => 'UTC/GMT +03:00 - Europe/Istanbul', 'Europe/Jersey' => 'UTC/GMT +01:00 - Europe/Jersey', 'Europe/Kaliningrad' => 'UTC/GMT +02:00 - Europe/Kaliningrad', 'Europe/Kiev' => 'UTC/GMT +03:00 - Europe/Kiev', 'Europe/Kirov' => 'UTC/GMT +03:00 - Europe/Kirov', 'Europe/Lisbon' => 'UTC/GMT +01:00 - Europe/Lisbon', 'Europe/Ljubljana' => 'UTC/GMT +02:00 - Europe/Ljubljana', 'Europe/London' => 'UTC/GMT +01:00 - Europe/London', 'Europe/Luxembourg' => 'UTC/GMT +02:00 - Europe/Luxembourg', 'Europe/Madrid' => 'UTC/GMT +02:00 - Europe/Madrid', 'Europe/Malta' => 'UTC/GMT +02:00 - Europe/Malta', 'Europe/Mariehamn' => 'UTC/GMT +03:00 - Europe/Mariehamn', 'Europe/Minsk' => 'UTC/GMT +03:00 - Europe/Minsk', 'Europe/Monaco' => 'UTC/GMT +02:00 - Europe/Monaco', 'Europe/Moscow' => 'UTC/GMT +03:00 - Europe/Moscow', 'Europe/Oslo' => 'UTC/GMT +02:00 - Europe/Oslo', 'Europe/Paris' => 'UTC/GMT +02:00 - Europe/Paris', 'Europe/Podgorica' => 'UTC/GMT +02:00 - Europe/Podgorica', 'Europe/Prague' => 'UTC/GMT +02:00 - Europe/Prague', 'Europe/Riga' => 'UTC/GMT +03:00 - Europe/Riga', 'Europe/Rome' => 'UTC/GMT +02:00 - Europe/Rome', 'Europe/Samara' => 'UTC/GMT +04:00 - Europe/Samara', 'Europe/San_Marino' => 'UTC/GMT +02:00 - Europe/San_Marino', 'Europe/Sarajevo' => 'UTC/GMT +02:00 - Europe/Sarajevo', 'Europe/Saratov' => 'UTC/GMT +04:00 - Europe/Saratov', 'Europe/Simferopol' => 'UTC/GMT +03:00 - Europe/Simferopol', 'Europe/Skopje' => 'UTC/GMT +02:00 - Europe/Skopje', 'Europe/Sofia' => 'UTC/GMT +03:00 - Europe/Sofia', 'Europe/Stockholm' => 'UTC/GMT +02:00 - Europe/Stockholm', 'Europe/Tallinn' => 'UTC/GMT +03:00 - Europe/Tallinn', 'Europe/Tirane' => 'UTC/GMT +02:00 - Europe/Tirane', 'Europe/Ulyanovsk' => 'UTC/GMT +04:00 - Europe/Ulyanovsk', 'Europe/Uzhgorod' => 'UTC/GMT +03:00 - Europe/Uzhgorod', 'Europe/Vaduz' => 'UTC/GMT +02:00 - Europe/Vaduz', 'Europe/Vatican' => 'UTC/GMT +02:00 - Europe/Vatican', 'Europe/Vienna' => 'UTC/GMT +02:00 - Europe/Vienna', 'Europe/Vilnius' => 'UTC/GMT +03:00 - Europe/Vilnius', 'Europe/Volgograd' => 'UTC/GMT +03:00 - Europe/Volgograd', 'Europe/Warsaw' => 'UTC/GMT +02:00 - Europe/Warsaw', 'Europe/Zagreb' => 'UTC/GMT +02:00 - Europe/Zagreb', 'Europe/Zaporozhye' => 'UTC/GMT +03:00 - Europe/Zaporozhye', 'Europe/Zurich' => 'UTC/GMT +02:00 - Europe/Zurich', 'Indian/Antananarivo' => 'UTC/GMT +03:00 - Indian/Antananarivo', 'Indian/Chagos' => 'UTC/GMT +06:00 - Indian/Chagos', 'Indian/Christmas' => 'UTC/GMT +07:00 - Indian/Christmas', 'Indian/Cocos' => 'UTC/GMT +06:30 - Indian/Cocos', 'Indian/Comoro' => 'UTC/GMT +03:00 - Indian/Comoro', 'Indian/Kerguelen' => 'UTC/GMT +05:00 - Indian/Kerguelen', 'Indian/Mahe' => 'UTC/GMT +04:00 - Indian/Mahe', 'Indian/Maldives' => 'UTC/GMT +05:00 - Indian/Maldives', 'Indian/Mauritius' => 'UTC/GMT +04:00 - Indian/Mauritius', 'Indian/Mayotte' => 'UTC/GMT +03:00 - Indian/Mayotte', 'Indian/Reunion' => 'UTC/GMT +04:00 - Indian/Reunion', 'Pacific/Apia' => 'UTC/GMT +13:00 - Pacific/Apia', 'Pacific/Auckland' => 'UTC/GMT +12:00 - Pacific/Auckland', 'Pacific/Bougainville' => 'UTC/GMT +11:00 - Pacific/Bougainville', 'Pacific/Chatham' => 'UTC/GMT +12:45 - Pacific/Chatham', 'Pacific/Chuuk' => 'UTC/GMT +10:00 - Pacific/Chuuk', 'Pacific/Easter' => 'UTC/GMT -06:00 - Pacific/Easter', 'Pacific/Efate' => 'UTC/GMT +11:00 - Pacific/Efate', 'Pacific/Fakaofo' => 'UTC/GMT +13:00 - Pacific/Fakaofo', 'Pacific/Fiji' => 'UTC/GMT +12:00 - Pacific/Fiji', 'Pacific/Funafuti' => 'UTC/GMT +12:00 - Pacific/Funafuti', 'Pacific/Galapagos' => 'UTC/GMT -06:00 - Pacific/Galapagos', 'Pacific/Gambier' => 'UTC/GMT -09:00 - Pacific/Gambier', 'Pacific/Guadalcanal' => 'UTC/GMT +11:00 - Pacific/Guadalcanal', 'Pacific/Guam' => 'UTC/GMT +10:00 - Pacific/Guam', 'Pacific/Honolulu' => 'UTC/GMT -10:00 - Pacific/Honolulu', 'Pacific/Kanton' => 'UTC/GMT +13:00 - Pacific/Kanton', 'Pacific/Kiritimati' => 'UTC/GMT +14:00 - Pacific/Kiritimati', 'Pacific/Kosrae' => 'UTC/GMT +11:00 - Pacific/Kosrae', 'Pacific/Kwajalein' => 'UTC/GMT +12:00 - Pacific/Kwajalein', 'Pacific/Majuro' => 'UTC/GMT +12:00 - Pacific/Majuro', 'Pacific/Marquesas' => 'UTC/GMT -09:30 - Pacific/Marquesas', 'Pacific/Midway' => 'UTC/GMT -11:00 - Pacific/Midway', 'Pacific/Nauru' => 'UTC/GMT +12:00 - Pacific/Nauru', 'Pacific/Niue' => 'UTC/GMT -11:00 - Pacific/Niue', 'Pacific/Norfolk' => 'UTC/GMT +11:00 - Pacific/Norfolk', 'Pacific/Noumea' => 'UTC/GMT +11:00 - Pacific/Noumea', 'Pacific/Pago_Pago' => 'UTC/GMT -11:00 - Pacific/Pago_Pago', 'Pacific/Palau' => 'UTC/GMT +09:00 - Pacific/Palau', 'Pacific/Pitcairn' => 'UTC/GMT -08:00 - Pacific/Pitcairn', 'Pacific/Pohnpei' => 'UTC/GMT +11:00 - Pacific/Pohnpei', 'Pacific/Port_Moresby' => 'UTC/GMT +10:00 - Pacific/Port_Moresby', 'Pacific/Rarotonga' => 'UTC/GMT -10:00 - Pacific/Rarotonga', 'Pacific/Saipan' => 'UTC/GMT +10:00 - Pacific/Saipan', 'Pacific/Tahiti' => 'UTC/GMT -10:00 - Pacific/Tahiti', 'Pacific/Tarawa' => 'UTC/GMT +12:00 - Pacific/Tarawa', 'Pacific/Tongatapu' => 'UTC/GMT +13:00 - Pacific/Tongatapu', 'Pacific/Wake' => 'UTC/GMT +12:00 - Pacific/Wake', 'Pacific/Wallis' => 'UTC/GMT +12:00 - Pacific/Wallis', 'UTC' => 'UTC/GMT +00:00 - UTC'];
}
