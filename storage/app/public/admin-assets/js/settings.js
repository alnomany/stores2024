CKEDITOR.replace("cname_text");
$(".basicinfo").on("click", function() {
  "use strict";
  $("#settingmenuContent").find(".card").attr("style", "");
  if ($(this).attr("data-tab") == "basicinfo" || $(this).attr("data-tab") == "theme_settings") {
    $("html, body").animate(
      {
        scrollTop: 0
      },
      "1000"
    );
  } else {
    if (!$(this).is(":last-child")) {
      $("#" + $(this).attr("data-tab"))
        .find(".card")
        .attr("style", "margin-top: 80px;");
    }
  }
  $(".list-options").find(".active").removeClass("active");
  $(this).addClass("active");
});
function show_feature_icon(x) {
  "use strict";
  $(x).next().html($(x).val());
}
var id = 1;
function add_features(icon, title, description) {
  "use strict";
  var html =
    '<div class="row remove' +
    id +
    '"><div class="col-md-3 form-group"><div class="input-group"><input type="text" class="form-control feature_icon" onkeyup="show_feature_icon(this)" name="feature_icon[]" placeholder="' +
    icon +
    '" required><p class="input-group-text"></p></div></div><div class="col-md-3 form-group"><input type="text" class="form-control" name="feature_title[]" placeholder="' +
    title +
    '" required></div><div class="col-md-5 form-group"><input type="text" class="form-control" name="feature_description[]" placeholder="' +
    description +
    '" required></div><div class="col-md-1 form-group"><button class="btn btn-outline-danger" type="button" onclick="remove_features(' +
    id +
    ')"><i class="fa-sharp fa-solid fa-xmark"></i></button></div></div>';
  $(".extra_footer_features").append(html);
  $(".feature_required").prop("required", true);
  id++;
}
function remove_features(id) {
  "use strict";
  $(".remove" + id).remove();
  if ($(".extra_footer_features .row").length == 0) {
    $(".feature_required").prop("required", false);
  }
}
function editimage(id)
{
    "use strict";
    $("#image_id").val(id);
    $("#editModal").modal('show');
}
var id = 1;
function add_social_links(icon,link) {
  "use strict";
  var html =
    '<div class="row remove' +
    id +
    '"><div class="col-md-6 form-group"><div class="input-group"><input type="text" class="form-control feature_icon" onkeyup="show_feature_icon(this)" name="social_icon[]" placeholder="' +
    icon +
    '" required><p class="input-group-text"></p></div></div><div class="col-md-6 d-flex align-items-center form-group"><input type="text" class="form-control" name="social_link[]" placeholder="' +
    link +
    '" required><button class="btn btn-outline-danger mx-2" type="button" onclick="remove_features(' +
    id +
    ')"><i class="fa-sharp fa-solid fa-xmark"></i></button></div></div>';
  $(".extra_social_links").append(html);
  $(".soaciallink_required").prop("required", true);
  id++;
}


