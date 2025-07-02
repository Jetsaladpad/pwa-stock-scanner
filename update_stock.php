
<?php
$conn = new mysqli("localhost", "root", "", "garage");
$data = json_decode(file_get_contents("php://input"), true);

foreach ($data as $item) {
  $barcode = $conn->real_escape_string($item['barcode']);
  $qty = intval($item['qty']);
  $conn->query("UPDATE stock SET quantity = quantity - $qty WHERE barcode = '$barcode'");
}

echo "สต๊อกถูกอัปเดตเรียบร้อยแล้ว";
?>
