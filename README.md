# 🏛️ WITI Governance Engine - Institutional Oversight & Management
🔗 [Institutional Portal](https://sanadidari.com/witi/gov) | [WITI Ecosystem](https://sanadidari.com/witi)

**WITI Governance Engine** is the administrative core of the **Sanadidari Legal Informatics Ecosystem**. Developed as a robust Laravel-based backend, it serves as the centralized hub for managing institutional workflows, legal acts, and judicial oversight.

---

## 🏗️ Architecture & Engineering Design

This engine is built on **Laravel 11** following a hybrid **Domain-Driven Design (DDD)** approach to handle the high complexity of judicial workflows.

- **Security Model**: Implements strict **Role-Based Access Control (RBAC)** via Laravel Policies and Gates.
- **Data Integrity**: Uses database-level transactions for legal acts to ensure no partial state changes in institutional records.
- **Optimization**: Eloquent indexing on geographic (`Tribunal`, `Region`) and temporal fields for high-performance reporting.
- **Interoperability**: Specialized API layer using **Sanctum** for secure communication with the **WITI Field (NOUR)** mobile client.

### 🏛️ Institutional Ecosystem
```mermaid
graph LR
    A[Tribunals / Justice] -- Oversight --> B[WITI Governance]
    B -- Management --> C[Bailiffs / Huissiers]
    C -- Operations --> D[WITI Field App]
    D -- Proof --> E[WITI Certify Protocol (QRPRUF)]
```

---

## 🚀 Local Development & Installation

### Prerequisites
- **PHP 8.2+**
- **Composer** 
- **Docker** (Recommended via Laravel Sail)
- **MySQL 8.0+**

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/sanadidari/governance-platform.git
   cd governance-platform
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Initialize Environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Setup Database & Seeds:
   ```bash
   php artisan migrate --seed
   ```
5. Run the dev server:
   ```bash
   # Using Sail
   ./vendor/bin/sail up
   # Or using local PHP
   php artisan serve
   ```

---

## 🧪 Testing & CI/CD
- **Automated Testing**: Standard PHPUnit suite in `tests/`. Includes Feature tests for API integrity and legal act lifecycles. Run with `./vendor/bin/phpunit`.
- **Static Analysis**: Configured PHPStan/Larastan for type-safety and maintenance quality.

---

## 📜 Professional Standard
This component is designed to meet the rigorous standards of **Invisible Tech**, **Gigster**, and high-growth startup ecosystems, focusing on **Maintainability**, **Auditability**, and **Security**.

---
*Developed by @sanadidari - Senior Full-Stack Engineer | Founder of Sanadidari SARL*

