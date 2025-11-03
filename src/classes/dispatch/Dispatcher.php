<?php

namespace iutnc\netvod\dispatch;

use iutnc\netvod\action\Action;

use iutnc\netvod\action\SigninAction;



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

            case 'signin':
                $action = new SigninAction();
                $html = $action->execute();
                break;
           



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

