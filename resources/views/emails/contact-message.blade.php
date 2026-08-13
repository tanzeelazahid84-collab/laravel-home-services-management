<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif;">
    <h2>New Contact Message</h2>
    <p><strong>Name:</strong> {{ $contactQuery->name }}</p>
    <p><strong>Email:</strong> {{ $contactQuery->email }}</p>
    <p><strong>Subject:</strong> {{ $contactQuery->subject }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $contactQuery->message }}</p>
</body>
</html>