"use client"

import { useState } from "react"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import {
  Search,
  Plus,
  Minus,
  Trash2,
  CreditCard,
  Banknote,
  Smartphone,
  Receipt,
  X,
  Barcode,
} from "lucide-react"
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"
import { Badge } from "@/components/ui/badge"

interface Product {
  id: string
  name: string
  price: number
  category: string
  stock: number
  barcode: string
}

interface CartItem extends Product {
  quantity: number
}

const products: Product[] = [
  { id: "1", name: "Paracetamol 500mg", price: 5.99, category: "Pain Relief", stock: 150, barcode: "8901234567890" },
  { id: "2", name: "Ibuprofen 400mg", price: 7.99, category: "Pain Relief", stock: 120, barcode: "8901234567891" },
  { id: "3", name: "Vitamin C 1000mg", price: 12.99, category: "Vitamins", stock: 80, barcode: "8901234567892" },
  { id: "4", name: "Multivitamin Daily", price: 15.99, category: "Vitamins", stock: 95, barcode: "8901234567893" },
  { id: "5", name: "Cough Syrup 100ml", price: 8.99, category: "Cold & Flu", stock: 60, barcode: "8901234567894" },
  { id: "6", name: "Antihistamine 10mg", price: 9.99, category: "Allergy", stock: 70, barcode: "8901234567895" },
  { id: "7", name: "Hand Sanitizer 250ml", price: 4.99, category: "Personal Care", stock: 200, barcode: "8901234567896" },
  { id: "8", name: "Face Masks (50 pack)", price: 14.99, category: "Personal Care", stock: 45, barcode: "8901234567897" },
  { id: "9", name: "Digital Thermometer", price: 19.99, category: "Equipment", stock: 30, barcode: "8901234567898" },
  { id: "10", name: "Blood Pressure Monitor", price: 49.99, category: "Equipment", stock: 15, barcode: "8901234567899" },
  { id: "11", name: "Bandages Assorted", price: 6.99, category: "First Aid", stock: 100, barcode: "8901234567900" },
  { id: "12", name: "Antiseptic Cream 30g", price: 7.49, category: "First Aid", stock: 85, barcode: "8901234567901" },
]

const categories = ["All", "Pain Relief", "Vitamins", "Cold & Flu", "Allergy", "Personal Care", "Equipment", "First Aid"]

export default function POSPage() {
  const [searchQuery, setSearchQuery] = useState("")
  const [selectedCategory, setSelectedCategory] = useState("All")
  const [cart, setCart] = useState<CartItem[]>([])
  const [showPaymentDialog, setShowPaymentDialog] = useState(false)
  const [paymentMethod, setPaymentMethod] = useState<string | null>(null)
  const [cashReceived, setCashReceived] = useState("")
  const [showSuccessDialog, setShowSuccessDialog] = useState(false)

  const filteredProducts = products.filter((product) => {
    const matchesSearch = product.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      product.barcode.includes(searchQuery)
    const matchesCategory = selectedCategory === "All" || product.category === selectedCategory
    return matchesSearch && matchesCategory
  })

  const addToCart = (product: Product) => {
    setCart((prev) => {
      const existing = prev.find((item) => item.id === product.id)
      if (existing) {
        return prev.map((item) =>
          item.id === product.id ? { ...item, quantity: item.quantity + 1 } : item
        )
      }
      return [...prev, { ...product, quantity: 1 }]
    })
  }

  const updateQuantity = (id: string, delta: number) => {
    setCart((prev) =>
      prev
        .map((item) =>
          item.id === id ? { ...item, quantity: Math.max(0, item.quantity + delta) } : item
        )
        .filter((item) => item.quantity > 0)
    )
  }

  const removeFromCart = (id: string) => {
    setCart((prev) => prev.filter((item) => item.id !== id))
  }

  const clearCart = () => {
    setCart([])
  }

  const subtotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0)
  const tax = subtotal * 0.08
  const total = subtotal + tax

  const handlePayment = () => {
    setShowPaymentDialog(false)
    setShowSuccessDialog(true)
    setTimeout(() => {
      setShowSuccessDialog(false)
      clearCart()
      setPaymentMethod(null)
      setCashReceived("")
    }, 3000)
  }

  const change = paymentMethod === "cash" && cashReceived ? parseFloat(cashReceived) - total : 0

  return (
    <div className="flex h-full">
      {/* Product Selection */}
      <div className="flex-1 flex flex-col p-4 border-r border-border">
        {/* Search and Categories */}
        <div className="space-y-4 mb-4">
          <div className="relative">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
            <Input
              placeholder="Search products or scan barcode..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="pl-10"
            />
            <Barcode className="absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
          </div>
          <div className="flex flex-wrap gap-2">
            {categories.map((category) => (
              <Button
                key={category}
                variant={selectedCategory === category ? "default" : "outline"}
                size="sm"
                onClick={() => setSelectedCategory(category)}
              >
                {category}
              </Button>
            ))}
          </div>
        </div>

        {/* Product Grid */}
        <div className="flex-1 overflow-auto">
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            {filteredProducts.map((product) => (
              <Card
                key={product.id}
                className="cursor-pointer transition-all hover:shadow-md hover:border-primary/50"
                onClick={() => addToCart(product)}
              >
                <CardContent className="p-4">
                  <div className="aspect-square bg-accent/30 rounded-lg mb-3 flex items-center justify-center">
                    <span className="text-3xl text-primary/50">
                      {product.category === "Pain Relief" && "💊"}
                      {product.category === "Vitamins" && "🍊"}
                      {product.category === "Cold & Flu" && "🤧"}
                      {product.category === "Allergy" && "🌸"}
                      {product.category === "Personal Care" && "🧴"}
                      {product.category === "Equipment" && "🩺"}
                      {product.category === "First Aid" && "🩹"}
                    </span>
                  </div>
                  <h3 className="font-medium text-sm line-clamp-2 mb-1">{product.name}</h3>
                  <div className="flex items-center justify-between">
                    <span className="font-bold text-primary">${product.price.toFixed(2)}</span>
                    <Badge variant="secondary" className="text-xs">
                      {product.stock} in stock
                    </Badge>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </div>

      {/* Cart */}
      <div className="w-96 flex flex-col bg-card">
        <CardHeader className="border-b border-border">
          <div className="flex items-center justify-between">
            <CardTitle className="flex items-center gap-2">
              <Receipt className="h-5 w-5" />
              Current Sale
            </CardTitle>
            {cart.length > 0 && (
              <Button variant="ghost" size="sm" onClick={clearCart} className="text-destructive hover:text-destructive">
                <X className="h-4 w-4 mr-1" />
                Clear
              </Button>
            )}
          </div>
        </CardHeader>

        <div className="flex-1 overflow-auto p-4">
          {cart.length === 0 ? (
            <div className="flex flex-col items-center justify-center h-full text-muted-foreground">
              <Receipt className="h-12 w-12 mb-4 opacity-50" />
              <p>No items in cart</p>
              <p className="text-sm">Click products to add them</p>
            </div>
          ) : (
            <div className="space-y-3">
              {cart.map((item) => (
                <div key={item.id} className="flex items-center gap-3 p-3 bg-accent/30 rounded-lg">
                  <div className="flex-1 min-w-0">
                    <p className="font-medium text-sm truncate">{item.name}</p>
                    <p className="text-sm text-muted-foreground">${item.price.toFixed(2)} each</p>
                  </div>
                  <div className="flex items-center gap-2">
                    <Button
                      variant="outline"
                      size="icon"
                      className="h-8 w-8"
                      onClick={() => updateQuantity(item.id, -1)}
                    >
                      <Minus className="h-3 w-3" />
                    </Button>
                    <span className="w-8 text-center font-medium">{item.quantity}</span>
                    <Button
                      variant="outline"
                      size="icon"
                      className="h-8 w-8"
                      onClick={() => updateQuantity(item.id, 1)}
                    >
                      <Plus className="h-3 w-3" />
                    </Button>
                    <Button
                      variant="ghost"
                      size="icon"
                      className="h-8 w-8 text-destructive hover:text-destructive"
                      onClick={() => removeFromCart(item.id)}
                    >
                      <Trash2 className="h-4 w-4" />
                    </Button>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>

        {/* Cart Summary */}
        <div className="border-t border-border p-4 space-y-4">
          <div className="space-y-2">
            <div className="flex justify-between text-sm">
              <span className="text-muted-foreground">Subtotal</span>
              <span>${subtotal.toFixed(2)}</span>
            </div>
            <div className="flex justify-between text-sm">
              <span className="text-muted-foreground">Tax (8%)</span>
              <span>${tax.toFixed(2)}</span>
            </div>
            <div className="flex justify-between text-lg font-bold pt-2 border-t border-border">
              <span>Total</span>
              <span className="text-primary">${total.toFixed(2)}</span>
            </div>
          </div>

          <Button
            className="w-full h-12 text-lg"
            disabled={cart.length === 0}
            onClick={() => setShowPaymentDialog(true)}
          >
            <CreditCard className="mr-2 h-5 w-5" />
            Pay ${total.toFixed(2)}
          </Button>
        </div>
      </div>

      {/* Payment Dialog */}
      <Dialog open={showPaymentDialog} onOpenChange={setShowPaymentDialog}>
        <DialogContent className="sm:max-w-md">
          <DialogHeader>
            <DialogTitle>Select Payment Method</DialogTitle>
            <DialogDescription>
              Total amount: <span className="font-bold text-primary">${total.toFixed(2)}</span>
            </DialogDescription>
          </DialogHeader>

          <div className="grid grid-cols-3 gap-4 py-4">
            <Button
              variant={paymentMethod === "cash" ? "default" : "outline"}
              className="h-24 flex-col gap-2"
              onClick={() => setPaymentMethod("cash")}
            >
              <Banknote className="h-8 w-8" />
              <span>Cash</span>
            </Button>
            <Button
              variant={paymentMethod === "card" ? "default" : "outline"}
              className="h-24 flex-col gap-2"
              onClick={() => setPaymentMethod("card")}
            >
              <CreditCard className="h-8 w-8" />
              <span>Card</span>
            </Button>
            <Button
              variant={paymentMethod === "mobile" ? "default" : "outline"}
              className="h-24 flex-col gap-2"
              onClick={() => setPaymentMethod("mobile")}
            >
              <Smartphone className="h-8 w-8" />
              <span>Mobile</span>
            </Button>
          </div>

          {paymentMethod === "cash" && (
            <div className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="cash-received">Cash Received</Label>
                <Input
                  id="cash-received"
                  type="number"
                  placeholder="0.00"
                  value={cashReceived}
                  onChange={(e) => setCashReceived(e.target.value)}
                />
              </div>
              {change > 0 && (
                <div className="p-3 bg-green-100 rounded-lg">
                  <p className="text-sm text-muted-foreground">Change to give:</p>
                  <p className="text-xl font-bold text-green-600">${change.toFixed(2)}</p>
                </div>
              )}
            </div>
          )}

          <DialogFooter>
            <Button variant="outline" onClick={() => setShowPaymentDialog(false)}>
              Cancel
            </Button>
            <Button
              onClick={handlePayment}
              disabled={!paymentMethod || (paymentMethod === "cash" && parseFloat(cashReceived || "0") < total)}
            >
              Complete Payment
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      {/* Success Dialog */}
      <Dialog open={showSuccessDialog} onOpenChange={setShowSuccessDialog}>
        <DialogContent className="sm:max-w-md text-center">
          <div className="py-8">
            <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
              <Receipt className="h-8 w-8 text-green-600" />
            </div>
            <DialogTitle className="text-2xl mb-2">Payment Successful!</DialogTitle>
            <DialogDescription>
              Transaction completed. Receipt has been printed.
            </DialogDescription>
          </div>
        </DialogContent>
      </Dialog>
    </div>
  )
}
