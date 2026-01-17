<?php

declare(strict_types=1);

class FeatureModel
{
    /**
     * @return string[]
     */
    public function getLandingPageFeatures(): array
    {
        return [
            'Mandantenfähigkeit mit separaten Einstellungen pro Tenant',
            'Rollenbasierter Zugriff für Admin, Kunde und Dienstleister',
            'Dashboard für die Auswahl aktivierter Applikationen',
            'Nachrichtensystem mit Mandanten- oder globalem Scope',
            'Abrechnung nach Mandant, Applikation und Nutzeranzahl',
            'Erste App: Adressbuch mit Kontaktverwaltung',
        ];
    }
}
