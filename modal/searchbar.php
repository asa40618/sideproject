<!--搜尋sidebar  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">搜尋條件</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="dosearch.php">
            <div class="my-3">
                <label for="">名稱搜尋</label>
                <input type="text" class="form-control" name="searchName" placeholder="搜尋優惠券名稱">
            </div>
            <div class="my-3">
                <label for="">折扣價格搜尋</label>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control px-2" name="discountmin" placeholder="最小折扣">
                    <div> ~ </div>
                    <input type="text" class="form-control px-2" name="discountMax" placeholder="最大折扣">
                </div>
            </div>
            <div class="my-3">
                <label for="">有效日期搜尋</label>
                <div class="d-flex align-items-center">
                    <input type="date" class="form-control px-2" name="datemin" placeholder="最小日期">
                    <div> ~ </div>
                    <input type="date" class="form-control px-2" name="dateMax" placeholder="最大日期">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">搜尋</button>
        </form>
    </div>
</div>
<!--搜尋sidebar  -->