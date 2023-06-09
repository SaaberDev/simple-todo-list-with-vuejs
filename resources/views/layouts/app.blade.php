<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Simple Todo Application') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{--<script>
            function app(){
                return {
                    todos: [],
                    focusItem: function(index) {
                        if ( !this.todos[index].open ) {
                            for(let i = 0; i < this.todos.length; i++){
                                this.todos[i].open = false;
                                this.todos[i].focused = i == index;
                            }
                        }
                    },
                    openItem: function(index) {
                        for(let i = 0; i < this.todos.length; i++){
                            this.todos[i].focused = false;
                            this.todos[i].open = i == index;
                        }
                        setTimeout(()=>document.getElementById(`titleField${index}`).focus(),10);
                    },
                    defocusItems: function() {
                        for(let i = 0; i < this.todos.length; i++){
                            this.todos[i].focused = false;
                            this.todos[i].open = false;
                        }
                    },
                    removeItem: function(index) {
                        this.todos = this.todos.filter((todo, i) => {
                            return i == index ? false : true;
                        });
                        setTimeout(()=>this.defocusItems(),10);
                    },
                    addItem: function() {
                        this.todos.push({
                            title: '',
                            notes: '',
                            checked: false,
                            focused: false,
                            open: false
                        });
                        setTimeout(()=>this.openItem(this.todos.length-1),10);
                    }
                }
            }
        </script>--}}
    </body>
</html>
