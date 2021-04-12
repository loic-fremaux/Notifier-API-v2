@extends('layouts.app')

@section('content')
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                {{ __('firebase.phone') }}
            </th>
            <th>
                {{ __('firebase.key') }}
            </th>
            <th>
                {{ __('app.delete') }}
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($keys as $key)
            <tr>
                <td>
                    {{ $key->id }}
                </td>
                <td>
                    {{ $key->device_name }}
                </td>
                <td>
                    <div class="badge badge-secondary text-monospace">{{ $key->key }}</div>
                </td>
                <td>
                    @include('services.modules.modal', [
                        "modal_id" => $key->id . '-delete',
                        "toggle_name" => __('services.remove.msg'),
                        "toggle_style" => "text-white bg-danger",
                        "title" => __('firebase.remove.question'),
                        "text" => __('firebase.remove.confirmation_message'),
                        "accept_text" => __('app.delete'),
                        "accept_route" => route('firebase.delete', ["id" => $key->id]),
                        "btn_type" => "btn-danger",
                    ])
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection

