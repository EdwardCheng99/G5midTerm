<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>促銷管理</title>

    <?php include("../headlink.php") ?>
</head>

<body>
    <script src="../assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include("../sidebar.php") ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>促銷管理</h3>
                            <p class="text-subtitle text-muted"></p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i
                                                class="fa-solid fa-house"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">促銷管理</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupSelect01">促銷類別</label>
                                        <select class="form-select" id="inputGroupSelect01">
                                            <option selected="">全部</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">促銷名稱</span>
                                        <input type="text" class="form-control" placeholder="" aria-label="Username" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">促銷時間</span>
                                        </div>
                                        <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input" placeholder="Select date.." readonly="readonly">
                                        <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input" placeholder="Select date.." readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-12">
                                    <div class="input-group mb-3 ">
                                        <label class="input-group-text" for="inputGroupSelect01">是否生效</label>
                                        <div class="form-check ms-3 d-flex align-items-center">
                                            <div class="checkbox">
                                                <input type="checkbox" id="checkbox1" class="form-check-input" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-primary me-1 mb-1">查詢</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">清除</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="dataTable-wrapper dataTable-loading no-footer sortable searchable fixed-columns">
                                    <div class="dataTable-top">
                                        <label for="">每頁</label>
                                        <div class="dataTable-dropdown">
                                            <select class="dataTable-selector form-select">
                                                <option value="5">5</option>
                                                <option value="10" selected="">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                            </select>
                                            <label>筆</label>
                                        </div>
                                        <div class="dataTable-search">
                                            <input class="dataTable-input" placeholder="Search..." type="text">
                                        </div>
                                    </div>
                                    <div class="dataTable-container table-responsive">
                                        <table class="table table-striped dataTable-table" id="table1">
                                            <thead>
                                                <tr>
                                                    <th data-sortable="" class="asc desc"><a href="#" class="dataTable-sorter">Name</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">Email</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">Phone</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">City</a></th>
                                                    <th data-sortable=""><a href="#" class="dataTable-sorter">Status</a></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Graiden</td>
                                                    <td>vehicula.aliquet@semconsequat.co.uk</td>
                                                    <td>076 4820 8838</td>
                                                    <td>Offenburg</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Dale</td>
                                                    <td>fringilla.euismod.enim@quam.ca</td>
                                                    <td>0500 527693</td>
                                                    <td>New Quay</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Nathaniel</td>
                                                    <td>mi.Duis@diam.edu</td>
                                                    <td>(012165) 76278</td>
                                                    <td>Grumo Appula</td>
                                                    <td>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Darius</td>
                                                    <td>velit@nec.com</td>
                                                    <td>0309 690 7871</td>
                                                    <td>Ways</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Oleg</td>
                                                    <td>rhoncus.id@Aliquamauctorvelit.net</td>
                                                    <td>0500 441046</td>
                                                    <td>Rossignol</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kermit</td>
                                                    <td>diam.Sed.diam@anteVivamusnon.org</td>
                                                    <td>(01653) 27844</td>
                                                    <td>Patna</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jermaine</td>
                                                    <td>sodales@nuncsit.org</td>
                                                    <td>0800 528324</td>
                                                    <td>Mold</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Ferdinand</td>
                                                    <td>gravida.molestie@tinciduntadipiscing.org</td>
                                                    <td>(016977) 4107</td>
                                                    <td>Marlborough</td>
                                                    <td>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kuame</td>
                                                    <td>Quisque.purus@mauris.org</td>
                                                    <td>(0151) 561 8896</td>
                                                    <td>Tresigallo</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Deacon</td>
                                                    <td>Duis.a.mi@sociisnatoquepenatibus.com</td>
                                                    <td>07740 599321</td>
                                                    <td>Karapınar</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Channing</td>
                                                    <td>tempor.bibendum.Donec@ornarelectusante.ca</td>
                                                    <td>0845 46 49</td>
                                                    <td>Warrnambool</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Aladdin</td>
                                                    <td>sem.ut@pellentesqueafacilisis.ca</td>
                                                    <td>0800 1111</td>
                                                    <td>Bothey</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Cruz</td>
                                                    <td>non@quisturpisvitae.ca</td>
                                                    <td>07624 944915</td>
                                                    <td>Shikarpur</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Keegan</td>
                                                    <td>molestie.dapibus@condimentumDonecat.edu</td>
                                                    <td>0800 200103</td>
                                                    <td>Assen</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Ray</td>
                                                    <td>placerat.eget@sagittislobortis.edu</td>
                                                    <td>(0112) 896 6829</td>
                                                    <td>Hofors</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Maxwell</td>
                                                    <td>diam@dapibus.org</td>
                                                    <td>0334 836 4028</td>
                                                    <td>Thane</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Carter</td>
                                                    <td>urna.justo.faucibus@orci.com</td>
                                                    <td>07079 826350</td>
                                                    <td>Biez</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Stone</td>
                                                    <td>velit.Aliquam.nisl@sitametrisus.com</td>
                                                    <td>0800 1111</td>
                                                    <td>Olivar</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Berk</td>
                                                    <td>fringilla.porttitor.vulputate@taciti.edu</td>
                                                    <td>(0101) 043 2822</td>
                                                    <td>Sanquhar</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Philip</td>
                                                    <td>turpis@euenimEtiam.org</td>
                                                    <td>0500 571108</td>
                                                    <td>Okara</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kibo</td>
                                                    <td>feugiat@urnajustofaucibus.co.uk</td>
                                                    <td>07624 682306</td>
                                                    <td>La Cisterna</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Bruno</td>
                                                    <td>elit.Etiam.laoreet@luctuslobortisClass.edu</td>
                                                    <td>07624 869434</td>
                                                    <td>Rocca d"Arce</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Leonard</td>
                                                    <td>blandit.enim.consequat@mollislectuspede.net</td>
                                                    <td>0800 1111</td>
                                                    <td>Lobbes</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Hamilton</td>
                                                    <td>mauris@diam.org</td>
                                                    <td>0800 256 8788</td>
                                                    <td>Sanzeno</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Harding</td>
                                                    <td>Lorem.ipsum.dolor@etnetuset.com</td>
                                                    <td>0800 1111</td>
                                                    <td>Obaix</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href=""> <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href=""><i class="fa-solid fa-circle-info fa-lg"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="dataTable-bottom">
                                        <div class="dataTable-info">Showing 11 to 20 of 26 entries</div>
                                        <nav class="dataTable-pagination justify-content-center">
                                            <ul class="dataTable-pagination-list pagination pagination-primary">
                                                <li class="pager page-item"><a href="#" data-page="1" class="page-link">‹</a></li>
                                                <li class="page-item"><a href="#" data-page="1" class="page-link">1</a></li>
                                                <li class="active page-item"><a href="#" data-page="2" class="page-link">2</a></li>
                                                <li class="page-item"><a href="#" data-page="3" class="page-link">3</a></li>
                                                <li class="pager page-item"><a href="#" data-page="3" class="page-link">›</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include("../footer.php") ?>
        </div>
    </div>
    <?php include("../js.php") ?>

</body>

</html>