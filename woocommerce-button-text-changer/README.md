# WooCommerce Button Text Changer

**WordPress-Plugin** zum Anpassen der WooCommerce-Button-Texte für „In den Warenkorb“ und externe/Affiliate-Produkte.

- **Version:** 1.1.0  
- **Autor:** Sven Gauditz  
- **Lizenz:** GPL v2 or later  
- **Text Domain:** `woocommerce-button-text-changer`

---

## Beschreibung

Das Plugin ersetzt die Standard-Button-Texte von WooCommerce durch frei wählbare Texte. So kannst du z. B. „In den Warenkorb“ durch „Kaufen“ oder „Zum Warenkorb“ ersetzen und für Affiliate-/externe Produkte einen eigenen Text (z. B. „Jetzt kaufen“) festlegen.

### Funktionsumfang

- **„In den Warenkorb“-Button**  
  Ein einheitlicher Text für alle normalen Produkte (einfach, variabel, gruppiert etc.) – auf der **Einzelproduktseite** und auf **Shop-/Kategorie-/Archivseiten**.

- **Affiliate-/Externe-Produkt-Button**  
  Separater Text für Produkte vom Typ **Externes/Affiliate-Produkt**. Diese Produkte leiten zum externen Shop weiter; der Button kann z. B. „Jetzt kaufen“ oder „Zum Anbieter“ heißen.

- **Einstellungsseite**  
  Alle Texte werden zentral unter **Einstellungen → WooCommerce Button Text** gepflegt. Leere Felder lassen den WooCommerce-Standardtext unverändert.

- **Übersetzungsbereitschaft**  
  Plugin-Texte sind mit der WordPress-Übersetzungs-API vorbereitet (Text Domain: `woocommerce-button-text-changer`).

- **WooCommerce-Abhängigkeit**  
  Wenn WooCommerce nicht aktiv ist, erscheint ein Hinweis im Admin und die Plugin-Funktionen werden nicht geladen.

---

## Anforderungen

| Anforderung | Version |
|-------------|---------|
| WordPress | 5.0 oder höher |
| PHP | 7.4 oder höher |
| WooCommerce | 5.0 oder höher (getestet bis 8.x) |

WooCommerce muss **installiert und aktiviert** sein, damit das Plugin die Button-Texte ändert.

---

## Installation

### Über WordPress-Admin (ZIP-Upload)

1. WooCommerce installieren und aktivieren.
2. Plugin als ZIP packen (der Ordner im ZIP soll `woocommerce-button-text-changer` heißen).
3. **Plugins → Installieren → Plugin hochladen** → ZIP auswählen und installieren.
4. Plugin aktivieren.
5. Unter **Einstellungen → WooCommerce Button Text** die gewünschten Texte eintragen und speichern.

### Manuelle Installation

1. WooCommerce installieren und aktivieren.
2. Ordner `woocommerce-button-text-changer` nach `wp-content/plugins/` kopieren.
3. Unter **Plugins** das Plugin **WooCommerce Button Text Changer** aktivieren.
4. Unter **Einstellungen → WooCommerce Button Text** die Button-Texte anpassen und speichern.

---

## Konfiguration & Nutzung

### Einstellungsseite

- **Menüpfad:** **Einstellungen → WooCommerce Button Text**
- **Berechtigung:** Nur Benutzer mit der Berechtigung **Optionen verwalten** (`manage_options`) sehen die Seite.

### Einstellungsfelder

| Feld | Beschreibung | Standard |
|------|--------------|----------|
| **„In den Warenkorb“-Button** | Text für den Button bei normalen Produkten (Einzelprodukt- und Shop-Seiten). | „In den Warenkorb“ |
| **Affiliate-/Externe-Produkt-Button** | Text für den Button bei externen/Affiliate-Produkten. | „Jetzt kaufen“ |

- **Leere Felder:** Wenn ein Feld leer gelassen wird, bleibt der jeweilige WooCommerce-Standardtext erhalten.
- **Eingabe:** Texte werden von HTML-Tags bereinigt und auf 200 Zeichen begrenzt.

### Wo die geänderten Texte erscheinen

- **Einzelproduktseite:** Der große „In den Warenkorb“-Button unter der Produktbeschreibung.
- **Shop-/Archivseiten:** Der Button in den Produktkacheln (z. B. Shop, Kategorien, Suchergebnisse).
- **Externe/Affiliate-Produkte:** Überall dort, wo WooCommerce den Button für diesen Produkttyp anzeigt; das Plugin nutzt hier den eingestellten Affiliate-Button-Text.

---

## Plugin-Struktur (Entwickler)

```
woocommerce-button-text-changer/
├── woocommerce-button-text-changer.php   # Hauptdatei: Bootstrap, WC-Check, Textdomain
├── includes/
│   ├── class-wcbtc-filters.php          # WooCommerce-Filter für Button-Texte
│   └── index.php
├── admin/
│   ├── class-wcbtc-admin.php            # Einstellungsseite, Settings API
│   └── index.php
├── uninstall.php                         # Löscht Optionen bei Deinstallation
├── readme.txt                            # WordPress.org-Format
└── README.md                             # Diese Datei
```

### Verwendete WooCommerce-Filter

- `woocommerce_product_single_add_to_cart_text` – Button auf der Einzelproduktseite (normale und externe Produkte).
- `woocommerce_product_add_to_cart_text` – Button auf Shop-/Archivseiten (normale und externe Produkte).

Die Logik unterscheidet intern nach Produkttyp (`external` vs. andere) und gibt den passenden gespeicherten Text zurück.

### Optionen (Datenbank)

| Option | Beschreibung |
|--------|--------------|
| `wc_add_to_cart_text` | Text für den normalen „In den Warenkorb“-Button. |
| `wc_affiliate_button_text` | Text für den Button bei externen/Affiliate-Produkten. |

Bei **Deinstallation** des Plugins werden diese Optionen durch `uninstall.php` gelöscht.

### Konstanten

- `WCBTC_VERSION` – Plugin-Version
- `WCBTC_PLUGIN_FILE` – Pfad zur Haupt-Plugin-Datei
- `WCBTC_PLUGIN_DIR` – Plugin-Verzeichnis
- `WCBTC_PLUGIN_BASENAME` – Plugin-Basename für WordPress

---

## Changelog

### 1.1.0

- Überarbeitete Plugin-Struktur (Hauptdatei, `includes/`, `admin/`).
- WooCommerce-Abhängigkeitsprüfung mit Admin-Hinweis, wenn WooCommerce fehlt.
- Einstellungen mit vollständiger WordPress Settings API und Sanitization.
- Übersetzungsbereitschaft (Text Domain, `load_plugin_textdomain`).
- Uninstall-Cleanup: Optionen werden bei Deinstallation gelöscht (`uninstall.php`).
- Einheitliche Button-Logik pro Filter (normale vs. externe Produkte).

### 1.0.0

- Erste Version: Anpassung von „In den Warenkorb“- und Affiliate-Button-Text über die WordPress-Einstellungen.

---

## Lizenz

GPL v2 or later.  
Lizenztext: [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)

---

## Autor

**Sven Gauditz**  
- Web: [gauditz.com](https://gauditz.com/)
