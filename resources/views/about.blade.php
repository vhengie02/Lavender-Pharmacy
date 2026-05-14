@extends('layouts.storefront')

@section('title', 'About Us - Lavender Pharmacy')

@section('content')
    <section class="relative bg-gradient-to-b from-primary/10 to-background pb-20 pt-32">
        <div class="container mx-auto px-4">
            <div class="mx-auto max-w-3xl text-center">
                <div class="mb-6 flex justify-center">
                    <x-storefront-logo class="h-16 w-auto" />
                </div>
                <h1 class="mb-6 text-balance font-serif text-4xl font-bold text-foreground md:text-5xl">About Lavender Pharmacy</h1>
                <p class="text-pretty text-lg text-muted-foreground">
                    For over a decade, Lavender Pharmacy has been a trusted healthcare partner in our community.
                    We combine traditional pharmaceutical care with modern convenience to serve you better.
                </p>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="mx-auto grid max-w-5xl gap-8 md:grid-cols-2">
                <div class="rounded-xl border border-primary/20 bg-primary/5 p-8">
                    <h2 class="mb-4 font-serif text-2xl font-bold text-foreground">Our Mission</h2>
                    <p class="leading-relaxed text-muted-foreground">
                        To provide accessible, affordable, and high-quality pharmaceutical services while
                        treating every patient with compassion and respect. We aim to be more than just a
                        pharmacy – we strive to be your trusted health partner.
                    </p>
                </div>
                <div class="rounded-xl border border-accent/50 bg-accent/30 p-8">
                    <h2 class="mb-4 font-serif text-2xl font-bold text-foreground">Our Vision</h2>
                    <p class="leading-relaxed text-muted-foreground">
                        To be the leading community pharmacy known for exceptional patient care, innovative
                        health solutions, and unwavering commitment to improving the health and wellness
                        of every individual we serve.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-muted/30 py-20">
        <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="mb-4 font-serif text-3xl font-bold text-foreground">Our Core Values</h2>
                <p class="mx-auto max-w-2xl text-muted-foreground">These principles guide everything we do at Lavender Pharmacy</p>
            </div>
            <div class="mx-auto grid max-w-6xl gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ([
                    ['title' => 'Patient-Centered Care', 'body' => 'Every decision we make is guided by what is best for our patients and their health outcomes.'],
                    ['title' => 'Trust & Integrity', 'body' => 'We maintain the highest standards of honesty and transparency in all our interactions.'],
                    ['title' => 'Community Focus', 'body' => 'We are deeply committed to serving and supporting our local community\'s health needs.'],
                    ['title' => 'Excellence', 'body' => 'We strive for excellence in pharmaceutical care, continuously improving our services.'],
                    ['title' => 'Accessibility', 'body' => 'Healthcare should be accessible to all. We offer extended hours and delivery services.'],
                    ['title' => 'Wellness Approach', 'body' => 'We believe in holistic wellness, offering preventive care and health education.'],
                ] as $v)
                    <div class="rounded-xl border border-border bg-card p-6 shadow-sm transition-shadow hover:shadow-lg">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-primary/10">
                            <span class="text-lg font-bold text-primary">✦</span>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-foreground">{{ $v['title'] }}</h3>
                        <p class="text-sm text-muted-foreground">{{ $v['body'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="mb-4 font-serif text-3xl font-bold text-foreground">Our Journey</h2>
                <p class="mx-auto max-w-2xl text-muted-foreground">Key milestones in our history of serving the community</p>
            </div>
            <div class="relative mx-auto max-w-3xl">
                <div class="absolute bottom-0 left-4 top-0 w-0.5 bg-primary/30 md:left-1/2 md:-translate-x-1/2"></div>
                @foreach ([
                    ['year' => '2010', 'event' => 'Lavender Pharmacy founded with a single location'],
                    ['year' => '2013', 'event' => 'Launched 24/7 emergency prescription services'],
                    ['year' => '2016', 'event' => 'Introduced free home delivery for seniors'],
                    ['year' => '2019', 'event' => 'Opened compounding pharmacy division'],
                    ['year' => '2022', 'event' => 'Achieved 50,000+ satisfied customers milestone'],
                    ['year' => '2024', 'event' => 'Launched online pharmacy platform'],
                ] as $i => $m)
                    <div class="relative mb-8 flex items-center {{ $i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }}">
                        <div class="flex-1 pl-12 md:pl-0 {{ $i % 2 === 0 ? 'md:pr-8 md:text-right' : 'md:pl-8' }}">
                            <div class="inline-block rounded-xl border border-border bg-card p-4">
                                <span class="text-lg font-bold text-primary">{{ $m['year'] }}</span>
                                <p class="mt-1 text-sm text-muted-foreground">{{ $m['event'] }}</p>
                            </div>
                        </div>
                        <div class="absolute left-4 z-10 h-3 w-3 rounded-full bg-primary md:left-1/2 md:-translate-x-1/2"></div>
                        <div class="hidden flex-1 md:block"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-muted/30 py-20">
        <div class="container mx-auto px-4">
            <div class="mb-12 text-center">
                <h2 class="mb-4 font-serif text-3xl font-bold text-foreground">Meet Our Team</h2>
                <p class="mx-auto max-w-2xl text-muted-foreground">Dedicated professionals committed to your health and wellness</p>
            </div>
            <div class="mx-auto grid max-w-6xl gap-6 md:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['name' => 'Dr. Maria Santos', 'role' => 'Chief Pharmacist', 'desc' => '25+ years of pharmaceutical experience'],
                    ['name' => 'John Rivera', 'role' => 'Operations Manager', 'desc' => 'Ensuring smooth daily operations'],
                    ['name' => 'Dr. Ana Cruz', 'role' => 'Clinical Pharmacist', 'desc' => 'Specializing in patient consultations'],
                    ['name' => 'Miguel Reyes', 'role' => 'Inventory Manager', 'desc' => 'Managing our extensive product catalog'],
                ] as $member)
                    @php($initials = collect(explode(' ', $member['name']))->map(fn ($n) => $n[0] ?? '')->implode(''))
                    <div class="rounded-xl border border-border bg-card p-6 text-center shadow-sm transition-shadow hover:shadow-lg">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-primary to-accent">
                            <span class="text-xl font-bold text-primary-foreground">{{ $initials }}</span>
                        </div>
                        <h3 class="font-semibold text-foreground">{{ $member['name'] }}</h3>
                        <p class="text-sm font-medium text-primary">{{ $member['role'] }}</p>
                        <p class="mt-2 text-sm text-muted-foreground">{{ $member['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="container mx-auto max-w-4xl px-4 text-center">
            <h2 class="mb-4 font-serif text-3xl font-bold text-foreground">Licensed & Certified</h2>
            <p class="mb-8 text-muted-foreground">Lavender Pharmacy is fully licensed and certified to provide pharmaceutical services</p>
            <div class="flex flex-wrap justify-center gap-4">
                @foreach (['FDA Licensed', 'DOH Registered', 'PhilHealth Accredited', 'ISO 9001 Certified'] as $tag)
                    <span class="rounded-full bg-primary/10 px-6 py-3 font-medium text-primary">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
    </section>
@endsection
