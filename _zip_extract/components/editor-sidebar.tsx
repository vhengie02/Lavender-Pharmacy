"use client"

import Link from "next/link"
import { usePathname } from "next/navigation"
import { cn } from "@/lib/utils"
import { LavenderLogo } from "./lavender-logo"
import {
  LayoutDashboard,
  ShoppingCart,
  Receipt,
  FileText,
  Settings,
  LogOut,
  ChevronLeft,
  ChevronRight,
  Package,
} from "lucide-react"
import { Button } from "@/components/ui/button"
import { useState } from "react"

const editorNavItems = [
  {
    title: "Dashboard",
    href: "/editor",
    icon: LayoutDashboard,
  },
  {
    title: "Point of Sale",
    href: "/editor/pos",
    icon: ShoppingCart,
  },
  {
    title: "Receipts",
    href: "/editor/receipts",
    icon: Receipt,
  },
  {
    title: "Products",
    href: "/editor/products",
    icon: Package,
  },
  {
    title: "Reports",
    href: "/editor/reports",
    icon: FileText,
  },
  {
    title: "Settings",
    href: "/editor/settings",
    icon: Settings,
  },
]

export function EditorSidebar() {
  const pathname = usePathname()
  const [collapsed, setCollapsed] = useState(false)

  return (
    <aside
      className={cn(
        "flex flex-col border-r border-border bg-card transition-all duration-300",
        collapsed ? "w-16" : "w-64"
      )}
    >
      <div className="flex h-16 items-center justify-between border-b border-border px-4">
        {!collapsed && (
          <Link href="/editor" className="flex items-center gap-2">
            <LavenderLogo className="h-8 w-8" />
            <span className="font-serif text-lg font-semibold text-primary">Editor</span>
          </Link>
        )}
        {collapsed && (
          <Link href="/editor" className="mx-auto">
            <LavenderLogo className="h-8 w-8" />
          </Link>
        )}
        <Button
          variant="ghost"
          size="icon"
          onClick={() => setCollapsed(!collapsed)}
          className={cn("h-8 w-8", collapsed && "mx-auto")}
        >
          {collapsed ? <ChevronRight className="h-4 w-4" /> : <ChevronLeft className="h-4 w-4" />}
        </Button>
      </div>

      <nav className="flex-1 space-y-1 p-2">
        {editorNavItems.map((item) => {
          const isActive = pathname === item.href || pathname.startsWith(item.href + "/")
          return (
            <Link
              key={item.href}
              href={item.href}
              className={cn(
                "flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors",
                isActive
                  ? "bg-primary text-primary-foreground"
                  : "text-muted-foreground hover:bg-accent hover:text-foreground",
                collapsed && "justify-center px-2"
              )}
              title={collapsed ? item.title : undefined}
            >
              <item.icon className="h-5 w-5 shrink-0" />
              {!collapsed && <span>{item.title}</span>}
            </Link>
          )
        })}
      </nav>

      <div className="border-t border-border p-2">
        <Link
          href="/login"
          className={cn(
            "flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-muted-foreground transition-colors hover:bg-destructive/10 hover:text-destructive",
            collapsed && "justify-center px-2"
          )}
          title={collapsed ? "Logout" : undefined}
        >
          <LogOut className="h-5 w-5 shrink-0" />
          {!collapsed && <span>Logout</span>}
        </Link>
      </div>
    </aside>
  )
}
