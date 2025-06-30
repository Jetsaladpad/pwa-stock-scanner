<?php
header('Content-Type: application/json');

$db = new SQLite3('db/garage.db');

$input = $_GET['code'] ?? '';

$stmt = $db->prepare('SELECT * FROM parts WHERE barcode = :exact OR name LIKE :like');
$stmt->bindValue(':exact', $input, SQLITE3_TEXT);
$stmt->bindValue(':like', "%$input%", SQLITE3_TEXT);

$result = $stmt->execute();

$parts = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $parts[] = $row;
}

echo json_encode($parts);
?>
