@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form role="form" method="POST" action="{{ route('service.create') }}">
                @csrf
                <div class="form-group">
                    <label for="serviceName">
                        {{ __('services.create.name') }}
                    </label>
                    <input type="text" class="form-control" id="serviceName" name="name" value="{{ old('name') }}" required/>
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="serviceSlug">
                        {{ __('services.create.slug') }}
                    </label>
                    <input type="text" class="form-control" id="serviceSlug" name="slug" value="{{ old('slug') }}" required/>
                    @error('slug')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ __('app.create') }}
                </button>
            </form>
        </div>
    </div>
@endsection
