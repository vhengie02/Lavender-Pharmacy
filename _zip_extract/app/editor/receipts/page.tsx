"use client"

import { useState } from "react"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import {
  Search,
  Receipt,
  Printer,
  Eye,
  Calendar,
  Filter,
  Download,
} from "lucide-react"
import { Badge } from "@/components/ui/badge"
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"

interface ReceiptItem {
  name: string
  quantity: number
  price: number
}

interface ReceiptData {
  id: string
  date: string
  time: string
  items: ReceiptItem[]
  subtotal: number
  tax: number
  total: number
  paymentMethod: "Cash" | "Card" | "Mobile"
  cashier: string
  status: "completed" | "refunded" | "voided"
}

const receipts: ReceiptData[] = [
  {
    id: "RCP-2024-001",
    date: "2024-01-15",
    time: "2:45 PM",
    items: [
      { name: "Paracetamol 500mg", quantity: 2, price: 5.99 },
      { name: "Vitamin C 1000mg", quantity: 1, price: 12.99 },
      { name: "Hand Sanitizer 250ml", quantity: 3, price: 4.99 },
    ],
    subtotal: 39.94,
    tax: 3.20,
    total: 43.14,
    paymentMethod: "Cash",
    cashier: "John Doe",
    status: "completed",
  },
  {
    id: "RCP-2024-002",
    date: "2024-01-15",
    time: "2:30 PM",
    items: [
      { name: "Blood Pressure Monitor", quantity: 1, price: 49.99 },
      { name: "Digital Thermometer", quantity: 1, price: 19.99 },
    ],
    subtotal: 69.98,
    tax: 5.60,
    total: 75.58,
    paymentMethod: "Card",
    cashier: "Jane Smith",
    status: "completed",
  },
  {
    id: "RCP-2024-003",
    date: "2024-01-15",
    time: "1:15 PM",
    items: [
      { name: "Cough Syrup 100ml", quantity: 2, price: 8.99 },
      { name: "Antihistamine 10mg", quantity: 1, price: 9.99 },
    ],
    subtotal: 27.97,
    tax: 2.24,
    total: 30.21,
    paymentMethod: "Mobile",
    cashier: "John Doe",
    status: "completed",
  },
  {
    id: "RCP-2024-004",
    date: "2024-01-14",
    time: "4:30 PM",
    items: [
      { name: "Multivitamin Daily", quantity: 1, price: 15.99 },
    ],
    subtotal: 15.99,
    tax: 1.28,
    total: 17.27,
    paymentMethod: "Cash",
    cashier: "Jane Smith",
    status: "refunded",
  },
  {
    id: "RCP-2024-005",
    date: "2024-01-14",
    time: "3:00 PM",
    items: [
      { name: "Face Masks (50 pack)", quantity: 2, price: 14.99 },
      { name: "Bandages Assorted", quantity: 3, price: 6.99 },
      { name: "Antiseptic Cream 30g", quantity: 2, price: 7.49 },
    ],
    subtotal: 65.93,
    tax: 5.27,
    total: 71.20,
    paymentMethod: "Card",
    cashier: "John Doe",
    status: "completed",
  },
]

export default function ReceiptsPage() {
  const [searchQuery, setSearchQuery] = useState("")
  const [selectedReceipt, setSelectedReceipt] = useState<ReceiptData | null>(null)
  const [dateFilter, setDateFilter] = useState("all")
  const [statusFilter, setStatusFilter] = useState("all")

  const filteredReceipts = receipts.filter((receipt) => {
    const matchesSearch = receipt.id.toLowerCase().includes(searchQuery.toLowerCase()) ||
      receipt.items.some(item => item.name.toLowerCase().includes(searchQuery.toLowerCase()))
    const matchesStatus = statusFilter === "all" || receipt.status === statusFilter
    return matchesSearch && matchesStatus
  })

  const totalSales = filteredReceipts
    .filter(r => r.status === "completed")
    .reduce((sum, r) => sum + r.total, 0)

  return (
    <div className="p-6 space-y-6">
      <div className="flex items-center justify-between">
        <div>
          <h1 className="text-3xl font-serif font-bold text-foreground">Receipts</h1>
          <p className="text-muted-foreground mt-1">
            View, search, and reprint transaction receipts
          </p>
        </div>
        <Button variant="outline">
          <Download className="mr-2 h-4 w-4" />
          Export
        </Button>
      </div>

      {/* Stats */}
      <div className="grid gap-4 md:grid-cols-3">
        <Card>
          <CardHeader className="pb-2">
            <CardTitle className="text-sm font-medium text-muted-foreground">Total Receipts</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold">{filteredReceipts.length}</div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="pb-2">
            <CardTitle className="text-sm font-medium text-muted-foreground">Total Sales</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold text-primary">${totalSales.toFixed(2)}</div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader className="pb-2">
            <CardTitle className="text-sm font-medium text-muted-foreground">Refunded</CardTitle>
          </CardHeader>
          <CardContent>
            <div className="text-2xl font-bold text-destructive">
              {filteredReceipts.filter(r => r.status === "refunded").length}
            </div>
          </CardContent>
        </Card>
      </div>

      {/* Filters */}
      <Card>
        <CardContent className="p-4">
          <div className="flex flex-col md:flex-row gap-4">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                placeholder="Search by receipt ID or product..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-10"
              />
            </div>
            <div className="flex gap-2">
              <Select value={dateFilter} onValueChange={setDateFilter}>
                <SelectTrigger className="w-40">
                  <Calendar className="mr-2 h-4 w-4" />
                  <SelectValue placeholder="Date" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Dates</SelectItem>
                  <SelectItem value="today">Today</SelectItem>
                  <SelectItem value="week">This Week</SelectItem>
                  <SelectItem value="month">This Month</SelectItem>
                </SelectContent>
              </Select>
              <Select value={statusFilter} onValueChange={setStatusFilter}>
                <SelectTrigger className="w-40">
                  <Filter className="mr-2 h-4 w-4" />
                  <SelectValue placeholder="Status" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Status</SelectItem>
                  <SelectItem value="completed">Completed</SelectItem>
                  <SelectItem value="refunded">Refunded</SelectItem>
                  <SelectItem value="voided">Voided</SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>
        </CardContent>
      </Card>

      {/* Receipts List */}
      <Card>
        <CardHeader>
          <CardTitle>Transaction History</CardTitle>
          <CardDescription>Click on a receipt to view details</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b border-border">
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Receipt ID</th>
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Date & Time</th>
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Items</th>
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Payment</th>
                  <th className="text-left py-3 px-4 text-sm font-medium text-muted-foreground">Status</th>
                  <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Total</th>
                  <th className="text-right py-3 px-4 text-sm font-medium text-muted-foreground">Actions</th>
                </tr>
              </thead>
              <tbody>
                {filteredReceipts.map((receipt) => (
                  <tr key={receipt.id} className="border-b border-border last:border-0 hover:bg-accent/30">
                    <td className="py-3 px-4 text-sm font-medium">{receipt.id}</td>
                    <td className="py-3 px-4 text-sm text-muted-foreground">
                      {receipt.date} {receipt.time}
                    </td>
                    <td className="py-3 px-4 text-sm text-muted-foreground">
                      {receipt.items.length} items
                    </td>
                    <td className="py-3 px-4 text-sm">
                      <Badge variant="outline">{receipt.paymentMethod}</Badge>
                    </td>
                    <td className="py-3 px-4 text-sm">
                      <Badge
                        variant={
                          receipt.status === "completed" ? "default" :
                          receipt.status === "refunded" ? "destructive" : "secondary"
                        }
                      >
                        {receipt.status}
                      </Badge>
                    </td>
                    <td className="py-3 px-4 text-sm font-medium text-right">${receipt.total.toFixed(2)}</td>
                    <td className="py-3 px-4 text-right">
                      <div className="flex items-center justify-end gap-2">
                        <Button
                          variant="ghost"
                          size="icon"
                          onClick={() => setSelectedReceipt(receipt)}
                        >
                          <Eye className="h-4 w-4" />
                        </Button>
                        <Button variant="ghost" size="icon">
                          <Printer className="h-4 w-4" />
                        </Button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </CardContent>
      </Card>

      {/* Receipt Detail Dialog */}
      <Dialog open={!!selectedReceipt} onOpenChange={() => setSelectedReceipt(null)}>
        <DialogContent className="sm:max-w-md">
          <DialogHeader>
            <DialogTitle className="flex items-center gap-2">
              <Receipt className="h-5 w-5" />
              Receipt Details
            </DialogTitle>
          </DialogHeader>
          
          {selectedReceipt && (
            <div className="space-y-6">
              {/* Receipt Header */}
              <div className="text-center border-b border-dashed border-border pb-4">
                <h3 className="font-serif text-xl font-bold text-primary">Lavender Pharmacy</h3>
                <p className="text-sm text-muted-foreground">123 Health Street, Medical City</p>
                <p className="text-sm text-muted-foreground">Tel: (555) 123-4567</p>
              </div>

              {/* Receipt Info */}
              <div className="grid grid-cols-2 gap-2 text-sm">
                <div className="text-muted-foreground">Receipt #:</div>
                <div className="font-medium">{selectedReceipt.id}</div>
                <div className="text-muted-foreground">Date:</div>
                <div>{selectedReceipt.date}</div>
                <div className="text-muted-foreground">Time:</div>
                <div>{selectedReceipt.time}</div>
                <div className="text-muted-foreground">Cashier:</div>
                <div>{selectedReceipt.cashier}</div>
              </div>

              {/* Items */}
              <div className="border-t border-b border-dashed border-border py-4 space-y-2">
                {selectedReceipt.items.map((item, index) => (
                  <div key={index} className="flex justify-between text-sm">
                    <div>
                      <span className="font-medium">{item.name}</span>
                      <span className="text-muted-foreground ml-2">x{item.quantity}</span>
                    </div>
                    <span>${(item.price * item.quantity).toFixed(2)}</span>
                  </div>
                ))}
              </div>

              {/* Totals */}
              <div className="space-y-2 text-sm">
                <div className="flex justify-between">
                  <span className="text-muted-foreground">Subtotal</span>
                  <span>${selectedReceipt.subtotal.toFixed(2)}</span>
                </div>
                <div className="flex justify-between">
                  <span className="text-muted-foreground">Tax (8%)</span>
                  <span>${selectedReceipt.tax.toFixed(2)}</span>
                </div>
                <div className="flex justify-between text-lg font-bold pt-2 border-t border-border">
                  <span>Total</span>
                  <span className="text-primary">${selectedReceipt.total.toFixed(2)}</span>
                </div>
                <div className="flex justify-between text-sm pt-2">
                  <span className="text-muted-foreground">Payment Method</span>
                  <Badge variant="outline">{selectedReceipt.paymentMethod}</Badge>
                </div>
              </div>

              {/* Footer */}
              <div className="text-center text-sm text-muted-foreground border-t border-dashed border-border pt-4">
                <p>Thank you for shopping with us!</p>
                <p>www.lavenderpharmacy.com</p>
              </div>

              {/* Actions */}
              <div className="flex gap-2">
                <Button variant="outline" className="flex-1">
                  <Printer className="mr-2 h-4 w-4" />
                  Print
                </Button>
                <Button variant="outline" className="flex-1">
                  <Download className="mr-2 h-4 w-4" />
                  Download
                </Button>
              </div>
            </div>
          )}
        </DialogContent>
      </Dialog>
    </div>
  )
}
