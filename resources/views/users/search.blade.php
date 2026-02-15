@extends('layouts.main')

@section('section')

<div class="container">
    <h4 class="mb-4">نتائج البحث عن: "{{ $query }}"</h4>

    @if($users->count())
        @foreach($users as $user)
            <div class="card mb-3 p-3 d-flex flex-row justify-content-between align-items-center">

                <div>
                    <strong>{{ $user->name }}</strong><br>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>

                <div>
                    @auth
                        @if(auth()->id() == $user->id)
                            <span class="badge bg-secondary">هذا أنت</span>

                        @elseif(auth()->user()->isFriendWith($user->id))
                            <span class="badge bg-success">أصدقاء</span>

                        @elseif(auth()->user()->hasPendingRequest($user->id))
                            <span class="badge bg-warning text-dark">تم إرسال الطلب</span>

                        @elseif(auth()->user()->hasReceivedRequest($user->id))
                            @php
                                $friendRequest = $user->sentFriendRequests()
                                    ->where('receiver_id', auth()->id())
                                    ->where('status', 'pending')
                                    ->first();
                            @endphp

                            @if($friendRequest)
                                <div class="btn-group btn-group-sm">
                                    <form action="{{ route('friends.respond', [$friendRequest->id, 'accepted']) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm">قبول</button>
                                    </form>

                                    <form action="{{ route('friends.respond', [$friendRequest->id, 'rejected']) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger btn-sm">رفض</button>
                                    </form>
                                </div>
                            @endif

                        @else
                            <form action="{{ route('friends.send', $user->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary btn-sm">
                                    إرسال طلب صداقة
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                            سجل دخول لإضافة صديق
                        </a>
                    @endauth
                </div>

            </div>
        @endforeach

    @else
        <p class="text-muted mt-3">لا يوجد نتائج</p>
    @endif
</div>

@endsection
