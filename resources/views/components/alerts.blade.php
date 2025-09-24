@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: flex; justify-content: space-between;">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=" background-color: transparent; border: 0cap;" >
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert"  style="display: flex; justify-content: space-between;">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style=" background-color: transparent; border: 0cap;">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif