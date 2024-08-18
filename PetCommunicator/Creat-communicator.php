<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>溝通師新增</title>

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
                                <h3>溝通師新增</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">溝通師新增</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                            <a href="petcommunicators.php?p=1" class="btn btn-primary mb-2">返回</a>
                            
                                <form action="doCreat.php" method="post">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="col">
                                            <input type="hidden" id="" class="form-control" placeholder="" name="PetCommStatus" value="未刊登">
                                            <input type="hidden" id="" class="form-control" placeholder="" name="valid" value="1">
                                            
                                                <div class="form-group">
                                                    <label for="">名稱</label>
                                                    <input type="text" id="" class="form-control" placeholder="" name="PetCommName">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">性別</label>
                                                    <select class="dataTable-selector form-select" name="PetCommSex">
                                                        <option value="male">男</option>
                                                        <option value="female">女</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">證照編號</label>
                                                    <input type="text" id="" class="form-control" placeholder="" name="PetCommCertificateid" value="動溝證字第">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">取證日期</label>
                                                    <input type="text" id="" class="form-control" placeholder="" name="PetCommCertificateDate">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">服務項目</label>
                                                    <input type="text" id="" class="form-control" placeholder="" name="PetCommService">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">進行方式</label>
                                                    <input type="text" id="" class="form-control" placeholder="" name="PetCommApproach">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">預約費用</label>
                                                    <input type="text" id="" class="form-control" placeholder="" name="PetCommFee">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">Eamil</label>
                                                    <input type="text" id="" class="form-control" placeholder="" name="PetCommEmail">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">介紹</label>
                                                    <textarea class="form-control" placeholder="" name="PetCommIntroduction"></textarea>
                                                </div>
                                                
                                            </div>


                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">相片</label>
                                                <input class="form-control" type="file" id="formFile" accept="image/*" name="PetCommImg">
                                            </div>
                                            <div class="ratio ratio-4x3 border">
                                            <img id="imagePreview" class="img-preview" src="" alt="Image Preview" style="display: none;">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">送出</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">清除</button>
                                        </div>
                                    </div>
                                </form>
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
    
<?php include("./js/js.php")?>
    

</body>

</html>