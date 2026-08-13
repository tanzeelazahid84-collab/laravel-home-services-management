<div style="font-family: sans-serif; color: #111">
    <p>Hi {{ $contactQuery->name }},</p>

    <p>{{ $replyMessage }}</p>

    <hr>

    <p><strong>Your original message:</strong></p>
    <p><em>{{ $contactQuery->subject }}</em></p>
    <p>{{ $contactQuery->message }}</p>

    <p>— {{ $adminName }}</p>
</div>
