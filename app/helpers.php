<?php

function translate($object, $property)
{
    $locale = App::getLocale();
    $property = $property . '_' . $locale;
    return $object->$property;
}

function getCurrentGitCommitHash()
{
    $path = base_path('.git/');
    if (!file_exists($path)) return null;
    $head = trim(substr(file_get_contents($path . 'HEAD'), 4));
    return env('APP_ENV') == 'local' ? time() : trim(file_get_contents($path . $head)) ?? time();
}

function getShortText($object, $property, $length): string
{
    $translatedText = translate($object, $property);

    if (strlen($translatedText) > $length) {
        $text = substr($translatedText, 0, $length) . "...";
    } else {
        $text = $translatedText;
    }

    return $text;
}
