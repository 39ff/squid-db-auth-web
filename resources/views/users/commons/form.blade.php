<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$name ?? '') }}">
</div>
<div class="mb-3">
    <label for="email" class="form-label">Login Email</label>
    <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" value="{{ old('email',$email ?? '') }}">
</div>
<div class="mb-3">
    <label for="password" class="form-label">Login Password</label>
    <input type="password" class="form-control" id="password" name="password">
</div>

<button type="submit" class="btn btn-primary mb-3">{{ $submit }}</button>
