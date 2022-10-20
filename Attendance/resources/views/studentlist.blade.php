@extends('canevas')
@section('title', 'Student list')
@section('script')
    <script src="js/student.js" defer></script>
@endsection
@section('StudentButton')
    <div class="  text-right">
        <button class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded-full content-center"
            onclick="toggleModal()">Add a Student !</button>
    </div>
@endsection
@section('content')
    @if (count($students) === 0)
        <p> Pas d'étudiant inscrit </p>
    @else
        <div class="fixed z-10 overflow-y-auto top-0 w-full left-0 hidden" id="modal">
            <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-900 opacity-75" />
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                    role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <label>Name</label>
                        <input id="name-insert" type="text" class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                        <span class="text-sm text-red-700 dark:text-red-800 error-text name_error"></span>
                        <div>
                            <label>Surname</label>
                            <input id="surname-insert" type="text" class="w-full bg-gray-100 p-2 mt-2 mb-3" />
                            <span class="text-sm text-red-700 dark:text-red-800 error-text surname_error"></span>
                        </div>

                    </div>
                    <div class="bg-gray-200 px-4 py-3 text-right">
                        <button type="button" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2"
                            onclick="toggleModal()"><i class="fas fa-times"></i> Cancel</button>
                        <button type="button" onclick="insertStudent(this)" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2"><i
                                class="fas fa-plus"></i> Create</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="bg-green-500/75 shadow-lg mx-auto w-96 max-w-full text-sm pointer-events-auto bg-clip-padding rounded-lg block mb-3 absolute top-3 right-3 hidden"
            id="request-toast" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false">
            <div class="flex justify-between items-center py-2 px-3 bg-clip-padding border-b border-green-400 rounded-t-lg">
                <div class="font-bold text-white flex items-center">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle"
                        class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z">
                        </path>
                    </svg>
                    <p>Success</p>
                </div>
            </div>
            <div class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3" id="request-text"></div>
        </div>



        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="student-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">Matricule</th>
                    <th scope="col" class="py-3 px-6">Name</th>
                    <th scope="col" class="py-3 px-6">Surname</th>
                    <th scope="col" class="py-3 px-0"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr class=" bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">
                        <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $student->id }}</td>
                        <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $student->name }}</td>
                        <td scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $student->surname }}</td>
                        <td scope="row" class="py-4 px-0 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                            <button onclick="deleteStudent(this)" data-id="{{ $student->id }}"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-0.5 px-3 rounded-full content-center">Delete</button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{-- <div class="mt-2 grid grid-cols-3 " id="add-student">
            <div class="flex flex-col">
                <input id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mr-2"
                    type="text" placeholder="Prénom">
                <span class="text-sm text-red-700 dark:text-red-800 error-text name_error"></span>
            </div>

            <div class="flex flex-col ">
                <input id="surname"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mr-2"
                    type="text" placeholder="Nom">
                <span class="text-sm text-red-700 dark:text-red-800 error-text surname_error"></span>
            </div>




            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded-full content-center"
                onclick="insertStudent(this)">Insérer</button>
            </form>

        </div> --}}




    @endif
@endsection
