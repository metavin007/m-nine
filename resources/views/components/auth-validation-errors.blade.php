@props(['errors'])

@if ($errors->any())
@foreach ($errors->all() as $error)
<div class="alert alert-light-danger color-danger">
    <i class="bi bi-exclamation-circle"></i> 
    {{ $error }}
</div>
@endforeach
@endif
