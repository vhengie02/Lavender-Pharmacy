"use client"

import { useState } from "react"
import Link from "next/link"
import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Badge } from "@/components/ui/badge"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Checkbox } from "@/components/ui/checkbox"
import { Label } from "@/components/ui/label"
import { Search, ShoppingCart, Filter, Grid, List, AlertCircle } from "lucide-react"
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from "@/components/ui/sheet"

const categories = [
  "All Products",
  "Pain Relief",
  "Cold & Flu",
  "Vitamins & Supplements",
  "First Aid",
  "Skin Care",
  "Digestive Health",
  "Allergy Relief",
  "Personal Care"
]

const products = [
  {
    id: 1,
    name: "Biogesic Paracetamol",
    genericName: "Paracetamol 500mg",
    brand: "Biogesic",
    price: 5.50,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Pain Relief",
    stock: 150,
    requiresPrescription: false,
    description: "For relief of minor aches, pains, and fever"
  },
  {
    id: 2,
    name: "Neozep Forte",
    genericName: "Phenylephrine + Chlorphenamine + Paracetamol",
    brand: "Neozep",
    price: 12.00,
    originalPrice: 15.00,
    image: "/placeholder.svg?height=200&width=200",
    category: "Cold & Flu",
    stock: 85,
    requiresPrescription: false,
    description: "Relief of clogged nose, runny nose, and fever"
  },
  {
    id: 3,
    name: "Bioflu",
    genericName: "Phenylephrine + Chlorphenamine + Paracetamol",
    brand: "Bioflu",
    price: 15.00,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Cold & Flu",
    stock: 120,
    requiresPrescription: false,
    description: "Multi-symptom flu relief"
  },
  {
    id: 4,
    name: "Amoxicillin 500mg",
    genericName: "Amoxicillin",
    brand: "Generic",
    price: 8.50,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Antibiotics",
    stock: 200,
    requiresPrescription: true,
    description: "Antibiotic for bacterial infections"
  },
  {
    id: 5,
    name: "Cetirizine 10mg",
    genericName: "Cetirizine Dihydrochloride",
    brand: "Generic",
    price: 3.50,
    originalPrice: 5.00,
    image: "/placeholder.svg?height=200&width=200",
    category: "Allergy Relief",
    stock: 300,
    requiresPrescription: false,
    description: "24-hour allergy relief"
  },
  {
    id: 6,
    name: "Decolgen Forte",
    genericName: "Phenylpropanolamine + Chlorphenamine + Paracetamol",
    brand: "Decolgen",
    price: 10.00,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Cold & Flu",
    stock: 95,
    requiresPrescription: false,
    description: "Fast relief from cold symptoms"
  },
  {
    id: 7,
    name: "Kremil-S",
    genericName: "Aluminum Hydroxide + Magnesium Hydroxide + Simethicone",
    brand: "Kremil-S",
    price: 7.50,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Digestive Health",
    stock: 180,
    requiresPrescription: false,
    description: "Relief from hyperacidity and gas pain"
  },
  {
    id: 8,
    name: "Solmux 500mg",
    genericName: "Carbocisteine",
    brand: "Solmux",
    price: 11.00,
    originalPrice: 13.00,
    image: "/placeholder.svg?height=200&width=200",
    category: "Cold & Flu",
    stock: 110,
    requiresPrescription: false,
    description: "Mucolytic for productive cough"
  },
  {
    id: 9,
    name: "Enervon C",
    genericName: "Multivitamins + Vitamin C",
    brand: "Enervon",
    price: 9.00,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Vitamins & Supplements",
    stock: 250,
    requiresPrescription: false,
    description: "Daily multivitamins with Vitamin C"
  },
  {
    id: 10,
    name: "Medicol Advance",
    genericName: "Ibuprofen 400mg",
    brand: "Medicol",
    price: 8.00,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Pain Relief",
    stock: 175,
    requiresPrescription: false,
    description: "For headache and body pain"
  },
  {
    id: 11,
    name: "Diatabs",
    genericName: "Loperamide 2mg",
    brand: "Diatabs",
    price: 6.00,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Digestive Health",
    stock: 140,
    requiresPrescription: false,
    description: "Relief from diarrhea"
  },
  {
    id: 12,
    name: "Ascorbic Acid 500mg",
    genericName: "Vitamin C",
    brand: "Generic",
    price: 2.50,
    originalPrice: null,
    image: "/placeholder.svg?height=200&width=200",
    category: "Vitamins & Supplements",
    stock: 400,
    requiresPrescription: false,
    description: "Vitamin C supplement"
  }
]

export default function ShopPage() {
  const [searchQuery, setSearchQuery] = useState("")
  const [selectedCategory, setSelectedCategory] = useState("All Products")
  const [sortBy, setSortBy] = useState("name")
  const [viewMode, setViewMode] = useState<"grid" | "list">("grid")
  const [showPrescriptionOnly, setShowPrescriptionOnly] = useState(false)
  const [priceRange, setPriceRange] = useState<[number, number]>([0, 100])

  const filteredProducts = products
    .filter(product => {
      const matchesSearch = product.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
        product.genericName.toLowerCase().includes(searchQuery.toLowerCase())
      const matchesCategory = selectedCategory === "All Products" || product.category === selectedCategory
      const matchesPrescription = !showPrescriptionOnly || product.requiresPrescription
      const matchesPrice = product.price >= priceRange[0] && product.price <= priceRange[1]
      return matchesSearch && matchesCategory && matchesPrescription && matchesPrice
    })
    .sort((a, b) => {
      switch (sortBy) {
        case "price-low": return a.price - b.price
        case "price-high": return b.price - a.price
        case "name": return a.name.localeCompare(b.name)
        default: return 0
      }
    })

  const FilterSidebar = () => (
    <div className="space-y-6">
      <div>
        <h3 className="font-semibold text-foreground mb-3">Categories</h3>
        <div className="space-y-2">
          {categories.map((category) => (
            <button
              key={category}
              onClick={() => setSelectedCategory(category)}
              className={`block w-full text-left px-3 py-2 rounded-lg text-sm transition-colors ${
                selectedCategory === category
                  ? "bg-primary text-primary-foreground"
                  : "text-muted-foreground hover:bg-muted"
              }`}
            >
              {category}
            </button>
          ))}
        </div>
      </div>

      <div>
        <h3 className="font-semibold text-foreground mb-3">Price Range</h3>
        <div className="flex items-center gap-2">
          <Input
            type="number"
            placeholder="Min"
            value={priceRange[0]}
            onChange={(e) => setPriceRange([Number(e.target.value), priceRange[1]])}
            className="w-20"
          />
          <span className="text-muted-foreground">-</span>
          <Input
            type="number"
            placeholder="Max"
            value={priceRange[1]}
            onChange={(e) => setPriceRange([priceRange[0], Number(e.target.value)])}
            className="w-20"
          />
        </div>
      </div>

      <div className="flex items-center space-x-2">
        <Checkbox
          id="prescription"
          checked={showPrescriptionOnly}
          onCheckedChange={(checked) => setShowPrescriptionOnly(checked as boolean)}
        />
        <Label htmlFor="prescription" className="text-sm text-muted-foreground">
          Prescription required only
        </Label>
      </div>
    </div>
  )

  return (
    <main className="min-h-screen bg-background">
      <Navbar />
      
      {/* Header */}
      <section className="pt-32 pb-8 bg-gradient-to-b from-primary/10 to-background">
        <div className="container mx-auto px-4">
          <h1 className="text-4xl font-serif font-bold text-foreground mb-4">Shop Medicines</h1>
          <p className="text-muted-foreground">Browse our wide selection of quality medicines and health products</p>
        </div>
      </section>

      <section className="py-8">
        <div className="container mx-auto px-4">
          <div className="flex flex-col lg:flex-row gap-8">
            {/* Sidebar - Desktop */}
            <aside className="hidden lg:block w-64 flex-shrink-0">
              <Card>
                <CardContent className="p-6">
                  <FilterSidebar />
                </CardContent>
              </Card>
            </aside>

            {/* Main Content */}
            <div className="flex-1">
              {/* Search and Filters Bar */}
              <div className="flex flex-col sm:flex-row gap-4 mb-6">
                <div className="relative flex-1">
                  <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                  <Input
                    placeholder="Search medicines..."
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    className="pl-10"
                  />
                </div>
                <div className="flex gap-2">
                  <Select value={sortBy} onValueChange={setSortBy}>
                    <SelectTrigger className="w-40">
                      <SelectValue placeholder="Sort by" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="name">Name A-Z</SelectItem>
                      <SelectItem value="price-low">Price: Low to High</SelectItem>
                      <SelectItem value="price-high">Price: High to Low</SelectItem>
                    </SelectContent>
                  </Select>
                  
                  {/* Mobile Filter Button */}
                  <Sheet>
                    <SheetTrigger asChild>
                      <Button variant="outline" size="icon" className="lg:hidden">
                        <Filter className="w-4 h-4" />
                      </Button>
                    </SheetTrigger>
                    <SheetContent side="left">
                      <SheetHeader>
                        <SheetTitle>Filters</SheetTitle>
                      </SheetHeader>
                      <div className="mt-6">
                        <FilterSidebar />
                      </div>
                    </SheetContent>
                  </Sheet>

                  <div className="hidden sm:flex border rounded-lg">
                    <Button
                      variant={viewMode === "grid" ? "secondary" : "ghost"}
                      size="icon"
                      onClick={() => setViewMode("grid")}
                    >
                      <Grid className="w-4 h-4" />
                    </Button>
                    <Button
                      variant={viewMode === "list" ? "secondary" : "ghost"}
                      size="icon"
                      onClick={() => setViewMode("list")}
                    >
                      <List className="w-4 h-4" />
                    </Button>
                  </div>
                </div>
              </div>

              {/* Results Count */}
              <p className="text-sm text-muted-foreground mb-4">
                Showing {filteredProducts.length} of {products.length} products
              </p>

              {/* Products Grid/List */}
              {viewMode === "grid" ? (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                  {filteredProducts.map((product) => (
                    <Card key={product.id} className="group overflow-hidden hover:shadow-lg transition-all">
                      <div className="relative aspect-square bg-muted/50">
                        <div className="absolute top-3 left-3 flex flex-col gap-2 z-10">
                          {product.originalPrice && (
                            <Badge className="bg-red-500 hover:bg-red-600">Sale</Badge>
                          )}
                          {product.requiresPrescription && (
                            <Badge variant="secondary" className="bg-amber-100 text-amber-800">
                              <AlertCircle className="w-3 h-3 mr-1" />
                              Rx
                            </Badge>
                          )}
                        </div>
                        <div className="w-full h-full flex items-center justify-center p-8">
                          <div className="w-24 h-24 rounded-full bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                            <span className="text-4xl font-bold text-primary/50">
                              {product.name.charAt(0)}
                            </span>
                          </div>
                        </div>
                      </div>
                      <CardContent className="p-4">
                        <p className="text-xs text-primary font-medium mb-1">{product.category}</p>
                        <Link href={`/shop/${product.id}`}>
                          <h3 className="font-semibold text-foreground group-hover:text-primary transition-colors line-clamp-1">
                            {product.name}
                          </h3>
                        </Link>
                        <p className="text-xs text-muted-foreground mt-1 line-clamp-1">{product.genericName}</p>
                        <div className="flex items-center justify-between mt-3">
                          <div className="flex items-center gap-2">
                            <span className="text-lg font-bold text-foreground">
                              ₱{product.price.toFixed(2)}
                            </span>
                            {product.originalPrice && (
                              <span className="text-sm text-muted-foreground line-through">
                                ₱{product.originalPrice.toFixed(2)}
                              </span>
                            )}
                          </div>
                          <Button size="sm" className="bg-primary hover:bg-primary/90">
                            <ShoppingCart className="w-4 h-4" />
                          </Button>
                        </div>
                        <p className="text-xs text-muted-foreground mt-2">
                          {product.stock > 0 ? `${product.stock} in stock` : "Out of stock"}
                        </p>
                      </CardContent>
                    </Card>
                  ))}
                </div>
              ) : (
                <div className="space-y-4">
                  {filteredProducts.map((product) => (
                    <Card key={product.id} className="overflow-hidden hover:shadow-lg transition-all">
                      <CardContent className="p-4 flex gap-4">
                        <div className="w-24 h-24 rounded-lg bg-muted/50 flex items-center justify-center flex-shrink-0">
                          <div className="w-16 h-16 rounded-full bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                            <span className="text-2xl font-bold text-primary/50">
                              {product.name.charAt(0)}
                            </span>
                          </div>
                        </div>
                        <div className="flex-1">
                          <div className="flex items-start justify-between">
                            <div>
                              <p className="text-xs text-primary font-medium mb-1">{product.category}</p>
                              <Link href={`/shop/${product.id}`}>
                                <h3 className="font-semibold text-foreground hover:text-primary transition-colors">
                                  {product.name}
                                </h3>
                              </Link>
                              <p className="text-sm text-muted-foreground">{product.genericName}</p>
                              <p className="text-xs text-muted-foreground mt-1">{product.description}</p>
                            </div>
                            <div className="flex items-center gap-2">
                              {product.requiresPrescription && (
                                <Badge variant="secondary" className="bg-amber-100 text-amber-800">
                                  <AlertCircle className="w-3 h-3 mr-1" />
                                  Rx
                                </Badge>
                              )}
                              {product.originalPrice && (
                                <Badge className="bg-red-500 hover:bg-red-600">Sale</Badge>
                              )}
                            </div>
                          </div>
                          <div className="flex items-center justify-between mt-3">
                            <div className="flex items-center gap-2">
                              <span className="text-lg font-bold text-foreground">
                                ₱{product.price.toFixed(2)}
                              </span>
                              {product.originalPrice && (
                                <span className="text-sm text-muted-foreground line-through">
                                  ₱{product.originalPrice.toFixed(2)}
                                </span>
                              )}
                              <span className="text-sm text-muted-foreground">
                                • {product.stock > 0 ? `${product.stock} in stock` : "Out of stock"}
                              </span>
                            </div>
                            <Button size="sm" className="bg-primary hover:bg-primary/90">
                              <ShoppingCart className="w-4 h-4 mr-2" />
                              Add to Cart
                            </Button>
                          </div>
                        </div>
                      </CardContent>
                    </Card>
                  ))}
                </div>
              )}

              {filteredProducts.length === 0 && (
                <div className="text-center py-12">
                  <p className="text-muted-foreground">No products found matching your criteria.</p>
                  <Button variant="link" onClick={() => {
                    setSearchQuery("")
                    setSelectedCategory("All Products")
                    setShowPrescriptionOnly(false)
                    setPriceRange([0, 100])
                  }}>
                    Clear all filters
                  </Button>
                </div>
              )}
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  )
}
