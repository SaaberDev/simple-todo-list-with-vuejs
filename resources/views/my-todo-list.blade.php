<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-white p-3 max-w-md mx-auto">
                        <div class="text-center">
                            <h1 class="text-3xl font-bold">My ToDo List</h1>

                            <div class="mt-8">
                                <button class="border-2 border-red-500 p-2 text-red-500">Archived Tasks</button>
                                <button class="border-2 border-indigo-500 p-2 text-indigo-500 ml-4">Completed Tasks</button>
                            </div>

                            <div class="mt-4 flex">
                                <input
                                    class="w-80 border-b-2 border-gray-500 text-black"
                                    type="text" placeholder="Enter your task here"
                                />
                                <button
                                    class="ml-2 border-2 border-green-500 p-2 text-green-500 hover:text-white hover:bg-green-500 rounded-lg flex"
                                >
                                    <svg class="h-6 w-6"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <circle cx="12" cy="12" r="9" />  <line x1="9" y1="12" x2="15" y2="12" />  <line x1="12" y1="9" x2="12" y2="15" /></svg>
                                    <span>Add</span>
                                </button>
                            </div>
                        </div>

                        <div class="mt-8">
                            <ul>
                                <li class="p-2 rounded-lg" >
                                    <div class="flex align-middle flex-row justify-between">
                                        <div class="p-2">
                                            <input type="checkbox" class="h-6 w-6 " value="true" checked/>
                                        </div>
                                        <div class="p-2">
                                            <p class="text-lg line-through text-gray-400">Cook maggie</p>
                                        </div>
                                        <button class="flex text-red-500 border-2 border-red-500 p-2 rounded-lg">
                                            <svg class="h-6 w-6 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>
                                            <span>Archive</span>
                                        </button>
                                    </div>
                                    <hr class="mt-2"/>
                                </li>
                                <li class="p-2 rounded-lg" >
                                    <div class="flex align-middle flex-row justify-between">
                                        <div class="p-2">
                                            <input type="checkbox" class="h-6 w-6 " value="true" />
                                        </div>
                                        <div class="p-2">
                                            <p class="text-lg text-black">Wash disc</p>
                                        </div>
                                        <button class="flex text-red-500 border-2 border-red-500 p-2 rounded-lg">
                                            <svg class="h-6 w-6 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>
                                            <span>Archive</span>
                                        </button>
                                    </div>
                                    <hr class="mt-2"/>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
