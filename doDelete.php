<?php

require_once("./mydb-connect.php");


$id=$_GET["id"];

echo($id);

$sql="UPDATE ch SET valid=0 WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("location:discountIndex.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

$conn->close();
?>

