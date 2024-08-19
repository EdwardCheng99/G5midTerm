<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增商品</title>

    <?php include("../headlink.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include("../sidebar.php") ?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <header>
            </header>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>新增商品</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">新增商品</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                    <div class="dataTable-top">
                                        <div class="py-2">
                                            <a class="btn btn-primary" href="ProductList.php" title="回商品管理"><i class="fa-solid fa-arrow-left"></i></a>
                                        </div>

                                        <div class="dataTable-search">

                                        </div>
                                    </div>

                                    <div class="dataTable-container">
                                        <form action="doCreateProduct.php" method="POST" enctype="multipart/form-data">
                                            <table class="table table-striped dataTable-table" id="table1">
                                                <div class="mb-2">
                                                    <label for="productName" class="form-label">商品名稱</label>
                                                    <input type="text" class="form-control" name="product_name" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="brand" class="form-label">品牌</label>
                                                    <select class="form-select" name="product_brand" required>
                                                        <option value="">請選擇品牌</option>
                                                        <option value="木入森">木入森</option>
                                                        <option value="陪心">陪心</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="originPrice" class="form-label">原價</label>
                                                    <input type="text" class="form-control" name="product_origin_price">
                                                </div>
                                                <div class="mb-2">
                                                    <label for="salePrice" class="form-label">售價</label>
                                                    <input type="tel" class="form-control" name="product_sale_price" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="stock" class="form-label">庫存</label>
                                                    <input type="text" class="form-control" name="product_stock" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="productPicName">商品圖片名稱</label>
                                                    <input type="text" class="form-control" name="product_img" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="">選取檔案</label>
                                                    <input type="file" name="pic" class="form-control" required>
                                                </div>
                                                <button class="btn btn-primary" type="submit">送出</button>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="dataTable-bottom">
                                        <div class="dataTable-info"></div>
                                        <nav class="dataTable-pagination">
                                            <ul class="dataTable-pagination-list pagination pagination-primary">


                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                    </div>
                    <div class="float-end">
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="../assets/compiled/js/app.js"></script>


</body>

</html>