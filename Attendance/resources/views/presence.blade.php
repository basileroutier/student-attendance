@extends('canevas')
@section('title', 'Presence')
@section('script')
<script src="js/presence.js" defer></script>
<link rel="stylesheet" type="text/css" href="{{url('css/presence.css')}}">
@endsection
@section('content')
    @if(count($students)===0)
        <p> Nothing to show </p>
    @else
        <div class="bg-green-500/75 shadow-lg mx-auto w-96 max-w-full text-sm pointer-events-auto bg-clip-padding rounded-lg block mb-3 absolute top-3 right-3 hidden" id="request-toast" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false">
            <div class="flex justify-between items-center py-2 px-3 bg-clip-padding border-b border-green-400 rounded-t-lg">
                <div class="font-bold text-white flex items-center">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                    </svg>
                    <p>Success</p>
                </div>
            </div>
            <div class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" id="request-text"></div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">Matricule</th>
                <th scope="col" class="py-3 px-6">Name</th>
                <th scope="col" class="py-3 px-6">Surname</th>
                <th scope="col" class="py-3 px-0">Presence</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">
                    <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$student->id}}</td>
                    <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$student->name}}</td>
                    <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$student->surname}}</td>
                    <td scope="row" class="py-4 px-0 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if($student -> is_present)
                            <input type="checkbox" name="{{ $student -> id }}" checked>
                        @else
                            <input type="checkbox" name="{{ $student -> id }}">
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" id="presence">Take presence</button>
    @endif
@endsection
