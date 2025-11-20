{{-- resources/views/admin/partials/errors.blade.php --}}
@if ($errors->any())
    <div class="admin-alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
