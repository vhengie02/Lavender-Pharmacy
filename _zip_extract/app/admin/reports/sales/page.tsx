"use client"

import { AdminHeader } from "@/components/admin-sidebar"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Badge } from "@/components/ui/badge"
import { 
  TrendingUp, 
  TrendingDown, 
  DollarSign, 
  ShoppingCart, 
  Package, 
  Users,
  Download,
  Calendar
} from "lucide-react"
import { useState } from "react"

const dailySales = [
  { date: "Mon", sales: 12500 },
  { date: "Tue", sales: 15800 },
  { date: "Wed", sales: 11200 },
  { date: "Thu", sales: 18900 },
  { date: "Fri", sales: 22100 },
  { date: "Sat", sales: 28500 },
  { date: "Sun", sales: 19800 }
]

const topProducts = [
  { name: "Biogesic Paracetamol", sales: 1250, revenue: 6875.00, growth: 12.5 },
  { name: "Neozep Forte", sales: 890, revenue: 10680.00, growth: 8.2 },
  { name: "Enervon C", sales: 756, revenue: 6804.00, growth: -3.1 },
  { name: "Solmux 500mg", sales: 634, revenue: 6974.00, growth: 15.7 },
  { name: "Cetirizine 10mg", sales: 589, revenue: 2061.50, growth: 5.4 }
]

const recentTransactions = [
  { id: "LP-12345678", customer: "Juan Dela Cruz", amount: 156.50, date: "2024-01-15 14:30", method: "Cash" },
  { id: "LP-12345679", customer: "Maria Santos", amount: 89.00, date: "2024-01-15 13:45", method: "GCash" },
  { id: "LP-12345680", customer: "Pedro Reyes", amount: 245.75, date: "2024-01-15 12:20", method: "Card" },
  { id: "LP-12345681", customer: "Ana Garcia", amount: 45.00, date: "2024-01-15 11:15", method: "Cash" },
  { id: "LP-12345682", customer: "Miguel Cruz", amount: 120.00, date: "2024-01-15 10:30", method: "GCash" }
]

export default function AdminSalesReportPage() {
  const [period, setPeriod] = useState("week")
  
  const maxSales = Math.max(...dailySales.map(d => d.sales))
  const totalSales = dailySales.reduce((sum, d) => sum + d.sales, 0)

  return (
    <div className="min-h-screen">
      <AdminHeader title="Sales Reports" description="Analyze your sales performance" />
      
      <div className="p-6 space-y-6">
        {/* Period Selector & Export */}
        <div className="flex flex-col sm:flex-row justify-between gap-4">
          <div className="flex items-center gap-4">
            <Select value={period} onValueChange={setPeriod}>
              <SelectTrigger className="w-40">
                <Calendar className="w-4 h-4 mr-2" />
                <SelectValue placeholder="Select period" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="today">Today</SelectItem>
                <SelectItem value="week">This Week</SelectItem>
                <SelectItem value="month">This Month</SelectItem>
                <SelectItem value="year">This Year</SelectItem>
              </SelectContent>
            </Select>
          </div>
          <Button variant="outline">
            <Download className="w-4 h-4 mr-2" />
            Export Report
          </Button>
        </div>

        {/* Stats Cards */}
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <Card>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div className="p-2 rounded-lg bg-green-100">
                  <DollarSign className="w-5 h-5 text-green-600" />
                </div>
                <div className="flex items-center gap-1 text-sm text-green-600">
                  <TrendingUp className="w-4 h-4" />
                  +12.5%
                </div>
              </div>
              <div className="mt-4">
                <p className="text-2xl font-bold text-foreground">₱{totalSales.toLocaleString()}</p>
                <p className="text-sm text-muted-foreground">Total Revenue</p>
              </div>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div className="p-2 rounded-lg bg-blue-100">
                  <ShoppingCart className="w-5 h-5 text-blue-600" />
                </div>
                <div className="flex items-center gap-1 text-sm text-green-600">
                  <TrendingUp className="w-4 h-4" />
                  +8.2%
                </div>
              </div>
              <div className="mt-4">
                <p className="text-2xl font-bold text-foreground">342</p>
                <p className="text-sm text-muted-foreground">Total Orders</p>
              </div>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div className="p-2 rounded-lg bg-purple-100">
                  <Package className="w-5 h-5 text-purple-600" />
                </div>
                <div className="flex items-center gap-1 text-sm text-green-600">
                  <TrendingUp className="w-4 h-4" />
                  +15.3%
                </div>
              </div>
              <div className="mt-4">
                <p className="text-2xl font-bold text-foreground">1,847</p>
                <p className="text-sm text-muted-foreground">Products Sold</p>
              </div>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div className="p-2 rounded-lg bg-orange-100">
                  <Users className="w-5 h-5 text-orange-600" />
                </div>
                <div className="flex items-center gap-1 text-sm text-red-600">
                  <TrendingDown className="w-4 h-4" />
                  -2.4%
                </div>
              </div>
              <div className="mt-4">
                <p className="text-2xl font-bold text-foreground">₱376.50</p>
                <p className="text-sm text-muted-foreground">Avg. Order Value</p>
              </div>
            </CardContent>
          </Card>
        </div>

        <div className="grid lg:grid-cols-2 gap-6">
          {/* Sales Chart */}
          <Card>
            <CardHeader>
              <CardTitle>Sales Overview</CardTitle>
              <CardDescription>Daily sales for the selected period</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="h-64 flex items-end gap-2">
                {dailySales.map((day, index) => (
                  <div key={index} className="flex-1 flex flex-col items-center gap-2">
                    <div 
                      className="w-full bg-primary/80 rounded-t-lg transition-all hover:bg-primary"
                      style={{ height: `${(day.sales / maxSales) * 200}px` }}
                    />
                    <span className="text-xs text-muted-foreground">{day.date}</span>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>

          {/* Top Products */}
          <Card>
            <CardHeader>
              <CardTitle>Top Selling Products</CardTitle>
              <CardDescription>Best performers this period</CardDescription>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                {topProducts.map((product, index) => (
                  <div key={index} className="flex items-center justify-between">
                    <div className="flex items-center gap-3">
                      <span className="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-xs font-bold text-primary">
                        {index + 1}
                      </span>
                      <div>
                        <p className="font-medium text-foreground text-sm">{product.name}</p>
                        <p className="text-xs text-muted-foreground">{product.sales} units sold</p>
                      </div>
                    </div>
                    <div className="text-right">
                      <p className="font-medium text-foreground">₱{product.revenue.toLocaleString()}</p>
                      <p className={`text-xs ${product.growth >= 0 ? 'text-green-600' : 'text-red-600'}`}>
                        {product.growth >= 0 ? '+' : ''}{product.growth}%
                      </p>
                    </div>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>
        </div>

        {/* Recent Transactions */}
        <Card>
          <CardHeader>
            <CardTitle>Recent Transactions</CardTitle>
            <CardDescription>Latest completed orders</CardDescription>
          </CardHeader>
          <CardContent>
            <div className="overflow-x-auto">
              <table className="w-full">
                <thead>
                  <tr className="text-left text-sm text-muted-foreground border-b">
                    <th className="pb-3 font-medium">Order ID</th>
                    <th className="pb-3 font-medium">Customer</th>
                    <th className="pb-3 font-medium">Date & Time</th>
                    <th className="pb-3 font-medium">Payment</th>
                    <th className="pb-3 font-medium text-right">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  {recentTransactions.map((transaction) => (
                    <tr key={transaction.id} className="border-b last:border-0">
                      <td className="py-3 font-medium text-foreground">{transaction.id}</td>
                      <td className="py-3 text-muted-foreground">{transaction.customer}</td>
                      <td className="py-3 text-muted-foreground">{transaction.date}</td>
                      <td className="py-3">
                        <Badge variant="outline">{transaction.method}</Badge>
                      </td>
                      <td className="py-3 text-right font-medium">₱{transaction.amount.toFixed(2)}</td>
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
