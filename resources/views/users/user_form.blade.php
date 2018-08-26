@extends('layouts/main')
@php
    $title = @$user ? 'Edit User' : 'Create New User'
@endphp
@section('title', $title)
@section('headerTitle', $title)
@section('content')
<div id="main-content">
<div class="main-content__body container-fluid">
    <div class="row justify-content-md-center">
    <div class="content-area col-md-9">
        @php
          $userId = @$user->user_id;
          $method = $userId ? 'PUT' : 'POST';
          $route = $userId ? route('user.update', ['id' => $userId]) : route('user.store');
        @endphp
        <form id="user_form" action="{{ $route }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="{{ $method }}">
            @csrf
            <div class="content-area__main">
                <div class="form-section">
                <h2 class="heading">User Profile</h2>
                <p>Lorem ipsum dolor sit amet, at has augue moderatius appellantur, per ut summo quando latine. Ea cum solet detraxit splendide, enim wisi qui ex, quidam dignissim ne nam.</p>
                </div>
                
                <div class="form-section row">
                <div class="col-md-6">
                    <div class="form-group">
                    <div class="form-input">
                        <label for="salutation">Salutation</label>
                        <div class="input-group">
                            @php $i = 0; @endphp
                            @foreach ($settings->salutation as $salutation)
                            @php
                                $checked = '';
                                if(@$user->user_salutation_pid == $salutation->parameters_id) {
                                    $checked = 'checked';
                                }elseif(!@$user->user_salutation_pid && $i == 0) {
                                    $checked = 'checked';
                                }
                            @endphp
                            <div class="form-input form-check radio-inline radio-width-3">
                                <input class="form-check-input" type="radio" name="user_salutation_pid" value="{{ $salutation->parameters_id }}" {{ $checked }} nice-checkbox-radio required>
                                <label class="form-check-label" for="salutation-mr">{{ $salutation->parameters_value }}</label>
                            </div>
                            @php $i++; @endphp
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <div class="form-input">
                        <label for="client-name">Full Name</label>
                    <input name="user_profile_name" type="text" class="form-control" id="client-name" placeholder="" value="{{ @$user->user_profile_name }}" required>
                    </div>
                    </div>
                </div>
                </div>
                <!-- /.form-section -->
                @if(!$sprintClient)
                <!-- /.form-section -->
                  <div class="form-section row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <div class="form-input">
                          <label for="choose-client">Client</label>
                          <select name="client_id" class="custom-select dropdown-select2" id="choose-client">
                            <option {{ !@$user->client_id ? 'selected' : '' }}>Choose...</option>
                            @foreach ($clients as $client)
                            @php
                                $selected = @$user->client_id == $client['client_id'] ? 'selected' : '';
                            @endphp
                            <option value="{{ $client['client_id'] }}" {{ $selected }}>{{ $client['client_name'] }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group has-only-a-link">
                        <a href="{{ route('client.create') }}" class="align-middle">Client is not registered yet? Click here to add new client</a>
                      </div>
                    </div>
                  </div>
                  <!-- /.form-section.row -->
                @endif
                
                <div class="form-section last">
                <div class="form-group">
                    <div class="form-input">
                    <label for="client-role">Role</label>
                    <select name="roles_id" class="custom-select dropdown-select2" id="choose-role" required>
                        <option value="" {{ !@$user->roles_id ? 'selected' : '' }} disabled hidden>Choose...</option>
                        @foreach ($roles as $role)
                        @php
                            $selected = @$user->roles_id == $role->roles_id ? 'selected' : '';
                        @endphp
                        <option value="{{ $role->roles_id }}" {{ $selected }}>{{ $role->roles_description }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                </div>
                <!-- /.form-section.last -->
                <div class="form-section row">
                <div class="col-md-6">
                    <div class="form-group">
                    <div class="form-input">
                        <label for="client-email">Email</label>
                        <input name="user_name" type="text" class="form-control" id="client-email" placeholder="" value="{{ @$user->user_name }}" required>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <div class="form-input">
                        <label for="client-phone">Phone Number</label>
                        <input name="user_phone" type="text" class="form-control" id="client-phone" placeholder="" value="{{ @$user->user_phone }}" required>
                    </div>
                    </div>
                </div>
                </div>

                <div class="form-section row">
                <div class="col-6">
                    <div id="upload_button">
                        <label>
                        <input id="uploadInput" type="file" name="user_profile_image_url" accept="image/*">
                        <span class="btn btn-outline-primary btn-block">Upload Profile Picture</span>
                        </label>
                        <p>Min. image 50 x 50 px</p>
                    </div>
                </div>
                <div class="col-6">
                    @if(@$user->user_profile_image_url)
                        <div id="uploadBox" style="display:block">
                        <input type="text" id="uploadText" value="{{ @$user->user_profile_image_url }}" readonly>
                        <a href="#" class="clearFile"><img src="{{ asset('assets/img/icon-times.svg') }}" alt=""></a>
                        </div>
                    @else
                        <div id="uploadBox" style="display:none">
                            <input type="text" id="uploadText" readonly>
                            <a href="#" class="clearFile"><img src="{{ asset('assets/img/icon-times.svg') }}" alt=""></a>
                        </div>
                    @endif
                </div>
                </div>
                <!-- /.form-section.row -->
                <div class="form-section clearfix">
                <button type="submit" id="save_user" class="btn btn-wide-block btn-primary btn-add-client border-0">Add User</button>
                </div>
            </div>
            <!-- /.content-area__main -->
        </form>
        <!-- /#client-form -->
    </div>
    <!-- /.content-area -->
    </div>
</div>
<!-- /.main-content__body -->
</div>
@endsection
@push('footer_scripts')
<script>
    $(document).ready(function(){
        $('#save_user').click(function(e){
            e.preventDefault();
            $('#user_form').validate({
            errorElement: "div",
            onkeyup: false,
            ignore: [],
            rules: {    
                user_salutation_pid: {
                    required: true,
                },
                user_profile_name: {
                    required: true,
                    minlength : 3,
                    maxlength : 50
                },
                roles_id: {
                    required: true,
                },
                user_name: {
                    required: true,
                    email: true
                },
                user_phone: {
                    required: true,
                    number: true,
                    minlength:6,
                    maxlength:14
                }
            },
            errorPlacement: function(error, element) {
            console.log(element.prop('nodeName'));
                if (element.prop('nodeName') == 'SELECT') {
                    error.appendTo(element.parent());
                    console.log('here');
                }
                else {
                    error.insertAfter(element);
                }
            }
            });
            if ((!$('#user_form').valid())) {
       		  return false;
            }
            $('#user_form').submit();
        });
    });
</script>
@endpush