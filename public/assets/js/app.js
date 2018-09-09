;
(function ($) {

  'use strict'

  var loginPage = function () {
    if ($('body.login').length) {
      var img = $('.login-left-col').attr('data-img-src');
      $('.login-left-col').css('background-image', 'url(' + img + ')');
    }
  }

  var mobileMenu = function () {
    if ($('.mobile-nav-toggle').length) {
      $('.mobile-nav-toggle').on('click', function (e) {
        $('#admin-top-bar').toggleClass('show-nav');
      });
    }
  }

  var dropDownMenu = function () {

    $(".admin-bar__nav .parent-menu > a").on('click', function (e) {

      $(this).parent('.parent-menu').toggleClass('active');
      var elemNext = $(this).next('.sub-menu');
      var elemRest = $(".admin-bar__nav .sub-menu:visible").not(elemNext);

      elemRest.slideUp();
      elemRest.parent('.parent-menu').removeClass('active');
      elemNext.slideToggle(200);

      e.stopPropagation();

    });

    $(document).click(function () {
      if ($('.admin-bar__nav .sub-menu').is(':visible')) {
        $('.admin-bar__nav .sub-menu', this).slideUp();
        $('.admin-bar__nav .parent-menu').removeClass('active');
      }
    });

  }

  var dropDownButton = function () {

    if ($('.btn-has-dropdown-menu').length) {

      $(document).on('click', '.btn-has-dropdown-menu .dropdown-toggle', function () {

        $(this).next('.dropdown-menu').toggleClass('show');
        $(this).toggleClass('dropdown-expanded');

      });

    }

    // Popover menu
    if ($('.popover-menu-btn').length) {

      $(document).on('click', '.popover-menu-btn', function (e) {

        $(this).toggleClass('active');
        $(this).next('.popover-menu-content').toggleClass('show');
        e.stopPropagation();
        e.preventDefault();

      });

      $(document).click(function () {
        $('.popover-menu-content').removeClass('show');
        $('.popover-menu-btn').removeClass('active');
      });

    }

  }

  var formInputs = function () {
    // Password
    if ($('.has-show-hide-password').length) {

      /*
      $('.has-show-hide-password .show-hide').

      var x = document.getElementById("myInput");
      if (x.type === "password") {
          x.type = "text";
      } else {
          x.type = "password";
      }
      */

      $(document).on('click', '.has-show-hide-password .show-hide', function () {

        var inputPass = $(this).parent().find('input');
        console.log(inputPass);
        var btnText = $(this).find('span');

        if (inputPass.attr('type') == 'password') {
          inputPass.attr('type', 'text');
          btnText.text('Hide');
        } else {
          inputPass.attr('type', 'password');
          btnText.text('Show');
        }

      });


    }
    // Dropdown
    if ($('.dropdown-select2').length) {
      $('.dropdown-select2').select2().on("change", function (e) {
        $(this).valid(); //jquery validation script validate on change
      }).on("select2:open", function () { //correct validation classes (has=*)
        if ($(this).parents("[class*='has-']").length) { //copies the classes
          var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);

          for (var i = 0; i < classNames.length; ++i) {
            if (classNames[i].match("has-")) {
              $("body > .select2-container").addClass(classNames[i]);
            }
          }
        } else { //removes any existing classes
          $("body > .select2-container").removeClass(function (index, css) {
            return (css.match(/(^|\s)has-\S+/g) || []).join(' ');
          });
        }
      });
    }
    // Input tags
    if ($('.select2-input-tags').length) {
      $('.select2-input-tags').select2({
        tags: true
      }).on("change", function (e) {
        $(this).valid(); //jquery validation script validate on change
      }).on("select2:open", function () { //correct validation classes (has=*)
        if ($(this).parents("[class*='has-']").length) { //copies the classes
          var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);

          for (var i = 0; i < classNames.length; ++i) {
            if (classNames[i].match("has-")) {
              $("body > .select2-container").addClass(classNames[i]);
            }
          }
        } else { //removes any existing classes
          $("body > .select2-container").removeClass(function (index, css) {
            return (css.match(/(^|\s)has-\S+/g) || []).join(' ');
          });
        }
      });;
    }
    if ($('#filter-by-tags').length) {
      $('#filter-by-tags').select2({
        tags: true
      }).on("change", function (e) {
        $(this).valid(); //jquery validation script validate on change
      }).on("select2:open", function () { //correct validation classes (has=*)
        if ($(this).parents("[class*='has-']").length) { //copies the classes
          var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);

          for (var i = 0; i < classNames.length; ++i) {
            if (classNames[i].match("has-")) {
              $("body > .select2-container").addClass(classNames[i]);
            }
          }
        } else { //removes any existing classes
          $("body > .select2-container").removeClass(function (index, css) {
            return (css.match(/(^|\s)has-\S+/g) || []).join(' ');
          });
        }
      });;
    }
    // Clearable input
    if ($('.add-clear-input').length) {
      $('.add-clear-input').addClear({
        closeSymbol: '<i class="fa fa-times-circle"></i>'
      });
    }
    // Checkbox and Radio
    if ($('[nice-checkbox-radio]').length) {
      $('[nice-checkbox-radio]').checkradios();
    }
    // Datepicker
    if ($('.form-group__validity-period #pick-date-period-start').length) {
      $('.form-group__validity-period #pick-date-period-start').datetimepicker({
        format: 'L',
        heading: '<h4>Campaign Start Date</h4>'
      });
    }
    if ($('.form-group__validity-period #pick-date-period-end').length) {
      $('.form-group__validity-period #pick-date-period-end').datetimepicker({
        format: 'L',
        heading: '<h4>Campaign End Date</h4>'
      });
    }

    //start date
    $(function () {
      $('.form-group__validity-period #pick-date-period-start').datetimepicker();
      var date = $('.form-group__validity-period #pick-date-period-start').datetimepicker('viewDate');
      console.log(date);
      $('.form-group__validity-period #pick-date-period-start').on("change.datetimepicker", function (e) {
        date = $('.form-group__validity-period #pick-date-period-start').datetimepicker('viewDate');
        let dateFormated = moment(date).format('YYYY-MM-DD');
        console.log(dateFormated);


        let end = $('#end_date').val();
        let endDate = Date.parse(new Date(end));
        let parseEndDate = Date.parse(new Date(endDate));
        console.log(parseEndDate);
        if (!isNaN(parseEndDate)) {
          // toastr.error('You cant set end date before start date');
          $('#end_date').val('')
        }

        var myDate = Date.parse(new Date(dateFormated));
        var dateTimeNow = Date.parse(moment(Date.now()).format('YYYY-MM-DD'));
        if (myDate < dateTimeNow) {
          toastr.error('Start date cannot be less than current date');
          $('#start_date').val(moment(dateTimeNow).format('MM/DD/YYYY'))
        }
      });
    });

    //end date
    $(function () {
      $('.form-group__validity-period #pick-date-period-end').datetimepicker();
      var date = $('.form-group__validity-period #pick-date-period-end').datetimepicker('viewDate');
      $('.form-group__validity-period #pick-date-period-end').on("change.datetimepicker", function (e) {
        date = $('.form-group__validity-period #pick-date-period-end').datetimepicker('viewDate');
        let dateFormated = moment(date).format('YYYY-MM-DD');
        var myDate = Date.parse(new Date(dateFormated));
        let start = $('#start_date').val();
        let startDate = Date.parse(new Date(start));
        let parseStartDate = Date.parse(new Date(startDate));

        if (isNaN(parseStartDate)) {
          toastr.error('You cant select end date before start date');
          $('#end_date').val('')
        }
        if (myDate < parseStartDate) {
          toastr.error('End date should be greater than start date');
          $('#end_date').val(moment(parseStartDate).format('MM/DD/YYYY'))
        }
      });
    });

    // Reset form fields

    if ($('.voucher-filter-form .btn.clear-all-filter').length) {

      $('.btn.clear-all-filter').on('click', function (e) {
        $('select#filter-by-tags').val(null).trigger('change');
        $('#filter-by-keyword, #filter-location, #filter-area').val('');
        $('.voucher-range').val($('.voucher-range').attr('data-default-val')).trigger('change');
        $('input[name="month"]').prop('checked', false).change();
        $('input[name="month"]').parent().removeClass('checked').addClass('unchecked');
        e.stopPropagation();
        e.preventDefault();
      });

    }

    // Cancel button on voucher filter form
    if ($('.voucher-filter-form .btn.cancel-filter').length) {
      function cancelFiter() {
        $('.voucher-filter-form .btn.cancel-filter').on('click', function (e) {

          $('.voucher-filter-form .dropdown-toggle').removeClass('dropdown-expanded');
          $('.voucher-filter-form .dropdown-toggle').next().removeClass('show');

          e.stopPropagation();
          e.preventDefault();
        });
      }
      cancelFiter();
    }

    // Range slider
    if ($('[data-rangeslider]').length) {

      function toIDR(number) {
        var idr = '';
        var newNumber = number.toString().split('').reverse().join('');
        for (var i = 0; i < newNumber.length; i++)
          if (i % 3 == 0) idr += newNumber.substr(i, 3) + '.';
        return 'IDR ' + idr.split('', idr.length - 1).reverse().join('');
      }

      var textContent = ('textContent' in document) ? 'textContent' : 'innerText';

      // Example functionality to demonstrate a value feedback
      function rangeValueOutput(element) {
        var value = element.value;
        var output = element.parentNode.getElementsByTagName('output')[0] || element.parentNode.parentNode.getElementsByTagName('output')[0];
        output[textContent] = toIDR(value);
      }

      var $element = $('[data-rangeslider]');

      function initRangeSlider() {
        $element.rangeslider({
          polyfill: false,
          onInit: function () {
            rangeValueOutput(this.$element[0]);
          },
          onSlide: function (position, value) {
            rangeValueOutput(this.$element[0]);
          },
          onSlideEnd: function (position, value) {
            rangeValueOutput(this.$element[0]);
          }
        });
      }
      initRangeSlider();

    }

    var uploadFile = function () {
      $("#uploadInput").change(function (e) {
        if (e.target.files.length !== 0) {
          var txtFile = e.target.files[0].name;
          $('#uploadText').val(txtFile);
          $('#uploadBox').show();
        }
      });

      $('.clearFile').click(function (event) {
        event.preventDefault();
        $('#uploadInput').val(null);
        $('#uploadText').val('');
        $('#uploadBox').fadeOut();
      });
    }
    uploadFile();
  }


  var sideMenuButton = function () {

    $(document).on('click', '.admin-bar__main-menu .btn', function () {

      $('body').toggleClass('side-menu-expanded');

      var sideMenu = $('#side-menu').width();
      var mainContent = $('#main-content').width();

      if (sideMenu < 62) {
        TweenMax.to(['#side-menu', '#side-menu .nav-item.first'], 0.2, {
          css: {
            width: 250
          }
        });
        var newContentW = mainContent - $('#side-menu').width();
        // var newContentW = $(window).width() - $('#side-menu').width();
        TweenMax.to(['.admin-bar', '#main-content'], 0.2, {
          css: {
            marginLeft: 250,
            width: newContentW - 30
          },
          onComplete: function () {
            // Custom event
            $(window).trigger('SideMenuOpen');
          }
        });
        TweenMax.to('.nav-link__text', 0.4, {
          css: {
            opacity: 1
          }
        });
        $('#admin-top-bar').removeClass('show-nav');
      } else {
        var normalContentW = $(window).width() - 61;
        TweenMax.to(['#side-menu', '#side-menu .nav-item.first'], 0.1, {
          css: {
            width: 61
          }
        });
        TweenMax.to(['.admin-bar', '#main-content'], 0.1, {
          css: {
            marginLeft: 61,
            width: normalContentW
          },
          onComplete: function () {
            // Custom event
            $(window).trigger('SideMenuClose');
          }
        });
        TweenMax.to('.nav-link__text', 0.2, {
          css: {
            opacity: 0
          }
        });
      }


    });

    // Reload masonry while side menu expands
    $(window).on("SideMenuOpen", function () {
      voucherMasonry.init();
    });

    // Reload masonry while side menu closes
    $(window).on("SideMenuClose", function () {
      voucherMasonry.init();
    });

  }

  var voucherMasonry = {

    init: function () {

      if ($('.voucher-list.grid').length) {

        if ($.session != 'undefined') {
          var layout = $.session.get('layout-view');
        } else {
          var layout = '';
        }

        if ($('.voucher-list').hasClass('grid')) {
          var $container = $('.voucher-list.grid');
          $container.imagesLoaded(function () {
            $container.masonry({
              itemSelector: '.voucher-item',
              isAnimated: true,
              isFitWidth: true,
              animationOptions: {
                duration: 500,
                easing: 'linear',
              }
            });

            if (layout == 'list') {
              $container.masonry('destroy');
            }

          });
        }

      }

    },
    destroy: function () {
      $('.voucher-list').masonry('destroy');
    }

  }

  var layoutSwitcher = function () {

    if ($('.switch-loop-layout-list').length) {
      $(document).on('click', '.switch-loop-layout-list', function () {
        var elemID = $(this).attr('data-id');
        $(elemID).removeClass('grid');
        $(elemID).addClass('list');
        $(this).addClass('active');
        $(this).next().removeClass('active');

        // Destroy masonry layout
        voucherMasonry.destroy();

        // Store session to detect list layout
        $.session.set('layout-view', 'list');

      });

    }

    if ($('.switch-loop-layout-grid').length) {
      $(document).on('click', '.switch-loop-layout-grid', function () {
        var elemID = $(this).attr('data-id');
        $(elemID).removeClass('list');
        $(elemID).addClass('grid');
        $(this).addClass('active');
        $(this).prev().removeClass('active');

        voucherMasonry.init();

        // Custom event
        $(window).trigger('GridOn');

        // Store session to detect grid layout
        $.session.set('layout-view', 'grid');

      });

      // Reload masonry while grid enabled
      $(window).on("GridOn", function () {
        voucherMasonry.init();
      });

    }

    if ($.session != 'undefined') {
      var layout = $.session.get('layout-view');
    } else {
      var layout = '';
    }

    if (layout == 'grid') {
      var container = $('.switch-loop-layout-grid');
      $(container.attr('data-id')).removeClass('list').addClass('grid');
      container.prev().removeClass('active');
      container.addClass('active');
    }

    if (layout == 'list') {

      var container = $('.switch-loop-layout-list');
      $(container.attr('data-id')).removeClass('grid').addClass('list');
      container.next().removeClass('active');
      container.addClass('active');

    }


  }

  var submitNewPasswordButton = function () {

    if ($('body').hasClass('change-password')) {

      var btn = $('button[type="submit"]');
      var password = $('input#new-password');
      var newPassword = $('input#retype-new-password');

      btn.on('click', function (e) {

        if ((password.val() != '') && (password.val() == newPassword.val())) {
          $('body').addClass('success-change-password');

          if ($('.post-reset-password-form-submission-modal').length) {
            $('.post-reset-password-form-submission-modal').modal({
              show: true
            });
          }

        }

        e.preventDefault();
        e.stopPropagation();
      });

    }

  }

  var sortEntryTable = function () {

    var table = $('[data-sort=table]');
    if (table.length) {
      // call the tablesorter plugin
      table.tablesorter({
        headers: {
          0: {
            sorter: false
          }
        }
      });
      table.bind('sortStart', function () {
        // $('[data-sort=table] .spacer').remove();
        $('[data-sort=table] .spacer:hidden').remove();
      }).bind('sortEnd', function () {

        $('[data-sort=table] tbody tr').each(function () {
          $(this).clone().insertAfter($(this)).addClass('spacer').html('<td></td>');
        });
        $('[data-sort=table] .spacer:hidden').remove();

      });
    }

  }

  var userMenuModal = function () {

    if ($('#userMenuModal').length) {
      var cardContainer = $('#userMenuModal').width();
      var cardW = $('.modal-user-menu__content').width();
      //total cards
      var cardN = $('.modal-user-menu__content').length;
      // var cW = (cardW*4)+120;

      if (cardN == 2) {
        var cW = (cardW * cardN) + 60;
      } else {
        var cW = (cardW * cardN) + 120;
      }
      $('.user-menu-cards').width(cW)

    }

  }

  var selectVoucher = function () {
    $('body').on('click', '.voucher-item-v2 .voucher-item-v2__title', function (e) {
      var parentDiv = $(this).closest('.voucher-item-v2');
      console.log(parentDiv);

      if (parentDiv.hasClass('selected')) {
        parentDiv.removeClass('selected');
      } else {
        parentDiv.addClass('selected');
      }
    });
  }

  var slideButton = function () {
    $(".two").hover(function () {
      $('.one').css("color", "#C6CC07");
    }, function () {
      $('.one').css("color", "#fff");
    });

    $(".two-b").hover(function () {
      $('.one-b').css("color", "#C6CC07");
    }, function () {
      $('.one-b').css("color", "#fff");
    });
  }

  var toolTip = function () {
    $('[data-toggle="tooltip"]').tooltip()
  }

  var RedeemPINModal = function () {
    $('#requestPIN').click(function (event) {
      event.preventDefault();
      $('#requestPINModal').modal('show');
    });
  }

  var textPreview = function () {
    $('.prvInput').keyup(function () {
      var x = $(this).val();
      $('.prvResult').html(x);
    });
  }

  // Dom Ready
  $(function () {
    loginPage();
    mobileMenu();
    dropDownMenu();
    dropDownButton();
    formInputs();
    sideMenuButton();
    voucherMasonry.init();
    layoutSwitcher();
    submitNewPasswordButton();
    sortEntryTable();
    userMenuModal();
    selectVoucher();
    slideButton();
    toolTip();
    RedeemPINModal();
    textPreview();
  });

})(jQuery);