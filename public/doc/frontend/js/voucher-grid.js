$(document).ready(function(){
    
    $.getJSON('js/voucher-data.json', function(data){
        arrVoucherData = data;
    }).done(function(){
        setVoucherData(arrVoucherData);
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

function myKeyword(id) {
    var x = document.getElementById("filter-by-keyword");
    // console.log(x.value);
    if(id == 1){
        var arrfiltered = searchData(x.value.toLowerCase());
    }else{
        var arrfiltered = searchData('');
    }           
    setVoucherData(arrfiltered);
}

function Paginator(items, page, per_page) {

    var page = page || 1,
    per_page = per_page || 3,
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
        $('#loop-layout').append(voucherTemplate);
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
                    merchantlist += '<li>'+data[i].merchants[j]+'</li>';
                }
            }
            merchantlist += '<li><a href="#">More..</a></li>';
            $('#grid_'+data[i].id).find('.option-sub-menu').html(merchantlist);
        }
    }
}