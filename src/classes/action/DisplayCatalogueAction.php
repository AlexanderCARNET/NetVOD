<?php
namespace iutnc\netvod\action;

use iutnc\netvod\render\SerieRender;
use iutnc\netvod\repository\Repository;
use iutnc\netvod\render\Renderer;

class DisplayCatalogueAction extends Action
{
    public function execute(): string
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?action=signin');
            exit();
        }

        $repo = Repository::getInstance();
        $series_total = $repo->getAllSeriesCompact();

        $html = '<h1>Catalogue</h1>';

        foreach ($series_total as $serie) {
            $renderer = new SerieRender($serie);
            $html .= $renderer->render(Renderer::COMPACT);
        }

        return $html;
    }
}
