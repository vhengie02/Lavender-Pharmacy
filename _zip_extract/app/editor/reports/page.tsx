"use client"

import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import {
  TrendingUp,
  DollarSign,
  ShoppingCart,
  Package,
  Calendar,
  Download,
  BarChart3,
} from "lucide-react"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import { useState } from "react"

const dailySales = [
  { day: "Mon", sales: 1245.50, transactions: 42 },
  { day: "Tue", sales: 1890.75, transactions: 58 },
  { day: "Wed", sales: 1567.25, transactions: 51 },
  { day: "Thu", sales: 2123.00, transactions: 67 },
  { day: "Fri", sales: 2456.50, transactions: 78 },
  { day: "Sat", sales: 2890.25, transactions: 92 },
  { day: "Sun", sales: 1234.00, transactions: 38 },
]

const topProducts = [
  { name: "Paracetamol 500mg", sold: 245, revenue: 1467.55 },
  { name: "Vitamin C 1000mg", sold: 189, revenue: 2455.11 },
  { name: "Hand Sanitizer 250ml", sold: 156, revenue: 778.44 },
  { name: "Cough Syrup 100ml", sold: 134, revenue: 1204.66 },
  { name: "Multivitamin Daily", sold: 112, revenue: 1790.88 },
]

export default function EditorReportsPage() {
  const [period, setPeriod] = useState("week")
  
  const totalSales = dailySales.reduce((sum, day) => sum + day.sales, 0)
  const totalTransactions = dailySales.reduce((sum, day) => sum + day.transactions, 0)
  const avgTransaction = totalSales / totalTransactions
  const maxSales = Math.max(...dailySales.map(d => d.sales))

  return (
    <div className="p-6 space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-serif font-bold text-foreground">Sales Reports</h1>
          <p className="text-muted-foreground mt-1">
            View your sales performance and analytics
          </p>
        </div>
        <div className="flex items-center gap-2">
          <Select value={period} onValueChange={setPeriod}>
            <SelectTrigger className="w-40">
              <Calendar className="mr-2 h-4 w-4" />
              <SelectValue />
            </SelectTrigger>
            <SelectContent>
              <SelectItem value="today">Today</SelectItem>
              <SelectItem value="week">This Week</SelectItem>
              <SelectItem value="month">This Month</SelectItem>
              <SelectItem value="year">This Year</SelectItem>
            </SelectContent>
          </Select>
          <Button variant="outline">
            <Download className="mr-2 h-4 w-4" />
            Export
          </Button>
        </div>
      </div>

      {/* Stats */}
      <div className="grid gap-4 md:grid-cols-4">
        <Card>
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-sm font-medium text-muted-foreground">Total Sales</CardTitle>
            <DollarSign className="h-4 w-4 text-primary" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">${totalSales.toFixed(2)}</div>
            <p className="text-xs text-green-600 mt-1">+12.5% from last week</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-sm font-medium text-muted-foreground">Transactions</CardTitle>
            <ShoppingCart className="h-4 w-4 text-primary" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{totalTransactions}</div>
            <p className="text-xs text-green-600 mt-1">+8.2% from last week</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-sm font-medium text-muted-foreground">Avg. Transaction</CardTitle>
            <TrendingUp className="h-4 w-4 text-primary" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">${avgTransaction.toFixed(2)}</div>
            <p className="text-xs text-green-600 mt-1">+4.1% from last week</p>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="flex flex-row items-center justify-between pb-2">
            <CardTitle className="text-sm font-medium text-muted-foreground">Items Sold</CardTitle>
            <Package className="h-4 w-4 text-primary" />
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">836</div>
            <p className="text-xs text-green-600 mt-1">+15.3% from last week</p>
          </CardContent>
        </Card>
      </div>

      {/* Sales Chart */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <BarChart3 className="h-5 w-5" />
            Daily Sales
          </CardTitle>
          <CardDescription>Sales performance by day</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="h-64 flex items-end justify-between gap-2">
            {dailySales.map((day) => (
              <div key={day.day} className="flex-1 flex flex-col items-center gap-2">
                <div className="w-full flex flex-col items-center">
                  <span className="text-sm font-medium mb-1">${(day.sales / 1000).toFixed(1)}k</span>
                  <div 
                    className="w-full bg-primary rounded-t transition-all hover:bg-primary/80"
                    style={{ height: `${(day.sales / maxSales) * 180}px` }}
                  />
                </div>
                <span className="text-sm text-muted-foreground">{day.day}</span>
              </div>
            ))}
          </div>
        </CardContent>
      </Card>

      {/* Top Products */}
      <Card>
        <CardHeader>
          <CardTitle>Top Selling Products</CardTitle>
          <CardDescription>Best performing products this week</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="space-y-4">
            {topProducts.map((product, index) => (
              <div key={product.name} className="flex items-center gap-4">
                <div className="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-sm font-bold text-primary">
                  {index + 1}
                </div>
                <div className="flex-1 min-w-0">
                  <p className="font-medium truncate">{product.name}</p>
                  <p className="text-sm text-muted-foreground">{product.sold} units sold</p>
                </div>
                <div className="text-right">
                  <p className="font-bold text-primary">${product.revenue.toFixed(2)}</p>
                  <p className="text-sm text-muted-foreground">revenue</p>
                </div>
                <div className="w-32 h-2 bg-accent rounded-full overflow-hidden">
                  <div 
                    className="h-full bg-primary rounded-full"
                    style={{ width: `${(product.sold / topProducts[0].sold) * 100}%` }}
                  />
                </div>
              </div>
            ))}
          </div>
        </CardContent>
      </Card>

      {/* Daily Summary Table */}
      <Card>
        <CardHeader>
          <CardTitle>Daily Summary</CardTitle>
          <CardDescription>Detailed breakdown by day</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b border-border">
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Day</th>
                  <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Transactions</th>
                  <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Sales</th>
                  <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Avg. Transaction</th>
                </tr>
              </thead>
              <tbody>
                {dailySales.map((day) => (
                  <tr key={day.day} className="border-b border-border last:border-0">
                    <td className="py-3 px-4 font-medium">{day.day}</td>
                    <td className="py-3 px-4 text-right">{day.transactions}</td>
                    <td className="py-3 px-4 text-right font-medium text-primary">${day.sales.toFixed(2)}</td>
                    <td className="py-3 px-4 text-right text-muted-foreground">
                      ${(day.sales / day.transactions).toFixed(2)}
                    </td>
                  </tr>
                ))}
              </tbody>
              <tfoot>
                <tr className="bg-accent/30">
                  <td className="py-3 px-4 font-bold">Total</td>
                  <td className="py-3 px-4 text-right font-bold">{totalTransactions}</td>
                  <td className="py-3 px-4 text-right font-bold text-primary">${totalSales.toFixed(2)}</td>
                  <td className="py-3 px-4 text-right font-bold">${avgTransaction.toFixed(2)}</td>
                </tr>
              </tfoot>
            </table>
          </div>
        </CardContent>
      </Card>
    </div>
  )
}
