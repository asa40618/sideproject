<?php

require_once("./mydb-connect.php");

$id = $_GET["id"];
$sql = "SELECT * FROM ch WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
// var_dump($row);

?>

<!doctype html>
<html lang="en">

<head>
    <title>優惠券編輯</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <h2 class="my-2">優惠券編輯</h2>
        <form action="doUpdate.php" method="post">
        <div>
           
                <table class="table table-bordered">
                    <thead>
                        <input type="hidden" value="<?=$row["id"]?>" name="id">
                        <tr>
                            <th>優惠券名稱</th>
                            <td>
                                <input type="text" class="form-control" name="discountName" value="<?= $row["discountName"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>折扣內容</th>
                            <td><input type="text" class="form-control" name="discount" value="<?= $row["discount"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>折扣種類</th>
                            <td>
                                <select type="text" class="form-select" name="countType" id="CountType">
                                    <?php if ($row["countType"] == 1) : ?>
                                        <option value="1">元</option>
                                        <option value="2">折</option>
                                    <?php else : ?>
                                        <option value="2">折</option>
                                        <option value="1">元</option>
                                    <?php endif ?>
                                </select>
                        </tr>
                        <tr>
                            <th>折扣代碼</th>
                            <td><input type="text" class="form-control" name="discountCode" value="<?= $row["discountCode"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>開始日期</th>
                            <td><input type="date" class="form-control" name="startDate" value="<?= $row["startDate"] ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>結束日期</th>
                            <td><input type="date" class="form-control" name="endDate" value="<?= $row["endDate"] ?>">
                            </td>
                        </tr>
                    </thead>
                </table>
            
        </div>
        <button class="btn btn-info" type="submit">編輯完成</button>
        <a href="discountIndex.php" class="btn btn-info">返回</a>
        </form>
    </div>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
</body>

</html>