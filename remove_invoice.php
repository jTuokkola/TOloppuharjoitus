<?php

require "dbconnection.php";
$dbcon = createDbConnection();

$invoice_item_id = 1; //item ID

$pdo = $dbcon;

$stmt = $pdo->prepare("DELETE FROM invoice_items WHERE InvoiceLineId = ?");
$stmt->execute([$invoice_item_id]);

if ($stmt->rowCount() > 0) {
    echo "deleted invoice item with ID $invoice_item_id";
} else {
    echo "invoice item with ID $invoice_item_id not found";
}