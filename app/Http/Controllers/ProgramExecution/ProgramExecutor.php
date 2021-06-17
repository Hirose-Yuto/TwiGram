<?php


namespace App\Http\Controllers\ProgramExecution;


use App\Exceptions\ProgramExecutionException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProgramExecutor
{
    public static function executeProgram($text, $lang, $ignoreWarning) {
        $methods = config("languages.languageMethods");
        $langList = config("languages.languageList");

        User::query()->find(Auth::id())->update(["ignore_compiler_warning"=>$ignoreWarning]);

        if(array_key_exists($lang, $langList) &&
            array_key_exists($langList[$lang], $methods)) {
            $method = $methods[$langList[$lang]];
            $twig = ProgramExecutor::$method($text, $ignoreWarning);

            // ToDo:データベース追加

            //
            return $twig;
        } else {
            // ToDo:例外を投げる

            // 言語が存在しない
            $twigs = ["twig" => ["error!"]];
            return "error!";
        }

    }

    private static function PlainText($text, $ignoreWarning) {
        return $text;
    }

    private static function C($text, $ignoreWarning) {
        return $text." feat. C";
    }

    /**
     * @throws ProgramExecutionException
     */
    private static function Cpp($text, $ignoreWarning) {
        $folder = "tmp_programs/Cpp/";
        $fileName = $folder."Main.cpp";
        $text = "#include<iostream>\n".
                "#include<vector>\n".
                "using namespace std;\n\n".
                "int main(){\n".
                    $text.
                "\n}";

        // ファイル書き込み
        if (file_put_contents($fileName, $text, LOCK_EX)) {
            $output = [];
            $return_var = 1;

            //exec("g++ --version", $output, $return_var); //g++ (Homebrew GCC 10.2.0_4) 10.2.0Copyright (C) 2020 Free Software Foundation, Inc.This is free software; see the source for copying conditions. There is NOwarranty; not even for MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
            //exec("gcc --version", $output, $return_var); // Apple clang version 11.0.3 (clang-1103.0.32.29)Target: x86_64-apple-darwin19.6.0Thread model: posixInstalledDir: /Library/Developer/CommandLineTools/usr/bin

            // compile
            exec("clang++ " . $fileName . " -o ".$folder."Main.out 2>&1", $output, $return_var);

            if(!$ignoreWarning && $output) {
                throw new ProgramExecutionException(6, PHP_EOL . implode(PHP_EOL, $output));
            }

            if ($return_var) {
                // compile error
                throw new ProgramExecutionException(2, 'Output: ' . PHP_EOL . implode(PHP_EOL, $output));
            }else {
                unset($output);
                // run
                exec($folder."Main.out 1>&1", $output, $return_var);

                if($return_var) {
                    // runtime error
                    throw new ProgramExecutionException(3, 'Output: ' . PHP_EOL . implode(PHP_EOL, $output));
                } else {
                    if($output === []) {
                        // 出力なし
                        throw new ProgramExecutionException(5);
                    } else {
                        return implode("\n", $output);
                    }
                }
            }
        } else {
            throw new ProgramExecutionException(1);
        }
    }
}
