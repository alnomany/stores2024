$("#delivery_dt").on("change", function() {
  "use strict";
  $("#delivery_time").empty();
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: $("#sloturl").val(),
    type: "post",
    dataType: "json",
    data: {
      inputDate: $(this).val(),
      vendor_id: $("#store_id").val()
    },
    success: function(response) {
      let html = "";
      if (response == "1") {
        $("#store_close").removeClass("d-none");
        $("#delivery_time").addClass("d-none");
      } else {
        $("#store_close").addClass("d-none");
        $("#delivery_time").removeClass("d-none");
        $("#delivery_time").append('<option value="">' + select + "</option>");
        for (var i in response) {
          $("#delivery_time").append(
            '<option value="' +
              response[i]["slot"] +
              '">' +
              response[i]["slot"] +
              "</option>"
          );
        }
      }
    }
  });
});
function copyToClipboard(element) {
  "use strict";
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    url: $("#copycodeurl").val(),
    type: "post",
    dataType: "json",
    data: {
      code: element
    },
    success: function(response) {
      if (response.status == 1) {
        var total = $("#sub_total").val();
        var tax = $("#tax").val();
        var delivery_charge = $("#delivery_charge").val();
        var discount = 0;
        var grandtotal =
          parseFloat(total) +
          parseFloat(tax) +
          parseFloat(delivery_charge) -
          parseFloat(discount);
        $("#offer_amount").text("-" + currency_formate(parseFloat(0)));
        $("#total_amount").text(currency_formate(parseFloat(grandtotal)));
        $("#couponcode").val("");
        $("#grand_total").val(grandtotal);
        $("#discount_amount").val(discount);
        $("#couponcode").val("");
        $("#btnremove").addClass("d-none");
        $("#btnapply").removeClass("d-none");
        $("#couponcode").val(response.element);
        $("#offerslabel").offcanvas("hide");
      } else {
        toastr.error(response.message);
      }
    }
  });
}
