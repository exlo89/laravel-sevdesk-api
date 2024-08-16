# Migration zu Version 2.0

Seit 2024 nutzt Sevdesk die Version 2.0 der API. Die Änderungen betreffen größtenteils die Steuern und die Art der Steuerberechnung.
Für Details siehe die offizielle [Dokumentation](https://api.sevdesk.de/#section/sevdesk-Update-2.0).

## Änderungen im Package

In Version 1.0 benötigst du `TAX_TYPE`, was die jeweilige Steuerart beschreibt (z.B. `default`).
Mit `TAX_RATE` kannst du eine beliebige Steuerquote festlegen (z.B. `19`).

In Version 2.0 allerdings wird `TAX_TYPE` durch `TAX_RULE` ersetzt.

Was dazu noch zusätzlich beachtet werden muss, ist, dass jede `TAX_RULE` nur an bestimmte Tax Rates verknüpft ist.
Bedeutet z.b. bei der `TAX_RULE` 1 (Umsatzsteuerpflichtige Umsätze) darf die `TAX_RATE` nur 0, 7 oder 19 betragen.

Für das genaue Mapping schaue in die [offizielle Dokumentation](https://api.sevdesk.de/#section/sevdesk-Update-2.0).

> **_Wichtig:_** `TAX_TYPE` wird durch `TAX_RULE` ersetzt in Version 2.0.

## Welche Version nutze ich gerade?

Es gibt zwei Wege herauszufinden, welche Version du gerade verwendest. Entweder schaust du in deinem offiziellen Sevdesk-Account
unter deinem Profil. Dort steht die Version direkt unter deiner Kundennummer. Oder du verwendest den Command `php artisan sevdesk:version`.

```shell
php artisan sevdesk:version
```

## Version 1.0 Konfiguration

```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="Mehrwertsteuer 19%"
SEVDESK_TAX_TYPE=Standard
SEVDESK_CURRENCY=EUR
SEVDESK_INVOICE_TYPE=RE
```

## Version 2.0 Konfiguration
```dotenv
SEVDESK_TAX_RATE=19
SEVDESK_TAX_TEXT="MwSt 19%"
SEVDESK_TAX_RULE=1
SEVDESK_CURRENCY=EUR
```
