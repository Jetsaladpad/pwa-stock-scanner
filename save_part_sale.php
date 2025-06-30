<!-- save_part_sale.php -->
<?php
$db = new PDO('sqlite:db/garage.db');
$data = json_decode(file_get_contents("php://input"), true);

// สร้างเลขบิลใหม่
$bill_no = 'B' . date('YmdHis');
$stmt = $db->prepare("INSERT INTO part_sales (bill_no, customer_name, total_amount, sale_date) VALUES (?, ?, ?, datetime('now'))");
$stmt->execute([$bill_no, $data['customer_name'], $data['total']]);
$sale_id = $db->lastInsertId();

// เพิ่มรายการแต่ละอะไหล่
$stmt = $db->prepare("INSERT INTO part_sale_items (sale_id, part_id, qty, price) VALUES (?, ?, ?, ?)");
foreach ($data['items'] as $item) {
  $stmt->execute([$sale_id, $item['id'], $item['qty'], $item['sell_price']]);

  // อัปเดตจำนวนใน stock
  $db->prepare("UPDATE parts SET stock = stock - ? WHERE id = ?")->execute([$item['qty'], $item['id']]);
}

echo json_encode(['status' => 'ok', 'bill_no' => $bill_no]);
