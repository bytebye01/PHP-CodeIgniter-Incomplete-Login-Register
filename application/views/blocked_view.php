<!-- application/views/blocked_view.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blocked IP</title>
</head>
<body>
    <h2>Your IP is Blocked</h2>
        <p>We have detected suspicious activities on your network. Please contact the system administrator.</p>
        <?php if ($ipBlockData): ?>
            <p>IP Address: <?php echo $ipBlockData->lib_ip; ?></p>
            <p>Activity: <?php echo $ipBlockData->lib_activity; ?></p>
            <p>Timestamp: <?php echo $ipBlockData->lib_timestamp; ?></p>
        <?php else: ?>
            <p>No data available.</p>
        <?php endif; ?>
</body>
</html>
