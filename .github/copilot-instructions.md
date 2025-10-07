## Purpose
This file gives focused, actionable guidance so an AI coding agent can be productive in this repository quickly.

## Big picture (what this repo contains)
- Small PHP coursework project with multiple example apps in folders: `Assn2/`, `Assn3/`, `Assn4/`, and `phpmysqltest/`.
- `phpmysqltest/` contains the primary database examples: `classes/Db_conn.php`, `classes/PdoMethods.php`, and `classes/Crud.php`. These show the project's DB access pattern using PDO.
- `Assn3/` shows a simple form/state flow split across `index.php` and `processNames.php` where a JSON-encoded hidden field (`namelist`) is used to preserve client-side state across POSTs.
- `Assn4/index.php` expects a `Calculator.php` (not present in the repo); review references before changing requires.

## Key files to read first
- `phpmysqltest/classes/Db_conn.php` — opens a PDO connection and sets PDO attributes (important to preserve).
- `phpmysqltest/classes/PdoMethods.php` — wrapper helper that: `selectBinded`, `selectNotBinded`, `otherBinded`, `otherNotBinded`. Note the return conventions (see below).
- `phpmysqltest/classes/Crud.php` — example consumer of `PdoMethods` that returns HTML tables as strings.
- `Assn3/index.php` and `Assn3/processNames.php` — demonstrates form handling and state via a JSON hidden field and `displayNames()` formatting.
- `sql/create.sql` — schema used by the DB examples.

## Project-specific patterns and conventions (explicit rules to follow)
- Return-value conventions for DB helpers (these are literal strings used by callers):
  - Select helpers return either an associative array (records) or the string `'error'` on failure.
  - Non-select helpers (`otherBinded`/`otherNotBinded`) return `'noerror'` on success or `'error'` on failure.
  - Many callers check for `== 'error'` rather than exceptions.
- Presentation-layer functions often return complete HTML strings (see `Crud::makeTable`) instead of separating templates. When modifying, keep the same string-return approach unless you're intentionally refactoring the UI contract.
- Includes use relative paths with `require_once` (e.g., `require_once 'classes/Crud.php'` in `phpmysqltest/index.php`). Preserve relative includes or update all dependent files consistently.
- Form-state pattern: `Assn3/index.php` encodes the current state as `json_encode($output)` into a hidden input called `namelist`; `processNames.php` decodes/updates that array. Follow this pattern when adding similar form flows.

## Notable implementation details and gotchas (discovered in code)
- `PdoMethods::createBinding()` uses a `switch` without `break` statements — this causes fall-through behavior and is likely unintentional. Be careful when adding bindings.
- `PdoMethods` uses `bindParam()` with values pulled directly from arrays; `bindParam()` expects a variable reference. When adding new queries, prefer `bindValue()` or ensure binding variables are references.
- Exceptions are caught and echoed inside `PdoMethods` (the code intentionally prints exception messages). Many callers depend on `'error'` string behavior — do not remove this contract without updating all callers.
- Database credentials live in `Db_conn.php` in plaintext (example credentials are present). Do not commit production credentials and treat this file carefully.

## How to run and debug locally (developer workflow)
1. Start a simple PHP server in the target folder and open the index page in a browser. Example (from repo root):

```bash
cd phpmysqltest
php -S localhost:8000
# then visit http://localhost:8000/index.php
```

2. Database: the SQL schema is at `sql/create.sql`. Import it into a local MySQL instance and adjust `Db_conn.php` credentials to match your local user before running the DB examples.

```bash
# from repo root (prompts for password)
mysql -u nakio -p < sql/create.sql
```

3. Debugging tips
- The codebase currently echoes PDO exception messages in the catch blocks. That makes debugging visible in the browser but is not safe for production. When debugging, you can leave those echoes; when preparing a patch for production, replace them with logging or return the `'error'` sentinel.
- Use browser developer tools to inspect forms (e.g., `namelist` hidden JSON in `Assn3`).

## When making changes, preserve these contracts
- Keep the `'error'` / `'noerror'` sentinel return values for DB helpers unless you update every caller.
- Preserve the PDO attribute configuration in `Db_conn.php` (emulated prepares, buffered queries, error mode) unless you understand the impact.
- Keep relative `require_once` paths consistent.

## Good quick PR targets (low risk)
- Fix the `switch` in `PdoMethods::createBinding()` to include `break` statements or replace with `if`/`elseif` and add `bindValue()` usage.
- Add a README in `phpmysqltest/` explaining how to configure `Db_conn.php` locally and import `sql/create.sql`.

## Questions for the repo owner
- Confirm whether `Assn4/index.php` should include an existing `Calculator.php` (it is required but not present). If present elsewhere, provide path or add the missing file.
- Should DB credentials remain in `Db_conn.php` for the exercises, or do you prefer a `.env` approach?

If anything in these instructions is unclear or missing, tell me which area you want expanded (run steps, DB setup, or code patterns) and I'll update this file.
