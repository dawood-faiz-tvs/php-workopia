<?php
function basePath($path = "")
{
    return __DIR__ . "/" . $path;
}

function loadView($name, $data = [])
{
    $viewPath = basePath("views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require($viewPath);
    } else {
        return "View: {$name} not found!";
    }
}

function loadPartial($name)
{
    $partialPath = basePath("views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        require($partialPath);
    } else {
        return "Partial: {$name} not found!";
    }
}

function d($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function formatSalary($salary)
{
    return '$' . number_format(floatval($salary));
}
