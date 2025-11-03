<?php

namespace iutnc\netvod\dispatch;

use iutnc\netvod\action\Action_noter;


class Dispatcher
{

    private string $action;

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void
    {
        $html = '';

        switch ($this->action) {
           default:
               $avis = new Action_noter();
               $html = $avis->execute();



        }

        $this->renderPage($html);
    }

private function renderPage(string $html): void
{
   
    $fullPage = <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" />
    <title>netvod</title>
</head>

<body>

$html

</body>
</html>
HTML;

    echo $fullPage;
}
}
?>

