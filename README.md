# 🎨 demo-theme

Własny motyw WordPress stworzony jako projekt demonstracyjny.
Zadanie zostało nadbudowywane na kodzie z projektu "Zadanie na start" w celu zapoznania się z wtyczką ALL-IN-ONE WP MIGRATION.

---

## 📁 Struktura plików

```
demo-theme/
│
├── inc/                        # Moduły PHP (logika motywu)
│   ├── enqueue.php             # Ładowanie CSS i JS
│   ├── cpt-projects.php        # Custom Post Type: Projekty + taksonomia: Technologie
│   ├── metaboxes.php           # Meta Box z custom fields dla CPT Projekty
│   ├── menus.php               # Rejestracja obszarów nawigacji
│   └── contact-form.php        # Obsługa formularza kontaktowego (wzorzec PRG)
│
├── css/                        # Arkusze stylów (modularne)
│   ├── base.css                # Reset, typografia, zmienne CSS
│   ├── components.css          # Przyciski, karty, wspólne elementy
│   ├── navigation.css          # Nawigacja + hamburger menu (mobile)
│   ├── projects.css            # Siatka projektów
│   ├── blog.css                # Lista wpisów blogowych
│   ├── contact.css             # Strona kontaktowa
│   ├── acf-demo.css            # Demo pól ACF
│   ├── acf-taksonomie.css      # Lista filmów z taksonomią
│   └── error-404.css           # Strona błędu 404
│
├── js/
│   └── navigation.js           # Toggle hamburger menu (vanilla JS)
│
├── functions.php               # Bootstrap — ładuje moduły z inc/
├── header.php                  # Nagłówek HTML, meta SEO, Open Graph, nawigacja
├── footer.php                  # Stopka, wp_footer()
├── front-page.php              # Strona główna — siatka 6 najnowszych projektów
├── single-project.php          # Widok pojedynczego projektu (layout dwukolumnowy)
├── page-blog.php               # Lista wpisów z paginacją (Template: Lista Wpisów)
├── page-kontakt.php            # Formularz kontaktowy z obsługą statusu
├── page-acf-demo.php           # Demo pól ACF: płeć + kolor CSS
├── page-acf-taksonomie.php     # Lista filmów z taksonomią Aktorzy / Języki
├── 404.php                     # Strona błędu 404
├── index.php                   # Fallback WordPress (wymagany)
├── page.php                    # Domyślny widok strony
├── style.css                   # Metadane motywu (wymagane przez WP)
└── theme.json                  # Konfiguracja edytora blokowego
```

---

## ⚙️ Funkcjonalności

### Custom Post Type — Projekty

Zarejestrowany CPT `project` z archiwum pod adresem `/projekty/` i obsługą Gutenberga.

**Custom Fields (Meta Box):**

| Klucz meta            | Typ  | Opis                             |
| --------------------- | ---- | -------------------------------- |
| `_project_github_url` | URL  | Link do repozytorium GitHub      |
| `_project_deadline`   | text | Termin wykonania (np. „Q3 2026") |

**Custom Taxonomy:**

| Nazwa       | Slug          | Typ                           |
| ----------- | ------------- | ----------------------------- |
| Technologie | `technologia` | hierarchiczna (jak kategorie) |

---

### Formularz kontaktowy

Obsługiwany przez WordPress `admin-post.php` z wzorcem **Post/Redirect/Get** — zapobiega ponownemu wysłaniu formularza po odświeżeniu strony.

```
[Formularz POST] → admin-post.php → walidacja + sanityzacja → wp_mail() → redirect
```

**Zabezpieczenia:**

- Weryfikacja nonce (ochrona przed CSRF)
- Sanityzacja wszystkich pól wejściowych (`sanitize_text_field`, `sanitize_email`, `sanitize_textarea_field`)
- Walidacja adresu e-mail przez `is_email()`
- Przekierowanie przez `wp_safe_redirect()`

---

### Nawigacja mobilna

Hamburger menu zaimplementowane w czystym vanilla JS (`navigation.js`) bez żadnych zewnętrznych bibliotek. Zarządza atrybutem `aria-expanded` dla dostępności (a11y).

---

### SEO & Open Graph

`header.php` generuje dynamicznie:

- `<meta name="description">` — opis strony lub excerpt wpisu
- `<meta property="og:title">` — tytuł dla social media
- `<meta property="og:description">` — opis dla social media
- `<meta property="og:type">` — `article` dla wpisów, `website` dla pozostałych

---

### Moduły CSS

Style są ładowane modularnie z zależnościami (`wp_enqueue_style`):

```
base.css
└── components.css
    ├── navigation.css
    ├── projects.css
    ├── contact.css
    ├── blog.css
    ├── error-404.css
    ├── acf-demo.css
    └── acf-taksonomie.css
```

---

## 🔧 Środowisko

Motyw uruchamiany lokalnie w środowisku **Docker** (WordPress + MariaDB). Dane importowane za pomocą wtyczki **All-in-One WP Migration**.

| Usługa    | Obraz              |
| --------- | ------------------ |
| WordPress | `wordpress:latest` |
| Baza      | `mariadb:10.11`    |

---

## 🛠 Zastosowane mechanizmy WordPress

| Mechanizm              | Gdzie używany                                                |
| ---------------------- | ------------------------------------------------------------ |
| `WP_Query`             | `front-page.php`, `page-blog.php`, `page-acf-taksonomie.php` |
| `register_post_type()` | `inc/cpt-projects.php`                                       |
| `register_taxonomy()`  | `inc/cpt-projects.php`                                       |
| `add_meta_box()`       | `inc/metaboxes.php`                                          |
| `wp_nonce_field()`     | Formularz kontaktowy + meta box                              |
| `get_field()` (ACF)    | `page-acf-demo.php`                                          |
| `get_the_term_list()`  | `page-acf-taksonomie.php`                                    |
| `wp_nav_menu()`        | `header.php`                                                 |
| `wp_enqueue_style()`   | `inc/enqueue.php`                                            |
| `admin_post_*` hook    | `inc/contact-form.php`                                       |
| `paginate_links()`     | `page-blog.php`                                              |
