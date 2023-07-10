<?php

// 請依正常管道進入
if(!isset($_POST["discountName"])){
    header("location:404page.php");
    die;
}

require_once("./mydb-connect.php");

$discountName=$_POST["discountName"];
$countType=$_POST["countType"];
$discount=$_POST["discount"];
$discountCode=$_POST["discountCode"];
$startDate=$_POST["startDate"];
$endDate=$_POST["endDate"];
$now=date('Y-m-d H:i:s');
// var_dump($discountname,$countType,$discount,$discountCode,$startDate,$endDate,$now);


$sql= "INSERT INTO ch (discountName,counTtype,discount,discountCode,startDate,endDate,created_at,valid) VALUES ('$discountName','$countType','$discount','$discountCode','$startDate','$endDate','$now','1')";



if ($conn->query($sql) === TRUE) {
    header("location: discountIndex.php");
} else {
    echo "資料表 新增資料錯誤: " . $conn->error;
}

$conn->close();