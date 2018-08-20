@extends('layouts/landing_page')
@section('title', 'Voucher Redeem')
@section('content')

 <div class="site clearfix">

          <div class="main-content__body container-fluid">
              <div class="row">
                  <div class="landing-container col-md-4">

                    @php
                      $redeemInformation = $redeem['redeemInformation'];
                      $termandCondition = collect($redeem['redeemTC']);
                    @endphp

                      <div class="landing-heading">
                        <h1>Congratulation!</h1>
                        <p>
                          {{ $redeemInformation->campaign_message_title }}
                        </p>
                        
                      </div>

                      <div class="card card-form">
                          <div class="card-header">
                              <h5 class="card-title">{{ $redeemInformation->campaign_voucher_title }}</h5>
                              <h5 class="card-subtitle">{{ $redeemInformation->Merchant }}</h5>
                          </div>
                          <div class="card-body text-center">
                              @if(!$redeemInformation->campaign_voucher_main_image_url)
                                <img src="{{ asset('assets/img/user/starwars-movie-poster-medium.jpg') }}" alt="">
                              @else
                                @php
                                  $path = 'storage/voucher/original';
                                  $filePath = $path.'/'.$redeemInformation->campaign_voucher_main_image_url;
                                @endphp
                                <!--<img src="{{ asset($filePath) }}" alt="">-->
                                <img src="{{ asset('assets/img/user/image.jpg') }}" alt="">
                              @endif
                          </div>
                          <div class="card-footer text-muted">
                              <nav class="voucher-tab">
                                  <div class="nav nav-tabs" id="m-Tab" role="tablist">
                                      <a class="nav-item nav-link active" id="info" href="#nav-info">Informasi</a>
                                      <a class="nav-item nav-link" id="ketentuan" href="#nav-ketentuan">Ketentuan</a>
                                      <a class="nav-item nav-link" id="penukaran" href="#nav-tukar">Penukaran</a>
                                  </div>
                              </nav>
                              <div class="tab-content" id="m-tabContent">
                                  <div class="tab-pane fade show active" id="nav-info">
                                      {{ $redeemInformation->campaign_voucher_information }}
                                  </div>
                                  <div class="tab-pane fade" id="nav-ketentuan">
                                      Voucher berlaku hingga {{ $redeemInformation->campaign_voucher_valid_end_date }}
                                  </div>
                                  <div class="tab-pane fade" id="nav-tukar">
                                      <p class="text-center">
                                            Tunjukkan QR Code ini kepada kasir/loket penukaran <br><br>
                                           <!--  <a href='#' data-toggle="modal" data-target="#storeCodeModal">
                                                <img src='http://www.unitag.io/qreator/generate?crs=e2ZRfLkGhCcNX0uPU0VF3l2iWCU5iBS65XqQ37eAYrFw1DqSur4MlY3KDO2BDD2mBo8u49VJSRUN61r7kZGYhdTmk%252F7zrZPNv%252BvdL8%252F3FZQIsRoRa29g6JCo%252BMr1U9KIrE%252Bnsuv3ZYI6Py3tmkIQ8%252BEeCrwb5jj4Irri3GordWt5Lnn5RdF7YPFjY1wajrVuR%252B%252FP9hE8xiNWLqCVKbr%252Bl4lUhL%252FV8dHyx4iB3lMvJA6b%252BR9YbGA4eBLyE4ApKFZytg2Kx6IpTsPPqimIJ3mZFOwRtlBVPh3fqjEmcG687Iw0%252F5378PNxX6sImd7pE23A5T1UiqdyW3LF34GmKxyp1g%253D%253D&crd=mXKe51B3LcpJnGj6pepi6V3RM8sS1f7iyDZdZEpcqQ3B93K71VLjQVUBTpD9A4ML7KVXVgDdRMTiVz24fi6wYw%253D%253D' alt='QR Code'/>
                                                <br><span id="storeCodeVal">AAPL690WK54M50</span>
                                            </a> -->

                                             <a href='#' data-toggle="modal" data-target="#storeCodeModal" id="qrcode">
                                                
                                            </a>
                                      </p>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- /.card -->

                      <!-- Cara Penukaran Voucher -->
                      <div id="nav-info-card" class="card card-form card-extra">
                        <div class="card-header">
                          <h5 class="card-title">Cara Penukaran Voucher</h5>
                        </div>
                        
                        <ul class="text-list">
                          
                          <li>
                          {{ $redeemInformation->campaign_voucher_short_information }}
                          </li>
                        </ul>
                        
                      </div>
                      <!-- /.card -->

                      <!-- Syarat dan Ketentuan -->
                      <div id="nav-ketentuan-card" class="card card-form card-extra">
                        <div class="card-header">
                          <h5 class="card-title">Syarat dan Ketentuan</h5>
                        </div>
                        <ul class="text-list">
                          <li>
                          {{ $redeemInformation->campaign_voucher_terms_and_condition }}
                          </li>
                        </ul>
                      </div>
                      <!-- /.card -->

                      <!-- Syarat dan Ketentuan -->
                      <div id="nav-ketentuan-card2" class="card card-form card-extra" style="display: none">
                        <div class="card-header">
                          <h5 class="card-title">Dapat Ditukar Pada Outlet</h5>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div id="accordion">
                                  @foreach($termandCondition->groupBy('outlets_address_province_pid','merchant_id') as $tc)
                                        <div class="card">
                                          <div class="card-header" id="headingCity0">
                                            <h5 class="mb-0">
                                              <a href="#" class="accordion-head" data-toggle="collapse" data-target="#collapseCity0" aria-expanded="true" aria-controls="collapseCity0">
                                                {{ $tc->first()->province }}
                                              </a>
                                            </h5>
                                          </div>
                                      
                                          <div id="collapseCity0" class="collapse show" aria-labelledby="headingCity0" data-parent="#accordion">
                                            <div class="card-body">
                                              @php
                                                $i =1;
                                              @endphp
                                                <ul id="accordCity0">
                                                  @foreach($tc as $terms)                                               
                                                    <li id="headcity0-ol0">
                                                        <a href="#" class="li-outlet" data-toggle="collapse" data-target="#collapseCity0Sub0" aria-expanded="false" aria-controls="collapseCity0Sub0">
                                                            {{ $terms->merchant_title }}
                                                        </a>
                                                        <div class="collapse show" id="collapseCity0Sub0" aria-labelledby="headcity0-ol0" data-parent="#accordCity0">
                                                            <div class="card card-body">
                                                                <ul>
                                                                    <li>{{ $terms->outlets_title }}</li>
                                                                    <li>{{ $terms->address_line }}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @php
                                                      $i++;
                                                    @endphp
                                                    @endforeach
                                                    <!-- <li id="headcity0-outlet1">
                                                        <a href="#" class="li-outlet collapsed" data-toggle="collapse" data-target="#collapseCity0Sub1" aria-expanded="false" aria-controls="collapseCity0Sub1">
                                                            XXI Cinemas
                                                        </a>
                                                        <div class="collapse" id="collapseCity0Sub1" aria-labelledby="headcity0-ol1" data-parent="#accordCity0">
                                                            <div class="card card-body">
                                                                <ul>
                                                                    <li>Puri Indah Mall <br> Lantai 2, Jl. Puri Indah Raya Jakarta Barat</li>
                                                                    <li>MALL TAMAN ANGGREK Lantai 3 <br>Jl. Letjen S. Parman, Kav. 21, Jakarta Barat</li>
                                                                    <li>Gandaria City Level 2 <br>Jl Sultan Iskandar Muda, Kebayoran Lama, <br> Jakarta Selatan</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li> -->
                                                </ul>
                                                
                                            </div>
                                          </div>
                                        </div>
                                  @endforeach
                                  </div>
                            </div>
                        </div>
                      </div>
                      <!-- /.card -->

                      <div id="nav-info-btn" class="nav-tab-btn">
                            <button id="tukarkanVoucher" type="button" class="btn btn-wide-block btn-green btn-add-campaign btn-redeem-voucher border-0">Tukarkan Voucher</button>
                        </div>
                      <div id="nav-tukar-btn" class="nav-tab-btn" style="display:none">
                            <button type="button" class="btn btn-wide-block btn-green btn-add-campaign btn-redeem-voucher border-0" data-toggle="modal" data-target="#storeCodeModal">Masukkan Outlet Code</button>
                            <p class="text-center note-text">*hanya boleh dilakukan oleh petugas kasir/loket</p>
                      </div>
                  </div>
                  <!-- /.sidebar-area -->
              </div>
          </div>

        </div>
        <!-- /.site -->

        <div class="footer-social">
        <div class="row">
            <div class="col-md-4">
              <ul class="list-unstyled">
                <li><a href="#" class="soc-facebook"><i class="fab fa-facebook"></i></a></li>
                <li><a href="#" class="soc-instagram"><i class="fab fa-instagram"></i></a></li>
                <li><a href="#" class="soc-twitter"><i class="fab fa-twitter"></i></a></li>
              </ul>
            </div>
          </div>
        </div>

            
        <!-- The Store Code Modal -->
        <div class="modal fade" id="storeCodeModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">                
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p class="text-center">
                            Ini merupakan voucher Prezent, untuk menukarkan mohon masukkan outlet code Anda
                        </p>
                        <form id="storeCodeForm">
                            <input type="text" class="form-control" name="outlet_authentification_code" placeholder="Store Code">
                            <button type="submit" id="btnRedeem" class="btn btn-wide-block btn-green btn-add-campaign btn-redeem-voucher border-0">Redeem</button>
                        </form>
                    </div>                
                </div>
            </div>
        </div>

        <!-- The Store Code Modal -->
        <div class="modal fade" id="statusModal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">                
                    <!-- Modal body -->
                    <div class="modal-body">
                        <p class="text-center">
                            <img id="status_image" src="{{ asset('assets/img/img-error.svg') }}" alt="">
                           <!-- <img src="img/img-error.svg" alt=""> -->
                        </p>
                        <h4 class="text-center" id="status_title">Store Code Salah</h4>
                        <p id="status-text" class="text-center">Loading ..</p>
                        <button type="button" class="btn btn-wide-block btn-green btn-add-campaign btn-redeem-voucher border-0" data-dismiss="modal">Coba Lagi</button>
                    </div>                
                </div>
            </div>
        </div>
@endsection
@push('footer_scripts')
<script type="text/javascript">
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

$('#tukarkanVoucher').click(function(e){
  e.preventDefault();
  $('#nav-tukar').attr('class','tab-pane fade active show');

  let link = $('#penukaran').attr('class','nav-item nav-link active show');
  $('.nav-item.nav-link').each(function(){
      if($(this).attr('id') !== 'penukaran') {
        console.log($(this).attr('id'));
        $(this).removeClass('active');
        $(this).removeClass('show');
      }
  })

  $('.tab-pane.fade').each(function(){
    if($(this).attr('id') !== 'nav-tukar') {
        $(this).removeClass('active');
        $(this).removeClass('show');
      }
  })

  $('#nav-info-card').hide();
  $('#nav-info-btn').hide();
  $('#nav-tukar-btn').show();

});

function setStatusModal(data, type){
    $('#statusModal').find('img').prop('src','{{ asset("assets/img/img-error.svg") }}');
    $('#statusModal').find('h4').html(data.title);
    $('#statusModal').find('button').html(data.btn);
    var newmsg = data.message;
    if(type == true){
        $('#storeCodeModal').modal('hide');
    }
    $('#statusModal').find('p#status-text').html(data.message);
    $('#statusModal').modal('show');
}

//functiob redeem
$(document).on('click','#btnRedeem', function(){
  redeemCode().done(function(response){
    // $('#statusModal').modal('hide');
    $('#statusModal, input').val('');
    let redemFailureCode = response['data'][0]['redeem_failure_code'];
    let reedemStatusCode = response['data'][0]['redeem_status_code'];
    let voucherGeneratedNo = response['data'][0]['voucher_generated_no'];
    let redeemRequestDate = response['data'][0]['redeem_request_date'];
    let messages = null;
    let statusTitle = 'Invalid Voucher';
    let statusImage = "{{ asset('assets/img/img-error.svg') }}";
    if(reedemStatusCode == '001') {
      statusTitle = 'Suksess Redeem Voucher';
      statusImage = "{{ asset('assets/img/img-success.svg') }}";
      messages = 'Success! voucher ['+voucherGeneratedNo+'] has been redeemed on '+ redeemRequestDate+' Please inform customer.';
    }else if(reedemStatusCode == '000' && redemFailureCode == 'INV') {
      messages = 'Oops! unknown voucher number or invalid store code, redeem failed';
    }else if (reedemStatusCode == '000' && redemFailureCode == 'RF01'){
      messages = 'Oops! voucher ['+voucherGeneratedNo+'] has been redeemed before! Please inform customer.';
    }else if (reedemStatusCode == '000' && redemFailureCode == 'RF02'){
      messages = 'Oops! voucher ['+voucherGeneratedNo+'] or it\'s related campaign has not been started yet! Please inform customer';
    }else if (reedemStatusCode == '000' && redemFailureCode == 'RF03'){
      messages = 'Oops! voucher ['+voucherGeneratedNo+'] or it\'s related campaign has expired! Please inform customer. ';
    }else if (reedemStatusCode == '000' && redemFailureCode == 'RF04'){
      messages = 'Oops! Invalid store code for voucher ['+voucherGeneratedNo+'] redeem failed! Please inform customer. ';
    }else if (reedemStatusCode == '000' && redemFailureCode.includes('Locked')){
      messages = 'Oops! there\'s too many failed redeem attempt for voucher ['+voucherGeneratedNo+'], redeem access '+redemFailureCode+'.';
    }

    $('#status_image').attr('src',statusImage);

    $('#status_title').text(statusTitle);

    $('#status-text').text(messages);
  }).fail(function(){
    console.log('data kosong');
     let statusTitle = 'Invalid Voucher';
     let messages = 'Unknown Voucher URL';
    $('#status_title').text(statusTitle);

    $('#status-text').text(messages);
  });
})

//Function redeem code for get value
function redeemCode(){
  var token = $('meta[name="csrf-token"]').attr('content');
  var storeCode = $('input[name="outlet_authentification_code"]').val();

  var data = {
    _token:token,
    outlets_auth_code:storeCode
  };

  return $.ajax({
    url: "{{ route('voucher.save.outlet',['voucherId' => $voucherId]) }}",
    data: data,
    method: 'POST',
  });
}


// jQuery("#qrcode").qrcode("url");

// or

jQuery("#qrcode").qrcode({
    //render:"table"
    width: 300,
    height: 300,
    text: "{{ $voucherId }}"
});

// <span id="storeCodeVal">AAPL690WK54M50</span>
$('#qrcode').append('<br/><span id="storeCodeVal">{{ $voucherId }}</span>');
</script>

@endpush
