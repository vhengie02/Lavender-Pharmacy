"use client"

import { Card, CardContent } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Heart, ShoppingCart, Trash2 } from "lucide-react"
import { Badge } from "@/components/ui/badge"

const wishlistItems = [
  {
    id: "1",
    name: "Blood Pressure Monitor",
    price: 49.99,
    originalPrice: 59.99,
    image: "/placeholder.svg",
    inStock: true,
  },
  {
    id: "2",
    name: "Vitamin D3 5000IU",
    price: 18.99,
    originalPrice: null,
    image: "/placeholder.svg",
    inStock: true,
  },
  {
    id: "3",
    name: "Omega-3 Fish Oil",
    price: 24.99,
    originalPrice: 29.99,
    image: "/placeholder.svg",
    inStock: false,
  },
]

export default function WishlistPage() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-serif font-bold">My Wishlist</h1>
          <p className="text-muted-foreground">{wishlistItems.length} items saved</p>
        </div>
      </div>

      {wishlistItems.length === 0 ? (
        <Card>
          <CardContent className="flex flex-col items-center justify-center py-12">
            <Heart className="h-12 w-12 text-muted-foreground/50 mb-4" />
            <h3 className="text-lg font-medium mb-2">Your wishlist is empty</h3>
            <p className="text-muted-foreground text-center mb-4">
              Save items you love to your wishlist and buy them later.
            </p>
            <Button>Start Shopping</Button>
          </CardContent>
        </Card>
      ) : (
        <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
          {wishlistItems.map((item) => (
            <Card key={item.id}>
              <CardContent className="p-4">
                <div className="aspect-square bg-accent/30 rounded-lg mb-4 relative">
                  {item.originalPrice && (
                    <Badge className="absolute top-2 left-2" variant="destructive">
                      Sale
                    </Badge>
                  )}
                  <Button
                    variant="ghost"
                    size="icon"
                    className="absolute top-2 right-2 text-destructive hover:text-destructive"
                  >
                    <Trash2 className="h-4 w-4" />
                  </Button>
                </div>
                <h3 className="font-medium mb-2">{item.name}</h3>
                <div className="flex items-center gap-2 mb-4">
                  <span className="font-bold text-primary">${item.price.toFixed(2)}</span>
                  {item.originalPrice && (
                    <span className="text-sm text-muted-foreground line-through">
                      ${item.originalPrice.toFixed(2)}
                    </span>
                  )}
                </div>
                <Button 
                  className="w-full" 
                  disabled={!item.inStock}
                >
                  <ShoppingCart className="mr-2 h-4 w-4" />
                  {item.inStock ? "Add to Cart" : "Out of Stock"}
                </Button>
              </CardContent>
            </Card>
          ))}
        </div>
      )}
    </div>
  )
}
