$(document).ready(function () {
    $('#addMerchant').click(function (event) {
        event.preventDefault();
        let el = $(this);
        setMerchantList(el);
    });

});

function setMerchantList(el) {
    if ($('#search-merchant').val() !== "")
        var idxNum = countList();
    let selectedValue = $(el).parent().parent().parent().find('#search-merchant').val();
    let count = $("select[selected-parent='" + selectedValue + "']").length;
    if (count >= 2) {
        toastr.error('item already in list form');
        return;
    }
    var merchantList = $('#merchantTemplate').html();
    $('#accordion').append(merchantList);
    // renaming id name
    var listHeadingName = $('#search-merchant option:selected').text();
    $('#accordion li.merchantList').find('#cardMerchant').prop('id', 'cardMerchant' + idxNum);
    $('#cardMerchant' + idxNum + ' h5').find('.headTitle').html(listHeadingName);
    $('#accordion li.merchantList').find('#headingMerchant').prop('id', 'headingMerchant' + idxNum);
    $('#accordion li.merchantList').find('#collapseMerchantBtn').prop('id', 'collapseMerchantBtn' + idxNum);
    $('#accordion li.merchantList').find('#collapseMerchantBtn' + idxNum).attr('data-target', '#collapseMerchant' + idxNum);
    $('#accordion li.merchantList').find('#collapseMerchantBtn' + idxNum).attr('aria-controls', '#collapseMerchant' + idxNum);


    $('#accordion li.merchantList').find('#collapseMerchant').prop('id', 'collapseMerchant' + idxNum);
    $('#accordion li.merchantList').find('#collapseMerchant' + idxNum).attr('aria-labelledby', 'headingMerchant' + idxNum);
    // all outlet radio
    //$('#collapseMerchant'+idxNum).find('input[name="voucher-outlet_"]').prop('name', 'voucher-outlet_'+idxNum);
    $('#collapseMerchant' + idxNum).find('input[name="voucher-outlet_"]').prop('name', 'voucher[' + selectedValue + '][redem_all_outlet]');
    $('#collapseMerchant' + idxNum).find('input[id="all-outlet_"]').prop('id', 'all-outlet_' + idxNum);
    //$('#collapseMerchant'+idxNum).find('input[value="all-outlet_"]').prop('value', 'all-outlet_'+idxNum);
    $('#collapseMerchant' + idxNum).find('input[value="all-outlet_"]').prop('value', true);
    $('#collapseMerchant' + idxNum).find('label[for="all-outlet_"]').prop('for', 'all-outlet_' + idxNum);
    // selected outlet radio
    $('#collapseMerchant' + idxNum).find('input[id="selected-outlet_"]').prop('id', 'selected-outlet_' + idxNum);
    $('#collapseMerchant' + idxNum).find('input[value="selected-outlet_"]').prop('value', 'selected-outlet_' + idxNum);
    $('#collapseMerchant' + idxNum).find('label[for="selected-outlet_"]').prop('for', 'selected-outlet_' + idxNum);
    // add outlet option
    $('#collapseMerchant' + idxNum).find('select[id="add-outlet_"]').prop('id', 'add-outlet_' + idxNum);
    $('#collapseMerchant' + idxNum).find('select[id="add-outlet_' + idxNum + '"]').attr('group-number', idxNum);
    $('#collapseMerchant' + idxNum).find('select[id="add-outlet_' + idxNum + '"]').attr('selected-parent', selectedValue);
    //$('#collapseMerchant'+idxNum).find('select[name="add-outlet_"]').prop('name', 'add-outlet_'+idxNum);
    $('#collapseMerchant' + idxNum).find('select[name="add-outlet_"]').prop('name', 'voucher[' + selectedValue + '][add_outlet][]');
    $('#collapseMerchant' + idxNum).find('label[for="add-outlet_"]').prop('for', 'add-outlet_' + idxNum);
    //$('#collapseMerchant'+idxNum).find('select[data-select2-id="add-outlet"]').attr('data-select2-id', 'add-outlet'+idxNum);
    //$('#add-outlet_'+idxNum).select2();
    // exclude outlet option
    $('#collapseMerchant' + idxNum).find('select[id="exclude-outlet_"]').prop('id', 'exclude-outlet_' + idxNum);
    $('#collapseMerchant' + idxNum).find('select[id="exclude-outlet_' + idxNum + '"]').attr('group-number', idxNum);
    $('#collapseMerchant' + idxNum).find('select[id="exclude-outlet_' + idxNum + '"]').attr('selected-parent', selectedValue);
    // $('#collapseMerchant'+idxNum).find('select[name="exclude-outlet_"]').prop('name', 'exclude-outlet_'+idxNum);
    $('#collapseMerchant' + idxNum).find('select[name="exclude-outlet_"]').prop('name', 'voucher[' + selectedValue + '][exclude_outlet][]');
    $('#collapseMerchant' + idxNum).find('label[for="exclude-outlet_"]').prop('for', 'exclude-outlet_' + idxNum);
    //$('#collapseMerchant'+idxNum).find('select[data-select2-id="exclude-outlet"]').attr('data-select2-id', 'exclude-outlet'+idxNum);
    //$('#exclude-outlet_' + idxNum).select2();
}

function countList() {
    var num = $('#accordion li.merchantList').length;
    return num;
}

function checkOutlet(e) {
    var checkstatus = $(e).prop('value');
    var idname = $(e).prop('id');
    var txtlen = idname.length;
    var idx = idname.substr(txtlen - 1);
    var checkedname = idname.substr(0, txtlen - 1);
    //console.log(checkedname);
    if (checkedname === 'all-outlet_') {
        $('#add-outlet_' + idx).val(null).trigger('change');
        $('#exclude-outlet_' + idx).val(null).trigger('change');
        $('#add-outlet_' + idx).prop('disabled', true);
        $('#exclude-outlet_' + idx).prop('disabled', true);
        $('#add-outlet_' + idx + '-error').remove();
        $('#exclude-outlet_' + idx + '-error').remove();
    } else {
        $('#add-outlet_' + idx).prop('disabled', false);
        $('#exclude-outlet_' + idx).prop('disabled', false);
    }

}

function removeList(e) {
    var idList = $(e).parent().parent().parent().parent().prop('id');
    $('#' + idList).parent().fadeOut();
    setTimeout(function () {
        $('#' + idList).parent().remove();
        resetIDList();
    }, 1000);
}

function resetIDList() {
    var num = $('#accordion li.merchantList').length;
    var listLen = countList();
    for (var i = 0; i < listLen; i++) {
        $('#accordion li.merchantList:eq(' + i + ')').find('div[id^="cardMerchant"]').prop('id', 'cardMerchant' + i);
        $('#accordion li.merchantList:eq(' + i + ')').find('div[id^="headingMerchant"]').prop('id', 'headingMerchant' + i);
        $('#accordion li.merchantList:eq(' + i + ')').find('button[id^="collapseMerchantBtn"]').prop('id', 'collapseMerchantBtn' + i);
        $('#accordion li.merchantList:eq(' + i + ')').find('button[id^="collapseMerchantBtn"]').attr('data-target', '#collapseMerchant' + i);
        $('#accordion li.merchantList:eq(' + i + ')').find('button[id^="collapseMerchantBtn"]').attr('aria-controls', '#collapseMerchant' + i);
        $('#accordion li.merchantList:eq(' + i + ')').find('div[id^="collapseMerchant"]').prop('id', 'collapseMerchant' + i);
        $('#accordion li.merchantList:eq(' + i + ')').find('div[id^="collapseMerchant"]').attr('aria-labelledby', 'headingMerchant' + i);
        // all outlet radio
        $('#collapseMerchant' + i).find('input[name^="voucher-outlet_"]').prop('name', 'voucher-outlet_' + i);
        $('#collapseMerchant' + i).find('input[id^="all-outlet_"]').prop('id', 'all-outlet_' + i);
        $('#collapseMerchant' + i).find('input[value^="all-outlet_"]').prop('value', 'all-outlet_' + i);
        $('#collapseMerchant' + i).find('label[for^="all-outlet_"]').prop('for', 'all-outlet_' + i);
        // selected outlet radio
        $('#collapseMerchant' + i).find('input[id^="selected-outlet_"]').prop('id', 'selected-outlet_' + i);
        $('#collapseMerchant' + i).find('input[value^="selected-outlet_"]').prop('value', 'selected-outlet_' + i);
        $('#collapseMerchant' + i).find('label[for^="selected-outlet_"]').prop('for', 'selected-outlet_' + i);
        // add outlet option
        $('#collapseMerchant' + i).find('select[id^="add-outlet_"]').prop('id', 'add-outlet_' + i);
        $('#collapseMerchant' + i).find('select[id="add-outlet_' + i + '"]').attr('group-number', i);
        $('#collapseMerchant' + i).find('select[name^="add-outlet_"]').prop('name', 'add-outlet_' + i);
        $('#collapseMerchant' + i).find('label[for^="add-outlet_"]').prop('for', 'add-outlet_' + i);
        //$('#collapseMerchant'+i).find('select[data-select2-id="add-outlet"]').attr('data-select2-id', 'add-outlet'+i);
        //$('#add-outlet'+i).select2();
        // exclude outlet option
        $('#collapseMerchant' + i).find('select[id^="exclude-outlet_"]').prop('id', 'exclude-outlet_' + i);
        $('#collapseMerchant' + i).find('select[id="exclude-outlet_' + i + '"]').attr('group-number', i);
        $('#collapseMerchant' + i).find('select[name^="exclude-outlet_"]').prop('name', 'exclude-outlet_' + i);
        $('#collapseMerchant' + i).find('label[for^="exclude-outlet_"]').prop('for', 'exclude-outlet_' + i);
        //$('#collapseMerchant'+i).find('select[data-select2-id="exclude-outlet"]').attr('data-select2-id', 'exclude-outlet'+i);
        //$('#exclude-outlet'+i).select2();
    }
}