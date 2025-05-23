@section('title', 'My Notes')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                @if ($message = Session::get('success'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        {{$message}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{$message}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row py-4">
                            <div class="col-md-6">
                                <h2><a href="{{ route('my.notes') }}" class="btn btn-outline-dark">Show All Notes</a></h2>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <form method="get" action="{{ route('note.search') }}">
                                        <div class="input-group">
                                            <input class="form-control" name="search" placeholder="Search..." value="{{ old('search', $search ?? '') }}">
                                            <button type="submit" class="btn btn-dark">Search</button>
                                        </div>
                                    </form>

                                    @error('search')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>


                    @if ( count($notes) == 0)
                        <br>
                        <div class=" m-auto col-lg-6 col-md-12 alert alert-danger text-center d-flex justify-content-center">There is no notes </div>
                    @else
                        <div class="container py-6">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Note Title</th>
                                    <th scope="col">Note Create at</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($notes as $note)
                                        <tr>
                                            <th scope="row">{{$i++}}</th>
                                            <td>{{ $note->title }}</td>
                                            <td>{{ $note->created_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <a class="btn btn-outline-primary" href="{{ route('note.show', $note->slug)}}" role="button"> <i class="fa-solid fa-eye"></i> Show</a>
                                                    </div>

                                                    <div class="col-sm">
                                                        <a class="btn btn-outline-success" href="{{ route('note.edit', $note->slug)}}" role="button"> <i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                    </div>

                                                    <div class="col-sm">
                                                        {{-- <a class="btn btn-outline-danger" href="{{ route('note.softdelete', $note->slug)}}" role="button"><i class="fa-solid fa-trash"></i> Delete</a> --}}
                                                        <a class="btn btn-outline-danger delete-btn"
                                                            href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteNoteModal"
                                                            data-route = "{{route('note.softdelete', $note->slug)}}"
                                                            >
                                                            <i class="fa-solid fa-trash"></i> Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $notes->links('pagination::bootstrap-4') !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteNoteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Delete Note?</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">
                    <p>You are about to move this note to trash.</p>
                </div>

                <div class="modal-footer border-0">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">
                        Move to trash
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const deleteUrl = this.dataset.route;
                    confirmDeleteBtn.href = deleteUrl;
                });
            });
        });
    </script>

</x-app-layout>
