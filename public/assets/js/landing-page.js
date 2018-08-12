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
    { title: 'Voucher Tidak Valid', img: 'img-error', btn: 'OK', message: 'Mohon hubungi 1500171 untuk informasi lebih lanjut'},
    { title: 'Voucher Berhasil Ditukar', img: 'img-success', btn: 'Tutup', message: 'Instruksi yang harus dilakukan penukar: <br>1. Minta kartu identitas konsumen <br>2. Konsumen hanya bisa menggunakan voucher untuk 2 tiket regular nonton Star Wars The Last Jedi <br>3. Pastikan menutup layar ini sebelum memberikan kembali HP konsumen'}
];

$('#storeCodeForm').submit(function(event){
    var codeVal = $('input[name="store-code"]').val();
    if(codeVal !== ''){
        if(codeVal == 'AAPL690WK54M50'){
            console.log('success');
            setStatusModal(arrStatus[2], true);
        }else{
            console.log('error 2');
            setStatusModal(arrStatus[1], true);
        }
    }else{
        console.log('error 1');
        setStatusModal(arrStatus[0], false);
    }
    event.preventDefault();
});

function setStatusModal(data, type){
    console.log(data);
    $('#statusModal').find('img').prop('src','assets/img/'+data.img+'.svg');
    $('#statusModal').find('h4').html(data.title);
    $('#statusModal').find('button').html(data.btn);
    var newmsg = data.message;
    if(type == true){
        $('#storeCodeModal').modal('hide');
    }
    $('#statusModal').find('p#status-text').html(data.message);
    $('#statusModal').modal('show');
}