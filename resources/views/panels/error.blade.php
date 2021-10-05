@if ($errors->any())
    <div class="card-alert card red lighten-1">
        <div class="card-content white-text">
            <p>
                <i class="material-icons">error</i> ERROR :
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </p>
        </div>
        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif


@if (session()->has('val_errors'))
    <div class="card-alert card red lighten-1">
        <div class="card-content white-text">
            <p>
                <i class="material-icons">error</i> ERROR :
                @foreach (session()->get('val_errors') as $k => $v)
                    <?php
                    $msg = array_values($v);
                    ?>
                    <li>{{ $msg[0][0] }}</li>
                @endforeach
            </p>
        </div>
        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif

@if (session()->has('error'))
    <div class="card-alert card red lighten-1">
        <div class="card-content white-text">
            <p>
                <i class="material-icons">error</i> ERROR : {{ session()->get('error') }}
            </p>
        </div>
        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif

@if (session()->has('success'))
    <div class="card-alert card green">
        <div class="card-content white-text">
            <p>
                <i class="material-icons">check</i> SUCCESS : {{ session()->get('success') }}
            </p>
        </div>
        <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
@endif
