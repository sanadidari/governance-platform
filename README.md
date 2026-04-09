# Governance Platform — Institutional Management for Judicial Officers

**National platform for managing the bailiff profession in Morocco**, built for the [National Council of Bailiffs of Justice](https://sanadidari.com/witi/gov). Part of the **NOUR** unified judicial ecosystem.

🔗 [Live Portal](https://sanadidari.com/witi/governance) · [NOUR Mobile App](https://github.com/sanadidari/nour-mobile) · [WITI Ecosystem](https://sanadidari.com/witi)

---

## Overview

This platform provides the institutional back-office for **huissiers de justice** (judicial officers) across Morocco's 12 regions and 73 courts. It was built following a convention between **Sanadidari SARL** and the **Conseil National des Huissiers de Justice du Maroc**.

Alongside the platform, a Sanctum API automatically provisions credentials for the **NOUR** mobile app — so every registered huissier gets simultaneous access to both the institutional dashboard and the field certification app (zero-trust proof of presence via QR cryptography).

**Stack:** Laravel 12 · Filament 3 · MySQL · Sanctum · Arabic RTL UI

---

## Dashboard & Analytics

| KPI Overview | Account Widget |
|---|---|
| ![Dashboard KPIs](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc1.png) | ![Dashboard account](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc2.png) |

| Analytics Charts — Huissiers by Region & Status |
|---|
| ![Charts](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc3.png) |

Real-time statistics: **3 registered huissiers**, **73 courts (mahakems)**, **12 regions**. Charts rendered via Filament widgets with Recharts.

---

## Judicial Acts (Actes & Procédures)

| New Act Form — Date & Type | Act Type Selection |
|---|---|
| ![Acte form 1](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc4.png) | ![Acte type dropdown](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc5.png) |

| Act Form — Reference Fields |
|---|
| ![Acte form 2](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc6.png) |

Act types: Notification, Status Change, Constat/Saisie. Full lifecycle tracking with timestamps and reference numbers.

---

## Complaints (الشكايات)

| Complaint Form — Rich Text | Complaint Status & Urgency |
|---|---|
| ![Complaint form 1](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc7.png) | ![Complaint form 2](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc8.png) |

Complaint intake with rich text editor, status workflow (pending/in review/resolved), and urgency classification.

---

## Huissier Management

| Huissiers List — Search & Filter | Add Huissier — Personal Info |
|---|---|
| ![Huissiers list](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc9.png) | ![Add huissier 1](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc10.png) |

| Add Huissier — Address Fields |
|---|
| ![Add huissier 2](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc11.png) |

On huissier creation, the `HuissierObserver` auto-provisions a `User` record with Sanctum credentials — same credentials sync to NOUR mobile via Supabase Auth (shared email identity).

---

## Regional Administration

| Add Regional Admin (مسؤول جهوي) |
|---|
| ![Regional admin form](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc12.png) |

RBAC with roles: `super_admin`, `regional_admin`, `huissier`. Regional admins manage their own jurisdiction scope.

---

## Geographic Coverage — Regions & Courts

| 12 Moroccan Regions (الجهات) | Regions — Continued |
|---|---|
| ![Regions 1](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc13.png) | ![Regions 2](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc14.png) |

| 73 Courts (المحاكم) | Courts — Continued |
|---|---|
| ![Mahakems 1](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc15.png) | ![Mahakems 2](https://raw.githubusercontent.com/sanadidari/governance-platform/main/docs/screenshots/sc16.png) |

Full geographic coverage of Morocco's judicial map: all regions and all courts pre-seeded.

---

## Architecture

```
┌─────────────────────────────────────────────┐
│         Governance Platform (Laravel)        │
│  ┌──────────┐  ┌──────────┐  ┌───────────┐  │
│  │  Filament│  │ Sanctum  │  │  HuissierO│  │
│  │  Admin   │  │  API     │  │  bserver  │  │
│  └──────────┘  └────┬─────┘  └─────┬─────┘  │
└───────────────────┼────────────────┼────────┘
                    │                │
                    ▼                ▼
          NOUR Mobile App      User provisioning
          (Flutter + QRPRUF)   (shared credentials)
```

- **HuissierObserver** — auto-provisions User on Huissier creation, bridges both apps via shared email identity
- **Sanctum API** — token-based auth for mobile client
- **Filament 3** — full Arabic RTL admin panel (via `APP_LOCALE=ar`)
- **RBAC** — policies enforce scope per role (super_admin / regional_admin / huissier)

---

## Installation

```bash
git clone https://github.com/sanadidari/governance-platform.git
cd governance-platform
composer install
cp .env.example .env
php artisan key:generate
# Configure DB in .env
php artisan migrate --seed
php artisan serve
```

Admin panel at: `http://127.0.0.1:8000/admin/shuffle`

---

## Related Projects

| Project | Description |
|---|---|
| [NOUR Mobile](https://github.com/sanadidari/nour-mobile) | Unified judicial mobile app (Flutter) — this platform + QRPruf |
| [QRPruf](https://github.com/sanadidari/qrpruf) | Zero-trust proof of presence (QR cryptography) |

---

*Built by [Samir Chatwiti](https://sanadidari.com) — Sanadidari SARL · LegalTech · Morocco*
