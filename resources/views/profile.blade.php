@extends('layouts.app')

@section('content')
    <dl>
        <dt>
            Identifiant
        </dt>
        <dd>
            loic.fremaux1@gmail.com
        </dd>
        <dt>
            Clé d'API
        </dt>
        <dd>
            {{ Auth::user()->api_token }}
        </dd>
    </dl>

    <a id="modal-96544" href="#modal-container-96544" role="button" class="btn btn-danger"
       data-toggle="modal"> {{ __('profile.reset_api_key') }}</a>

    <div class="modal fade" id="modal-container-96544" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">
                        {{ __('profile.reset_api_key_question') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('profile.reset_api_key_confirmation') }}
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-danger" href="{{ route('profile.reset_api_token') }}">
                        {{ __('profile.reset') }}
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ __('app.cancel') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
