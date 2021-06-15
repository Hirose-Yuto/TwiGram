<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProgramExecutionException extends Exception
{
    private $exceptionId_Message = [
        0 => "The language doesn't exist.",
        1 => "Internal error happened",
        2 => "Compile error happened",
        3 => "Runtime error happened",
        4 => "Time limit exceeded.",
        5 => "Output is null.",
        ];

    public $exceptionId;
    public $exceptionMessage;
    public $customMessage;

    public function __construct($exceptionId, $customMessage)
    {
        if(array_key_exists($exceptionId, $this->exceptionId_Message)) {
            $this->exceptionId = $exceptionId;
            $this->exceptionMessage = $this->exceptionId_Message[$exceptionId];
        } else {
            $this->exceptionId = 1;
            $this->exceptionMessage = $this->exceptionId_Message[1];
        }
        $this->customMessage = $customMessage;
    }

    public function report() {
        Log::info($this->exceptionMessage." ", $this->customMessage);
    }
}
