@extends('layouts.index')
@section('content')
    <div class=" flex flex-col ">

        @include('pages.create_events.components.calendar_modal')
        <div class="p-4"> @include('pages.create_events.components.sidebare')</div>


     


            <section class="container  mx-auto mb-10">
                <div class="flex flex-col items-center">
                    <div class=" -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-[85%]">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 ">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 px-4 text-sm font-normal text-center rtl:text-right text-gray-500 dark:text-gray-400">
                                                #
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-4 text-sm font-normal text-center rtl:text-right text-gray-500 dark:text-gray-400">
                                                Title
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Location
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Price
                                            </th>

                                            <th scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Date
                                            </th>

                                            <th scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Update
                                            </th>
                                            <th scope="col"
                                                class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                Delete
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">


                                        @foreach ($events as $event)
                                        @if ($event->user_id == Auth::user()->id)
                                            <tr class=" border-t-2">
                                                <td  class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ $numberEvent++ }}</td>
                                                <td  class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ $event->title }}</td>
                                                <td  class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ $event->location }}</td>
                                                <td  class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ $event->price }} MAD</td>
                                                <td  class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ $event->date_start }}</td>
                                                <td  class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">@include('pages.create_events.components.update_modal')</td>
                                                <td  class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">@include('pages.create_events.components.delete')</td>
                                            </tr>
                                        @endif
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>








        <script>
            document.addEventListener('DOMContentLoaded', async function() {
                const {
                    data
                } = await axios.get(`/calendar/events`)
                console.log(data);
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    headerToolbar: {
                        left: 'dayGridMonth,timeGridWeek,timeGridDay',
                        center: 'title',
                        right: 'listMonth,listWeek,listDay'
                    },
                    views: {
                        listDay: { // Customize the name for listDay
                            buttonText: 'Day Events',
                        },
                        listWeek: { // Customize the name for listWeek
                            buttonText: 'Week Events'
                        },
                        listMonth: { // Customize the name for listMonth
                            buttonText: 'Month Events'
                        },
                        timeGridWeek: {
                            buttonText: 'Week', // Customize the button text
                        },
                        timeGridDay: {
                            buttonText: "Day",
                        },
                        dayGridMonth: {
                            buttonText: "Month",
                        },
                    },
                    initialView: "timeGridWeek",
                    slotMinTime: "09:00:00", // min  time  appear in the calendar
                    slotMaxTime: "18:00:00",
                    nowIndicator: true,
                    selectable: true,
                    selectMirror: true,
                    selectOverlap: true,
                    weekends: true,
                    // editable: true,
                    events: data,
                    selectAllow: (info) => {
                        let instant = new Date()
                        return info.start > instant
                    },
                    select: (info) => {
                        let start = info.start
                        let end = info.end
                        console.log(info);
                        // if (end.getDate()-start.getDate() >=1 && !info.allDay) {
                        //     alert('khditi bzaf dial lwa9t')
                        //     calendar.unselect()
                        //     return
                        // }
                        // fblast matkhdam b hadi :
                        // document.getElementById('buttonModal ').click()
                        // khdam bhadi la bghity  :
                        buttonModal.click()
                        document.getElementById('start-Date').value = formatDate(start)
                        document.getElementById('end-Date').value = formatDate(end)
                    }
                });
                calendar.render();

                function formatDate(date) {
                    let year = String(date.getFullYear())
                    let month = String(date.getMonth() + 1).padStart(2, 0)
                    let day = String(date.getDate()).padStart(2, 0)
                    let hour = String(date.getHours()).padStart(2, 0)
                    let min = String(date.getMinutes()).padStart(2, 0)
                    let sec = String(date.getSeconds()).padStart(2, 0)
                    return `${year}-${month}-${day} ${hour}:${min}:${sec}`
                }
            });
        </script>
    </div>
@endsection
