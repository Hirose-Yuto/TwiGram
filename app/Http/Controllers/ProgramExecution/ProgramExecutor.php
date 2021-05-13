<?php


namespace App\Http\Controllers\ProgramExecution;


class ProgramExecutor
{
    public static function executeProgram($text, $lang) {
        $methods = config("languages.languageMethods");
        $langList = config("languages.languageList");

        if(array_key_exists($lang, $langList) &&
            array_key_exists($langList[$lang], $methods)) {
            $method = $methods[$langList[$lang]];
            $twig = ProgramExecutor::$method($text);

            // ToDo:データベース追加

            // 仮に
            $twigs = ["twig" => $twig];
            return view("home", $twigs);
        } else {
            // ToDo:例外を投げる

            // 仮に
            $twigs = ["twig" => "error!"];
            return view("home", $twigs);
        }

    }

    private static function PlainText($text) {
        return $text;
    }

    private static function C($text) {
        return $text." feat. C";
    }

    private static function Cpp($text) {
        $fileName = "Main.cpp";
        return $text." feat. C++";
    }
}
