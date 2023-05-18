


$("#form_puesto").on("submit", function() {
    var formData = new FormData(document.getElementById("form_puesto"));
    console.log(formData);
        $.ajax({
            url: "insert_puesto.php",
            type: "post",
            //dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == "TRUE") {
                    console.log(res);
                }else{
                    alert(res);
                }
            }
        })
            /*.done(function(res){
                if (res == "TRUE"){
                    ok ();
                }
            });*/
});