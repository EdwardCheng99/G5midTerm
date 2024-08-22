<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreateEvent</title>
    <?php include("../headlink.php") ?>

    <!-- Quill Editor -->
    <link rel="stylesheet" href="../assets/extensions/quill/quill.snow.css">
    <link rel="stylesheet" href="../assets/extensions/quill/quill.bubble.css">
    <style>
        .image-preview-wrapper {
            width: 100%;
            /* 設置預覽框的寬度 */
            height: 240px;
            /* 設置預覽框的高度 */
            border: 2px dashed #ccc;
            /* 虛線框表示預覽區域 */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            /* 確保圖片不會超出邊界 */
            background-color: #f8f9fa;
            /* 背景顏色，用於佔位 */
        }

        .image-preview-wrapper img {
            max-width: 100%;
            /* max-height: 100%; */
        }

        #editor-container {
            height: 300px;
        }

        .ql-editor {
            min-height: 200px;
            max-height: 500px;
            overflow-y: auto;
            /* 允許垂直滾動 */
        }
    </style>
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
            <!-- Event -->

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <button type="submit" class="btn btn-primary mb-4"> <a class="text-white" href="./OfficialEventsList.php">回列表</a></button>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">活動管理</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <!-- 預覽圖片的區域 -->
                        <div class="mb-3">
                            <label for="image" class="form-label">封面圖片</label>
                            <input type="file" class="form-control" id="image" accept="image/*" required>
                            <!-- 預留預覽圖片框 -->
                            <div id="image-preview-wrapper" class="image-preview-wrapper">
                                <img id="image-preview" src="#" alt="圖片預覽" class="img-fluid d-none" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label col-3">活動標題</label>
                            <div class="col">
                                <input type="text" class="form-control mb-3" id="title" placeholder="輸入文章標題" required>
                            </div>
                        </div>
                        <div class="mb-3"> <label for="title" class="form-label col-3">活動時間</label>
                            <div class="row">
                                <div class="col">
                                    <input type="text" class="form-control  flatpickr-no-config flatpickr-input active " placeholder="開始時間." readonly="readonly">
                                </div>
                                <div class="col">
                                    <!-- <label for="title" class="form-label">活動結束</label> -->
                                    <input type="text" class="form-control  flatpickr-no-config flatpickr-input active " placeholder="結束時間." readonly="readonly">
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">活動內容</label>
                            <div id="editor-container"></div>
                            <textarea class="form-control d-none" id="content" rows="5" placeholder="輸入文章內容" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form id="articleForm">
                            <div class="mb-3">
                                <label for="title" class="form-label col-3">報名時間</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active " placeholder="開始時間." readonly="readonly">
                                    </div>
                                    <div class="col">
                                        <!-- <label for="title" class="form-label">活動結束</label> -->
                                        <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active " placeholder="結束時間." readonly="readonly">
                                    </div>
                                </div>

                            </div>
                            <div class="mb-3">
                                <label class="form-label">活動類型</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="eventType" id="eventTypeOnline" value="online" checked>
                                        <label class="form-check-label" for="eventTypeOnline">
                                            線上活動
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="eventType" id="eventTypeOffline" value="offline">
                                        <label class="form-check-label" for="eventTypeOffline">
                                            實體活動
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="addressField" class="mb-3" style="display: none;">
                                <label for="event-address" class="form-label">活動地址</label>
                                <input type="text" class="form-control" id="event-address" name="event-address">
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col"><label for="title" class="form-label">上架日期</label>
                                        <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active" placeholder="Select date.." readonly="readonly">
                                    </div>
                                    <div class="col"><label for="title" class="form-label">下架日期</label>
                                        <input type="text" class="form-control mb-3 flatpickr-no-config flatpickr-input active" placeholder="Select date.." readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center">
                                <label class="form-label me-3 mb-0">發布狀態</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="draft">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            立即發布
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="published" checked>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            儲存草稿
                                        </label>
                                    </div>
                                </div>

                            </div>

                    </div>

                </div>

            </div>
            <div class="d-flex justify-content-center mt-3 mb-3">
                <button type="submit" class="btn btn-primary">提交</button>
            </div>
            <?php include("../footer.php") ?>
        </div>

    </div>

    </div>
    <?php include("../js.php") ?>


    <!-- QuillEditor -->
    <script src="../assets/extensions/quill/quill.min.js"></script>
    <script src="quill.min.js"></script>
    <script>
        // 預覽圖片
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0]; // 取得上傳的圖片
            const imagePreview = document.getElementById('image-preview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result; // 設置預覽圖片的 src 屬性為上傳圖片的路徑
                    imagePreview.classList.remove('d-none'); // 顯示預覽圖片
                };

                reader.readAsDataURL(file); // 讀取圖片，並在讀取完成後觸發 onload 事件
            } else {
                imagePreview.src = "#";
                imagePreview.classList.add('d-none'); // 沒有選擇圖片時隱藏預覽圖片
            }
        });
        //實體活動地址填寫
        document.addEventListener('DOMContentLoaded', function() {
            const eventTypeRadios = document.querySelectorAll('input[name="eventType"]');
            const addressField = document.getElementById('addressField');

            function toggleAddressField() {
                if (document.getElementById('eventTypeOffline').checked) {
                    addressField.style.display = 'block';
                } else {
                    addressField.style.display = 'none';
                }
            }

            eventTypeRadios.forEach(radio => {
                radio.addEventListener('change', toggleAddressField);
            });

            // 初始化時執行一次
            toggleAddressField();
        });

        // Initialize Quill editor with image upload option
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        header: 1
                    }, {
                        header: 2
                    }],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    [{
                        script: 'sub'
                    }, {
                        script: 'super'
                    }],
                    [{
                        size: ['small', false, 'large', 'huge']
                    }],
                    [{
                        header: [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['link', 'image', 'video'],
                    [{
                        color: []
                    }, {
                        background: []
                    }],
                    [{
                        align: []
                    }],
                ]
            }
        });


        // Handle form submission
        document.getElementById('articleForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const title = document.getElementById('title').value;
            const content = quill.root.innerHTML; // Get content from Quill editor
            const image = document.getElementById('image').files[0];
            const status = document.getElementById('status').value;

            const result = `
            <h2>文章提交成功</h2>
            <p><strong>標題:</strong> ${title}</p>
            <p><strong>內容:</strong> ${content}</p>
        `;
            document.getElementById('result').innerHTML = result;
        });
    </script>

</body>

</html>