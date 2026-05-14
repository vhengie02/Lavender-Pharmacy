<section id="services" class="bg-secondary/30 py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto mb-16 max-w-3xl text-center">
            <p class="mb-2 text-sm font-medium uppercase tracking-wide text-primary">Our Services</p>
            <h2 class="font-serif text-3xl font-bold tracking-tight text-foreground sm:text-4xl lg:text-5xl">Comprehensive Care for Your Wellness</h2>
            <p class="mt-4 text-lg leading-relaxed text-muted-foreground">
                From prescription filling to health consultations, we offer a complete range of pharmacy services designed to support your health journey every step of the way.
            </p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['Prescription Filling', 'Quick and accurate prescription fulfillment with expert pharmacist consultation.'],
                ['Health Consultations', 'One-on-one consultations with our licensed pharmacists about your medications.'],
                ['Home Delivery', 'Delivery for prescriptions and health products within the local area.'],
                ['Immunizations', 'Vaccination services including flu shots and travel vaccines.'],
                ['Health Monitoring', 'Blood pressure, glucose, and cholesterol screenings.'],
                ['Compounding', 'Custom medication preparations tailored to your specific needs.'],
            ] as [$title, $desc])
                <div class="group rounded-xl border border-border bg-card p-6 shadow-sm transition-all duration-300 hover:border-primary/30 hover:shadow-lg hover:shadow-primary/5">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 transition-colors group-hover:bg-primary/20">
                        <svg class="h-6 w-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0 1 12 15a9.065 9.065 0 0 0-6.23-.693L5 14.5m14.8.8 1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0 1 12 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-card-foreground">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted-foreground">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
