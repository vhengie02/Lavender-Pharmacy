"use client"

import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { MapPin, Plus, Pencil, Trash2, Check } from "lucide-react"
import { Badge } from "@/components/ui/badge"

const addresses = [
  {
    id: "1",
    label: "Home",
    name: "John Doe",
    address: "123 Main Street",
    city: "Medical City",
    state: "CA",
    zip: "90210",
    phone: "(555) 123-4567",
    isDefault: true,
  },
  {
    id: "2",
    label: "Office",
    name: "John Doe",
    address: "456 Business Ave, Suite 200",
    city: "Commerce Town",
    state: "CA",
    zip: "90211",
    phone: "(555) 987-6543",
    isDefault: false,
  },
]

export default function AddressesPage() {
  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-serif font-bold">My Addresses</h1>
          <p className="text-muted-foreground">Manage your delivery addresses</p>
        </div>
        <Button>
          <Plus className="mr-2 h-4 w-4" />
          Add Address
        </Button>
      </div>

      <div className="grid gap-4 md:grid-cols-2">
        {addresses.map((address) => (
          <Card key={address.id} className={address.isDefault ? "border-primary" : ""}>
            <CardHeader className="flex flex-row items-start justify-between pb-2">
              <div className="flex items-center gap-2">
                <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                  <MapPin className="h-5 w-5 text-primary" />
                </div>
                <div>
                  <CardTitle className="text-base">{address.label}</CardTitle>
                  {address.isDefault && (
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
                <p className="font-medium">{address.name}</p>
                <p className="text-muted-foreground">{address.address}</p>
                <p className="text-muted-foreground">
                  {address.city}, {address.state} {address.zip}
                </p>
                <p className="text-muted-foreground">{address.phone}</p>
              </div>
              {!address.isDefault && (
                <Button variant="outline" size="sm" className="mt-4">
                  Set as Default
                </Button>
              )}
            </CardContent>
          </Card>
        ))}

        {/* Add New Address Card */}
        <Card className="border-dashed cursor-pointer hover:border-primary transition-colors">
          <CardContent className="flex flex-col items-center justify-center h-full min-h-[200px]">
            <div className="w-12 h-12 rounded-full bg-accent flex items-center justify-center mb-3">
              <Plus className="h-6 w-6 text-muted-foreground" />
            </div>
            <p className="font-medium">Add New Address</p>
            <p className="text-sm text-muted-foreground">Save a new delivery location</p>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}
