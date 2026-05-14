"use client"

import { use } from "react"
import Link from "next/link"
import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Separator } from "@/components/ui/separator"
import { 
  ChevronRight, 
  Package, 
  Truck, 
  MapPin, 
  CreditCard, 
  Calendar,
  Phone,
  Mail,
  Printer,
  Download,
  Check,
  Clock
} from "lucide-react"

const orderData = {
  id: "LP-12345678",
  date: "2024-01-15",
  status: "Delivered",
  total: 156.50,
  subtotal: 134.00,
  vat: 16.08,
  deliveryFee: 0,
  discount: 0,
  items: [
    { id: 1, name: "Biogesic Paracetamol", genericName: "Paracetamol 500mg", quantity: 2, price: 5.50 },
    { id: 2, name: "Neozep Forte", genericName: "Phenylephrine + Chlorphenamine", quantity: 1, price: 12.00 },
    { id: 9, name: "Enervon C", genericName: "Multivitamins + Vitamin C", quantity: 3, price: 9.00 }
  ],
  customer: {
    name: "Juan Dela Cruz",
    email: "juan.delacruz@email.com",
    phone: "+63 917 123 4567"
  },
  deliveryAddress: {
    street: "123 Main Street, Barangay San Antonio",
    city: "Makati City",
    province: "Metro Manila",
    zipCode: "1200"
  },
  paymentMethod: "Cash on Delivery",
  paymentStatus: "Paid",
  timeline: [
    { status: "Order Placed", date: "2024-01-15 10:30 AM", completed: true },
    { status: "Payment Confirmed", date: "2024-01-15 10:35 AM", completed: true },
    { status: "Processing", date: "2024-01-15 11:00 AM", completed: true },
    { status: "Out for Delivery", date: "2024-01-16 09:00 AM", completed: true },
    { status: "Delivered", date: "2024-01-16 02:30 PM", completed: true }
  ]
}

export default function OrderDetailPage({ params }: { params: Promise<{ id: string }> }) {
  const resolvedParams = use(params)
  const orderId = resolvedParams.id

  const getStatusColor = (status: string) => {
    switch (status) {
      case "Delivered": return "bg-green-100 text-green-800"
      case "Processing": return "bg-blue-100 text-blue-800"
      case "Pending": return "bg-yellow-100 text-yellow-800"
      case "Cancelled": return "bg-red-100 text-red-800"
      default: return "bg-gray-100 text-gray-800"
    }
  }

  return (
    <main className="min-h-screen bg-background">
      <Navbar />
      
      {/* Breadcrumb */}
      <section className="pt-28 pb-4">
        <div className="container mx-auto px-4">
          <nav className="flex items-center text-sm text-muted-foreground">
            <Link href="/customer/profile" className="hover:text-primary transition-colors">My Account</Link>
            <ChevronRight className="w-4 h-4 mx-2" />
            <Link href="/customer/orders" className="hover:text-primary transition-colors">Orders</Link>
            <ChevronRight className="w-4 h-4 mx-2" />
            <span className="text-foreground">{orderId}</span>
          </nav>
        </div>
      </section>

      <section className="pb-20">
        <div className="container mx-auto px-4">
          {/* Header */}
          <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
              <h1 className="text-2xl font-serif font-bold text-foreground">Order {orderId}</h1>
              <div className="flex items-center gap-3 mt-2">
                <Badge className={getStatusColor(orderData.status)}>
                  {orderData.status}
                </Badge>
                <span className="text-sm text-muted-foreground">
                  Placed on {new Date(orderData.date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                  })}
                </span>
              </div>
            </div>
            <div className="flex gap-2">
              <Button variant="outline" size="sm">
                <Printer className="w-4 h-4 mr-2" />
                Print
              </Button>
              <Button variant="outline" size="sm">
                <Download className="w-4 h-4 mr-2" />
                Download Receipt
              </Button>
            </div>
          </div>

          <div className="grid lg:grid-cols-3 gap-8">
            {/* Main Content */}
            <div className="lg:col-span-2 space-y-6">
              {/* Order Items */}
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <Package className="w-5 h-5" />
                    Order Items
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="space-y-4">
                    {orderData.items.map((item) => (
                      <div key={item.id} className="flex items-center gap-4 p-3 rounded-lg bg-muted/30">
                        <div className="w-14 h-14 rounded-lg bg-muted flex items-center justify-center">
                          <div className="w-10 h-10 rounded-full bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                            <span className="text-lg font-bold text-primary/50">
                              {item.name.charAt(0)}
                            </span>
                          </div>
                        </div>
                        <div className="flex-1">
                          <Link href={`/shop/${item.id}`} className="font-medium text-foreground hover:text-primary transition-colors">
                            {item.name}
                          </Link>
                          <p className="text-sm text-muted-foreground">{item.genericName}</p>
                        </div>
                        <div className="text-right">
                          <p className="font-medium">₱{(item.price * item.quantity).toFixed(2)}</p>
                          <p className="text-sm text-muted-foreground">
                            ₱{item.price.toFixed(2)} x {item.quantity}
                          </p>
                        </div>
                      </div>
                    ))}
                  </div>

                  <Separator className="my-4" />

                  {/* Price Summary */}
                  <div className="space-y-2">
                    <div className="flex justify-between text-sm">
                      <span className="text-muted-foreground">Subtotal</span>
                      <span>₱{orderData.subtotal.toFixed(2)}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-muted-foreground">VAT (12%)</span>
                      <span>₱{orderData.vat.toFixed(2)}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-muted-foreground">Delivery Fee</span>
                      <span>{orderData.deliveryFee === 0 ? "FREE" : `₱${orderData.deliveryFee.toFixed(2)}`}</span>
                    </div>
                    {orderData.discount > 0 && (
                      <div className="flex justify-between text-sm text-green-600">
                        <span>Discount</span>
                        <span>-₱{orderData.discount.toFixed(2)}</span>
                      </div>
                    )}
                    <Separator />
                    <div className="flex justify-between font-bold text-lg">
                      <span>Total</span>
                      <span className="text-primary">₱{orderData.total.toFixed(2)}</span>
                    </div>
                  </div>
                </CardContent>
              </Card>

              {/* Order Timeline */}
              <Card>
                <CardHeader>
                  <CardTitle className="flex items-center gap-2">
                    <Truck className="w-5 h-5" />
                    Order Timeline
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="relative">
                    {orderData.timeline.map((event, index) => (
                      <div key={index} className="flex gap-4 pb-6 last:pb-0">
                        <div className="relative">
                          <div className={`w-8 h-8 rounded-full flex items-center justify-center ${
                            event.completed ? 'bg-green-100' : 'bg-muted'
                          }`}>
                            {event.completed ? (
                              <Check className="w-4 h-4 text-green-600" />
                            ) : (
                              <Clock className="w-4 h-4 text-muted-foreground" />
                            )}
                          </div>
                          {index < orderData.timeline.length - 1 && (
                            <div className={`absolute top-8 left-1/2 transform -translate-x-1/2 w-0.5 h-full ${
                              event.completed ? 'bg-green-200' : 'bg-muted'
                            }`} />
                          )}
                        </div>
                        <div className="flex-1 pb-2">
                          <p className={`font-medium ${event.completed ? 'text-foreground' : 'text-muted-foreground'}`}>
                            {event.status}
                          </p>
                          <p className="text-sm text-muted-foreground">{event.date}</p>
                        </div>
                      </div>
                    ))}
                  </div>
                </CardContent>
              </Card>
            </div>

            {/* Sidebar */}
            <div className="space-y-6">
              {/* Customer Info */}
              <Card>
                <CardHeader>
                  <CardTitle className="text-base">Customer Information</CardTitle>
                </CardHeader>
                <CardContent className="space-y-3">
                  <div className="flex items-center gap-3">
                    <div className="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                      <span className="text-sm font-bold text-primary">
                        {orderData.customer.name.split(' ').map(n => n[0]).join('')}
                      </span>
                    </div>
                    <span className="font-medium">{orderData.customer.name}</span>
                  </div>
                  <div className="flex items-center gap-3 text-sm text-muted-foreground">
                    <Mail className="w-4 h-4" />
                    {orderData.customer.email}
                  </div>
                  <div className="flex items-center gap-3 text-sm text-muted-foreground">
                    <Phone className="w-4 h-4" />
                    {orderData.customer.phone}
                  </div>
                </CardContent>
              </Card>

              {/* Delivery Address */}
              <Card>
                <CardHeader>
                  <CardTitle className="text-base flex items-center gap-2">
                    <MapPin className="w-4 h-4" />
                    Delivery Address
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <p className="text-sm text-muted-foreground">
                    {orderData.deliveryAddress.street}<br />
                    {orderData.deliveryAddress.city}, {orderData.deliveryAddress.province}<br />
                    {orderData.deliveryAddress.zipCode}
                  </p>
                </CardContent>
              </Card>

              {/* Payment Info */}
              <Card>
                <CardHeader>
                  <CardTitle className="text-base flex items-center gap-2">
                    <CreditCard className="w-4 h-4" />
                    Payment Information
                  </CardTitle>
                </CardHeader>
                <CardContent className="space-y-2">
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Method</span>
                    <span>{orderData.paymentMethod}</span>
                  </div>
                  <div className="flex justify-between text-sm">
                    <span className="text-muted-foreground">Status</span>
                    <Badge variant="outline" className="bg-green-50 text-green-700 border-green-200">
                      {orderData.paymentStatus}
                    </Badge>
                  </div>
                </CardContent>
              </Card>

              {/* Actions */}
              <Card>
                <CardContent className="pt-6 space-y-3">
                  <Button variant="outline" className="w-full">
                    Need Help?
                  </Button>
                  <Button variant="outline" className="w-full">
                    Reorder Items
                  </Button>
                </CardContent>
              </Card>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </main>
  )
}
