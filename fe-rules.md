# Frontend Development Rules

## Tailwind CSS Usage

### 1. Avoid Arbitrary Values

-   **Rule:** Do not use arbitrary values (e.g., `gap-[5px]`, `leading-[22px]`, `text-[#71717A]`) unless absolutely necessary and no standard utility exists.
-   **Action:** Always check the [Tailwind CSS documentation](https://tailwindcss.com/docs) or the project's `main.css` configuration first to see if a standard class can be used.
-   **Example:**
    -   ❌ Bad: `gap-[5px]`
    -   ��� Good: `gap-1.5` (6px) or `gap-1` (4px) - choose the closest standard value.

### 2. Color Management

-   **Rule:** Do not use hex codes directly in classes (e.g., `text-[#71717A]`).
-   **Action:**
    1. Check `src/theme/main.css` to see if the color already exists as a CSS variable.
    2. If the color exists, use the corresponding utility class (e.g., `text-primary`, `bg-secondary-8`).
    3. If the color **does not** exist:
        - Create a new semantic variable in `src/theme/main.css` inside the `@theme` block.
        - Name it descriptively (e.g., `--color-brand-gray`, `--color-accent-blue`).
        - Convert the Hex color to **OKLCH** format.
        - Use the new variable in your component (e.g., `text-brand-gray`).

### 3. Color Format (OKLCH)

-   **Rule:** All new colors added to the theme must be in **OKLCH** format.
-   **Action:** Convert Hex or RGB values to OKLCH before adding them to `main.css`.
-   **Example:**
    -   ❌ Bad: `--color-neutral-8: #8d8d8d;`
    -   ✅ Good: `--color-neutral-8: oklch(0.5517 0.0138 285.94);`

## Component Generation

-   When generating Vue components, ensure all styles follow the above Tailwind rules.
-   Prefer standard spacing, typography, and color utilities over custom arbitrary values.
