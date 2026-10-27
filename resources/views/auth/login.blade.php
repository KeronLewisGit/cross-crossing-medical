<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
    <title>Sign in · CCMC staff desk</title>
    <meta name="robots" content="noindex">
</head>
<body class="admin stucco grid min-h-screen place-items-center px-4 py-10">
    <main class="w-full max-w-sm">
        <a href="{{ route('home') }}" class="mx-auto mb-8 flex min-h-11 w-max items-center"><x-logo tone="light" /></a>
        <form method="POST" action="{{ route('login') }}" class="a-card space-y-5 p-6 sm:p-8">
            @csrf
            <div>
                <h1 class="text-xl font-semibold">Staff desk</h1>
                <p class="mt-1 text-sm text-ink-3">Appointments, registrations, dialysis enquiries and applications. Staff only.</p>
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold" for="email">Email</label>
                <input class="a-input w-full" id="email" name="email" type="email" value="{{ old_text('email') }}" required autofocus autocomplete="username" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                <x-error for="email" />
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold" for="password">Password</label>
                <input class="a-input w-full" id="password" name="password" type="password" required autocomplete="current-password">
            </div>
            <label class="flex min-h-11 items-center gap-2 text-sm"><input type="checkbox" name="remember" value="1" class="h-5 w-5 accent-[color:var(--primary)]">Keep me signed in on this device</label>
            <button class="a-btn a-btn-primary w-full">Sign in</button>
            <p class="text-xs text-ink-3">Every opening of a patient document is logged against your account.</p>
        </form>
    </main>
</body>
</html>
