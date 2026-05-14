"use client"

import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { CreditCard, Plus, Pencil, Trash2, Check } from "lucide-react"
import { Badge } from "@/components/ui/badge"

const paymentMethods = [
  {
    id: "1",
    type: "Visa",
    lastFour: "4242",
    expiry: "12/25",
    holderName: "John Doe",
    isDefault: true,
  },
  {
    id: "2",
    type: "Mastercard",
    lastFour: "8888",
    expiry: "06/26",
    holderName: "John Doe",
    isDefault: false,
  },
]

export default function PaymentPage() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-serif font-bold">Payment Methods</h1>
          <p className="text-muted-foreground">Manage your saved payment methods</p>
        </div>
        <Button>
          <Plus className="mr-2 h-4 w-4" />
          Add Card
        </Button>
      </div>

      <div className="grid gap-4 md:grid-cols-2">
        {paymentMethods.map((method) => (
          <Card key={method.id} className={method.isDefault ? "border-primary" : ""}>
            <CardHeader className="flex flex-row items-start justify-between pb-2">
              <div className="flex items-center gap-3">
                <div className="w-12 h-8 rounded bg-gradient-to-r from-primary to-accent flex items-center justify-center">
                  <CreditCard className="h-5 w-5 text-primary-foreground" />
                </div>
                <div>
                  <CardTitle className="text-base">{method.type} •••• {method.lastFour}</CardTitle>
                  {method.isDefault && (
                    <Badge variant="secondary" className="mt-1">
                      <Check className="mr-1 h-3 w-3" />
                      Default
                    </Badge>
                  )}
                </div>
              </div>
              <div className="flex gap-1">
                <Button variant="ghost" size="icon" className="h-8 w-8">
                  <Pencil className="h-4 w-4" />
                </Button>
                <Button variant="ghost" size="icon" className="h-8 w-8 text-destructive hover:text-destructive">
                  <Trash2 className="h-4 w-4" />
                </Button>
              </div>
            </CardHeader>
            <CardContent>
              <div className="space-y-1 text-sm">
                <p className="font-medium">{method.holderName}</p>
                <p className="text-muted-foreground">Expires {method.expiry}</p>
              </div>
              {!method.isDefault && (
                <Button variant="outline" size="sm" className="mt-4">
                  Set as Default
                </Button>
              )}
            </CardContent>
          </Card>
        ))}

        {/* Add New Card */}
        <Card className="border-dashed cursor-pointer hover:border-primary transition-colors">
          <CardContent className="flex flex-col items-center justify-center h-full min-h-[150px]">
            <div className="w-12 h-12 rounded-full bg-accent flex items-center justify-center mb-3">
              <Plus className="h-6 w-6 text-muted-foreground" />
            </div>
            <p className="font-medium">Add New Card</p>
            <p className="text-sm text-muted-foreground">Save a new payment method</p>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}
