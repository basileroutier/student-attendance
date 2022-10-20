<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>


    @vite('resources/css/app.css')
    @yield('script')
</head>

<body class="md:container md:mx-auto  content bg-gray-900">
    <nav class=" bg-white shadow dark:bg-gray-800">
        <div class="grid grid-cols-3 items-center p-3 mx-auto text-gray-600 capitalize dark:text-gray-300">
            <div class="container flex  ">
                <img src="/image/Logo-esi.png" class="mr-3 h-6 sm:h-10" alt="Logo ESI HE2B">
                <a class="text-1xl font-bold text-gray-800 dark:text-white lg:text-3xl hover:text-gray-700 dark:hover:text-gray-300"
                    href="{{ route('accueil') }}">ESI-Attendance</a>
            </div>
            <div class="container flex  ">
                <a href="{{ route('accueil') }}"
                    class="border-b-2 border-transparent text-gray-800 dark:text-gray-200  hover:border-blue-500 mx-1.5 sm:mx-6">Home</a>

                <a href="{{ route('presence') }}"
                    class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-blue-500 mx-1.5 sm:mx-6">Presences
                    List</a>

                <a href="{{ route('students') }}"
                    class="border-b-2 border-transparent hover:text-gray-800 dark:hover:text-gray-200 hover:border-blue-500 mx-1.5 sm:mx-6">Student
                    List</a>

            </div>
            @yield('StudentButton')

        </div>
    </nav>



    @yield('content')

</body>

</html>





{{-- <h1 class="mb-1 bg-gray-700"> --}}
{{-- <a href="{{route('accueil')}}" class="text-2xl dark:bg-sky-700 hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 " id="Accueil">ESI - Attendance</a> --}}
{{-- <a class="text-2xl dark:bg-sky-700 hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300  " href="{{route('presence')}} " >Presences List</a> --}}
{{-- <a class="text-2xl dark:bg-sky-700 hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300  " href="{{route('students')}}">Students List</a> --}}

{{-- </h1> --}}
