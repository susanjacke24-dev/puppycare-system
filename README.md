# PuppyCare

PuppyCare es una plataforma web moderna para la gestión integral de clínicas veterinarias desarrollada con Laravel, Livewire y TailwindCSS.

El sistema permite administrar:

* usuarios,
* mascotas,
* veterinarios,
* expedientes clínicos,
* consultas médicas,
* recetas veterinarias,
* agenda médica,
* reportes automatizados,
* y notificaciones inteligentes.

---

# Características principales

## Gestión de usuarios y roles

* Administración de usuarios.
* Roles y permisos dinámicos.
* Control de acceso mediante autenticación.
* Gestión de perfiles.

## Gestión veterinaria

* Registro de mascotas.
* Expediente clínico completo.
* Historial médico.
* Información de alergias, condiciones crónicas y antecedentes.

## Agenda médica inteligente

* Configuración de horarios laborales por veterinario.
* Visualización dinámica de citas.
* Estado visual de citas:

  * Pendiente
  * En proceso
  * Finalizada

## Consultas veterinarias

* Registro de diagnóstico.
* Tratamiento médico.
* Notas clínicas.
* Gestión de medicamentos.
* Historial de consultas anteriores.

## Generación automática de PDF

* Comprobantes de citas.
* Recetas veterinarias.
* Descarga automática de documentos clínicos.

## Sistema de correos automáticos

* Envío de recetas veterinarias por correo.
* Reportes automáticos diarios.
* Agenda diaria para veterinarios.
* Reporte consolidado para administración.

## Automatización y Scheduler

El sistema implementa automatización backend mediante Laravel Task Scheduling:

* envío automático de reportes,
* recordatorios,
* procesos clínicos programados.

Comandos automatizados:

```bash
php artisan puppycare:automate
```

Scheduler:

```php
Schedule::command('puppycare:automate')->dailyAt('08:00');
Schedule::command('puppycare:automate')->dailyAt('18:30');
```

---

# Tecnologías utilizadas

## Backend

* Laravel
* Livewire
* PHP
* MySQL

## Frontend

* TailwindCSS
* Flowbite
* WireUI
* FontAwesome

## Librerías adicionales

* DomPDF
* Laravel Jetstream
* Rappasoft Livewire Tables

---

# Diseño UI/UX

PuppyCare incorpora una interfaz moderna inspirada en dashboards SaaS:

* glassmorphism,
* transparencias,
* diseño responsive,
* sidebar moderna,
* componentes visuales dinámicos,
* paleta clínica verde/emerald.

---

# Funcionalidades destacadas

## Dashboard moderno

* Navegación lateral premium.
* Efectos visuales modernos.
* Interfaz responsiva.

## Sistema de búsqueda dinámica

* Filtrado en tiempo real.
* Estados vacíos personalizados.
* Experiencia de usuario moderna.

## Automatización clínica

* Correos automáticos.
* Scheduler backend.
* Recordatorios inteligentes.

---

# Instalación

## Clonar repositorio

```bash
git clone <repository_url>
```

## Instalar dependencias

```bash
composer install
npm install
```

## Variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

## Migraciones

```bash
php artisan migrate
```

## Storage

```bash
php artisan storage:link
```

## Ejecutar proyecto

```bash
php artisan serve
npm run dev
```

---

# Scheduler

Para activar tareas automáticas:

```bash
php artisan schedule:work
```

---

# Credenciales SMTP

El sistema utiliza Gmail SMTP para:

* recetas médicas,
* reportes automáticos,
* comprobantes clínicos.

---

# Arquitectura del sistema

PuppyCare implementa:

* arquitectura MVC,
* componentes Livewire,
* automatización backend,
* relaciones Eloquent,
* componentes reutilizables.

---

# Estado del proyecto

Proyecto funcional y en desarrollo continuo.

Próximas mejoras:

* estadísticas clínicas,
* dashboard analítico,
* modo oscuro completo,
* calendario avanzado,
* notificaciones en tiempo real,
* integración móvil.

---

# Autor

Desarrollado por Susan Jackeline y colaboradores académicos.

---

# Licencia

Proyecto académico y de desarrollo profesional.
