@if (Session::has('success'))
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×
                </button>
                <h4>
                    {{ explode("\r", Session::get('success'))[0] }}
                </h4>
                {{ explode("\r", Session::get('success'))[1] }}
            </div>
        </div>
    </div>
@endif

@if (Session::has('warning'))
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissable">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×
                </button>
                <h4>
                    {{ explode("\r", Session::get('warning'))[0] }}
                </h4>
                {{ explode("\r", Session::get('warning'))[1] }}
            </div>
        </div>
    </div>
@endif


@if (Session::has('failure'))
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">

                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×
                </button>
                <h4>
                    {{ explode("\r", Session::get('failure'))[0] }}
                </h4>
                {{ explode("\r", Session::get('failure'))[1] }}
            </div>
        </div>
    </div>
@endif
