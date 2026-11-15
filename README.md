# SISTEC-MDSS 💻🏛️
> **Sistema de Gestión y Trazabilidad de Soporte Técnico e Inventario Informático**  
> *Desarrollado para la Municipalidad Distrital de San Sebastián - Cusco*

---

## 🏢 Empresa Aliada y Contexto Operacional

### **Municipalidad Distrital de San Sebastián (Cusco)**
La Municipalidad Distrital de San Sebastián es una entidad de gobierno local encargada del desarrollo integral y la prestación de servicios públicos a más de 120,000 habitantes en la provincia de Cusco.

### **Área de Impacto: Oficina de Tecnología y Sistemas Informáticos (OTSI)**
La **OTSI** es el área estratégica responsable de garantizar la operatividad de la infraestructura tecnológica, redes, servidores y equipos informáticos (computadoras, impresoras, switches, laptops) de todas las gerencias y direcciones del municipio.

#### ⚠️ Problema Operacional
Antes de la implementación de **SISTEC-MDSS**, la OTSI operaba bajo un flujo tradicional basado en **fichas de atención físicas en papel**:
1. **Pérdida de Trazabilidad Patrimonial:** Dificultad para rastrear la ubicación, estado y responsable de los equipos ingresados a mantenimiento.
2. **Falta de Historial de Incidencias:** Ausencia de un registro histórico centralizado que permitiese identificar fallas recurrentes por Código Patrimonial.
3. **Ineficiencia en Tiempos de Respuesta:** Demora en la asignación de técnicos, diagnóstico y entrega de equipos a las áreas usuarias.

#### 💡 Solución Tecnológica
**SISTEC-MDSS** es una plataforma web desarrollada en **Laravel** que digitaliza y automatiza el flujo integral de soporte técnico de la OTSI, permitiendo la recepción mediante códigos patrimoniales, el registro de checklists diagnósticos, la asignación de mantenimientos y la generación de métricas en tiempo real.

---

## 🛠️ Stack Tecnológico y QA

* **Core Framework:** Laravel (PHP 8.x)
* **Base de Datos:** MySQL (Producción) / SQLite `:memory:` (Entorno de pruebas)
* **Pruebas Automatizadas:** PHPUnit (Enfoque TDD)
* **Estándar de Código:** Laravel Pint (PHP CS Fixer)
* **Integración Continua:** GitHub Actions (Automated CI/CD Pipeline)

---

## 🚀 Estado de Historias de Usuario (Backlog del Sprint)


| PBI / Issue | Descripción | Responsable | Estado |
| :--- | :--- | :--- | :--- |
| **PBI-01** | Registro y Recepción de Equipos Informáticos OTSI | Lead Backend Engineer 
| **PBI-02** | Registro de Diagnóstico Técnico e Incidentes | Backend Engineer 
| **PBI-03** | Asignación de Técnico de Soporte | Lead Frontend Engineer 
| **PBI-04** | Panel de Control y Seguimiento de Tickets (Dashboard) | Frontend / UX 
| **PBI-05** | Emisión de Reportes y Fichas de Salida | Fullstack Developer 


## ⚙️ Instalación y Despliegue Local

```bash
# 1. Clonar el repositorio
git clone [https://github.com/rodry674/sistec-mdss.git](https://github.com/rodry674/sistec-mdss.git)
cd sistec-mdss

# 2. Instalar dependencias
composer install
npm ci
npm run build

# 3. Configuración de entorno y base de datos
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# 4. Ejecución del pipeline de pruebas automatizadas (CI Local)
php artisan test

# 5. Iniciar servidor de desarrollo
php artisan serve