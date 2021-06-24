<?php


namespace App\Http\Controllers\ProgramExecution;


use App\Exceptions\ProgramExecutionException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProgramExecutor
{
    /**
     * @throws ProgramExecutionException
     */
    public static function executeProgram($text, $lang_index, $ignoreWarning) {
        $methods = config("languages.languageMethods");
        $langList = config("languages.languageList");

        User::query()->find(Auth::id())->update([
            "ignore_compiler_warning"=>$ignoreWarning,
            "last_select_program_language_id" => $lang_index]);

        if(array_key_exists($lang_index, $langList) &&
            array_key_exists($langList[$lang_index], $methods)) {
            $method = $methods[$langList[$lang_index]];
            $twig_executionTime = ProgramExecutor::$method($text, $ignoreWarning);
            return $twig_executionTime;
        } else {
            throw new ProgramExecutionException(0);
        }

    }

    private static function PlainText($text, $ignoreWarning) {
        $executionTime = 0;
        return [
            "program_result" => $text,
            "execution_time" => $executionTime
        ];
    }

    private static function C($text, $ignoreWarning) {
        $executionTime = 0;
        return [
            "program_result" => $text." feat. C",
            "execution_time" => $executionTime
        ];
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
                $executionTime = 0;
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
                        return [
                            "program_result" => implode("\n", $output),
                            "execution_time" => $executionTime
                        ];
                    }
                }
            }
        } else {
            throw new ProgramExecutionException(1);
        }
    }
}
