<?php
function basePath($path = "")
{
    return __DIR__ . "/" . $path;
}

function loadView($name, $data = [])
{
    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require($viewPath);
    } else {
        return "View: {$name} not found!";
    }
}

function loadPartial($name)
{
    $partialPath = basePath("App/views/partials/{$name}.php");

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

function sanitize($dirty)
{
    return filter_var($dirty, FILTER_SANITIZE_SPECIAL_CHARS);
}

function redirect($url)
{
    header("Location: {$url}");
    exit;
}

function placeholder($field)
{
    return ":{$field}";
}

function nullable($input)
{
    return $input === "" ? NULL : $input;
}
