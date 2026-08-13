<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\ContactQuery;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;

new #[Layout('layouts::admin')] #[Title('Contact Messages')] class extends Component
{
    public $queries;

    public $replyingQueryId = null;
    public $replySubject = '';
    public $replyMessage = '';

    public function mount()
    {
        $this->queries = ContactQuery::latest()->get();
    }

    public function openReply($id)
    {
        $query = ContactQuery::findOrFail($id);
        $this->replyingQueryId = $id;
        $this->replySubject = 'Re: ' . $query->subject;
        $this->replyMessage = '';
        $this->dispatch('open-reply-modal');
    }

    public function sendReply()
    {
        $validated = $this->validate([
            'replySubject' => 'required|string|max:255',
            'replyMessage' => 'required|string',
        ]);

        $query = ContactQuery::findOrFail($this->replyingQueryId);

        Mail::to($query->email)->send(new ContactReplyMail($query, $this->replySubject, $this->replyMessage));

        $query->status = 'replied';
        $query->save();

        $this->queries = ContactQuery::latest()->get();
        session()->flash('message', 'Reply sent successfully.');
        $this->dispatch('close-reply-modal');
    }
}; ?>

<div>
    <h3 class="page-title">Contact Messages</h3>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($queries as $query)
                            <tr>
                                <td>{{ $query->name }}</td>
                                <td>{{ $query->email }}</td>
                                <td>{{ $query->subject }}</td>
                                <td>{{ Str::limit($query->message, 60) }}</td>
                                <td>{{ $query->created_at->format('d M Y, g:i A') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="openReply({{ $query->id }})">Reply</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">No messages yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- REPLY MODAL --}}
    <div class="modal fade" id="replyModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reply to Message</h5>
                </div>
                <div class="modal-body">
                    @if (session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" class="form-control" wire:model="replySubject">
                        @error('replySubject') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" rows="6" wire:model="replyMessage"></textarea>
                        @error('replyMessage') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" wire:click="sendReply">Send Reply</button>
                </div>
            </div>
        </div>
    </div>
</div>