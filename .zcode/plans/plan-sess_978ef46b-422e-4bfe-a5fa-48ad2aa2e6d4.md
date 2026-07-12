## Admin Redesign — "Clean Light + Glass"

A full visual redesign of every in-app admin page plus the shared layout. Light theme with frosted-glass surfaces, rounded-2xl cards, colored Font Awesome icon chips, thin borders, and a refined sidebar/header. **Functionality, forms, routes, Blade directives, and all JS (Chart.js, SweetAlert, AJAX, modals) stay 100% intact** — this is purely a presentational layer swap.

### Shared design system (applied consistently across all pages)
- **Font Awesome 6.4.0** CDN added to layout head (matches storefront `boutique.blade.php`) — replaces all nav/button/table emoji with `fa-solid` icons. Contextual emoji kept only in alerts.
- **Body background**: subtle `bg-gradient-to-br from-slate-50 via-white to-emerald-50/40`.
- **Glass surface utility** (one small `<style>` block in layout): semi-transparent white bg + `backdrop-blur-xl` + hairline border + soft shadow — used on sidebar, header, cards, modals.
- **Component patterns**: stat cards = glass card + colored icon chip; tables = glass container + light sticky header + hover rows + FA action chips; inputs = `rounded-xl bg-gray-50/60` + green focus ring; primary btn = `bg-green-600`; secondary = white/border.
- Keep **Inter** font + Tailwind v4 browser CDN already in use.

### 1. `layouts/admin.blade.php` — full rewrite (the keystone)
- **Sidebar** (`bg-white/70 backdrop-blur-xl`): gradient logo mark (FA `fa-prescription-bottle-medical`) + "ParaAdmin" wordmark + "Espace Administration" subtitle. Nav grouped into 3 labeled sections (PRINCIPAL / GESTION / SÉCURITÉ). Active link = `bg-green-600 text-white shadow-lg`. FA icons per item. Bottom: user mini-card (initials avatar, name, role) + glass logout button. Add mobile hamburger toggle.
- **Header** (`bg-white/70 backdrop-blur-xl sticky top-0`): left = hamburger (mobile) + `@yield('page_title')` + `@yield('page_subtitle')`; right = notif bell, "Modifier mot de passe" pill, user avatar. Add `@yield('header_actions')` slot so each page mounts its primary CTA in the header instead of a redundant in-page title bar.
- Restyle password modal to glass. Keep its JS.

### 2. `admin/dashboard.blade.php`
- Move "Télécharger le Rapport PDF" into `@yield('header_actions')`; drop the duplicate welcome bar (welcome line becomes the page subtitle).
- Stat cards → glass + colored FA icon chips. Chart card → glass with legend chips. Filter form, add-product form, flash-sale form → glass consistency + FA icons + refined inputs/buttons. Modals → glass. **All Chart.js/SweetAlert/AJAX/category/stock JS preserved verbatim.**

### 3. `admin/produits.blade.php`
- Title via layout; "Ajouter un produit" → `header_actions`. Search input → glass with FA magnifier icon. Table → glass container, FA edit/delete chips. Keep filter JS.

### 4. `admin/edit.blade.php` — unify into shared layout (structural fix)
- Convert from standalone full HTML doc to `@extends('layouts.admin')`. Delete its duplicate `<head>`/`<aside>`/`<header>`. Form fields preserved, restyled to glass + FA.

### 5. `admin/commandes.blade.php`
- Title + badge via layout. Table → glass; status progress bar + status pills restyled; FA action icons. Keep status-update forms.

### 6. `admin/users/index.blade.php`
- Section headers restyled (Staff / Clients). Add-staff form + both tables → glass + FA chips. Edit modal → glass. Keep modal JS.

### 7. `admin/messages.blade.php`
- Title + count badge via layout. Table → glass; "Nouveau/Lu" badges; FA reply/mark-read/delete chips. Keep pagination.

### 8. `admin/coupons/index.blade.php`
- Title + active/expired stat chips via layout. Form card + table → glass consistency + FA.

### 9. `admin/logs.blade.php`
- Title via layout. Table → glass; action-type badges restyled; FA icons. Keep pagination.

### Out of scope
- `admin/reports/pdf.blade.php` — intentional print document, leave as-is.
- No controller/route/JS-logic changes. No new dependencies beyond the FA CDN link.

### Verification
After editing, run `php artisan route:list --name=admin` to confirm no route references broke, and visually reason over each page's bindings (`{{ }}`, `{!! !!}`, form actions) to ensure nothing functional was touched.