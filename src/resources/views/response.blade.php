@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@if (session('warning'))
                                <div class="alert alert-warning">
                                    {{ session('warning') }}
                            
                                </div>
                            @endif
                            @if(session('subscribe'))
<div class="alert alert-info">
    {{session('subscribe')}}
</div>
    @endif
@if (isset($errors) && $errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('status'))
@if(is_array(session('status')))
    <div class="alert alert-success">
        {{session('status')['message']}}
        <script>
            window.setTimeout(function(){

                // Move to a new location or you can do something else
                window.location.href = "{{session('status')['payUrl']}}";

            }, 5000);
        </script>
    </div>
    @else
    <div class="alert alert-success">
        {{session('status')}}
        </div>
    
    @endif
@endif