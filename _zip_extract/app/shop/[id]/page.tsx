"use client"

import { useState } from "react"
import { use } from "react"
import Link from "next/link"
import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { 
  ShoppingCart, 
  Heart, 
  Share2, 
  Minus, 
  Plus, 
  AlertCircle, 
  Check, 
  Truck, 
  Shield, 
  RotateCcw,
  ChevronRight
} from "lucide-react"

const products: Record<number, {
  id: number
  name: string
  genericName: string
  brand: string
  price: number
  originalPrice: number | null
  category: string
  stock: number
  requiresPrescription: boolean
  description: string
  dosage: string
  sideEffects: string
  storage: string
  manufacturer: string
  expirationDate: string
  barcode: string
}> = {
  1: {
    id: 1,
    name: "Biogesic Paracetamol",
    genericName: "Paracetamol 500mg",
    brand: "Biogesic",
    price: 5.50,
    originalPrice: null,
    category: "Pain Relief",
    stock: 150,
    requiresPrescription: false,
    description: "Biogesic Paracetamol 500mg is for the relief of minor aches and pains such as headache, backache, menstrual cramps, muscular aches, minor arthritis pain, toothache, and pain from the common cold. It also temporarily reduces fever.",
    dosage: "Adults and children 12 years and over: Take 1-2 tablets every 4-6 hours as needed. Do not take more than 8 tablets in 24 hours.",
    sideEffects: "Rare side effects may include allergic reactions, skin rash, or liver problems if taken in excess. Consult a healthcare provider if any unusual symptoms occur.",
    storage: "Store at room temperature (not more than 30°C). Keep away from moisture and direct sunlight. Keep out of reach of children.",
    manufacturer: "Unilab",
    expirationDate: "2026-12-31",
    barcode: "4800015501234"
  },
  2: {
    id: 2,
    name: "Neozep Forte",
    genericName: "Phenylephrine + Chlorphenamine + Paracetamol",
    brand: "Neozep",
    price: 12.00,
    originalPrice: 15.00,
    category: "Cold & Flu",
    stock: 85,
    requiresPrescription: false,
    description: "Neozep Forte is a powerful combination medicine for the relief of clogged nose, runny nose, postnasal drip, itchy and watery eyes, sneezing, headache, body aches, and fever associated with the common cold, allergic rhinitis, sinusitis, and flu.",
    dosage: "Adults: 1 tablet every 6 hours. Do not exceed 4 tablets in 24 hours. Not recommended for children under 12 years.",
    sideEffects: "May cause drowsiness, dizziness, dry mouth, or nervousness. Avoid driving or operating heavy machinery after taking this medication.",
    storage: "Store below 25°C. Protect from light and moisture.",
    manufacturer: "Unilab",
    expirationDate: "2026-06-30",
    barcode: "4800015502341"
  }
}

const relatedProducts = [
  { id: 3, name: "Bioflu", price: 15.00, category: "Cold & Flu" },
  { id: 5, name: "Cetirizine 10mg", price: 3.50, category: "Allergy Relief" },
  { id: 6, name: "Decolgen Forte", price: 10.00, category: "Cold & Flu" },
  { id: 10, name: "Medicol Advance", price: 8.00, category: "Pain Relief" }
]

export default function ProductDetailPage({ params }: { params: Promise<{ id: string }> }) {
  const resolvedParams = use(params)
  const productId = parseInt(resolvedParams.id)
  const product = products[productId] || products[1]
  
  const [quantity, setQuantity] = useState(1)
  const [isWishlisted, setIsWishlisted] = useState(false)

  const incrementQuantity = () => {
    if (quantity < product.stock) {
      setQuantity(q => q + 1)
    }
  }

  const decrementQuantity = () => {
    if (quantity > 1) {
      setQuantity(q => q - 1)
    }
  }

  return (
    <main className="min-h-screen bg-background">
      <Navbar />
      
      {/* Breadcrumb */}
      <section className="pt-28 pb-4">
        <div className="container mx-auto px-4">
          <nav className="flex items-center text-sm text-muted-foreground">
            <Link href="/" className="hover:text-primary transition-colors">Home</Link>
            <ChevronRight className="w-4 h-4 mx-2" />
            <Link href="/shop" className="hover:text-primary transition-colors">Shop</Link>
            <ChevronRight className="w-4 h-4 mx-2" />
            <span className="text-foreground">{product.name}</span>
          </nav>
        </div>
      </section>

      {/* Product Details */}
      <section className="py-8">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-2 gap-12">
            {/* Product Image */}
            <div>
              <Card className="overflow-hidden">
                <CardContent className="p-0">
                  <div className="relative aspect-square bg-gradient-to-br from-primary/5 to-accent/5 flex items-center justify-center">
                    <div className="absolute top-4 left-4 flex flex-col gap-2 z-10">
                      {product.originalPrice && (
                        <Badge className="bg-red-500 hover:bg-red-600">
                          {Math.round((1 - product.price / product.originalPrice) * 100)}% OFF
                        </Badge>
                      )}
                      {product.requiresPrescription && (
                        <Badge variant="secondary" className="bg-amber-100 text-amber-800">
                          <AlertCircle className="w-3 h-3 mr-1" />
                          Prescription Required
                        </Badge>
                      )}
                    </div>
                    <div className="w-48 h-48 rounded-full bg-gradient-to-br from-primary/30 to-accent/30 flex items-center justify-center">
                      <span className="text-8xl font-bold text-primary/40">
                        {product.name.charAt(0)}
                      </span>
                    </div>
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* Product Info */}
            <div>
              <div className="mb-4">
                <p className="text-sm text-primary font-medium mb-2">{product.category}</p>
                <h1 className="text-3xl font-serif font-bold text-foreground mb-2">{product.name}</h1>
                <p className="text-muted-foreground">{product.genericName}</p>
                <p className="text-sm text-muted-foreground mt-1">Brand: {product.brand}</p>
              </div>

              {/* Price */}
              <div className="flex items-baseline gap-3 mb-6">
                <span className="text-3xl font-bold text-foreground">₱{product.price.toFixed(2)}</span>
                {product.originalPrice && (
                  <span className="text-xl text-muted-foreground line-through">
                    ₱{product.originalPrice.toFixed(2)}
                  </span>
                )}
              </div>

              {/* Stock Status */}
              <div className="flex items-center gap-2 mb-6">
                {product.stock > 0 ? (
                  <>
                    <Check className="w-5 h-5 text-green-600" />
                    <span className="text-green-600 font-medium">In Stock</span>
                    <span className="text-muted-foreground">({product.stock} available)</span>
                  </>
                ) : (
                  <>
                    <AlertCircle className="w-5 h-5 text-red-600" />
                    <span className="text-red-600 font-medium">Out of Stock</span>
                  </>
                )}
              </div>

              {/* Description */}
              <p className="text-muted-foreground mb-6 leading-relaxed">{product.description}</p>

              {/* Quantity Selector */}
              <div className="flex items-center gap-4 mb-6">
                <span className="text-sm font-medium text-foreground">Quantity:</span>
                <div className="flex items-center border rounded-lg">
                  <Button
                    variant="ghost"
                    size="icon"
                    onClick={decrementQuantity}
                    disabled={quantity <= 1}
                    className="rounded-none"
                  >
                    <Minus className="w-4 h-4" />
                  </Button>
                  <span className="w-12 text-center font-medium">{quantity}</span>
                  <Button
                    variant="ghost"
                    size="icon"
                    onClick={incrementQuantity}
                    disabled={quantity >= product.stock}
                    className="rounded-none"
                  >
                    <Plus className="w-4 h-4" />
                  </Button>
                </div>
              </div>

              {/* Action Buttons */}
              <div className="flex flex-col sm:flex-row gap-3 mb-8">
                <Button 
                  size="lg" 
                  className="flex-1 bg-primary hover:bg-primary/90"
                  disabled={product.stock === 0}
                >
                  <ShoppingCart className="w-5 h-5 mr-2" />
                  Add to Cart - ₱{(product.price * quantity).toFixed(2)}
                </Button>
                <Button
                  size="lg"
                  variant="outline"
                  onClick={() => setIsWishlisted(!isWishlisted)}
                  className={isWishlisted ? "text-red-500 border-red-500" : ""}
                >
                  <Heart className={`w-5 h-5 ${isWishlisted ? "fill-current" : ""}`} />
                </Button>
                <Button size="lg" variant="outline">
                  <Share2 className="w-5 h-5" />
                </Button>
              </div>

              {/* Features */}
              <div className="grid grid-cols-3 gap-4 p-4 bg-muted/30 rounded-lg">
                <div className="text-center">
                  <Truck className="w-6 h-6 mx-auto text-primary mb-2" />
                  <p className="text-xs text-muted-foreground">Free Delivery</p>
                </div>
                <div className="text-center">
                  <Shield className="w-6 h-6 mx-auto text-primary mb-2" />
                  <p className="text-xs text-muted-foreground">Genuine Product</p>
                </div>
                <div className="text-center">
                  <RotateCcw className="w-6 h-6 mx-auto text-primary mb-2" />
                  <p className="text-xs text-muted-foreground">Easy Returns</p>
                </div>
              </div>
            </div>
          </div>

          {/* Product Details Tabs */}
          <div className="mt-12">
            <Tabs defaultValue="dosage" className="w-full">
              <TabsList className="w-full justify-start border-b rounded-none h-auto p-0 bg-transparent">
                <TabsTrigger 
                  value="dosage"
                  className="rounded-none border-b-2 border-transparent data-[state=active]:border-primary data-[state=active]:bg-transparent"
                >
                  Dosage & Administration
                </TabsTrigger>
                <TabsTrigger 
                  value="sideeffects"
                  className="rounded-none border-b-2 border-transparent data-[state=active]:border-primary data-[state=active]:bg-transparent"
                >
                  Side Effects
                </TabsTrigger>
                <TabsTrigger 
                  value="storage"
                  className="rounded-none border-b-2 border-transparent data-[state=active]:border-primary data-[state=active]:bg-transparent"
                >
                  Storage
                </TabsTrigger>
                <TabsTrigger 
                  value="info"
                  className="rounded-none border-b-2 border-transparent data-[state=active]:border-primary data-[state=active]:bg-transparent"
                >
                  Product Info
                </TabsTrigger>
              </TabsList>
              <TabsContent value="dosage" className="pt-6">
                <Card>
                  <CardContent className="p-6">
                    <h3 className="font-semibold text-foreground mb-3">Dosage Instructions</h3>
                    <p className="text-muted-foreground leading-relaxed">{product.dosage}</p>
                  </CardContent>
                </Card>
              </TabsContent>
              <TabsContent value="sideeffects" className="pt-6">
                <Card>
                  <CardContent className="p-6">
                    <h3 className="font-semibold text-foreground mb-3">Possible Side Effects</h3>
                    <p className="text-muted-foreground leading-relaxed">{product.sideEffects}</p>
                  </CardContent>
                </Card>
              </TabsContent>
              <TabsContent value="storage" className="pt-6">
                <Card>
                  <CardContent className="p-6">
                    <h3 className="font-semibold text-foreground mb-3">Storage Instructions</h3>
                    <p className="text-muted-foreground leading-relaxed">{product.storage}</p>
                  </CardContent>
                </Card>
              </TabsContent>
              <TabsContent value="info" className="pt-6">
                <Card>
                  <CardContent className="p-6">
                    <h3 className="font-semibold text-foreground mb-4">Product Information</h3>
                    <div className="grid sm:grid-cols-2 gap-4">
                      <div>
                        <p className="text-sm text-muted-foreground">Manufacturer</p>
                        <p className="font-medium text-foreground">{product.manufacturer}</p>
                      </div>
                      <div>
                        <p className="text-sm text-muted-foreground">Expiration Date</p>
                        <p className="font-medium text-foreground">{product.expirationDate}</p>
                      </div>
                      <div>
                        <p className="text-sm text-muted-foreground">Barcode</p>
                        <p className="font-medium text-foreground">{product.barcode}</p>
                      </div>
                      <div>
                        <p className="text-sm text-muted-foreground">Category</p>
                        <p className="font-medium text-foreground">{product.category}</p>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              </TabsContent>
            </Tabs>
          </div>

          {/* Related Products */}
          <div className="mt-16">
            <h2 className="text-2xl font-serif font-bold text-foreground mb-6">Related Products</h2>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              {relatedProducts.map((item) => (
                <Card key={item.id} className="group overflow-hidden hover:shadow-lg transition-all">
                  <div className="aspect-square bg-muted/50 flex items-center justify-center">
                    <div className="w-16 h-16 rounded-full bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                      <span className="text-2xl font-bold text-primary/50">
                        {item.name.charAt(0)}
                      </span>
                    </div>
                  </div>
                  <CardContent className="p-4">
                    <p className="text-xs text-primary font-medium mb-1">{item.category}</p>
                    <Link href={`/shop/${item.id}`}>
                      <h3 className="font-semibold text-foreground text-sm group-hover:text-primary transition-colors line-clamp-1">
                        {item.name}
                      </h3>
                    </Link>
                    <p className="text-foreground font-bold mt-2">₱{item.price.toFixed(2)}</p>
                  </CardContent>
                </Card>
              ))}
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  )
}
