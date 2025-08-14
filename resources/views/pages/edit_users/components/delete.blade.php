<form action="{{ route('user.delete' , $user) }}" method="post">
    @csrf
    @method('DELETE')
    
    <button {{ $user->role == "admin" ? 'disabled' : ""  }} class=" bg-danger text-light  my-1 px-3 py-2 rounded-lg cursor-not-allowed">Delete</button>
</form>