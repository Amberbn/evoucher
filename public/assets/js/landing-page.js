// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});

// Highlight the top nav as scrolling occurs
$('body').scrollspy({
    target: '.navbar-fixed-top'
})

// Closes the Responsive Menu on Menu Item Click
$('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
});

$('div.modal').on('show.bs.modal', function() {
	var modal = this;
	var hash = modal.id;
	window.location.hash = hash;
	window.onhashchange = function() {
		if (!location.hash){
			$(modal).modal('hide');
		}
	}
});

$('#m-Tab a').on('click', function (e) {
    e.preventDefault();
    var idTab = $(this).attr('href');
    idTab = idTab.substr(1);
    console.log(idTab);
     $(this).tab('show');
     $('.card-extra').hide();
     $('.nav-tab-btn').hide();
     $("div[id^='"+idTab+"-']").show();
});


var arrStatus = [
    { title: 'Store Code Salah', img: 'img-error', btn: 'Coba Lagi', message: ''},
    { title: 'Loading', img: 'img-error', btn: 'OK', message: 'Loading'},
    { title: 'Voucher Berhasil Ditukar', img: 'img-success', btn: 'Tutup', message: 'Instruksi yang harus dilakukan penukar: <br>1. Minta kartu identitas konsumen <br>2. Konsumen hanya bisa menggunakan voucher untuk 2 tiket regular nonton Star Wars The Last Jedi <br>3. Pastikan menutup layar ini sebelum memberikan kembali HP konsumen'}
];

