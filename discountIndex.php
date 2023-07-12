<?php
require_once("mydb-connect.php");



// 計算頁數
$sqlPage = "SELECT * FROM ch WHERE valid=1";
$resultPage = $conn->query($sqlPage);
$numDiscount = $resultPage->num_rows;
$totalPageCount = ceil($numDiscount / 10);

// 每頁幾筆
$page = $_GET["page"] ?? 1;
$start = ($page - 1) * 10;

//升冪降冪控制
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

// 區分固定折扣、趴數折扣



$sql = "SELECT * FROM ch WHERE valid=1 ORDER BY $where LIMIT $start,10 ";

$result = $conn->query($sql);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

  <div class="container">



    <div class="mt-2">
      <a href="./discountIndex.php" class="h2 text-decoration-none">優惠券目錄</a>
    </div>

    <form action="dosearch.php">
      <div class="my-2 align-items-center row">
        <div class="col-auto">
          <input type="text" class="form-control" name="searchName" placeholder="搜尋優惠券名稱">
        </div>
        <button class="btn btn-primary col-auto me-2" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      </div>
    </form>

    <div>
      <div class=" mb-2 col-auto">
        <a href="discountCreat.php" class="btn btn-primary"><i class="fa-solid fa-file-circle-plus"></i> 新增</a>
      </div>

      <div class="btn-group float-end col-auto">
        <button class="form-select " data-bs-toggle="dropdown" aria-expanded="false">
          排序條件
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="discountIndex.php?type=1">id升冪</a></li>
          <li><a class="dropdown-item" href="discountIndex.php?type=2">id降冪</a></li>
          <li><a class="dropdown-item" href="discountIndex.php?type=3">折扣升冪</a></li>
          <li><a class="dropdown-item" href="discountIndex.php?type=4">折扣降冪</a></li>
          <li><a class="dropdown-item" href="discountIndex.php?type=5">有效日期升冪</a></li>
          <li><a class="dropdown-item" href="discountIndex.php?type=6">有效日期降冪</a></li>
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
                    echo $row["discount"] . "%";
                  }
                  ?></td>
              <td><?= $row["discountCode"] ?></td>
              <td><?= $row["startDate"] ?> ~ <?= $row["endDate"] ?></td>
              <td><?= $row["created_at"] ?></td>
              <td><a href="discountDetail.php?id=<?= $row["id"] ?>" class="btn btn-primary">查看 <i class="fa-solid fa-right-to-bracket"></i> </a></td>
              <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $row["id"] ?>">刪除 <i class="fa-solid fa-trash-can"></i> </button>
              </td>
            </tr>

            <!-- 以下刪除提示 -->
            <div class="modal fade" id="exampleModal<?= $row["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel<?= $row["id"] ?>">確認刪除</h1>
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
        <li class="page-item <?php if (!isset($_GET["page"]) || $_GET["page"] == 1) {
                                echo "disabled";
                              } ?>">
          <a class="page-link " href="discountIndex.php?page=<?= $page - 1 ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php for ($i = 1; $i <= $totalPageCount; $i++) : ?>
          <li class="page-item <?php if ($page == $i) {
                                  echo "active";
                                } ?>"><a class="page-link" href="discountIndex.php?page=<?= $i ?>&type=<?= $type ?>"><?= $i ?></a></li>
        <?php endfor; ?>
        <li class="page-item <?php if (isset($_GET["page"]) && $_GET["page"] == $totalPageCount) {
                                echo "disabled";
                              } ?> ">
          <a class="page-link" href="discountIndex.php?page=<?= $page + 1 ?>" aria-label="Next">
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