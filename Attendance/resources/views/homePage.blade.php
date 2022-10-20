@extends('canevas')
@section('title', 'ESI-Attendance HomePage')
@section('content')
<div class="ml-2 grid grid-cols-6   mx-auto mt-10">
        <a class="mr-3 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{route('presence')}}" >Presences List</a>
{{-- text-1xl bg-gray-500 hover:bg-sky-600 focus:outline-none focus:ring focus:ring-sky-300   --}}
        <a class="mr-3 bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{route('students')}}">Students List</a>
</div>

@endsection
