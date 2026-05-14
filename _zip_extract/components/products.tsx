import { Card, CardContent, CardFooter } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { ShoppingCart } from "lucide-react"

const products = [
  {
    name: "Daily Multivitamins",
    category: "Supplements",
    price: "$24.99",
    badge: "Bestseller",
    color: "from-primary/30 to-accent/30",
  },
  {
    name: "Organic Lavender Oil",
    category: "Aromatherapy",
    price: "$18.99",
    badge: "New",
    color: "from-accent/30 to-primary/20",
  },
  {
    name: "First Aid Kit",
    category: "Emergency Care",
    price: "$34.99",
    badge: null,
    color: "from-primary/20 to-lavender-light",
  },
  {
    name: "Pain Relief Cream",
    category: "Topicals",
    price: "$12.99",
    badge: "Popular",
    color: "from-lavender-light to-accent/20",
  },
]

export function Products() {
  return (
    <section id="products" className="py-24 bg-secondary/30">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto mb-16">
          <p className="text-sm font-medium text-primary mb-2 tracking-wide uppercase">Featured Products</p>
          <h2 className="font-serif text-3xl font-bold tracking-tight sm:text-4xl lg:text-5xl text-foreground">
            Health Essentials for You
          </h2>
          <p className="mt-4 text-lg text-muted-foreground leading-relaxed">
            Discover our carefully curated selection of health and wellness products, 
            chosen by our pharmacists to support your daily well-being.
          </p>
        </div>

        {/* Products Grid */}
        <div className="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          {products.map((product) => (
            <Card 
              key={product.name} 
              className="group bg-card border-border overflow-hidden hover:shadow-lg hover:shadow-primary/5 transition-all duration-300"
            >
              {/* Product Image Placeholder */}
              <div className={`aspect-square bg-gradient-to-br ${product.color} relative`}>
                {product.badge && (
                  <Badge className="absolute top-3 left-3 bg-primary text-primary-foreground">
                    {product.badge}
                  </Badge>
                )}
                <div className="absolute inset-0 flex items-center justify-center">
                  <svg
                    viewBox="0 0 60 80"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    className="h-20 w-auto opacity-50 group-hover:opacity-70 transition-opacity"
                  >
                    <path
                      d="M30 75 Q32 55 30 30"
                      stroke="currentColor"
                      strokeWidth="2"
                      fill="none"
                      className="text-primary/60"
                    />
                    <ellipse cx="30" cy="25" rx="5" ry="8" fill="currentColor" className="text-primary" />
                    <ellipse cx="26" cy="18" rx="4" ry="6" fill="currentColor" className="text-primary/90" />
                    <ellipse cx="34" cy="18" rx="4" ry="6" fill="currentColor" className="text-primary/90" />
                    <ellipse cx="30" cy="11" rx="4" ry="6" fill="currentColor" className="text-primary/80" />
                    <ellipse cx="27" cy="5" rx="3" ry="5" fill="currentColor" className="text-primary/70" />
                    <ellipse cx="33" cy="5" rx="3" ry="5" fill="currentColor" className="text-primary/70" />
                  </svg>
                </div>
              </div>
              
              <CardContent className="pt-4">
                <p className="text-xs text-primary font-medium uppercase tracking-wide">{product.category}</p>
                <h3 className="mt-1 font-semibold text-card-foreground group-hover:text-primary transition-colors">
                  {product.name}
                </h3>
                <p className="mt-2 text-lg font-bold text-primary">{product.price}</p>
              </CardContent>
              
              <CardFooter className="pt-0">
                <Button variant="outline" className="w-full gap-2 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                  <ShoppingCart className="h-4 w-4" />
                  Add to Cart
                </Button>
              </CardFooter>
            </Card>
          ))}
        </div>

        {/* View All Button */}
        <div className="mt-12 text-center">
          <Button size="lg" variant="outline">
            View All Products
          </Button>
        </div>
      </div>
    </section>
  )
}
