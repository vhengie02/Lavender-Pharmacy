"use client"

import { useState } from "react"
import { AdminHeader } from "@/components/admin-sidebar"
import { Button } from "@/components/ui/button"
import { Card, CardContent } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Badge } from "@/components/ui/badge"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { 
  Search, 
  Eye,
  MoreHorizontal,
  ShoppingCart,
  Clock,
  Truck,
  Check,
  X,
  Calendar
} from "lucide-react"
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import { Separator } from "@/components/ui/separator"

const initialOrders = [
  { 
    id: "LP-12345678", 
    customer: "Juan Dela Cruz", 
    email: "juan@email.com",
    phone: "+63 917 123 4567",
    date: "2024-01-15", 
    total: 156.50, 
    status: "Processing",
    paymentMethod: "Cash on Delivery",
    paymentStatus: "Pending",
    items: [
      { name: "Biogesic Paracetamol", quantity: 2, price: 5.50 },
      { name: "Neozep Forte", quantity: 1, price: 12.00 }
    ],
    address: "123 Main St, Makati City"
  },
  { 
    id: "LP-12345679", 
    customer: "Maria Santos", 
    email: "maria@email.com",
    phone: "+63 918 234 5678",
    date: "2024-01-15", 
    total: 89.00, 
    status: "Pending",
    paymentMethod: "GCash",
    paymentStatus: "Paid",
    items: [
      { name: "Solmux 500mg", quantity: 2, price: 11.00 },
      { name: "Cetirizine 10mg", quantity: 5, price: 3.50 }
    ],
    address: "456 Oak Ave, Quezon City"
  },
  { 
    id: "LP-12345680", 
    customer: "Pedro Reyes", 
    email: "pedro@email.com",
    phone: "+63 919 345 6789",
    date: "2024-01-14", 
    total: 245.75, 
    status: "Delivered",
    paymentMethod: "Credit Card",
    paymentStatus: "Paid",
    items: [
      { name: "Amoxicillin 500mg", quantity: 10, price: 8.50 }
    ],
    address: "789 Pine Rd, Pasig City"
  },
  { 
    id: "LP-12345681", 
    customer: "Ana Garcia", 
    email: "ana@email.com",
    phone: "+63 920 456 7890",
    date: "2024-01-14", 
    total: 45.00, 
    status: "Cancelled",
    paymentMethod: "Cash on Delivery",
    paymentStatus: "N/A",
    items: [
      { name: "Kremil-S", quantity: 2, price: 7.50 }
    ],
    address: "321 Elm St, Manila"
  },
  { 
    id: "LP-12345682", 
    customer: "Miguel Cruz", 
    email: "miguel@email.com",
    phone: "+63 921 567 8901",
    date: "2024-01-13", 
    total: 120.00, 
    status: "Processing",
    paymentMethod: "GCash",
    paymentStatus: "Paid",
    items: [
      { name: "Medicol Advance", quantity: 5, price: 8.00 },
      { name: "Bioflu", quantity: 4, price: 15.00 }
    ],
    address: "555 Cedar Ln, Taguig City"
  }
]

export default function AdminOrdersPage() {
  const [orders, setOrders] = useState(initialOrders)
  const [searchQuery, setSearchQuery] = useState("")
  const [statusFilter, setStatusFilter] = useState("All")
  const [selectedOrder, setSelectedOrder] = useState<typeof initialOrders[0] | null>(null)
  const [isViewDialogOpen, setIsViewDialogOpen] = useState(false)

  const filteredOrders = orders.filter(order => {
    const matchesSearch = order.id.toLowerCase().includes(searchQuery.toLowerCase()) ||
      order.customer.toLowerCase().includes(searchQuery.toLowerCase())
    const matchesStatus = statusFilter === "All" || order.status === statusFilter
    return matchesSearch && matchesStatus
  })

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
      default: return <ShoppingCart className="w-4 h-4" />
    }
  }

  const updateOrderStatus = (orderId: string, newStatus: string) => {
    setOrders(orders.map(order => 
      order.id === orderId ? { ...order, status: newStatus } : order
    ))
  }

  const handleViewOrder = (order: typeof initialOrders[0]) => {
    setSelectedOrder(order)
    setIsViewDialogOpen(true)
  }

  const orderCounts = {
    all: orders.length,
    pending: orders.filter(o => o.status === "Pending").length,
    processing: orders.filter(o => o.status === "Processing").length,
    delivered: orders.filter(o => o.status === "Delivered").length,
    cancelled: orders.filter(o => o.status === "Cancelled").length
  }

  return (
    <div className="min-h-screen">
      <AdminHeader title="Orders" description="Manage customer orders" />
      
      <div className="p-6 space-y-6">
        {/* Stats */}
        <div className="grid grid-cols-2 lg:grid-cols-5 gap-4">
          <Card className={statusFilter === "All" ? "ring-2 ring-primary" : ""}>
            <CardContent className="p-4 cursor-pointer" onClick={() => setStatusFilter("All")}>
              <div className="flex items-center gap-3">
                <div className="p-2 rounded-lg bg-gray-100">
                  <ShoppingCart className="w-5 h-5 text-gray-600" />
                </div>
                <div>
                  <p className="text-2xl font-bold">{orderCounts.all}</p>
                  <p className="text-sm text-muted-foreground">All Orders</p>
                </div>
              </div>
            </CardContent>
          </Card>
          <Card className={statusFilter === "Pending" ? "ring-2 ring-primary" : ""}>
            <CardContent className="p-4 cursor-pointer" onClick={() => setStatusFilter("Pending")}>
              <div className="flex items-center gap-3">
                <div className="p-2 rounded-lg bg-yellow-100">
                  <Clock className="w-5 h-5 text-yellow-600" />
                </div>
                <div>
                  <p className="text-2xl font-bold">{orderCounts.pending}</p>
                  <p className="text-sm text-muted-foreground">Pending</p>
                </div>
              </div>
            </CardContent>
          </Card>
          <Card className={statusFilter === "Processing" ? "ring-2 ring-primary" : ""}>
            <CardContent className="p-4 cursor-pointer" onClick={() => setStatusFilter("Processing")}>
              <div className="flex items-center gap-3">
                <div className="p-2 rounded-lg bg-blue-100">
                  <Truck className="w-5 h-5 text-blue-600" />
                </div>
                <div>
                  <p className="text-2xl font-bold">{orderCounts.processing}</p>
                  <p className="text-sm text-muted-foreground">Processing</p>
                </div>
              </div>
            </CardContent>
          </Card>
          <Card className={statusFilter === "Delivered" ? "ring-2 ring-primary" : ""}>
            <CardContent className="p-4 cursor-pointer" onClick={() => setStatusFilter("Delivered")}>
              <div className="flex items-center gap-3">
                <div className="p-2 rounded-lg bg-green-100">
                  <Check className="w-5 h-5 text-green-600" />
                </div>
                <div>
                  <p className="text-2xl font-bold">{orderCounts.delivered}</p>
                  <p className="text-sm text-muted-foreground">Delivered</p>
                </div>
              </div>
            </CardContent>
          </Card>
          <Card className={statusFilter === "Cancelled" ? "ring-2 ring-primary" : ""}>
            <CardContent className="p-4 cursor-pointer" onClick={() => setStatusFilter("Cancelled")}>
              <div className="flex items-center gap-3">
                <div className="p-2 rounded-lg bg-red-100">
                  <X className="w-5 h-5 text-red-600" />
                </div>
                <div>
                  <p className="text-2xl font-bold">{orderCounts.cancelled}</p>
                  <p className="text-sm text-muted-foreground">Cancelled</p>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        {/* Filters */}
        <div className="flex flex-col sm:flex-row gap-4">
          <div className="relative flex-1 max-w-md">
            <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
            <Input
              placeholder="Search orders..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="pl-10"
            />
          </div>
          <Select value={statusFilter} onValueChange={setStatusFilter}>
            <SelectTrigger className="w-full sm:w-48">
              <SelectValue placeholder="Status" />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="All">All Status</SelectItem>
              <SelectItem value="Pending">Pending</SelectItem>
              <SelectItem value="Processing">Processing</SelectItem>
              <SelectItem value="Delivered">Delivered</SelectItem>
              <SelectItem value="Cancelled">Cancelled</SelectItem>
            </SelectContent>
          </Select>
        </div>

        {/* Orders Table */}
        <Card>
          <CardContent className="p-0">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Order ID</TableHead>
                  <TableHead>Customer</TableHead>
                  <TableHead>Date</TableHead>
                  <TableHead className="text-right">Total</TableHead>
                  <TableHead>Payment</TableHead>
                  <TableHead>Status</TableHead>
                  <TableHead className="w-12"></TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {filteredOrders.map((order) => (
                  <TableRow key={order.id}>
                    <TableCell className="font-medium">{order.id}</TableCell>
                    <TableCell>
                      <div>
                        <p className="font-medium text-foreground">{order.customer}</p>
                        <p className="text-sm text-muted-foreground">{order.email}</p>
                      </div>
                    </TableCell>
                    <TableCell>
                      <div className="flex items-center gap-2 text-muted-foreground">
                        <Calendar className="w-4 h-4" />
                        {new Date(order.date).toLocaleDateString()}
                      </div>
                    </TableCell>
                    <TableCell className="text-right font-medium">₱{order.total.toFixed(2)}</TableCell>
                    <TableCell>
                      <div>
                        <p className="text-sm">{order.paymentMethod}</p>
                        <Badge variant="outline" className={
                          order.paymentStatus === "Paid" ? "text-green-600" : "text-muted-foreground"
                        }>
                          {order.paymentStatus}
                        </Badge>
                      </div>
                    </TableCell>
                    <TableCell>
                      <Badge className={`${getStatusColor(order.status)} flex items-center gap-1 w-fit`}>
                        {getStatusIcon(order.status)}
                        {order.status}
                      </Badge>
                    </TableCell>
                    <TableCell>
                      <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                          <Button variant="ghost" size="icon">
                            <MoreHorizontal className="w-4 h-4" />
                          </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                          <DropdownMenuItem onClick={() => handleViewOrder(order)}>
                            <Eye className="w-4 h-4 mr-2" />
                            View Details
                          </DropdownMenuItem>
                          {order.status === "Pending" && (
                            <DropdownMenuItem onClick={() => updateOrderStatus(order.id, "Processing")}>
                              <Truck className="w-4 h-4 mr-2" />
                              Mark Processing
                            </DropdownMenuItem>
                          )}
                          {order.status === "Processing" && (
                            <DropdownMenuItem onClick={() => updateOrderStatus(order.id, "Delivered")}>
                              <Check className="w-4 h-4 mr-2" />
                              Mark Delivered
                            </DropdownMenuItem>
                          )}
                          {order.status !== "Cancelled" && order.status !== "Delivered" && (
                            <DropdownMenuItem 
                              className="text-red-600"
                              onClick={() => updateOrderStatus(order.id, "Cancelled")}
                            >
                              <X className="w-4 h-4 mr-2" />
                              Cancel Order
                            </DropdownMenuItem>
                          )}
                        </DropdownMenuContent>
                      </DropdownMenu>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </CardContent>
        </Card>

        {/* Order Details Dialog */}
        <Dialog open={isViewDialogOpen} onOpenChange={setIsViewDialogOpen}>
          <DialogContent className="sm:max-w-lg">
            <DialogHeader>
              <DialogTitle>Order Details</DialogTitle>
              <DialogDescription>{selectedOrder?.id}</DialogDescription>
            </DialogHeader>
            {selectedOrder && (
              <div className="space-y-4">
                <div className="flex items-center justify-between">
                  <Badge className={getStatusColor(selectedOrder.status)}>
                    {selectedOrder.status}
                  </Badge>
                  <span className="text-sm text-muted-foreground">
                    {new Date(selectedOrder.date).toLocaleDateString()}
                  </span>
                </div>

                <Separator />

                <div>
                  <h4 className="font-medium mb-2">Customer</h4>
                  <p className="text-sm">{selectedOrder.customer}</p>
                  <p className="text-sm text-muted-foreground">{selectedOrder.email}</p>
                  <p className="text-sm text-muted-foreground">{selectedOrder.phone}</p>
                </div>

                <div>
                  <h4 className="font-medium mb-2">Delivery Address</h4>
                  <p className="text-sm text-muted-foreground">{selectedOrder.address}</p>
                </div>

                <Separator />

                <div>
                  <h4 className="font-medium mb-2">Items</h4>
                  <div className="space-y-2">
                    {selectedOrder.items.map((item, index) => (
                      <div key={index} className="flex justify-between text-sm">
                        <span>{item.name} x {item.quantity}</span>
                        <span>₱{(item.price * item.quantity).toFixed(2)}</span>
                      </div>
                    ))}
                  </div>
                </div>

                <Separator />

                <div className="flex justify-between font-bold">
                  <span>Total</span>
                  <span>₱{selectedOrder.total.toFixed(2)}</span>
                </div>

                <div className="flex justify-between text-sm">
                  <span className="text-muted-foreground">Payment Method</span>
                  <span>{selectedOrder.paymentMethod}</span>
                </div>
              </div>
            )}
          </DialogContent>
        </Dialog>
      </div>
    </div>
  )
}
