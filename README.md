# 🏛️ WITI Governance Engine - Institutional Oversight & Management

**WITI Governance Engine** is the administrative core of the **Sanadidari Legal Informatics Ecosystem**. Developed as a robust Laravel-based backend, it serves as the centralized hub for managing institutional workflows, legal acts, and judicial oversight.

Designed for high-trust environments, it connects judicial authorities, bailiffs, and tribunals into a seamless, verifiable management pipeline.

---

## 🏛️ Institutional Core Features

### ⚖️ Judicial Lifecycle Management
- **Acts Management**: Complete CRUD and lifecycle tracking for `Acte` (Legal Acts), ensuring full traceability.
- **Bailiff Directory (`Huissier`)**: Centralized management of certified institutional agents and their credentials.
- **Tribunal Integration**: Mapping of judicial jurisdictions (`Region`, `Tribunal`) to missions for geography-aware oversight.

### 🛡️ Compliance & Oversight
- **Complaint Handling**: Integrated `Complaint` module for public or institutional grievance tracking and resolution.
- **Role-Based Access Control (RBAC)**: Fine-grained permissions using Laravel's policy-driven architecture, ensuring that sensitive institutional data is only accessible to authorized personnel.

### 📄 Professional Reporting
- **PDF Generation Engine**: Automated generation of official judicial documents and mission reports (`ActeController@downloadPdf`).
- **Data Integrity**: Backend validation logic to ensure all legal documentation meets institutional standards before certification.

---

## 🛠️ Engineering & Architecture

- **Framework**: Laravel 10 (PHP 8.2+)
- **Architecture**: Domain-Driven Design (DDD) elements with specialized Models for institutional entities.
- **Security**: 
    - **CSRF Protection & Secure Headers**: Hardened configuration for government-grade security.
    - **Row-Level Logic**: Advanced Eloquent queries to filter data based on regional jurisdiction.
- **Tooling**: Custom scripts for institutional data migration (`fix_schema.php`) and administrator bootstrapping.

---

## 🚀 Part of the WITI Ecosystem

This engine provides the backend infrastructure for the **WITI Field App (NOUR)** and integrates with the **WITI Certify Protocol (QRPRUF)** to ensure that every field action is recorded, managed, and audited.

---
*Developed by @sanadidari - Senior Full-Stack Engineer | Founder of Sanadidari SARL*
