<x-app-layout>
  
  {{-- TODO::we can configure vite and load style or script through vite or public asset file, skipping for now --}}
  @include('user.partials.style')

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New User') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="{{ route('users.store') }}">
                            @csrf
                            @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div>{{$error}}</div>
                            @endforeach
                        @endif
                            <div class="row g-3">
                              <div class="col-md-6">
                                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                              </div>
                              <div class="col-md-6">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                              </div>
                              <div class="col-md-6">
                                <label for="password" class="form-label">Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required>
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                              </div>
                              <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
                              </div>
                              <div class="col-md-6">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" accept="image/*" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                                @error('avatar')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                              </div>

                              <div class="col-md-12">
                                <div id="address-fields">
                                  <!-- Address fields will be appended here -->
                                  @if (count(old('addresses') ?? []))
                                      @foreach (old('addresses') as $key => $item)
                                        <div class="address-container">
                                          <textarea name="addresses[]" rows="2" cols="50">{{ $item }}</textarea>
                                          <button type="button" class="@error('addresses.' . $key) is-invalid @enderror btn btn-sm btn-danger btn-outline-danger w-40 remove-address" data-address-id="{{ $key }}">Remove</button>
                                        </div>
                                        @error('addresses.' . $key)
                                          <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                      @endforeach
                                  @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-info btn-outline-info w-40" id="add-address">Add Address</button>
                              </div>

                              <div class="col-12">
                                <div class="row">
                                  <div class="col-md-6 offset-3">
                                    <button type="submit" class="btn btn-dark btn-outline-dark w-100 fw-bold">Save</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@include('user.partials.script')
