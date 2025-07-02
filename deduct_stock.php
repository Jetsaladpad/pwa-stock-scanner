<?php
if (!isset($_POST['barcode']) || !isset($_POST['qty'])) {
  http_response_code(400);
  echo "ข้อมูลไม่ครบ";
  exit;
}

$barcode = $_POST['barcode'];
$qty = intval($_POST['qty']);

$conn = new mysqli("localhost", "root", "", "jetsedza_db"); // ✅ แก้ให้ตรงกับฐานข้อมูลจริง
$conn->set_charset("utf8");

if ($conn->connect_error) {
  http_response_code(500);
  echo "เชื่อมต่อฐานข้อมูลล้มเหลว";
  exit;
}

$result = $conn->query("SELECT quantity FROM stock WHERE barcode = '$barcode'");
if ($result->num_rows == 0) {
  http_response_code(404);
  echo "ไม่พบอะไหล่";
  exit;
}

$row = $result->fetch_assoc();
$currentQty = intval($row['quantity']);
if ($qty > $currentQty) {
  http_response_code(400);
  echo "สต๊อกไม่พอ";
  exit;
}

$newQty = $currentQty - $qty;
$conn->query("UPDATE stock SET quantity = $newQty WHERE barcode = '$barcode'");
echo "หักสต๊อกสำเร็จ";
?>
