<!doctype html>
<html lang="en">

<head>
    <title>user</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
                                <h3>修改資料</h3>
                                <p class="text-subtitle text-muted"></p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><a href="MemberList.php?p=1&sorter=1">會員管理</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $row["MemberName"] ?></a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <!-- 會員資訊 -->
                        <div class="card-body">
                            <form class="form form-vertical" action="doCreateMember.php" method="post">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">ID : <?= $row["MemberID"] ?></label>
                                                <input type="hidden" name="id" value="<?= $row["MemberID"] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">Name</label>
                                                <input type="text" class="form-control" name="name" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">Account</label>
                                                <input type="text" class="form-control" name="account" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">PCID</label>
                                                <input type="text" id="email-id-vertical" class="form-control" name="pcid" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">Admin</label>
                                                <input type="text" id="contact-info-vertical" class="form-control" name="admin" placeholder="Mobile" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">Password</label>
                                                <input type="text" id="password-vertical" class="form-control" name="password" placeholder="Password" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">NickName</label>
                                                <input type="text" id="first-name-vertical" class="form-control" name="nickname" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Level</label>
                                                <input type="text" id="email-id-vertical" class="form-control" name="level" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">Email</label>
                                                <input type="email" id="contact-info-vertical" class="form-control" name="email" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">Phone</label>
                                                <input type="text" id="password-vertical" class="form-control" name="phone" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">Tel</label>
                                                <input type="tel" id="first-name-vertical" class="form-control" name="tel" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Address</label>
                                                <input type="text" id="email-id-vertical" class="form-control" name="address" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="contact-info-vertical">Birth</label>
                                                <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active" placeholder="Select date.." name="birth" readonly="readonly" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">Gender</label>
                                                <input type="text" id="password-vertical" class="form-control" name="gender" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="first-name-vertical">Valid</label>
                                                <input type="text" id="first-name-vertical" class="form-control" name="valid" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">BlackList</label>
                                                <input type="text" id="email-id-vertical" class="form-control" name="blacklist" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">Created_UserID</label>
                                                <input type="text" id="password-vertical" class="form-control" name="createuserid" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="password-vertical">Uptate_UserID</label>
                                                <input type="text" id="password-vertical" class="form-control" name="updateuserid" placeholder="" value="">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
            </div>
                </div>
            </section>
        </div>
    </div>
    <?php include("../js.php");?>
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
    <script>
        src = "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity = "sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin = "anonymous"
    </script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>