<?php


namespace App\Http\Controllers\ProgramExecution;


use App\Exceptions\ProgramExecutionException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProgramExecutor
{
    /**
     * プログラムを実行
     * @param string $text
     * @param int $lang_index
     * @param bool $ignoreWarning
     * @return mixed program_result & execution_time
     * @throws ProgramExecutionException
     */
    public static function executeProgram(string $text, int $lang_index, bool $ignoreWarning) {
        $methods = config("languages.languageMethods");
        $langList = config("languages.languageList");

        User::query()->find(Auth::id())->update([
            "ignore_compiler_warning"=>$ignoreWarning,
            "last_select_program_language_id" => $lang_index]);

        if(array_key_exists($lang_index, $langList) &&
            array_key_exists($langList[$lang_index], $methods)) {
            $method = $methods[$langList[$lang_index]];
            if($method == "PlainText") {return ["program_result"=>$text, "execution_time"=>0];}
            // コンテナ作成
            $container_name = self::generateContainerName();
            exec('/usr/local/bin/docker run -d --privileged --name '.$container_name.' '.config("languages.imageNames")[$langList[$lang_index]].' /sbin/init' , $output, $return_var);
            try {
                $twig_executionTime = ProgramExecutor::$method($text, $ignoreWarning, $container_name);
            }finally {
                echo "finally ".$container_name;
                // コンテナ削除
                exec('/usr/local/bin/docker stop '.$container_name.' && /usr/local/bin/docker rm '.$container_name." > /dev/null &");
            }

            return $twig_executionTime;
        } else {
            throw new ProgramExecutionException(0);
        }

    }

    /**
     * プレーンテキスト(そのまま)
     * @param string $text
     * @param bool $ignoreWarning
     * @return array
     */
    private static function PlainText(string $text, bool $ignoreWarning) {
        $executionTime = 0;
        return [
            "program_result" => $text,
            "execution_time" => $executionTime
        ];
    }

    /**
     * C言語実行
     * @param string $text
     * @param bool $ignoreWarning
     * @param string
     * @return array
     */
    private static function C(string $text, bool $ignoreWarning, string $containerName) {
        $executionTime = 0;
        return [
            "program_result" => $text." feat. C",
            "execution_time" => $executionTime
        ];
    }

    /**
     * C++実行(clang++)
     * @param string $text
     * @param bool $ignoreWarning
     * @param string $containerName
     * @return array
     * @throws ProgramExecutionException
     */
    private static function Cpp(string $text, bool $ignoreWarning, string $containerName) {
        $folder = "tmp_programs/Cpp/";
        $fileName = $folder."Main.cpp";
        $text = "#include<iostream>\n".
                "#include<vector>\n".
                "using namespace std;\n\n".
                "int main(){\n".
                    $text.
                "\n}";

        $output = [];
        $return_var = 1;

        // ファイル書き込み
        exec('/usr/local/bin/docker exec -it '.$containerName.' /bin/bash -c " cd '.config("languages.directory")["C++"].' && echo -e '.$text.' > Main.cpp"', $output, $return_var);
        if (!$return_var) {
            // 初期化
            unset($output);

            $executionTime = 0;

            //exec("g++ --version", $output, $return_var); //g++ (Homebrew GCC 10.2.0_4) 10.2.0Copyright (C) 2020 Free Software Foundation, Inc.This is free software; see the source for copying conditions. There is NOwarranty; not even for MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
            //exec("gcc --version", $output, $return_var); // Apple clang version 11.0.3 (clang-1103.0.32.29)Target: x86_64-apple-darwin19.6.0Thread model: posixInstalledDir: /Library/Developer/CommandLineTools/usr/bin

            // compile
            $command = "g++ " . $fileName . " -o ".$folder."Main.out 2>&1";
            exec('/usr/local/bin/docker exec -it '.$containerName.' /bin/bash -c " cd '.config("languages.directory")["C++"].' && '.$command.'"', $output, $return_var);

            if(!$ignoreWarning && $output) {
                // warning
                throw new ProgramExecutionException(6, PHP_EOL . implode(PHP_EOL, $output));
            }
            if ($return_var) {
                // compile error
                throw new ProgramExecutionException(2, 'Output: ' . PHP_EOL . implode(PHP_EOL, $output));
            }

            // 初期化
            unset($output);

            // run
            $command = $folder."Main.out 1>&1";
            exec('/usr/local/bin/docker exec -it '.$containerName.' /bin/bash -c " cd '.config("languages.directory")["C++"].' && '.$command.'"', $output, $return_var);

            if($return_var) {
                // runtime error
                throw new ProgramExecutionException(3, 'Output: ' . PHP_EOL . implode(PHP_EOL, $output));
            }

            if($output === []) {
                // 出力なし
                throw new ProgramExecutionException(5);
            }

            return [
                "program_result" => implode("\n", $output),
                "execution_time" => $executionTime
            ];

        } else {
            throw new ProgramExecutionException(1);
        }
    }

    private static function generateContainerName(): string {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 8);
    }
}
