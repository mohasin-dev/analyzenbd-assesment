<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Details') }}
            </h2>
            
            <a href="{{ route('users.index') }}" type="button" class="btn btn-sm btn-outline-dark float-end">Back</a>
        </div>
    </x-slot>

    <div class="container mt-4">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img class="img-fluid mx-auto" src="{{ $user->avatar_path }}" width="200" alt="{{ $user->name }}">
                        <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight mt-2">
                            {{ $user->name }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight mt-2">
                            Basic Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if ($user->addresses()->count())
                    <div class="card mt-4">
                        <div class="card-header">
                            <h3 class="font-semibold text-l text-gray-800 dark:text-gray-200 leading-tight mt-2">
                                Addresses
                            </h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    @foreach ($user->addresses as $address)
                                        <tr>
                                            <td><i class="fas fa-map-marker-alt"></i> {{ $address->address }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>