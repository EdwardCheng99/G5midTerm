<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增商品</title>
    <link rel="stylesheet" href="./css.css">
    <link rel="stylesheet" href="../assets/style.css">
    <?php include("../headlink.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include("../sidebar.php") ?>
        <?php include("../css.php") ?>

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



                                    <form action="doCreateProduct.php" method="POST" enctype="multipart/form-data">

                                        <div class="row">
                                            <div class="col-6">
                                            
                                                <div class="mb-2">

                                                    <label for="productName" class="form-label required">商品名稱</label>
                                                    <input type="text" class="form-control" name="product_name" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="brand" class="form-label required">品牌</label>
                                                    <select class="form-select" name="product_brand" required>
                                                        <option value="">請選擇品牌</option>
                                                        <option value="木入森">木入森</option>
                                                        <option value="水魔素">水魔素</option>
                                                        <option value="陪心">陪心</option>
                                                        <option value="美喵">美喵</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="category" class="form-label required">類別</label>
                                                    <select class="form-select" name="product_category_name" required>
                                                        <option value="">請選擇類別</option>
                                                        <option value="犬貓通用">犬貓通用</option>
                                                        <option value="犬寶保健">犬寶保健</option>
                                                        <option value="貓皇保健">貓皇保健</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="sub" class="form-label required">分類</label>
                                                    <select class="form-select" name="product_sub_category" required>
                                                        <option value="">請選擇分類</option>
                                                        <option value="魚油粉">魚油粉</option>
                                                        <option value="鈣保健">鈣保健</option>
                                                        <option value="腸胃保健">腸胃保健</option>
                                                        <option value="關節保健">關節保健</option>
                                                        <option value="口腔保健">口腔保健</option>
                                                        <option value="心臟保健">心臟保健</option>
                                                        <option value="皮膚保健">皮膚保健</option>
                                                        <option value="胰臟保健">胰臟保健</option>
                                                        <option value="眼睛保健">眼睛保健</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="originPrice" class="form-label required">原價</label>
                                                    <input type="text" class="form-control" name="product_origin_price" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="salePrice" class="form-label required">售價</label>
                                                    <input type="tel" class="form-control" name="product_sale_price" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="stock" class="form-label required">庫存</label>
                                                    <input type="text" class="form-control" name="product_stock" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">
                                                    <!-- <label for="productPicName" class="form-label" >商品圖片上傳</label>
                                                    <input type="text" class="form-control" name="product_img" required> -->
                                                </div>
                                                <div class="mb-2">
                                                    <label for="formFile" class="form-label required">選取商品圖片</label>
                                                    <input type="file" id="formFile" name="pic" class="form-control" required>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="ratio ratio-4x3 border mb-2">
                                                        <img id="imagePreview" class="img-preview" src="" alt="Image Preview">
                                                    </div>
                                                </div>
                                                <div class="col-lg">
                                                    <div class="form-group">
                                                        <label for="" class="form-label required">商品介紹</label>
                                                        <textarea class="form-control" rows="8" maxlength="400" placeholder="請輸入商品介紹" name="product_info" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button class="btn btn-primary" type="submit">送出</button>
                                                    <button type="reset" class="btn btn-light-secondary ms-2">清除</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
            </section>
        </div>
    </div>
    </div>


    <script src="../assets/static/js/components/dark.js"></script>
    <script src="../assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <?php include("../js.php") ?>
    <?php include("./product-js.php") ?>
    <script src="../assets/compiled/js/app.js"></script>


</body>

</html>