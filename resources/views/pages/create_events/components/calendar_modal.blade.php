<!-- Button trigger modal -->
<div class="max-[430px]:block hidden">
    <button id="buttonModal" type="button" class="btn btn-primary w-[26vw] p-0 py-2 m-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
        add event
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Event</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('event.post') }}" method="post" class="flex flex-col gap-2"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- title --}}
                    <label for="">Title</label>
                    <input name="title" type="text" required class="w-full rounded-xl border-2 border-black p-2"
                        placeholder="insert event title">
                    {{-- description --}}
                    <label for="">Description </label>
                        <textarea name="description" placeholder="add description ..." type="text"
                        class="w-full rounded-xl border-2 border-black p-2"></textarea>
                    <div class="flex gap-2 max-[430px]:flex-col">
                        <div class="w-[100%]">
                            {{-- start date --}}
                            <label for="">start date </label>
                            <input min="{{ date('Y-m-d h:m') }}" required value="{{ date('Y-m-d') }}" type="datetime-local"
                                name="date_start" id="start-Date" class="w-full rounded-xl border-2 border-black p-2">
                        </div>
                        <div class="w-[100%]">
                            {{-- end date --}}
                            <label for="">end date</label>
                            <input type="datetime-local" required name="date_end" id="end-Date"
                                class="w-full rounded-xl border-2 border-black p-2">
                        </div>
                    </div>
                    <div class="flex gap-2 max-[430px]:flex-col">
                        <div class="w-[100%]">
                            {{-- price --}}
                            <label for="">Price </label>
                            <input name="price" required placeholder="Price" type="number"
                                class="w-full rounded-xl border-2 border-black p-2" placeholder="name's task">
                        </div>
                        <div class="w-[100%]">
                            {{-- location --}}
                            <label for="">location</label>
                            <input name="location" placeholder="location" required type="text"
                                class="w-full rounded-xl border-2 border-black p-2">
                        </div>
                    </div>
                    {{-- picture --}}
                    <label for="">Add picture</label>
                    <input name="image" type="file" required class="w-full rounded-xl border-2 border-black p-2">
                    {{-- submit --}}
                    <input type="submit" class="bg-blue-500 px-2 py-1 rounded-xl" value="save">
                </form>
            </div>

        </div>
    </div>
</div>
