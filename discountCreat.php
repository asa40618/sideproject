<!doctype html>
<html lang="en">

<head>
  <title>discountCreat</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <style>

  </style>

</head>

<body>
  <div class="container">
    <form action="doDiscountCreat.php" method="post">
      <label for="discountName">優惠券名稱</label>
      <input type="text" class="form-control" name="discountName">

      <label for="countType">折扣種類</label>
      <select type="text" class="form-select" name="countType" id="CountType">
        <option value="1">固定折扣</option>
        <option value="2">百分比折扣</option>
      </select>
      <label for="discount">折扣</label>
      <input type="text" class="form-control" name="discount" placeholder="請輸入金額或折扣" id="">
      <label for="discountCode">折扣代碼</label>
      <input type="text" class="form-control" name="discountCode">
      <div class="row my-3 align-items-center">
        <label for="startDate" class="col-auto">起始日期:</label>
        <div class="col-3">
          <input type="date" class="form-control" name="startDate">
        </div>
        <label for="endDate" class="col-auto">結束日期:</label>
        <div class="col-3">
          <input type="date" class="form-control" name="endDate">
        </div>
      </div>
      <div class="d-flex">
        <button type="submit" class="btn btn-info">送出</button>
        <div class="ms-2">
          <a href="discountIndex.php" class="btn btn-info">返回列表</a>
        </div>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>




  </script>

</body>

</html>