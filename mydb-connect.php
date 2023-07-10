<?php
//第一步要先連結資料庫
//下面四個都要與資料庫資料正確
$servername = "localhost";
$username = "admin";
$password = "12345";
$dbname = "sideproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// 檢查連線
if ($conn->connect_error) {
  	die("連線失敗: " . $conn->connect_error);
}else{
    echo "連線成功";
}

