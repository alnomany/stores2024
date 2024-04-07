/*
[Table of contents]

1 header-fixed js

2 menu-icon js 

3 lazyload js

4 wow js

5 Owl carousel js
*/
/* menu-icon js */
$(".navbar-toggler").click(function () {
  $("html").toggleClass("show-menu");
});
/* menu-icon js */
/* lazyload js */
$(function () {
  $("img.lazyload").lazyload();
});
/* lazyload js */
/* Owl carousel js */
$(".banner-carousel").owlCarousel({
  items: 1,
  loop: true,
  margin: 1,
  nav: true,
  autoplay: true,
  autoplayTimeout: 3000,
  autoplayHoverPause: true
});
$(".review-carousel").owlCarousel({
  items: 1,
  loop: true,
  margin: 10,
  nav: true,
  dots: false
});
$(".product-details-img").owlCarousel({
  items: 1,
  loop: true,
  margin: 0,
  nav: false,
  dots: true,
  autoplay: true
});
$(".feature-carousel").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  margin: 10,
  nav: false,
  dots: false,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 3
    }
  }
});
$(".pro-ref-carousel").owlCarousel({
  // items: 2,
  loop: true,
  margin: 10,
  nav: true,
  dots: false,
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 3
    }
  }
});
$(".ingredients-carousel").owlCarousel({
  // items: 2,
  loop: true,
  margin: 0,
  nav: false,
  dots: false,
  autoplay: true,
  responsive: {
    0: {
      items: 1
    },
    481: {
      items: 2
    },
    576: {
      items: 3
    },
    768: {
      items: 4
    },
    992: {
      items: 5
    },
    1200: {
      items: 6
    }
  }
});

//========= home banner =========//
$(".furniture_home").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,

  nav: true,
  dots: false,
  // autoplay: true,
  // autoplayTimeout: 2000,
  navText: [
    "<i class='fa-solid fa-arrow-left-long'></i>",
    "<i class='fa-solid fa-arrow-right-long'></i>"
  ],
  responsive: {
    0: {
      items: 1,
      nav: false
    },
    600: {
      items: 1,
      nav: false,
      margin: 10
    },
    1000: {
      items: 1,
      margin: 10
    }
  }
});

$(document).ready(function () {
  var sync1 = $("#sync1");
  var sync2 = $("#sync2");
  var slidesPerPage = 4; //globaly define number of elements per page
  var syncedSecondary = true;
  sync1
    .owlCarousel({
      items: 1,
      nav: false,
      loop: true,
      dots: false,
      autoplay: false,
      mouseDrag: false,
      animateOut: "fadeOut",
      responsiveRefreshRate: 200,
      navText: [
        '<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>',
        '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'
      ]
    })
    .on("changed.owl.carousel", syncPosition);
  sync2
    .on("initialized.owl.carousel", function () {
      sync2.find(".owl-item").eq(0).addClass("current");
    })
    .owlCarousel({
      nav: true,
      dots: false,
      autoWidth: true,
      mouseDrag: false,
      slideBy: slidesPerPage,
      responsiveRefreshRate: 100
    })
    .on("changed.owl.carousel", syncPosition2);
  function syncPosition(el) {
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
    if (current < 0) {
      current = count;
    }
    if (current > count) {
      current = 0;
    }
    sync2
      .find(".owl-item")
      .removeClass("current")
      .eq(current)
      .addClass("current");
    var onscreen = sync2.find(".owl-item.active").length - 1;
    var start = sync2.find(".owl-item.active").first().index();
    var end = sync2.find(".owl-item.active").last().index();
    if (current > end) {
      sync2.data("owl.carousel").to(current, 100, true);
    }
    if (current < start) {
      sync2.data("owl.carousel").to(current - onscreen, 100, true);
    }
  }
  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index;
      sync1.data("owl.carousel").to(number, 100, true);
    }
  }
  sync2.on("click", ".owl-item", function (e) {
    e.preventDefault();
    var number = $(this).index();
    sync1.data("owl.carousel").to(number, 300, true);
  });
});
/* Owl carousel js */
/* Product Grid & List */
$(document).ready(function () {
  $("#list").click(function (event) {
    event.preventDefault();
    $(".cat-product .row > div").addClass("col-12");
    // $('#posts img').addClass('d-none');
    $("#grid").removeClass("active");
    $("#list").addClass("active");
  });
  $("#grid").click(function (event) {
    event.preventDefault();
    $(".cat-product .row > div").removeClass("col-12");
    // $('#posts .item').addClass('col-4');
    // $('#posts img').removeClass('d-none');
    $("#list").removeClass("active");
    $("#grid").addClass("active");
  });
  window.onload = function () {
    setTimeout(() => {
      document.body.classList.add("loaded");
      $("body")
        .find(".placeholder")
        .removeClass("placeholder , d-inline-block , mb-2 , mx-1");
    }, 1000);
  };
});
/* Product Grid & List */
/* back to Top */
// hide #back-top first
$("#myBtn").hide();
// fade in #back-top
$(function () {
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $("#myBtn").fadeIn();
    } else {
      $("#myBtn").fadeOut();
    }
  });
  // scroll body to 0px on click
  $("#myBtn").click(function () {
    $("body,html").animate(
      {
        scrollTop: 0
      },
      1000
    );
    return false;
  });
});
/* back to Top */
/* Qty increase & decrease */
// $('.add').click(function () {
// 	if ($(this).prev().val() < 200) {
// 		$(this).prev().val(+$(this).prev().val() + 1);
// 	}
// });
// $('.sub').click(function () {
// 	if ($(this).next().val() > 1) {
// 		if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
// 	}
// });
// This button will increment the value
$(".add").click(function (e) {
  var max_qty = $("#max_qty").val();
  // Stop acting like a button
  e.preventDefault();
  // Get the field name
  fieldName = $(this).attr("field");
  // Get its current value
  var currentVal = parseInt($("input[name=" + fieldName + "]").val());
  // If is not undefined
  if (!isNaN(currentVal)) {
    // Increment only if value is < 20
    if (currentVal < max_qty) {
      $("input[name=" + fieldName + "]").val(currentVal + 1);
      $(".sub").val("-").removeAttr("style");
    } else {
      $(".add").val("+").css("color", "#aaa");
      $(".add").val("+").css("cursor", "not-allowed");
    }
  } else {
    // Otherwise put a 0 there
    $("input[name=" + fieldName + "]").val(1);
  }
});
// This button will decrement the value till 0
$(".sub").click(function (e) {
  // Stop acting like a button
  e.preventDefault();
  // Get the field name
  fieldName = $(this).attr("field");
  // Get its current value
  var currentVal = parseInt($("input[name=" + fieldName + "]").val());
  // If it isn't undefined or its greater than 0
  if (!isNaN(currentVal) && currentVal > 1) {
    // Decrement one only if value is > 1
    $("input[name=" + fieldName + "]").val(currentVal - 1);
    $(".add").val("+").removeAttr("style");
  } else {
    // Otherwise put a 0 there
    $("input[name=" + fieldName + "]").val(1);
    $(".sub").val("-").css("color", "#aaa");
    $(".sub").val("-").css("cursor", "not-allowed");
  }
});

/* Qty increase & decrease */
$(document).ready(function () {
  $(".minus").click(function () {
    var $input = $(this).parent().find("input");
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
  });
  $(".plus").click(function () {
    var $input = $(this).parent().find("input");
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
  });
});

// live search
$(document).ready(function () {
  $("#searchText").keyup(function () {
    var value = $(this).val().toLowerCase();
    $(".recipe-card #pro-box").filter(function () {
      $(this).toggle(
        $(this).find("#itemname").text().toLowerCase().indexOf(value) > -1
      );
    });

    $(".custom-product-card").each(function (index) {
      if (
        $(this).find(".custom-product-column").length ==
        $(this).find(".custom-product-column:hidden").length
      ) {
        $("#" + $(this).prev().attr("id")).hide(); // to hide category-name-div
        $("#" + $(this).prev().attr("id")).prev("hr").hide(); // to hide hr exist before category-name-div
      } else {
        $("#" + $(this).prev().attr("id")).show(); // to show category-name-div
        $("#" + $(this).prev().attr("id")).prev("hr").show(); // to hide hr exist before category-name-div
      }
    });
    $(".custom-categories-main-sec")
      .find(".custom-cat-name-sec:not(:hidden):first")
      .prev("hr")
      .hide();
  });
});

// category-scroll Theme-1
$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (scroll >= 300) {
    $(".responsive-padding").addClass("product-main-sec");
  } else {
    $(".responsive-padding").removeClass("product-main-sec");
  }
});

// category-scroll Theme-2
$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (scroll >= 700) {
    $(".padding-top").addClass("product-padding");
  } else {
    $(".padding-top").removeClass("product-padding");
  }
});

// category-scroll theme-3
$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (scroll >= 540) {
    $(".product2-sec").addClass("product-main-sec2");
  } else {
    $(".product2-sec").removeClass("product-main-sec2");
  }
});

// category-scroll Theme-4
$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  if (scroll >= 400) {
    $(".responsive-padding-top").addClass("product-padding");
  } else {
    $(".responsive-padding-top").removeClass("product-padding");
  }
});

// sticky-menu theme-3
$(".nav-link").on("click", function () {
  // Select all list items
  var listItems = $(".nav-link");
  // Remove 'active' tag for all nav-link
  for (let i = 0; i < listItems.length; i++) {
    listItems[i].classList.remove("active");
  }
  // Add 'active' tag for currently selected item
  this.classList.add("active");
});

// increment and decrement btn
$(".change-qty").on("click", function () {
  if ($(this).attr("data-type") == "plus") {
    $(this).prev().val(parseInt($(this).prev().val()) + 1);
  } else {
    if ($(this).next().val() > 1)
      $(this).next().val(parseInt($(this).next().val()) - 1);
  }
});
// Delivery & pick up btn
$(document).ready(function () {
  $(".form-switch").on("change", function () {
    $(".form").removeClass("active");
    var formToShow = ".form-" + $(this).data("id");
    $(formToShow).addClass("active");
  });
});

// Apply Coupon
if (document.getElementById("btn")) {
  const btn = document.getElementById("btn");

  btn.addEventListener("click", () => {
    const form = document.getElementById("form");

    if (form.style.display === "none") {
      form.style.display = "block";
    } else {
      form.style.display = "none";
    }
  });
}

function deletedata(nexturl) {
  "use strict";
  manegedata(nexturl);
}
function manegedata(nexturl) {
  "use strict";
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-success mx-1",
      cancelButton: "btn btn-danger mx-1"
    },
    buttonsStyling: false
  });
  swalWithBootstrapButtons
    .fire({
      title: are_you_sure,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      reverseButtons: true
    })
    .then(result => {
      if (result.isConfirmed) {
        $("#preloader").show();
        location.href = nexturl;
      } else {
        result.dismiss === Swal.DismissReason.cancel;
      }
    });
}
$(".mobile-number").on("keyup", function () {
  "use strict";
  var val = $(this).val();
  if (isNaN(val)) {
    val = val.replace(/[^0-9\.+.-]/g, "");
    if (val.split(".").length > 2) {
      val = val.replace(/\.+$/, "");
    }
  }
  $(this).val(val);
});

//=========== store review sec ===========//
$(".store-review").owlCarousel({
  loop: false,
  margin: 10,
  nav: true,
  dots: false,
  navText: [
    "<i class='fa-solid fa-angles-left'></i>",
    "<i class='fa-solid fa-angles-right'></i>"
  ],
  responsive: {
    0: {
      items: 1,
      nav: false
    },
    600: {
      items: 2,
      nav: false
    },
    1000: {
      items: 4
    }
  }
});

//========= product view popup multi img =========//
$(".multi-img").owlCarousel({
  loop: true,
  margin: 10,
  nav: false,
  dots: false,
  responsive: {
    0: {
      items: 4
    },
    600: {
      items: 4
    },
    1000: {
      items: 4
    }
  }
});

function managefavorite(product_id, vendor_id, f_url) {
  "use Strict";
  if (is_logedin == 2) {
    var offcanvasElement = document.getElementById("loginpage");
    var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
    offcanvas.toggle();
  } else {
    $("#preload").show();
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: f_url,
      type: "post",
      dataType: "json",
      data: {
        product_id: product_id,
        vendor_id: vendor_id
      },
      success: function (response) {
        $("#preload").hide();
        if (response.status == 0) {
          toastr.error(response.message);
        } else {
          location.reload();
        }
      }
    });
  }
}


//======= theme-4 =======//

$(".blog-4").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  nav: false,
  dots: false,
  // autoplay:true,
  navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
  responsive: {
    0: {
      items: 1,
      margin: 0,
    },
    600: {
      items: 2,
      margin: 24,
    },
    1000: {
      items: 2,
      margin: 24,
    },
    1200: {
      items: 2,
      margin: 24,
    }
  }
});


// narbar scrolling js //

if (current_url == home_url) {
  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    //>=, not <=
    if (scroll >= 300) {
      //clearHeader, not clearheader - caps H
      $(".main-header").addClass("header-bg-white");
    } else {
      $(".main-header").removeClass("header-bg-white");
    }
  });
}
//================================== theme-6 ==================================//



$(".home-banner2").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  nav: false,
  dots: false,  
  navText: ["<i class='fa-solid fa-angles-left'></i>", "<i class='fa-solid fa-angles-right'></i>"],
  responsive: {
    0: {
      items: 1,
      margin: 16,
    }
  }
});

//=========== store review sec ===========//
$(".store-review-6").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  nav: false,
  dots: false,
  navText: ["<i class='fa-solid fa-angles-left'></i>", "<i class='fa-solid fa-angles-right'></i>"],
  responsive: {
    0: {
      items: 1,
      margin: 16,
    },
    600: {
      items: 2,
      margin: 24,
    },
    1000: {
      items: 2,
      margin: 24,
    }
  }
});

//=========== store blog sec ===========//

$(".blog-6").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  nav: false,
  dots: false,
  margin: 0,
  autoplay: true,
  navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 3
    },
    1200: {
      items: 4
    }
  }
});



// Get titles from the DOM
$(".nav-6").slick({
  slidesToShow: 2,
  slidesToScroll: 1,
  vertical: true,
  verticalSwiping: true,
  centerMode: false,
  autoplay: true,
  infinite: false,
  autoplaySpeed: 1500,
  arrows: false,
  dots: false,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        dots: false,
      }
    },
    {
      breakpoint: 600,
      settings: {
        dots: false,
      }
    },
    {
      breakpoint: 480,
      settings: {
        dots: false,
      }
    }
  ]
});



//================================== theme-7 ==================================//
$(".blog-7").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  nav: false,
  dots: false,
  margin: 15,
  autoplay: true,
  navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
  responsive: {
    0: {
      items: 1
    },
    600: {
      items: 2
    },
    1000: {
      items: 3
    },
    1200: {
      items: 4
    }
  }
});

$(".feature-slider-6").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  margin: 24,
  nav: false,
  dots: false,
  responsive: {
    0: {
      items: 2
    },
    600: {
      items: 3
    },
    1000: {
      items: 4
    }
  }
});


// category scroll //
function prev() {
  document.getElementById('myTab').scrollLeft -= 100;
}

function next() {
  document.getElementById('myTab').scrollLeft += 100;
}



//================================== theme-8 ==================================//

$(".pro-8").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  nav: true,
  dots: false,
  navText: ["<i class='fa-regular fa-angle-left'></i>", "<i class='fa-regular fa-angle-right'></i>"],
  responsive: {
    0: {
      items: 1,
    },
    375: {
      items: 2,
    },
    600: {
      items: 3,
    },
    1000: {
      items: 4,
    },
    1200: {
      items: 5,
    }
  }
});

$(".store-review-8").owlCarousel({
  loop: false,
  nav: false,
  dots: false,
  navText: [
    "<i class='fa-solid fa-angles-left'></i>",
    "<i class='fa-solid fa-angles-right'></i>"
  ],
  responsive: {
    0: {
      items: 1,
      nav: false,
      margin: 10,
    },
    600: {
      items: 2,
      nav: false,
      margin: 20,
    },
    1000: {
      items: 4,
      margin: 20,
    }
  }
});

$(".blogs-8").owlCarousel({
  rtl: rtl == "2" ? true : false,
  loop: false,
  nav: false,
  dots: false,
  autoplay: true,
  navText: ["<i class='fa-solid fa-angle-left'></i>", "<i class='fa-solid fa-angle-right'></i>"],
  responsive: {
    0: {
      items: 1,
      margin: 10,
    },
    576: {
      items: 2,
      margin: 15,
    },
    600: {
      items: 2,
      margin: 15,
    },
    1000: {
      items: 3,
      margin: 15,
    },
    1200: {
      items: 3,
      margin: 15,
    }
  }
});