<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test Friend Request Notifications</title>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
</head>
<body>
    <h1>اختبار إشعارات طلب الصداقة</h1>

    <p>المستخدم الحالي: {{ auth()->user()->name }}</p>

    <h3>قائمة المستخدمين:</h3>
    <ul>
        @foreach (\App\Models\User::all() as $user)
            @if($user->id !== auth()->id())
                <li>
                    {{ $user->name }}
                    <button onclick="sendFriendRequest({{ $user->id }})">إرسال طلب صداقة</button>
                </li>
            @endif
        @endforeach
    </ul>

    <script>
        Pusher.logToConsole = true;

        const echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env("PUSHER_APP_KEY") }}',
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            forceTLS: true
        });

        // ID المستخدم الحالي
        const userId = {{ auth()->id() }};

        echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log('وصل إشعار جديد:', notification);
                alert(notification.sender_name + ' أرسل لك طلب صداقة!');
            });

        function sendFriendRequest(receiverId) {
            fetch(`/send-friend-request/${receiverId}`)
                .then(res => res.text())
                .then(res => alert(res))
                .catch(err => console.error(err));
        }
    </script>
</body>
</html>
