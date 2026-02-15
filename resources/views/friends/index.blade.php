@extends('layouts.main')
@section('section')

<div class="container py-5">
  @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="mb-4 fw-bold text-center">Friends</h2>

            {{-- ================= Friends List ================= --}}
            <div class="card border-0 shadow-lg mb-5">
                <div class="card-header bg-success text-white fw-semibold">
                    My Friends ({{ $friends->count() }})
                </div>

                <div class="card-body">

                    @forelse($friends as $friend)
                        <div class="d-flex justify-content-between align-items-center py-2">

                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center"
                                     style="width:45px;height:45px;">
                                    <i class="bi bi-person-fill text-secondary"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">
                                        {{ $friend->name }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $friend->email }}
                                    </small>
                                </div>
                            </div>

                        </div>

                        @if(!$loop->last)
                            <hr class="my-2">
                        @endif

                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">
                                You have no friends yet.
                            </p>
                        </div>
                    @endforelse

                </div>
            </div>


            {{-- ================= Pending Requests ================= --}}
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-warning fw-semibold">
                    Pending Requests ({{ $pending->count() }})
                </div>

                <div class="card-body">

                    @forelse($pending as $request)

                        <div class="d-flex justify-content-between align-items-center py-2">

                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center"
                                     style="width:45px;height:45px;">
                                    <i class="bi bi-person-plus-fill text-secondary"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">
                                        {{ $request->sender->name }}
                                    </div>
                                    <small class="text-muted">
                                        sent you a friend request
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex gap-2">

                                {{-- Accept --}}
                                <form action="{{ route('friends.respond', [$request->id, 'accepted']) }}"
                                      method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm px-3">
                                        Accept
                                    </button>
                                </form>

                                {{-- Reject --}}
                                <form action="{{ route('friends.respond', [$request->id, 'rejected']) }}"
                                      method="POST">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm px-3">
                                        Reject
                                    </button>
                                </form>

                            </div>

                        </div>

                        @if(!$loop->last)
                            <hr class="my-2">
                        @endif

                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">
                                No pending requests.
                            </p>
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
