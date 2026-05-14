import { Button } from "@/components/ui/button"
import { ArrowRight, Shield, Clock, Heart } from "lucide-react"

export function Hero() {
  return (
    <section id="home" className="relative min-h-screen flex items-center pt-16">
      {/* Background Pattern */}
      <div className="absolute inset-0 overflow-hidden">
        <div className="absolute -top-40 -right-40 h-[500px] w-[500px] rounded-full bg-primary/10 blur-3xl" />
        <div className="absolute -bottom-40 -left-40 h-[500px] w-[500px] rounded-full bg-accent/20 blur-3xl" />
      </div>

      <div className="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
        <div className="grid gap-12 lg:grid-cols-2 lg:gap-8 items-center">
          {/* Content */}
          <div className="max-w-2xl">
            <div className="mb-6 inline-flex items-center rounded-full bg-primary/10 px-4 py-1.5 text-sm font-medium text-primary">
              <span className="mr-2">✨</span>
              Trusted by 10,000+ families
            </div>
            
            <h1 className="font-serif text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
              <span className="text-foreground">Your Health,</span>
              <br />
              <span className="text-primary">Our Priority</span>
            </h1>
            
            <p className="mt-6 text-lg leading-relaxed text-muted-foreground">
              At Lavender Pharmacy, we believe in providing more than just medications. 
              We offer personalized care, expert guidance, and a warm smile with every visit. 
              Your wellness journey starts here.
            </p>

            <div className="mt-8 flex flex-col sm:flex-row gap-4">
              <Button size="lg" className="gap-2">
                View Our Services
                <ArrowRight className="h-4 w-4" />
              </Button>
              <Button size="lg" variant="outline">
                Contact Us
              </Button>
            </div>

            {/* Trust Indicators */}
            <div className="mt-12 grid grid-cols-3 gap-6">
              <div className="flex flex-col items-center text-center sm:items-start sm:text-left">
                <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                  <Shield className="h-5 w-5 text-primary" />
                </div>
                <p className="mt-2 text-sm font-medium text-foreground">Licensed</p>
                <p className="text-xs text-muted-foreground">Certified Pharmacists</p>
              </div>
              <div className="flex flex-col items-center text-center sm:items-start sm:text-left">
                <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                  <Clock className="h-5 w-5 text-primary" />
                </div>
                <p className="mt-2 text-sm font-medium text-foreground">24/7</p>
                <p className="text-xs text-muted-foreground">Always Available</p>
              </div>
              <div className="flex flex-col items-center text-center sm:items-start sm:text-left">
                <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10">
                  <Heart className="h-5 w-5 text-primary" />
                </div>
                <p className="mt-2 text-sm font-medium text-foreground">Care</p>
                <p className="text-xs text-muted-foreground">Personalized Service</p>
              </div>
            </div>
          </div>

          {/* Hero Image */}
          <div className="relative hidden lg:block">
            <div className="relative aspect-square">
              {/* Decorative Elements */}
              <div className="absolute inset-0 rounded-full bg-gradient-to-br from-primary/20 to-accent/30" />
              <div className="absolute inset-8 rounded-full bg-gradient-to-tr from-lilac to-lavender-light flex items-center justify-center">
                {/* Lavender Illustration */}
                <svg
                  viewBox="0 0 200 300"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                  className="h-64 w-auto"
                >
                  {/* Main Stem */}
                  <path
                    d="M100 290 Q105 200 100 100"
                    stroke="currentColor"
                    strokeWidth="4"
                    fill="none"
                    className="text-primary/60"
                  />
                  {/* Left Leaves */}
                  <path
                    d="M100 250 Q70 240 60 260 Q80 265 100 250"
                    fill="currentColor"
                    className="text-primary/50"
                  />
                  <path
                    d="M100 210 Q65 195 55 220 Q75 230 100 210"
                    fill="currentColor"
                    className="text-primary/50"
                  />
                  {/* Right Leaves */}
                  <path
                    d="M100 230 Q130 220 140 240 Q120 250 100 230"
                    fill="currentColor"
                    className="text-primary/50"
                  />
                  <path
                    d="M100 190 Q135 175 145 200 Q125 215 100 190"
                    fill="currentColor"
                    className="text-primary/50"
                  />
                  {/* Lavender Petals */}
                  <ellipse cx="100" cy="85" rx="12" ry="18" fill="currentColor" className="text-primary" />
                  <ellipse cx="88" cy="70" rx="10" ry="16" fill="currentColor" className="text-primary/90" />
                  <ellipse cx="112" cy="70" rx="10" ry="16" fill="currentColor" className="text-primary/90" />
                  <ellipse cx="100" cy="55" rx="10" ry="15" fill="currentColor" className="text-primary/85" />
                  <ellipse cx="90" cy="42" rx="8" ry="13" fill="currentColor" className="text-primary/80" />
                  <ellipse cx="110" cy="42" rx="8" ry="13" fill="currentColor" className="text-primary/80" />
                  <ellipse cx="100" cy="28" rx="8" ry="12" fill="currentColor" className="text-primary/75" />
                  <ellipse cx="94" cy="16" rx="6" ry="10" fill="currentColor" className="text-primary/70" />
                  <ellipse cx="106" cy="16" rx="6" ry="10" fill="currentColor" className="text-primary/70" />
                  <ellipse cx="100" cy="6" rx="4" ry="8" fill="currentColor" className="text-primary/60" />
                </svg>
              </div>
              {/* Floating Elements */}
              <div className="absolute top-10 right-10 h-16 w-16 rounded-full bg-primary/20 animate-pulse" />
              <div className="absolute bottom-20 left-5 h-12 w-12 rounded-full bg-accent/30 animate-pulse delay-500" />
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
