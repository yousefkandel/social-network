@extends('layouts.main')
@section('section')

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Create Post Form --}}
    @auth
    <div class="mb-5">
        <h2 class="mb-3">Create Post</h2>
        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" placeholder="Write something..." rows="3"></textarea>
            </div>
            <div class="mb-3">
                <input type="file" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>
    </div>
    @endauth

    <hr>

    {{-- All Posts --}}
    <h2 class="mb-4">All Posts</h2>

    @foreach($posts as $post)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">

                {{-- Post Author & Actions --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <strong>{{ $post->user->name }}</strong>

                        @auth
                            @if(auth()->id() !== $post->user_id)
                                @php $friendUser = $post->user; @endphp

                                @if(auth()->user()->isFriendWith($friendUser->id))
                                    <span class="badge bg-success">Friend</span>
                                @elseif(auth()->user()->hasPendingRequest($friendUser->id))
                                    <span class="badge bg-warning text-dark">Request Sent</span>
                                @elseif(auth()->user()->hasReceivedRequest($friendUser->id))
                                    <div class="btn-group btn-group-sm">
                                        @php
                                            $friendRequest = $friendUser->receivedFriendRequests()->where('sender_id', $friendUser->id)->first();
                                        @endphp
                                        @if($friendRequest)
                                            <form action="{{ route('friends.respond', [$friendRequest->id, 'accepted']) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-success btn-sm">Accept</button>
                                            </form>
                                            <form action="{{ route('friends.respond', [$friendRequest->id, 'rejected']) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        @endif
                                    </div>
                                @else
                                    {{-- زر Add Friend عبر AJAX --}}
                                    <button class="btn btn-primary btn-sm" onclick="sendFriendRequest({{ $friendUser->id }}, this)">
                                        Add Friend
                                    </button>
                                @endif
                            @endif
                        @endauth
                    </div>

                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                </div>

                {{-- Post Content --}}
                <p>{{ $post->content }}</p>
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid rounded mb-3" style="max-width:100%;">
                @endif

                {{-- Post Actions --}}
                <div class="d-flex gap-2 mb-3">
                    <form action="{{ route('posts.like', $post->id) }}" method="GET">
                        <button class="btn btn-outline-primary btn-sm">
                            Like ({{ $post->likes->count() }})
                        </button>
                    </form>

                    @auth
                        @if(auth()->id() === $post->user_id)
                            <button onclick="toggleEdit({{ $post->id }})" class="btn btn-warning btn-sm">Edit</button>

                            <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    @endauth
                </div>

                {{-- Edit Form --}}
                @auth
                @if(auth()->id() === $post->user_id)
                    <div id="edit-form-{{ $post->id }}" class="mb-3" style="display:none;">
                        <form action="{{ route('post.update', $post->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="content" class="form-control mb-2">{{ $post->content }}</textarea>
                            <button class="btn btn-success btn-sm">Save</button>
                        </form>
                    </div>
                @endif
                @endauth

                {{-- Comments Section --}}
                <hr>
                <h6>Comments ({{ $post->comments->count() }})</h6>
                @foreach($post->comments as $comment)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
                        </div>
                        @auth
                        @if(auth()->id() === $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">X</button>
                            </form>
                        @endif
                        @endauth
                    </div>
                @endforeach

                {{-- Add Comment Form --}}
                @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="content" class="form-control" placeholder="Write a comment...">
                        <button class="btn btn-primary" type="submit">Comment</button>
                    </div>
                </form>
                @endauth

            </div>
        </div>
    @endforeach

</div>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>

<script>
Pusher.logToConsole = true;

const echo = new Echo({
    broadcaster: 'pusher',
    key: '{{ env("PUSHER_APP_KEY") }}',
    cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
    forceTLS: true
});

const userId = {{ auth()->id() }};

// استقبال الإشعارات real-time
echo.private(`App.Models.User.${userId}`)
    .notification((notification) => {
        console.log('وصل إشعار جديد:', notification);
        alert(notification.sender_name + ' أرسل لك طلب صداقة!');
    });

// AJAX لإرسال طلب صداقة
function sendFriendRequest(receiverId, btn) {
    fetch(`/send-friend-request/${receiverId}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.text())
    .then(res => {
        alert(res);
        // غيّر شكل الزر بعد الإرسال
        btn.textContent = 'Request Sent';
        btn.disabled = true;
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-warning', 'text-dark');
    })
    .catch(err => console.error(err));
}

function toggleEdit(id) {
    let form = document.getElementById('edit-form-' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
</script>

@endsection
