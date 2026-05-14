"use client"

import { useState } from "react"
import { AdminHeader } from "@/components/admin-sidebar"
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Input } from "@/components/ui/input"
import { Badge } from "@/components/ui/badge"
import { Progress } from "@/components/ui/progress"
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogFooter } from "@/components/ui/dialog"
import { Label } from "@/components/ui/label"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
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
  Package,
  AlertTriangle,
  TrendingUp,
  TrendingDown,
  Plus,
  Minus,
  RotateCcw
} from "lucide-react"

const initialInventory = [
  { id: 1, name: "Biogesic Paracetamol", sku: "BIO-001", stock: 150, minStock: 50, maxStock: 500, lastRestocked: "2024-01-10", expiryDate: "2026-12-31" },
  { id: 2, name: "Neozep Forte", sku: "NEO-001", stock: 8, minStock: 30, maxStock: 200, lastRestocked: "2024-01-05", expiryDate: "2026-06-30" },
  { id: 3, name: "Bioflu", sku: "BIO-002", stock: 120, minStock: 40, maxStock: 300, lastRestocked: "2024-01-08", expiryDate: "2026-09-15" },
  { id: 4, name: "Amoxicillin 500mg", sku: "AMX-001", stock: 15, minStock: 50, maxStock: 400, lastRestocked: "2024-01-02", expiryDate: "2025-08-20" },
  { id: 5, name: "Cetirizine 10mg", sku: "CET-001", stock: 300, minStock: 40, maxStock: 500, lastRestocked: "2024-01-12", expiryDate: "2027-03-10" },
  { id: 6, name: "Decolgen Forte", sku: "DEC-001", stock: 95, minStock: 30, maxStock: 250, lastRestocked: "2024-01-07", expiryDate: "2026-11-05" },
  { id: 7, name: "Kremil-S", sku: "KRE-001", stock: 180, minStock: 50, maxStock: 400, lastRestocked: "2024-01-09", expiryDate: "2027-01-20" },
  { id: 8, name: "Solmux 500mg", sku: "SOL-001", stock: 0, minStock: 30, maxStock: 200, lastRestocked: "2023-12-15", expiryDate: "2026-04-30" },
]

export default function AdminInventoryPage() {
  const [inventory, setInventory] = useState(initialInventory)
  const [searchQuery, setSearchQuery] = useState("")
  const [statusFilter, setStatusFilter] = useState("All")
  const [selectedItem, setSelectedItem] = useState<typeof initialInventory[0] | null>(null)
  const [isAdjustDialogOpen, setIsAdjustDialogOpen] = useState(false)
  const [adjustmentType, setAdjustmentType] = useState<"add" | "remove">("add")
  const [adjustmentAmount, setAdjustmentAmount] = useState("")
  const [adjustmentReason, setAdjustmentReason] = useState("")

  const getStockStatus = (stock: number, minStock: number) => {
    if (stock === 0) return "Out of Stock"
    if (stock < minStock) return "Low Stock"
    return "In Stock"
  }

  const getStockColor = (status: string) => {
    switch (status) {
      case "In Stock": return "bg-green-100 text-green-800"
      case "Low Stock": return "bg-amber-100 text-amber-800"
      case "Out of Stock": return "bg-red-100 text-red-800"
      default: return "bg-gray-100 text-gray-800"
    }
  }

  const filteredInventory = inventory.filter(item => {
    const status = getStockStatus(item.stock, item.minStock)
    const matchesSearch = item.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      item.sku.toLowerCase().includes(searchQuery.toLowerCase())
    const matchesStatus = statusFilter === "All" || status === statusFilter
    return matchesSearch && matchesStatus
  })

  const handleAdjustStock = () => {
    if (!selectedItem || !adjustmentAmount) return
    
    const amount = parseInt(adjustmentAmount)
    setInventory(inventory.map(item => {
      if (item.id === selectedItem.id) {
        const newStock = adjustmentType === "add" 
          ? item.stock + amount 
          : Math.max(0, item.stock - amount)
        return { ...item, stock: newStock }
      }
      return item
    }))
    
    setIsAdjustDialogOpen(false)
    setAdjustmentAmount("")
    setAdjustmentReason("")
  }

  const openAdjustDialog = (item: typeof initialInventory[0], type: "add" | "remove") => {
    setSelectedItem(item)
    setAdjustmentType(type)
    setIsAdjustDialogOpen(true)
  }

  const stats = {
    totalProducts: inventory.length,
    inStock: inventory.filter(i => getStockStatus(i.stock, i.minStock) === "In Stock").length,
    lowStock: inventory.filter(i => getStockStatus(i.stock, i.minStock) === "Low Stock").length,
    outOfStock: inventory.filter(i => getStockStatus(i.stock, i.minStock) === "Out of Stock").length,
    totalUnits: inventory.reduce((sum, i) => sum + i.stock, 0)
  }

  return (
    <div className="min-h-screen">
      <AdminHeader title="Inventory" description="Track and manage product stock levels" />
      
      <div className="p-6 space-y-6">
        {/* Stats */}
        <div className="grid grid-cols-2 lg:grid-cols-5 gap-4">
          <Card>
            <CardContent className="p-4 flex items-center gap-4">
              <div className="p-2 rounded-lg bg-blue-100">
                <Package className="w-5 h-5 text-blue-600" />
              </div>
              <div>
                <p className="text-2xl font-bold">{stats.totalProducts}</p>
                <p className="text-sm text-muted-foreground">Total SKUs</p>
              </div>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-4 flex items-center gap-4">
              <div className="p-2 rounded-lg bg-green-100">
                <TrendingUp className="w-5 h-5 text-green-600" />
              </div>
              <div>
                <p className="text-2xl font-bold">{stats.inStock}</p>
                <p className="text-sm text-muted-foreground">In Stock</p>
              </div>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-4 flex items-center gap-4">
              <div className="p-2 rounded-lg bg-amber-100">
                <AlertTriangle className="w-5 h-5 text-amber-600" />
              </div>
              <div>
                <p className="text-2xl font-bold">{stats.lowStock}</p>
                <p className="text-sm text-muted-foreground">Low Stock</p>
              </div>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-4 flex items-center gap-4">
              <div className="p-2 rounded-lg bg-red-100">
                <TrendingDown className="w-5 h-5 text-red-600" />
              </div>
              <div>
                <p className="text-2xl font-bold">{stats.outOfStock}</p>
                <p className="text-sm text-muted-foreground">Out of Stock</p>
              </div>
            </CardContent>
          </Card>
          <Card>
            <CardContent className="p-4 flex items-center gap-4">
              <div className="p-2 rounded-lg bg-purple-100">
                <Package className="w-5 h-5 text-purple-600" />
              </div>
              <div>
                <p className="text-2xl font-bold">{stats.totalUnits.toLocaleString()}</p>
                <p className="text-sm text-muted-foreground">Total Units</p>
              </div>
            </CardContent>
          </Card>
        </div>

        {/* Low Stock Alerts */}
        {stats.lowStock > 0 && (
          <Card className="border-amber-200 bg-amber-50/50">
            <CardHeader className="pb-3">
              <CardTitle className="flex items-center gap-2 text-amber-800">
                <AlertTriangle className="w-5 h-5" />
                Low Stock Alert
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {inventory
                  .filter(i => getStockStatus(i.stock, i.minStock) === "Low Stock")
                  .map((item) => (
                    <div key={item.id} className="p-3 bg-white rounded-lg border">
                      <p className="font-medium text-sm">{item.name}</p>
                      <div className="flex items-center justify-between mt-2">
                        <span className="text-amber-600 font-bold">{item.stock} units</span>
                        <Button 
                          size="sm" 
                          variant="outline"
                          onClick={() => openAdjustDialog(item, "add")}
                        >
                          <Plus className="w-3 h-3 mr-1" />
                          Restock
                        </Button>
                      </div>
                    </div>
                  ))}
              </div>
            </CardContent>
          </Card>
        )}

        {/* Filters */}
        <div className="flex flex-col sm:flex-row gap-4">
          <div className="relative flex-1 max-w-md">
            <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
            <Input
              placeholder="Search by name or SKU..."
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
              <SelectItem value="In Stock">In Stock</SelectItem>
              <SelectItem value="Low Stock">Low Stock</SelectItem>
              <SelectItem value="Out of Stock">Out of Stock</SelectItem>
            </SelectContent>
          </Select>
        </div>

        {/* Inventory Table */}
        <Card>
          <CardContent className="p-0">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Product</TableHead>
                  <TableHead>SKU</TableHead>
                  <TableHead>Stock Level</TableHead>
                  <TableHead>Status</TableHead>
                  <TableHead>Last Restocked</TableHead>
                  <TableHead>Expiry Date</TableHead>
                  <TableHead className="text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {filteredInventory.map((item) => {
                  const status = getStockStatus(item.stock, item.minStock)
                  const stockPercentage = Math.min((item.stock / item.maxStock) * 100, 100)
                  
                  return (
                    <TableRow key={item.id}>
                      <TableCell>
                        <p className="font-medium text-foreground">{item.name}</p>
                      </TableCell>
                      <TableCell className="text-muted-foreground">{item.sku}</TableCell>
                      <TableCell>
                        <div className="w-32">
                          <div className="flex items-center justify-between mb-1">
                            <span className="text-sm font-medium">{item.stock}</span>
                            <span className="text-xs text-muted-foreground">/ {item.maxStock}</span>
                          </div>
                          <Progress 
                            value={stockPercentage} 
                            className="h-2"
                          />
                        </div>
                      </TableCell>
                      <TableCell>
                        <Badge className={getStockColor(status)}>{status}</Badge>
                      </TableCell>
                      <TableCell className="text-muted-foreground">
                        {new Date(item.lastRestocked).toLocaleDateString()}
                      </TableCell>
                      <TableCell className="text-muted-foreground">
                        {new Date(item.expiryDate).toLocaleDateString()}
                      </TableCell>
                      <TableCell className="text-right">
                        <div className="flex items-center justify-end gap-1">
                          <Button
                            variant="ghost"
                            size="icon"
                            className="h-8 w-8"
                            onClick={() => openAdjustDialog(item, "add")}
                          >
                            <Plus className="w-4 h-4" />
                          </Button>
                          <Button
                            variant="ghost"
                            size="icon"
                            className="h-8 w-8"
                            onClick={() => openAdjustDialog(item, "remove")}
                            disabled={item.stock === 0}
                          >
                            <Minus className="w-4 h-4" />
                          </Button>
                        </div>
                      </TableCell>
                    </TableRow>
                  )
                })}
              </TableBody>
            </Table>
          </CardContent>
        </Card>

        {/* Adjust Stock Dialog */}
        <Dialog open={isAdjustDialogOpen} onOpenChange={setIsAdjustDialogOpen}>
          <DialogContent className="sm:max-w-md">
            <DialogHeader>
              <DialogTitle>
                {adjustmentType === "add" ? "Add Stock" : "Remove Stock"}
              </DialogTitle>
              <DialogDescription>
                {selectedItem?.name}
              </DialogDescription>
            </DialogHeader>
            <div className="grid gap-4 py-4">
              <div className="flex items-center justify-between p-3 bg-muted rounded-lg">
                <span className="text-sm text-muted-foreground">Current Stock</span>
                <span className="font-bold">{selectedItem?.stock} units</span>
              </div>
              <div className="space-y-2">
                <Label htmlFor="amount">
                  {adjustmentType === "add" ? "Add Quantity" : "Remove Quantity"}
                </Label>
                <Input
                  id="amount"
                  type="number"
                  min="1"
                  value={adjustmentAmount}
                  onChange={(e) => setAdjustmentAmount(e.target.value)}
                  placeholder="Enter amount"
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="reason">Reason</Label>
                <Select value={adjustmentReason} onValueChange={setAdjustmentReason}>
                  <SelectTrigger>
                    <SelectValue placeholder="Select reason" />
                  </SelectTrigger>
                  <SelectContent>
                    {adjustmentType === "add" ? (
                      <>
                        <SelectItem value="restock">Restock</SelectItem>
                        <SelectItem value="return">Customer Return</SelectItem>
                        <SelectItem value="correction">Inventory Correction</SelectItem>
                      </>
                    ) : (
                      <>
                        <SelectItem value="sale">Sale</SelectItem>
                        <SelectItem value="damaged">Damaged</SelectItem>
                        <SelectItem value="expired">Expired</SelectItem>
                        <SelectItem value="correction">Inventory Correction</SelectItem>
                      </>
                    )}
                  </SelectContent>
                </Select>
              </div>
              {adjustmentAmount && (
                <div className="flex items-center justify-between p-3 bg-muted rounded-lg">
                  <span className="text-sm text-muted-foreground">New Stock</span>
                  <span className="font-bold">
                    {adjustmentType === "add" 
                      ? (selectedItem?.stock || 0) + parseInt(adjustmentAmount || "0")
                      : Math.max(0, (selectedItem?.stock || 0) - parseInt(adjustmentAmount || "0"))
                    } units
                  </span>
                </div>
              )}
            </div>
            <DialogFooter>
              <Button variant="outline" onClick={() => setIsAdjustDialogOpen(false)}>Cancel</Button>
              <Button 
                className="bg-primary hover:bg-primary/90" 
                onClick={handleAdjustStock}
                disabled={!adjustmentAmount || !adjustmentReason}
              >
                {adjustmentType === "add" ? (
                  <>
                    <Plus className="w-4 h-4 mr-2" />
                    Add Stock
                  </>
                ) : (
                  <>
                    <Minus className="w-4 h-4 mr-2" />
                    Remove Stock
                  </>
                )}
              </Button>
            </DialogFooter>
          </DialogContent>
        </Dialog>
      </div>
    </div>
  )
}
