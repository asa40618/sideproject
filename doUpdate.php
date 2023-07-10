<?php

require_once("./mydb-connect.php");

$id=$_POST["id"];
$discountName=$_POST["discountName"];
$countType=$_POST["countType"];
$discount=$_POST["discount"];
$discountCode=$_POST["discountCode"];
$startDate=$_POST["startDate"];
$endDate=$_POST["endDate"];

$sql="UPDATE ch SET discountName='$discountName',discount='$discount',countType='$countType',discountCode='$discountCode',startDate='$startDate',endDate='$endDate' WHERE id=$id";


if ($conn->query($sql) === TRUE) {
    // echo "更新成功";
    header("location:discountDetail.php?id=$id");
} else {
    echo "更新失敗: " . $conn->error;
}

$conn->close();
?>
