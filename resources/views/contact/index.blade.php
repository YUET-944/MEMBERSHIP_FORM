<article class="contact active">
    <header>
        <h2 class="h2 article-title">Contact</h2>
    </header>

    <section class="contact-text">
        <p class="contact-content">Feel free to reach out to me for any inquiries or collaboration opportunities.</p>
    </section>

    <section class="contact-form">
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" name="subject" id="subject" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" id="message" class="form-input" rows="5" required></textarea>
            </div>

            <button type="submit" class="form-btn">Send Message</button>
        </form>
    </section>
</article>

<style>
    .contact-content {
        color: var(--light-gray);
        font-size: var(--fs-6);
        font-weight: var(--fw-300);
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        color: var(--white-2);
        font-size: var(--fs-6);
        font-weight: var(--fw-500);
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        background: var(--eerie-black-1);
        border: 1px solid var(--jet);
        border-radius: 8px;
        padding: 12px 16px;
        color: var(--white-2);
        font-size: var(--fs-6);
        transition: var(--transition-1);
    }

    .form-input:focus {
        border-color: var(--orange-yellow-crayola);
    }

    .form-btn {
        background: var(--bg-gradient-yellow-1);
        color: var(--smoky-black);
        font-size: var(--fs-6);
        font-weight: var(--fw-500);
        border-radius: 8px;
        padding: 12px 24px;
        border: none;
        cursor: pointer;
        transition: var(--transition-1);
    }

    .form-btn:hover {
        background: var(--bg-gradient-yellow-2);
    }
</style>