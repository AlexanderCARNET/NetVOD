<?php

namespace iutnc\deefy\dispatch;



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
    <title>Deefy</title>
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

