<?php
require_once("mydb-connect.php");
if (!isset($_GET["searchName"])) {
    header("location:404page.php");
    exit;
}

// 分類%還是固定金額
if (isset($_GET["countType"])) {
    $countType = $_GET["countType"] ?? "";
    if ($countType == 1) {
        $discountType = "countType=1 AND";
    } elseif ($countType == 2) {
        $discountType = "countType=2  AND";
    }
} else {
    $discountType = "";
}


//排序
$type = $_GET["type"] ?? 1;
if ($type == 1) {
    $where = "id ASC";
}
if ($type == 2) {
    $where = "id DESC";
}
if ($type == 3) {
    $where = "discount ASC";
}
if ($type == 4) {
    $where = "discount DESC";
}
if ($type == 5) {
    $where = "startDate ASC";
}
if ($type == 6) {
    $where = "startDate DESC";
}

// 金額篩選
$discountmin = $_GET["discountmin"];
$discountMax = $_GET["discountMax"];
if (empty($discountmin)) {
    $discountmin = 0;
}
if (empty($discountMax)) {
    $discountMax = 99999999;
}
$discountRange = "discount >= $discountmin AND discount <= $discountMax AND";

//日期篩選
$datemin = $_GET["datemin"];
$dateMax = $_GET["dateMax"];
if (empty($datemin)) {
    $datemin = '0000 - 00 - 00';
}
if (empty($dateMax)) {
    $dateMax = date('Y-m-d');
}
$dateRange = "startDate >= '$datemin' AND endDate <= '$dateMax' AND";

$page = $_GET["page"] ?? 1; //起始頁數
$start = ($page - 1) * 10; //開始抓的id

// 篩選節果
$searchName = $_GET["searchName"] ?? "";

$sql = "SELECT * FROM ch WHERE discountName LIKE '%$searchName%' AND $discountType $discountRange $dateRange valid=1 ORDER BY $where LIMIT $start,10";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

//製作page
$sqlforPage = "SELECT * FROM ch WHERE discountName LIKE '%$searchName%' AND $discountType $discountRange $dateRange valid=1";
$resultforPage = $conn->query($sqlforPage);
$numDiscount = $resultforPage->num_rows;
$totalPageCount = ceil($numDiscount / 10);


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <!--搜尋sidebar  -->
    <?php include("./modal/searchbar.php") ?>
    <!--搜尋sidebar  -->

    <div class="container">
        <div class="mt-2">
            <a href="./discountIndex.php" class="h2 text-decoration-none">優惠券目錄</a>
        </div>

        <div class="my-3">

            <div class="d-flex">
                <button class="btn btn-primary me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa-solid fa-magnifying-glass"></i> 搜尋</button>
                <div>
                    <a href="discountCreat.php" class="btn btn-primary"><i class="fa-solid fa-file-circle-plus"></i> 新增</a>
                </div>
            </div>
            <?php if (!empty($_GET["searchName"])) : ?>
                <a href="discountIndex.php" class="btn btn-primary col-auto"><i class="fa-solid fa-reply"></i> 返回列表</a>
            <?php endif ?>


            <div class="d-flex justify-content-end mb-4">
                <div class="btn-group me-2" role="group" aria-label="Basic outlined example">
                    <a href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>" type="button" class="btn btn-outline-primary">不區分</a>
                    <a href="dosearch.php?countType=1&searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&<?php if (isset($type)) {
                                                                                                                                                                                                        echo "type=$type";
                                                                                                                                                                                                    } ?>" type="button" class="btn btn-outline-primary">固定折扣</a>
                    <a href="dosearch.php?countType=2&searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&<?php if (isset($type)) {
                                                                                                                                                                                                        echo "type=$type";
                                                                                                                                                                                                    } ?>" type="button" class="btn btn-outline-primary me-2">百分比折扣</a>
                </div>
                <div class="btn-group">
                    <button class="form-select " data-bs-toggle="dropdown" aria-expanded="false">
                        排序條件
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&type=1&<?php if (isset($countType)) {
                                                                                                                                                                                                                                    echo "countType=$countType";
                                                                                                                                                                                                                                } ?>">id升冪</a></li>
                        <li><a class="dropdown-item" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&type=2&<?php if (isset($countType)) {
                                                                                                                                                                                                                                    echo "countType=$countType";
                                                                                                                                                                                                                                } ?>">id降冪</a></li>
                        <li><a class="dropdown-item" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&type=3&<?php if (isset($countType)) {
                                                                                                                                                                                                                                    echo "countType=$countType";
                                                                                                                                                                                                                                } ?>">折扣升冪</a></li>
                        <li><a class="dropdown-item" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&type=4&<?php if (isset($countType)) {
                                                                                                                                                                                                                                    echo "countType=$countType";
                                                                                                                                                                                                                                } ?>">折扣降冪</a></li>
                        <li><a class="dropdown-item" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&type=5&<?php if (isset($countType)) {
                                                                                                                                                                                                                                    echo "countType=$countType";
                                                                                                                                                                                                                                } ?>">有效日期升冪</a></li>
                        <li><a class="dropdown-item" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&type=6&<?php if (isset($countType)) {
                                                                                                                                                                                                                                    echo "countType=$countType";
                                                                                                                                                                                                                                } ?>">有效日期降冪</a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">優惠券名稱</th>
                        <th class="text-center">折扣內容</th>
                        <th class="text-center">折扣代碼</th>
                        <th class="text-center">有效期限</th>
                        <th class="text-center">最後更新時間</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row) : ?>
                        <tr>
                            <td class="text-center"><?= $row["id"] ?></td>
                            <td class="text-center"><?= $row["discountName"] ?></td>
                            <td class="text-center"><?php if ($row["countType"] == 1) {
                                                        echo $row["discount"] . "元";
                                                    } else {
                                                        echo $row["discount"] . "%";
                                                    }
                                                    ?></td>
                            <td class="text-center"><?= $row["discountCode"] ?></td>
                            <td class="text-center"><?= $row["startDate"] ?> ~ <?= $row["endDate"] ?></td>
                            <td class="text-center"><?= $row["created_at"] ?></td>
                            <td class="d-flex justify-content-evenly">
                                <a href="discountDetail.php?id=<?= $row["id"] ?>" class="btn btn-primary">查看 <i class="fa-solid fa-right-to-bracket"></i> </a>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">刪除 <i class="fa-solid fa-trash-can"></i> </button>
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

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link <?php if ($page - 1 == 0) {
                                            echo "disabled";
                                        } ?>" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&<?php if (isset($type)) {
                                                                                                                                                                                                                    echo "type=$type";
                                                                                                                                                                                                                } ?>&<?php if (isset($countType)) {
                                                                                                                                                                                                                        echo "countType=$countType";
                                                                                                                                                                                                                    } ?>&page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                <?php for ($i = 1; $i <= $totalPageCount; $i++) : ?>
                    <li class="page-item"><a class="page-link <?php if ($i == $page) {
                                                                    echo "active";
                                                                } ?>" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&<?php if (isset($type)) {
                                                                                                                                                                                                                                            echo "type=$type";
                                                                                                                                                                                                                                        } ?>&<?php if (isset($countType)) {
                                                                                                                                                                                                                                                echo "countType=$countType";
                                                                                                                                                                                                                                            } ?>&page=<?= $i ?>"><?= $i ?></a></li>
                <?php endfor  ?>

                <li class="page-item">
                    <a class="page-link <?php if ($page == $totalPageCount) {
                                            echo "disabled";
                                        } ?>" href="dosearch.php?searchName=<?= $searchName ?>&discountmin=<?= $discountmin ?>&discountMax=<?= $discountMax ?>&datemin=<?= $datemin ?>&dateMax=<?= $dateMax ?>&<?php if (isset($type)) {
                                                                                                                                                                                                                    echo "type=$type";
                                                                                                                                                                                                                } ?>&<?php if (isset($countType)) {
                                                                                                                                                                                                                        echo "countType=$countType";
                                                                                                                                                                                                                    } ?>&page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div>共 <?= $numDiscount ?> 筆</div>


    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

</body>

</html>