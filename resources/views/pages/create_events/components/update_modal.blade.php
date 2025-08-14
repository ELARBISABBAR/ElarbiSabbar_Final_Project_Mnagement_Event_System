<!-- Button trigger modal -->
<button id="buttonModal{{$event->id }}" type="button" class="btn btn-primary my-1 px-2 py-1 rounded-lg" data-bs-toggle="modal" data-bs-target="#{{$event->id  }}">
    Update
</button>

<!-- Modal -->
<div class="modal fade" id="{{ $event->id  }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">update Event</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('event.update' , $event )}}"  class="flex flex-col gap-2"
                    enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    {{-- title --}}
                    <label for="">Title</label>
                    <input value="{{ old('title', $event->title) }}" name="title" type="text" class="w-full rounded-xl border-2 border-black p-2"
                        placeholder="insert event title">
                    {{-- description --}}
                    <label for="">Description </label>
                        <textarea name="description"  placeholder="add description ..." type="text"
                        class="w-full rounded-xl border-2 border-black p-2">{{ old('description', $event->description) }}</textarea>
                    <div class="flex gap-2">
                        <div class="w-[100%] flex flex-col">
                            {{-- start date --}}
                            <label for="">start date </label>
                            <input min="{{ date('Y-m-d h:m') }}"  value="{{ old('date_start', $event->date_start) }}"  type="datetime-local"
                                name="date_start" id="start-Date" class="w-full rounded-xl border-2 border-black p-2">
                        </div>
                        <div class="w-[100%] flex flex-col">
                            {{-- end date --}}
                            <label for="">end date</label>
                            <input type="datetime-local" name="date_end" id="end-Date"
                                class="w-full rounded-xl border-2 border-black p-2" value="{{ old('date_end', $event->date_end) }}">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <div class="w-[100%] flex flex-col">
                            {{-- price --}}
                            <label for="">Price </label>
                            <input name="price" placeholder="Price" type="number" value="{{ old('price', $event->price) }}"
                                class="w-full rounded-xl border-2 border-black p-2" placeholder="name's task">
                        </div>
                        <div class="w-[100%] flex flex-col">
                            {{-- location --}}
                            <label for="">location</label>
                            <input name="location" placeholder="location" type="text" value="{{ old('location', $event->location) }}"
                                class="w-full rounded-xl border-2 border-black p-2">
                        </div>
                    </div>
                    {{-- picture --}}
                    <label for="">Add picture</label>
                    <input name="image" type="file" class="w-full rounded-xl border-2 border-black p-2">
                    {{-- submit --}}
                    <input type="submit" class="bg-blue-500 px-2 py-1 rounded-xl" value="save">
                </form>
            </div>

        </div>
    </div>
</div>
