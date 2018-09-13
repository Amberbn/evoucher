$(document).ready(function(){
    $.getJSON('js/voucher-data.json', function(data){
        arrVoucherData = data;
    }).done(function(){
        myKeyword(0);
    });

    
});

var arrVoucherData = [];
function searchData(keyword){
    var tempdata = arrVoucherData.filter(function (item) {
    return Object.values(item).map(function (value) {
        return String(value);
        }).find(function (value) {
            return value.toLowerCase().includes(keyword);
        });
    });
    return tempdata;
}

var arrfiltered = [];
var arrPaged = [];
function myKeyword(id) {
    var x = document.getElementById("filter-by-keyword");
    // console.log(x.value);
    if(id == 1){
        arrfiltered = searchData(x.value.toLowerCase());
    }else{
        arrfiltered = searchData('');
    }
    arrPaged = Paginator(arrfiltered);           
    setVoucherData(arrPaged.data);
    generatePage(arrPaged);
}

function showPage(pg){
    arrPaged = Paginator(arrfiltered, pg);           
    setVoucherData(arrPaged.data);
    generatePage(arrPaged);
}

function generatePage(data){
    $('.pagination').html('');
    var totalpage = data.total_pages;
    var activepage = data.page;
    var prevpage = data.pre_page;
    var nextpage = data.next_page;
    var buttonpage = '<li class="page-item '+(prevpage == null ? 'disabled' : '')+'"><a class="page-link" href="#" onclick="showPage('+prevpage+');return false" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
    for(var i=0;i<totalpage;i++){
        if((i+1) == activepage){
            buttonpage += '<li class="page-item active"><a class="page-link" href="#">'+(i+1)+'<span class="sr-only">(current)</span></a></li>';
        }else{
            buttonpage += '<li class="page-item"><a class="page-link" href="#" onclick="showPage('+(i+1)+');return false">'+(i+1)+'</a></li>';
        }  
    }
    buttonpage += '<li class="page-item '+(nextpage == null ? 'disabled' : '')+'"><a class="page-link" href="#" onclick="showPage('+nextpage+');return false" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
    $('.pagination').html(buttonpage);
}

function Paginator(items, page, per_page) {
    var totalitem = 5; //total objects in array
    var page = page || 1,
    per_page = per_page || totalitem,
    offset = (page - 1) * per_page,

    paginatedItems = items.slice(offset).slice(0, per_page),
    total_pages = Math.ceil(items.length / per_page);
    return {
        page: page,
        per_page: per_page,
        pre_page: page - 1 ? page - 1 : null,
        next_page: (total_pages > page) ? page + 1 : null,
        total: items.length,
        total_pages: total_pages,
        data: paginatedItems
    };
}

function setVoucherData(data){
    $('#loop-layout').html('');
    for(var i=0;i<data.length;i++){
        var voucherTemplate = $('#voucher-grid-template').html();
        $(voucherTemplate).hide().appendTo("#loop-layout").fadeIn(100);
        // $('#loop-layout').append(voucherTemplate);
        $('#loop-layout').find('#grid').prop('id', 'grid_'+data[i].id);
        $('#grid_'+data[i].id).find('.voucher-item-v2__title').html(data[i].name);
        $('#grid_'+data[i].id).find('.voucher-item-v2__point span').html(data[i].amount);
        $('#grid_'+data[i].id).find('.remaining-val').html(data[i].remaining);
        $('#grid_'+data[i].id).find('.redeemed-val').html(data[i].redeemed);
        $('#grid_'+data[i].id).find('.tags-val').html(data[i].tags);
        $('#grid_'+data[i].id).find('.desc-text').html(data[i].desc);
        $('#grid_'+data[i].id).find('.imgpath').prop('src', data[i].img_path);
        $('#grid_'+data[i].id).find('.imgpath').prop('alt', data[i].alt);
        if(data[i].merchants.length > 0){
            $('#grid_'+data[i].id).find('.option-sub-menu').html('');
            var merchantlist = '';
            var merchantlen = data[i].merchants.length;
            for(var j=0;j<data[i].merchants.length;j++){
                if(j==0){
                    $('#grid_'+data[i].id).find('.option-value').html(data[i].merchants[j]);
                    if(data[i].merchants.length > 1){
                       $('#grid_'+data[i].id).find('.text-others').html('and '+(merchantlen - 1)+' others');
                    }else{  
                        $('#grid_'+data[i].id).find('.voucher-item-v2__option li').removeClass('has-children');
                    }
                }else{
                    if(j > 3){
                        if(j == (merchantlen - 1)){
                            merchantlist += '<li class="listMore">'+data[i].merchants[j]+'</li><li><a class="moreBtn" href="#">More..</a></li>';
                        }else{
                            merchantlist += '<li class="listMore">'+data[i].merchants[j]+'</li>';
                        }  
                    }else{
                        merchantlist += '<li>'+data[i].merchants[j]+'</li>';
                    }
                }
            }
            
            $('#grid_'+data[i].id).find('.option-sub-menu').html(merchantlist);
        }
    }
    initModule();
}

function initModule(){
    $('a.moreBtn').click(function(event){
        // event.preventDefault();
        $(this).closest('ul').find('.listMore').fadeToggle();
        console.log('more list..')
    });
}