<footer class="border-t border-border bg-secondary/50">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <x-storefront-logo class="h-12 w-auto" />
                <p class="mt-4 leading-relaxed text-muted-foreground">
                    Your trusted partner in health and wellness. Providing quality pharmaceutical care to our community since 2004.
                </p>
                <div class="mt-6 flex gap-4">
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary transition-colors hover:bg-primary hover:text-primary-foreground" aria-label="Facebook">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary transition-colors hover:bg-primary hover:text-primary-foreground" aria-label="Instagram">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    </a>
                    <a href="#" class="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 text-primary transition-colors hover:bg-primary hover:text-primary-foreground" aria-label="Twitter">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                </div>
            </div>
            <div class="grid gap-8 sm:grid-cols-3 lg:col-span-3">
                <div>
                    <h3 class="mb-4 font-semibold text-foreground">Services</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-muted-foreground transition-colors hover:text-primary">Prescription Filling</a></li>
                        <li><a href="#" class="text-muted-foreground transition-colors hover:text-primary">Health Consultations</a></li>
                        <li><a href="#" class="text-muted-foreground transition-colors hover:text-primary">Home Delivery</a></li>
                        <li><a href="#" class="text-muted-foreground transition-colors hover:text-primary">Immunizations</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 font-semibold text-foreground">Company</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('home') }}#about" class="text-muted-foreground transition-colors hover:text-primary">About Us</a></li>
                        <li><a href="{{ route('home') }}#contact" class="text-muted-foreground transition-colors hover:text-primary">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 font-semibold text-foreground">Support</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="text-muted-foreground transition-colors hover:text-primary">FAQ</a></li>
                        <li><a href="#" class="text-muted-foreground transition-colors hover:text-primary">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-border py-6 sm:flex-row">
            <p class="text-sm text-muted-foreground">&copy; {{ date('Y') }} Lavender Pharmacy. All rights reserved.</p>
            <p class="text-sm text-muted-foreground">Made with care for your wellness</p>
        </div>
    </div>
</footer>
