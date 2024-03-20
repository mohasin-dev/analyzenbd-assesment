<x-app-layout>

  {{-- TODO::we can configure vite and load script via vite --}}
  @include('user.partials.style')

    <x-slot name="header">
      <div class="d-flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>

        <a href="{{ route('users.index') }}" type="button" class="btn btn-sm btn-outline-dark float-end">Back</a>
      </div>
    </x-slot>

    <div class="container mt-4">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('patch')
                            <div class="row g-3">
                              <div class="col-md-6">
                                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                              </div>
                              <div class="col-md-6">
                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                              </div>
                              <div class="col-md-6">
                                <label for="avatar" class="form-label">Avatar</label>
                                <input type="file" accept="image/*" class="form-control" id="avatar" name="avatar">
                              </div>
                              @if($user->avatar)
                              <div class="col-md-6">
                                <img src="{{ asset('storage/' . $user->avatar) }}" width="100">
                              </div>
                              @endif

                              <div class="col-md-12">
                                <div id="address-fields">
                                  <!-- Address fields will be appended here -->
                                  @if (count(old('addresses', $user->addresses)))
                                      @foreach (old('addresses', $user->addresses) as $key => $address)
                                        <div class="address-container">
                                          <textarea name="addresses[]" rows="2" cols="50">{{ $address->address }}</textarea>
                                            <button type="button" class="btn btn-sm btn-danger btn-outline-danger w-40 remove-address" data-address-id="{{ $key }}">Remove</button>
                                        </div>
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

{{-- TODO::we can configure vite and load script via vite --}}
@include('user.partials.script')