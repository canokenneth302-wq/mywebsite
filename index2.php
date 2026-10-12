<?php
declare(strict_types=1);
session_start();

/* A small file-based demo database. For production, use MySQL and authentication. */
$dataFile = __DIR__ . DIRECTORY_SEPARATOR . 'transactions.json';
$studentFile = __DIR__ . DIRECTORY_SEPARATOR . 'student_accounts.json';
/* Starter fare table: replace these sample fares with the approved fare matrix. */
$calbayogBarangays = [
    'Acedillo', 'Aguit-itan', 'Alibaba', 'Anislag', 'Bagacay', 'Bagong Lipunan',
    'Balud', 'Basud', 'Bontay', 'Buenavista', 'Cacaransan', 'Cagbanayacao',
    'Cagboborac', 'Cagsalaosao', 'Cahumpan', 'Calocnayan', 'Canjumadac', 'Capoocan',
    'Cara', 'Carayman', 'Carmen', 'Central', 'Cogon', 'Dagum', 'Dinawacan',
    'East Awang', 'Esperanza', 'Gabay', 'Gadgaran', 'Gasdo', 'Geragaan', 'Guinbaoyan Norte',
    'Guinbaoyan Sur', 'Guin-on', 'Hamorawon', 'Helino', 'Hibatang', 'Higasaan',
    'Himalandrog', 'Jacinto', 'Jimautan', 'Kalilihan', 'Kilikili', 'La Paz', 'Langoyon',
    'Limarayon', 'Lonoy', 'Looc', 'Mabini I', 'Mancol', 'Matobato', 'Maybog', 'Maysalong',
    'Migara', 'Nag-uma', 'Naga', 'Navarro', 'Nijaga', 'Obrero', 'Olera', 'Osmeña',
    'Pagbalican', 'Palanas', 'Palanogan', 'Panonongon', 'Patong', 'Payahan', 'Pinamorotan',
    'Rawis', 'Rizal I', 'Roxas I', 'Salvacion', 'San Antonio', 'San Jose', 'San Policarpio',
    'Saputan', 'Sinantan', 'Tanval', 'Tapae', 'Tabawan', 'Tigbe', 'Trinidad', 'Victory',
    'Villahermosa', 'West Awang',
];
$staMargaritaBarangays = [
    'Agrupacion', 'Arapison', 'Avelino', 'Bahay', 'Balud', 'Bana-ao', 'Burabod', 'Cagsumje', 'Cautod',
    'Camperito', 'Campeig', 'Can-ipulan', 'Canmoros', 'Cinco', 'Curry', 'Gajo', 'Hindang', 'Ilo', 'Imelda',
    'Inoraguiao', 'Jolacao', 'Lambao', 'Mabuhay', 'Mahayag', 'Matayonas', 'Monbon', 'Nabulo', 'Napuro I',
    'Napuro II', 'Palale', 'Panabatan', 'Panaruan', 'Roxas', 'Salvacion', 'Solsogon', 'Sundara',
];
$oquendoBarangays = [
    'Baja', 'Bayo', 'Begaho', 'Cabacungan', 'Cabatuan', 'Cabicahan', 'Cabugawan', 'Cag-anahaw', 'Cag-anibong',
    'Cagbayang', 'Cagbilwang', 'Capacuhan', 'Catabunan', 'Caybago', 'Dawo', 'De Victoria', 'Dinabongan', 'Dinagan',
    'Hugon Rosales', 'Jose A. Roño', 'Lapaan', 'Libertad', 'Limarayon', 'Longsob', 'Mabini II', 'Macatingog',
    'Mag-ubay', 'Mantaong', 'Manuel Barral Sr.', 'Mawacat', 'Nabang', 'Obo-ob', 'Oquendo', 'Panlayahan', 'Panoypoy',
    'Pilar', 'Quezon', 'Rizal II', 'Roxas II', 'San Rufino', 'Sigo', 'Sinidman Occidental', 'Sinidman Oriental',
    'Talahiban', 'Tarabucan',
];
$firstLocationPlaces = [
    'Acedillo', 'Aguit-itan', 'Alibaba', 'Amampacang', 'Anislag', 'Awang East', 'Awang West', 'Ba-ay',
    'Bagacay', 'Bagong Lipunan', 'Baja', 'Balud', 'Bante', 'Bantian', 'Basud', 'Bayo', 'Begaho', 'Binaliw',
    'Bontay', 'Buenavista', 'Bugtong', 'Cabacungan', 'Cabatuan', 'Cabicahan', 'Cabugawan', 'Cacaransan',
    'Cag-anahaw', 'Cag-anibong', 'Cagbanayacao', 'Cagbayang', 'Cagbilwang', 'Cagboborac', 'Cagsalaosao',
    'Caglanipao Sur', 'Cagmanipes Norte', 'Cagmanipes Sur', 'Cagnipa', 'Cag-olango', 'Cahumpan', 'Calocnayan',
    'Cangomaod', 'Canhumadac', 'Capacuhan', 'Capoocan', 'Carayman', 'Carmen', 'Catabunan', 'Caybago',
    'Central (Poblacion)', 'Cogon', 'Dagum', 'Danao I', 'Danao II', 'Dawo', 'De Victoria', 'Dinabongan',
    'Dinagan', 'Dinawacan', 'Esperanza', 'Gabay', 'Gadgaran', 'Gasdo', 'Geraga-an', 'Guin-on',
    'Guimbaoyan Norte', 'Guimbaoyan Sur', 'Hamorawon', 'Helino', 'Hibabngan', 'Hibatang', 'Higasaan',
    'Himalandrog', 'Hugon Rosales', 'Jacinto', 'Jimautan', 'Jose A. Roño', 'Kalilihan', 'Kilikili', 'La Paz',
    'Langoyon', 'Lapaan', 'Libertad', 'Limarayon', 'Longsob', 'Lonoy', 'Looc', 'Mabini I', 'Mabini II',
    'Macatingog', 'Mag-ubay', 'Maguino-o', 'Malaga', 'Malajog', 'Malayog', 'Malopalo', 'Mancol', 'Mantaong',
    'Manuel Barral, Sr.', 'Marcatubig', 'Matobato', 'Mawacat', 'Maybog', 'Maysalong', 'Nabang', 'Nag-uma',
    'Naga', 'Navarro', 'Nijaga', 'Obo-ob', 'Obrero', 'Olera', 'Oquendo', 'Osmeña', 'Pagbalican', 'Palanas',
    'Palanogan', 'Panlayahan', 'Panonongan', 'Panoypoy', 'Patong', 'Payahan', 'Peña', 'Pilar', 'Pinamorotan',
    'Quezon', 'Rawis', 'Rizal I', 'Rizal II', 'Roxas I', 'Roxas II', 'Saljag', 'Salvacion', 'San Antonio',
    'San Isidro', 'San Joaquin', 'San Jose', 'San Policarpio', 'San Rufino', 'Saputan', 'Sigo', 'Sinantan',
    'Sinidman Occidental', 'Sinidman Oriental', 'Tabawan', 'Talahiban', 'Tanval', 'Tapa-e', 'Tarabucan',
    'Tigbe', 'Tinambacan Norte', 'Tinambacan Sur', 'Tinaplacan', 'Tomaliguez', 'Trinidad', 'Victory',
    'Villahermosa',
];
$destinations = ['Calbayog City Proper' => 15.00];
foreach ($calbayogBarangays as $index => $barangay) {
    $destinations['Calbayog City Proper -> ' . $barangay] = 15.00;
}
foreach ($staMargaritaBarangays as $barangay) {
    $destinations['Calbayog City Proper -> Sta. Margarita - ' . $barangay] = 30.00;
}
foreach ($oquendoBarangays as $barangay) {
    $destinations['Calbayog City Proper -> Oquendo - ' . $barangay] = 30.00;
}
$destinationPlaces = array_values(array_unique(array_map(
    fn ($place) => str_contains($place, ' -> ') ? substr($place, strrpos($place, ' -> ') + 4) : $place,
    array_keys($destinations)
)));
$passengers = [
    'STU-1001' => ['name' => 'Ana Cruz', 'school' => 'Calbayog City College', 'type' => 'Student', 'discount_eligible' => true],
    'STU-1002' => ['name' => 'Ben Santos', 'school' => 'Northwest Samar State University', 'type' => 'Student', 'discount_eligible' => true],
    'STU-1003' => ['name' => 'Carla Reyes', 'school' => 'Calbayog National High School', 'type' => 'Student', 'discount_eligible' => true],
    'REG-2001' => ['name' => 'Daniel Flores', 'school' => 'Regular commuter', 'type' => 'Regular', 'discount_eligible' => false],
    'REG-2002' => ['name' => 'Elena Ramos', 'school' => 'Regular commuter', 'type' => 'Regular', 'discount_eligible' => false],
];

if (!file_exists($studentFile)) {
    file_put_contents($studentFile, '[]', LOCK_EX);
}
$studentAccounts = json_decode((string) file_get_contents($studentFile), true);
$studentAccounts = is_array($studentAccounts) ? $studentAccounts : [];
foreach ($studentAccounts as $account) {
    $passengers[$account['id']] = [
        'name' => $account['name'], 'school' => $account['school'], 'type' => 'Student',
        'discount_eligible' => (bool) $account['eligible'], 'expires_at' => $account['expires_at'],
    ];
}

if (!file_exists($dataFile)) {
    file_put_contents($dataFile, '[]', LOCK_EX);
}
$transactions = json_decode((string) file_get_contents($dataFile), true);
$transactions = is_array($transactions) ? $transactions : [];
$notice = '';
$noticeType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register_student') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $school = trim((string) ($_POST['school'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $exists = array_filter($studentAccounts, fn ($account) => $account['email'] === $email);
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $school && strlen($password) >= 6 && !$exists) {
        $account = ['id' => 'STU-' . random_int(100000, 999999), 'name' => $name, 'email' => $email,
            'school' => $school, 'password' => password_hash($password, PASSWORD_DEFAULT),
            'eligible' => true, 'expires_at' => date('Y-m-d', strtotime('+1 year'))];
        $studentAccounts[] = $account;
        file_put_contents($studentFile, json_encode($studentAccounts, JSON_PRETTY_PRINT), LOCK_EX);
        $_SESSION['student_id'] = $account['id'];
        header('Location: ?student_portal=1'); exit;
    }
    $notice = 'Registration failed. Use a unique valid email and a password with at least 6 characters.';
    $noticeType = 'error';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'student_login') {
    $email = strtolower(trim((string) ($_POST['email'] ?? '')));
    $password = (string) ($_POST['password'] ?? '');
    foreach ($studentAccounts as $account) {
        if ($account['email'] === $email && password_verify($password, $account['password'])) {
            $_SESSION['student_id'] = $account['id'];
            header('Location: ?student_portal=1'); exit;
        }
    }
    $notice = 'Incorrect student email or password.';
    $noticeType = 'error';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'scan') {
    $studentId = trim((string) ($_POST['student_id'] ?? ''));
    $destination = (string) ($_POST['destination'] ?? '');

    if ($studentId !== '' && !isset($passengers[$studentId])) {
        $notice = 'QR code not recognized. Please scan a valid commuter QR code.';
        $noticeType = 'error';
    } elseif (!isset($destinations[$destination])) {
        $notice = 'Please choose a destination before scanning.';
        $noticeType = 'error';
    } elseif (!empty($passengers[$studentId]['expires_at']) && $passengers[$studentId]['expires_at'] < date('Y-m-d')) {
        foreach ($studentAccounts as &$account) {
            if ($account['id'] === $studentId) {
                if (($account['failed_scan_day'] ?? '') !== date('Y-m-d')) { $account['failed_scan_day'] = date('Y-m-d'); $account['failed_scan_attempts'] = 0; }
                $account['failed_scan_attempts'] = min(3, (int) ($account['failed_scan_attempts'] ?? 0) + 1);
                $attempt = $account['failed_scan_attempts'];
                break;
            }
        }
        unset($account);
        file_put_contents($studentFile, json_encode($studentAccounts, JSON_PRETTY_PRINT), LOCK_EX);
        $notice = $attempt >= 3 ? 'Student QR is expired. Maximum 3 retry attempts reached today; renew the student QR first.' : "Student QR is expired. Invalid scan attempt {$attempt} of 3; renew the student QR, then try again.";
        $noticeType = 'error';
    } else {
        $regularFare = $destinations[$destination];
        $passenger = $passengers[$studentId] ?? [
            'name' => 'Regular passenger',
            'type' => 'Regular',
            'discount_eligible' => false,
        ];
        $isStudent = $passenger['discount_eligible'];
        $discount = $isStudent ? round($regularFare * 0.20, 2) : 0.00;
        $paidFare = round($regularFare - $discount, 2);
        $transaction = [
            'id' => 'TX-' . date('Ymd-His') . '-' . random_int(100, 999),
            'student_id' => $studentId,
            'student_name' => $passenger['name'],
            'passenger_type' => $passenger['type'],
            'destination' => $destination,
            'regular_fare' => $regularFare,
            'discount' => $discount,
            'paid_fare' => $paidFare,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        array_unshift($transactions, $transaction);
        file_put_contents($dataFile, json_encode($transactions, JSON_PRETTY_PRINT), LOCK_EX);
        $fareType = $isStudent ? 'student 20% discount' : 'regular fare';
        $notice = "Trip saved: {$passenger['name']} paid ₱" . number_format($paidFare, 2) . " ({$fareType}) to {$destination}.";
    }
}

$today = date('Y-m-d');
$todayTransactions = array_values(array_filter($transactions, fn ($t) => str_starts_with((string) ($t['created_at'] ?? ''), $today)));
$totalCollected = array_sum(array_map(fn ($t) => (float) ($t['paid_fare'] ?? 0), $todayTransactions));
$loggedInStudent = null;
foreach ($studentAccounts as $account) {
    if (($account['id'] ?? '') === ($_SESSION['student_id'] ?? '')) { $loggedInStudent = $account; break; }
}
$requestHost = preg_replace('/[^a-zA-Z0-9.:-]/', '', $_SERVER['HTTP_HOST'] ?? 'localhost:8000');
$requestScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$serverPort = (string) ($_SERVER['SERVER_PORT'] ?? '8000');
$lanHost = preg_replace('/[^a-zA-Z0-9.:-]/', '', getenv('COMMUTERPASS_HOST') ?: '192.168.0.100');
if (!str_contains($lanHost, ':')) {
    $lanHost .= ':' . $serverPort;
}
$normalizedHost = strtolower($requestHost);
if ($requestHost === '' || str_starts_with($normalizedHost, 'localhost') || str_starts_with($normalizedHost, '127.0.0.1') || str_starts_with($normalizedHost, '0.0.0.0')) {
    $driverHost = $lanHost;
} else {
    $driverHost = $requestHost;
}
$portalPath = strtok($_SERVER['SCRIPT_NAME'] ?? '/index.php', '?');
$portalBaseUrl = $requestScheme . '://' . $driverHost . $portalPath;
$selectedDestination = (string) ($_GET['destination'] ?? '');
$driverQrUrl = $portalBaseUrl . '?student_portal=1';
if (isset($destinations[$selectedDestination])) {
    $driverQrUrl .= '&destination=' . rawurlencode($selectedDestination);
}
function peso(float $amount): string { return '₱' . number_format($amount, 2); }
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CommuterPass | Student Fare Scanner</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>
    :root {
        --ink: #14213d;
        --blue: #176bdb;
        --sky: #eaf4ff;
        --green: #14804a;
        --red: #bb2d3b;
        --line: #dce5f0;
        --muted: #62728a;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Inter, Segoe UI, Arial, sans-serif;
        background: #f6f9fd;
        color: var(--ink);
    }

    header {
        background: linear-gradient(120deg, #10234c, #176bdb);
        color: white;
        padding: 27px max(24px, calc((100% - 1100px)/2));
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .brand {
        font-weight: 800;
        letter-spacing: -.5px;
        font-size: 23px;
    }

    .brand span {
        color: #9ee4ff;
    }

    .badge {
        background: #ffffff1f;
        padding: 8px 13px;
        border-radius: 99px;
        font-size: 13px;
    }

    main {
        max-width: 1100px;
        margin: 28px auto 55px;
        padding: 0 20px;
    }

    h1 {
        margin: 0 0 5px;
        font-size: 28px;
    }

    .intro {
        margin: 0 0 23px;
        color: var(--muted);
    }

    .grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 20px;
    }

    .card {
        background: #fff;
        border: 1px solid var(--line);
        box-shadow: 0 5px 18px #2538580b;
        border-radius: 16px;
        padding: 22px;
    }

    h2 {
        font-size: 18px;
        margin: 0 0 16px;
    }

    label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        margin: 13px 0 6px;
        color: #34445f;
    }

    select,
    input {
        width: 100%;
        border: 1px solid #cbd7e6;
        border-radius: 9px;
        padding: 12px;
        font: inherit;
        color: var(--ink);
        background: white;
    }

    button {
        border: 0;
        border-radius: 9px;
        padding: 12px 16px;
        font: inherit;
        font-weight: 750;
        cursor: pointer;
        background: var(--blue);
        color: #fff;
    }

    button:hover {
        filter: brightness(.94);
    }

    .scan-btn {
        width: 100%;
        margin-top: 18px;
    }

    #qrReader {
        max-width: 420px;
        margin: 15px auto 0;
    }

    #qrReader:empty {
        display: none;
    }

    .secondary {
        background: #eaf4ff;
        color: #1456aa;
        margin-top: 10px;
        width: 100%;
    }

    .registration-link {
        display: block;
        text-align: center;
        text-decoration: none;
        margin-top: 10px;
    }

    .fare-box {
        background: var(--sky);
        border-radius: 11px;
        padding: 14px;
        margin-top: 17px;
    }

    .fare-box strong {
        font-size: 24px;
    }

    .small {
        color: var(--muted);
        font-size: 13px;
        margin-top: 4px;
    }

    .alert {
        padding: 14px 17px;
        border-radius: 10px;
        margin: 0 0 20px;
        font-weight: 600;
    }

    .success {
        background: #e8f8ef;
        color: #0d693b;
    }

    .error {
        background: #fff0f1;
        color: #9c2632;
    }

    .stat-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 13px;
        margin-bottom: 17px;
    }

    .stat {
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 15px;
    }

    .stat b {
        display: block;
        font-size: 24px;
        margin-top: 4px;
    }

    .stat span {
        font-size: 12px;
        color: var(--muted);
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .qrs {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-top: 20px;
    }

    .qr-card {
        text-align: center;
        padding: 15px 8px;
    }

    .qr {
        display: flex;
        justify-content: center;
        margin: 9px 0;
    }

    .qr-card b {
        font-size: 14px;
    }

    .qr-card p {
        margin: 4px 0;
        color: var(--muted);
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    th {
        text-align: left;
        color: var(--muted);
        font-size: 11px;
        letter-spacing: .5px;
        text-transform: uppercase;
    }

    th,
    td {
        padding: 13px 8px;
        border-bottom: 1px solid var(--line);
    }

    .amount {
        font-weight: 800;
        color: var(--green);
    }

    .empty {
        color: var(--muted);
        text-align: center;
        padding: 30px;
    }

    @media(max-width:760px) {
        .grid {
            grid-template-columns: 1fr
        }

        .qrs {
            grid-template-columns: 1fr
        }

        header {
            padding: 20px
        }

        .badge {
            display: none
        }

        main {
            margin-top: 20px
        }
    }
    </style>
</head>

<body>
    <header>
        <div class="brand">Commuter<span>Pass</span></div>
        <div class="badge">Student Discount · Driver Console</div>
    </header>
    <main>
        <h1>Student commuter transactions</h1>
        <p class="intro">The driver selects the destination, then scans the commuter QR. Student QR codes receive a 20%
            discount; regular QR codes pay the full fare.</p>
        <?php if ($notice): ?><div class="alert <?= $noticeType ?>"><?= htmlspecialchars($notice) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['student_portal'])): ?>
        <section class="card" style="margin-bottom:20px">
            <h2>Student Portal — Register or Log In</h2>
            <?php if (isset($destinations[$selectedDestination])): ?><div class="fare-box"><b>Selected destination:</b>
                <?= htmlspecialchars($selectedDestination) ?> · Regular fare
                <?= peso($destinations[$selectedDestination]) ?></div><?php endif; ?>
            <?php if ($loggedInStudent): ?>
            <p><b><?= htmlspecialchars($loggedInStudent['name']) ?></b> ·
                <?= htmlspecialchars($loggedInStudent['email']) ?></p>
            <div class="fare-box" style="text-align:center">
                <b><?= $loggedInStudent['eligible'] ? 'Approved: 20% student discount' : 'Not approved for a discount' ?></b>
                <div class="qr" id="studentPassQr"></div>
                <div class="small">Student pass: <?= htmlspecialchars($loggedInStudent['id']) ?> · Expires:
                    <?= htmlspecialchars($loggedInStudent['expires_at']) ?></div>
            </div>
            <?php else: ?>
            <div class="grid">
                <form method="post" class="card">
                    <h2>Register student</h2><input type="hidden" name="action" value="register_student">
                    <label>Name</label><input name="name" required><label>Student email</label><input type="email"
                        name="email" required><label>School</label><input name="school"
                        required><label>Password</label><input type="password" name="password" minlength="6"
                        required><button style="margin-top:16px">Register & get Student QR</button>
                </form>
                <form method="post" class="card">
                    <h2>Student log in</h2><input type="hidden" name="action" value="student_login">
                    <label>Student email</label><input type="email" name="email" required><label>Password</label><input
                        type="password" name="password" required><button style="margin-top:16px">Log in</button>
                    <p class="small">New accounts are approved in this starter demo and expire after one year.</p>
                </form>
            </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>
        <div class="grid">
            <section class="card">
                <h2>Driver fare scanner</h2>
                <form method="post" id="scanForm"><input type="hidden" name="action" value="scan">
                    <input type="hidden" name="destination" id="destination">
                    <label for="originLocation">First location / pickup</label>
                    <input id="originLocation" list="calbayogOrigins" value="Calbayog City Proper"
                        placeholder="Type first location" autocomplete="off" required>
                    <datalist id="calbayogOrigins">
                        <?php foreach ($firstLocationPlaces as $place): ?>
                        <option value="<?= htmlspecialchars($place) ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                    <label for="destinationLocation">Second route / where are you going?</label>
                    <input id="destinationLocation" list="calbayogDestinations"
                        placeholder="Type destination, e.g. Acedillo" autocomplete="off" required>
                    <datalist id="calbayogDestinations">
                        <?php foreach ($destinationPlaces as $place): ?>
                        <option value="<?= htmlspecialchars($place) ?>"></option>
                        <?php endforeach; ?>
                    </datalist>
                    <div class="fare-box" id="farePreview"><strong id="amountToPay">₱0.00</strong>
                        <div class="small" id="fareText">Select a destination, then scan a commuter QR.</div>
                        <div class="small" id="fareBreakdown">Regular fare: ₱0.00 · Discount: ₱0.00 · Amount to pay:
                            ₱0.00</div>
                    </div>
                    <label for="student_id">Student ID for discount</label>
                    <input name="student_id" id="student_id" placeholder="Student: STU-123456 · Regular: REG-2001"
                        autocomplete="off">
                    <button type="button" class="scan-btn" id="startQrScanner">Scan commuter QR with camera</button>
                    <div id="qrReader"></div>
                    <button type="button" class="secondary" id="checkFare">Apply student discount</button>
                    <div class="fare-box" id="scanResult" hidden>
                        <strong id="riderName">Waiting for QR scan</strong>
                        <div class="small" id="riderStatus"></div>
                        <div class="small" id="riderDue"></div>
                        <a class="secondary registration-link" id="registrationLink"
                            href="<?= htmlspecialchars($driverQrUrl) ?>" hidden>Open Student Registration</a>
                    </div>
                    <button type="submit" class="secondary" id="confirmFare" hidden>Confirm cash fare & save
                        transaction</button>
                </form>
                <p class="small">Choose a destination, then scan or enter the student ID. A valid student ID
                    automatically receives 20% off; regular IDs pay the full fare.</p>
            </section>
            <aside class="card">
                <h2>Driver collection today</h2>
                <div class="stat-row">
                    <div class="stat"><span>Transactions</span><b><?= count($todayTransactions) ?></b></div>
                    <div class="stat"><span>Collected</span><b><?= peso($totalCollected) ?></b></div>
                </div>
                <p class="small">Both student and regular fares collected are added to the driver total.</p>
                <div class="fare-box" style="text-align:center">
                    <b>Commuter registration QR</b>
                    <div class="qr" id="driverQr"></div>
                    <div class="small" id="driverQrHelp">Choose a destination first, then scan this QR to open Student
                        Registration or Log In on another phone connected to the same Wi-Fi.</div>
                    <p class="small"><a id="driverQrLink" href="<?= htmlspecialchars($driverQrUrl) ?>">Open Student Registration</a></p>
                    <p class="small">Student QR contains only the Student ID, so it can be scanned even when the phone
                        uses mobile data or another Wi-Fi.</p>
                </div>
            </aside>
        </div>
        <section class="card" style="margin-top:20px">
            <h2>Recent transactions</h2><?php if (!$transactions): ?><div class="empty">No fares recorded yet. Scan a
                passenger QR to begin.</div><?php else: ?><div style="overflow-x:auto">
                <table>
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Passenger</th>
                            <th>Fare type</th>
                            <th>Destination</th>
                            <th>Regular</th>
                            <th>Discount</th>
                            <th>Paid</th>
                        </tr>
                    </thead>
                    <tbody><?php foreach (array_slice($transactions, 0, 15) as $t): ?><tr>
                            <td><?= htmlspecialchars(date('M d, h:i A', strtotime($t['created_at']))) ?></td>
                            <td><b><?= htmlspecialchars($t['student_name']) ?></b><br><span
                                    class="small"><?= htmlspecialchars($t['student_id']) ?></span></td>
                            <td><?= htmlspecialchars($t['passenger_type'] ?? 'Student') ?></td>
                            <td><?= htmlspecialchars($t['destination']) ?></td>
                            <td><?= peso((float)$t['regular_fare']) ?></td>
                            <td><?= peso((float)$t['discount']) ?></td>
                            <td class="amount"><?= peso((float)$t['paid_fare']) ?></td>
                        </tr><?php endforeach; ?></tbody>
                </table>
            </div><?php endif; ?>
        </section>
    </main>
    <script>
    const fares = <?= json_encode($destinations) ?>;
    const discountEligible =
        <?= json_encode(array_map(fn($passenger) => $passenger['discount_eligible'], $passengers)) ?>;
    const riderRecords =
        <?= json_encode(array_map(fn($passenger) => ['name' => $passenger['name'], 'type' => $passenger['type'], 'eligible' => $passenger['discount_eligible']], $passengers)) ?>;
    const destination = document.getElementById('destination'),
        originLocation = document.getElementById('originLocation'),
        destinationLocation = document.getElementById('destinationLocation'),
        preview = document.getElementById('farePreview'),
        fareText = document.getElementById('fareText'),
        fareBreakdown = document.getElementById('fareBreakdown'),
        studentInput = document.getElementById('student_id'),
        scanResult = document.getElementById('scanResult'),
        riderName = document.getElementById('riderName'),
        riderStatus = document.getElementById('riderStatus'),
        riderDue = document.getElementById('riderDue'),
        registrationLink = document.getElementById('registrationLink'),
        confirmFare = document.getElementById('confirmFare');

    originLocation.addEventListener('focus', () => originLocation.select(), { once: true });

    function updateFarePreview() {
        const regularFare = Number(fares[destination.value] || 0);
        const isStudent = studentInput.value && discountEligible[studentInput.value];
        const discount = isStudent ? regularFare * .20 : 0;
        const fare = regularFare - discount;
        document.getElementById('amountToPay').textContent = '₱' + fare.toFixed(2);
        fareBreakdown.textContent = 'Regular fare: ₱' + regularFare.toFixed(2) +
            ' · Discount: ₱' + discount.toFixed(2) + ' · Amount to pay: ₱' + fare.toFixed(2);
        fareText.textContent = !destination.value ? 'Select a destination, then scan a commuter QR.' :
            !studentInput.value ? 'Regular fare shown. Scan QR to apply a student discount when eligible.' :
            isStudent ? 'Student fare — 20% discount applied.' : 'Regular commuter — full regular fare.';
    }

    function showScannedRider(id) {
        const rider = riderRecords[id];
        scanResult.hidden = false;
        registrationLink.hidden = false;
        if (!id) {
            riderName.textContent = 'Regular passenger';
            riderStatus.textContent = 'No Student ID entered — full regular fare';
            riderDue.textContent = 'DUE TODAY: Standard fare ₱' + Number(fares[destination.value] || 0).toFixed(2) +
                ' · Discount ₱0.00';
            confirmFare.hidden = !destination.value;
            return;
        }
        if (!rider) {
            riderName.textContent = 'Invalid commuter QR';
            riderStatus.textContent = 'This QR is not registered. Please scan again (maximum 3 retries).';
            riderDue.textContent = 'No fare is ready.';
            confirmFare.hidden = true;
            return;
        }
        const standardFare = Number(fares[destination.value] || 0);
        const discount = rider.eligible ? standardFare * .20 : 0;
        const due = standardFare - discount;
        riderName.textContent = 'Rider: ' + rider.name;
        riderStatus.textContent = rider.eligible ? 'STUDENT COMMUTER — approved 20% discount' :
            'REGULAR COMMUTER — standard fare';
        riderDue.textContent = 'DUE TODAY: Standard fare ₱' + standardFare.toFixed(2) + ' · Discount ₱' + discount
            .toFixed(2) + ' · Cash due ₱' + due.toFixed(2);
        confirmFare.hidden = false;
    }

    function syncRouteSelection() {
        const origin = originLocation.value.trim();
        const target = destinationLocation.value.trim();
        const route = origin === 'Calbayog City Proper' && target ?
            (target === origin ? origin : origin + ' -> ' + target) : '';
        destination.value = Object.prototype.hasOwnProperty.call(fares, route) ? route : '';
        updateFarePreview();
        if (destination.value) {
            showScannedRider(studentInput.value);
        }
        updateDestinationQr();
    }
    originLocation.addEventListener('input', syncRouteSelection);
    originLocation.addEventListener('change', syncRouteSelection);
    destinationLocation.addEventListener('input', syncRouteSelection);
    destinationLocation.addEventListener('change', syncRouteSelection);
    studentInput.addEventListener('input', () => {
        const commuterId = studentInput.value.trim().split('|')[0];
        studentInput.value = commuterId;
        updateFarePreview();
        if (riderRecords[commuterId]) showScannedRider(commuterId);
    });

    const portalBaseUrl = <?= json_encode($portalBaseUrl) ?>;
    const driverQr = new QRCode(document.getElementById('driverQr'), {
        text: <?= json_encode($driverQrUrl) ?>,
        width: 210,
        height: 210
    });
    const driverQrLink = document.getElementById('driverQrLink');
    const driverQrHelp = document.getElementById('driverQrHelp');

    function updateDestinationQr() {
        const selected = destination.value;
        const validDestination = Object.prototype.hasOwnProperty.call(fares, selected) ? selected : '';
        const portalUrl = validDestination ? portalBaseUrl + '?student_portal=1&destination=' + encodeURIComponent(validDestination) :
            portalBaseUrl + '?student_portal=1';
        driverQr.clear();
        driverQr.makeCode(portalUrl);
        driverQrLink.href = portalUrl;
        driverQrHelp.textContent = validDestination ? 'Scan this QR to open Registration or Log In for ' + validDestination + '.' :
            'Choose a destination first, then scan this QR to open Student Registration or Log In.';
    }
    const studentPassQr = document.getElementById('studentPassQr');
    if (studentPassQr) {
        new QRCode(studentPassQr, {
            text: <?= json_encode($loggedInStudent['id'] ?? '') ?>,
            width: 180,
            height: 180
        });
    }

    function checkFare() {
        if (!destination.value) {
            alert('Driver: choose the passenger destination first.');
            return;
        }
        studentInput.value = studentInput.value.trim().split('|')[0];
        updateFarePreview();
        showScannedRider(studentInput.value);
    }
    document.getElementById('checkFare').addEventListener('click', checkFare);

    const startQrScanner = document.getElementById('startQrScanner');
    const qrReader = document.getElementById('qrReader');
    let qrScanner;
    startQrScanner.addEventListener('click', async () => {
        if (qrScanner) return;
        if (!window.Html5Qrcode) {
            alert('The QR scanner library could not load. Enter the commuter ID manually.');
            return;
        }
        qrScanner = new Html5Qrcode('qrReader');
        try {
            await qrScanner.start({
                    facingMode: 'environment'
                }, {
                    fps: 10,
                    qrbox: 220
                },
                async decodedText => {
                        const scannedValue = decodedText.trim();
                        studentInput.value = scannedValue.split('|')[0].replace(/^COMMUTERPASS:/i, '');
                        checkFare();
                        await qrScanner.stop();
                        qrScanner.clear();
                        qrScanner = null;
                    },
                    () => {}
            );
        } catch (error) {
            alert('Camera access failed. Check browser permission or enter the commuter ID manually.');
            qrScanner = null;
        }
    });
    document.getElementById('scanForm').addEventListener('submit', e => {
        if (!destination.value) {
            e.preventDefault();
            alert('Choose a destination first. Student ID is optional for regular fare.');
        }
    });
    </script>
</body>

</html>