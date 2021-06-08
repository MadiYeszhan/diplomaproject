$(document).ready(function(){
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    if (i > 1){
        $("#remove_title").removeClass('d-none');
    }

    for (let i = 1; i < 4; i++) {
        $(".sbtn" + i).click(function() {
            if ($("#side"+i).is(":visible")) {
                        $(".sbtn"+i).html('Show side effect');
                        $("#side"+i).hide(200);
                    }else{
                        $(".sbtn"+i).html('Hide side effect');
                        $("#side"+i).show(200);
                    }
        });
    }

    for (let i = 1; i < 4; i++) {
        $(".cbtn" + i).click(function() {
                if ($("#contradiction"+i).is(":visible")) {
                    $(".cbtn"+i).html('Show contradiction');
                    $("#contradiction"+i).hide(200);

                }else{
                    $(".cbtn"+i).html('Hide contradiction');
                    $("#contradiction"+i).show(200);
                }
        });
    }


    $('input[name="contradiction_diseases"]').amsifySuggestags({
        suggestions: diseaseArr,
        whiteList: true
    });

    var i_img = 0;

    $('#disease_id').selectpicker('render');
    $('#manufacturer_id').selectpicker('render');
    $('#drug_id').selectpicker('render');
    $("#add_image").click(function() {
        i_img++;
        var x = $("#drug_images");
        var new_field = '<input type="file" class="form-control-file mb-2 w-25" required accept="image/*" id="drug_image_'+i_img+'" name="drug_image_'+i_img+'">';
        x.append(new_field);
        $("#drug_images_count").val(i_img);
        if(i_img > 0){
            $("#remove_image").removeClass('d-none');
        }
    });
    $("#remove_image").click(function() {
        if (i_img !== 0) {
            $("#drug_image_"+i_img).remove();
            i_img--;
            $("#drug_images_count").val(i_img);
            if (i_img  === 0){
                $("#remove_image").addClass('d-none');
            }
        }
    });

    $(".delete_image").click(function() {
        if (old_img !== 0) {
            let id = $("#old_image_"+old_img).data("id");
            if (id !== undefined){
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                    {
                        url: '/admin/drugs/drug_image/'+id,
                        type: 'GET',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (){
                            console.log("it Works");
                        }
                    });
            }
            $("#old_image_"+old_img).remove();
            old_img--;
            $("#old_images_count").val(old_img);
        }
    });

    setInterval(function(){
        $('.form-control-file').popover({
        trigger: 'hover',
        html: true,
        content: function () {
            var img = document.createElement("img");
            img.setAttribute('class', 'img-fluid');
            img.src  = "http://placehold.it/400x200";
            if (this.files && this.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    img.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
            return img;
        },
        title: 'Image'
    })}, 300);

    $('.images').popover({
        trigger: 'hover',
        html: true,
        content: function () {
            var img = document.createElement("img");
            img.setAttribute('class', 'img-fluid');
            img.src  = $(this).data('src');
            return img;
        },
        title: 'Image'
    });
});
