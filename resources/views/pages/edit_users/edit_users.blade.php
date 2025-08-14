@extends('layouts.admin_organizer')

@section('content2')



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
                                                User_id
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        User name
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Email
                                    </th>

                                    <th scope="col"
                                        class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        Role
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

                                @foreach ($users as $user)
                                <tr class=" border-t-2">
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap text-center">{{ $numberEvent++ }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap text-center">{{ $user->id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">{{ $user->role }}</td> {{-- getRoleNames()[0] --}}
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">@include('pages.edit_users.components.update_user')</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap"> @include('pages.edit_users.components.delete')</td>
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
