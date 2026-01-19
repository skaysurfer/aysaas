<?php

declare(strict_types=1);

require_once __DIR__ . '/../Model/FeatureModel.php';

class HomeController
{
    private FeatureModel $featureModel;

    public function __construct(?FeatureModel $featureModel = null)
    {
        $this->featureModel = $featureModel ?? new FeatureModel();
    }

    public function index(): void
    {
        $features = $this->featureModel->getLandingPageFeatures();

        $this->render('home', [
            'features' => $features,
        ]);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        require __DIR__ . '/../View/' . $view . '.php';
    }
}
