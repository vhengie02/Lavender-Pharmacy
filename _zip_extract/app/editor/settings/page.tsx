"use client"

import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Switch } from "@/components/ui/switch"
import {
  User,
  Bell,
  Printer,
  Receipt,
  Shield,
  Save,
} from "lucide-react"
import { useState } from "react"

export default function EditorSettingsPage() {
  const [settings, setSettings] = useState({
    name: "John Doe",
    email: "john.doe@lavenderpharmacy.com",
    printReceipt: true,
    soundEnabled: true,
    autoLogout: 30,
    receiptFooter: "Thank you for shopping at Lavender Pharmacy!",
    taxRate: "8",
  })

  const handleSave = () => {
    // Save settings
    alert("Settings saved successfully!")
  }

  return (
    <div className="p-6 space-y-6 max-w-4xl">
      <div>
        <h1 className="text-3xl font-serif font-bold text-foreground">Settings</h1>
        <p className="text-muted-foreground mt-1">
          Manage your POS preferences and account settings
        </p>
      </div>

      {/* Profile Settings */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <User className="h-5 w-5" />
            Profile
          </CardTitle>
          <CardDescription>Your account information</CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="grid grid-cols-2 gap-4">
            <div className="space-y-2">
              <Label htmlFor="name">Full Name</Label>
              <Input
                id="name"
                value={settings.name}
                onChange={(e) => setSettings({ ...settings, name: e.target.value })}
              />
            </div>
            <div className="space-y-2">
              <Label htmlFor="email">Email</Label>
              <Input
                id="email"
                type="email"
                value={settings.email}
                onChange={(e) => setSettings({ ...settings, email: e.target.value })}
              />
            </div>
          </div>
          <Button variant="outline">Change Password</Button>
        </CardContent>
      </Card>

      {/* Receipt Settings */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Receipt className="h-5 w-5" />
            Receipt Settings
          </CardTitle>
          <CardDescription>Configure receipt printing options</CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="flex items-center justify-between">
            <div className="space-y-0.5">
              <Label>Auto Print Receipt</Label>
              <p className="text-sm text-muted-foreground">Automatically print receipt after each sale</p>
            </div>
            <Switch
              checked={settings.printReceipt}
              onCheckedChange={(checked) => setSettings({ ...settings, printReceipt: checked })}
            />
          </div>
          <div className="space-y-2">
            <Label htmlFor="footer">Receipt Footer Message</Label>
            <Input
              id="footer"
              value={settings.receiptFooter}
              onChange={(e) => setSettings({ ...settings, receiptFooter: e.target.value })}
            />
          </div>
          <div className="space-y-2">
            <Label htmlFor="tax">Tax Rate (%)</Label>
            <Input
              id="tax"
              type="number"
              value={settings.taxRate}
              onChange={(e) => setSettings({ ...settings, taxRate: e.target.value })}
              className="w-32"
            />
          </div>
        </CardContent>
      </Card>

      {/* Printer Settings */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Printer className="h-5 w-5" />
            Printer
          </CardTitle>
          <CardDescription>Configure receipt printer</CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="p-4 bg-accent/30 rounded-lg flex items-center justify-between">
            <div>
              <p className="font-medium">Epson TM-T88VI</p>
              <p className="text-sm text-muted-foreground">Connected via USB</p>
            </div>
            <Button variant="outline" size="sm">Test Print</Button>
          </div>
          <Button variant="outline">Configure Printer</Button>
        </CardContent>
      </Card>

      {/* Notification Settings */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Bell className="h-5 w-5" />
            Notifications
          </CardTitle>
          <CardDescription>Sound and alert preferences</CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="flex items-center justify-between">
            <div className="space-y-0.5">
              <Label>Sound Effects</Label>
              <p className="text-sm text-muted-foreground">Play sounds for scan and payment</p>
            </div>
            <Switch
              checked={settings.soundEnabled}
              onCheckedChange={(checked) => setSettings({ ...settings, soundEnabled: checked })}
            />
          </div>
        </CardContent>
      </Card>

      {/* Security Settings */}
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Shield className="h-5 w-5" />
            Security
          </CardTitle>
          <CardDescription>Security and session settings</CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="space-y-2">
            <Label htmlFor="autoLogout">Auto Logout (minutes)</Label>
            <Input
              id="autoLogout"
              type="number"
              value={settings.autoLogout}
              onChange={(e) => setSettings({ ...settings, autoLogout: parseInt(e.target.value) })}
              className="w-32"
            />
            <p className="text-sm text-muted-foreground">Automatically logout after inactivity</p>
          </div>
        </CardContent>
      </Card>

      {/* Save Button */}
      <div className="flex justify-end">
        <Button onClick={handleSave} className="min-w-32">
          <Save className="mr-2 h-4 w-4" />
          Save Settings
        </Button>
      </div>
    </div>
  )
}
