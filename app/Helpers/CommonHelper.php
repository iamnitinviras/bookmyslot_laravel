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
