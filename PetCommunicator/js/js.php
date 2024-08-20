<script>
    const formFile=document.querySelector("#formFile")
    formFile.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('imagePreview');
                img.src = e.target.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').style.display = 'none';
        }
    });
// -- 創建表單驗證
function setPrefix() {
    var input = document.getElementById('certIdInput');
    var prefix = '動溝證字第';
    if (input.value.startsWith(prefix)) {
        input.value = input.value;
    } else {
        input.value = prefix + input.value;
    }
}

</script>