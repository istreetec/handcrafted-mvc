<?php
declare(strict_types=1);
namespace App;

use App\Exceptions\ViewNotFoundException;

class View
{
    public function __construct(
        protected string $view,
        protected array $params = []
    )
    {
    }

    public static function make(string $view, array $params = []): static
    {
        // Returning a newed instance means make() can be chained to invoke 
        // other methods, e.g. render(), within the class it was created 
        // i.e. View
        return new static($view, $params);
    }

    public function render(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        // Turn on output buffering, by first storing include's value into a 
        // buffer then returning contents of the buffer
        ob_start();

        // NB:: anything between ob_start() and ob_get_clean() is buffered.
        // Include a file containing HTML Markup
        include $viewPath;

        // Now return the buffer's content as string
        return (string) ob_get_clean();
    }

    // use __toString() to have View class invoke something on our behalf
    // after it's instance being type casted to string.
    public function __toString(): string
    {
        echo "Invoked by View Instance" . "<br/>";
        return $this->render();
    }
}
