<div class="clearfix"></div>
@if (Session::has('message'))
    <div class="alert alert-danger">
        <p>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-exclamation"></i>
            <span style="margin-left: 10px;">{{ Session::get('message') }}</span>
        </p>
    </div>
@endif
<div class="clearfix"></div>
<div id="div-resultado"></div>
<div class="clearfix"></div>