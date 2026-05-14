"use client"

import { AdminHeader } from "@/components/admin-sidebar"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { 
  TrendingUp, 
  TrendingDown, 
  DollarSign, 
  ShoppingCart, 
  Package, 
  Users,
  ArrowRight,
  AlertTriangle
} from "lucide-react"
import Link from "next/link"

const stats = [
  {
    title: "Total Revenue",
    value: "₱156,420.00",
    change: "+12.5%",
    trend: "up",
    icon: DollarSign,
    color: "text-green-600 bg-green-100"
  },
  {
    title: "Total Orders",
    value: "1,234",
    change: "+8.2%",
    trend: "up",
    icon: ShoppingCart,
    color: "text-blue-600 bg-blue-100"
  },
  {
    title: "Products Sold",
    value: "4,567",
    change: "+15.3%",
    trend: "up",
    icon: Package,
    color: "text-purple-600 bg-purple-100"
  },
  {
    title: "Active Customers",
    value: "892",
    change: "-2.4%",
    trend: "down",
    icon: Users,
    color: "text-orange-600 bg-orange-100"
  }
]

const recentOrders = [
  { id: "LP-12345678", customer: "Juan Dela Cruz", total: 156.50, status: "Processing", items: 3 },
  { id: "LP-12345679", customer: "Maria Santos", total: 89.00, status: "Pending", items: 2 },
  { id: "LP-12345680", customer: "Pedro Reyes", total: 245.75, status: "Delivered", items: 5 },
  { id: "LP-12345681", customer: "Ana Garcia", total: 45.00, status: "Processing", items: 1 },
  { id: "LP-12345682", customer: "Miguel Cruz", total: 120.00, status: "Pending", items: 4 }
]

const lowStockProducts = [
  { name: "Amoxicillin 500mg", stock: 15, minStock: 50 },
  { name: "Biogesic Paracetamol", stock: 23, minStock: 100 },
  { name: "Neozep Forte", stock: 8, minStock: 30 },
  { name: "Cetirizine 10mg", stock: 12, minStock: 40 }
]

const topProducts = [
  { name: "Biogesic Paracetamol", sold: 1250, revenue: 6875.00 },
  { name: "Neozep Forte", sold: 890, revenue: 10680.00 },
  { name: "Enervon C", sold: 756, revenue: 6804.00 },
  { name: "Solmux 500mg", sold: 634, revenue: 6974.00 },
  { name: "Cetirizine 10mg", sold: 589, revenue: 2061.50 }
]

export default function AdminDashboard() {
  const getStatusColor = (status: string) => {
    switch (status) {
      case "Delivered": return "bg-green-100 text-green-800"
      case "Processing": return "bg-blue-100 text-blue-800"
      case "Pending": return "bg-yellow-100 text-yellow-800"
      default: return "bg-gray-100 text-gray-800"
    }
  }

  return (
    <div className="min-h-screen">
      <AdminHeader title="Dashboard" description="Welcome back! Here's an overview of your pharmacy." />
      
      <div className="p-6 space-y-6">
        {/* Stats Cards */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
          {stats.map((stat) => (
            <Card key={stat.title}>
              <CardContent className="p-6">
                <div className="flex items-center justify-between">
                  <div className={`p-2 rounded-lg ${stat.color}`}>
                    <stat.icon className="w-5 h-5" />
                  </div>
                  <div className={`flex items-center gap-1 text-sm ${
                    stat.trend === "up" ? "text-green-600" : "text-red-600"
                  }`}>
                    {stat.trend === "up" ? (
                      <TrendingUp className="w-4 h-4" />
                    ) : (
                      <TrendingDown className="w-4 h-4" />
                    )}
                    {stat.change}
                  </div>
                </div>
                <div className="mt-4">
                  <p className="text-2xl font-bold text-foreground">{stat.value}</p>
                  <p className="text-sm text-muted-foreground">{stat.title}</p>
                </div>
              </CardContent>
            </Card>
          ))}
        </div>

        <div className="grid lg:grid-cols-2 gap-6">
          {/* Recent Orders */}
          <Card>
            <CardHeader className="flex flex-row items-center justify-between">
              <div>
                <CardTitle>Recent Orders</CardTitle>
                <CardDescription>Latest customer orders</CardDescription>
              </div>
              <Link href="/admin/orders">
                <Button variant="ghost" size="sm">
                  View All
                  <ArrowRight className="w-4 h-4 ml-1" />
                </Button>
              </Link>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                {recentOrders.map((order) => (
                  <div key={order.id} className="flex items-center justify-between py-2">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                        <span className="text-sm font-bold text-primary">
                          {order.customer.split(' ').map(n => n[0]).join('')}
                        </span>
                      </div>
                      <div>
                        <p className="font-medium text-foreground text-sm">{order.id}</p>
                        <p className="text-xs text-muted-foreground">{order.customer}</p>
                      </div>
                    </div>
                    <div className="flex items-center gap-3">
                      <Badge className={getStatusColor(order.status)}>
                        {order.status}
                      </Badge>
                      <span className="font-medium text-sm">₱{order.total.toFixed(2)}</span>
                    </div>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>

          {/* Low Stock Alert */}
          <Card>
            <CardHeader className="flex flex-row items-center justify-between">
              <div>
                <CardTitle className="flex items-center gap-2">
                  <AlertTriangle className="w-5 h-5 text-amber-500" />
                  Low Stock Alert
                </CardTitle>
                <CardDescription>Products that need restocking</CardDescription>
              </div>
              <Link href="/admin/inventory">
                <Button variant="ghost" size="sm">
                  Manage
                  <ArrowRight className="w-4 h-4 ml-1" />
                </Button>
              </Link>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                {lowStockProducts.map((product) => (
                  <div key={product.name} className="flex items-center justify-between py-2">
                    <div>
                      <p className="font-medium text-foreground text-sm">{product.name}</p>
                      <p className="text-xs text-muted-foreground">Min. stock: {product.minStock}</p>
                    </div>
                    <div className="text-right">
                      <span className="text-lg font-bold text-red-600">{product.stock}</span>
                      <p className="text-xs text-muted-foreground">in stock</p>
                    </div>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>
        </div>

        {/* Top Products */}
        <Card>
          <CardHeader className="flex flex-row items-center justify-between">
            <div>
              <CardTitle>Top Selling Products</CardTitle>
              <CardDescription>Best performing products this month</CardDescription>
            </div>
            <Link href="/admin/products">
              <Button variant="ghost" size="sm">
                View All Products
                <ArrowRight className="w-4 h-4 ml-1" />
              </Button>
            </Link>
          </CardHeader>
          <CardContent>
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead>
                  <tr className="text-left text-sm text-muted-foreground border-b">
                    <th className="pb-3 font-medium">Product</th>
                    <th className="pb-3 font-medium text-right">Units Sold</th>
                    <th className="pb-3 font-medium text-right">Revenue</th>
                  </tr>
                </thead>
                <tbody>
                  {topProducts.map((product, index) => (
                    <tr key={product.name} className="border-b last:border-0">
                      <td className="py-3">
                        <div className="flex items-center gap-3">
                          <span className="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-xs font-bold text-primary">
                            {index + 1}
                          </span>
                          <span className="font-medium text-foreground">{product.name}</span>
                        </div>
                      </td>
                      <td className="py-3 text-right text-muted-foreground">{product.sold.toLocaleString()}</td>
                      <td className="py-3 text-right font-medium text-foreground">₱{product.revenue.toLocaleString()}</td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}
