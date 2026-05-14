import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Pill, Stethoscope, Truck, Syringe, HeartPulse, FlaskConical } from "lucide-react"

const services = [
  {
    icon: Pill,
    title: "Prescription Filling",
    description: "Quick and accurate prescription fulfillment with expert pharmacist consultation for all your medication needs.",
  },
  {
    icon: Stethoscope,
    title: "Health Consultations",
    description: "One-on-one consultations with our licensed pharmacists to discuss your health concerns and medication management.",
  },
  {
    icon: Truck,
    title: "Home Delivery",
    description: "Free delivery service for prescriptions and health products right to your doorstep within the local area.",
  },
  {
    icon: Syringe,
    title: "Immunizations",
    description: "Stay protected with our comprehensive vaccination services including flu shots and travel vaccines.",
  },
  {
    icon: HeartPulse,
    title: "Health Monitoring",
    description: "Blood pressure, glucose, and cholesterol screenings to help you stay on top of your health metrics.",
  },
  {
    icon: FlaskConical,
    title: "Compounding",
    description: "Custom medication preparations tailored to your specific needs when standard medications aren&apos;t suitable.",
  },
]

export function Services() {
  return (
    <section id="services" className="py-24 bg-secondary/30">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto mb-16">
          <p className="text-sm font-medium text-primary mb-2 tracking-wide uppercase">Our Services</p>
          <h2 className="font-serif text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl text-foreground">
            Comprehensive Care for Your Wellness
          </h2>
          <p className="mt-4 text-lg text-muted-foreground leading-relaxed">
            From prescription filling to health consultations, we offer a complete range of pharmacy services 
            designed to support your health journey every step of the way.
          </p>
        </div>

        {/* Services Grid */}
        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {services.map((service) => (
            <Card 
              key={service.title} 
              className="group bg-card border-border hover:border-primary/30 transition-all duration-300 hover:shadow-lg hover:shadow-primary/5"
            >
              <CardHeader>
                <div className="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 group-hover:bg-primary/20 transition-colors">
                  <service.icon className="h-6 w-6 text-primary" />
                </div>
                <CardTitle className="text-xl font-semibold text-card-foreground">{service.title}</CardTitle>
              </CardHeader>
              <CardContent>
                <CardDescription className="text-muted-foreground leading-relaxed">
                  {service.description}
                </CardDescription>
              </CardContent>
            </Card>
          ))}
        </div>
      </div>
    </section>
  )
}
