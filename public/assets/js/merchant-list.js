$(document).ready(function(){
    $('#addMerchant').click(function(event){
        event.preventDefault();
        setMerchantList();
    });

});

function setMerchantList(){
    if($('#search-merchant').val() !== "")
        var idxNum = countList();
        var merchantList = $('#merchantTemplate').html();
        $('#accordion').append(merchantList);
        // renaming id name
        var listHeadingName = $('#search-merchant option:selected').text();
        $('#accordion li.merchantList').find('#cardMerchant').prop('id', 'cardMerchant'+idxNum);
        $('#cardMerchant'+idxNum+' h5').find('.headTitle').html(listHeadingName);
        $('#accordion li.merchantList').find('#headingMerchant').prop('id','headingMerchant'+idxNum);
        $('#accordion li.merchantList').find('#collapseMerchantBtn').prop('id','collapseMerchantBtn'+idxNum);
        $('#accordion li.merchantList').find('#collapseMerchantBtn'+idxNum).attr('data-target','#collapseMerchant'+idxNum);
        $('#accordion li.merchantList').find('#collapseMerchantBtn'+idxNum).attr('aria-controls','#collapseMerchant'+idxNum);
        $('#accordion li.merchantList').find('#collapseMerchant').prop('id','collapseMerchant'+idxNum);
        $('#accordion li.merchantList').find('#collapseMerchant'+idxNum).attr('aria-labelledby','headingMerchant'+idxNum);
        // all outlet radio
        $('#collapseMerchant'+idxNum).find('input[name="voucher-outlet"]').prop('name', 'voucher-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('input[id="all-outlet"]').prop('id', 'all-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('input[value="all-outlet"]').prop('value', 'all-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('label[for="all-outlet"]').prop('for', 'all-outlet'+idxNum);
        // selected outlet radio
        $('#collapseMerchant'+idxNum).find('input[id="selected-outlet"]').prop('id', 'selected-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('input[value="selected-outlet"]').prop('value', 'selected-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('label[for="selected-outlet"]').prop('for', 'selected-outlet'+idxNum);
        // add outlet option
        $('#collapseMerchant'+idxNum).find('select[id="add-outlet"]').prop('id', 'add-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('select[name="add-outlet"]').prop('name', 'add-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('label[for="add-outlet"]').prop('for', 'add-outlet'+idxNum);
        //$('#collapseMerchant'+idxNum).find('select[data-select2-id="add-outlet"]').attr('data-select2-id', 'add-outlet'+idxNum);
        $('#add-outlet'+idxNum).select2();
        // exclude outlet option
        $('#collapseMerchant'+idxNum).find('select[id="exclude-outlet"]').prop('id', 'exclude-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('select[name="exclude-outlet"]').prop('name', 'exclude-outlet'+idxNum);
        $('#collapseMerchant'+idxNum).find('label[for="exclude-outlet"]').prop('for', 'exclude-outlet'+idxNum);
        //$('#collapseMerchant'+idxNum).find('select[data-select2-id="exclude-outlet"]').attr('data-select2-id', 'exclude-outlet'+idxNum);
        $('#exclude-outlet'+idxNum).select2();
}

function countList(){
    var num = $('#accordion li.merchantList').length;
    return num;
}

function checkOutlet(e){
    var checkstatus = $(e).prop('value');
    var idname = $(e).prop('id');
    var txtlen = idname.length;
    var idx = idname.substr(txtlen - 1);
    var checkedname = idname.substr(0, txtlen - 1);
    //console.log(checkedname);
    if(checkedname === 'all-outlet'){
        $('#add-outlet'+idx).prop('disabled', true);
        $('#exclude-outlet'+idx).prop('disabled', true);
    }else{
        $('#add-outlet'+idx).prop('disabled', false);
        $('#exclude-outlet'+idx).prop('disabled', false);
    }
    
}

function removeList(e){
    var idList = $(e).parent().parent().parent().parent().prop('id');
    $('#'+idList).parent().fadeOut();
    setTimeout(function(){ 
        $('#'+idList).parent().remove(); 
        resetIDList();
    }, 1000);
}

function resetIDList(){
    var num = $('#accordion li.merchantList').length;
    var listLen = countList();
    for(var i=0;i<listLen;i++){
        $('#accordion li.merchantList:eq('+i+')').find('div[id^="cardMerchant"]').prop('id', 'cardMerchant'+i);
        $('#accordion li.merchantList:eq('+i+')').find('div[id^="headingMerchant"]').prop('id','headingMerchant'+i);
        $('#accordion li.merchantList:eq('+i+')').find('button[id^="collapseMerchantBtn"]').prop('id','collapseMerchantBtn'+i);
        $('#accordion li.merchantList:eq('+i+')').find('button[id^="collapseMerchantBtn"]').attr('data-target','#collapseMerchant'+i);
        $('#accordion li.merchantList:eq('+i+')').find('button[id^="collapseMerchantBtn"]').attr('aria-controls','#collapseMerchant'+i);
        $('#accordion li.merchantList:eq('+i+')').find('div[id^="collapseMerchant"]').prop('id','collapseMerchant'+i);
        $('#accordion li.merchantList:eq('+i+')').find('div[id^="collapseMerchant"]').attr('aria-labelledby','headingMerchant'+i);
        // all outlet radio
        $('#collapseMerchant'+i).find('input[name^="voucher-outlet"]').prop('name', 'voucher-outlet'+i);
        $('#collapseMerchant'+i).find('input[id^="all-outlet"]').prop('id', 'all-outlet'+i);
        $('#collapseMerchant'+i).find('input[value^="all-outlet"]').prop('value', 'all-outlet'+i);
        $('#collapseMerchant'+i).find('label[for^="all-outlet"]').prop('for', 'all-outlet'+i);
        // selected outlet radio
        $('#collapseMerchant'+i).find('input[id^="selected-outlet"]').prop('id', 'selected-outlet'+i);
        $('#collapseMerchant'+i).find('input[value^="selected-outlet"]').prop('value', 'selected-outlet'+i);
        $('#collapseMerchant'+i).find('label[for^="selected-outlet"]').prop('for', 'selected-outlet'+i);
        // add outlet option
        $('#collapseMerchant'+i).find('select[id^="add-outlet"]').prop('id', 'add-outlet'+i);
        $('#collapseMerchant'+i).find('select[name^="add-outlet"]').prop('name', 'add-outlet'+i);
        $('#collapseMerchant'+i).find('label[for^="add-outlet"]').prop('for', 'add-outlet'+i);
        //$('#collapseMerchant'+i).find('select[data-select2-id="add-outlet"]').attr('data-select2-id', 'add-outlet'+i);
        //$('#add-outlet'+i).select2();
        // exclude outlet option
        $('#collapseMerchant'+i).find('select[id^="exclude-outlet"]').prop('id', 'exclude-outlet'+i);
        $('#collapseMerchant'+i).find('select[name^="exclude-outlet"]').prop('name', 'exclude-outlet'+i);
        $('#collapseMerchant'+i).find('label[for^="exclude-outlet"]').prop('for', 'exclude-outlet'+i);
        //$('#collapseMerchant'+i).find('select[data-select2-id="exclude-outlet"]').attr('data-select2-id', 'exclude-outlet'+i);
        //$('#exclude-outlet'+i).select2();
    }
}