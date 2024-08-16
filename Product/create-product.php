<!doctype html>
<html lang="en">
    <head>
        <title>新增商品</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <?php include('../css.php') ?>
    </head>

    <body>
    <div class="container">
        <div class="py-2">
            <a class="btn btn-primary" href="product-list.php" title="回商品列表"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
            <form action="doCreateProduct.php" method="post">
            <div class="mb-2" >
                    <label for="name" class="form-label"><span class="text-danger">*</span>商品名稱</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-2" >
                    <label for="name" class="form-label"><span class="text-danger">*</span>商品分類</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-2" >
                    <label for="name" class="form-label"><span class="text-danger">*</span>商品類別</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <button class="btn btn-primary" type="sumbit">送出</button>
            </form>
        </div>
    </body>
</html>
