<div class="form-control-live-edit-label-wrapper">

    <button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-dark text-uppercase']) }}>
        {{ $slot }}
    </button>
</div>
