<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Commuter QR Fare System</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f8;
        text-align: center;
        padding: 60px 20px;
    }

    h1 {
        color: #222;
    }

    a.btn {
        display: block;
        max-width: 320px;
        margin: 14px auto;
        background: #2d7dd2;
        color: #fff;
        padding: 16px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
    }

    a.btn.alt {
        background: #1f9d55;
    }

    a.btn.grey {
        background: #555;
    }
    </style>
</head>

<body>
    <h1>🚌 Commuter QR Fare System</h1>
    <p>Starter version — 3 destinations, student discount included.</p>

    <a class="btn grey" href="generate_qr.php">🖨️ Generate / Print Destination QR Codes</a>
    <a class="btn" href="scanner.php">📷 Driver Scanner</a>
    <a class="btn alt" href="dashboard.php">📊 Driver Dashboard</a>
</body>

</html>
<?php
// ============================================
// Database Connection Config
// Edit these to match your MySQL setup
// ============================================
$DB_HOST = "localhost";
$DB_NAME = "commuter_qr";
$DB_USER = "root";
$DB_PASS = "";

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<?php
require 'config.php';
$destinations = $pdo->query("SELECT * FROM destinations")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Destination QR Codes</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f8;
        text-align: center;
        padding: 30px;
    }

    h1 {
        color: #222;
    }

    .card {
        display: inline-block;
        background: #fff;
        margin: 15px;
        padding: 20px 25px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
        margin: 8px 0;
        font-size: 18px;
    }

    .fares {
        font-size: 14px;
        color: #555;
        margin-top: 6px;
    }

    .fares b {
        color: #0a7d32;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
    </style>
</head>

<body>

    <h1>🚌 Destination QR Codes</h1>
    <p class="no-print">Print each card and post it at the matching boarding point / route card. Drivers scan these with
        the Scanner page.</p>

    <?php foreach ($destinations as $d): ?>
    <div class="card">
        <div id="qr-<?php echo $d['id']; ?>"></div>
        <h2><?php echo htmlspecialchars($d['name']); ?></h2>
        <div class="fares">
            Regular: <b>₱<?php echo number_format($d['regular_fare'], 2); ?></b><br>
            Student: <b>₱<?php echo number_format($d['student_fare'], 2); ?></b>
        </div>
    </div>
    <script>
    new QRCode(document.getElementById("qr-<?php echo $d['id']; ?>"), {
        text: JSON.stringify({
            destination_id: <?php echo $d['id']; ?>
        }),
        width: 180,
        height: 180
    });
    </script>
    <?php endforeach; ?>

    <p class="no-print"><button onclick="window.print()">🖨️ Print All</button></p>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Driver Scanner</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        background: #111;
        color: #fff;
        text-align: center;
        margin: 0;
        padding: 16px;
    }

    h1 {
        font-size: 20px;
        margin-bottom: 4px;
    }

    #reader {
        width: 100%;
        max-width: 400px;
        margin: 16px auto;
        border-radius: 12px;
        overflow: hidden;
    }

    .panel {
        background: #1c1c1c;
        border-radius: 12px;
        padding: 18px;
        max-width: 400px;
        margin: 16px auto;
        display: none;
    }

    .panel.show {
        display: block;
    }

    .panel h2 {
        margin: 0 0 12px;
        font-size: 16px;
        color: #9ad;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 16px;
        margin: 8px 0;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-regular {
        background: #2d7dd2;
        color: #fff;
    }

    .btn-student {
        background: #1f9d55;
        color: #fff;
    }

    .btn:disabled {
        opacity: 0.5;
    }

    #status {
        margin-top: 14px;
        font-size: 15px;
        min-height: 20px;
    }

    #status.ok {
        color: #5cff8f;
    }

    #status.err {
        color: #ff6b6b;
    }

    a {
        color: #9ad;
    }
    </style>
</head>

<body>

    <h1>🚌 Driver Scanner</h1>
    <p>Scan the destination QR posted on the route</p>

    <div id="reader"></div>

    <div class="panel" id="farePanel">
        <h2 id="destName"></h2>
        <button class="btn btn-regular" id="btnRegular"></button>
        <button class="btn btn-student" id="btnStudent"></button>
    </div>

    <div id="status"></div>

    <p><a href="dashboard.php">📊 View my earnings dashboard</a></p>

    <script>
    let currentDestination = null;

    const statusEl = document.getElementById('status');
    const panel = document.getElementById('farePanel');

    function onScanSuccess(decodedText) {
        let payload;
        try {
            payload = JSON.parse(decodedText);
        } catch (e) {
            setStatus('QR code not recognized.', 'err');
            return;
        }
        if (!payload.destination_id) {
            setStatus('QR code not recognized.', 'err');
            return;
        }
        loadFares(payload.destination_id);
    }

    const html5QrCode = new Html5Qrcode("reader");
    html5QrCode.start({
            facingMode: "environment"
        }, {
            fps: 10,
            qrbox: 220
        },
        onScanSuccess
    ).catch(err => {
        setStatus('Camera error: ' + err, 'err');
    });

    function loadFares(destinationId) {
        fetch('get_fares.php?destination_id=' + destinationId)
            .then(r => r.json())
            .then(data => {
                if (data.error) {
                    setStatus(data.error, 'err');
                    return;
                }
                currentDestination = data;
                document.getElementById('destName').textContent = data.name;
                document.getElementById('btnRegular').textContent =
                    'Regular  ·  ₱' + parseFloat(data.regular_fare).toFixed(2);
                document.getElementById('btnStudent').textContent =
                    'Student  ·  ₱' + parseFloat(data.student_fare).toFixed(2);
                panel.classList.add('show');
                setStatus('Destination locked in. Choose passenger type.', 'ok');
            })
            .catch(() => setStatus('Could not reach server.', 'err'));
    }

    function saveTransaction(passengerType) {
        if (!currentDestination) return;
        setStatus('Saving...', '');
        fetch('save_transaction.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    destination_id: currentDestination.id,
                    passenger_type: passengerType
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    setStatus(`✅ Saved: ${data.destination} (${data.type}) — ₱${parseFloat(data.fare).toFixed(2)}`,
                        'ok');
                    panel.classList.remove('show');
                    currentDestination = null;
                } else {
                    setStatus(data.error || 'Save failed.', 'err');
                }
            })
            .catch(() => setStatus('Could not reach server.', 'err'));
    }

    document.getElementById('btnRegular').addEventListener('click', () => saveTransaction('regular'));
    document.getElementById('btnStudent').addEventListener('click', () => saveTransaction('student'));

    function setStatus(msg, cls) {
        statusEl.textContent = msg;
        statusEl.className = cls || '';
    }
    </script>

</body>

</html>