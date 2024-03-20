<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        <div class="card">
            <div class="card-body">
                @include('partials.flash')
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Avatar</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($deletedUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><img width="30" src="{{ $user->avatar_path }}" alt=""></td>
                            <td>
                                <a href="{{ route('deletedUsers.restore', $user->id) }}" type="button" class="btn btn-sm btn-outline-success">Restore</a>
                                <button onclick="confirmDelete('{{ $user->id }}')" type="button" class="btn btn-sm btn-outline-danger">Permanent Delete</button>
                                
                                <form id="deleteForm_{{ $user->id }}" method="POST" action="{{ route('deletedUsers.destroy', $user->id) }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-sm btn-outline-danger" value="Delete">
                                </form>
                            </td>
                            
                        </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5">No data found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $deletedUsers->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    function confirmDelete(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            document.getElementById('deleteForm_' + userId).submit();
        }
    }
</script>