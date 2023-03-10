<?php
/*
 * This function redirects the user to a page.
 */

use Boolnut\Core\Router\App;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

function redirect($path)
{
    header("Location: /{$path}");
}

/*
 * This function returns the view of a page.
 */

function view($name, $data = [])
{
    extract($data);

    $path = "app/views/";
    $ext = ".nut.twig";

    $loader = new FilesystemLoader("app/views");
    $twig = new Environment($loader, [
        "debug" => true,
    ]);
    $twig->addExtension(new DebugExtension());

    if (!file_exists("$path{$name}$ext")) {
        header("HTTP/1.0 404 Not Found");
        return errorEngineView("error/404");
    } else {
        try {
            return $twig->render("{$name}$ext", $data);
        } catch (LoaderError $e) {
            App::logError(
                "There was a Twig LoaderError Exception. Details: " . $e
            );
            header("HTTP/1.0 404 Twig LoaderError");
            return errorEngineView("error/404", ["error" => $e]);
        } catch (RuntimeError $e) {
            App::logError(
                "There was a Twig RuntimeError Exception. Details: " . $e
            );
            header("HTTP/1.0 404 wig RuntimeError");
            return errorEngineView("error/404", ["error" => $e]);
        } catch (SyntaxError $e) {
            App::logError(
                "There was a Twig SyntaxError Exception. Details: " . $e
            );
            header("HTTP/1.0 404 Twig SyntaxError");
            return errorEngineView("error/404", ["error" => $e]);
        }
    }
}

/*
 * This function returns the view of a page.
 */
function errorEngineView($name, $data = ["error" => "error"])
{
    extract($data);
    return require "./core/inc/engine/template.data";
}

/*
 * This function is used for dying and dumping.
 */
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}
