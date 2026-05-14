import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { LavenderLogo } from "@/components/lavender-logo"
import { Card, CardContent } from "@/components/ui/card"
import { Heart, Shield, Users, Award, Clock, Leaf } from "lucide-react"

const values = [
  {
    icon: Heart,
    title: "Patient-Centered Care",
    description: "Every decision we make is guided by what is best for our patients and their health outcomes."
  },
  {
    icon: Shield,
    title: "Trust & Integrity",
    description: "We maintain the highest standards of honesty and transparency in all our interactions."
  },
  {
    icon: Users,
    title: "Community Focus",
    description: "We are deeply committed to serving and supporting our local community&apos;s health needs."
  },
  {
    icon: Award,
    title: "Excellence",
    description: "We strive for excellence in pharmaceutical care, continuously improving our services."
  },
  {
    icon: Clock,
    title: "Accessibility",
    description: "Healthcare should be accessible to all. We offer extended hours and delivery services."
  },
  {
    icon: Leaf,
    title: "Wellness Approach",
    description: "We believe in holistic wellness, offering preventive care and health education."
  }
]

const milestones = [
  { year: "2010", event: "Lavender Pharmacy founded with a single location" },
  { year: "2013", event: "Launched 24/7 emergency prescription services" },
  { year: "2016", event: "Introduced free home delivery for seniors" },
  { year: "2019", event: "Opened compounding pharmacy division" },
  { year: "2022", event: "Achieved 50,000+ satisfied customers milestone" },
  { year: "2024", event: "Launched online pharmacy platform" }
]

const team = [
  {
    name: "Dr. Maria Santos",
    role: "Chief Pharmacist",
    description: "25+ years of pharmaceutical experience"
  },
  {
    name: "John Rivera",
    role: "Operations Manager",
    description: "Ensuring smooth daily operations"
  },
  {
    name: "Dr. Ana Cruz",
    role: "Clinical Pharmacist",
    description: "Specializing in patient consultations"
  },
  {
    name: "Miguel Reyes",
    role: "Inventory Manager",
    description: "Managing our extensive product catalog"
  }
]

export default function AboutPage() {
  return (
    <main className="min-h-screen bg-background">
      <Navbar />
      
      {/* Hero Section */}
      <section className="relative pt-32 pb-20 bg-gradient-to-b from-primary/10 to-background">
        <div className="container mx-auto px-4">
          <div className="max-w-3xl mx-auto text-center">
            <div className="flex justify-center mb-6">
              <LavenderLogo size="lg" />
            </div>
            <h1 className="text-4xl md:text-5xl font-serif font-bold text-foreground mb-6 text-balance">
              About Lavender Pharmacy
            </h1>
            <p className="text-lg text-muted-foreground text-pretty">
              For over a decade, Lavender Pharmacy has been a trusted healthcare partner in our community. 
              We combine traditional pharmaceutical care with modern convenience to serve you better.
            </p>
          </div>
        </div>
      </section>

      {/* Mission & Vision */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <Card className="bg-primary/5 border-primary/20">
              <CardContent className="p-8">
                <h2 className="text-2xl font-serif font-bold text-foreground mb-4">Our Mission</h2>
                <p className="text-muted-foreground leading-relaxed">
                  To provide accessible, affordable, and high-quality pharmaceutical services while 
                  treating every patient with compassion and respect. We aim to be more than just a 
                  pharmacy – we strive to be your trusted health partner.
                </p>
              </CardContent>
            </Card>
            <Card className="bg-accent/30 border-accent/50">
              <CardContent className="p-8">
                <h2 className="text-2xl font-serif font-bold text-foreground mb-4">Our Vision</h2>
                <p className="text-muted-foreground leading-relaxed">
                  To be the leading community pharmacy known for exceptional patient care, innovative 
                  health solutions, and unwavering commitment to improving the health and wellness 
                  of every individual we serve.
                </p>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      {/* Our Values */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-serif font-bold text-foreground mb-4">Our Core Values</h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              These principles guide everything we do at Lavender Pharmacy
            </p>
          </div>
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            {values.map((value, index) => (
              <Card key={index} className="bg-card hover:shadow-lg transition-shadow">
                <CardContent className="p-6">
                  <div className="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                    <value.icon className="w-6 h-6 text-primary" />
                  </div>
                  <h3 className="text-lg font-semibold text-foreground mb-2">{value.title}</h3>
                  <p className="text-muted-foreground text-sm">{value.description}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Timeline */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-serif font-bold text-foreground mb-4">Our Journey</h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Key milestones in our history of serving the community
            </p>
          </div>
          <div className="max-w-3xl mx-auto">
            <div className="relative">
              <div className="absolute left-4 md:left-1/2 top-0 bottom-0 w-0.5 bg-primary/30 transform md:-translate-x-1/2" />
              {milestones.map((milestone, index) => (
                <div key={index} className={`relative flex items-center mb-8 ${index % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'}`}>
                  <div className={`flex-1 ${index % 2 === 0 ? 'md:pr-8 md:text-right' : 'md:pl-8'} pl-12 md:pl-0`}>
                    <Card className="inline-block">
                      <CardContent className="p-4">
                        <span className="text-primary font-bold text-lg">{milestone.year}</span>
                        <p className="text-muted-foreground text-sm mt-1">{milestone.event}</p>
                      </CardContent>
                    </Card>
                  </div>
                  <div className="absolute left-4 md:left-1/2 w-3 h-3 bg-primary rounded-full transform md:-translate-x-1/2 z-10" />
                  <div className="flex-1 hidden md:block" />
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Team */}
      <section className="py-20 bg-muted/30">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-serif font-bold text-foreground mb-4">Meet Our Team</h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Dedicated professionals committed to your health and wellness
            </p>
          </div>
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            {team.map((member, index) => (
              <Card key={index} className="bg-card text-center hover:shadow-lg transition-shadow">
                <CardContent className="p-6">
                  <div className="w-20 h-20 rounded-full bg-gradient-to-br from-primary to-accent mx-auto mb-4 flex items-center justify-center">
                    <span className="text-2xl font-bold text-primary-foreground">
                      {member.name.split(' ').map(n => n[0]).join('')}
                    </span>
                  </div>
                  <h3 className="font-semibold text-foreground">{member.name}</h3>
                  <p className="text-primary text-sm font-medium">{member.role}</p>
                  <p className="text-muted-foreground text-sm mt-2">{member.description}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Certifications */}
      <section className="py-20">
        <div className="container mx-auto px-4">
          <div className="max-w-4xl mx-auto text-center">
            <h2 className="text-3xl font-serif font-bold text-foreground mb-4">Licensed & Certified</h2>
            <p className="text-muted-foreground mb-8">
              Lavender Pharmacy is fully licensed and certified to provide pharmaceutical services
            </p>
            <div className="flex flex-wrap justify-center gap-4">
              <div className="px-6 py-3 bg-primary/10 rounded-full text-primary font-medium">
                FDA Licensed
              </div>
              <div className="px-6 py-3 bg-primary/10 rounded-full text-primary font-medium">
                DOH Registered
              </div>
              <div className="px-6 py-3 bg-primary/10 rounded-full text-primary font-medium">
                PhilHealth Accredited
              </div>
              <div className="px-6 py-3 bg-primary/10 rounded-full text-primary font-medium">
                ISO 9001 Certified
              </div>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  )
}
