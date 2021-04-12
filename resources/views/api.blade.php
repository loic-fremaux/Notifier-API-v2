@extends('layouts.app')

@section('content')
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                {{ __('api.token') }}
            </th>
            <th>
                {{ __('api.usage') }}
            </th>
            <th>
                {{ __('app.delete') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tokens as $token)
            <tr>
                <td>
                    {{ $token->id }}
                </td>
                <td>
                    <div class="text-monospace">{{ $token->token }}</div>
                </td>
                <td>
                    <div class="text-monospace">{{ $token->usage }}</div>
                </td>
                <td>
                    @include('services.modules.modal', [
                        "modal_id" => $token->id . '-delete',
                        "toggle_name" => __('services.remove.msg'),
                        "toggle_style" => "text-white bg-danger",
                        "title" => __('api.remove.question'),
                        "text" => __('api.remove.confirmation_message'),
                        "accept_text" => __('app.delete'),
                        "accept_route" => route('user.api.delete', ["id" => $token->id]),
                        "btn_type" => "btn-danger",
                    ])
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

