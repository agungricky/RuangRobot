<div class="form-group">
    <label for="{{$name}}">{{$label}}</label>
    <input type="text" class="form-control" id="{{$name}}" placeholder="{{$placeholder}}" name="{{$name}}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
</div>