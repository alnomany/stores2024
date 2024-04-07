
function show_funfact_icon(x){

    "use strict";

    $(x).next().html($(x).val())

}

var id = 1;

function add_funfact(icon, title, description) {

    "use strict";

    var html = '<div class="row remove' + id + '"><div class="col-md-3 form-group"><div class="input-group"><input type="text" class="form-control feature_icon" onkeyup="show_funfact_icon(this)" name="funfact_icon[]" placeholder="' + icon + '" required><p class="input-group-text"></p></div></div><div class="col-md-3 form-group"><input type="text" class="form-control" name="funfact_title[]" placeholder="' + title + '" required></div><div class="col-md-5 form-group"><input type="text" class="form-control" name="funfact_subtitle[]" placeholder="' + description + '" required></div><div class="col-md-1 form-group"><button class="btn btn-outline-danger" type="button" onclick="remove_funfcat(' + id + ')"><i class="fa-sharp fa-solid fa-xmark"></i></button></div></div>';

    $('.extra_footer_features').append(html);

    $(".feature_required").prop('required',true);

    id++;

}

function remove_funfcat(id) {

    "use strict";

    $('.remove' + id).remove();

    if ($('.extra_footer_features .row').length == 0) {

        $(".feature_required").prop('required',false);

    }

}