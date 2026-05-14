export function LavenderLogo({ className = "h-8 w-auto" }: { className?: string }) {
  return (
    <svg
      viewBox="0 0 200 50"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
    >
      {/* Lavender Flower Icon */}
      <g>
        {/* Stem */}
        <path
          d="M20 45 Q22 35 20 25"
          stroke="currentColor"
          strokeWidth="2"
          fill="none"
          className="text-primary"
        />
        {/* Leaves */}
        <path
          d="M20 35 Q15 33 12 36 Q15 38 20 35"
          fill="currentColor"
          className="text-primary/70"
        />
        <path
          d="M20 38 Q25 36 28 39 Q25 41 20 38"
          fill="currentColor"
          className="text-primary/70"
        />
        {/* Lavender Petals - Bottom to Top */}
        <ellipse cx="20" cy="22" rx="3" ry="4" fill="currentColor" className="text-primary" />
        <ellipse cx="18" cy="18" rx="2.5" ry="3.5" fill="currentColor" className="text-primary/90" />
        <ellipse cx="22" cy="18" rx="2.5" ry="3.5" fill="currentColor" className="text-primary/90" />
        <ellipse cx="20" cy="14" rx="2.5" ry="3.5" fill="currentColor" className="text-primary/80" />
        <ellipse cx="18" cy="10" rx="2" ry="3" fill="currentColor" className="text-primary/70" />
        <ellipse cx="22" cy="10" rx="2" ry="3" fill="currentColor" className="text-primary/70" />
        <ellipse cx="20" cy="6" rx="1.5" ry="2.5" fill="currentColor" className="text-primary/60" />
      </g>
      
      {/* Text */}
      <text
        x="40"
        y="32"
        fontFamily="var(--font-playfair), Georgia, serif"
        fontSize="18"
        fontWeight="600"
        fill="currentColor"
        className="text-foreground"
      >
        Lavender
      </text>
      <text
        x="40"
        y="45"
        fontFamily="var(--font-inter), system-ui, sans-serif"
        fontSize="10"
        fontWeight="400"
        letterSpacing="0.15em"
        fill="currentColor"
        className="text-muted-foreground"
      >
        PHARMACY
      </text>
    </svg>
  )
}
