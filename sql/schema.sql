-- SaaS foundation schema with multi-tenant support

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS invoice_line_items;
DROP TABLE IF EXISTS invoices;
DROP TABLE IF EXISTS addressbook_entries;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS tenant_settings;
DROP TABLE IF EXISTS tenant_applications;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS tenants;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE tenants (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE,
  status ENUM('active', 'inactive', 'trial') NOT NULL DEFAULT 'trial',
  plan VARCHAR(100) NOT NULL DEFAULT 'starter',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE roles (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE,
  description VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT UNSIGNED NOT NULL,
  role_id INT UNSIGNED NOT NULL,
  email VARCHAR(190) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  display_name VARCHAR(120) NOT NULL,
  status ENUM('active', 'invited', 'suspended') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_users_tenant_email (tenant_id, email),
  CONSTRAINT fk_users_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id),
  CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE applications (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  app_key VARCHAR(80) NOT NULL UNIQUE,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tenant_applications (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT UNSIGNED NOT NULL,
  application_id INT UNSIGNED NOT NULL,
  enabled TINYINT(1) NOT NULL DEFAULT 1,
  configuration JSON NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uniq_tenant_application (tenant_id, application_id),
  CONSTRAINT fk_tenant_apps_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id),
  CONSTRAINT fk_tenant_apps_app FOREIGN KEY (application_id) REFERENCES applications (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE tenant_settings (
  tenant_id INT UNSIGNED PRIMARY KEY,
  messaging_scope ENUM('tenant_only', 'all_users') NOT NULL DEFAULT 'tenant_only',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_tenant_settings_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT UNSIGNED NOT NULL,
  sender_user_id INT UNSIGNED NOT NULL,
  recipient_user_id INT UNSIGNED NULL,
  scope ENUM('tenant', 'all') NOT NULL DEFAULT 'tenant',
  subject VARCHAR(150) NOT NULL,
  body TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_messages_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id),
  CONSTRAINT fk_messages_sender FOREIGN KEY (sender_user_id) REFERENCES users (id),
  CONSTRAINT fk_messages_recipient FOREIGN KEY (recipient_user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE addressbook_entries (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT UNSIGNED NOT NULL,
  owner_user_id INT UNSIGNED NOT NULL,
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  company VARCHAR(150) NULL,
  email VARCHAR(190) NULL,
  phone VARCHAR(50) NULL,
  mobile VARCHAR(50) NULL,
  street VARCHAR(150) NULL,
  city VARCHAR(100) NULL,
  postal_code VARCHAR(20) NULL,
  country VARCHAR(100) NULL,
  notes TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_addressbook_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id),
  CONSTRAINT fk_addressbook_owner FOREIGN KEY (owner_user_id) REFERENCES users (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE invoices (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id INT UNSIGNED NOT NULL,
  period_start DATE NOT NULL,
  period_end DATE NOT NULL,
  total_amount DECIMAL(10, 2) NOT NULL,
  currency CHAR(3) NOT NULL DEFAULT 'EUR',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_invoices_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE invoice_line_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  invoice_id INT UNSIGNED NOT NULL,
  description VARCHAR(255) NOT NULL,
  quantity INT UNSIGNED NOT NULL,
  unit_price DECIMAL(10, 2) NOT NULL,
  total DECIMAL(10, 2) NOT NULL,
  CONSTRAINT fk_invoice_line_items_invoice FOREIGN KEY (invoice_id) REFERENCES invoices (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tenants (name, slug, status, plan) VALUES
  ('Alpha Consulting GmbH', 'alpha-consulting', 'active', 'business'),
  ('Beta Services AG', 'beta-services', 'trial', 'starter');

INSERT INTO roles (name, description) VALUES
  ('admin', 'Mandantenadministration und Nutzerverwaltung'),
  ('kunde', 'Mandant und Endkunde'),
  ('dienstleister', 'Serviceanbieter innerhalb des Mandanten');

INSERT INTO users (tenant_id, role_id, email, password_hash, display_name, status) VALUES
  (1, 1, 'admin@alpha-consulting.de', '$2y$10$demoDemoDemoDemoDemoDemoDemoDemoDemoDemoDemo', 'Anna Admin', 'active'),
  (1, 2, 'kunde@alpha-consulting.de', '$2y$10$demoDemoDemoDemoDemoDemoDemoDemoDemoDemoDemo', 'Klara Kunde', 'active'),
  (1, 3, 'service@alpha-consulting.de', '$2y$10$demoDemoDemoDemoDemoDemoDemoDemoDemoDemoDemo', 'Dieter Dienstleister', 'active'),
  (2, 1, 'admin@beta-services.de', '$2y$10$demoDemoDemoDemoDemoDemoDemoDemoDemoDemoDemo', 'Bernd Admin', 'active');

INSERT INTO applications (app_key, name, description) VALUES
  ('addressbook', 'Adressbuch', 'Zentrale Kontaktdaten mit Such- und Filterfunktion.'),
  ('messaging', 'Nachrichten', 'Mandanten- oder globale Kommunikation zwischen Nutzern.');

INSERT INTO tenant_applications (tenant_id, application_id, enabled, configuration) VALUES
  (1, 1, 1, JSON_OBJECT('layout', 'cards')),
  (1, 2, 1, JSON_OBJECT('allowGlobalMessaging', true)),
  (2, 1, 1, JSON_OBJECT('layout', 'table'));

INSERT INTO tenant_settings (tenant_id, messaging_scope) VALUES
  (1, 'all_users'),
  (2, 'tenant_only');

INSERT INTO messages (tenant_id, sender_user_id, recipient_user_id, scope, subject, body) VALUES
  (1, 1, NULL, 'tenant', 'Willkommen bei Alpha', 'Hier finden Sie alle aktiven Anwendungen für Ihren Mandanten.'),
  (1, 2, 3, 'tenant', 'Rückfrage', 'Bitte aktualisieren Sie die Kontaktdaten im Adressbuch.'),
  (1, 1, NULL, 'all', 'Globale Mitteilung', 'Neue App-Module stehen im Marketplace bereit.');

INSERT INTO addressbook_entries (tenant_id, owner_user_id, first_name, last_name, company, email, phone, mobile, street, city, postal_code, country, notes) VALUES
  (1, 2, 'Marie', 'Muster', 'Muster GmbH', 'marie@muster.de', '+49 30 123456', '+49 170 123456', 'Musterstraße 1', 'Berlin', '10115', 'Deutschland', 'VIP-Kontakt für Abrechnung.'),
  (1, 2, 'Jonas', 'Jung', 'JJ Logistics', 'jonas@jjlogistics.eu', '+49 40 987654', NULL, 'Hafenweg 12', 'Hamburg', '20457', 'Deutschland', 'Logistikpartner für Q2.'),
  (2, 4, 'Lena', 'Licht', 'Beta Retail', 'lena@beta-retail.de', '+49 221 222333', '+49 151 987654', 'Domplatz 3', 'Köln', '50667', 'Deutschland', 'Testkunde im Trial-Plan.');

INSERT INTO invoices (tenant_id, period_start, period_end, total_amount, currency) VALUES
  (1, '2024-12-01', '2024-12-31', 480.00, 'EUR'),
  (2, '2024-12-01', '2024-12-31', 120.00, 'EUR');

INSERT INTO invoice_line_items (invoice_id, description, quantity, unit_price, total) VALUES
  (1, 'Grundgebühr Mandant', 1, 200.00, 200.00),
  (1, 'Adressbuch App', 1, 80.00, 80.00),
  (1, 'Nutzerlizenzen (10)', 10, 20.00, 200.00),
  (2, 'Grundgebühr Mandant', 1, 80.00, 80.00),
  (2, 'Nutzerlizenzen (2)', 2, 20.00, 40.00);
