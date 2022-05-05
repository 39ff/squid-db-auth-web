<div class="mb-3">
    <label for="user" class="form-label">User</label>
    <input type="text" class="form-control" id="user" name="user" value="{{ old('user',$user ?? '') }}">
</div>
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" value="{{ old('password',$password ?? '') }}">
</div>
<div class="mb-3">
    <label for="fullname" class="form-label">FullName</label>
    <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname',$fullname ?? '') }}">
</div>
<div class="mb-3">
    <label for="comment" class="form-label">Comment</label>
    <input type="text" class="form-control" id="comment" name="comment" value="{{ old('comment',$comment ?? '') }}">
</div>
<div class="mb-3">
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="enabled" name="enabled" value="1" {{ str_replace('1','checked',old('enabled',$enabled ?? '')) }}>
        <label class="form-check-label" for="enabled">Enabled</label>
    </div>
</div>


<button type="submit" class="btn btn-primary mb-3">{{ $submit }}</button>
