<form action="{{ route('event.delete', $event) }}" method="post">
    @csrf
    @method('DELETE')
    <button class="bg-red-600  px-2 py-1 rounded-lg text-white">Delete</button>
</form>