<a id="modal-{{ $modal_id }}" href="#modal-container-{{ $modal_id }}" role="button"
   class="list-group-item list-group-item-action {{ $toggle_style }}" data-toggle="modal">
    {{ $toggle_name }}
</a>

<div class="modal fade" id="modal-container-{{ $modal_id }}"
    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">
                    {{ $title }}
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $text }}
            </div>
            <div class="modal-footer">
                <a type="button" class="btn {{ $btn_type }}"
                   href="{{ $accept_route }}">
                    {{ $accept_text }}
                </a>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{ __('app.cancel') }}
                </button>
            </div>
        </div>

    </div>
</div>
