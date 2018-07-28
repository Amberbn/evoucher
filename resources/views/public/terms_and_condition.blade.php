@extends('layouts/blank_page')
@section('title', 'Terms and Condition')
@section('content')
<div class="container-fluid">
<div class="terms-condition-outer">
    <h4 class="heading">Terms and Condition</h2>
    <div class="terms-condition-inner">
        <h5>Last Updated May 20. 2018</h5>
        <p>dolor sit amet, nonumy eleifend at vel, his ei accusata principes similique, an vim odio perfecto. Duo probatus reprimique ad, habeo honestatis ei est, usu no case tacimates voluptaria. At usu novum argumentum, pro et quis voluptaria interesset, cu pro harum melius prodesset. Adhuc audiam tibique id eum, ei his vitae utroque. Eam et illud democritum, feugait senserit id duo, modus periculis no vis.</p>
        <p>Qui aperiri virtute offendit no, nec gloriatur honestatis instructior eu. Te qui detracto expetendis. Ea error dolorem his, wisi viris vivendo nam ei. Dicta solet omnium cu eam, delectus forensibus quo ne.</p>
        <h5>Lorem ipsum dolor sit omet</h5>
        <p>dolor sit amet, nonumy eleifend at vel, his ei accusata principes similique, an vim odio perfecto. Duo probatus reprimique ad, habeo honestatis ei est, usu no case tacimates voluptaria. At usu novum argumentum, pro et quis voluptaria interesset, cu pro harum melius prodesset. Adhuc audiam tibique id eum, ei his vitae utroque. Eam et illud democritum, feugait senserit id duo, modus periculis no vis.</p>
        <p>Qui aperiri virtute offendit no, nec gloriatur honestatis instructior eu. Te qui detracto expetendis. Ea error dolorem his, wisi viris vivendo nam ei. Dicta solet omnium cu eam, delectus forensibus quo ne.</p>
        <h5>Lorem ipsum dolor sit omet</h5>
        <p>dolor sit amet, nonumy eleifend at vel, his ei accusata principes similique, an vim odio perfecto. Duo probatus reprimique ad, habeo honestatis ei est, usu no case tacimates voluptaria. At usu novum argumentum, pro et quis voluptaria interesset, cu pro harum melius prodesset. Adhuc audiam tibique id eum, ei his vitae utroque. Eam et illud democritum, feugait senserit id duo, modus periculis no vis.</p>
        <button id="redirect_home" link-url="{{ route('home') }}" type="submit" class="btn btn-wide-block btn-primary btn-add-client border-0">I agree</button>
    </div>
</div>
</div>
@endsection
@push('footer_scripts')
<script>
    $('#redirect_home').click(function(){
        window.location = $(this).attr('link-url');
    });
</script>
@endpush