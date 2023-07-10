<?php
require_once("mydb-connect.php");
if(!isset($_POST["searchName"])){
    echo "請依正常管道進入頁面";
    die;
}

$searchName = $_POST["searchName"];


$sql = "SELECT * FROM ch WHERE discountName LIKE '%$searchName%'AND valid=1 ORDER BY id ";


$result = $conn->query($sql);
$numDiscount = $result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows);
?>

<!doctype html>
<html lang="en">

<head>
    <title>優惠券目錄</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>

    </style>

</head>

<body>

    <div class="container">

        <div class="mt-2">
            <h2>優惠券目錄</h2>
        </div>

        <form action="discountIndex.php" method="post">
            <div class="my-2 align-items-center row">
                <div class="col-auto">
                    <input type="text" class="form-control" name="searchName" placeholder="搜尋優惠券名稱">
                </div>
                <button class="btn btn-info col-auto me-2" type="submit">送出</button>

                <?php if (!empty($_POST["searchName"])) : ?>
                    <a href="discountIndex.php" class="btn btn-info col-auto">返回列表</a>
                <?php endif ?>
            </div>
        </form>

        <div>
            <a href="discountCreat.php" class="btn btn-info mb-2">新增</a>

            <div class="btn-group float-end">
                <button class="form-select " data-bs-toggle="dropdown" aria-expanded="false">
                    篩選條件
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="dosearch.php?type=1">id升冪</a></li>
                    <li><a class="dropdown-item" href="dosearch.php?type=2">id降冪</a></li>
                    <li><a class="dropdown-item" href="dosearch.php?type=3">折扣升冪</a></li>
                    <li><a class="dropdown-item" href="dosearch.php?type=4">折扣降冪</a></li>
                    <li><a class="dropdown-item" href="dosearch.php?type=5">有效日期升冪</a></li>
                    <li><a class="dropdown-item" href="dosearch.php?type=6">有效日期降冪</a></li>
                </ul>
            </div>

        </div>

        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>優惠券名稱</th>
                        <th>折扣內容</th>
                        <th>折扣代碼</th>
                        <th>有效期限</th>
                        <th>建立時間</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td><?= $row["id"] ?></td>
                            <td><?= $row["discountName"] ?></td>
                            <td><?php if ($row["countType"] == 1) {
                                    echo $row["discount"] . "元";
                                } else {
                                    echo $row["discount"] . "折";
                                }
                                ?></td>
                            <td><?= $row["discountCode"] ?></td>
                            <td><?= $row["startDate"] ?> ~ <?= $row["endDate"] ?></td>
                            <td><?= $row["created_at"] ?></td>
                            <td><a href="discountDetail.php?id=<?= $row["id"] ?>" class="btn btn-primary">查看</a></td>
                            <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">刪除</button>
                            </td>
                        </tr>

                        <!-- 以下刪除提示 -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">確認刪除</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        確定刪除該張優惠券嗎?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">否</button>
                                        <a href="doDelete.php?id=<?= $row["id"] ?>" type="button" class="btn btn-primary">是</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 以上刪除提示 -->

                    <?php endforeach ?>
                </tbody>
            </table>
        </div>


        <div>共 <?= $numDiscount ?> 筆</div>


    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

</body>

</html>