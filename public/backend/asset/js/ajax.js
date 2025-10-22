$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#file").on('change', () => {
    console.log("File change detected");
    var formData = new FormData();
    var file = $("#file")[0].files[0];
    formData.append('file', file);

    $.ajax({
        url: '/upload',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (result) {
            if (result.success === true) {
                
                html += '<img src="' + result.path + '" alt="" >';
                $('#input-file-img').html(html);
                $('#input-file-img-hidden').val(result.path);
            }
        }
    });
});
// 
$('#files').on('change', function(e) {
    var formData = new FormData();
    var files = $('#files')[0].files;
    for (let index = 0; index < files.length; index++) {
        formData.append('files[]', files[index]);
    }

    $.ajax({
        url: '/uploads',
        method: 'POST',
        dataType: 'JSON',
        data: formData,
        contentType: false,
        processData: false,
        success: function(result) {
            if (result.success == true) {
                let html="";
                
                if (url.includes('minacode.net')) {
                    for (let index = 0; index < result.url.length; index++) {
                        let truePath = "/public" + result.url[index];
                        
                        html += '<img src="' + truePath + '" alt=""><input type="hidden" value="' + truePath + '" class="product-images" name="product_images[]">';
                    }
                    $('#input-file-imgs').html(html);
                } else {
                    html=""
                    for (let index = 0; index < result.url.length; index++) {
                        html += '<img src="' + result.url[index] + '" alt=""><input type="hidden" value="' + result.url[index] + '" class="product-images" name="product_images[]">';
                    }
                    $('#input-file-imgs').html(html);
                }
            }
        }
    });
});
//delete
function removeRow(product_id,url){
    if(confirm('Ok')){
        $.ajax({
            url:url,
            data:{product_id},
            method:'GET',
            dataType:'JSON',
            success: function(res){
                console.log(res)
            }
        })
    }
}


