@auth
    @if (Auth::user()->role === 'admin')
        <div class="dropdown  p-4">
            <div class="flex gap-4 items-center">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    pages
                </button>

                {{-- <p class="m-0">pages-></p> --}}
                <ul class="dropdown-menu">

                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Users</a></li>
                    <li><a class="dropdown-item" href="{{ route('event_admin.index') }}">Events of users</a></li>

                    {{-- <li><a class="dropdown-item" href="{{ route('event.index') }}">create event</a></li> --}}
                </ul>
            </div>


        </div>
    @endif
@endauth
