# PuppyCare

Sistema web moderno de gestión veterinaria desarrollado con Laravel, Livewire y TailwindCSS.

---

# Características principales

* Gestión de usuarios y roles
* Gestión de mascotas y expedientes clínicos
* Agenda veterinaria
* Consultas médicas
* Generación de recetas PDF
* Correos automáticos
* Automatización con Scheduler
* Dashboard moderno estilo SaaS

---

# Tecnologías utilizadas

* Laravel
* Livewire
* TailwindCSS
* MySQL
* Jetstream
* WireUI
* DomPDF

---

# Instalación del proyecto

## 1. Clonar repositorio

```bash
git clone https://github.com/susanjacke24-dev/puppycare-system.git
```

---

## 2. Instalar dependencias

```bash
composer install
npm install
```

---

## 3. Configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

---

## 4. Configurar base de datos

Crear una base de datos llamada:

```plaintext
puppycare_db
```

---

## 5. Ejecutar migraciones

```bash
php artisan migrate
```

---

## 6. Crear enlace de storage

```bash
php artisan storage:link
```

---

## 7. Ejecutar proyecto

```bash
php artisan serve
npm run dev
```

---

# Scheduler y automatización

El sistema implementa automatización mediante Laravel Scheduler.

Ejecutar:

```bash
php artisan schedule:work
```

Comandos automatizados:

* envío de reportes diarios,
* envío de recetas,
* automatización clínica.

---

# Credenciales de prueba

## Administrador

Email:

```plaintext
susanjacke.24@gmail.com
```

Password:

```plaintext
password
```

---

## Veterinario

Email:

```plaintext
mtromisset21@gmail.com
```

Password:

```plaintext
password
```

---

# Diagrama Entidad-Relación (DER)

## Entidades principales

* users
* roles
* patients
* appointments
* medicines
* prescriptions
* schedules

Relaciones:

* Un usuario puede tener múltiples mascotas.
* Un veterinario puede tener múltiples citas.
* Una cita pertenece a una mascota.
* Una consulta genera recetas y medicamentos.

---

# Arquitectura

El sistema utiliza:

* arquitectura MVC,
* componentes Livewire,
* relaciones Eloquent,
* automatización backend,
* diseño responsive.

---

# Estado del proyecto

Proyecto académico funcional en desarrollo continuo.

---

# Autor

Susan Jackeline y colaboradores académicos.
