import { Button } from "@/components/ui/button"
import { CheckCircle } from "lucide-react"

const highlights = [
  "Over 20 years of community service",
  "Licensed and certified pharmacists on staff",
  "Personalized medication management",
  "Accepted by all major insurance providers",
  "Committed to patient education and wellness",
]

export function About() {
  return (
    <section id="about" className="py-24">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div className="grid gap-12 lg:grid-cols-2 lg:gap-16 items-center">
          {/* Image Side */}
          <div className="relative">
            <div className="aspect-[4/3] rounded-2xl bg-gradient-to-br from-primary/20 via-accent/20 to-lavender-light overflow-hidden">
              <div className="absolute inset-0 flex items-center justify-center">
                {/* Decorative Lavender Pattern */}
                <div className="grid grid-cols-3 gap-8 p-8">
                  {[...Array(6)].map((_, i) => (
                    <svg
                      key={i}
                      viewBox="0 0 60 100"
                      fill="none"
                      xmlns="http://www.w3.org/2000/svg"
                      className="h-24 w-auto opacity-60"
                      style={{ transform: `rotate(${(i - 2) * 10}deg)` }}
                    >
                      <path
                        d="M30 95 Q32 70 30 40"
                        stroke="currentColor"
                        strokeWidth="2"
                        fill="none"
                        className="text-primary/60"
                      />
                      <path
                        d="M30 75 Q22 72 18 78 Q24 80 30 75"
                        fill="currentColor"
                        className="text-primary/40"
                      />
                      <path
                        d="M30 80 Q38 77 42 83 Q36 86 30 80"
                        fill="currentColor"
                        className="text-primary/40"
                      />
                      <ellipse cx="30" cy="35" rx="6" ry="9" fill="currentColor" className="text-primary" />
                      <ellipse cx="26" cy="28" rx="5" ry="8" fill="currentColor" className="text-primary/90" />
                      <ellipse cx="34" cy="28" rx="5" ry="8" fill="currentColor" className="text-primary/90" />
                      <ellipse cx="30" cy="20" rx="5" ry="7" fill="currentColor" className="text-primary/80" />
                      <ellipse cx="27" cy="13" rx="4" ry="6" fill="currentColor" className="text-primary/70" />
                      <ellipse cx="33" cy="13" rx="4" ry="6" fill="currentColor" className="text-primary/70" />
                      <ellipse cx="30" cy="6" rx="3" ry="5" fill="currentColor" className="text-primary/60" />
                    </svg>
                  ))}
                </div>
              </div>
            </div>
            
            {/* Stats Card */}
            <div className="absolute -bottom-6 -right-6 bg-card rounded-xl shadow-lg p-6 border border-border">
              <div className="text-center">
                <p className="text-4xl font-bold text-primary">20+</p>
                <p className="text-sm text-muted-foreground">Years of Service</p>
              </div>
            </div>
          </div>

          {/* Content Side */}
          <div>
            <p className="text-sm font-medium text-primary mb-2 tracking-wide uppercase">About Us</p>
            <h2 className="font-serif text-3xl font-bold tracking-tight sm:text-4xl text-foreground">
              A Legacy of Care and Trust
            </h2>
            <p className="mt-6 text-lg text-muted-foreground leading-relaxed">
              Founded with a vision to provide compassionate healthcare, Lavender Pharmacy has been 
              serving our community for over two decades. We believe that every patient deserves 
              personalized attention and expert care.
            </p>
            <p className="mt-4 text-muted-foreground leading-relaxed">
              Our team of dedicated pharmacists and healthcare professionals are committed to going 
              beyond just dispensing medications. We take the time to understand your needs, answer 
              your questions, and help you achieve your health goals.
            </p>

            {/* Highlights */}
            <ul className="mt-8 space-y-3">
              {highlights.map((item) => (
                <li key={item} className="flex items-center gap-3">
                  <CheckCircle className="h-5 w-5 text-primary flex-shrink-0" />
                  <span className="text-foreground">{item}</span>
                </li>
              ))}
            </ul>

            <div className="mt-8">
              <Button size="lg">Learn More About Us</Button>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}
