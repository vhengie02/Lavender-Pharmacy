<section id="about" class="py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="relative">
                <div class="aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-primary/20 via-accent/20 to-lavender-light">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="grid grid-cols-3 gap-8 p-8 opacity-60">
                            @for ($i = 0; $i < 6; $i++)
                                <svg viewBox="0 0 60 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-24 w-auto text-primary" style="transform: rotate({{ ($i - 2) * 10 }}deg)">
                                    <path d="M30 95 Q32 70 30 40" stroke="currentColor" stroke-width="2" fill="none" class="text-primary/60" />
                                    <ellipse cx="30" cy="35" rx="6" ry="9" fill="currentColor" />
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="absolute -bottom-6 -right-6 rounded-xl border border-border bg-card p-6 shadow-lg">
                    <p class="text-center text-4xl font-bold text-primary">20+</p>
                    <p class="text-sm text-muted-foreground">Years of Service</p>
                </div>
            </div>
            <div>
                <p class="mb-2 text-sm font-medium uppercase tracking-wide text-primary">About Us</p>
                <h2 class="font-serif text-3xl font-bold tracking-tight text-foreground sm:text-4xl">A Legacy of Care and Trust</h2>
                <p class="mt-6 text-lg leading-relaxed text-muted-foreground">
                    Founded with a vision to provide compassionate healthcare, Lavender Pharmacy has been serving our community for over two decades. We believe that every patient deserves personalized attention and expert care.
                </p>
                <p class="mt-4 leading-relaxed text-muted-foreground">
                    Our team of dedicated pharmacists and healthcare professionals are committed to going beyond just dispensing medications. We take the time to understand your needs, answer your questions, and help you achieve your health goals.
                </p>
                <ul class="mt-8 space-y-3">
                    @foreach ([
                        'Over 20 years of community service',
                        'Licensed and certified pharmacists on staff',
                        'Personalized medication management',
                        'Committed to patient education and wellness',
                    ] as $item)
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 shrink-0 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            <span class="text-foreground">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-8">
                    <a href="#catalog" class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-3 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90">Browse products</a>
                </div>
            </div>
        </div>
    </div>
</section>
