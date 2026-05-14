"use client"

import { useState } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import {
  Search,
  Package,
  AlertTriangle,
  Filter,
  Grid,
  List,
} from "lucide-react"
import { Badge } from "@/components/ui/badge"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"

interface Product {
  id: string
  name: string
  sku: string
  price: number
  category: string
  stock: number
  minStock: number
  barcode: string
  description: string
}

const products: Product[] = [
  { id: "1", name: "Paracetamol 500mg", sku: "MED-001", price: 5.99, category: "Pain Relief", stock: 150, minStock: 50, barcode: "8901234567890", description: "Pain relief tablets" },
  { id: "2", name: "Ibuprofen 400mg", sku: "MED-002", price: 7.99, category: "Pain Relief", stock: 120, minStock: 40, barcode: "8901234567891", description: "Anti-inflammatory tablets" },
  { id: "3", name: "Vitamin C 1000mg", sku: "VIT-001", price: 12.99, category: "Vitamins", stock: 80, minStock: 30, barcode: "8901234567892", description: "Immune support supplement" },
  { id: "4", name: "Multivitamin Daily", sku: "VIT-002", price: 15.99, category: "Vitamins", stock: 95, minStock: 35, barcode: "8901234567893", description: "Daily multivitamin tablets" },
  { id: "5", name: "Cough Syrup 100ml", sku: "MED-003", price: 8.99, category: "Cold & Flu", stock: 25, minStock: 30, barcode: "8901234567894", description: "Cough relief syrup" },
  { id: "6", name: "Antihistamine 10mg", sku: "MED-004", price: 9.99, category: "Allergy", stock: 70, minStock: 25, barcode: "8901234567895", description: "Allergy relief tablets" },
  { id: "7", name: "Hand Sanitizer 250ml", sku: "HYG-001", price: 4.99, category: "Personal Care", stock: 200, minStock: 50, barcode: "8901234567896", description: "Antibacterial hand sanitizer" },
  { id: "8", name: "Face Masks (50 pack)", sku: "HYG-002", price: 14.99, category: "Personal Care", stock: 15, minStock: 20, barcode: "8901234567897", description: "Disposable face masks" },
  { id: "9", name: "Digital Thermometer", sku: "EQP-001", price: 19.99, category: "Equipment", stock: 30, minStock: 10, barcode: "8901234567898", description: "Digital temperature reader" },
  { id: "10", name: "Blood Pressure Monitor", sku: "EQP-002", price: 49.99, category: "Equipment", stock: 15, minStock: 5, barcode: "8901234567899", description: "Home blood pressure monitor" },
  { id: "11", name: "Bandages Assorted", sku: "AID-001", price: 6.99, category: "First Aid", stock: 100, minStock: 40, barcode: "8901234567900", description: "Assorted bandage pack" },
  { id: "12", name: "Antiseptic Cream 30g", sku: "AID-002", price: 7.49, category: "First Aid", stock: 85, minStock: 30, barcode: "8901234567901", description: "Wound antiseptic cream" },
]

const categories = ["All", "Pain Relief", "Vitamins", "Cold & Flu", "Allergy", "Personal Care", "Equipment", "First Aid"]

export default function EditorProductsPage() {
  const [searchQuery, setSearchQuery] = useState("")
  const [selectedCategory, setSelectedCategory] = useState("All")
  const [viewMode, setViewMode] = useState<"grid" | "list">("grid")
  const [stockFilter, setStockFilter] = useState("all")

  const filteredProducts = products.filter((product) => {
    const matchesSearch = product.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      product.sku.toLowerCase().includes(searchQuery.toLowerCase()) ||
      product.barcode.includes(searchQuery)
    const matchesCategory = selectedCategory === "All" || product.category === selectedCategory
    const matchesStock = stockFilter === "all" ||
      (stockFilter === "low" && product.stock <= product.minStock) ||
      (stockFilter === "inStock" && product.stock > product.minStock)
    return matchesSearch && matchesCategory && matchesStock
  })

  const lowStockCount = products.filter(p => p.stock <= p.minStock).length

  return (
    <div className="p-6 space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-serif font-bold text-foreground">Products</h1>
          <p className="text-muted-foreground mt-1">
            Search and view product information
          </p>
        </div>
        {lowStockCount > 0 && (
          <Badge variant="destructive" className="flex items-center gap-1">
            <AlertTriangle className="h-3 w-3" />
            {lowStockCount} Low Stock Items
          </Badge>
        )}
      </div>

      {/* Filters */}
      <Card>
        <CardContent className="p-4">
          <div className="flex flex-col md:flex-row gap-4">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                placeholder="Search by name, SKU, or barcode..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-10"
              />
            </div>
            <div className="flex gap-2">
              <Select value={selectedCategory} onValueChange={setSelectedCategory}>
                <SelectTrigger className="w-40">
                  <Filter className="mr-2 h-4 w-4" />
                  <SelectValue placeholder="Category" />
                </SelectTrigger>
                <SelectContent>
                  {categories.map((cat) => (
                    <SelectItem key={cat} value={cat}>{cat}</SelectItem>
                  ))}
                </SelectContent>
              </Select>
              <Select value={stockFilter} onValueChange={setStockFilter}>
                <SelectTrigger className="w-40">
                  <Package className="mr-2 h-4 w-4" />
                  <SelectValue placeholder="Stock" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Stock</SelectItem>
                  <SelectItem value="inStock">In Stock</SelectItem>
                  <SelectItem value="low">Low Stock</SelectItem>
                </SelectContent>
              </Select>
              <div className="flex border rounded-lg overflow-hidden">
                <Button
                  variant={viewMode === "grid" ? "default" : "ghost"}
                  size="icon"
                  onClick={() => setViewMode("grid")}
                  className="rounded-none"
                >
                  <Grid className="h-4 w-4" />
                </Button>
                <Button
                  variant={viewMode === "list" ? "default" : "ghost"}
                  size="icon"
                  onClick={() => setViewMode("list")}
                  className="rounded-none"
                >
                  <List className="h-4 w-4" />
                </Button>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Products */}
      {viewMode === "grid" ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
          {filteredProducts.map((product) => (
            <Card key={product.id} className={product.stock <= product.minStock ? "border-destructive/50" : ""}>
              <CardContent className="p-4">
                <div className="aspect-square bg-accent/30 rounded-lg mb-3 flex items-center justify-center">
                  <Package className="h-12 w-12 text-primary/30" />
                </div>
                <div className="space-y-2">
                  <h3 className="font-medium line-clamp-2">{product.name}</h3>
                  <p className="text-sm text-muted-foreground">{product.sku}</p>
                  <div className="flex items-center justify-between">
                    <span className="font-bold text-primary">${product.price.toFixed(2)}</span>
                    <Badge 
                      variant={product.stock <= product.minStock ? "destructive" : "secondary"}
                    >
                      {product.stock} in stock
                    </Badge>
                  </div>
                  <Badge variant="outline" className="w-full justify-center">
                    {product.category}
                  </Badge>
                </div>
              </CardContent>
            </Card>
          ))}
        </div>
      ) : (
        <Card>
          <CardHeader>
            <CardTitle>Product List</CardTitle>
            <CardDescription>{filteredProducts.length} products found</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead>
                  <tr className="border-b border-border">
                    <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Product</th>
                    <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">SKU</th>
                    <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Category</th>
                    <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Barcode</th>
                    <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Price</th>
                    <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Stock</th>
                  </tr>
                </thead>
                <tbody>
                  {filteredProducts.map((product) => (
                    <tr 
                      key={product.id} 
                      className={`border-b border-border last:border-0 ${product.stock <= product.minStock ? "bg-destructive/5" : ""}`}
                    >
                      <td className="py-3 px-4">
                        <div className="flex items-center gap-3">
                          <div className="w-10 h-10 bg-accent/30 rounded flex items-center justify-center">
                            <Package className="h-5 w-5 text-primary/50" />
                          </div>
                          <div>
                            <p className="font-medium">{product.name}</p>
                            <p className="text-sm text-muted-foreground">{product.description}</p>
                          </div>
                        </div>
                      </td>
                      <td className="py-3 px-4 text-sm">{product.sku}</td>
                      <td className="py-3 px-4">
                        <Badge variant="outline">{product.category}</Badge>
                      </td>
                      <td className="py-3 px-4 text-sm font-mono text-muted-foreground">{product.barcode}</td>
                      <td className="py-3 px-4 text-sm font-medium text-right">${product.price.toFixed(2)}</td>
                      <td className="py-3 px-4 text-right">
                        <Badge variant={product.stock <= product.minStock ? "destructive" : "secondary"}>
                          {product.stock}
                          {product.stock <= product.minStock && (
                            <AlertTriangle className="ml-1 h-3 w-3" />
                          )}
                        </Badge>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </CardContent>
        </Card>
      )}
    </div>
  )
}
