"use client"

import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import {
  ShoppingCart,
  Receipt,
  TrendingUp,
  Package,
  Clock,
  DollarSign,
  ArrowRight,
} from "lucide-react"
import Link from "next/link"

const stats = [
  {
    title: "Today's Sales",
    value: "$1,234.56",
    change: "+12.5%",
    icon: DollarSign,
  },
  {
    title: "Transactions",
    value: "48",
    change: "+8.2%",
    icon: Receipt,
  },
  {
    title: "Items Sold",
    value: "156",
    change: "+15.3%",
    icon: Package,
  },
  {
    title: "Avg. Transaction",
    value: "$25.72",
    change: "+4.1%",
    icon: TrendingUp,
  },
]

const recentTransactions = [
  {
    id: "TXN-001",
    time: "2:45 PM",
    items: 3,
    total: "$45.99",
    paymentMethod: "Cash",
  },
  {
    id: "TXN-002",
    time: "2:30 PM",
    items: 5,
    total: "$78.50",
    paymentMethod: "Card",
  },
  {
    id: "TXN-003",
    time: "2:15 PM",
    items: 2,
    total: "$23.00",
    paymentMethod: "Cash",
  },
  {
    id: "TXN-004",
    time: "1:50 PM",
    items: 4,
    total: "$56.75",
    paymentMethod: "Card",
  },
  {
    id: "TXN-005",
    time: "1:30 PM",
    items: 1,
    total: "$12.99",
    paymentMethod: "Cash",
  },
]

const quickActions = [
  {
    title: "New Sale",
    description: "Start a new point of sale transaction",
    href: "/editor/pos",
    icon: ShoppingCart,
    color: "bg-primary",
  },
  {
    title: "View Receipts",
    description: "Browse and reprint receipts",
    href: "/editor/receipts",
    icon: Receipt,
    color: "bg-accent",
  },
  {
    title: "Products",
    description: "Search and check product details",
    href: "/editor/products",
    icon: Package,
    color: "bg-secondary",
  },
]

export default function EditorDashboard() {
  return (
    <div className="p-6 space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-serif font-bold text-foreground">Editor Dashboard</h1>
          <p className="text-muted-foreground mt-1">
            Welcome back! Here&apos;s your sales overview for today.
          </p>
        </div>
        <div className="flex items-center gap-2 text-sm text-muted-foreground">
          <Clock className="h-4 w-4" />
          <span>{new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</span>
        </div>
      </div>

      {/* Stats Grid */}
      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        {stats.map((stat) => (
          <Card key={stat.title}>
            <CardHeader className="flex flex-row items-center justify-between pb-2">
              <CardTitle className="text-sm font-medium text-muted-foreground">
                {stat.title}
              </CardTitle>
              <stat.icon className="h-4 w-4 text-primary" />
            </CardHeader>
            <CardContent>
              <div className="text-2xl font-bold">{stat.value}</div>
              <p className="text-xs text-green-600 mt-1">
                {stat.change} from yesterday
              </p>
            </CardContent>
          </Card>
        ))}
      </div>

      {/* Quick Actions */}
      <div className="grid gap-4 md:grid-cols-3">
        {quickActions.map((action) => (
          <Link key={action.title} href={action.href}>
            <Card className="h-full transition-all hover:shadow-md hover:border-primary/50 cursor-pointer">
              <CardHeader>
                <div className={`w-12 h-12 rounded-lg ${action.color} flex items-center justify-center mb-2`}>
                  <action.icon className="h-6 w-6 text-primary-foreground" />
                </div>
                <CardTitle className="text-lg">{action.title}</CardTitle>
                <CardDescription>{action.description}</CardDescription>
              </CardHeader>
              <CardContent>
                <Button variant="ghost" className="p-0 h-auto text-primary hover:text-primary/80">
                  Go to {action.title.toLowerCase()} <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </CardContent>
            </Card>
          </Link>
        ))}
      </div>

      {/* Recent Transactions */}
      <Card>
        <CardHeader className="flex flex-row items-center justify-between">
          <div>
            <CardTitle>Recent Transactions</CardTitle>
            <CardDescription>Your latest point of sale transactions</CardDescription>
          </div>
          <Button variant="outline" asChild>
            <Link href="/editor/receipts">View All</Link>
          </Button>
        </CardHeader>
        <CardContent>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b border-border">
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Transaction ID</th>
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Time</th>
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Items</th>
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Payment</th>
                  <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Total</th>
                  <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Actions</th>
                </tr>
              </thead>
              <tbody>
                {recentTransactions.map((txn) => (
                  <tr key={txn.id} className="border-b border-border last:border-0">
                    <td className="py-3 px-4 text-sm font-medium">{txn.id}</td>
                    <td className="py-3 px-4 text-sm text-muted-foreground">{txn.time}</td>
                    <td className="py-3 px-4 text-sm text-muted-foreground">{txn.items} items</td>
                    <td className="py-3 px-4 text-sm">
                      <span className={`inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${
                        txn.paymentMethod === "Cash" 
                          ? "bg-green-100 text-green-800" 
                          : "bg-blue-100 text-blue-800"
                      }`}>
                        {txn.paymentMethod}
                      </span>
                    </td>
                    <td className="py-3 px-4 text-sm font-medium text-right">{txn.total}</td>
                    <td className="py-3 px-4 text-right">
                      <Button variant="ghost" size="sm" asChild>
                        <Link href={`/editor/receipts/${txn.id}`}>
                          <Receipt className="h-4 w-4" />
                        </Link>
                      </Button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>
    </div>
  )
}
