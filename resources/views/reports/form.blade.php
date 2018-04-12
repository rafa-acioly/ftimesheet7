<form action="{{ route('time.update', ['id' => $times->id]) }}" 
        method="post" 
        id="form-{{ $times->id }}">
    <div class="form-row">
        <div class="form-group col-md-4">
            <input type="number" 
                class="form-control" 
                value="{{ explode(':', $times->duration)[0] }}"
                min="0">
        </div>
        <div class="form-group col-md-4">
            <input type="number" 
                class="form-control" 
                value="{{ explode(':', $times->duration)[1] }}"
                max="60"
                min="0">
        </div>
        <div class="form-group col-md-4">
            <input type="number" 
                class="form-control" 
                value="{{ explode(':', $times->duration)[2] }}"
                max="60"
                min="0">
        </div>
    </div>
</form>