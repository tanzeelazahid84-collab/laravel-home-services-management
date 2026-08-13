<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\ContactQuery;
use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;

new #[Layout('layouts::customer')] #[Title('Contact')] class extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';
    public $sent = false;

    public function submit()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contactQuery = ContactQuery::create($validated);

        Mail::to('tanzeelazahid84@gmail.com')->send(new ContactMessageMail($contactQuery));

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->sent = true;
    }
}; ?>

<div>
    <div class="page-title dark-background" data-aos="fade">
        <div class="container position-relative">
            <h1>Contact</h1>
            <p>We'd love to hear from you</p>
        </div>
    </div>

    <section id="contact" class="contact section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">

                <div class="col-lg-4">
                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                        <i class="bi bi-geo-alt flex-shrink-0"></i>
                        <div>
                            <h3>Address</h3>
                            <p>Lahore, Pakistan</p>
                        </div>
                    </div>

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                        <i class="bi bi-telephone flex-shrink-0"></i>
                        <div>
                            <h3>Call Us</h3>
                            <p>+92 300 0000000</p>
                        </div>
                    </div>

                    <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
                        <i class="bi bi-envelope flex-shrink-0"></i>
                        <div>
                            <h3>Email Us</h3>
                            <p>info@homeservices.test</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    @if ($sent)
                        <div class="alert alert-success">Your message has been sent. Thank you!</div>
                    @endif

                    <form wire:submit="submit" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <input type="text" wire:model="name" class="form-control" placeholder="Your Name">
                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <input type="email" wire:model="email" class="form-control" placeholder="Your Email">
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12">
                                <input type="text" wire:model="subject" class="form-control" placeholder="Subject">
                                @error('subject') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12">
                                <textarea wire:model="message" class="form-control" rows="6" placeholder="Message"></textarea>
                                @error('message') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 text-center">
                                <button type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>