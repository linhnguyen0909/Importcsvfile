@if ($failures)
    <div class="alert alert-danger" role="alert">
        <strong>Errors:</strong>
        <ul>
            @foreach ($failures as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
