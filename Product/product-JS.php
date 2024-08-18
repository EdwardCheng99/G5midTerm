<!-- 控制每頁筆數 page 但好像有bug 修不好 先不用-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pageSize = document.querySelector("#pageselect");
        const dataTbody = document.querySelector("#table1 tbody");

        const data = <?= json_encode($rows) ?>; // 將 PHP 的資料轉換為 JS 陣列

        function page(pageSize) {
            dataTbody.innerHTML = ''; // 清空表格
            const rowsToDisplay = data.slice(0, pageSize);
            const rowsHTML = rowsToDisplay.map(function(row) {
                return `
                    <tr>
                        <td>${row.product_id}</td>
                        <td>
                            <div class="ratio ratio-1x1">
                                <img class="object-fit-cover" src="./moreson/${row.product_img}" alt="${row.product_name}">
                            </div>
                        </td>
                        <td>${row.product_name}</td>
                        <td>${row.product_brand}</td>
                        <td></td>
                        <td></td>
                        <td>${new Intl.NumberFormat().format(row.product_origin_price)}</td>
                        <td>${new Intl.NumberFormat().format(row.product_sale_price)}</td>
                        <td>${row.product_stock}</td>
                        <td>${row.product_create_date}</td>
                        <td></td>
                        <td>
                            <a title="檢視商品" class="btn btn-primary" href="product.php?product_id=${row.product_id}">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </a>
                        </td>
                    </tr>
                `;
            }).join('');
            dataTbody.innerHTML = rowsHTML; // 更新表格內容
        }

        pageSize.addEventListener('change', function(event) {
            const selectedPageSize = parseInt(event.target.value, 10);
            page(selectedPageSize);
        });

        // 初始筆數
        page(parseInt(pageSize.value, 10));
    });
</script>