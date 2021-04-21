@extends('layouts.app')

@section('content')
    <a type="button" class="btn btn-primary float-right" href="{{ route('services.new') }}">
        {{ __('services.new') }}
    </a>

    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                {{ __('services.name') }}
            </th>
            <th>
                {{ __('services.slug') }}
            </th>
            <th>
                {{ __('services.member_list') }}
            </th>
            <th>
                {{ __('services.api_key') }}
            </th>
            <th>
                {{ __('services.actions') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($services as $service)
            <tr>
                <td>
                    {{ $service->id }}
                </td>
                <td>
                    {{ $service->name }}
                </td>
                <td>
                    {{ $service->slug }}
                </td>
                <td>
                    @if($service->user_id === Auth::id())
                        @php($i = 0)
                        @php($c = count($service->users))
                        <ul class="list-group">
                            @foreach($service->users as $user)
                                @if($user->id === Auth::id())
                                    <li class="list-group-item disabled">{{ $user->name }}</li>
                                @else
                                    @include('services.modules.modal', [
                                        "modal_id" => $service->id . '-deluser-' . $user->id,
                                        "toggle_name" => $user->name,
                                        "toggle_style" => "list-group-item",
                                        "title" => __('services.user.remove_member'),
                                        "text" => __('services.user.remove_text'),
                                        "accept_text" => __('services.user.remove'),
                                        "accept_route" => route('service.user.remove', ["id" => $service->id, "user" => $user->id]),
                                        "btn_type" => "btn-danger",
                                    ])
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <ul class="list-group">
                            @foreach($service->users as $user)
                                <li class="list-group-item">{{ $user->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
                <td>
                    <div class="badge badge-primary text-truncate d-inline-block text-monospace"
                         style="max-width: 180px;">
                        {{ $service->api_key }}
                    </div>
                </td>
                <td>
                    <div class="list-group">

                        <a id="modal-{{ $service->id }}-add-user" href="#modal-container-{{ $service->id }}-add-user"
                           role="button"
                           class="list-group-item list-group-item-action text-white bg-primary" data-toggle="modal">
                            {{ __('services.user.add') }}
                        </a>

                        <div class="modal fade" id="modal-container-{{ $service->id }}-add-user" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form id="add-user-{{ $service->id }}"
                                          action="{{ route('service.user.add', ["id" => $service->id]) }}"
                                          method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">
                                                {{ __('services.user.add') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label
                                                for="input-add-user-{{ $service->id }}">{{ __('services.user.add_text') }}</label>
                                            <input name="username" type="text" class="form-control"
                                                   id="input-add-user-{{ $service->id }}"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('app.add') }}
                                            </button>

                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                {{ __('app.cancel') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        @include('services.modules.modal', [
                            "modal_id" => $service->id . '-reset',
                            "toggle_name" => __('services.reset.api_key'),
                            "toggle_style" => "text-danger",
                            "title" => __('services.reset.api_key_question'),
                            "text" => __('services.reset.api_key_confirmation'),
                            "accept_text" => __('services.reset.reset'),
                            "accept_route" => route('service.reset_api_key', ["id" => $service->id]),
                            "btn_type" => "btn-danger",
                        ])

                        @include('services.modules.modal', [
                            "modal_id" => $service->id . '-delete',
                            "toggle_name" => __('services.remove.msg'),
                            "toggle_style" => "text-white bg-danger",
                            "title" => __('services.remove.question'),
                            "text" => __('services.remove.confirmation_message'),
                            "accept_text" => __('app.delete'),
                            "accept_route" => route('service.delete', ["id" => $service->id]),
                            "btn_type" => "btn-danger",
                        ])
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
