# Task Manager

![Laravel](https://img.shields.io/badge/Laravel-13-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Tests](https://img.shields.io/badge/Tests-Passing-success)

Aplicație web de gestionare a task-urilor personale, construită cu Laravel 13 și PHP 8.3. Fiecare utilizator își administrează propria listă de task-uri, cu prioritizare, status, deadline-uri, căutare și filtrare.

![Dashboard](screenshots/dashboard.png)

## Funcționalități

- **Autentificare completă** (înregistrare, login, resetare parolă, verificare email) — implementată cu Laravel Breeze
- **CRUD task-uri** — creare, editare, ștergere, vizualizare
- **Prioritate** — low / medium / high
- **Status** — todo / in progress / done
- **Deadline** — dată limită opțională per task
- **Căutare** — filtrare task-uri după titlu
- **Filtrare după status**
- **Dashboard cu statistici** — total task-uri, distribuția pe status (todo / in progress / done)
- **Izolare per utilizator** — fiecare user vede și modifică doar propriile task-uri

## Capturi de ecran

<table>
<tr>
<td width="50%">

**Adăugare task**
![Adaugă task](screenshots/create-task.png)

</td>
<td width="50%">

**Editare task**
![Editează task](screenshots/edit-task.png)

</td>
</tr>
<tr>
<td width="50%">

**Filtrare după status**
![Filtrare status](screenshots/filter-status.png)

</td>
<td width="50%">

**Lista de task-uri**
![Lista task-uri](screenshots/task-list.png)

</td>
</tr>
</table>

## Stack tehnic

| Componentă | Tehnologie |
|---|---|
| Backend | Laravel 13, PHP 8.3 |
| Autentificare | Laravel Breeze |
| Frontend | Blade, Tailwind CSS |
| Bază de date | MySQL |
| Testing | Pest |

## Structură bază de date

**tasks**
- `title`, `description`
- `priority` (enum: low, medium, high)
- `status` (enum: todo, in_progress, done)
- `due_date`
- `user_id` (foreign key, cascade on delete)

## Instalare locală

```bash
git clone https://github.com/RusanLucian/taskmanager.git
cd taskmanager
composer install
cp .env.example .env
php artisan key:generate
```

Configurează conexiunea la baza de date în `.env`, apoi:

```bash
php artisan migrate:fresh --seed
npm install
npm run build
php artisan serve
```

Aplicația va fi disponibilă la `http://localhost:8000`. Contul de test creat prin seeder:

- **Email:** `test@example.com`
- **Parolă:** `password`

## Testare

Suita de teste Pest acoperă CRUD-ul de task-uri și autorizarea (verifică faptul că un user nu poate modifica sau șterge task-urile altui user):

```bash
php artisan test
```

## Roadmap

- [x] Extragerea autorizării în `TaskPolicy` (în locul verificărilor manuale din controller)
- [x] Validare prin `FormRequest`-uri dedicate (`StoreTaskRequest`, `UpdateTaskRequest`)
- [x] Testare automată cu Pest
- [ ] Sortare task-uri (după deadline, prioritate)

## Autor

Rusan Lucian — proiect de portofoliu, dezvoltat ca parte a pregătirii pentru poziții de dezvoltator web.
