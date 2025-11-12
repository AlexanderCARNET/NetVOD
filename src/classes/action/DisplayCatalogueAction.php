<?php
namespace iutnc\netvod\action;

use iutnc\netvod\renderer\SerieRender;
use iutnc\netvod\repository\Repository;

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

   $html = '<h1>Catalogue</h1><div class="catalogue">';
foreach ($series_total as $serie) {
    $renderer = new SerieRender($serie);
    $html .= $renderer->render(Renderer::COMPACT);
}
$html .= '</div>';


        return $html;
    }
}
