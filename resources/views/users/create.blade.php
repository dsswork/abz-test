<x-layout title="Create User">
    <div class="col-md-6">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add User</h3>
            </div>
            <form class="card-body"
                  action="{{ route('users.store') }}"
                  method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" class="form-control"
                           value="{{ old('name') }}">
                    @error('name')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input id="phone" type="text" name="phone" class="form-control"
                           value="{{ old('phone') }}">
                    @error('phone')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control"
                           value="{{ old('email') }}">
                    @error('email')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="customFile">Photo</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="photo" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    @error('photo')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <x-position-select/>
                <button class="btn btn-success">Add User</button>
            </form>
        </div>
    </div>
</x-layout>
