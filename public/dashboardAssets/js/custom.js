(function ($) {
  "use strict";

  // ______________ PAGE LOADING
  $(window).on("load", function (e) {
    $("#global-loader").fadeOut("slow");
  });

  //Color-Theme
  $(document).on("click", "a[data-theme]", function () {
    $("head link#theme").attr("href", $(this).data("theme"));
    $(this).toggleClass("active").siblings().removeClass("active");
  });

  // ______________Full screen
  $(document).on("click", ".fullscreen-button", function toggleFullScreen() {
    $(".fullscreen-button").addClass("fullscreen-button");
    if (
      (document.fullScreenElement !== undefined &&
        document.fullScreenElement === null) ||
      (document.msFullscreenElement !== undefined &&
        document.msFullscreenElement === null) ||
      (document.mozFullScreen !== undefined && !document.mozFullScreen) ||
      (document.webkitIsFullScreen !== undefined &&
        !document.webkitIsFullScreen)
    ) {
      if (document.documentElement.requestFullScreen) {
        document.documentElement.requestFullScreen();
      } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
      } else if (document.documentElement.webkitRequestFullScreen) {
        document.documentElement.webkitRequestFullScreen(
          Element.ALLOW_KEYBOARD_INPUT
        );
      } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen();
      }
    } else {
      $("html").removeClass("fullscreen-button");
      if (document.cancelFullScreen) {
        document.cancelFullScreen();
      } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
      } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
      } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
      }
    }
  });

  // ______________ BACK TO TOP BUTTON
  $(window).on("scroll", function (e) {
    if ($(this).scrollTop() > 0) {
      $("#back-to-top").fadeIn("slow");
    } else {
      $("#back-to-top").fadeOut("slow");
    }
  });
  $(document).on("click", "#back-to-top", function (e) {
    $("html, body").animate(
      {
        scrollTop: 0,
      },
      0
    );
    return false;
  });

  // ______________ COVER IMAGE
  $(".cover-image").each(function () {
    var attr = $(this).attr("data-bs-image-src");
    if (typeof attr !== typeof undefined && attr !== false) {
      $(this).css("background", "url(" + attr + ") center center");
    }
  });

  // ______________Quantity Cart Increase & Descrease
  $(function () {
    $(".add").on("click", function () {
      var $qty = $(this).closest("div").find(".qty");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal)) {
        $qty.val(currentVal + 1);
      }
    });
    $(".minus").on("click", function () {
      var $qty = $(this).closest("div").find(".qty");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal) && currentVal > 0) {
        $qty.val(currentVal - 1);
      }
    });
  });

  // ______________Chart-circle
  if ($(".chart-circle").length) {
    $(".chart-circle").each(function () {
      let $this = $(this);
      $this.circleProgress({
        fill: {
          color: $this.attr("data-bs-color"),
        },
        size: $this.height(),
        startAngle: (-Math.PI / 4) * 2,
        emptyFill: "#edf0f5",
        lineCap: "round",
      });
    });
  }

  // __________MODAL
  // showing modal with effect
  $(".modal-effect").on("click", function (e) {
    e.preventDefault();
    var effect = $(this).attr("data-bs-effect");
    $("#modaldemo8").addClass(effect);
  });
  // hide modal with effect
  $("#modaldemo8").on("hidden.bs.modal", function (e) {
    $(this).removeClass(function (index, className) {
      return (className.match(/(^|\s)effect-\S+/g) || []).join(" ");
    });
  });

  // ______________ CARD
  const DIV_CARD = "div.card";

  // ___________TOOLTIP
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // __________POPOVER
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });
  // By default, Bootstrap doesn't auto close popover after appearing in the page
  $(document).on("click", function (e) {
    $('[data-toggle="popover"],[data-original-title]').each(function () {
      //the 'is' for buttons that trigger popups
      //the 'has' for icons within a button that triggers a popup
      if (
        !$(this).is(e.target) &&
        $(this).has(e.target).length === 0 &&
        $(".popover").has(e.target).length === 0
      ) {
        (
          ($(this).popover("hide").data("bs.popover") || {}).inState || {}
        ).click = false; // fix for BS 3.3.6
      }
    });
  });

  // ______________ Toast
  var toastElList = [].slice.call(document.querySelectorAll(".toast"));
  var toastList = toastElList.map(function (toastEl) {
    return new bootstrap.Toast(toastEl);
  });
  $("#liveToastBtn").click(function () {
    $(".toast").toast("show");
  });

  // ______________ FUNCTION FOR REMOVE CARD
  $(document).on("click", '[data-bs-toggle="card-remove"]', function (e) {
    let $card = $(this).closest(DIV_CARD);
    $card.remove();
    e.preventDefault();
    return false;
  });

  // ______________ FUNCTIONS FOR COLLAPSED CARD
  $(document).on("click", '[data-bs-toggle="card-collapse"]', function (e) {
    let $card = $(this).closest(DIV_CARD);
    $card.toggleClass("card-collapsed");
    e.preventDefault();
    return false;
  });

  // ______________ CARD FULL SCREEN
  $(document).on("click", '[data-bs-toggle="card-fullscreen"]', function (e) {
    let $card = $(this).closest(DIV_CARD);
    $card.toggleClass("card-fullscreen").removeClass("card-collapsed");
    e.preventDefault();
    return false;
  });

  //Input file-browser
  $(document).on("change", ".file-browserinput", function () {
    var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, "/").replace(/.*\//, "");
    input.trigger("fileselect", [numFiles, label]);
  }); // We can watch for our custom `fileselect` event like this

  //______File Upload
  $(".file-browserinput").on("fileselect", function (event, numFiles, label) {
    var input = $(this).parents(".input-group").find(":text"),
      log = numFiles > 1 ? numFiles + " files selected" : label;
    if (input.length) {
      input.val(log);
    } else {
      if (log) alert(log);
    }
  });

  // ______________Accordion Style
  $(document).on("click", '[data-bs-toggle="collapse"]', function () {
    $(this).toggleClass("active").siblings().removeClass("active");
  });
})(jQuery);

function replay() {
  let replayButtom = document.querySelectorAll(".reply a");
  // Creating Div
  let Div = document.createElement("div");
  Div.setAttribute("class", "comment mt-5 d-grid");
  // creating textarea
  let textArea = document.createElement("textarea");
  textArea.setAttribute("class", "form-control");
  textArea.setAttribute("rows", "5");
  textArea.innerText = "Your Comment";
  // creating Cancel buttons
  let cancelButton = document.createElement("button");
  cancelButton.setAttribute("class", "btn btn-danger");
  cancelButton.innerText = "Cancel";

  let buttonDiv = document.createElement("div");
  buttonDiv.setAttribute("class", "btn-list ms-auto mt-2");

  // Creating submit button
  let submitButton = document.createElement("button");
  submitButton.setAttribute("class", "btn btn-success ms-3");
  submitButton.innerText = "Submit";

  // appending text are to div
  Div.append(textArea);
  Div.append(buttonDiv);
  buttonDiv.append(cancelButton);
  buttonDiv.append(submitButton);

  replayButtom.forEach((element, index) => {
    element.addEventListener("click", () => {
      let replay = $(element).parent();
      replay.append(Div);

      cancelButton.addEventListener("click", () => {
        Div.remove();
      });
    });
  });
}
replay();

function like() {
  let like = document.querySelectorAll(".like");

  like.forEach((element, index) => {
    element.addEventListener("click", () => {
      let likeText = $(element).children();
      console.log(Number(likeText[0].childNodes[2]));
      // likeText.innerText++
    });
  });
}

like();

//Email Inbox
jQuery(document).ready(function ($) {
  $(".clickable-row").click(function () {
    window.location = $(this).data("href");
  });
});

/*off canvas Style*/
$(".off-canvas").on("click", function () {
  $("body").addClass("overflow-y-scroll");
  $("body").addClass("pe-0");
});

$(".layout-setting").on("click", function (e) {
  if (document) {
    $("body").toggleClass("dark-mode");
    $("body").removeClass("transparent-mode");
  } else {
    $("body").removeClass("dark-mode");
    $("body").removeClass("transparent-mode");
    $("body").addClass("light-mode");
  }
});

//######## SWITCHER STYLES ######## //

// Sidemenu layout Styles //

// ***** Icon with Text *****//
// $('body').addClass('icontext-menu');
// $('body').addClass('sidenav-toggled');
// if(document.querySelector('.icontext-menu').firstElementChild.classList.contains('login-img') !== true){
// icontext();
// }

// ***** Icon Overlay ***** //
// $('body').addClass('icon-overlay');
// $('body').addClass('sidenav-toggled');

// ***** closed-leftmenu ***** //
// $('body').addClass('closed-leftmenu');
// $('body').addClass('sidenav-toggled')

// ***** hover-submenu ***** //
// $('body').addClass('hover-submenu');
// $('body').addClass('sidenav-toggled')
// if(document.querySelector('.hover-submenu').firstElementChild.classList.contains('login-img') !== true){
// hovermenu();
// }

// ***** hover-submenu style 1 ***** //
// $('body').addClass('hover-submenu1');
// $('body').addClass('sidenav-toggled')
// if(document.querySelector('.hover-submenu1').firstElementChild.classList.contains('login-img') !== true){
// hovermenu();
// }

/******** *Header-Position Styles Start* ********/

// $('body').addClass('fixed-layout');
// $('body').addClass('scrollable-layout');

/******* Full Width Layout Start ********/

// $('body').addClass('layout-fullwidth');
// $('body').addClass('layout-boxed');

/******* Header Styles ********/

// $('body').addClass('header-light');
// $('body').addClass('color-header');
// $('body').addClass('dark-header');
// $('body').addClass('gradient-header');

/******* Menu Styles ********/

// $('body').addClass('light-menu');
// $('body').addClass('color-menu');
// $('body').addClass('dark-menu');
// $('body').addClass('gradient-menu');

/******* Theme Style ********/

// $('body').addClass('light-mode');
// $('body').addClass('dark-mode');
// $('body').addClass('transparent-mode');

/******* RTL VERSION *******/

// $('body').addClass('rtl');

$(document).ready(function () {
  let bodyRtl = $("body").hasClass("rtl");
  if (bodyRtl) {
    $("body").addClass("rtl");
    $("html[lang=en]").attr("dir", "rtl");
    $("body").removeClass("ltr");
    localStorage.setItem("rtl", "True");
    $("head link#style").attr("href", $(this));
    document
      .getElementById("style")
      .setAttribute(
        "href",
        "../assets/plugins/bootstrap/css/bootstrap.rtl.min.css"
      );
    var carousel = $(".owl-carousel");
    $.each(carousel, function (index, element) {
      // element == this
      var carouselData = $(element).data("owl.carousel");
      carouselData.settings.rtl = true; //don't know if both are necessary
      carouselData.options.rtl = true;
      $(element).trigger("refresh.owl.carousel");
    });
  }
});

/******* Navigation Style *******/

// ***** Horizontal Click Menu ***** //

$(document).ready(function () {
  /******* popoverIMG *******/

  $('[data-toggle="popoverIMG"]').popover({
    placement: "left",
    trigger: "hover",
    html: true,
  });

  $('[data-bs-toggle="popoverRoles"]').popover({
    placement: "left",
    trigger: "focus",
    html: true,
    // content:
    //   "<span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>تعديل البيانات</span><span class='tooltipRole'>تعديل </span><span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>تعديل المستخدمين</span><span class='tooltipRole'>إضافة مستخدم </span><span class='tooltipRole'>تعديل الوظائف</span><span class='tooltipRole'>تعديل الصلاحيات</span><span class='tooltipRole'>تعديل المستخدمين</span>",
  });

  /******* Calendar *******/
  $(
    "#from-hijri-picker, #to-hijri-picker, #from-hijri-unactive-picker ,#to-hijri-unactive-picker"
  ).hijriDatePicker({
    hijri: true,
    showSwitcher: false,
  });

  $("input").attr("autocomplete", "off");

  $(".dropify").dropify({
    messages: {
      default: "اسحب وأسقط او قم برفع الصورة",
      replace: "اسحب وأسقط او إضغط لتغيير الصورة",
      remove: "حذف",
      error: "اووه ، حدث خطأ ما",
    },
    error: {
      fileSize: "حجم الملف كبير (5M max).",
      minWidth: "The image width is too small ({{ value }}}px min).",
      maxWidth: "The image width is too big ({{ value }}}px max).",
      minHeight: "The image height is too small ({{ value }}}px min).",
      maxHeight: "The image height is too big ({{ value }}px max).",
      imageFormat: "The image format is not allowed ({{ value }} only).",
    },
  });
});
