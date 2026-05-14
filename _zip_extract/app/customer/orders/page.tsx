"use client"

import { useState } from "react"
import Link from "next/link"
import { Navbar } from "@/components/navbar"
import { Footer } from "@/components/footer"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Input } from "@/components/ui/input"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"
import { 
  Package, 
  Search, 
  ChevronRight, 
  Calendar,
  ShoppingBag,
  Truck,
  Check,
  Clock,
  X
} from "lucide-react"

const allOrders = [
  {
    id: "LP-12345678",
    date: "2024-01-15",
    status: "Delivered",
    total: 156.50,
    items: [
      { name: "Biogesic Paracetamol", quantity: 2, price: 5.50 },
      { name: "Neozep Forte", quantity: 1, price: 12.00 },
      { name: "Enervon C", quantity: 3, price: 9.00 }
    ],
    paymentMethod: "Cash on Delivery",
    deliveryAddress: "123 Main Street, Makati City"
  },
  {
    id: "LP-12345679",
    date: "2024-01-10",
    status: "Processing",
    total: 89.00,
    items: [
      { name: "Solmux 500mg", quantity: 2, price: 11.00 },
      { name: "Cetirizine 10mg", quantity: 5, price: 3.50 }
    ],
    paymentMethod: "GCash",
    deliveryAddress: "456 Oak Avenue, Quezon City"
  },
  {
    id: "LP-12345680",
    date: "2024-01-05",
    status: "Delivered",
    total: 245.75,
    items: [
      { name: "Amoxicillin 500mg", quantity: 10, price: 8.50 },
      { name: "Vitamin D3", quantity: 1, price: 15.00 }
    ],
    paymentMethod: "Credit Card",
    deliveryAddress: "789 Pine Road, Pasig City"
  },
  {
    id: "LP-12345681",
    date: "2024-01-02",
    status: "Cancelled",
    total: 45.00,
    items: [
      { name: "Diatabs", quantity: 3, price: 6.00 },
      { name: "Kremil-S", quantity: 2, price: 7.50 }
    ],
    paymentMethod: "Cash on Delivery",
    deliveryAddress: "321 Elm Street, Manila"
  },
  {
    id: "LP-12345682",
    date: "2024-01-18",
    status: "Pending",
    total: 120.00,
    items: [
      { name: "Medicol Advance", quantity: 5, price: 8.00 },
      { name: "Bioflu", quantity: 4, price: 15.00 }
    ],
    paymentMethod: "GCash",
    deliveryAddress: "555 Cedar Lane, Taguig City"
  }
]

export default function CustomerOrdersPage() {
  const [searchQuery, setSearchQuery] = useState("")
  const [statusFilter, setStatusFilter] = useState("all")
  const [activeTab, setActiveTab] = useState("all")

  const getStatusColor = (status: string) => {
    switch (status) {
      case "Delivered": return "bg-green-100 text-green-800"
      case "Processing": return "bg-blue-100 text-blue-800"
      case "Pending": return "bg-yellow-100 text-yellow-800"
      case "Cancelled": return "bg-red-100 text-red-800"
      default: return "bg-gray-100 text-gray-800"
    }
  }

  const getStatusIcon = (status: string) => {
    switch (status) {
      case "Delivered": return <Check className="w-4 h-4" />
      case "Processing": return <Truck className="w-4 h-4" />
      case "Pending": return <Clock className="w-4 h-4" />
      case "Cancelled": return <X className="w-4 h-4" />
      default: return <Package className="w-4 h-4" />
    }
  }

  const filterOrders = (orders: typeof allOrders) => {
    return orders.filter(order => {
      const matchesSearch = order.id.toLowerCase().includes(searchQuery.toLowerCase()) ||
        order.items.some(item => item.name.toLowerCase().includes(searchQuery.toLowerCase()))
      const matchesStatus = statusFilter === "all" || order.status.toLowerCase() === statusFilter
      const matchesTab = activeTab === "all" || order.status.toLowerCase() === activeTab
      return matchesSearch && matchesStatus && matchesTab
    })
  }

  const filteredOrders = filterOrders(allOrders)

  const orderCounts = {
    all: allOrders.length,
    pending: allOrders.filter(o => o.status === "Pending").length,
    processing: allOrders.filter(o => o.status === "Processing").length,
    delivered: allOrders.filter(o => o.status === "Delivered").length,
    cancelled: allOrders.filter(o => o.status === "Cancelled").length
  }

  return (
    <main className="min-h-screen bg-background">
      <Navbar />
      
      <section className="pt-32 pb-8">
        <div className="container mx-auto px-4">
          <h1 className="text-3xl font-serif font-bold text-foreground mb-2">My Orders</h1>
          <p className="text-muted-foreground">Track and manage your orders</p>
        </div>
      </section>

      <section className="pb-20">
        <div className="container mx-auto px-4">
          {/* Filters */}
          <div className="flex flex-col sm:flex-row gap-4 mb-6">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
              <Input
                placeholder="Search by order ID or product..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-10"
              />
            </div>
            <Select value={statusFilter} onValueChange={setStatusFilter}>
              <SelectTrigger className="w-full sm:w-40">
                <SelectValue placeholder="Filter by status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Status</SelectItem>
                <SelectItem value="pending">Pending</SelectItem>
                <SelectItem value="processing">Processing</SelectItem>
                <SelectItem value="delivered">Delivered</SelectItem>
                <SelectItem value="cancelled">Cancelled</SelectItem>
              </SelectContent>
            </Select>
          </div>

          {/* Tabs */}
          <Tabs value={activeTab} onValueChange={setActiveTab} className="space-y-6">
            <TabsList className="w-full justify-start overflow-x-auto">
              <TabsTrigger value="all">
                All ({orderCounts.all})
              </TabsTrigger>
              <TabsTrigger value="pending">
                Pending ({orderCounts.pending})
              </TabsTrigger>
              <TabsTrigger value="processing">
                Processing ({orderCounts.processing})
              </TabsTrigger>
              <TabsTrigger value="delivered">
                Delivered ({orderCounts.delivered})
              </TabsTrigger>
              <TabsTrigger value="cancelled">
                Cancelled ({orderCounts.cancelled})
              </TabsTrigger>
            </TabsList>

            <TabsContent value={activeTab}>
              {filteredOrders.length > 0 ? (
                <div className="space-y-4">
                  {filteredOrders.map((order) => (
                    <Card key={order.id} className="overflow-hidden hover:shadow-lg transition-shadow">
                      <CardHeader className="bg-muted/30 py-4">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                          <div className="flex items-center gap-4">
                            <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                              {getStatusIcon(order.status)}
                            </div>
                            <div>
                              <CardTitle className="text-base">{order.id}</CardTitle>
                              <div className="flex items-center gap-2 text-sm text-muted-foreground">
                                <Calendar className="w-3 h-3" />
                                {new Date(order.date).toLocaleDateString('en-US', {
                                  year: 'numeric',
                                  month: 'long',
                                  day: 'numeric'
                                })}
                              </div>
                            </div>
                          </div>
                          <div className="flex items-center gap-3">
                            <Badge className={getStatusColor(order.status)}>
                              {order.status}
                            </Badge>
                            <span className="font-bold text-lg">₱{order.total.toFixed(2)}</span>
                          </div>
                        </div>
                      </CardHeader>
                      <CardContent className="py-4">
                        <div className="space-y-3">
                          {order.items.slice(0, 2).map((item, index) => (
                            <div key={index} className="flex items-center justify-between text-sm">
                              <div className="flex items-center gap-3">
                                <div className="w-8 h-8 rounded bg-muted/50 flex items-center justify-center">
                                  <span className="text-xs font-bold text-primary/50">
                                    {item.name.charAt(0)}
                                  </span>
                                </div>
                                <span className="text-foreground">{item.name}</span>
                                <span className="text-muted-foreground">x{item.quantity}</span>
                              </div>
                              <span className="text-foreground">₱{(item.price * item.quantity).toFixed(2)}</span>
                            </div>
                          ))}
                          {order.items.length > 2 && (
                            <p className="text-sm text-muted-foreground">
                              +{order.items.length - 2} more item(s)
                            </p>
                          )}
                        </div>
                        <div className="flex items-center justify-between mt-4 pt-4 border-t">
                          <div className="text-sm text-muted-foreground">
                            <span className="font-medium">Payment:</span> {order.paymentMethod}
                          </div>
                          <Link href={`/customer/orders/${order.id}`}>
                            <Button variant="outline" size="sm">
                              View Details
                              <ChevronRight className="w-4 h-4 ml-1" />
                            </Button>
                          </Link>
                        </div>
                      </CardContent>
                    </Card>
                  ))}
                </div>
              ) : (
                <Card>
                  <CardContent className="py-12 text-center">
                    <ShoppingBag className="w-16 h-16 text-muted-foreground mx-auto mb-4" />
                    <h3 className="text-lg font-medium text-foreground mb-2">No orders found</h3>
                    <p className="text-muted-foreground mb-6">
                      {searchQuery || statusFilter !== "all" 
                        ? "Try adjusting your search or filter"
                        : "You haven't placed any orders yet"}
                    </p>
                    <Link href="/shop">
                      <Button className="bg-primary hover:bg-primary/90">
                        Start Shopping
                      </Button>
                    </Link>
                  </CardContent>
                </Card>
              )}
            </TabsContent>
          </Tabs>
        </div>
      </section>

      <Footer />
    </main>
  )
}
