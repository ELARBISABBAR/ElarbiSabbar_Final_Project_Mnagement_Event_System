@extends('layouts.admin_organizer')
@section('content2')
    <section class="container  mx-auto mb-10">
        <div class="flex flex-col items-center">
            <div class=" -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-[100%]">
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
                                        User_name
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Event_id
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                                    <tr class=" border-t-2">
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            {{ $numberEvent++ }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            {{ $event->user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            {{ $event->id }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            {{ $event->title }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            {{ $event->location }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            {{ $event->price }} MAD</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            {{ $event->date_start }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            @include('pages.create_events.components.update_modal')</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                            @include('pages.create_events.components.delete')</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
